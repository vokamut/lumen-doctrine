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
    public const GENDER_FEMALE = false;
    public const GENDER_MALE = true;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private string $firstname;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private string $lastname;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private string $country;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private string $username;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $gender;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private string $city;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private string $phone;

    /**
     * Customer constructor.
     *
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $country
     * @param string $username
     * @param bool $gender
     * @param string $city
     * @param string $phone
     */
    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        string $country,
        string $username,
        bool $gender,
        string $city,
        string $phone
    ) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->country = $country;
        $this->username = $username;
        $this->gender = $gender;
        $this->city = $city;
        $this->phone = $phone;
    }

    final public function getId(): int
    {
        return $this->id;
    }

    final public function getFullName(): string
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    final public function getFirstname(): string
    {
        return $this->firstname;
    }

    final public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    final public function getLastname(): string
    {
        return $this->lastname;
    }

    final public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    final public function getEmail(): string
    {
        return $this->email;
    }

    final public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    final public function getCountry(): string
    {
        return $this->country;
    }

    final public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    final public function getUsername(): string
    {
        return $this->username;
    }

    final public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    final public function getGender(): bool
    {
        return $this->gender;
    }

    final public function setGender(bool $gender): void
    {
        $this->gender = $gender;
    }

    final public function getCity(): string
    {
        return $this->city;
    }

    final public function setCity(string $city): void
    {
        $this->city = $city;
    }

    final public function getPhone(): string
    {
        return $this->phone;
    }

    final public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    final public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'fullName' => $this->getFullName(),
            'email' => $this->getEmail(),
            'country' => $this->getCountry(),
            'username' => $this->getUsername(),
            'gender' => $this->getGender() === self::GENDER_MALE ? 'male' : 'female',
            'city' => $this->getCity(),
            'phone' => $this->getPhone(),
        ];
    }

    final public function toArrayForList(): array
    {
        return [
            'id' => $this->getId(),
            'fullName' => $this->getFullName(),
            'email' => $this->getEmail(),
            'country' => $this->getCountry(),
        ];
    }
}
