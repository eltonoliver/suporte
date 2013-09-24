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
					situacao.nome
				FROM solicitacao LEFT JOIN usuarios ON solicitacao.id_suporte = usuarios.id
					 LEFT JOIN db_base.unidade_uni ON solicitacao.local_servico = db_base.unidade_uni.id
					 LEFT JOIN patrimonio ON solicitacao.patrimonio_id = patrimonio.id
					 LEFT JOIN sistemas ON solicitacao.sistemas_id = sistemas.id
					 LEFT JOIN situacao ON solicitacao.situacao_id = situacao.id
				WHERE solicitacao.id = '.$id
	    		)->result();
	    }
	
	


}
?>
