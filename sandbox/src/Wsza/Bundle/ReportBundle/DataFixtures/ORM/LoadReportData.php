<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 12.11.14
 * Time: 15:59
 */

namespace Wsza\Bundle\ReportBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Wsza\Bundle\ReportBundle\Entity\Client;
use Wsza\Bundle\ReportBundle\Entity\Connection;
use Wsza\Bundle\ReportBundle\Entity\Subscriber;
use Wsza\Bundle\ReportBundle\Entity\Tariff;

class LoadReportData extends AbstractFixture implements ContainerAwareInterface
{
    private $container;
    /** @var  ObjectManager */
    private $manager;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        srand(2340);
        $orange = $this->createCient("Orange Polska S.A.", "orange", '526-025-09-95', 'Aleje Jerozolimskie 160', '02-236 Warszawa', 'ul. Jagiellońska 34', '96-100 Skierniewice', 13);
        $mm = $this->createCient("Multimedia Polska", "mm", '354-034-19-33', 'Waszyngtona 33/60', '81-435 Gdynia', 'ul. Jana z Kolna 3/1', '81-436 Gdynia', 15);

        //
        $this->currentClient = $orange;
        $normalOrange = $this->createTariff("Taryfa normalna", 'seconds', 0.20);
        $playOrange = $this->createTariff("Taryfa do Play", 'seconds', 0.80);
        $specialOrange = $this->createTariff("Taryfa specjalna", 'single', 5.00);
        $adam = $this->createSubscriber("Adam", 'Borowski', '503993723', 'Władysława IV 23/41', '81-358 Gdynia');
        $jan = $this->createSubscriber("Jan", 'Nowak', '804784004', 'Rynek 15', '81-333 Wejherowo');
        //
        $this->currentClient = $mm;
        $normalMm = $this->createTariff("Taryfa normalna", 'seconds', 0.15);
        $dzidzia = $this->createSubscriber("Zdzisawa", "Czerwińska", "453-535-235", "Wielkopolska 3", "89-322 Wołczynki");
        //

        $this->createConnections($adam, new \DateTime('2014-08-10'), new \DateTime('2014-10-09'));
        $this->createConnections($jan, new \DateTime('2014-08-14'), new \DateTime('2014-10-13'));
        $this->createConnections($dzidzia, new \DateTime('2014-08-15'), new \DateTime('2014-10-14'));
        $this->manager->flush();
    }

    /**
     * @var Client
     */
    protected $currentClient;

    protected function createConnections($subscriber, \DateTime $start, \DateTime $end)
    {
        $tariffs = $subscriber->getClient()->getTariffs();
        $countMinus1 = $tariffs->count() - 1;
        for ($date = $start; $date <= $end;) {

            //
            $connection = new Connection();
            $this->manager->persist($connection);
            $connection->setSubscriber($subscriber);
            $connection->setStartTime(clone $date);
            $seconds = rand(40, 700);
            $date->add(new \DateInterval("PT${seconds}S"));
            $connection->setEndTime(clone $date);
            $connection->setTariff($tariffs[rand(0, $countMinus1)]);
            $connection->setNumber(rand(501404505, 890800200));
            //
            $seconds = rand(400, 36000);
            $date->add(new \DateInterval("PT${seconds}S"));

        }
    }

    protected function createTariff($name, $type, $price)
    {
        $tariff = new Tariff();
        $tariff->setClient($this->currentClient);
        $tariff->setCountingMethod($type);
        $tariff->setName($name);
        $tariff->setPrice($price);
        $this->manager->persist($tariff);
        $this->currentClient->getTariffs()->add($tariff);
        return $tariff;
    }


    protected function createSubscriber($firstName, $lastName, $phoneNumber, $address1, $address2)
    {
        $subscriber = new Subscriber();
        $subscriber->setFirstName($firstName);
        $subscriber->setLastName($lastName);
        $subscriber->setNumber($phoneNumber);
        $subscriber->setBankAccountNumber(null);
        $subscriber->setAccountingPeriodStart(rand(1, 28));
        $subscriber->setAddress1($address1);
        $subscriber->setAddress2($address2);
        $subscriber->setClient($this->currentClient);
        $subscriber->setId(rand(10000, 19999));
        $this->manager->persist($subscriber);
        $this->currentClient->getSubscribers()->add($subscriber);
        return $subscriber;
    }

    protected function createCient($name, $login, $nip, $address1, $address2, $address3, $address4, $paymentDelay)
    {
        $client = new Client();
        $client->setName($name);
        $client->setLogin($login);
        $client->setPassword(hash('sha256', $login));
        $client->setNip($nip);
        $client->setAddress1($address1);
        $client->setAddress2($address2);
        $client->setCorrespondenceAddress1($address3);
        $client->setCorrespondenceAddress2($address4);
        $client->setCorrespondenceName($name);
        $client->setCorrespondencePhoneNumber('503-235-235');
        $client->setBillingUrl("/api/fake/billing");
        $client->setPostReportUrl("/api/fake/post_report");
        $client->setSubscriberUrl("/api/fake/subscribers");
        $client->setBankAccountNumber('62445831273296664050574135');
        $client->setPaymentDelay($paymentDelay);
        $this->manager->persist($client);
        return $client;
    }
}