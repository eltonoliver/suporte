<?php ob_start(); ?>
<?php session_start(); ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{	

	public $sessionUsuario;
	public $sessionNome;
	public $idSuporte;
	public $idUnidade;
	public $nomeUnidade;

	public function __construct(){

		parent::__construct();
		
		$this->load->library('grocery_CRUD');
		$this->load->model('solicitacao_model');
		//SIMULACAO DO ID DO USUÁRIO
		
		$_SESSION['sess_codusuario'] 	= 3;
		$_SESSION['sess_nomeusuario'] 	= "ELTON OLIVEIRA";
		$_SESSION['sess_codunidade'] 	= 22;
		$_SESSION['sess_unidade'] 		= "CFP - LILI BENCHIMOL";


		$sess_codusuario = isset($_SESSION['sess_codusuario']) ? $sess_codusuario = $_SESSION['sess_codusuario'] : $sess_codusuario = "";
		$sess_nomeusuario = isset($_SESSION['sess_nomeusuario']) ? $sess_nomeusuario = $_SESSION['sess_nomeusuario'] : $sess_nomeusuario = "";

		$this->idUnidade    		= isset($_SESSION['sess_codunidade']) ? $this->idUnidade = $_SESSION['sess_codunidade'] : $this->idUnidade = "";
		$this->nomeUnidade  		= isset($_SESSION['sess_unidade']) 	? $this->nomeUnidade = $_SESSION['sess_unidade'] 	: $this->nomeUnidade = "";

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
	}
	
	public function home_sisten(){
		$output = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
		$this->template->load('home','templates/view_home',$output);
	}


	public function solicitacaoEquipamento($id = null){
		try{
			
			$crud = new grocery_CRUD();
			$crud->set_crud_url_path(site_url('home/solicitacaoEquipamento'));			
			$crud->set_theme('flexigrid');
			$crud->set_table('solicitacao');	
			/*set_relation('capodatabela','tabela_relacionada','chave estrangeira')*/
					
			
			$crud->add_fields('patrimonio','descricao_equi','descricao_servico','local_servico','data_solicitacao','tipo','usuario_id');
			
			$crud->display_as('patrimonio','Patrimônio')
				 ->display_as('descricao_equi','Descrição do Equipamento')
				 ->display_as('anexo','Anexo')
				 ->display_as('descricao_servico','Descrição do Serviço')
				 ->display_as('local_servico','Local do Serviço');
			/*Deixa o campo data_solicitacao invisivel*/	 
			$crud->field_type('data_solicitacao','invisible');
			
			$crud->field_type('usuario_id', 'hidden', $this->sessionUsuario);
			$crud->field_type('tipo', 'hidden',1);

			/*UNIDADE*/
			
			$crud->field_type('local_servico', 'hidden', $this->idUnidade);
			/*END UNIDADE*/
			
			$crud->required_fields('descricao_equi','descricao_servico','patrimonio');
			
			$crud->set_subject('Solicitação - Equipamentos');
			
			$crud->unset_back_to_list();
			/*Insere a data de solicitação automaticamente via callback*/
			$crud->callback_before_insert(array($this,'data_solicitacao_callback'));
			$crud->set_lang_string('insert_success_message',
									'Os dados foram armazenados no banco de dados
										<script type="text/javascript">

											window.location = "'.site_url('home/minhas-solicitacoes').'";
										</script>
									
									'
									);			
			
			$output = $crud->render();
			$this->template->load('home','templates/view_frm_solicitacao_equi',$output);

		}catch(Exception $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
		
	}

	public function retornaDescricao($id = null){

		$dados = $this->solicitacao_model->getDescricaoEqui($id);
		
		foreach ($dados as $value) {
				
				echo $value->equi_descricao;
		}	

	}

	public function solicitacaoSistema($id = null){
		try{
			/*set_relation('capodatabela','tabela_relacionada','chave estrangeira')*/
			$crud = new grocery_CRUD();
			$crud->set_crud_url_path(site_url('home/solicitacaoSistema'));			
			$crud->set_theme('flexigrid');
			$crud->set_table('solicitacao');

			$crud->add_fields( 'sistemas_id','anexo','descricao_servico','local_servico','data_solicitacao','tipo','usuario_id');	
			
			$crud->set_relation('sistemas_id','sistemas','nome');

			$crud->display_as('sistemas_id','Sistema')
				 ->display_as('anexo','Anexo')
				 ->display_as('descricao_servico','Descrição do Serviço')
				 ->display_as('local_servico','Local do Serviço');
			/*Deixa o campo data_solicitacao invisivel*/	 
			$crud->field_type('data_solicitacao','invisible');
			$crud->field_type('usuario_id', 'hidden', $this->sessionUsuario);
			$crud->field_type('tipo', 'hidden',2);
			/*UNIDADE*/
			$crud->field_type('local_servico', 'hidden', $this->idUnidade);
			/*END UNIDADE*/
			$crud->required_fields('descricao_servico','sistemas_id');
						
			$crud->set_subject('Solicitação - Sistemas');
			
			$crud->unset_back_to_list();
			/*Insere a data de solicitação automaticamente via callback*/
		
			$crud->callback_before_insert(array($this,'data_solicitacao_callback'));
			$crud->callback_after_insert(array($this,'emailAbrirChamado'));
			$crud->set_lang_string('insert_success_message',
			'Os dados foram armazenados no banco de dados
				<script type="text/javascript">
					
					window.location = "'.site_url('home/minhas-solicitacoes').'";
				</script>
			
			'
			);
		
			$crud->set_field_upload('anexo','assets/arquivos/anexo/solicitacao_sis');
			$output = $crud->render();
			$this->template->load('home','templates/view_frm_solicitacao_sis',$output);

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
			
			$crud->set_relation('id_suporte','usuarios','nome');
			$crud->set_relation('situacao_id','situacao','nome');
			/*EQUIPAMENTO*/
			/*RELACIONAMENTO SISTEMAS*/
			
			$crud->set_relation('local_servico','db_base.unidade_uni','uni_nomecompleto');
			$crud->set_relation('sistemas_id','sistemas','nome');
			/*SISTEMAS*/
			$crud->field_type('id','readonly');
						
			$crud->display_as('id','Código')
				 ->display_as('situacao_id','Situação')
				 ->display_as('id_suporte','Nome do Suporte')
				 ->display_as('data_solicitacao','Data de Solicitação')
				 ->display_as('local_servico','Local do Serviço')
				 ->display_as('patrimonio','Patrimônio')
				 ->display_as('descricao_servico','Descrição do Serviço')
				 ->display_as('descricao_equi','Descrição do Equipamento')
				 ->display_as('sistemas_id','Sistema')
				 ->display_as('anexo','Anexo');
		    $crud->callback_field('data_solicitacao',array($this,'formatData'));
		    $crud->callback_after_update(array($this, 'data_finalizacao_callback'));
		    $crud->callback_before_delete(array($this,'delete_image'));
		    $crud->set_field_upload('anexo','assets/arquivos/anexo/solicitacao_sis');
		    /*ACTION FINALIZAR SOLICITAÇÃO*/

		    $crud->add_action('Finalizar', 'ui-icon ui-icon-circle-minus', 'home/finalizarChamado');	

		    /*END ACTION*/
		    $crud->unset_back_to_list();
			$state 		= $crud->getState();
    		$state_info = $crud->getStateInfo();


    		if($state == 'read'){

    			$idSolicitacao = $state_info->primary_key;
    			$tipo = $this->solicitacao_model->getTipoSolicitacao($idSolicitacao);

    			foreach ($tipo as $value) {
        			if($value->tipo == 2){
        				

        				$crud->fields('id','descricao_servico','anexo','data_solicitacao','situacao_id','id_suporte','sistemas_id');        				

        			}else{
        				$crud->fields('id','local_servico','descricao_equi','descricao_servico','patrimonio','data_solicitacao','situacao_id','id_suporte');
        			}
        		}

    		}elseif($state == 'edit'){
    				$idSolicitacao = $state_info->primary_key;
    			    $tipo = $this->solicitacao_model->getTipoSolicitacao($idSolicitacao);
    			    $situacao = $this->solicitacao_model->getSituacaoSolicitacao($idSolicitacao);

    			foreach ($tipo as $value) {
        			if($value->tipo == 2){
        				if($situacao[0]->situacao_id != 3){
        				    $crud->edit_fields('id','descricao_servico','anexo','situacao_id');        				
        				 }else{

        				 	  $crud->field_type('descricao_servico', 'readonly');
        				 	  $crud->field_type('anexo', 'readonly');
        				 	  $crud->edit_fields('id','descricao_servico','anexo');
        				 }
        			}else{
        				if($situacao[0]->situacao_id != 3){
        				   $crud->edit_fields('id','descricao_equi','anexo','descricao_servico','situacao_id');      				
        				 }else{
        				 	 $crud->field_type('descricao_equi', 'readonly');
        				 	 $crud->field_type('descricao_servico', 'readonly');
        				 	 $crud->field_type('anexo', 'readonly');
        				 	 $crud->edit_fields('id','descricao_equi','anexo','descricao_servico');
        				 }        				
        			}
        		}
    		}

		
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_print();	
			$crud->unset_delete(); 
			$output = $crud->render();			
			
			$this->template->load('home','templates/view_solicitacoes',$output);

		}catch(Exception $e){

			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}

	}


	public function finalizarChamado($id = null){

		try{

			if(!$this->solicitacao_model->update($id , array('situacao_id' => 3,'data_finalizacao' => date('Y-m-d') ))){

				throw new Exception("Este chamado já foi finalizado!");						
			}

						   $this->db->where('id',$id); 	
						   $this->db->select('id_suporte');
			$suporteResp = $this->db->get('solicitacao')->result();

			if(isset($suporteResp[0]->id_suporte)){

					$mensagem = "Usuário : ".$_SESSION['sess_nomeusuario']." Finalizou o chamado de Nº ".$id." ás " .date('h:i:s');
					$emailGic = "elton.oliveira@am.senac.br";
					$assunto = $_SESSION['sess_nomeusuario']." - Finalização de chamado - ".date('d-m-Y');
					$this->email->from($emailGic, 'Sistema de Solicitação de Serviços');
					$this->email->to($emailGic);				 
								
					$this->email->subject($assunto);
					$this->email->message($emailGic." - ".$mensagem);	
					
					$this->email->send();				

			}


						  $this->db->where('id',$id); 	
						  $this->db->select('usuario_id');
			$idUsuario =  $this->db->get('solicitacao')->result();


				 		 $this->db->where('emus_codusuario', $idUsuario[0]->usuario_id);
						 $this->db->select('emus_email');	
				$email = $this->db->get('db_base.emailusuario_emus')->result();

				if(isset($email[0]->emus_email)){

					$mensagem = "Seu chamado foi finalizado com sucesso, chamado de número ".$id;
					$email 	  = $email[0]->emus_email;
					$assunto  = $_SESSION['sess_nomeusuario']." - Finalização de chamado - ".date('d-m-Y');
					$this->email->from($email, 'Sistema de Solicitação de Serviços');
					$this->email->to($email);								
					$this->email->subject($assunto);
					$this->email->message($emailGic." - ".$mensagem);	
					
					$this->email->send();

				}				  

			$msg = '
				<script>
					alert("Atendimento Finalizado!");
				</script>';
 			$this->session->set_flashdata('msg', $msg);

			redirect('home/minhas-solicitacoes/');

		}catch(Exception $e){

			$msg = '<script> alert("'.$e->getMessage().'"); </script>';
 			$this->session->set_flashdata('msg', $msg);

			redirect('home/minhas-solicitacoes/');
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

	public function data_finalizacao_callback($post_array,$primary_key) {
		  	
		  $dados = array('data_finalizacao' => date('Y-m-d h:i:s') ); 
		  return $this->solicitacao_model->update($primary_key,$dados);
	}

	public function mensagem_insert($postArray){		

		$msg = '
			<div class="alert alert-success">
				 <button type="button" class="close" data-dismiss="alert">×</button>
 					Mensagem Enviada..
			</div>
		';
 		$this->session->set_flashdata('msg', $msg); 		
    	redirect('home/mensagem/'.$postArray['solicitacao_id']);
	}
	/*FORMATAÇÃO DAS DATAS*/
	public function formatData($value, $primary_key = null){
		return formatDataBrasil($value);
	}
	/*E-MAIL ENVIADO AO ABRIR CHAMADO DE USUÁRIO*/
	public function emailAbrirChamado(){
		try{
					
					$mensagem = "Usuário : ".$_SESSION['sess_nomeusuario']." abriu uma solicitação ás ". date('h:i:s');
					$emailGic = "elton.oliveira@am.senac.br";
					$assunto = $_SESSION['sess_nomeusuario']." - Abertura de solicitação de serviço - ".date('d-m-Y');
					$this->email->from($emailGic, 'Sistema de Solicitação de Serviços');
					$this->email->to($emailGic);				 
								
					$this->email->subject($assunto);
					$this->email->message($emailGic." - ".$mensagem);	
					
					$this->email->send();				

		}catch(Exception $e){

			
			return $e->getMessage();
		}


	}
	/*DELETAR A IMAGEM AO EXCLUIR A SOLICITAÇÃO*/
	function delete_image($primary_key){
	
		$image = $this->db->get_where('solicitacao', array('id'=>$primary_key), 1)->row_array();
		$path = 'assets/arquivos/anexo/solicitacao_sis/';
		if(unlink($path.$image['anexo']))
			return true;
		
	}
	/*METODO SAIR*/
	public function sair(){
		session_destroy();	
		$this->session->sess_destroy();
		redirect('http://portalsenac.am.senac.br');

	}


}
	

 ?>