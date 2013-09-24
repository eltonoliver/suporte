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
			$crud->set_relation('id_suporte','usuarios','nome');
			$crud->set_relation('situacao_id','situacao','nome');	
			$crud->set_relation('prioridade_id','prioridade','nome');	
			$crud->set_relation('patrimonio_id','prioridade','nome');
			$crud->set_relation('sistemas_id','sistemas','nome');
			$crud->set_relation('local_servico','db_base.unidade_uni','uni_nomecompleto');	
			$crud->unset_edit_fields('data_atualizacao','data_finalizacao','tipo');	
			$crud->unset_add_fields('data_atualizacao','data_finalizacao','tipo');	
			$crud->columns('id','usuario_id','data_solicitacao','situacao_id','id_suporte','tipo');
			$crud->callback_column('tipo',array($this,'tipo_callback'));
			$crud->display_as('id','Código')->display_as('id_suporte','Nome do Suporte')
				 ->display_as('situacao_id','Situação')
				 ->display_as('data_solicitacao','Data de Solicitação')
				 ->display_as('usuario_id','Nome do usuário');

			$crud->unset_print();		 
			$output = $crud->render();

			$this->template->load('home','templates/view_atendimento',$output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());

		}
	}


	public function tipo_callback($value,$row){
		if($row->tipo == 1){

			$value = "Equipamentos";

		}else{

			$value = "Sistemas";
		}

		return $value;

	}





}


?>
