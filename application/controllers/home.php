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
			$crud->set_theme('flexigrid');
			$crud->set_table('solicitacao_equi');
			$crud->set_relation('suporte_id','usuarios','nome');
			$crud->set_relation('prioridade_id','prioridade','nome');
			$crud->set_relation('situacao_id','situacao','nome');

			$crud->field_type('data_solicitacao', 'date');
			$crud->set_subject('Solicitação');			
			$crud->set_field_upload('anexo','assets/arquivos/anexo_solicitacao');
			$output = $crud->render();
			$this->template->load('home','templates/view_frm_solicitacao_equi',$output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
		
	}


}
	

 ?>