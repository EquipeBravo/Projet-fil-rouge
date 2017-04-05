<?php

namespace PlanningBundle\Entity;


use AccountBundle\Entity\Person;

/**
 * Place
 */
class Place
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $room;

    /**
     * @var string
     */
    private $city;

    /**
     * @var Person
     */
   //private $roomManager;


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
     * Set room
     *
     * @param string $room
     *
     * @return Place
     */
    public function setRoom($room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return string
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Place
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set roomManager
     *
     * @param Person $roomManager
     *
     * @return Place
     */
   /* public function setRoomManager(Person $roomManager)
    {
        $this->roomManager = $roomManager;

        return $this;
    }
   */

    /**
     * Get roomManager
     *
     * @return Person
     */
   /*
    public function getRoomManager()
    {
        return $this->roomManager;
    }
   */
    public function __toString()
    {
        $place = $this->room . " " . $this->city;
        return $place;
    }

}

