<?php

namespace Dimsymfony\Controller\Admin; // Corrected Namespace

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Response;

class OtherPageController extends FrameworkBundleAdminController
{
    public function indexAction(): Response
    {
        return $this->render('@Modules/dimsymfony/views/templates/admin/other_page.html.twig');
    }
}
