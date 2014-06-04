<?php

namespace Application\Service;

use Sglib\Service\AbstractService;
use Zend\View\Model\JsonModel;
use Zend\Http\Response;

class Json extends AbstractService
{
    /**
     * Generate user
     *
     * @param \Application\Entity\User $user
     * @return \Zend\View\Model\JsonModel
     */
    public function generateUser($user)
    {
        return new JsonModel(
            array(
                'user' => array(
                    'id'            => $user->id,
                    'username'      => $user->username,
                    'first_name'    => $user->firstName,
                    'last_name'     => $user->lastName,
                    'email'         => $user->email,
                    'visibility'    => $user->visibility,
                    'photo'         => $user->photo
                )
            )
        );
    }


    /**
     * Generate error
     *
     * @param string $reason
     * @param boolean $code
     * @return \Zend\View\Model\JsonModel
     */
    public function generateError($reason, $code = 400)
    {
        $this->getServiceLocator()->get('response')->setStatusCode($code);

        return new JsonModel(
            array(
                'code'    => $code,
                'errors'  => array('application' => $reason),
                'response' => array(
                    'action' => $reason,
                )
            )
        );
    }


    /**
     * Generate response
     *
     * @param array $data
     * @return \Zend\View\Model\JsonModel
     */
    public function generateResponse(array $data)
    {
        $this->getServiceLocator()->get('response')->setStatusCode('200');

        return new JsonModel(
            array(
                'code'    => '200',
                'errors'  => array(
                    'application' => 'No error'
                ),
                'response' => $data
            )
        );
    }
}
