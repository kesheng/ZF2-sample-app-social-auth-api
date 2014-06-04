<?php
namespace Application\Controller;

use Sglib\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\EventManager\EventManagerInterface;


class ContactusController extends AbstractActionController
{
    protected $contactusForm;


    public function indexAction()
    {
        $form = $this->getContactusForm();

        $inputFilter = $form->getInputFilter();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost()->toArray();
            $form->setData($data);

            if ($form->isValid()) {
                // mail function in here
            }
        }
        return array('form' => $form);
    }


    public function getContactusForm()
    {
        if (empty($this->contactusForm) === true) {
            $this->contactusForm = $this->getServiceLocator()->get('Application\Form\ContactusForm');
        }

        return $this->contactusForm;
    }


    public function setContactusForm($contactusForm)
    {
        $this->contactusForm = $contactusForm;

        return $this;
    }
}