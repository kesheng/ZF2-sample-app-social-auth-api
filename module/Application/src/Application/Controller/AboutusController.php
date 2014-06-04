<?php
namespace Application\Controller;

use Sglib\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\EventManager\EventManagerInterface;


class AboutusController extends AbstractActionController
{
    protected $aboutusService;


    public function indexAction()
    {
        return new ViewModel(array());
    }


    public function getAboutusService()
    {
        if (empty($this->aboutusService) === true) {
            $this->aboutusService = $this->getServiceLocator()->get('Application\Service\Aboutus');
        }

        return $this->aboutusService;
    }


    public function setAboutusService($aboutusService)
    {
        $this->aboutusService = $aboutusService;

        return $this;
    }
}