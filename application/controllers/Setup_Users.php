<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_Users extends CI_Controller {

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
		if(!isset($_SESSION['user_data'])){
			//user already logged in
			redirect('login');
		}
		
		$enable_next = 0;
		
		$user_count = $this->user->get_count();
		
		if ($user_count > 10){
			$enable_next = 1;
		}
		
		$data = array('current_location' => 'setup_users'
		, 'user_access' => $_SESSION['user_data']['user_access']
		, 'page' => 1
		, 'enable_next' => $enable_next
		, 'total_page' => ceil($user_count/10)
		);
		
		$data['user_list'] = $this->user->get_users(10, 0);
		$data['positions'] = $this->user->get_positions();
		
		$this->load->view('setup_users', $data);

	}

	public function save(){
		$userid = $this->input->post('edit_flag');
		$edit_flag = false;
		
		if(!$userid){
			$userid = $this->generate_id();
		}else{
			$edit_flag = true;
		}
		
		$page = $this->input->post('page');
		//$edit_flag = $this->input->post('edit_flag');
		
		$firstname = $this->input->post('fname');
		$lastname = $this->input->post('lname');
		$usertype = $this->input->post('position');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$birthdate = date("Y-m-d",strtotime($this->input->post('birthdate')));
		$telephone = $this->input->post('telephone_no');
		$cellphone = $this->input->post('cellphone_no');
		$email = $this->input->post('email');
		
		$street_province = $this->input->post('street_province');
		$city_province = $this->input->post('city_province');
		$state_province = $this->input->post('state_province');
		$zip_province = $this->input->post('zip_province');

		$street_city = $this->input->post('street_city');
		$city_city = $this->input->post('city_city');
		$state_city = $this->input->post('state_city');
		$zip_city = $this->input->post('zip_city');
		
		$user_access = $this->input->post('useraccess');
		
		
		$mother = $this->input->post('mother_name');
		$father = $this->input->post('father_name');
		
		//format the address
		
		$add_province = $street_province."!#".$city_province."!#".$state_province;
		
		$add_city = $street_city."!#".$city_city."!#".$state_city;
		
		if ($edit_flag){
			$this->user->update_user_data($userid, $firstname, $lastname, $usertype, $username);
			$this->user->update_user_details($userid, $birthdate, $telephone, $cellphone, $email, $add_province, $zip_province, $add_city, $zip_city, $mother, $father, $user_access);
			
		}else{
			$this->user->add_user($userid, $firstname, $lastname, $usertype, $username, $password);
			
			$this->user->add_user_details($userid, $birthdate, $telephone, $cellphone, $email, $add_province, $zip_province, $add_city, $zip_city, $mother, $father, $user_access);
		}
		
		//retrieve the count of users
		$user_count = $this->user->get_count();
		$page_arr['total_page'] = ceil($user_count/10);
		if(!$edit_flag){
			$page = 1;
		}
		if($page < $page_arr['total_page']){
			$page_arr['next'] = 1;
		}else{
			$page_arr['next'] = 0;
		}
		if($page == 1){
			$page_arr['prev'] = 0;
		}else{
			$page_arr['prev'] = 1;
		}
		
		$page_arr['page_num'] = $page;
		
		$data = $this->user->get_users(10, ($page-1)*10);
		array_unshift($data, $page_arr);
		echo json_encode($data);
	}
	
	public function page(){
		$page = $this->input->post('page');
		
		$search_flag = $this->input->post('search_flag');
		$search_arr['username'] = $this->input->post('search_username');
		$search_arr['fname'] = $this->input->post('search_fname');
		$search_arr['lname'] = $this->input->post('search_lname');
		
		// $search_flag = 1;
		// $search_arr['username'] = 'jays';
		// $search_arr['fname'] = $this->input->post('search_fname');
		// $search_arr['lname'] = $this->input->post('search_lname');
		
		//retrieve the last announcements
		if($search_flag == 0){
			$user_count = $this->user->get_count();
		}else{
			$user_count = $this->user->get_count($search_arr);
		}
		
		$page_arr['total_page'] = ceil($user_count/10);
		//$page = 1;
		//check if page to access is last page
		//if $page = 0, jquery is trying to access last page.
		//$page = 0;
		if ($page == 0){
			$page = $page_arr['total_page'];
		}
		
		if($page < $page_arr['total_page']){
			$page_arr['next'] = 1;
		}else{
			$page_arr['next'] = 0;
		}
		if($page == 1){
			$page_arr['prev'] = 0;
		}else{
			$page_arr['prev'] = 1;
		}
		
		$page_arr['page_num'] = $page;
		
		//retrieve the user depending on the page supplied
		if($search_flag == 0){
			$data = $this->user->get_users(10, ($page-1)*10);
		}else{
			$data = $this->user->get_users(10, ($page-1)*10, $search_arr);
		}
		
		array_unshift($data, $page_arr);
		echo json_encode($data);
	}
	
	public function generate_id(){
		
		$mt = str_replace(".","",(string)microtime());
		$mt = str_replace(" ","",$mt);
		return $mt.(string)rand(0000,9999);
	}
	
	public function test_count()
	{
		echo $this->user->get_count();
	}
	
	public function deactivate(){
		
		//convert csv into array
		$ids = explode("," , $this->input->post('id'));
		$this->user->deactivate($ids);
		$page = $this->input->post('page');
		
		//retrieve the last announcements
		$user_count = $this->user->get_count();
		$page_arr['total_page'] = ceil($user_count/10);
		// if ($user_count % 10 == 0){
			// $page = $page-1;
		// }
		
		if($page < $page_arr['total_page']){
			$page_arr['next'] = 1;
		}else{
			$page_arr['next'] = 0;
		}
		if($page == 1){
			$page_arr['prev'] = 0;
		}else{
			$page_arr['prev'] = 1;
		}
		
		$page_arr['page_num'] = $page;
		
		$data = $this->user->get_users(10, ($page-1)*10);
		array_unshift($data, $page_arr);
		echo json_encode($data);
		
	}
	
	public function activate(){
		
		//convert csv into array
		$ids = explode("," , $this->input->post('id'));
		$this->user->activate($ids);
		$page = $this->input->post('page');
		
		//retrieve the last announcements
		$user_count = $this->user->get_count();
		$page_arr['total_page'] = ceil($user_count/10);
		// if ($user_count % 10 == 0){
			// $page = $page-1;
		// }
		
		if($page < $page_arr['total_page']){
			$page_arr['next'] = 1;
		}else{
			$page_arr['next'] = 0;
		}
		if($page == 1){
			$page_arr['prev'] = 0;
		}else{
			$page_arr['prev'] = 1;
		}
		
		$page_arr['page_num'] = $page;
		
		$data = $this->user->get_users(10, ($page-1)*10);
		array_unshift($data, $page_arr);
		echo json_encode($data);
		
	}
	
	public function get_user_details(){
		
		$user_id = $this->input->post('user_id');
		//$user_id = '03452420014559818094533';
		
		$data = $this->user->get_user_info($user_id);
		
		$city_address = explode('!#', $data['address_city']);
		
		if(isset($city_address[0])){
			$data['city_street'] = $city_address[0];
		}
		if(isset($city_address[1])){
			$data['city_city'] = $city_address[1];
		}
		if(isset($city_address[2])){
			$data['city_province'] = $city_address[2];
		}

		$province_address = explode('!#', $data['address_province']);
		
		if(isset($province_address[0])){
			$data['province_street'] = $province_address[0];
		}
		if(isset($province_address[1])){
			$data['province_city'] = $province_address[1];
		}
		if(isset($province_address[2])){
			$data['province_province'] = $province_address[2];
		}
		
		$data['ua_descr'] = $this->user->get_user_access_descr($data['user_access']);
		$data['pos_descr'] = $this->user->get_position_descr($data['user_access']);
		//array_unshift($data, $user_basic_data);
		
		echo json_encode($data);
		
	}
	
	public function update_test(){
		
		$userid = '0120185001454833784961';
		$firstname = 'Luke Andrew E';
		$lastname = 'Barino';
		$usertype = '0';
		$username = 'andrewe';
		
		$this->user->update_user_data($userid, $firstname, $lastname, $usertype, $username);
		//$this->user->update_user_details($userid, $birthdate, $telephone, $cellphone, $email, $add_province, $zip_province, $add_city, $zip_city, $mother, $father, $user_access);
	}
	
	public function update_test2()
	{
		
		$userid = '0120185001454833784961';
		$birthdate = '2008-10-12';
		$telephone = '123456789';
		$cellphone = '987654321';
		$email = 'tester@yahoo.com';
		$add_province = 'sdgs!#sdhsdh!#fhdfh';
		$zip_province = '25125';
		$add_city = "sdgs!#sdhsdh!#fhdfh";
		$zip_city = "12512";
		$mother = 'sdgsdg';
		$father = 'sdhsh';
		$user_access = 0;
		
		$this->user->update_user_details($userid, $birthdate, $telephone, $cellphone, $email, $add_province, $zip_province, $add_city, $zip_city, $mother, $father, $user_access);
	}
	
	public function test_get_details()
	{
		
		
	}
	
}