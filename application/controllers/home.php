<?php 

class Home extends CI_Controller{	

	public function __construct(){

		parent::__construct();

	}

	public function home_sisten(){

		$this->template->load('home','templates/view_home');
	}

	public function solicitacaoSistema(){

		$this->template->load('home','templates/view_frm_solicitacao_sis');
	}

	public function solicitacaoEquipamento(){

		$this->template->load('home','templates/view_frm_solicitacao_equi');
	}


}
	

 ?>