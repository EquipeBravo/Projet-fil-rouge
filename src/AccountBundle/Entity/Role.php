<?php

namespace AccountBundle\Entity;

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
}

