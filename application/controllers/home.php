<?php 

class Home extends CI_Controller{	

	public function __construct(){

		parent::__construct();
		//$this->load->database();	
		$this->load->library('grocery_CRUD');

	}
	
	public function home_sisten(){

		$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
		$this->template->load('home','templates/view_home',$output);
	}

	public function solicitacaoSistema(){

		$this->template->load('home','templates/view_frm_solicitacao_sis');
	}

	public function solicitacaoEquipamento($id = null){
		try{
			
			$crud = new grocery_CRUD();			
			$crud->set_theme('flexigrid');
			$crud->set_table('solicitacao_equi');	
			$crud->set_relation('local_servico','db_base.unidade_uni','uni_nomecompleto');	
			$crud->fields('patrimonio','descricao_equi','anexo','descricao_servico','local_servico');
			$crud->display_as('patrimonio','Patrimônio:')
				 ->display_as('descricao_equi','Descrição Equipamento:')
				 ->display_as('anexo','Anexo:')
				 ->display_as('descricao_servico','Descrição Serviço:')
				 ->display_as('local_servico','Local do Serviço:');
			
			$crud->required_fields('descricao_equi','descricao_servico','patrimonio');
			$crud->field_type('data_solicitacao', 'date');
			$crud->set_subject('Solicitação');
			$crud->callback_before_insert(array($this,'data_solicitacao'));
			$crud->set_field_upload('anexo','assets/arquivos/anexo/solicitacao_equi');
			$output = $crud->render();
			$this->template->load('home','templates/view_frm_solicitacao_equi',$output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
		
	}

	public function solcicitacaoSistema(){


	}

	function data_solicitacao($dados = null) {
		
		  $dataSolicitcao['data_solicitacao'] = '2013-09-19 00:00:00';	 
		  return $post_array;
	}    


}
	

 ?>