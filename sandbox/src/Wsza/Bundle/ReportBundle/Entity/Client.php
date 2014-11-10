<?php
namespace Sonata\Bundle\DemoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     * np Orange Polska SA
     */
    protected $name;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $address1;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $address2;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $correspondenceName;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $correspondenceAddress1;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $correspondenceAddress2;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $correspondencePhoneNumber;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $nip;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $bankAccountNumber;
    /**
     * @ORM\Column(type="integer", options={"default":15})
     * ilość dni opóźnienia zapłaty dla klienta
     */
    protected $paymentDelay;
    /**
     * @ORM\Column(type="string", length=2048)
     */
    protected $subscriberUrl;
    /**
     * @ORM\Column(type="string", length=2048)
     */
    protected $billingUrl;
    /**
     * @ORM\Column(type="string", length=2048)
     */
    protected $postReportUrl;
    /**
     * @ORM\OneToMany(targetEntity="Subscriber", cascade={"persist", "remove"}, mappedBy="client")
     * @Assert\Valid
     */
    protected $subscribers;
    /**
     * @ORM\OneToMany(targetEntity="Tariff", cascade={"persist", "remove"}, mappedBy="client")
     * @Assert\Valid
     */
    protected $tariffs;

    public function __construct()
    {
        $this->subscribers = new ArrayCollection();
        $this->tariffs = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCorrespondencePhoneNumber()
    {
        return $this->correspondencePhoneNumber;
    }

    /**
     * @param mixed $correspondencePhoneNumber
     */
    public function setCorrespondencePhoneNumber($correspondencePhoneNumber)
    {
        $this->correspondencePhoneNumber = $correspondencePhoneNumber;
    }

    /**
     * @return mixed
     */
    public function getTariffs()
    {
        return $this->tariffs;
    }

    /**
     * @param mixed $tariffs
     */
    public function setTariffs($tariffs)
    {
        $this->tariffs = $tariffs;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param mixed $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param mixed $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * @return mixed
     */
    public function getCorrespondenceName()
    {
        return $this->correspondenceName;
    }

    /**
     * @param mixed $correspondenceName
     */
    public function setCorrespondenceName($correspondenceName)
    {
        $this->correspondenceName = $correspondenceName;
    }

    /**
     * @return mixed
     */
    public function getCorrespondenceAddress1()
    {
        return $this->correspondenceAddress1;
    }

    /**
     * @param mixed $correspondenceAddress1
     */
    public function setCorrespondenceAddress1($correspondenceAddress1)
    {
        $this->correspondenceAddress1 = $correspondenceAddress1;
    }

    /**
     * @return mixed
     */
    public function getCorrespondenceAddress2()
    {
        return $this->correspondenceAddress2;
    }

    /**
     * @param mixed $correspondenceAddress2
     */
    public function setCorrespondenceAddress2($correspondenceAddress2)
    {
        $this->correspondenceAddress2 = $correspondenceAddress2;
    }

    /**
     * @return mixed
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * @param mixed $nip
     */
    public function setNip($nip)
    {
        $this->nip = $nip;
    }

    /**
     * @return mixed
     */
    public function getBankAccountNumber()
    {
        return $this->bankAccountNumber;
    }

    /**
     * @param mixed $bankAccountNumber
     */
    public function setBankAccountNumber($bankAccountNumber)
    {
        $this->bankAccountNumber = $bankAccountNumber;
    }

    /**
     * @return mixed
     */
    public function getPaymentDelay()
    {
        return $this->paymentDelay;
    }

    /**
     * @param mixed $paymentDelay
     */
    public function setPaymentDelay($paymentDelay)
    {
        $this->paymentDelay = $paymentDelay;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSubscriberUrl()
    {
        return $this->subscriberUrl;
    }

    /**
     * @param mixed $subscriberUrl
     */
    public function setSubscriberUrl($subscriberUrl)
    {
        $this->subscriberUrl = $subscriberUrl;
    }

    /**
     * @return mixed
     */
    public function getBillingUrl()
    {
        return $this->billingUrl;
    }

    /**
     * @param mixed $billingUrl
     */
    public function setBillingUrl($billingUrl)
    {
        $this->billingUrl = $billingUrl;
    }

    /**
     * @return mixed
     */
    public function getPostReportUrl()
    {
        return $this->postReportUrl;
    }

    /**
     * @param mixed $postReportUrl
     */
    public function setPostReportUrl($postReportUrl)
    {
        $this->postReportUrl = $postReportUrl;
    }

    /**
     * @return mixed
     */
    public function getSubscribers()
    {
        return $this->subscribers;
    }

    /**
     * @param mixed $subscribers
     */
    public function setSubscribers($subscribers)
    {
        $this->subscribers = $subscribers;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}