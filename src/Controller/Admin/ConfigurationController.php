<?php

namespace Dimsymfony\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Configuration;

class ConfigurationController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request): Response
    {
        $form = $this->createConfigurationForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            Configuration::updateValue('DIMSYMFONY_GOOGLE_API_KEY', $data['google_api_key']);
            $this->addFlash('success', $this->trans('Settings saved successfully.', 'Admin.Notifications.Success'));
        }

        return $this->render('@Modules/dimsymfony/views/templates/admin/configuration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function createConfigurationForm()
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder
            ->add('google_api_key', TextType::class, [
                'label' => $this->trans('Google API Key', 'Modules.Dimsymfony.Admin'),
                'required' => true,
                'data' => Configuration::get('DIMSYMFONY_GOOGLE_API_KEY'), // Pré-remplir avec la valeur existante
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->trans('Save', 'Admin.Actions'),
            ]);

        return $formBuilder->getForm();
    }
}
