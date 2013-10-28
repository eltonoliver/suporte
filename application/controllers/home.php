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
		
		$_SESSION['sess_codusuario'] 	= 23;
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
			
			$crud->required_fields('descricao_equi','descricao_servico');
			
			$crud->set_subject('Solicitação - Equipamentos');
			
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
				 ->display_as('id_suporte','Técnico')
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

			 			   $this->db->where('id',$suporteResp[0]->id_suporte); 	
						   $this->db->select('email');
			$emailSuporte = $this->db->get('usuarios')->result();

			$mensagem = '
							
							<html>
							
							<body>
								<div style="text-align: center;">
									<p style="text-align: left;">
										<span class="header" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(253, 253, 253);"><strong>MENSAGEM AUTOM&Aacute;TICA. POR FAVOR, N&Atilde;O RESPONDA ESSE E-MAIL.</strong><br />
										Para isso utilize a ferramenta de suporte <span class="Object" id="OBJ_PREFIX_DWT153_com_zimbra_url" style="color: rgb(51, 102, 153); cursor: pointer;"><a class="external" href="http://portalsenac.am.senac.br" style="color: rgb(51, 102, 153); text-decoration: none; cursor: pointer;" target="_blank">http://portalsenac.am.senac.br</a></span><br />
										___<em>_</em>_____________________________________________________________________________________________</span></p>
									<p style="text-align: left;">
										<span style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(253, 253, 253);">O Usu&aacute;rio - ('.$_SESSION['sess_nomeusuario'].') Fechou um chamado.</span></p>
									<ul style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(253, 253, 253);">
										<li style="text-align: left;">
											Data de Finalização : &nbsp;'.date('d/m/Y').'</li>
											<li style="text-align: left;">
											Nº : &nbsp;'.$id.'</li>
									</ul>
									
										<span class="footer" style="font-size: 0.8em; font-style: italic; font-family: Helvetica, Arial, sans-serif; background-color: rgb(253, 253, 253);"><strong>ESTA &Eacute; UMA MENSAGEM AUTOM&Aacute;TICA. POR FAVOR, N&Atilde;O RESPONDA ESSE E-MAIL.</strong><br />
										Voc&ecirc; recebeu este e-mail porque voc&ecirc; est&aacute; inscrito na lista de suporte da Equipe GIC.<br />
										Para alterar suas configura&ccedil;&otilde;es por favor acess:&nbsp;<span class="Object" id="OBJ_PREFIX_DWT157_com_zimbra_url" style="color: rgb(51, 102, 153); cursor: pointer;"><a class="external" href="http://portal.am.senac.br" style="color: rgb(51, 102, 153); text-decoration: none; cursor: pointer;" target="_blank">http://</a>portal.am.senac.br</span>.</span></p>
								</div>
								<p>
									&nbsp;</p>
							</body>
						</html>				
					
					';				
					
					
					$emailGic = $emailSuporte[0]->email;
					$assunto = $_SESSION['sess_nomeusuario']." - Finalização do chamado - ".date('d-m-Y');
					$config['charset'] = 'utf-8';

					$config['wordwrap'] = TRUE;
					$config['mailtype'] = 'html';
					$this->email->initialize($config);

					$this->email->from($emailGic, 'Sistema de Solicitação de Serviços');
					$this->email->to($emailGic);				 
								
					$this->email->subject($assunto);
					$this->email->message($mensagem);	
					
					$this->email->send();

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

	/*DELETAR A IMAGEM AO EXCLUIR A SOLICITAÇÃO*/

	function delete_image($primary_key){
	
		$image = $this->db->get_where('solicitacao', array('id'=>$primary_key), 1)->row_array();
		$path = 'assets/arquivos/anexo/solicitacao_sis/';
		if(unlink($path.$image['anexo']))
			return true;
		
	}
	
	public function emailAbrirChamado($post_array,$primary_key){
		try{
					
					
					
					$mensagem = '
							
							<html>
	
								<body>
									<div style="text-align: center;">
										<p style="text-align: left;">
											<span class="header" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(253, 253, 253);"><strong>MENSAGEM AUTOM&Aacute;TICA. POR FAVOR, N&Atilde;O RESPONDA ESSE E-MAIL.</strong><br />
											Para isso utilize a ferramenta de suporte <span class="Object" id="OBJ_PREFIX_DWT153_com_zimbra_url" style="color: rgb(51, 102, 153); cursor: pointer;"><a class="external" href="http://portalsenac.am.senac.br" style="color: rgb(51, 102, 153); text-decoration: none; cursor: pointer;" target="_blank">http://</a>portalsenac.am.senac.br</span><br />
											___<em>_</em>_____________________________________________________________________________________________</span></p>
										<p style="text-align: left;">
											<span style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(253, 253, 253);">O Usu&aacute;rio - ('.$_SESSION['sess_nomeusuario'].') Abriu um chamado.</span></p>
										<ul style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(253, 253, 253);">
											<li style="text-align: left;">
												Data de abertua : &nbsp;'.date('d/m/Y').'</li>
												<li style="text-align: left;">
												Nº : &nbsp;'.$primary_key.'</li>
										</ul>
										<p style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(253, 253, 253); text-align: left;">
											&nbsp;</p>
										<hr style="width: 1883px; height: 1px; background-color: rgb(204, 204, 204); border: 0px; font-family: Helvetica, Arial, sans-serif; font-size: 16px;" />
										<h1 style="font-family: \'Trebuchet MS\', Verdana, sans-serif; margin: 0px; font-size: 1.2em; background-color: rgb(253, 253, 253); text-align: left;">
											<span class="Object" id="OBJ_PREFIX_DWT154_com_zimbra_url" style="color: rgb(51, 102, 153); cursor: pointer;"><a href="#" style="color: rgb(51, 102, 153); text-decoration: none; cursor: pointer;" target="_blank">D</a>escri&ccedil;&atilde;o do Servi&ccedil;o:</span></h1>
										<p style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; background-color: rgb(253, 253, 253); text-align: left;">
											'.strip_tags($post_array['descricao_servico']).'</p>
										<hr style="width: 1883px; height: 1px; background-color: rgb(204, 204, 204); border: 0px; font-family: Helvetica, Arial, sans-serif; font-size: 16px;" />
										<p style="text-align: left;">
											<span class="footer" style="font-size: 0.8em; font-style: italic; font-family: Helvetica, Arial, sans-serif; background-color: rgb(253, 253, 253);"><strong>ESTA &Eacute; UMA MENSAGEM AUTOM&Aacute;TICA. POR FAVOR, N&Atilde;O RESPONDA ESSE E-MAIL.</strong><br />
											Voc&ecirc; recebeu este e-mail porque voc&ecirc; est&aacute; inscrito na lista de suporte da Equipe GIC.<br />
											Para alterar suas configura&ccedil;&otilde;es por favor acess:&nbsp;<span class="Object" id="OBJ_PREFIX_DWT157_com_zimbra_url" style="color: rgb(51, 102, 153); cursor: pointer;"><a class="external" href="http://portalsenac.am.senac.br" style="color: rgb(51, 102, 153); text-decoration: none; cursor: pointer;" target="_blank">http://portalsenac.am.senac.br</span></a>.</span></p>
									</div>
									<p>
										&nbsp;</p>
								</body>
							</html>
					
					';		
					
					
					
					$emailGic = "elton.oliveira@am.senac.br";
					$assunto = $_SESSION['sess_nomeusuario']." - Abertura de  - ".date('d-m-Y');
					$config['charset'] = 'utf-8';

					$config['wordwrap'] = TRUE;
					$config['mailtype'] = 'html';
					$this->email->initialize($config);

					$this->email->from($emailGic, 'Sistema de Solicitação de Serviços');
					$this->email->to($emailGic);				 
								
					$this->email->subject($assunto);
					$this->email->message($mensagem);	
					
					$this->email->send();				

		}catch(Exception $e){
			
			return $e->getMessage();
		}
			
		return $post_array;
	}
	public function sair(){
		//session_destroy();	
		//$this->session->sess_destroy();
		redirect('http://portalsenac.am.senac.br/portal_senac/control_base_vermodulos/control_base_vermodulos.php');

	}


}
	

 ?>