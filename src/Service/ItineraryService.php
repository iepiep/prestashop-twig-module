
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
     * @param array $appointment The appointment data
     * @return array Itinerary data
     */
    public function getItineraryData(array $appointment): array
    {
        // Get shop address from configuration
        $shopAddress = $this->getShopAddress();
        
        // Format appointment address
        $destinationAddress = $this->formatAppointmentAddress($appointment);
        
        return [
            'origin' => $shopAddress,
            'destination' => $destinationAddress,
            'appointment' => $appointment,
        ];
    }
    
    /**
     * Format the appointment address for Google Maps
     * 
     * @param array $appointment
     * @return string Formatted address
     */
    private function formatAppointmentAddress(array $appointment): string
    {
        return urlencode(
            $appointment['address'] . ', ' . 
            $appointment['postal_code'] . ' ' . 
            $appointment['city'] . ', France'
        );
    }
    
    /**
     * Get shop address from configuration
     * 
     * @return string Formatted shop address
     */
    private function getShopAddress(): string
    {
        $shop = $this->context->getContext()->shop;
        $address = \Configuration::get('PS_SHOP_ADDR1', null, $shop->id_shop_group, $shop->id);
        $city = \Configuration::get('PS_SHOP_CITY', null, $shop->id_shop_group, $shop->id);
        $postcode = \Configuration::get('PS_SHOP_CODE', null, $shop->id_shop_group, $shop->id);
        $country = \Configuration::get('PS_SHOP_COUNTRY', null, $shop->id_shop_group, $shop->id);
        
        return urlencode("$address, $postcode $city, $country");
    }
}
