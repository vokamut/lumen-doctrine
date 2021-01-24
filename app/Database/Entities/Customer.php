<?php
declare(strict_types=1);

namespace App\Database\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string")
     */
    protected string $firstname;

    /**
     * @ORM\Column(type="string")
     */
    protected string $lastname;

    /**
     * @ORM\Column(type="string")
     */
    protected string $email;

    /**
     * @ORM\Column(type="string")
     */
    protected string $country;

    /**
     * @ORM\Column(type="string")
     */
    protected string $username;

    /**
     * @ORM\Column(type="string")
     */
    protected string $gender;

    /**
     * @ORM\Column(type="string")
     */
    protected string $city;

    /**
     * @ORM\Column(type="string")
     */
    protected string $phone;

    /**
     * @param $title
     */
    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        string $country,
        string $username,
        string $gender,
        string $city,
        string $phone
    )
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->country = $country;
        $this->username = $username;
        $this->gender = $gender;
        $this->city = $city;
        $this->phone = $phone;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'fullName' => $this->getFullName(),
            'firstname' => $this->getFirstname(),
            'lastname' => $this->getLastname(),
            'email' => $this->getEmail(),
            'country' => $this->getCountry(),
            'username' => $this->getUsername(),
            'gender' => $this->getGender(),
            'city' => $this->getCity(),
            'phone' => $this->getPhone(),
        ];
    }
}
