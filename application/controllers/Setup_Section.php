<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_Section extends CI_Controller { 

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
		
		$section_count = $this->section->get_count();
		
		if ($section_count > 10){
			$enable_next = 1;
		}
		
		$data = array('current_location' => 'setup_section'
		, 'user_access' => $_SESSION['user_data']['user_access']
		, 'page' => 1
		, 'enable_next' => $enable_next
		);
		
		$data['section_list'] = $this->section->get_sections(10, 0);
		
		if (empty($data['section_list']))
		{
			$data['no_data'] = 1;
			$data['total_page'] = 1;
		}else{
			$data['no_data'] = 0;
			$data['total_page'] =  ceil($section_count/10);
		}
		$data['year_level'] = $this->year_level->get_all_year_levels();
		
		$this->load->view('setup_section', $data);
	}
	
	public function save(){
		
		$section_id = $this->input->post('edit_flag');
		$edit_flag = false;
		
		if(!$section_id){
			$section_id = $this->generate_id();
		}else{
			$edit_flag = true;
		}	
		
		$section = $this->input->post('section');
		$year_level = $this->input->post('year_level');
		$max_student = $this->input->post('max_student');
		$waive = $this->input->post('waive');
		$page = $this->input->post('page');
		
		$created_by = $_SESSION['user_data']['userid'];
		$modified_by = $_SESSION['user_data']['userid'];
		
		if ($edit_flag){
			$this->section->edit_section($section_id, $section, $year_level, $max_student, $waive, $created_by, $modified_by);
			
		}else{
			$this->section->add_section($section_id, $section, $year_level, $max_student, $waive, $created_by, $modified_by);
		}
		
		//$this->section->add_section($section_id, "Good", 9, 22, 0, "j", "b");
		
		//retrieve the last announcements
		$section_count = $this->section->get_count();
		$page_arr['total_page'] = ceil($section_count/10);
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

		$data = $this->section->get_sections(10, ($page-1)*10);
		array_unshift($data, $page_arr);
		echo json_encode($data);
	}
	
	public function page(){
		$page = $this->input->post('page');
		
		$search_flag = $this->input->post('search_flag');
		$search_arr['section_name'] = $this->input->post('section_name');
		$search_arr['year_level'] = $this->input->post('year_level');
		$search_arr['waive_flag'] = $this->input->post('waive_flag');
		$search_arr['max_student'] = $this->input->post('max_student');
		
		// $search_arr['section_name'] = "bad";
		// $search_arr['year_level'] = 2;
		// $search_arr['max_student'] = 23;
		// $search_flag = 1;
				 
		if($search_flag == 0){
			$section_count = $this->section->get_count();
		}else{
			$section_count = $this->section->get_count($search_arr);
		}
		
		$page_arr['total_page'] = ceil($section_count/10);
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
		
		//retrieve the section depending on the current page
		if($search_flag == 0){
			$data = $this->section->get_sections(10, ($page-1)*10);
		}else{
			$data = $this->section->get_sections(10, ($page-1)*10, $search_arr);
		}
		
		array_unshift($data, $page_arr);
		echo json_encode($data);
	}
	
	public function generate_id(){
		return uniqid("SEC", true);
	}
	
	//returns section details
	public function get_section_details(){
		$section_id = $this->input->post('section_id');
		$data = $this->section->get_section($section_id);
		array_unshift($data, $this->section->get_subjects_by_section($section_id));
		array_unshift($data, $this->user->get_teachers());
		array_unshift($data, $this->subject->get_subjects(0, 0));
		array_unshift($data, $this->year_level->get_all_year_levels());
		// echo "<pre>"; print_r ($data);
		//$data = $this->section->get_subjects_by_section($section_id);
		echo json_encode($data);
	}
	
	public function save_subject(){
		
		$data = [];
		
		$sec_sub_id = $this->input->post('sec_sub_id');
		$subject_id = $this->input->post('subject_id');
		
		$result = $this->section->update_section_subject($sec_sub_id, $subject_id);
		
		if ($result > -1){
			$data['success'] = 1; 
		}else{
			$data['success'] = 0; 
			$data['message'] = "Unable to update the section's subject. Please contact an administrator."; 
		}
		echo json_encode($data);
	}
	
	
	public function save_teacher(){
		
		$data = [];
		
		$sec_sub_id = $this->input->post('sec_sub_id');
		$teacher_id = $this->input->post('teacher_id');
		
		$result = $this->section->update_section_subject_teacher($sec_sub_id, $teacher_id);
		
		if ($result > -1){
			$data['success'] = 1; 
		}else{
			$data['success'] = 0; 
			$data['message'] = "Unable to update the subject's teacher. Please contact an administrator."; 
		}
		echo json_encode($data);
	}
	
	public function add_subject(){

		$data = [];
	
		$section_id = $this->input->post('section_id');
		$subject_id = $this->input->post('subject_id');
		$teacher_id = $this->input->post('teacher_id');

		$this->section->add_subject($section_id, $subject_id, $teacher_id);
		
		$data['sec_sub_id'] = $this->section->get_sec_sub_id($section_id, $subject_id, $teacher_id);
		$data['subject_id'] = $subject_id;
		$data['teacher_id'] = $teacher_id;
		
		echo json_encode($data);
	}
	
	public function delete(){
		$ids = explode("," , $this->input->post('id'));
		$this->section->delete($ids);
		$page = $this->input->post('page');

		$section_count = $this->section->get_count();
		$page_arr['total_page'] = ceil($section_count/10);
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
		
		$data = $this->section->get_sections(10, ($page-1)*10);
		array_unshift($data, $page_arr);
		echo json_encode($data);
	}
	
	public function delete_subject(){
		$sec_sub_id = $this->input->post('sec_sub_id');
		$this->section->delete_subject($sec_sub_id);
	}
	
}