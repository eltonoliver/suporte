<?php

class User_model extends grocery_CRUD_Model {

	public function getUser(){

		return $this->db->get('user')->result();
	}


}
?>
