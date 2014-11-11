<?php
namespace Wsza\Bundle\ReportBundle\Entity;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Report
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="datetime")
     * czas zgłoszenia wygenerowania PDF
     */
    protected $requestTime;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * czas wygenerowania PDF
     */
    protected $completeTime;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $reportTime;
    /**
     * @ORM\ManyToOne(targetEntity="Subscriber", inversedBy="reports")
     * @JMS\Type("Wsza\Bundle\ReportBundle\Serializer\ForeignKeyType")
     */
    protected $subscriber;

    /**
     * @return mixed
     */
    public function getRequestTime()
    {
        return $this->requestTime;
    }

    /**
     * @param mixed $requestTime
     */
    public function setRequestTime($requestTime)
    {
        $this->requestTime = $requestTime;
    }

    /**
     * @return mixed
     */
    public function getCompleteTime()
    {
        return $this->completeTime;
    }

    /**
     * @param mixed $completeTime
     */
    public function setCompleteTime($completeTime)
    {
        $this->completeTime = $completeTime;
    }

    /**
     * @return mixed
     */
    public function getReportTime()
    {
        return $this->reportTime;
    }

    /**
     * @param mixed $reportTime
     */
    public function setReportTime($reportTime)
    {
        $this->reportTime = $reportTime;
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
    public function getId()
    {
        return $this->id;
    }

}