
<?php
/**
 * @author Roberto Minini <r.minini@solution61.fr>
 * @copyright 2025 Roberto Minini
 * @license MIT
 */

namespace DimSymfony\Form;

use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

/**
 * Form data provider for the configuration form
 */
class ConfigurationTextFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var ConfigurationTextDataConfiguration
     */
    private $configuration;

    /**
     * @param ConfigurationTextDataConfiguration $configuration
     */
    public function __construct(ConfigurationTextDataConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return $this->configuration->getConfiguration();
    }

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): array
    {
        return $this->configuration->updateConfiguration($data);
    }
}
