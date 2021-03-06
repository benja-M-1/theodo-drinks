<?php

namespace Drinks\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User class.
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 * @ODM\Document(repositoryClass="Drinks\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ODM\Id
     * @var integer
     */
    private $id;

    /**
     * @ODM\String
     * @ODM\UniqueIndex
     * @var string
     */
    private $name;

    /**
     * @ODM\Int
     * @var integer
     */
    private $balance;

    /**
     * @ODM\String
     * @var string
     */
    private $salt;

    /**
     * @ODM\String
     * @var string
     */
    private $password;

    /**
     * @ODM\String
     * @var string
     */
    private $roles;

    /**
     * @ODM\ReferenceMany(targetDocument="Drinks\Document\Transaction", mappedBy="user")
     * @var ArrayCollection
     */
    private $transactions;

    /**
     * @ODM\ReferenceMany(targetDocument="Drinks\Document\Restocking", mappedBy="users")
     * @var ArrayCollection
     */
    private $restockings;

    /**
     * Stores the number of drinks consummed by the user.
     *
     * @ODM\Int
     * @var integer
     */
    private $drinks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->restockings  = new ArrayCollection();
    }

    /**
     * @param $consumptions
     */
    public function setTransactions($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * @return array|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return String
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Integer $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * @return Integer
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param Integer $amount
     */
    public function debite($amount)
    {
        $this->balance -= $amount;
    }

    /**
     * @param Integer $amount
     */
    public function credite($amount)
    {
        $this->balance += $amount;
    }

    /**
     * @return float
     */
    public function getFormattedBalance()
    {
        return $this->getBalance() / 100;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return explode(',', $this->roles);
    }

    /**
     * @param Array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = implode(',', $roles);
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getName();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     *
     * @return void
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return int
     */
    public function getDrinks()
    {
        return $this->drinks;
    }

    /**
     * Add a drink to the count.
     */
    public function addDrink()
    {
        $this->drinks += 1;
    }

    /**
     * Reset the drinks count.
     */
    public function resetDrinks()
    {
        $this->drinks = 0;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $restockings
     */
    public function setRestockings($restockings)
    {
        $this->restockings = $restockings;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getRestockings()
    {
        return $this->restockings;
    }
}
