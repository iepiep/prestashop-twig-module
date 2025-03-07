<?php
/**
 * @author Roberto Minini <r.minini@solution61.fr>
 * @copyright 2025 Roberto Minini
 * @license MIT
 */
namespace DimSymfony\Form;

// Si la variable d'environnement n'existe pas, on la définit par défaut (chaîne vide)
if (false === getenv('DIMSYMFONY_GOOGLE_API_KEY')) {
    putenv('DIMSYMFONY_GOOGLE_API_KEY=');
}

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Adapter\Configuration;
use Symfony\Component\DependencyInjection\Exception\EnvNotFoundException;

/**
 * Configuration data provider
 */
class ConfigurationTextDataConfiguration
{
    public const DIM_SYMFONY_TEXT_TYPE = 'DIM_SYMFONY_TEXT_TYPE';
    public const DIMSYMFONY_ENABLE_MAPS = 'DIMSYMFONY_ENABLE_MAPS';
    public const DIMSYMFONY_GOOGLE_API_KEY = 'DIMSYMFONY_GOOGLE_API_KEY';

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return array
     */
    public function getConfiguration(): array
    {
        $return = [];

        // Get multilingual values for the welcome message
        $languages = \Language::getLanguages(false);
        $welcomeMessages = [];

        foreach ($languages as $language) {
            $langId = (int) $language['id_lang'];
            $welcomeMessages[$langId] = $this->configuration->get(
                self::DIM_SYMFONY_TEXT_TYPE,
                $langId
            );

            // Set default value if empty
            if (empty($welcomeMessages[$langId])) {
                $welcomeMessages[$langId] = 'Book your appointment now!';
            }
        }

        $return[self::DIM_SYMFONY_TEXT_TYPE] = $welcomeMessages;
        $return[self::DIMSYMFONY_ENABLE_MAPS] = (bool) $this->configuration->get(self::DIMSYMFONY_ENABLE_MAPS);

        // Tenter de récupérer la clé Google, et en cas d'absence, utiliser une chaîne vide
        try {
            $googleApiKey = $this->configuration->get(self::DIMSYMFONY_GOOGLE_API_KEY);
        } catch (EnvNotFoundException $e) {
            $googleApiKey = '';
        }
        if (!$googleApiKey) {
            $googleApiKey = '';
        }
        $return[self::DIMSYMFONY_GOOGLE_API_KEY] = $googleApiKey;

        return $return;
    }

    /**
     * @param array $configuration
     *
     * @return array
     */
    public function updateConfiguration(array $configuration): array
    {
        $errors = [];

        if ($this->validateConfiguration($configuration)) {
            // Update multilingual values
            foreach ($configuration[self::DIM_SYMFONY_TEXT_TYPE] as $langId => $welcomeMessage) {
                $this->configuration->set(self::DIM_SYMFONY_TEXT_TYPE, $welcomeMessage, ['id_lang' => $langId]);
            }

            $this->configuration->set(self::DIMSYMFONY_ENABLE_MAPS, (int) $configuration[self::DIMSYMFONY_ENABLE_MAPS]);

            // Utiliser une valeur par défaut pour la clé Google si elle n'est pas fournie
            $googleApiKey = $configuration[self::DIMSYMFONY_GOOGLE_API_KEY] ?? '';
            $this->configuration->set(self::DIMSYMFONY_GOOGLE_API_KEY, $googleApiKey);
        }

        return $errors;
    }

    /**
     * @param array $configuration
     *
     * @return bool
     */
    private function validateConfiguration(array $configuration): bool
    {
        // Vérifier qu'un message d'accueil est défini pour au moins une langue
        $hasWelcomeMessage = false;
        foreach ($configuration[self::DIM_SYMFONY_TEXT_TYPE] as $langId => $welcomeMessage) {
            if (!empty($welcomeMessage)) {
                $hasWelcomeMessage = true;
                break;
            }
        }

        if (!$hasWelcomeMessage) {
            return false;
        }

        // Si les maps sont activées, la clé API est requise (ici, la validation échoue si absente)
        if ($configuration[self::DIMSYMFONY_ENABLE_MAPS] && empty($configuration[self::DIMSYMFONY_GOOGLE_API_KEY])) {
            return false;
        }

        return true;
    }
}
