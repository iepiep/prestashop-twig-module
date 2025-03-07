<?php

namespace Dimsymfony\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="` . _DB_PREFIX_ . `dim_rdv") // Nom de table correct
 */
class Rdv
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id_dim_rdv", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(name="postal_code", type="string", length=10)
     */
    private $postalCode;

    /**
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(name="phone", type="string", length=20)
     */
    private $phone;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(name="date_creneau1", type="string", length=50)
     */
    private $dateCreneau1;

    /**
     * @ORM\Column(name="date_creneau2", type="string", length=50)
     */
    private $dateCreneau2;

    /**
     * @ORM\Column(name="visited", type="boolean")
     */
    private $visited;

     /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastname;
    }

    public function setLastName(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }
    public function getFirstName(): ?string
    {
        return $this->firstname;
    }

    public function setFirstName(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }
    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getDateCreneau1(): ?string
    {

        return $this->dateCreneau1;
    }

    public function setDateCreneau1(string $dateCreneau1): self
    {
        $this->dateCreneau1 = $dateCreneau1;
        return $this;
    }

    public function getDateCreneau2(): ?string
    {
        return $this->dateCreneau2;
    }

    public function setDateCreneau2(string $dateCreneau2): self
    {
        $this->dateCreneau2 = $dateCreneau2;
        return $this;
    }

    public function getVisited(): ?bool
    {
        return $this->visited;
    }
    public function setVisited(bool $visited): self
    {
        $this->visited = $visited;
        return $this;
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {

        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
