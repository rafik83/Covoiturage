<?php

namespace Covoiturage\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gouvernorat
 *
 * @ORM\Entity
 */
class Gouvernorat extends Localite
{

    private $numGouv;

    public function __construct($type = "gouvernorat")
    {
        $this->setType($type);
    }

    /**
     * @return mixed
     */
    public function getNumGouv()
    {
        return $this->numGouv;
    }

    /**
     * @param mixed $numGouv
     */
    public function setNumGouv($numGouv)
    {
        $this->numGouv = $numGouv;
    }

}