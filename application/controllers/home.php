<?php 

class Home extends CI_Controller{	

	public function __construct(){

		parent::__construct();
		$this->load->database();
	
		$this->load->library('grocery_CRUD');

	}

	public function home_sisten(){

		$this->template->load('home','templates/view_home');
	}

	public function solicitacaoSistema(){

		$this->template->load('home','templates/view_frm_solicitacao_sis');
	}

	public function solicitacaoEquipamento(){
		try{
			$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
			$crud = new grocery_CRUD();
			
			$crud->set_theme('datatables');
			$crud->set_table('user');
			$crud->columns('nome','login');
			
			$output = $crud->render();

			$this->load->view('templates/view_frm_solicitacao_equi',$output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}


		
	}




}
	

 ?>