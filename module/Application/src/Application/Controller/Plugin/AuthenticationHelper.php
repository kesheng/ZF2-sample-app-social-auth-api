<?php

namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Http\Response;



class AuthenticationHelper extends AbstractPlugin
{
    protected $zfcUserAuthentication;
    protected $getResponse;

    public function __construct($auth)
    {
        $this->zfcUserAuthentication = $auth;
        $this->getResponse = new Response();
    }


    


    public function checkIdentity()
    {
        if ($this->zfcUserAuthentication->hasIdentity() === false) {
            $this->getController()->getResponse()->setStatusCode('401');
            //$this->getResponse->setStatusCode(401);

            return array(
                'code'    => '401',
                'errors'  => array(
                    'application' => 'Session not exist'
                )
            );
        } else {
            $this->getController()->getResponse()->setStatusCode('200');
            //$this->getResponse->setStatusCode(200);

            return array(
                'code'    => '200',
                'response' => array(
                    //'id'     => $this->zfcUserAuthentication->getIdentity()->getId(),
                    'action' => 'Session already exist',
                )
            );
        }
    }
}