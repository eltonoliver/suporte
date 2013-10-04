<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Solicitacao_model extends CI_Model{


	public function __construct(){
	   parent::__construct();
	}


	   public function getSolicitacao($id = null){
	
	    	return $this->db->query(
	    		'
	    			SELECT solicitacao.id, 
					solicitacao.descricao_equi, 
					solicitacao.descricao_servico, 
					usuarios.nome, 
					db_base.unidade_uni.uni_nomecompleto, 
					solicitacao.tipo, 
					patrimonio.patrimonio, 
					solicitacao.data_solicitacao, 
					solicitacao.usuario_id, 
					sistemas.nome, 
					situacao.nome as nomeSituacao
				FROM solicitacao LEFT JOIN usuarios ON solicitacao.id_suporte = usuarios.id
					 LEFT JOIN db_base.unidade_uni ON solicitacao.local_servico = db_base.unidade_uni.id
					 LEFT JOIN patrimonio ON solicitacao.patrimonio_id = patrimonio.id
					 LEFT JOIN sistemas ON solicitacao.sistemas_id = sistemas.id
					 LEFT JOIN situacao ON solicitacao.situacao_id = situacao.id
				WHERE solicitacao.id = '.$id.' AND solicitacao.usuario_id ='.$this->session->userdata('usuario_id')
	    		)->result();
	    }

	    public function getTipoSolicitacao($id = null){
	    	$this->db->where('id', $id);
	    	$this->db->select('tipo');
	    	return $this->db->get('solicitacao')->result();

	    }

	    public function getSituacaoSolicitacao($id = null){
	    	$this->db->where('id', $id);
	    	$this->db->select('situacao_id');
	    	return $this->db->get('solicitacao')->result();

	    }


	    public function getForum($id = null){
	    		   $this->db->where('solicitacao_id',$id);   	
	    		   $this->db->where('usuario_id', $this->session->userdata('usuario_id'));
	    	return $this->db->get('forum')->result();

	    }

	    public function getMensagemForum($id = null){
	    	 		$this->db->where('solicitacao_id',$id);   	 
	    	 return $this->db->get('forum')->result();

	    }

	    public function getSuporte($login = null){
	    	$this->db->where('nome',$login);
	    	return $this->db->get('usuarios')->result();

	    }

	    public function update($id = null, $data = array()){

	    	
	    	$this->db->where('id',$id);	
	        $this->db->update('solicitacao', $data);
			return $this->db->affected_rows();
	    		    
	    	
	    }


       public function verificaSolicitacoes($idUser = null, $tipo = null, $situacao = null){
    			$arrayWhere = array('usuario_id' => $idUser,'situacao_id' => $situacao,'tipo' => $tipo);
    			$this->db->where( $arrayWhere);
    			$this->db->get('solicitacao')->result();
    			return $this->db->affected_rows();
        }

        public function getDescricaoEqui($id = null){

        	$this->db->where('equi_patrimonio',$id);
        	$this->db->select('equi_descricao');
        	return $this->db->get('db_gde.equipamento_equi')->result();
        }
	    

}
?>
