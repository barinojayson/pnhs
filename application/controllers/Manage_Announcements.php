<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_Announcements extends CI_Controller {

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
		$this->load->model('announcement');
		session_start();
	}
	 
	public function index(){
		if(!isset($_SESSION['user_data'])){
			//user already logged in
			redirect('login');
		}
		
		$enable_next = 0;
		
		$announcement_count = $this->announcement->count_announcements();
		
		if ($announcement_count > 10){
			$enable_next = 1;
		}
		
		$data = array('current_location' => 'manage_announcements'
		, 'user_access' => $_SESSION['user_data']['user_access']
		, 'page' => 1
		, 'enable_next' => $enable_next
		, 'total_page' => ceil($announcement_count/10));
		
		$data['announcement_list'] = $this->announcement->get_recent_announcements(10, 0);
		
		if($data['announcement_list'] == 0)
		{
			$data['no_data'] = 1;
		}
		else{
			$data['no_data'] = 0;
		}
		
		$this->load->view('manage_announcements', $data);
	}
	
	function get_announcement_detail(){
		$id = $this->input->post('announcement_id');
		//$id = "ANN56ac84b598c650.731425";
		$data = $this->announcement->get_announcement($id);
		echo json_encode($data);
	}
	
	function save(){
		$id = $this->input->post('edit_flag');
		$edit_flag = false;
		
		if(!$id){
			$id = uniqid("ANN", true);
		}else{
			$edit_flag = true;
		}
		
		$page = $this->input->post('page');
		$title = $this->input->post('title');
		$type = $this->input->post('type');
		$published_date = date("Y-m-d",strtotime($this->input->post('datepicker')));
		$content = $this->input->post('content');
		
		$date_created = date("Y-m-d H:i:s");
		$created_by = $_SESSION['user_data']['userid'];
		$modified_by = $_SESSION['user_data']['userid'];
		$modified_date = date("Y-m-d H:i:s");
		if ($edit_flag){
			$this->announcement->update_announcement($id, $title, $type, $date_created, $published_date, $created_by, $content, $modified_by, $modified_date);
		}else{
			$this->announcement->add_announcement($id, $title, $type, $date_created, $published_date, $created_by, $content, $modified_by, $modified_date);
		}

		//retrieve the last announcements
		$announcement_count = $this->announcement->count_announcements();
		$page_arr['total_page'] = ceil($announcement_count/10);
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

		$data = $this->announcement->get_recent_announcements(10, ($page-1)*10);
		array_unshift($data, $page_arr);
		echo json_encode($data);
	}
	
	function delete(){
	
		//convert csv into array
		$ids = explode("," , $this->input->post('id'));
		$this->announcement->delete_announcements($ids);
		$page = $this->input->post('page');
		
		//retrieve the last announcements
		$announcement_count = $this->announcement->count_announcements();
		$page_arr['total_page'] = ceil($announcement_count/10);
		if ($announcement_count % 10 == 0){
			$page = $page-1;
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
		
		$data = $this->announcement->get_recent_announcements(10, ($page-1)*10);
		array_unshift($data, $page_arr);
		echo json_encode($data);
	}
	
	function page(){
		$page = $this->input->post('page');
		
		$search_flag = $this->input->post('search_flag');
		$search_text = $this->input->post('search_text');
		$search_type = $this->input->post('search_type');
		
		// $search_flag = true;
		// $search_text = "test";
		// $search_type = 1;
		
		//retrieve the last announcements
		if(!$search_flag){
			$announcement_count = $this->announcement->count_announcements();
		}else{
			$announcement_count = $this->announcement->count_announcements($search_text, $search_type);
		}
		
		$page_arr['total_page'] = ceil($announcement_count/10);

		//check if page to access is last page
		//if $page = 0, jquery is trying to access last page.
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
		
		//retrieve the last announcements
		if(!$search_flag){
			$data = $this->announcement->get_recent_announcements(10, ($page-1)*10);
		}else{
			$data = $this->announcement->get_recent_announcements(10, ($page-1)*10, $search_text, $search_type);
		}
		
		array_unshift($data, $page_arr);
		echo json_encode($data);
	}
	
	function test(){
		//retrieve the last announcements
		$announcement_count = $this->announcement->count_announcements();
		$page = 1;
		if($page < (ceil($announcement_count/10))){
			$page_arr['next'] = 1;
		}else{
			$page_arr['next'] = 0;
		}
		$page_arr['prev'] = 0;

		$data = $this->announcement->get_recent_announcements(10, 0);
		array_unshift($data, $page_arr);
		echo json_encode($data);
	}	
}