
<?php
/**
 * @author Roberto Minini <r.minini@solution61.fr>
 * @copyright 2025 Roberto Minini
 * @license MIT
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

class AdminDimSymfonyMainController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
        $this->display = 'view';
    }

    public function initContent()
    {
        // Redirecting to configuration page
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminDimSymfonyConfig'));
    }
}
