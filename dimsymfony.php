<?php
declare(strict_types=1);

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use Dimsymfony\Entity\CustomerItinerary; // Import the entity

if (!defined('_PS_VERSION_')) {
    exit;
}

class Dimsymfony extends Module implements WidgetInterface
{
    public function __construct()
    {
        $this->name = 'dimsymfony';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Iepiep';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = ['min' => '8.0.0', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Dim Symfony Module', [], 'Modules.Dimsymfony.Admin');
        $this->description = $this->trans('A simple module to demonstrate PrestaShop 8 development.', [], 'Modules.Dimsymfony.Admin');
        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', [], 'Modules.Dimsymfony.Admin');
    }

    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('displayHome') // Example hook
            && $this->installTab()
            && $this->installDatabase(); // Install the database table
    }

    public function uninstall()
    {
        return parent::uninstall()
            && $this->uninstallTab()
            && $this->uninstallDatabase(); // Uninstall the database table
    }

    private function installTab()
    {
        // ... (same as previous response, no changes here) ...
        $tabId = (int) Tab::getIdFromClassName('DimsymfonyTab');
        if (!$tabId) {
            $tab = new Tab();
        } else {
          $tab = new Tab($tabId); //Instantiate
        }
        $tab->active = 1;
        $tab->class_name = 'DimsymfonyTab';
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = 'DimSymfony Main';
        }
        $tab->id_parent = (int) Tab::getIdFromClassName('CONFIGURE');
        $tab->module = $this->name;
        $tab->icon = 'settings';

        return $tab->save() && $this->installSubTabs();
    }
    private function installSubTabs()
    {
        // ... (same as previous response, no changes here) ...
        $subTabs = [
            [
                'class_name' => 'DimsymfonyConfiguration',
                'name' => 'Configuration',
                'icon' => 'settings',
                'route_name' => 'dimsymfony_configuration' // Corrected: Use your module name
            ],
            [
                'class_name' => 'DimsymfonyOtherPage',
                'name' => 'Other Page',
                'icon' => 'settings',
                'route_name' => 'dimsymfony_other_page' // Corrected: Use your module name
            ],
            [
                'class_name' => 'DimsymfonyApi',
                'name' => 'API',
                'icon' => 'settings',
                'route_name' => 'dimsymfony_api'  // Corrected: Use your module name
            ],
        ];

        $parentTabId = (int) Tab::getIdFromClassName('DimsymfonyTab');
        if (!$parentTabId) {
            return false;
        }

        $success = true;
        foreach ($subTabs as $subTab) {
          $tabId = (int) Tab::getIdFromClassName($subTab['class_name']);
          if (!$tabId) {
              $tab = new Tab();
          } else {
              $tab = new Tab($tabId);
          }
            $tab->active = 1;
            $tab->class_name = $subTab['class_name'];
            $tab->name = array();
            foreach (Language::getLanguages() as $lang) {
                $tab->name[$lang['id_lang']] = $subTab['name'];
            }
            $tab->id_parent = $parentTabId;
            $tab->module = $this->name;
            $tab->icon = $subTab['icon']; // Corrected: Use the icon

            $success = $success && $tab->save();
        }

        return $success;
    }

    private function uninstallTab()
    {
         // ... (same as previous response, no changes here) ...
         $tabId = (int) Tab::getIdFromClassName('DimsymfonyTab');
         if ($tabId) {
             $tab = new Tab($tabId);
             return $tab->delete() && $this->uninstallSubTabs(); //Correct order.
         }
         return true; //If no tab id, consider uninstalled.
    }
    private function uninstallSubTabs()
    {
        // ... (same as previous response, no changes here) ...
        $subTabs = [
            'DimsymfonyConfiguration',
            'DimsymfonyOtherPage',
            'DimsymfonyApi'
        ];

        $success = true;
        foreach ($subTabs as $subTab) {
            $tabId = (int) Tab::getIdFromClassName($subTab);
            if ($tabId) {
                $tab = new Tab($tabId);
                $success = $success && $tab->delete();
            }
        }

        return $success;
    }

    private function installDatabase()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'customer_itinerary` (
            `id_customer_itinerary` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `customer_name` VARCHAR(255) NOT NULL,
            `destination` VARCHAR(255) NOT NULL,
            `travel_date` DATE NOT NULL,
            `itinerary_details` TEXT,
            PRIMARY KEY (`id_customer_itinerary`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

        return Db::getInstance()->execute($sql);
    }

    private function uninstallDatabase()
    {
        $sql = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'customer_itinerary`;';
        return Db::getInstance()->execute($sql);
    }
    public function renderWidget($hookName, array $configuration)
    {
        // Implement widget rendering if you use hooks (e.g., displayHome)
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        // Implement widget variables if you use hooks
    }
}
