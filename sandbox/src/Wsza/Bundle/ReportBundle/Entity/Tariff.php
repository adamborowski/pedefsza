<?php
namespace Sonata\Bundle\DemoBundle\Entity;

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
     */
    protected $client;
    /**
     * @ORM\OneToMany(targetEntity="Connection", mappedBy="tariff")
     */
    protected $connections;

    function __construct()
    {
        $this->connections = new ArrayCollection();
    }


}