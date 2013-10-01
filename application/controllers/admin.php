<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller{	

	public function __construct(){

		parent::__construct();		
		$this->load->library('grocery_CRUD');
		$this->load->model('solicitacao_model');

	}


	public function atendimentos($id = null){

	  try{	
			
			$crud = new grocery_CRUD();
			$crud->set_crud_url_path(site_url('admin/atendimentos'));
			$crud->set_theme('datatables');
			$crud->set_table('solicitacao');
				 
			$crud->set_relation('id_suporte','usuarios','nome');
			$crud->set_relation('situacao_id','situacao','nome');	
			$crud->set_relation('prioridade_id','prioridade','nome');	
			$crud->set_relation('patrimonio_id','db_gde.equipamento_equi','equi_descricao');
			$crud->set_relation('sistemas_id','sistemas','nome');
			$crud->set_relation('usuario_id','db_base.usuario_usu','usu_nomeusuario');
			$crud->set_relation('local_servico','db_base.unidade_uni','uni_nomecompleto');
			
			$crud->columns('id','usuario_id','data_solicitacao','situacao_id','id_suporte','tipo');

			$crud->callback_column('tipo',array($this,'tipo_callback'));

			
			$crud->display_as('id','Código')
				 ->display_as('id_suporte','Nome do Suporte')
				 ->display_as('situacao_id','Situação')
				 ->display_as('data_solicitacao','Data de Solicitação')
				 ->display_as('usuario_id','Nome do usuário')
				 ->display_as('descricao_equi','Descrição do Equipamento')
				 ->display_as('descricao_servico','Descrição do Serviço')
				 ->display_as('local_servico','Local do Serviço')
				 ->display_as('prioridade_id','Prioridade')
				 ->display_as('sistemas_id','Nome do Sistema')
				 ->display_as('patrimonio_id','Patrimônio');
			$crud->order_by('situacao_id','desc');
			$crud->set_field_upload('anexo','assets/arquivos/anexo/solicitacao_equi');
			$crud->callback_field('data_solicitacao',array($this,'formatData'));
			$crud->field_type('id','readonly');
			$crud->unset_back_to_list();	 
			$crud->unset_print();
			$crud->unset_add();
			$crud->unset_delete();
			
			/*STATE*/
			
			$state = $crud->getState();
    		$state_info = $crud->getStateInfo();
    		if($state == 'read'){

    			$idSolicitacao = $state_info->primary_key;
    			$tipo = $this->solicitacao_model->getTipoSolicitacao($idSolicitacao);

    			foreach ($tipo as $value) {
        			if($value->tipo == 2){
        				
        				$crud->fields('id','descricao_servico','anexo','data_solicitacao','situacao_id','id_suporte','sistemas_id');        				

        			}else{
        				$crud->fields('id','local_servico','anexo','descricao_equi','descricao_servico','patrimonio_id','data_solicitacao','situacao_id','id_suporte');
        			}
        		}

    		}elseif($state == 'edit'){
    				$idSolicitacao = $state_info->primary_key;
    			$tipo = $this->solicitacao_model->getTipoSolicitacao($idSolicitacao);

    			foreach ($tipo as $value) {
        			if($value->tipo == 2 || $value->tipo == 1 ){
        				
        				$crud->edit_fields('id','id_suporte');   				

        			}
        		}
    		}
    		/*END STATE*/

    		/*ACTIONS*/
    		
    		$crud->callback_after_update(array($this, 'msgUpdate'));
    		//$crud->callback_column('Mensagem',array($this,'callback_forum'));
    		$crud->add_action('Assumir Atendimento', '', 'admin/assumirAtendimento','ui-icon ui-icon-circle-check');

    		
    		/*END ACTIONS*/	
			
			$output = $crud->render();

			$this->template->load('home','templates/view_atendimento',$output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());

		}
	}

	/*CADASTRAR USUÁRIOS*/

	public function cadastrarUsuarios(){
		try{

			$crud = new grocery_CRUD();
			$crud->set_crud_url_path(site_url('admin/cadastrarUsuarios'));
			$crud->set_theme('datatables');
			$crud->set_table('usuarios');
			$crud->columns('id','nome','login','email','status_id');
			//$crud->add_fields('nome','login','cargo','email');
			//$crud->edit_fields('nome','login','cargo','email');
			$crud->field_type('status_id', 'hidden', 1);

			$crud->display_as('nome','Nome')
				 ->display_as('login','Login')
				 ->display_as('email','E-mail');
			$crud->unset_print();	 
		    $crud->callback_column('status_id',array($this,'status_callback'));	
			$output = $crud->render();

			$this->template->load('home','templates/view_frm_usuarios',$output);
		}catch(Exception $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());	

		}
		

	}
	/*CADASTRO DE DÚVIDAS*/

	public function cadastrarDuvidas(){
		try{

			$crud = new grocery_CRUD();
			$crud->set_crud_url_path(site_url('admin/cadastrarDuvidas'));
			$crud->set_theme('datatables');
			$crud->set_table('duvidas');
			$crud->columns('id','titulo','conteudo');
			

			$crud->display_as('titulo','Título')
				 ->display_as('conteudo','Conteúdo');
				 
			$crud->unset_print();	 
		    $crud->callback_column('status_id',array($this,'status_callback'));	
			$output = $crud->render();

			$this->template->load('home','templates/view_frm_usuarios',$output);
		}catch(Exception $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());	

		}
		

	}


	public function relatorio(){
		try{
			
			$crud = new grocery_CRUD();		

			$crud->set_theme('flexigrid');
			$crud->set_table('solicitacao');	
			/*set_relation('capodatabela','tabela_relacionada','chave estrangeira')*/
			$crud->set_relation('local_servico','db_base.unidade_uni','uni_nomecompleto');
			$crud->set_relation('sistemas_id','sistemas','nome');
			$crud->set_relation('patrimonio_id','patrimonio','patrimonio');


			$crud->columns('id','id_suporte','tipo','sistemas_id','patrimonio_id','local_servico','data_solicitacao','data_finalizacao','usuario_id');
			$crud->display_as('sistemas_id','Sistema')
				 ->display_as('anexo','Anexo')
				 ->display_as('descricao_servico','Descrição do Serviço')
				 ->display_as('local_servico','Local do Serviço')
				 ->display_as('descricao_equi','Descrição do Equipamento')
				 ->display_as('id','Código')
				 ->display_as('usuario_id','Usuário');

			
						
			$crud->set_subject('Relatório - Atendimentos');
			$crud->unset_edit();
			$crud->unset_add();
			$crud->unset_delete();
			$crud->unset_read();
			$crud->unset_back_to_list();
			/*Insere a data de solicitação automaticamente via callback*/
			$crud->callback_column('tipo',array($this,'tipo_callback'));

			$output = $crud->render();
			$this->template->load('home','templates/view_relatorio',$output);

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

	/*VERIFICA AO LISTAR OS DADOS*/
	public function status_callback($value,$row){
		if($row->status_id == 1){

			$value = "Ativo";

		}else{

			$value = "Inativo";
		}

		return $value;

	}

	/*CALLBACK ASSUMIR ATENDIMENTO*/

	public function assumirAtendimento($id = null){
		try{
			$dados = array('id_suporte' => $this->session->userdata('suporte_id'));
			if(!$this->solicitacao_model->update($id,$dados)){

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


	/*CALLBACK MSG DE UPDATE*/
	public function msgUpdate($post_array,$primary_key){
    	
    	$dados = array('data_atualizacao' => date('Y-m-d h:i:s'));
    	$this->solicitacao_model->update($primary_key,$dados);	

 		$msg = '
				<div class="alert alert-success">
					 <button type="button" class="close" data-dismiss="alert">×</button>
 						Dados Atualizados! <a href="'.base_url().'admin/atendimentos/">Voltar para lista </a> 
				</div>';

		$this->session->set_flashdata('msg', $msg); 		
    	redirect('admin/atendimentos/edit/'.$primary_key);
	}

	/*CALLBACK EDIT SITUAÇÃO*/
	public function callback_forum($value,$row){
		$id = $row->id;
		$query = $this->solicitacao_model->getMensagemForum($id);
		if($query){

			return '<a href="'.base_url().'home/mensagem/'.$id.'">Ativo</a>';
		}else{

			return '';
		}

	}	

	
	/*FORMATAÇÃO DAS DATAS*/
	public function formatData($value, $primary_key = null){
		return formatDataBrasil($value);
	}



 


}


?>
