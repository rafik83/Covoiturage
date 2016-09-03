<?php

namespace Covoiturage\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Voiture
 *
 * @ORM\Table(name="voiture")
 * @ORM\Entity
 */
class Voiture
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=100, nullable=false)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=500, nullable=true)
     */
    private $photo;

    /**
     * @var \Personne
     *
     * @ORM\ManyToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_personne", referencedColumnName="id")
     * })
     */
    private $idPersonne;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set marque
     *
     * @param string $marque
     * @return Voiture
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;
    
        return $this;
    }

    /**
     * Get marque
     *
     * @return string 
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return Voiture
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    
        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set idPersonne
     *
     * @param \Covoiturage\FrontendBundle\Entity\Personne $idPersonne
     * @return Voiture
     */
    public function setIdPersonne(\Covoiturage\FrontendBundle\Entity\Personne $idPersonne = null)
    {
        $this->idPersonne = $idPersonne;
    
        return $this;
    }

    /**
     * Get idPersonne
     *
     * @return \Covoiturage\FrontendBundle\Entity\Personne 
     */
    public function getIdPersonne()
    {
        return $this->idPersonne;
    }
}