<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Restrito extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->library("session");
	}

    public function index(){
		// echo password_hash("admin", PASSWORD_DEFAULT);
		/**
		 * $this->load->model("users_model");
		 * print_r($this->users_model->get_user_data("admin"));
		 */

		if ($this->session->userdata("user_id")){
			$this->template->show("restrito");
		} else {

         $this->template->show('login');

		}
		 
     }

	 public function logoff(){
		 $this->session->sess_destroy();
		 header("Location: " . base_url() . "restrito");
	 }
 
	 // Função para quando o form for enviado
	public function ajax_login() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$username = $this->input->post("username");
		$password = $this->input->post("password");

		if (empty($username)) {
			$json["status"] = 0;
			$json["error_list"]["#username"] = "Usuário não pode ser vazio!";
		} else {
			$this->load->model("users_model");
			$result = $this->users_model->get_user_data($username);
			if ($result) {
				$user_id = $result->user_id;
				$password_hash = $result->password_hash;
				if (password_verify($password, $password_hash)) {
					$this->session->set_userdata("user_id", $user_id);
				} else {
					$json["status"] = 0;
				}
			} else {
				$json["status"] = 0;
			}
			if ($json["status"] == 0) {
				$json["error_list"]["#btn_login"] = "Usuário e/ou senha incorretos!";
			}
		}

		echo json_encode($json);

	}

	public function ajax_save_cliente(){

		if (!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();
	 
	     $this->load->model("cliente_model");

	     $data = $this->input->post();

		 if (empty($data["clientes_name"])){
			 $json["error_list"]["#clientes_name"] = "Campo nome é obrigatório";
		 }
		 if (empty($data["clientes_email"])){
			 $json["error_list"]["#clientes_email"] = "Campo email é obrigatório";
		 }
		 if (empty($data["clientes_fone"])){
			 $json["error_list"]["#clientes_fone"] = "Campo telefone é obrigatório";
		 }
		 if (empty($data["clientes_fornecedor"])){
			 $json["error_list"]["#clientes_fornecedor"] = "Campo fornecedor é obrigatório";
		 }

		 if(!empty($json["error_list"])){
			 $json["status"] = 0;
		 }else{

			 if(empty($data["clientes_id"])){
				 $this->cliente_model->insert($data);
			 } else {
				$clientes_id = $data["clientes_id"];
				unset($data["clientes_id"]); 
				$this->cliente_model->update($clientes_id, $data); 
			 }

		 }
		 echo json_encode($json);

  }

  public function ajax_get_cliente_data(){

	  if (!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script direto permitido");
		}

		$json = array();
		$json["status"] = 1;
		$json["input"] = array();
	 
	     $this->load->model("cliente_model");

		 $cliente_id = $this->input->post("clientes_id");
		 $data = $this->cliente_model->get_data($cliente_id)->result_array()[0];
		 $json["input"]["clientes_id"] = $data["clientes_id"];
		 $json["input"]["clientes_name"] = $data["clientes_name"];
		 $json["input"]["clientes_email"] = $data["clientes_email"];
		 $json["input"]["clientes_fone"] = $data["clientes_fone"];
		 $json["input"]["clientes_fornecedor"] = $data["clientes_fornecedor"];

		 echo json_encode($json);
  }

  public function ajax_delete_cliente_data(){

		if (!$this->input->is_ajax_request()){
		     exit("Nenhum acesso de script direto permitido");
	  }

	  $json = array();
	  $json["status"] = 1;

	  $this->load->model("cliente_model");
	  $clientes_id = $this->input->post("clientes_id");
	  $this->cliente_model->delete($clientes_id);

	  echo json_encode( $json );
  }

  public function ajax_list_cliente(){
	  
	if (!$this->input->is_ajax_request()){
		  exit("Nenhum acesso de script direto permitido!");
	  }
	
	  $this->load->model("cliente_model");
	  $clientes = $this->cliente_model->get_datatable();

	  $data = array();
	  foreach ($clientes as $cliente) {
		  $row = array();
		  $row[] = $cliente->clientes_id;
		  $row[] = $cliente->clientes_name;
		  $row[] = $cliente->clientes_email;
		  $row[] = $cliente->clientes_fone;
		  $row[] = $cliente->clientes_fornecedor; 
		  $row[] ='<div style="display: inline-block;">
						<button class="btn btn-primary btn-edit-cliente" 
							clientes_id="'.$cliente->clientes_id.'">
							<i class="fa fa-edit"></i>
						</button>
						<button class="btn btn-danger btn-del-cliente" 
							clientes_id="'.$cliente->clientes_id.'">
							<i class="fa fa-times"></i>
						</button>
					</div>';
		  $data[] = $row;
	  }
	  
	  $json = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $this->cliente_model->records_total(),
			"recordsFiltered" => $this->cliente_model->records_filtered(),
			"data" => $data,
		);

		echo json_encode($json);
  }

}