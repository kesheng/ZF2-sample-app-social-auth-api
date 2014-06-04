<?php

namespace Application\Controller;

use Sglib\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $login = $this->authenticationHelper()->checkIdentity();

        if ($login['code'] == '401') {
        	return new \Zend\View\Model\JsonModel($login);
        } else {
        	return new \Zend\View\Model\JsonModel($login);
        }

        
    }
}
