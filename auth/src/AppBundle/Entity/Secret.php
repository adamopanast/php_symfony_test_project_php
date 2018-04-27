<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Secret
 *
 * @ORM\Table(name="secret")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SecretRepository")
 */
class Secret
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="userid", type="integer", unique=true)
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="apikey", type="string", length=40, unique=true)
     */
    private $apikey;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     *
     * @return Secret
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set apikey
     *
     * @param string $apikey
     *
     * @return Secret
     */
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;

        return $this;
    }

    /**
     * Get apikey
     *
     * @return string
     */
    public function getApikey()
    {
        return $this->apikey;
    }
}

