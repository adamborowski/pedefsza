<?php
namespace Wsza\Bundle\ReportBundle\Entity;

use JMS\Serializer\Annotation\Exclude;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Tariff
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
    protected $name;
    /**
     * @ORM\Column(type="string", length=100)
     * np naliczanie sekundowe | od połączenia | za każdą rozpoczętą minutę
     */
    protected $countingMethod;
    /**
     * @ORM\Column(type="decimal", precision=4, scale=2)
     * cena np za sekundę, za rozpoczętą minutę, za połączenie
     */
    protected $price;
    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="tariffs")
     * @Exclude
     */
    protected $client;
    /**
     * @ORM\OneToMany(targetEntity="Connection", mappedBy="tariff")
     * @Exclude
     */
    protected $connections;

    function __construct()
    {
        $this->connections = new ArrayCollection();
    }


}