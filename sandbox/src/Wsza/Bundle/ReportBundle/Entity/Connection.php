<?php
namespace Wsza\Bundle\ReportBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation as JMS;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Connection
{
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $number;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $startTime;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $endTime;
    /**
     * @ORM\ManyToOne(targetEntity="Subscriber", inversedBy="connections")
     * @JMS\Type("Wsza\Bundle\ReportBundle\Serializer\ForeignKeyType")
     */
    protected $subscriber;
    /**
     * @ORM\ManyToOne(targetEntity="Tariff", inversedBy="connections")
     * @JMS\Type("Wsza\Bundle\ReportBundle\Serializer\ForeignKeyType")
     */
    protected $tariff;

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
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param mixed $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * @return mixed
     */
    public function getSubscriber()
    {
        return $this->subscriber;
    }

    /**
     * @param mixed $subscriber
     */
    public function setSubscriber($subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * @return mixed
     */
    public function getTariff()
    {
        return $this->tariff;
    }

    /**
     * @param mixed $tariff
     */
    public function setTariff($tariff)
    {
        $this->tariff = $tariff;
    }

}