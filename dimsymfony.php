
<?php
/**
 * @author Roberto Minini <r.minini@solution61.fr>
 * @copyright 2025 Roberto Minini
 * @license MIT
 *
 * This file is part of the dimrdv project.
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use DimSymfony\Form\ConfigurationTextDataConfiguration;

class Dimsymfony extends Module
{
    public $tabs = [
        [
            'name' => 'Appointment Management', // Main tab
            'class_name' => 'AdminDimSymfonyMain',
            'visible' => true,
            'parent_class_name' => 'CONFIGURE', // Important: Use 'CONFIGURE' for modules main menu
            'wording' => 'Appointment Management',
            'wording_domain' => 'Modules.Dimsymfony.Admin',
        ],
        [
            'name' => 'Configuration', // Subtab
            'class_name' => 'AdminDimSymfonyConfig',
            'visible' => true,
            'parent_class_name' => 'AdminDimSymfonyMain', // Parent is the main tab
            'wording' => 'Configuration',
            'wording_domain' => 'Modules.Dimsymfony.Admin',
        ],
        [
            'name' => 'Appointments', // Subtab
            'class_name' => 'DimSymfonyGestionRdv', //  Keep this name!
            'visible' => true,
            'parent_class_name' => 'AdminDimSymfonyMain',
            'wording' => 'Appointments',
            'wording_domain' => 'Modules.Dimsymfony.Admin',
            'route_name' => 'admin_dimsymphony_gestionrdv_index', // Symfony route name
        ],
    ];

    public function __construct()
    {
        $this->name = 'dimsymfony';
        $this->tab = 'shipping_logistics';
        $this->author = 'Roberto Minini';
        $this->version = '1.0.0';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('DIM Appointment Manager', [], 'Modules.Dimsymfony.Admin');
        $this->description = $this->trans(
            'Appointment management system with Symfony integration.',
            [],
            'Modules.Dimsymfony.Admin'
        );
        $this->ps_versions_compliancy = ['min' => '8.0.0', 'max' => '8.99.99'];
    }

    public function getContent()
    {
         return $this->context->link->getAdminLink('AdminDimSymfonyConfig');
    }

    public function install(): bool
    {
        return parent::install()
            && $this->installSql()
            && $this->registerHook('displayHome')
            && $this->registerHook('displayCustomerAccount')
            && $this->installTabs();
    }

    public function uninstall(): bool
    {
        return parent::uninstall()
            && Configuration::deleteByName(ConfigurationTextDataConfiguration::DIM_SYMFONY_TEXT_TYPE)
            && $this->unregisterHook('displayHome')
            && $this->unregisterHook('displayCustomerAccount')
            && $this->uninstallSql()
            && $this->uninstallTabs();
    }

    private function installSql(): bool
    {
        $sql_file = dirname(__FILE__) . '/sql/installs.sql';

        if (!file_exists($sql_file)) {
            return false;
        }

        $sql_content = file_get_contents($sql_file);
        $sql_content = str_replace('PREFIX_', _DB_PREFIX_, $sql_content);
        $queries = preg_split("/;\s*[\r\n]+/", $sql_content);

        foreach ($queries as $query) {
            if (!empty(trim($query))) {
                if (!Db::getInstance()->execute($query)) {
                    return false;
                }
            }
        }
        return true;
    }

    private function uninstallSql(): bool
    {
        $sql = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'dim_rdv`';
        return Db::getInstance()->execute($sql);
    }

    public function installTabs(): bool
    {
        foreach ($this->tabs as $tabData) {
            $tab = new Tab();
            $tab->active = 1;
            $tab->class_name = $tabData['class_name'];
            $tab->module = $this->name;
            $tab->id_parent = (int) Tab::getIdFromClassName($tabData['parent_class_name']);
            $tab->name = [];
            foreach (Language::getLanguages() as $lang) {
                $tab->name[$lang['id_lang']] = $this->trans($tabData['name'], [], $tabData['wording_domain']);
            }
            if (!$tab->save()) {
                return false;
            }
        }

        return true;
    }

    public function uninstallTabs(): bool
    {
        foreach ($this->tabs as $tabData) {
            $idTab = (int) Tab::getIdFromClassName($tabData['class_name']);
            if ($idTab) {
                $tab = new Tab($idTab);
                if (!$tab->delete()) {
                    return false;
                }
            }
        }

        return true;
    }

    public function hookDisplayHome($params)
    {
        $this->context->smarty->assign([
            'my_module_message' => $this->trans('Book your appointment now!', [], 'Modules.Dimsymfony.Shop'),
            'module_link' => $this->context->link->getModuleLink($this->name, 'dimform')
        ]);

        return $this->display(__FILE__, 'views/templates/hook/dimsymfony.tpl');
    }

    public function hookDisplayCustomerAccount($params)
    {
        return $this->display(__FILE__, 'views/templates/hook/customer_account.tpl');
    }

    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }

    public function resetModuleData(): bool
    {
        $sql = 'TRUNCATE TABLE `' . _DB_PREFIX_ . 'dim_rdv`';

        try {
            return Db::getInstance()->execute($sql);
        } catch (Exception $e) {
            PrestaShopLogger::addLog('SQL Reset Error: ' . $e->getMessage(), 3);

            return false;
        }
    }

    public function getPathUri(): string
    {
        return $this->_path;
    }
}
