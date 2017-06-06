<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_Year_Level extends CI_Controller {

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
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('year_level');
		$this->load->model('section');
		$this->load->model('subject');
		$this->load->model('user');
		session_start();
	}
	 
	public function index(){
		if(!isset($_SESSION['user_data'])){
			//user already logged in
			redirect('login');
		}
		
		$enable_next = 0;
		
		$year_count = $this->year_level->get_count();
		
		if ($year_count > 10){
			$enable_next = 1;
		}
		
		$data = array('current_location' => 'manage_year_level'
		, 'user_access' => $_SESSION['user_data']['user_access']
		, 'page' => 1
		, 'enable_next' => $enable_next);
		
		$data['year_list'] = $this->year_level->get_year_levels(10, 0);
		
		//print_r($data);
		
		if ($year_count == 0)
		{
			$data['no_data'] = 1;
			$data['total_page'] = 1;
		}else{
			$data['no_data'] = 0;
			$data['total_page'] =  ceil($year_count/10);
		}
		
		$this->load->view('manage_year_level', $data);
	}	
	
	public function save(){
		
		$year_id = $this->input->post('edit_flag');
		$edit_flag = false;
		
		if(!$year_id){
			$year_id = $this->generate_id();
		}else{
			$edit_flag = true;
		}
		
		$page = $this->input->post('page');

		$year = $this->input->post('year');
		$description = $this->input->post('description');
				
		$created_by = $_SESSION['user_data']['userid'];
		$modified_by = $_SESSION['user_data']['userid'];
			
		if ($edit_flag){
			// $this->subject->update_subject($subject_id, $subject_code, $description, $date_modified, $modified_by);
			
		}else{
			$this->year_level->add_year_level($year_id, $year, $description, $created_by);
		}
		
		//retrieve the count of subjects
		$yl_count = $this->year_level->get_count();
		$page_arr['total_page'] = ceil($yl_count/10);
		
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
		
		$data = $this->year_level->get_year_levels(10, ($page-1)*10);
		array_unshift($data, $page_arr);
		echo json_encode($data);

	}
	
	public function page(){
		$page = $this->input->post('page');
		
		$search_flag = $this->input->post('search_flag');
		$search_arr['year_level'] = $this->input->post('search_yl');
		$search_arr['description'] = $this->input->post('search_yl_descr');
		
		if($search_flag == 0){
			$yl_count = $this->year_level->get_count();
		}else{
			$yl_count = $this->year_level->get_count($search_arr);
		}
		
		$page_arr['total_page'] = ceil($yl_count/10);
		
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
		
		//retrieve the year levels depending on the current page
		if($search_flag == 0){
			$data = $this->year_level->get_year_levels(10, ($page-1)*10);
		}else{
			$data = $this->year_level->get_year_levels(10, ($page-1)*10, $search_arr);
		}

		array_unshift($data, $page_arr);
		echo json_encode($data);
	}
	
	public function generate_id(){
		return uniqid("YR", true);
	}
	
	public function delete(){
		
		//convert csv into array
		$ids = explode("," , $this->input->post('id'));
		$this->year_level->delete($ids);
		$page = $this->input->post('page');
		$page = 1;
		
		//retrieve the last announcements
		$year_count = $this->year_level->get_count();
		$page_arr['total_page'] = ceil($year_count/10);
		
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
		
		$data = $this->year_level->get_year_levels(10, ($page-1)*10);
		array_unshift($data, $page_arr);
		echo json_encode($data);
		
	}
	
	//returns year_level details
	public function get_year_level_details(){
		
		$yl_id = $this->input->post('yl_id');
		
		$data = $this->year_level->get_year_level_by_id($yl_id);
		
		//array_unshift($data, $user_basic_data);
		
		echo json_encode($data);
	}
	
}