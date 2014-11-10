<?php
namespace Wsza\Bundle\ReportBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Connection
{
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
     * @Exclude
     */
    protected $subscriber;
    /**
     * @ORM\ManyToOne(targetEntity="Tariff", inversedBy="connections")
     * @Exclude
     */
    protected $tariff;

}