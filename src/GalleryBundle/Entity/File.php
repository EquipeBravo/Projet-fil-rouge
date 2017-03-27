<?php

namespace GalleryBundle\Entity;

use AccountBundle\Entity\Team;

/**
 * file
 */
class File
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $files;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $alt;

    /**
     * @var \DateTime
     */
    private $uploadDate;

    /**
     * @var Team
     */
    private $team;

    /**
     * Get team
     *
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    public function __construct()
    {
        $this->uploadDate = new \DateTime();
    }
    /**
     * Set team
     *
     * @param Team $team
     *
     * @return files
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;

        return $this;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return files
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set files
     *
     * @param string $files
     *
     * @return files
     */
    public function setfiles($files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * Get files
     *
     * @return string
     */
    public function getfiles()
    {
        return $this->files;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return files
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return files
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set uploadDate
     *
     * @param \DateTime $uploadDate
     *
     * @return files
     */
    public function setUploadDate($uploadDate)
    {
        $this->uploadDate = $uploadDate;

        return $this;
    }

    /**
     * Get uploadDate
     *
     * @return \DateTime
     */
    public function getUploadDate()
    {
        return $this->uploadDate;
    }
}
