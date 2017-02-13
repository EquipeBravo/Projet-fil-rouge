<?php

namespace AccountBundle\Entity;

/**
 * Team
 */
class Team
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
     * @var \DateTime
     */
    private $resumptionDate;

    /**
     * @var string
     */
    private $trainingDay;

    /**
     * @var string
     */
    private $trainingTime;


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
     * @return Team
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
     * Set resumptionDate
     *
     * @param \DateTime $resumptionDate
     *
     * @return Team
     */
    public function setResumptionDate($resumptionDate)
    {
        $this->resumptionDate = $resumptionDate;

        return $this;
    }

    /**
     * Get resumptionDate
     *
     * @return \DateTime
     */
    public function getResumptionDate()
    {
        return $this->resumptionDate;
    }

    /**
     * Set trainingDay
     *
     * @param string $trainingDay
     *
     * @return Team
     */
    public function setTrainingDay($trainingDay)
    {
        $this->trainingDay = $trainingDay;

        return $this;
    }

    /**
     * Get trainingDay
     *
     * @return string
     */
    public function getTrainingDay()
    {
        return $this->trainingDay;
    }

    /**
     * Set trainingTime
     *
     * @param string $trainingTime
     *
     * @return Team
     */
    public function setTrainingTime($trainingTime)
    {
        $this->trainingTime = $trainingTime;

        return $this;
    }

    /**
     * Get trainingTime
     *
     * @return string
     */
    public function getTrainingTime()
    {
        return $this->trainingTime;
    }
}

