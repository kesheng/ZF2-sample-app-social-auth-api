<?php

namespace Application\Controller;

use Zend\View\Model\JsonModel;
use Zend\Stdlib\Parameters;

class SessionController extends \ZfcUser\Controller\UserController
{
    /**
     * @var Application\Service\Json
     */
    protected $jsonService;

    /**
     * @var Application\Service\User
     */
    protected $userService;



    /**
     * No option action
     */
    public function noopAction()
    {
        return new JsonModel();
    }



    /**
     * User page
     */
    public function indexAction()
    {
        if ($this->zfcUserAuthentication()->hasIdentity() === true) {
            $this->getResponse()->setStatusCode(200);
            return new JsonModel(
                $this->getFilteredSession()
            );
        } else {
            $this->getResponse()->setStatusCode(401); // Not found
            return new JsonModel(
                array(
                    'id' => null
                )
            );
        }
    }


    public function loginAction()
    {
        if ($this->zfcUserAuthentication()->getAuthService()->hasIdentity()) {
            return $this->processLoginRedirect();
        }

        $this->userService = $this->getServiceLocator()->get('Application\Service\User');
        $this->jsonService = $this->getServiceLocator()->get('Application\Service\Json');

        $request = $this->getRequest();
        $post = $request->getPost()->toArray();

        if (!isset($post['identity']) || !isset($post['credential'])) {
            return $this->jsonService->generateError('Login form invalid');
        } 

        //$request->setPost(new Parameters($post));


        $this->zfcUserAuthentication()->getAuthAdapter()->resetAdapters();
        $this->zfcUserAuthentication()->getAuthService()->clearIdentity();

        return $this->forward()->dispatch(static::CONTROLLER_NAME, array('action' => 'authenticate'));
    }


    public function registerAction()
    {
        if ($this->zfcUserAuthentication()->getAuthService()->hasIdentity()) {
            return $this->processLoginRedirect();
        }

        $this->userService = $this->getServiceLocator()->get('Application\Service\User');
        $this->jsonService = $this->getServiceLocator()->get('Application\Service\Json');

        $request = $this->getRequest();
        $post = $request->getPost()->toArray();
        $user = $this->userService->register($post);

        if (!$user) {
            return $this->jsonService->generateError('User reigister fail');
        }

        if ($this->userService->getOptions()->getLoginAfterRegistration()) {
            $identityFields = $this->userService->getOptions()->getAuthIdentityFields();
            if (in_array('email', $identityFields)) {
                $post['identity'] = $user->getEmail();
            } elseif (in_array('username', $identityFields)) {
                $post['identity'] = $user->getUsername();
            }
            $post['credential'] = $post['password'];
            $request->setPost(new Parameters($post));

            return $this->forward()->dispatch(static::CONTROLLER_NAME, array('action' => 'authenticate'));
        }

        return $this->jsonService->generateError('Fail to regeister');
    }



    public function logoutAction()
    {
        $this->jsonService = $this->getServiceLocator()->get('Application\Service\Json');

        $this->zfcUserAuthentication()->getAuthAdapter()->resetAdapters();
        $this->zfcUserAuthentication()->getAuthAdapter()->logoutAdapters();
        $this->zfcUserAuthentication()->getAuthService()->clearIdentity();

        $redirect = $this->params()->fromPost('redirect', $this->params()->fromQuery('redirect', false));

        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $redirect) {
            return $this->redirect()->toUrl($redirect);
        }


        return $this->jsonService->generateResponse(array('success' => 1));
    }



    public function authenticateAction()
    {
        if ($this->zfcUserAuthentication()->getAuthService()->hasIdentity()) {
            return $this->processLoginRedirect();
        }

        $adapter = $this->zfcUserAuthentication()->getAuthAdapter();
        $redirect = $this->params()->fromPost('redirect', $this->params()->fromQuery('redirect', false));

        $result = $adapter->prepareForAuthentication($this->getRequest());

        // Return early if an adapter returned a response
        if ($result instanceof Response) {
            return $result;
        }

        $auth = $this->zfcUserAuthentication()->getAuthService()->authenticate($adapter);

        if (!$auth->isValid()) {
            $this->flashMessenger()->setNamespace('zfcuser-login-form')->addMessage($this->failedLoginMessage);
            $adapter->resetAdapters();
            return $this->redirect()->toUrl($this->url()->fromRoute(static::ROUTE_LOGIN)
                . ($redirect ? '?redirect='.$redirect : ''));
        }

        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $redirect) {
            return $this->redirect()->toUrl($redirect);
        }


        return $this->processLoginRedirect();
    }



    /**
     * Allow processing internal and external routes
     */
    protected function processLoginRedirect()
    {
        $route = $this->getOptions()->getLoginRedirectRoute();

        if (substr($route, 0, 4) === 'http') {
            return $this->redirect()->toUrl($route);
        } else {
            return $this->redirect()->toRoute($route);
        }
    }



    /**
     * Get a reduced session object
     *
     * @return array
     */
    protected function getFilteredSession()
    {
        $session = $this->zfcUserAuthentication()->getIdentity()->getArrayCopy();

        $whitelist = array('id', 'firstName', 'lastName', 'email', 'visibility', 'role', 'photo');
        foreach ($session as $key => $value) {
            if (in_array($key, $whitelist) === false) {
                unset($session[$key]);
            }
        }

        // TODO: Replace with ZF2 method
        $session['session_id'] = session_id();


        return $session;
    }
}


