<?php

namespace AccountBundle\Entity;

use AppBundle\Entity\Club;
/**
 * Role
 */
class Role
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $roleName;

    /**
     * @var int
     */
    private $roleRights;

    /**
     * @var AppBundle\Entity\Club
     */
    private $club;

    /**
     * Get category
     *
     * @return Club
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * Set club
     *
     * @param Club $club
     *
     * @return Team
     */
    public function setClub(Club $club)
    {
        $this->club = $club;

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
     * Set roleName
     *
     * @param string $roleName
     *
     * @return Role
     */
    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;

        return $this;
    }

    /**
     * Get roleName
     *
     * @return string
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * Set roleRights
     *
     * @param integer $roleRights
     *
     * @return Role
     */
    public function setRoleRights($roleRights)
    {
        $this->roleRights = $roleRights;

        return $this;
    }

    /**
     * Get roleRights
     *
     * @return int
     */
    public function getRoleRights()
    {
        return $this->roleRights;
    }

    public function __toString()
    {
        return $this->roleName;
    }
}

