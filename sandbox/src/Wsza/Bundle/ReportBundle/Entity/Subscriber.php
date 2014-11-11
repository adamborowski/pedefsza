<?php
namespace Wsza\Bundle\ReportBundle\Entity;

use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Subscriber
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $number;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $firstName;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $lastName;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $address1;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $address2;
    /**
     * @ORM\Column(type="integer")
     * np liczba 23 oznacza że okres rozpoczyna się 23 dnia każdego miesiąca
     */
    protected $accountingPeriodStart;
    /**
     * @ORM\OneToMany(targetEntity="Report", cascade={"persist", "remove"}, mappedBy="subscriber")
     * @Assert\Valid
     * @JMS\Exclude
     */
    protected $reports;
    /**
     * @ORM\OneToMany(targetEntity="Connection", cascade={"persist", "remove"}, mappedBy="subscriber")
     * @Assert\Valid
     * @JMS\Exclude
     */
    protected $connections;
    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="subscribers")
     * @JMS\Type("Wsza\Bundle\ReportBundle\Serializer\ForeignKeyType")
     * @Assert\Valid
     */
    protected $client;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $bankAccountNumber;

    public function __construct()
    {
        $this->reports = new ArrayCollection();
        $this->connections = new ArrayCollection();
    }

    public function lookupBankAccountNumber(){
        if( $this->bankAccountNumber==null)
        {
            return $this->getClient()->getBankAccountNumber();
        }
        return $this->bankAccountNumber;
    }

    /**
     * @return \Wsza\Bundle\ReportBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
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
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
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
    public function getAccountingPeriodStart()
    {
        return $this->accountingPeriodStart;
    }

    /**
     * @param mixed $accountingPeriodStart
     */
    public function setAccountingPeriodStart($accountingPeriodStart)
    {
        $this->accountingPeriodStart = $accountingPeriodStart;
    }

    /**
     * @return mixed
     */
    public function getReports()
    {
        return $this->reports;
    }

    /**
     * @param mixed $reports
     */
    public function setReports($reports)
    {
        $this->reports = $reports;
    }

    /**
     * @return mixed
     */
    public function getConnections()
    {
        return $this->connections;
    }

    /**
     * @param mixed $connections
     */
    public function setConnections($connections)
    {
        $this->connections = $connections;
    }
}