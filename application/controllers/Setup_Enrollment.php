<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_Enrollment extends CI_Controller {

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
		$this->load->model('subject');
		session_start();
	}
	 
	public function index(){
		if(!isset($_SESSION['user_data'])){
			//user already logged in
			redirect('login');
		}
		
		/* $enable_next = 0;
		
		$subject_count = $this->subject->get_count();
		
		if ($subject_count > 10){
			$enable_next = 1;
		}
		*/
		$data = array('current_location' => 'setup_enrollment'
		, 'user_access' => $_SESSION['user_data']['user_access']
		, 'page' => 1
		//, 'enable_next' => $enable_next
		);
		 
		/* $data['subject_list'] = $this->subject->get_subjects(10, 0);
		if ($data['subject_list'] == 0)
		{
			$data['no_data'] = 1;
			$data['total_page'] = 1;
		}else{
			$data['no_data'] = 0;
			$data['total_page'] =  ceil($subject_count/10);
		} */
		
		$this->load->view('manage_enrollment', $data);

	}

	public function save(){
		
		$subject_id = $this->input->post('edit_flag');
		$edit_flag = false;
		
		if(!$subject_id){
			$subject_id = $this->generate_id();
		}else{
			$edit_flag = true;
		}
		
		$page = $this->input->post('page');
			
		$subject_code = $this->input->post('subject_code');
		$description = $this->input->post('description');
		
		$date_created = date("Y-m-d H:i:s");
		$date_modified = $date_created;
		$created_by = $_SESSION['user_data']['userid'];
		$modified_by = $_SESSION['user_data']['userid'];
			
		if ($edit_flag){
			$this->subject->update_subject($subject_id, $subject_code, $description, $date_modified, $modified_by);
			
		}else{
			$this->subject->add_subject($subject_id, $subject_code, $description, $date_created, $date_modified, $created_by, $modified_by);
		}
		
		//retrieve the count of subjects
		$subject_count = $this->subject->get_count();
		$page_arr['total_page'] = ceil($subject_count/10);
		
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
		
		$data = $this->subject->get_subjects(10, ($page-1)*10);
		array_unshift($data, $page_arr);
		echo json_encode($data);
	}
	
	public function page(){
		$page = $this->input->post('page');
		
		$search_flag = $this->input->post('search_flag');
		$search_arr['subject_code'] = $this->input->post('search_subject_code');
		$search_arr['description'] = $this->input->post('search_description');
		
		//$search_flag = 1;
		//$search_arr['subject_code'] = 'MATH';
		// $search_arr['fname'] = $this->input->post('search_fname');
		
		if($search_flag == 0){
			$subject_count = $this->subject->get_count();
		}else{
			$subject_count = $this->subject->get_count($search_arr);
		}
		
		$page_arr['total_page'] = ceil($subject_count/10);
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
		
		//retrieve the subjects depending on the current page
		if($search_flag == 0){
			$data = $this->subject->get_subjects(10, ($page-1)*10);
		}else{
			$data = $this->subject->get_subjects(10, ($page-1)*10, $search_arr);
		}
		
		array_unshift($data, $page_arr);
		echo json_encode($data);
	}
	
	public function generate_id(){
		return uniqid("SUB", true);
	}
	
	public function deactivate(){
		
		//convert csv into array
		$ids = explode("," , $this->input->post('id'));
		$this->subject->deactivate($ids);
		$page = $this->input->post('page');
		
		//retrieve the last announcements
		$user_count = $this->subject->get_count();
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
		
		$data = $this->subject->get_subjects(10, ($page-1)*10);
		array_unshift($data, $page_arr);
		echo json_encode($data);
		
	}
	
	public function activate(){
		
		//convert csv into array
		$ids = explode("," , $this->input->post('id'));
		
		//$ids = explode(",","SUB56f4e62d142514.657106");
		
		$this->subject->activate($ids);
		$page = $this->input->post('page');
		
		//$page = 1;
		
		//retrieve the last announcements
		$subject_count = $this->subject->get_count();
		$page_arr['total_page'] = ceil($subject_count/10);
		
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
		
		$data = $this->subject->get_subjects(10, ($page-1)*10);
		array_unshift($data, $page_arr);
		echo json_encode($data);
		
	}
	
	//returns subject details
	public function get_subject_details(){
		
		$subject_id = $this->input->post('subject_id');
		//$user_id = '03452420014559818094533';
		
		$data = $this->subject->get_subject($subject_id);
		
		//array_unshift($data, $user_basic_data);
		
		echo json_encode($data);
	}
	
}