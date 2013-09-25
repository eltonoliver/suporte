<?php

class Admin extends CI_Controller{	



	public function __construct(){

		parent::__construct();		
		$this->load->library('grocery_CRUD');
		$this->load->model('solicitacao_model');

	}

	public function atendimentos(){
	  try{	
			//$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('solicitacao');
				 


			$crud->set_relation('id_suporte','usuarios','nome');
			$crud->set_relation('situacao_id','situacao','nome');	
			$crud->set_relation('prioridade_id','prioridade','nome');	
			$crud->set_relation('patrimonio_id','patrimonio','patrimonio');
			$crud->set_relation('sistemas_id','sistemas','nome');
			$crud->set_relation('local_servico','db_base.unidade_uni','uni_nomecompleto');	
			$crud->unset_edit_fields('data_atualizacao','data_finalizacao','tipo');	
			$crud->unset_add_fields('data_atualizacao','data_finalizacao','tipo');	
			$crud->columns('id','usuario_id','data_solicitacao','situacao_id','id_suporte','tipo');
			$crud->callback_column('tipo',array($this,'tipo_callback'));
			$crud->display_as('id','Código')->display_as('id_suporte','Nome do Suporte')
				 ->display_as('situacao_id','Situação')
				 ->display_as('data_solicitacao','Data de Solicitação')
				 ->display_as('usuario_id','Nome do usuário')
				 ->display_as('descricao_equi','Descrição do Equipamento')
				 ->display_as('descricao_servico','Descrição do Serviço')
				 ->display_as('local_servico','Local do Serviço')
				 ->display_as('prioridade_id','Prioridade')
				 ->display_as('sistemas_id','Nome do Sistema')
				 ->display_as('patrimonio_id','Patrimônio');
			$crud->set_field_upload('anexo','assets/arquivos/anexo/solicitacao_equi');	 
			$crud->unset_print();
			$crud->unset_add();
			$crud->unset_delete();
			$crud->unset_jquery();
			/*STATE*/
			$state = $crud->getState();
    		$state_info = $crud->getStateInfo();
			if($state == 'read' || $state == 'edit'){
				$crud->field_type('data_solicitacao', 'readonly');
				$crud->field_type('descricao_equi', 'readonly');
				$crud->field_type('descricao_servico', 'readonly');
				$crud->field_type('local_servico', 'readonly');
				$crud->field_type('usuario_id', 'readonly');





        		$idSolicitacao = $state_info->primary_key;
    			$tipo = $this->solicitacao_model->getTipoSolicitacao($idSolicitacao);
        		foreach ($tipo as $value) {
        			if($value->tipo == 2){
        				$crud->field_type('descricao_equi', 'hidden');

        			}else{
        				$crud->field_type('sistemas_id', 'invisible');
        			}
        		}
    		}
    		/*END STATE*/

    		/*ACTIONS*/

    		$crud->add_action('Assumir Atendimento', '', 'admin/assumirAtendimento','ui-icon ui-icon-circle-check');
    		/*END ACTIONS*/	
		
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

	/*CALLBACK ASSUMIR ATENDIMENTO*/

	public function assumirAtendimento($id = null){
		try{
			$dados = array('id_suporte' => $this->session->userdata('suporte_id'));
			if(!$this->solicitacao_model->assumir($id,$dados)){

				throw new Exception("Você já é responsável por este atendimento!");
				
			}

			$msg = '
				<div class="alert alert-success">
					 <button type="button" class="close" data-dismiss="alert">×</button>
 						Você assumiu este atendimento!
				</div>';
 				$this->session->set_flashdata('msg', $msg); 	
				redirect('admin/atendimentos/');
		}catch(Exception $e){

			

			$msg = '
				<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
  					'.$e->getMessage().'
				</div>
			';
			$this->session->set_flashdata('msg', $msg); 
			redirect('admin/atendimentos/');
		}

	}





}


?>
