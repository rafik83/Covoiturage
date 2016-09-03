<?php
/**
 * 
 * User: wissem
 * Date: 02/11/2014
 * Time: 19:49
 * Email: wissemr@gmail.com
 */

namespace Covoiturage\FrontendBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateur")
 */
class Utilisateur extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="tel", type="integer", nullable=true)
     */
    private $tel;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @param int $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }



} 