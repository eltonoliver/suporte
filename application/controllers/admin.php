<?php

class Admin extends CI_Controller{	



	public function __construct(){

		parent::__construct();
		
		$this->load->library('grocery_CRUD');
		$this->load->model('solicitacao_model');

	}

	public function atendimentos(){
	  try{	
			$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('solicitacao');
			$crud->columns('id','usuario_id','data_solicitacao','situacao_id','id_suporte');
			$crud->display_as('id','Código');
			$output = $crud->render();


			$this->template->load('home','templates/view_atendimento',$output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());

		}
	}





}


?>
