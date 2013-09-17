<?php

class User_model extends grocery_CRUD_Model {

	public function getUser(){

		return $this->db->query('				
				SELECT
				situacao.nome,
				usuarios.nome as user,
				prioridade.nome,
				solicitacao_equi.patrimonio,
				solicitacao_equi.descricao_equi,
				solicitacao_equi.descricao_servico,
				solicitacao_equi.anexo,
				solicitacao_equi.local_servico,
				solicitacao_equi.usuario_id,
				solicitacao_equi.data_solicitacao,
				solicitacao_equi.data_atualizacao,
				solicitacao_equi.data_finalizacao
				FROM
				solicitacao_equi
				INNER JOIN prioridade ON solicitacao_equi.prioridade_id = prioridade.id
				INNER JOIN situacao ON solicitacao_equi.situacao_id = situacao.id
				INNER JOIN usuarios ON solicitacao_equi.suporte_id = usuarios.id
			')->result();
	}


}
?>
