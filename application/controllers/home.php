<?php 

class Home extends CI_Controller{	

	public function __construct(){

		parent::__construct();
		$this->load->database();
	
		$this->load->library('grocery_CRUD');

	}

	public function home_sisten(){

		$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
		$this->template->load('home','templates/view_home',$output);
	}

	public function solicitacaoSistema(){

		$this->template->load('home','templates/view_frm_solicitacao_sis');
	}

	public function solicitacaoEquipamento(){
		try{
			
			$crud = new grocery_CRUD();			
			$crud->set_theme('datatables');
			$crud->set_table('user');
			$crud->columns('nome','login');			
			$output = $crud->render();
			$this->template->load('home','templates/view_frm_solicitacao_equi',$output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
		
	}


}
	

 ?>