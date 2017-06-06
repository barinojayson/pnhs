<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	function __construct(){
	// Call the CI_Model constructor
	parent::__construct();
		$this->load->helper('url');
		$this->load->model('user');
		session_start();
	}
	 
	public function index(){
		if(isset($_SESSION['user_data'])){
			//user already logged in
			redirect('announcement');
		}
		//check if user tried to login
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if(isset($username) && isset($password)){
			$user_id = $this->user->validate_user($username, $password);
			if ($user_id != 0){
				//user inputted correct credentials
				//$user_access = $this->user->get_user_access($user_id);
				$_SESSION['user_data'] = array('username' => $username
											, 'userid' => $user_id
											, 'user_access' => $user_access);
				redirect('announcement');
			}
			else{
				//user inputted incorrect credentials
				$error_message = array('error' => 'Incorrect username and password.');
				$this->load->view('login', $error_message);
			}
		}
		else{
			$this->load->view('login');
		}
	}
	
	public function logout(){
		unset($_SESSION['user_data']);
	}
}
