<?php

namespace Application\Controller;

use Sglib\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class UserController extends AbstractActionController
{
    /**
     * @var \Application\Service\User
     */
    protected $userService;


    /**
     * @var Application\Service\Json
     */
    protected $jsonService;



    public function __construct($userService, $jsonService)
    {
        $this->userService = $userService;
        $this->jsonService = $jsonService;
    }


    /**
     * No option action
     */
    public function noopAction()
    {
        return new JsonModel();
    }


    /**
     * Index
     */
    public function indexAction()
    {
        //return new JsonModel();
        $login = $this->authenticationHelper()->checkIdentity();
        if ($login['code'] == 401) {
            return new JsonModel($login);
        }

        return $this->userService->getUserByUserId(
            $this->zfcUserAuthentication()->getIdentity()->getId()
        );
    }


    public function viewAction()
    {
        $login = $this->authenticationHelper()->checkIdentity();
        if ($login['code'] == 401) {
            return new JsonModel($login);
        }

        return $this->userService->getUserByUserName(
            $this->zfcUserAuthentication()->getIdentity()->getUsername()
        );
    }
}
