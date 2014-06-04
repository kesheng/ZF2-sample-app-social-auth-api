<?php
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Http\Request as HttpRequest;

class Module
{
    public function onBootstrap($event)
    {
        // add timezone
        date_default_timezone_set("UTC");

        // Configuration
        $configuration = $event->getApplication()->getServiceManager()->get('Configuration');

        // Events
        $eventManager = $event->getTarget()->getEventManager();

        // set controller and action name
        $eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchErrorLog'));
        $eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER, array($this, 'onRenderError'));

        // Session
        $this->onBootstrapSession($configuration['session']);
    }


    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }


    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }


     /**
     * On bootstrap create session
     *
     * @param array $configuration
     * @return void
     */
    public function onBootstrapSession($configuration)
    {
        $sessionConfig = new \Zend\Session\Config\SessionConfig();
        $sessionConfig->setOptions($configuration);

        $sessionManager = new \Zend\Session\SessionManager($sessionConfig);
        $sessionManager->start();
    }


    public function onDispatchErrorLog(\Zend\Mvc\MvcEvent $event)
    {
        if ($event->getError() === 'error-exception') {
            $exception = $event->getParam('exception');

            $event->getApplication()->getServiceManager()->get('Zend\Log\Logger')->crit($exception);
        }
    }


    public function onRenderError($event)
    {
        if ($event->isError() === false) {
            return;
        }


        // If we have a JsonModel in the result, then do nothing
        $currentModel = $event->getResult();
        if ($currentModel instanceof \Zend\View\Model\JsonModel) {
            return;
        }


        // create a new JsonModel - use application/api-problem+jsonService fields.
        $response = $event->getResponse();
        $model = new \Zend\View\Model\JsonModel(
            array(
                "code"     => (string) $response->getStatusCode(),
                "errors"   => array(
                    'application' => $response->getReasonPhrase()
                ),
                "response" => array(
                    'action' => $response->getReasonPhrase()
                ),
            )
        );


        // Change error text
        /** @var \Exception $exception */
        $exception = $currentModel->getVariable('exception');

        $reason = $currentModel->getVariable('reason');
        if ($currentModel instanceof \Zend\View\Model\ModelInterface && $reason) {
            switch ($reason) {
                case 'error-controller-cannot-dispatch':
                    $model->setVariable(
                        'error',
                        array(
                            'application' => 'The requested controller was unable to dispatch the request.'
                        )
                    );
                    break;
                case 'error-controller-not-found':
                    $model->setVariable(
                        'error',
                        array(
                            'application' => 'The requested controller could not be mapped to an existing controller class.'
                        )
                    );
                    break;
                case 'error-controller-invalid':
                    $model->setVariable(
                        'error',
                        array(
                            'application' => 'The requested controller was not dispatchable.'
                        )
                    );
                    break;
                case 'error-router-no-match':
                    $model->setVariable(
                        'error',
                        array(
                            'application' => 'The requested URL could not be matched by routing.'
                        )
                    );
                    break;
                default:
                    $model->setVariable(
                        'error',
                        array(
                            'application' => $currentModel->getVariable('message')
                        )
                    );
                    break;
            }
        }



        if ($exception) {
            if ($exception->getCode() > 300 && $exception->getCode() < 500) {
                $response->setStatusCode($exception->getCode());
            }

            $model->setVariable(
                'exception',
                array(
                    'message' => $exception->getMessage(),
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine()
                )
            );


            $stack = array();
            while ($exception = $exception->getPrevious()) {
                $stack[] = $exception->getMessage();
            };

            if (count($stack)) {
                $errors = $model->getVariable('errors');
                $errors['stack'] = $stack;

                $model->setVariable('errors', $stack);
            }
        }

        $model->setTerminal(true);
        $event->setResult($model);
        $event->setViewModel($model);
    }


    /*
    public function onRenderError(\Zend\Mvc\MvcEvent $event)
    {
        if ($event->isError() === false) {
            return;
        }

        $currentModel = $event->getResult();
        $exception = $currentModel->getVariable('exception');

        $errors = array();
        if ($exception) {
            $errors['exception'] = array(
                'message' => $exception->getMessage(),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine()
            );

            $stack = array();
            while ($exception = $exception->getPrevious()) {
                $stack[] = $exception->getMessage();
            };

            if (count($stack)) {
                $errors['stack'] = $stack;
            }
        }
       
        // redirect to exception page
        $url = $event->getRouter()->assemble(array('action' => 'login'), array('name' => 'frontend'));
        
        $response = $event->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(500);
        $response->sendHeaders();

        var_dump(get_class_methods($response));exit;
    }*/


    public function onDispatchAuthenticate($event)
    {
        $authenticationRes = $event->getMessages();
        $authenticationMessage = strtolower(str_replace(' ', '', $authenticationRes[0]));
        if ($authenticationMessage === 'authenticationsuccessful.') {
            // add anything after autherntication

        }
    }


    public function getControllerPluginConfig()
    {
        return array(
            'factories' => array(
                'authenticationHelper' => function ($serviceManager) {
                    return new Controller\Plugin\AuthenticationHelper(
                        $serviceManager->getServiceLocator()->get('zfcuser_auth_service')
                    );
                },
            ),
        );
    }


    /*public function onFinish(\Zend\Mvc\MvcEvent $event)
    {
        $app        = $event->getTarget();
        $match      = $app->getMvcEvent()->getRouteMatch();
        $controller = $match->getParam('controller');
        $action     = $match->getParam('action');

        if($controller == 'ScnSocialAuth-User' && ($action == 'logout')){
            //$session = new \Zend\Session\Container('***');
            //$session->getManager()->destroy();
        }
    }*/
}