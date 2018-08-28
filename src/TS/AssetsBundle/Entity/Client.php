<?php

namespace TS\AssetsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="TS\AssetsBundle\Repository\ClientRepository")
 */
class Client
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
    * @ORM\OneToMany(targetEntity="TS\AssetsBundle\Entity\Site", mappedBy="client")
    */
    private $sites;

    /**
     * @var string
     *
     * @ORM\Column(name="clientName", type="string", length=30)
     */
    private $clientName;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set clientName.
     *
     * @param string $clientName
     *
     * @return Client
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;

        return $this;
    }

    /**
     * Get clientName.
     *
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sites = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add site.
     *
     * @param \TS\AssetsBundle\Entity\Site $site
     *
     * @return Client
     */
    public function addSite(\TS\AssetsBundle\Entity\Site $site)
    {
        $this->sites[] = $site;

        $site->setClient($this);

        return $this;
    }

    /**
     * Remove site.
     *
     * @param \TS\AssetsBundle\Entity\Site $site
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSite(\TS\AssetsBundle\Entity\Site $site)
    {
        return $this->sites->removeElement($site);
    }

    /**
     * Get sites.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSites()
    {
        return $this->sites;
    }
}
