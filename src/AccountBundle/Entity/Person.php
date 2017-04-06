<?php

namespace AccountBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Person
 * @UniqueEntity("email", message="Cet email existe déjà")
 */
class Person implements UserInterface, \Serializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre prénom ne peut pas contenir un nombre"
     * )
     */
    private $lastName;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne peut pas contenir un nombre"
     * )
     */
    private $firstName;

    /**
     * @var \DateTime
     */
    private $birthDate;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $zip;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     *
     * @Assert\Email(
     *     message = "Cet email '{{ value }}' n'est pas valide."
     * )
     */
    private $email;

    /**
     * Verifies that password contains just letters, numbers or given special characters
     * Note: It verifies also every time on edit encoded password (if you don't enter a new one), this should be changed!
     *
     * @var string
     * @Assert\Regex(
     *     pattern="/^([a-zA-Z0-9@.\/*!_#\$]{8,})$/",
     *     match=true,
     *     message="Votre mot de passe doit comporter au moins 8 caractères (lettres minuscule et majuscule, sans accents, chiffres ou caractères spéciaux '@$*#!_')"
     * )
     */
    private $plainPassword;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $token;

    /** 
     * @var ArrayCollection
     */
    private $teams;

    /**
     * @var ArrayCollection
     */
    private $userRoles;

    /** 
     * @var ArrayCollection
     */
    private $roles = [];

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }


    /**
     * @return ArrayCollection
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }

    /**
     * @param ArrayCollection $userRoles
     */
    public function setUserRoles(ArrayCollection $userRoles)
    {
        $this->userRoles = $userRoles;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        $roles =['ROLE_USER'];
        foreach ($this->getUserRoles() as $role){
            //if we add a column to the table Role: userRole which either ROLE_USER, ROLE_MANAGER or ROLE_ADMIN then:
            $roles[] = $role->getRoleRights();
        }
        return $roles;
    }

    /**
     * Set roles
     *
     * @param array
     *
     * @return Person
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get teams
     *
     * @return ArrayCollection
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Set teams
     *
     * @param ArrayCollection $teams
     *
     * @return Person
     */
    public function setTeams(ArrayCollection $teams)
    {
        $this->teams = $teams;

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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Person
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Person
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Person
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set zip
     *
     * @param string $zip
     *
     * @return Person
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Person
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
     * Set email
     *
     * @param string $email
     *
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Person
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Person
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /* Needed for UserInterface */
    public function getUsername()
    {
        return $this->email;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
    /*************************/

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
        $this->roles = ['ROLE_USER'];
    }

    public function __toString()
    {
        $name = $this->firstName . " " . $this->lastName; 
        return $name;
    }
}
