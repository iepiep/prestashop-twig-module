<?php
/**
 * @author Roberto Minini <r.minini@solution61.fr>
 * @copyright 2025 Roberto Minini
 * @license MIT
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Form\Handler;
use PrestaShop\PrestaShop\Core\Domain\Shop\ValueObject\ShopConstraint;

class AdminDimSymfonyConfigController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->display = 'view';
    }

    public function initContent()
    {
        if (Tools::isSubmit('resetModule')) {
            if ($this->module->resetModuleData()) {
                $this->confirmations[] = $this->trans('Module data has been reset successfully.', [], 'Modules.Dimsymfony.Admin');
            } else {
                $this->errors[] = $this->trans('An error occurred while resetting module data.', [], 'Modules.Dimsymfony.Admin');
            }
        }

        parent::initContent();
    }

    public function renderView()
    {
        $container = \PrestaShop\PrestaShop\Adapter\SymfonyContainer::getInstance();
        $formHandler = $container->get('prestashop.module.dimsymfony.form.configuration_text_form_data_handler');

        $shopConstraint = ShopConstraint::allShops();
        $this->content = $this->renderConfigurationForm($formHandler, $shopConstraint);

        $this->context->smarty->assign([
            'content' => $this->content,
            'module_dir' => $this->module->getPathUri(),
            'resetUrl' => $this->context->link->getAdminLink('AdminDimSymfonyConfig') . '&resetModule=1',
        ]);

        return parent::renderView();
    }

    protected function renderConfigurationForm(Handler $formHandler, ShopConstraint $shopConstraint)
    {
        $form = $formHandler->getForm();
        $form->handleRequest($this->getRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $errors = $formHandler->save($data);

            if (empty($errors)) {
                $this->confirmations[] = $this->trans('Configuration updated successfully.', [], 'Modules.Dimsymfony.Admin');
            } else {
                foreach ($errors as $error) {
                    $this->errors[] = $error;
                }
            }
        }

        $formFactory = $this->get('form.factory');
        return $this->renderForm($form);
    }

    private function getRequest()
    {
        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        $request->attributes->set('_route', 'admin_dimsymfony_config');
        return $request;
    }

    private function get($service)
    {
        return \PrestaShop\PrestaShop\Adapter\SymfonyContainer::getInstance()->get($service);
    }
}
