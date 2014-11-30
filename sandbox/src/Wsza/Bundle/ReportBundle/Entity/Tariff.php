<?php
namespace Wsza\Bundle\ReportBundle\Entity;

use JMS\Serializer\Annotation as JMS;
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
     * @return mixed
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * @param mixed $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }
    /**
     * @ORM\Column(type="decimal", precision=2, scale=2)
     * vat
     */
    protected $vat;
    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="tariffs")
     * @JMS\Type("Wsza\Bundle\ReportBundle\Serializer\ForeignKeyType")
     */
    protected $client;
    /**
     * @ORM\OneToMany(targetEntity="Connection", mappedBy="tariff")
     * @JMS\Exclude
     */
    protected $connections;

    function __construct()
    {
        $this->connections = new ArrayCollection();
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCountingMethod()
    {
        return $this->countingMethod;
    }

    /**
     * @param mixed $countingMethod
     */
    public function setCountingMethod($countingMethod)
    {
        $this->countingMethod = $countingMethod;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
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

    public function countCosts($numConnections, $numSeconds)
    {
        $numMinutes = floor($numSeconds / 60);
        switch ($this->getCountingMethod()) {
            case "seconds":
                return array(
                    'factor' => $numMinutes,
                    'unit' => 'min.',
                    'costs' => $numSeconds / 60 * $this->getPrice()
                );
                break;
            case "minutes":
                return array(
                    'factor' => $numMinutes,
                    'unit' => 'min.',
                    'costs' => $numMinutes * $this->getPrice()
                );
                break;
            case "single":
                return array(
                    'factor' => $numConnections,
                    'unit' => 'połączeń',
                    'costs' => $numConnections * $this->getPrice()
                );
                break;
        }
        return null;
    }


}