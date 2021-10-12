<?php 

     class Users_model extends CI_Model {

		// Fazendo referencia da classe	Users_model	 
		// Carregando a base de dados 
		public function __construct() {
			parent::__construct();
			$this->load->database();
		}

		 // Pegando o usuário do banco de dados 
		public function get_user_data($user_login){

			$this->db
			     ->select("user_id, password_hash, user_name, user_email")
				 ->from("users")
				 ->where("user_login", $user_login);
				 
		   $result = $this->db->get();
		   
		   if ( $result->num_rows() > 0 ) {
			   return $result->row();
		   }else{
			   return NULL;
		   }


		}

	 }