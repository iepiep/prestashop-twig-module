<?php
declare(strict_types=1);

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use Dimsymfony\Entity\Rdv; // Utilisation de la nouvelle entité Rdv
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Dimsymfony extends Module implements WidgetInterface
{
    private $urlGenerator;

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
        $this->description = $this->trans('A module for appointment scheduling and route optimization.', [], 'Modules.Dimsymfony.Admin'); // Description plus précise
        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', [], 'Modules.Dimsymfony.Admin');
        $this->urlGenerator = $this->get('router');
    }

    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('displayBanner')
            && $this->installTab()
            && $this->installDatabase()
            && Configuration::updateValue('DIMSYMFONY_BASE_LOCATION', '25 rue de la Noé Pierre, 53960 Bonchamp-lès-Laval, France');
    }

    public function uninstall()
    {
        return parent::uninstall()
            && $this->uninstallTab()
            && $this->uninstallDatabase()
            && Configuration::deleteByName('DIMSYMFONY_BASE_LOCATION');
    }

    private function installTab()
    {
        // ... (Pas de changements ici) ...
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
         // ... (Pas de changements ici) ...
         $subTabs = [
            [
                'class_name' => 'DimsymfonyConfiguration',
                'name' => 'Configuration',
                'icon' => 'settings',
                'route_name' => 'dimsymfony_configuration'
            ],
            [
                'class_name' => 'DimsymfonyCustomerList', // Changement de nom
                'name' => 'Customer List',
                'icon' => 'list',
                'route_name' => 'dimsymfony_customer_list' // Changement de nom
            ],
            // Pas de tab pour ItineraryController, car on y accède via un bouton
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
            $tab->name = [];
            foreach (Language::getLanguages() as $lang) {
                $tab->name[$lang['id_lang']] = $subTab['name'];
            }
            $tab->id_parent = $parentTabId;
            $tab->module = $this->name;
            $tab->icon = $subTab['icon'];

            $success = $success && $tab->save();
        }

        return $success;
    }

    private function uninstallTab()
    {
         // ... (Pas de changements ici) ...
         $tabId = (int) Tab::getIdFromClassName('DimsymfonyTab');
        if ($tabId) {
            $tab = new Tab($tabId);
            return $tab->delete() && $this->uninstallSubTabs();
        }
        return true;
    }

    private function uninstallSubTabs()
    {
        // ... (Pas de changements ici) ...
        $subTabs = [
            'DimsymfonyConfiguration',
            'DimsymfonyCustomerList', // Changement de nom
            // Pas de tab pour ItineraryController
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
        $sql = file_get_contents(_PS_MODULE_DIR_ . $this->name . '/sql/install.sql');
        $sql = str_replace('{prefix}', _DB_PREFIX_, $sql); // Remplacement correct du préfixe
        return Db::getInstance()->execute($sql);
    }

    private function uninstallDatabase()
    {
        $sql = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'dim_rdv`;'; // Utilisation de dim_rdv
        return Db::getInstance()->execute($sql);
    }

    public function renderWidget($hookName, array $configuration)
    {
       // ... (Pas de changements ici) ...
       if ($hookName != 'displayBanner') {
            return '';
        }
        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        return $this->fetch('module:dimsymfony/views/templates/hook/banner.tpl');
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        // ... (Pas de changements ici) ...
        if ($hookName != 'displayBanner') {
            return [];
        }

        // Générer l'URL vers le FrontController (formulaire)
        $formUrl = $this->urlGenerator->generate('dimsymfony_itinerary_form'); // Nom de la route du FrontController

        return [
            'message' => $this->trans('Plan your trip with us! Book an appointment.', [], 'Modules.Dimsymfony.Front'),
            'button_url' => $formUrl,
            'button_text' => $this->trans('Book Now', [], 'Modules.Dimsymfony.Front'),
        ];
    }
}
