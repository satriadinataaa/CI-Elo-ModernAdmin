<?php  

class Admin extends MY_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->module = 'Admin';
	}

	public function index()
	{
		$this->data['title'] 	= 'home';
        $this->data['content'] 	= 'index';
        $this->template($this->data, $this->module);
	}
}