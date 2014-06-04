<?php

namespace Application\Service;

use Sglib\Service\AbstractService;

class Contactus extends AbstractService
{
	protected $contactusForm;

	

    public function getApplicationForm()
    {
        return $this->contactusForm;
    }

    public function setApplicationForm($contactusForm)
    {
        $this->contactusForm = $contactusForm;

        return $this;
    }
}
