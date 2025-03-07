<?php

namespace Dimsymfony\Controller\Admin; // Corrected Namespace

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Configuration;

class ConfigurationController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request): Response
    {
        $form = $this->getConfigurationForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            Configuration::updateValue('DIMSYMFONY_SETTING', $formData['my_setting']);
            $this->addFlash('success', $this->trans('Settings saved successfully.', 'Admin.Notifications.Success'));
        }

        return $this->render('@Modules/dimsymfony/views/templates/admin/configuration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function getConfigurationForm()
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder->add('my_setting', TextType::class, [
            'label' => $this->trans('My Setting', 'Modules.Dimsymfony.Admin'),
            'required' => false,
            'data' => Configuration::get('DIMSYMFONY_SETTING'),
        ]);

        return $formBuilder->getForm();
    }
}
