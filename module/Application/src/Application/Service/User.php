<?php

namespace Application\Service;

use Zend\Crypt\Password\Bcrypt;

class User extends \ZfcUser\Service\User
{
    /**
     * @var \Application\Service\Json
     */
    protected $jsonService;

    /**
     * @var \Application\Repository\UserRepository
     */
    protected $repository;


    public function __construct(
        \Application\Service\Json $jsonService,
        \Application\Repository\UserRepository $repository
    )
    {
        $this->setJsonService($jsonService);
        $this->setRepository($repository);
    }



    /**
     * Get user by username
     *
     * @param $username
     * @return \Zend\View\Model\JsonModel
     */
    public function getUserByUsername($username)
    {
        $user = $this->getRepository()->findOneBy(
            array('username' => $username)
        );

        if ($user instanceof \Application\Entity\User) {
            return $this->jsonService->generateUser($user);
        }

        return $this->jsonService->generateError('invalid user id', '403');
    }



    /**
     * Get user by id
     *
     * @param $userid
     * @return \Zend\View\Model\JsonModel
     */
    public function getUserByUserId($userid)
    {
        $user = $this->getRepository()->findOneBy(
            array('id' => $userid)
        );

        if ($user instanceof \Application\Entity\User) {
            return $this->jsonService->generateUser($user);
        }

        return $this->jsonService->generateError('invalid user id', '403');
    }



     /**
     * Rewrite register service for zfcuser
     *
     */
    public function register(array $data)
    {
        $class = $this->getOptions()->getUserEntityClass();
        $user  = new $class;
        $form  = $this->getRegisterForm();
        $form->setHydrator($this->getFormHydrator());
        $form->bind($user);
        $form->setData($data);
        if (!$form->isValid()) {
            return false;
        }

        $user = $form->getData();
        /* @var $user \ZfcUser\Entity\UserInterface */

        $bcrypt = new Bcrypt;
        $bcrypt->setCost($this->getOptions()->getPasswordCost());
        $user->setPassword($bcrypt->create($user->getPassword()));

        if ($this->getOptions()->getEnableUsername()) {
            $user->setUsername($data['username']);
        }
        if ($this->getOptions()->getEnableDisplayName()) {
            $user->setDisplayName($data['display_name']);
        }

        // If user state is enabled, set the default state value
        if ($this->getOptions()->getEnableUserState()) {
            if ($this->getOptions()->getDefaultUserState()) {
                $user->setState($this->getOptions()->getDefaultUserState());
            }
        }

        // Start to add customer fields
        if (isset($data['first_name'])) {
            $user->setFirstName($data['first_name']);
        }

        if (isset($data['last_name'])) {
            $user->setLastName($data['last_name']);
        }

        if (isset($data['photo'])) {
            $user->setPhoto($data['photo']);
        }
        // End to add customer fields


        $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $user, 'form' => $form));
        $this->getUserMapper()->insert($user);
        $this->getEventManager()->trigger(__FUNCTION__.'.post', $this, array('user' => $user, 'form' => $form));

        return $user;
    }




    /**
     * Set JSON service
     *
     * @param \Application\Service\Json $jsonService
     * @return self
     */
    public function setJsonService($jsonService)
    {
        $this->jsonService = $jsonService;

        return $this;
    }

    /**
     * Get JSON service
     *
     * @return \Application\Service\Json
     */
    public function getJsonService()
    {
        return $this->jsonService;
    }



    /**
     * Set repository
     *
     * @param \Application\Repository\UserRepository $repository
     * @return self
     */
    public function setRepository(\Application\Repository\UserRepository $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Get repository
     *
     * @return \Application\Repository\UserRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }
}
