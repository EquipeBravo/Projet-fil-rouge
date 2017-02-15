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
    private $history;

    /**
     * @var string
     */
    private $clubValues;


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
     * Set history
     *
     * @param string $history
     *
     * @return Club
     */
    public function setHistory($history)
    {
        $this->history = $history;

        return $this;
    }

    /**
     * Get history
     *
     * @return string
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * Set clubValues
     *
     * @param string $clubValues
     *
     * @return Club
     */
    public function setClubValues($clubValues)
    {
        $this->clubValues = $clubValues;

        return $this;
    }

    /**
     * Get clubValues
     *
     * @return string
     */
    public function getClubValues()
    {
        return $this->clubValues;
    }
}

