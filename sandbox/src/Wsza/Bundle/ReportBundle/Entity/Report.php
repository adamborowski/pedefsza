<?php
namespace Sonata\Bundle\DemoBundle\Entity;

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
     * @ORM\Column(type="string", length=100)
     */
    protected $number;
    /**
     * @ORM\Column(type="datetime")
     * czas zgłoszenia wygenerowania PDF
     */
    protected $requestTime;
    /**
     * @ORM\Column(type="datetime")
     * czas wygenerowania PDF
     */
    protected $completeTime;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $reportTime;
    /**
     * @ORM\ManyToOne(targetEntity="Subscriber", inversedBy="reports")
     */
    protected $subscriber;

}