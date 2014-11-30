<?php

namespace Wsza\Bundle\GenBundle\Controller;

use Doctrine\ORM\EntityManager;
use Lsw\ApiCallerBundle\Call\HttpGetHtml;
use Lsw\ApiCallerBundle\Call\HttpGetJson;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Wsza\Bundle\ReportBundle\Entity\Client;
use Wsza\Bundle\ReportBundle\Entity\Connection;
use Wsza\Bundle\ReportBundle\Entity\Report;
use Wsza\Bundle\ReportBundle\Entity\Subscriber;
use Wsza\Bundle\ReportBundle\Entity\Tariff;

class DefaultController extends Controller
{
    private $wszaUrl = ':8000/init/fvat/';
    private $reqHost;

    private function getURL($part)
    {
        return 'http://' . $this->reqHost . $this->wszaUrl . $part;
    }

    private function lookupTariffs($client)
    {
        $caller = $this->get('api_caller');
        $url = $this->getURL("tariffs");
        $request = $caller->call(new HttpGetJson($url, Request::create($url)));

        foreach ($request->data as $t) {
            $tariff = new Tariff();
            $tariff->setIdOnClient($t->id);
            $tariff->setClient($client);
            $client->getTariffs()->add($tariff);
            $tariff->setName($t->name);
            $tariff->setCountingMethod($t->counting_method);
            $tariff->setVat($t->vat);
            $tariff->setPrice($t->price);
            //
            $this->getDoctrine()->getManager()->persist($tariff);
        }
        $this->getDoctrine()->getManager()->flush();
    }

    private function lookupConnections($subscriber, $client, \DateTime $start, \DateTime $end)
    {
        $em = $this->getDoctrine()->getManager();
        $caller = $this->get('api_caller');
        $id = $client->getId();

        //
        $startTs = $start->format('U');
        $endTs = $end->format('U');
        //
        $url = $this->getURL("subscriber/$id/connections/$startTs/$endTs");
        $request = $caller->call(new HttpGetJson($url, Request::create($url)));
        foreach ($request->data as $c) {
            $con = new Connection();
            $con->setStartTime(new \DateTime($c->start_time));
            $con->setEndTime(new \DateTime($c->end_time));
            $con->setTariff($em->getRepository('ReportBundle:Tariff')->findOneBy(array('idOnClient' => $c->tariff)));
            $con->setNumber($c->number);
            $con->setSubscriber($subscriber);
            $con->setId($c->id);
            $em->persist($con);
        }
        $em->flush();

    }

    private function lookupSubscriber($id, $client)
    {
        $caller = $this->get('api_caller');
        //
        $url = $this->getURL("subscriber/$id");
        $request = $caller->call(new HttpGetJson($url, Request::create($url)));
        $d = $request->data;
        $sub = new Subscriber();
        $sub->setId($d->id);
        $sub->setClient($client);
        $sub->setFirstName($d->first_name);
        $sub->setLastName($d->last_name);
        $sub->setAddress1($d->address1);
        $sub->setAddress2($d->address2);
        $sub->setNumber($d->number);
        $sub->setAccountingPeriodStart($d->accounting_period_start);
        $this->getDoctrine()->getManager()->persist($sub);
        return $sub;
    }

