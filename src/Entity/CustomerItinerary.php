<?php

namespace Dimsymfony\Entity; // Corrected Namespace

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="` . _DB_PREFIX_ . `customer_itinerary")
 */
class CustomerItinerary
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id_customer_itinerary", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="customer_name", type="string", length=255)
     */
    private $customerName;

    /**
     * @ORM\Column(name="destination", type="string", length=255)
     */
    private $destination;

    /**
     * @ORM\Column(name="travel_date", type="date")
     */
    private $travelDate;

    /**
      * @ORM\Column(name="itinerary_details", type="text", nullable=true)
      */
    private $itineraryDetails;

    // Getters and setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    public function setCustomerName(string $customerName): self
    {
        $this->customerName = $customerName;
        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;
        return $this;
    }
    public function getTravelDate(): ?\DateTimeInterface
    {
        return $this->travelDate;
    }

    public function setTravelDate(\DateTimeInterface $travelDate): self
    {
        $this->travelDate = $travelDate;
        return $this;
    }

    public function getItineraryDetails(): ?string
    {
        return $this->itineraryDetails;
    }

    public function setItineraryDetails(?string $itineraryDetails): self
    {
        $this->itineraryDetails = $itineraryDetails;
        return $this;
    }
}
