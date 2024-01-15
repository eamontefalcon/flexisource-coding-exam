<?php

namespace  App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repositories\Customer\CustomerRepository")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string")
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string")
     */
    private string $username;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="string")
     */
    private string $gender;

    /**
     * @ORM\Column(type="string")
     */
    private string $country;

    /**
     * @ORM\Column(type="string")
     */
    private string $city;

    /**
     * @ORM\Column(type="string")
     */
    private string $phone;


    /**
     * @throws \Exception
     */
    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $username,
        string $password,
        string $gender,
        string $country,
        string $city,
        string $phone
    )
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setEmail($email);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setGender($gender);
        $this->setCountry($country);
        $this->setCity($city);
        $this->setPhone($phone);
    }


    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @throws \Exception
     */
    public function setFirstName(string $firstName): void
    {
        if (empty($firstName)) {
            throw new \Exception('first name is required');
        }

        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @throws \Exception
     */
    public function setLastName(string $lastName): void
    {
        if (empty($lastName)) {
            throw new \Exception('last name is required');
        }

        $this->lastName = $lastName;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' '. $this->lastName;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @throws \Exception
     */
    public function setUsername(string $username): void
    {
        if (empty($username)) {
            throw new \Exception('username is required');
        }

        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @throws \Exception
     */
    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('email is not valid');
        }

        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @throws \Exception
     */
    public function setPassword(string $password): void
    {
        if (empty($password)) {
            throw new \Exception('password is required');
        }

        $this->password = $password;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @throws \Exception
     */
    public function setGender(string $gender): void
    {
        if (empty($gender)) {
            throw new \Exception('gender is required');
        }

        $this->gender = $gender;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @throws \Exception
     */
    public function setCountry(string $country): void
    {
        if (empty($country)) {
            throw new \Exception('country is required');
        }

        $this->country = $country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @throws \Exception
     */
    public function setCity(string $city): void
    {
        if (empty($city)) {
            throw new \Exception('city is required');
        }

        $this->city = $city;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @throws \Exception
     */
    public function setPhone(string $phone): void
    {
        if (empty($phone)) {
            throw new \Exception('phone is required');
        }

        $this->phone = $phone;
    }


}
