<?php

namespace Covoiturage\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="Covoiturage\FrontendBundle\Repository\ReservationRepository")
 */
class Reservation
{
    const PENDING = 0;
    const CONFIRMED = 1;
    const CANCELED = 2;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Voyage")
     * @ORM\JoinColumn(name="voyage_id", referencedColumnName="id")
     */
    private $voyage;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")
     */
    private $utilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="smallint", options={"default":"0"})
     */
    private $status = self::PENDING;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }


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
     * Set voyage
     *
     * @param Voyage $voyage
     * @return Reservation
     */
    public function setVoyage(Voyage $voyage)
    {
        $this->voyage = $voyage;
    
        return $this;
    }

    /**
     * Get voyage
     *
     * @return Voyage
     */
    public function getVoyage()
    {
        return $this->voyage;
    }

    /**
     * Set utilisateur
     *
     * @param Utilisateur $utilisateur
     * @return Reservation
     */
    public function setUtilisateur(Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;
    
        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Reservation
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Reservation
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
