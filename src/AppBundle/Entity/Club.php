<?php

namespace AppBundle\Entity;

/**
 * Club
 */
class Club
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $clubcontent;

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
     * Set title
     *
     * @param string $title
     *
     * @return Club
     */
    public function settitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function gettitle()
    {
        return $this->title;
    }

    /**
     * Set clubcontent
     *
     * @param string $clubcontent
     *
     * @return Club
     */
    public function setClubcontent($clubcontent)
    {
        $this->clubcontent = $clubcontent;

        return $this;
    }

    /**
     * Get clubcontent
     *
     * @return string
     */
    public function getClubcontent()
    {
        return $this->clubcontent;
    }
}
