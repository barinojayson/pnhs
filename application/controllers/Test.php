<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

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
	 
	public function index()
	{
//retrieve the last announcements
		$announcement_count = $this->announcement->count_announcements();
		$page = 1;
		if($page < (ceil($announcement_count/10))){
			$page_arr['next'] = 1;
		}else{
			$page_arr['next'] = 0;
		}
		
		if($page == 1){
			$page_arr['prev'] = 0;
		}else{
			$page_arr['prev'] = 1;
		}
		
		//$page_arr['prev'] = 0;

		$data = $this->announcement->get_recent_announcements(10, 0);
		array_unshift($data, $page_arr);
		echo json_encode($data);
		
	}
}
