<?php
/**
 * @author Roberto Minini <r.minini@solution61.fr>
 * @copyright 2025 Roberto Minini
 * @license MIT
 */
namespace DimSymfony\Service;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Adapter\LegacyContext;

class ItineraryService
{
    /**
     * @var LegacyContext
     */
    private $context;

    /**
     * @param LegacyContext $context
     */
    public function __construct(LegacyContext $context)
    {
        $this->context = $context;
    }

    /**
     * Get itinerary data for an appointment
     *
     * @param array $appointment
     * @return array
     */
    public function getItineraryData(array $appointment): array
    {
        // Format the full address
        $fullAddress = sprintf(
            '%s, %s %s, France',
            $appointment['address'],
            $appointment['postal_code'],
            $appointment['city']
        );

        // Sample itinerary data - in a real module, this would call an external API
        return [
            'destination' => $fullAddress,
            'client_name' => $appointment['firstname'] . ' ' . $appointment['lastname'],
            'estimated_travel_time' => '25 minutes',
            'distance' => '15 km',
            'suggested_departure_time' => $this->getSuggestedDepartureTime($appointment['date_creneau1'])
        ];
    }

    /**
     * Calculate suggested departure time based on appointment slot
     *
     * @param string $appointmentSlot
     * @return string
     */
    private function getSuggestedDepartureTime(string $appointmentSlot): string
    {
        // Parse the slot to determine if it's morning or afternoon
        if (strpos($appointmentSlot, 'MATIN') !== false) {
            return '08:30'; // For morning appointments
        } else {
            return '13:30'; // For afternoon appointments
        }
    }
}
