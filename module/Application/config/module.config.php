<?php
namespace Application;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'aboutus' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/about[/]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Aboutus',
                        'action'     => 'index',
                    ),
                ),
            ),
            'contactus' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/contact[/]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Contactus',
                        'action'     => 'index',
                    ),
                ),
            ),

            'user' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/user',
                    'defaults' => array(
                        'controller' => 'Application\Controller\User',
                        'action'     => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'view' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/view',
                            'defaults' => array(
                                'action' => 'view'
                            ),
                        ),
                    ),
                ),
            ),

            // User Login
            'zfcuser' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/session',
                    'defaults' => array(
                        'controller' => 'zfcuser',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'login',
                            ),
                        ),
                    ),
                    'authenticate' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/authenticate',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'authenticate',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'logout',
                            ),
                        ),
                    ),
                    'register' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/register',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'register',
                            ),
                        ),
                    ),
                    'changepassword' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/change-password',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'changepassword',
                            ),
                        ),
                    ),
                    'changeemail' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/change-email',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'changeemail',
                            ),
                        ),
                    ),
                ),
            ),


            // Social Login
            'scn-social-auth-user' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'priority' => 2001,
                'options' => array(
                    'route' => '/session',
                    'defaults' => array(
                        'controller' => 'zfcuser',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // POST request
                    'register' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'child_routes' => array(
                            array(
                                'type' => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/register',
                                    'defaults' => array(
                                        'controller' => 'ScnSocialAuth-User',
                                        'action'     => 'register',
                                    ),
                                ),
                            ),
                        )
                    ),

                    // DELETE request
                    'logout' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'child_routes' => array(
                            array(
                                'type' => 'Zend\Mvc\Router\Http\Segment',
                                'options' => array(
                                    'route'    => '[/]',
                                    'defaults' => array(
                                        'action' => 'logout'
                                    ),
                                ),
                            ),
                        )
                    ),


                    'authenticate' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/authenticate',
                            'defaults' => array(
                                'action' => 'authenticate',
                            ),
                        ),
                    ),

                    'login' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action'     => 'login',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'provider' => array(
                                'type' => 'Zend\Mvc\Router\Http\Segment',
                                'options' => array(
                                    'route' => '/:provider',
                                    'constraints' => array(
                                        'provider' => '[a-zA-Z][a-zA-Z0-9_-]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'ScnSocialAuth-User',
                                        'action' => 'provider-login',
                                    ),
                                ),
                            ),
                        ),
                    ),

                    'add-provider' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/add-provider',
                            'defaults' => array(
                                'controller' => 'ScnSocialAuth-User',
                                'action'     => 'add-provider',
                            ),
                        ),
                        'child_routes' => array(
                            'provider' => array(
                                'type' => 'Zend\Mvc\Router\Http\Segment',
                                'options' => array(
                                    'route' => '/:provider',
                                    'constraints' => array(
                                        'provider' => '[a-zA-Z][a-zA-Z0-9_-]+',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    // Controller
    'controllers' => array(
        'invokables' => array(
            // Controller
            'zfcuser' => 'Application\Controller\SessionController',
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            //'Application\Controller\User' => 'Application\Controller\UserController',
            'Application\Controller\Aboutus' => 'Application\Controller\AboutusController',
            'Application\Controller\Contactus' => 'Application\Controller\ContactusController',
        ),

        'factories' => array(
            'Application\Controller\User' => function(\Zend\Mvc\Controller\ControllerManager $controllerManager) {
                $serviceLocator = $controllerManager->getServiceLocator();

                $controller = new \Application\Controller\UserController(
                    $serviceLocator->get('Application\Service\User'),
                    $serviceLocator->get('Application\Service\Json')
                );

                return $controller;
            }
        ),
    ),

    // Service
    'service_manager' => array(
        'factories' => array(
            // Authentication Adapters
            //'ScnSocialAuth\Authentication\Adapter\HybridAuth' => 'Application\Service\HybridAuthAdapterFactory',

            // Log
            /*'Zend\Log\Logger' => function($sm){
                $logger = new \Zend\Log\Logger;
                $writer = new \Zend\Log\Writer\Stream('./data/log/'.date('Y-m-d').'-error.log');

                $logger->addWriter($writer);

                return $logger;
            },*/

            // Services
            'Application\Service\User' => function (\Zend\ServiceManager\ServiceManager $serviceManager) {
                /** @var \Application\Service\Json $jsonService */
                $jsonService = $serviceManager->get('Application\Service\Json');

                /** @var \Doctrine\ORM\EntityManager $entityManager */
                $entityManager = $serviceManager->get('Doctrine\ORM\EntityManager');

                /** @var \Application\Repository\UserRepository $userRepository */
                $userRepository = $entityManager->getRepository('Application\Entity\User');

                return new \Application\Service\User(
                    $jsonService,
                    $userRepository
                );
            },
            'Application\Service\Aboutus' => function($serviceManager) {
                $service = new \Application\Service\Aboutus();

                return $service;
            },
            'Application\Service\Contactus' => function($serviceManager) {
                $service = new \Application\Service\Contactus();
                $service->setApplicationForm(
                    $serviceManager->get('Application\Form\ContactusForm')
                );

                return $service;
            },
            // Forms
            'Application\Form\ContactusForm' => function ($sm) {
                $inputFilter = $sm->get('Application\Entity\Contactus')->getInputFilter();
                $form = new \Application\Form\ContactusForm($sm);
                $form->setInputFilter($inputFilter);

                return $form;
            },
        ),
        'invokables' => array(
            // Overrides
            'zfcuser_user_service' => 'Application\Service\User',

            // Services
            'Application\Service\Json' => 'Application\Service\Json',

            // Entities
            'Application\Entity\User' => 'Application\Entity\User',
            'Application\Entity\Contactus' => 'Application\Entity\Contactus',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
            'zfcuser_doctrine_em' => 'Doctrine\ORM\EntityManager',
        ),
    ),

    // Translator
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),

    // View
    'view_manager' => array(
        'doctype'             => 'HTML5',
        'not_found_template'  => 'error/404',
        'exception_template'  => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'     => __DIR__ . '/../view/error/404.phtml',
            'error/index'   => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'template_map' => array(
            'scn-social-auth/user/login' => __DIR__ . '/../view/scn-social-auth/user/login.phtml',
            'scn-social-auth/user/register' => __DIR__ . '/../view/scn-social-auth/user/register.phtml',
        ),
    ),
    /*'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array(
            'scn-social-auth/user/login' => __DIR__ . '/../view/scn-social-auth/user/login.phtml',
            'scn-social-auth/user/register' => __DIR__ . '/../view/scn-social-auth/user/register.phtml',
        ),
    ),*/

    // Doctrine
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),

    // Session
    'session' => array(
        'save_path' => getcwd() . '/data/session/'
    ),

    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);