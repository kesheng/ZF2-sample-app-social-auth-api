<?php
namespace Application\Form;

use Zend\Form\Form;

class ContactusForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('Contactus');

        $this->add(array(
            'name' => 'txtName',
            'type' => 'Text',
            'options' => array(
                'label' => '姓名：',
            ),
        ));
        $this->add(array(
            'name' => 'txtPhone',
            'type' => 'Text',
            'options' => array(
                'label' => '手机：',
            ),
        ));
        $this->add(array(
            'name' => 'txtEmail',
            'type' => 'Text',
            'options' => array(
                'label' => '邮箱：',
            ),
        ));
        $this->add(array(
            'name' => 'txtQqNumber',
            'type' => 'Text',
            'options' => array(
                'label' => 'QQ：',
            ),
        ));
        $this->add(array(
            'name' => 'txtComment',
            'type' => 'Textarea',
            'options' => array(
                'label' => '信息填写：',
            ),
        ));
        $this->add(array(
            'type' => '\Zend\Form\Element\Csrf',
            'name' => 'csrf'
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'submit',
            ),
            'options' => array(
                'label' => '提交定单',
            ),
        ));
    }
}