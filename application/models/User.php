<?php

class User extends CI_Model {

	function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
		$this->load->database();
	}
	
	//validate user login
	//returns 0 if user does not exists in the database
	//returns actual user_id if user is valid
	public function validate_user($username, $password){
		$user_id = 0;
		$password = md5($password);
		$this->db->select('id');
		$row = $this->db->get_where('user', array('username' => $username, 'password' => $password))->result();
		//$row = $this->db->result();
		if (count($row) > 0){
			$user_id = $row[0]->id;
		}
		return $user_id;
	}

	public function get_name($id){
	
		$name = "";
		$this->db->select('fname');
		$this->db->select('lname');
		$row = $this->db->get_where('user', array('id' => $id))->result();
		//$row = $this->db->result();
		if (count($row) > 0){
			$name = $row[0]->fname." ".$row[0]->lname;
		}
		return $name;
	}
	
	//insert user data to user in the database
	public function add_user($userid, $firstname, $lastname, $usertype, $username, $password){
		$userdata = Array('id' => $userid
		, 'fname' => $firstname
		, 'lname' => $lastname
		, 'usertype' => $usertype
		, 'username' => $username
		, 'password' => md5($password)
		, 'status' => 1);
		$this->db->insert('user', $userdata);
	}
	
	//insert a user detail in the database
	public function add_user_details($userid, $birthdate, $telephone, $cellphone, $email, $add_province, $zip_province, $add_city, $zip_city, $mother, $father, $user_access){
		$userdetails = Array('user_id' => $userid
		, 'birthdate' => $birthdate
		, 'telephone_no' => $telephone
		, 'cellphone_no' => $cellphone
		, 'email' => $email
		, 'address_province' => $add_province
		, 'zipcode_province' => $zip_province
		, 'address_city' => $add_city
		, 'zipcode_city' => $zip_city
		, 'mother_name' => $mother
		, 'father_name' => $father
		, 'user_access' => $user_access);
		$this->db->insert('user_details', $userdetails);
	}	
	
	//returns array of objects given the userid
	public function get_user_details($userid){
		$userdetails = Array();
		//$this->db->select('birthdate');
		$row = $this->db->get_where('user_details', array('user_id' => $userid))->result();
		
		$userdetails = Array('id' => $userid
		, 'birthdate' => $row[0]->birthdate
		, 'telephone_no' => $row[0]->telephone_no
		, 'cellphone_no' => $row[0]->cellphone_no
		, 'email' => $row[0]->email
		, 'address_province' => $row[0]->address_province
		, 'zipcode_province' => $row[0]->zipcode_province
		, 'address_city' => $row[0]->address_city
		, 'zipcode_city' => $row[0]->zipcode_city
		, 'mother_name' => $row[0]->mother_name
		, 'father_name' => $row[0]->father_name
		, 'user_access' => $row[0]->user_access
		);
		
		// foreach($row as $user){
			// $userdetails['id'] = $user->user_id;
			// $userdetails['birthdate'] = $user->birthdate;
		// }
		
		return $userdetails;
	}
	
	//returns user basic data from record user
	
	public function get_user_data($userid){
		$userdetails = Array();
		//$this->db->select('birthdate');
		$row = $this->db->get_where('user', array('id' => $userid))->result();
		
		$userdetails = Array('id' => $userid
		, 'fname' => $row[0]->fname
		, 'lname' => $row[0]->lname
		, 'usertype' => $row[0]->usertype
		, 'username' => $row[0]->username
		, 'status' => $row[0]->status);
		
		return $userdetails;
	}
	
	//returns user login and details
	public function get_user_info($userid){
		
		$userdata = array();
		
		$rs = $this->db->query("SELECT u.id, u.fname, u.lname, u.usertype, u.username, u.status, ud.birthdate, ud.telephone_no, ud.cellphone_no, ud.email, ud.address_province, ud.address_city, ud.zipcode_province, ud.zipcode_city, ud.mother_name, ud.father_name, ud.user_access FROM user u left join user_details ud on ud.user_id = u.id WHERE u.id = '".$userid."'");
		
		foreach($rs->result() as $row){
			
			$userdata['id'] = $userid;
			$userdata['fname'] =  $row->fname;
			$userdata['lname'] =  $row->lname;
			$userdata['usertype'] =  $row->usertype;
			$userdata['username'] =  $row->username;
			$userdata['status'] =  $row->status;
			$userdata['birthdate'] =  $row->birthdate;
			$userdata['telephone_no'] =  $row->telephone_no;
			$userdata['cellphone_no'] =  $row->cellphone_no;
			$userdata['email'] =  $row->email;
			$userdata['address_province'] =  $row->address_province;
			$userdata['zipcode_province'] =  $row->zipcode_province;
			$userdata['address_city'] =  $row->address_city;
			$userdata['zipcode_city'] =  $row->zipcode_city;
			$userdata['mother_name'] =  $row->mother_name;
			$userdata['father_name'] =  $row->father_name;
			$userdata['user_access'] =  $row->user_access;
			
		}
		
		return $userdata;
	}
	
	//returns user_access description
	public function get_user_access_descr($useraccess)
	{
		$user_access_descr = '';
		$this->db->select('description');
		$row = $this->db->get_where('user_access', array('type' => $useraccess))->result();
		if(!isset($row[0]))
		{
			$user_access_descr = "Not Set";
		}else
		{
			$user_access_descr = $row[0]->description;
		}
		return $user_access_descr;
		
	}
	
	//returns position description
	public function get_position_descr($position)
	{
		$position_descr = '';
		$this->db->select('description');
		$row = $this->db->get_where('position', array('type' => $position))->result();
		if(!isset($row[0]))
		{
			$position_descr = "Not Set";
		}else
		{
			$position_descr = $row[0]->description;
		}
		return $position_descr;
		
	}
	
	//returns user access
	public function get_user_access($userid){
		$user_access = '3';
		$this->db->select('user_access');
		$row = $this->db->get_where('user_details', array('user_id' => $userid))->result();
		$user_access = $row[0]->user_access;
		return $user_access;
	}
	
	public function get_users($limit, $offset, array $search_array = array()){
		
		$users = array();
		$user_data = array();
		
		$str_limitoffset = "";

		if($limit !=0 ){
			$str_limitoffset ="LIMIT {$limit} OFFSET {$offset}";
		}
		
		$str_search = "";
		
		if (!empty($search_array)){
			if($search_array['username']!= NULL){
				$str_search = "AND username LIKE '%{$search_array['username']}%' ";
			}
			
			if($search_array['fname']!= NULL){
				$str_search = "AND fname LIKE '%{$search_array['fname']}%' ";
			}
			
			if($search_array['lname']!= NULL){
				$str_search = "AND lname LIKE '%{$search_array['fname']}%' ";
			}
		}

		$str_select_fields = "u.id, u.username, u.fname, u.lname, u.usertype, u.status, p.description";
		$rs = $this->db->query("SELECT {$str_select_fields} FROM user u, position p WHERE u.usertype = p.type {$str_search} {$str_limitoffset}");
		
		foreach($rs->result() as $row){
			$user_data['user_id'] = $row->id;
			$user_data['username'] = $row->username;
			$user_data['fname'] = $row->fname;
			$user_data['lname'] = $row->lname;
			$user_data['user_type'] = $row->usertype;
			$user_data['status'] = $row->status;
			$user_data['position'] = $row->description;
			array_push($users, $user_data);
		}
		return $users;	
	}
	
	public function get_positions(){
		$positions = array();
		$position_data = array();
		$rows = $this->db->get('position')->result();
		
		foreach($rows as $row){
			$position_data['type'] = $row->type;
			$position_data['description'] = $row->description;
			array_push($positions, $position_data);
		}
		return $positions;
	}
	
	public function get_count(array $search_array = array()){
		
		$count = 0;
		$users = array();
		
		$user_data = array();
		
		$str_limitoffset = "";
		
		$str_search = "";
		
		if (!empty($search_array)){
			if($search_array['username']!= NULL){
				$str_search = "AND username LIKE '%{$search_array['username']}%' ";
			}
			
			if($search_array['fname']!= NULL){
				$str_search = "AND fname LIKE '%{$search_array['fname']}%' ";
			}
			
			if($search_array['lname']!= NULL){
				$str_search = "AND lname LIKE '%{$search_array['fname']}%' ";
			}
		}
		
		$rs = $this->db->query("SELECT count(*) as count FROM user u, position p WHERE u.usertype = p.type {$str_search}");
		
		foreach($rs->result() as $row){
			$count = $row->count;
		}
		
		return $count;
		
	}
	
	public function deactivate($userids){
		
		$str_ids = "('".implode("','" , $userids)."')";
		$this->db->query("UPDATE user SET status = '0' WHERE id IN {$str_ids}");
		
	}

	public function activate($userids){
		
		$str_ids = "('".implode("','" , $userids)."')";
		$this->db->query("UPDATE user SET status = '1' WHERE id IN {$str_ids}");
	}
	
	//updates the user data from table user
	public function update_user_data($id, $fname, $lname, $usertype, $username){
		
		$rs = $this->db->query("UPDATE user SET fname = '{$fname}', lname = '{$lname}', usertype = '{$usertype}', username = '{$username}' WHERE id = '{$id}'");
		
	}
	
	//updates the user data from table user
	public function update_user_details($id, $birthdate, $telephone_no, $cellphone_no, $email, $address_province, $zipcode_province, $address_city, $zipcode_city, $mother_name, $father_name, $user_access){
		$rs = $this->db->query("UPDATE user_details SET birthdate = '{$birthdate}', telephone_no = '{$telephone_no}', cellphone_no = '{$cellphone_no}', email = '{$email}', address_province = '{$address_province}', zipcode_province = '{$zipcode_province}', address_city = '{$address_city}' , zipcode_city = '{$zipcode_city}', mother_name = '{$mother_name}', father_name = '{$father_name}', user_access = '{$user_access}' WHERE user_id = '{$id}'");
	}
	
	//returns all teachers
	public function get_teachers(){
		
		$users = array();
		$user_data = array();
		
		$str_select_fields = "u.id, u.fname, u.lname";
		$rs = $this->db->query("SELECT {$str_select_fields} FROM USER u, user_access ua	WHERE u.usertype = ua.type AND ua.type = 'Teacher' AND u.status = 1");
		
		foreach($rs->result() as $row){
			$user_data['user_id'] = $row->id;
			$user_data['fname'] = $row->fname;
			$user_data['lname'] = $row->lname;
			array_push($users, $user_data);
		}
		return $users;
	}
}
?>