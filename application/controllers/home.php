<?php ob_start(); ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{	

	public $sessionUsuario;
	public $sessionNome;
	public $idSuporte;

	public function __construct(){

		parent::__construct();
		session_start();
		$this->load->library('grocery_CRUD');
		$this->load->model('solicitacao_model');
		//SIMULACAO DO ID DO USUÁRIO
		$sess_codusuario = isset($_SESSION['sess_codusuario']) ? $sess_codusuario = $_SESSION['sess_codusuario'] : $sess_codusuario = "";
		$sess_nomeusuario = isset($_SESSION['sess_nomeusuario']) ? $sess_nomeusuario = $_SESSION['sess_nomeusuario'] : $sess_nomeusuario = "";
		$this->session->set_userdata('usuario_id', $sess_codusuario);
		$this->session->set_userdata('login', $sess_nomeusuario);
		$this->sessionLogin = $this->session->userdata('login');
		$this->sessionUsuario =  $this->session->userdata('usuario_id');

		$dados = $this->solicitacao_model->getSuporte($this->sessionLogin);
		/*************
		*CASO O USUÁRIO SEJA UM ADMINISTRADOR , O ID DELE DE SUPORTE FICARA NA SESSAO
		*
		**************/
		foreach ($dados as $value) {
			if($this->sessionLogin === $value->nome){
				$this->session->set_userdata('suporte_id',$value->id);
				$this->idSuporte = $this->session->userdata('suporte_id');
			}
		}
		//$this->session->sess_destroy();

		if(!$this->session->userdata('usuario_id')){

			redirect('http://portalsenac.am.senac.br/');

			}
	}
	
	public function home_sisten(){
		
		$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
		echo "Nome = ".$_SESSION['sess_nomeusuario']." ID suporte".$this->idSuporte ;
		$this->template->load('home','templates/view_home',$output);
	}


	public function solicitacaoEquipamento($id = null){
		try{
			
			$crud = new grocery_CRUD();			
			$crud->set_theme('flexigrid');
			$crud->set_table('solicitacao');	
			/*set_relation('capodatabela','tabela_relacionada','chave estrangeira')*/

			$crud->set_relation('local_servico','db_base.unidade_uni','uni_nomecompleto');
			$crud->set_relation('patrimonio_id','patrimonio','patrimonio');
			$crud->fields('patrimonio_id','descricao_equi','anexo','descricao_servico','local_servico','data_solicitacao','tipo','usuario_id');
			$crud->display_as('patrimonio_id','Patrimônio')
				 ->display_as('descricao_equi','Descrição do Equipamento')
				 ->display_as('anexo','Anexo')
				 ->display_as('descricao_servico','Descrição do Serviço')
				 ->display_as('local_servico','Local do Serviço');
			/*Deixa o campo data_solicitacao invisivel*/	 
			$crud->field_type('data_solicitacao','invisible');
			$crud->field_type('usuario_id', 'hidden', $this->sessionUsuario);
			$crud->field_type('tipo', 'hidden',1);
			$crud->required_fields('descricao_equi','descricao_servico','patrimonio');
			
			$crud->set_subject('Solicitação - Equipamentos');
			
			$crud->unset_back_to_list();
			/*Insere a data de solicitação automaticamente via callback*/
			$crud->callback_before_insert(array($this,'data_solicitacao_callback'));
			
			$crud->set_field_upload('anexo','assets/arquivos/anexo/solicitacao_equi');
			$output = $crud->render();
			$this->template->load('home','templates/view_frm_solicitacao_equi',$output);

		}catch(Exception $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
		
	}

	public function solcicitacaoSistema($id = null){
		try{
			
			$crud = new grocery_CRUD();		

			$crud->set_theme('flexigrid');
			$crud->set_table('solicitacao');	
			/*set_relation('capodatabela','tabela_relacionada','chave estrangeira')*/
			$crud->set_relation('local_servico','db_base.unidade_uni','uni_nomecompleto');
			$crud->set_relation('sistemas_id','sistemas','nome');
			$crud->fields('sistemas_id','anexo','descricao_servico','local_servico','data_solicitacao','tipo','usuario_id');
			$crud->display_as('sistemas_id','Sistema')
				 ->display_as('anexo','Anexo')
				 ->display_as('descricao_servico','Descrição do Serviço')
				 ->display_as('local_servico','Local do Serviço');
			/*Deixa o campo data_solicitacao invisivel*/	 
			$crud->field_type('data_solicitacao','invisible');
			$crud->field_type('usuario_id', 'hidden', $this->sessionUsuario);
			$crud->field_type('tipo', 'hidden',2);
			$crud->required_fields('descricao_equi','descricao_servico','patrimonio');
						
			$crud->set_subject('Solicitação - Sistemas');
			
			$crud->unset_back_to_list();
			/*Insere a data de solicitação automaticamente via callback*/
			$crud->callback_before_insert(array($this,'data_solicitacao_callback'));
			$crud->set_field_upload('anexo','assets/arquivos/anexo/solicitacao_equi');
			$output = $crud->render();
			$this->template->load('home','templates/view_frm_solicitacao_equi',$output);

		}catch(Exception $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}

	}

	public function minhasSolicitacoes($id = null){
		try{

			$crud = new grocery_CRUD();		
			$crud->set_crud_url_path(site_url('home/minhasSolicitacoes'));
			$crud->set_theme('datatables');
			$crud->set_table('solicitacao');
			$crud->where('usuario_id',$this->sessionUsuario);
			$crud->columns('id','local_servico','data_solicitacao','situacao_id','id_suporte');


			/*RELACIONAMENTO EQUIPAMENTO*/
			$crud->set_relation('local_servico','db_base.unidade_uni','uni_nomecompleto');
			$crud->set_relation('patrimonio_id','patrimonio','patrimonio');
			$crud->set_relation('id_suporte','usuarios','nome');
			$crud->set_relation('situacao_id','situacao','nome');
			/*EQUIPAMENTO*/
			/*RELACIONAMENTO SISTEMAS*/
			
			$crud->set_relation('local_servico','db_base.unidade_uni','uni_nomecompleto');
			$crud->set_relation('sistemas_id','sistemas','nome');
			/*SISTEMAS*/
			
						
			$crud->display_as('id','Código')
				 ->display_as('situacao_id','Situação')
				 ->display_as('id_suporte','Nome do Suporte')
				 ->display_as('data_solicitacao','Data de Solicitação')
				 ->display_as('local_servico','Local do Serviço');


			/*ACTION - TELA DO FORUM*/
			$crud->add_action('Adicionar Mensagem', '', 'home/mensagem','ui-icon-plus');

			/*REMOVAR OPÇÃO DE DELETAR LER E EDITAR*/
			//$crud->unset_delete();
			$crud->unset_read();
			$crud->unset_edit();
			$crud->unset_add();
			$crud->unset_print();	 
			$output = $crud->render();
			
			
			$this->template->load('home','templates/view_solicitacoes',$output);


		}catch(Exception $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}


	}

	public function mensagem($id = null){
		
		try{
			$crud = new grocery_CRUD();
			$crud->set_table('forum');

			$crud->set_crud_url_path(site_url('home/mensagem'));
			$crud->set_theme('datatables');
			 $crud->callback_after_insert(array($this, 'mensagem_insert'));
			$output = $crud->render();
			
			$this->template->load('home','templates/view_mensagem',$output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}		
	}

	
	/*
	*@method - data_solicitacao_callback 
	*Esse método so podera ser utilizado caso o campo esteja como invisible
	*@return retorna um array modificado
	*/

	public function data_solicitacao_callback($postArray) {
		  	
		  $postArray['data_solicitacao'] = date('Y-m-d h:i:s');
		  return $postArray;
	}


	function mensagem_insert($postArray){	  	
 		

		$msg = '
			<div class="alert alert-success">
				 <button type="button" class="close" data-dismiss="alert">×</button>
 					Mensagem Enviada..
			</div>
		';
 		$this->session->set_flashdata('msg', $msg); 		
    	redirect('home/mensagem/'.$postArray['solicitacao_id']);
	}


}
	

 ?>