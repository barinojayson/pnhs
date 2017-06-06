<?php

class Subject extends CI_Model {

	function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
		$this->load->database();
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
	public function add_subject($subject_id, $subject_code, $description, $date_created, $date_modified, $created_by, $modified_by){
		$subjectdata = Array('id' => $subject_id
		, 'subject_code' => $subject_code
		, 'description' => $description
		, 'date_created' => $date_created
		, 'date_modified' => $date_modified
		, 'created_by' => $created_by
		, 'modified_by' => $modified_by
		, 'status' => 1);
		$this->db->insert('subject', $subjectdata);
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
	
	//returns subject details
	public function get_subject($subject_id){
		
		$subjectdata = array();
		
		$rs = $this->db->query("SELECT s.subject_code, s.description, s.created_by, s.modified_by, s.date_created, s.date_modified, s.status, u.fname as cfname, u.lname as clname, mu.fname as mfname, mu.lname as mlname FROM subject s, user u, user mu  WHERE s.id = '".$subject_id."' AND u.id = s.created_by AND mu.id = s.modified_by");
		
		foreach($rs->result() as $row){
			
			$subjectdata['id'] = $subject_id;
			$subjectdata['subject_code'] = $row->subject_code;
			$subjectdata['description'] =  $row->description;
			$subjectdata['created_by'] =  $row->created_by;
			$subjectdata['modified_by'] =  $row->modified_by;
			$subjectdata['date_created'] =  $row->date_created;
			$subjectdata['date_modified'] =  $row->date_modified;
			$subjectdata['creator_name'] =  $row->cfname." ".$row->clname;
			$subjectdata['modifier_name'] =  $row->mfname." ".$row->mlname;
			$subjectdata['status'] =  $row->status;
		}
		return $subjectdata;
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
	
	public function get_subjects($limit, $offset, array $search_array = array()){
		
		$count = 0;
		$subjects = array();
		$subject_data = array();
		
		$str_limitoffset = "";

		if($limit !=0 ){
			$str_limitoffset ="LIMIT {$limit} OFFSET {$offset}";
		}
		
		$str_search = "";
		
		//if user entered search keys:
		if (!empty($search_array)){
			if($search_array['subject_code']!= NULL){
				$str_search = "AND subject_code LIKE '%{$search_array['subject_code']}%' ";
			}
			
			if($search_array['description']!= NULL){
				$str_search = $str_search."AND description LIKE '%{$search_array['description']}%' ";
			}
		}

		$str_select_fields = "*";
		$rs = $this->db->query("SELECT {$str_select_fields} FROM subject s WHERE 1 = 1 {$str_search} ORDER BY date_created desc {$str_limitoffset}");
		
		foreach($rs->result() as $row){
			$count = $count + 1;
			$subject_data['id'] = $row->id;
			$subject_data['subject_code'] = $row->subject_code;
			$subject_data['description'] = $row->description;
			$subject_data['created_by'] = $row->created_by;
			$subject_data['modified_by'] = $row->modified_by;
			$subject_data['date_created'] = $row->date_created;
			$subject_data['date_modified'] = $row->date_modified;
			$subject_data['status'] = $row->status;
			
			array_push($subjects, $subject_data);
		}
		
		if ($count == 0){
			return $count;
		}
		return $subjects;	
	}
	
	public function get_count(array $search_array = array()){
		
		$count = 0;
		$subjects = array();
		
		$subject_data = array();
		
		$str_limitoffset = "";
		
		$str_search = "";
		
		//if user entered search keys:
		if (!empty($search_array)){
			if($search_array['subject_code']!= NULL){
				$str_search = "AND subject_code LIKE '%{$search_array['subject_code']}%' ";
			}
			
			if($search_array['description']!= NULL){
				$str_search = $str_search."AND description LIKE '%{$search_array['description']}%' ";
			}
		}
		
		$rs = $this->db->query("SELECT count(*) as count FROM subject s  WHERE 1 = 1 {$str_search}");
		
		foreach($rs->result() as $row){
			$count = $row->count;
		}
		
		return $count;
		
	}
	
	public function deactivate($subject_ids){
		
		$str_ids = "('".implode("','" , $subject_ids)."')";
		$this->db->query("UPDATE subject SET status = '0' WHERE id IN {$str_ids}");
		
	}

	public function activate($subject_ids){
		
		$str_ids = "('".implode("','" , $subject_ids)."')";
		$this->db->query("UPDATE subject SET status = '1' WHERE id IN {$str_ids}");
	}
	
	//updates the subject
	public function update_subject($subject_id, $subject_code, $description, $date_modified, $modified_by){
		
		$rs = $this->db->query("UPDATE subject SET subject_code = '{$subject_code}', description = '{$description}', date_modified = '{$date_modified}', modified_by = '{$modified_by}' WHERE id = '{$subject_id}'");
	}
	
}
?>