    public function generateAction(Request $request, $subscriberId, $validDate)
    {

        $this->reqHost = $request->getClientIp();
        $client = explode(':', base64_decode(substr($request->headers->get('authorization'), 6)));

        if (count($client) < 2 || $client == "") {
            //tryb debug nie wymaga uwirzeytelnienia
            $client = array('wsza', 'wsza');
        }
        $em = $this->getDoctrine()->getManager();

        $user = $client[0];
        $pass = $client[1];

        $clientEntity = $em->getRepository('ReportBundle:Client')->findOneBy(array('login' => $user));
        if ($clientEntity == null) {
            return new Response('nie ma takiego klienta', 403);
        }
        if ($clientEntity->canLogin($pass) == false) {
            return new Response('złe hasło', 403);
        }

        /** @var Client $clientEntity */
        if ($clientEntity->getTariffs()->count() == 0) {
            $this->lookupTariffs($clientEntity);
        }


        /**
         * @var $em EntityManager
         */
        $em = $this->getDoctrine()->getManager();
        /** @var Subscriber $subscriber */
        $subscriber = $em->getRepository('ReportBundle:Subscriber')->find($subscriberId);
        if ($subscriber == null) {
            $subscriber = $this->lookupSubscriber($subscriberId, $clientEntity);
        }
        $startTime = $this->prepareStartTime($subscriber, new \DateTime($validDate));
        $endTime = clone $startTime;
        $endTime->modify('+1 month');
        $paymentTime = clone $endTime;
        $delay = $subscriber->getClient()->getPaymentDelay();
        $paymentTime->modify("+${delay}day");
        $tariffs = $subscriber->getClient()->getTariffs();
        $sumQuery = $em->createQuery("
SELECT count(c) , sum(c.endTime-c.startTime) FROM ReportBundle:Connection c
 WHERE c.subscriber = :subscriber
 AND c.tariff=:tariff
 AND c.startTime >= :startTime
 AND c.endTime < :endTime
 ");
        $sumQuery->setParameter("subscriber", $subscriber);
        $sumQuery->setParameter("startTime", $startTime);
        $sumQuery->setParameter("endTime", $endTime);

        /** @var Tariff $tariff */
        $costArray = array();
        $sumNetto = 0;
        $sumBrutto = 0;
        $sumVat = 0;
        foreach ($tariffs as $tariff) {
            $sumQuery->setParameter("tariff", $tariff);

            $ret = $sumQuery->getSingleResult();
            if ($ret[1] == 0) {
                //nie mamy żadnych połączeń, lepiej sprawdź w systemie wsza
                $this->lookupConnections($subscriber, $clientEntity, $startTime, $endTime);
                $ret = $sumQuery->getSingleResult();
            }
            $costs = $tariff->countCosts($ret[1], $ret[2]);
            $costs['tariff'] = $tariff;
            $costs['vat'] = $tariff->getVat();
            $costs['vatCosts'] = $costs['costs'] * $costs['vat'];
            $costs['brutto'] = $costs['costs'] + $costs['vatCosts'];
            $costArray[] = $costs;
            $sumNetto += $costs['costs'];
            $sumBrutto += $costs['brutto'];
            $sumVat += $costs['vatCosts'];
        }

        $report = new Report();
        $report->setSubscriber($subscriber);
        $report->setRequestTime(new \DateTime());
        $report->setReportTime($startTime);
        $em->persist($report);


//        /** @var Barcode $barcode */
//        $barcode = $this->container->get('hackzilla_barcode');
//        $barcode->setMode(Barcode::MODE_PNG);
//        $barImage = $barcode->outputHtml("12.234.25.33");

        $em->flush();
        $parameters = array(
            'subscriber' => $subscriber,
            'costs' => $costArray,
            'startTime' => $startTime,
            'endTime' => $endTime->modify('-1 day'),
            'paymentTime' => $paymentTime,
            'client' => $subscriber->getClient(),
            'report' => $report,
            'sumBrutto' => $sumBrutto,
            'sumNetto' => $sumNetto,
            'sumVat' => $sumVat,
//            'barImage'=>$barImage
        );

        if ($request->getRequestFormat() == 'html') {
            return $this->render('GenBundle:Default:index.html.twig', $parameters);
        }
        $html = $this->renderView('GenBundle:Default:index.html.twig', $parameters);
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
//                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );

    }

    private function prepareStartTime(Subscriber $subscriber, \DateTime $startTime)
    {
        $startTime = clone $startTime;
        $startTime->setDate($startTime->format('Y'), $startTime->format('m'), $subscriber->getAccountingPeriodStart());
        return $startTime;
    }

}
