<?php

namespace TS\ReportsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Report
 *
 * @ORM\Table(name="report")
 * @ORM\Entity(repositoryClass="TS\ReportsBundle\Repository\ReportRepository")
 */
class Report
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
     * @var \stdClass
     *
     * @ORM\Column(name="site", type="object")
     */
    private $site;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="date")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date")
     */
    private $endDate;

    /**
     * @var array|null
     *
     * @ORM\Column(name="register", type="array", nullable=true)
     */
    private $register;

    /**
     * @var array|null
     *
     * @ORM\Column(name="rows", type="array", nullable=true)
     */
    private $rows;

    /**
     * @var array|null
     *
     * @ORM\Column(name="curve", type="array", nullable=true)
     */
    private $curve;


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
     * Set site.
     *
     * @param \stdClass $site
     *
     * @return Report
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site.
     *
     * @return \stdClass
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set startDate.
     *
     * @param \DateTime $startDate
     *
     * @return Report
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate.
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate.
     *
     * @param \DateTime $endDate
     *
     * @return Report
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate.
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set register.
     *
     * @param array|null $register
     *
     * @return Report
     */
    public function setRegister($register = null)
    {
        $this->register = $register;

        return $this;
    }

    /**
     * Get register.
     *
     * @return array|null
     */
    public function getRegister()
    {
        return $this->register;
    }

    /**
     * Set rows.
     *
     * @param array|null $rows
     *
     * @return Report
     */
    public function setRows($rows = null)
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * Get rows.
     *
     * @return array|null
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Set curve.
     *
     * @param array|null $curve
     *
     * @return Report
     */
    public function setCurve($curve = null)
    {
        $this->curve = $curve;

        return $this;
    }

    /**
     * Get curve.
     *
     * @return array|null
     */
    public function getCurve()
    {
        return $this->curve;
    }
}
