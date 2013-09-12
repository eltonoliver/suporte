<?php 

class Home extends CI_Controller{	

	public function __construct(){

		parent::__construct();

	}

	public function home_sisten(){

		$this->template->load('home','templates/view_home');
	}


}
	

 ?>