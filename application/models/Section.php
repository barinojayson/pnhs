<?php
class Section extends CI_Model {

	function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
		$this->load->database();
	}
	
	//inserts section into the database.
	public function add_section($id, $section_name, $year_level, $max_student, $waive_flag, $created_by, $modified_by){
		$section_data = Array('id' => $id
							,'section_name' => $section_name
							, 'year_level' => $year_level
							, 'max_student' => $max_student
							, 'waive_flag' => $waive_flag
							, 'created_by' => $created_by
							, 'modified_by' => $modified_by
							, 'date_created' => date("Y-m-d H:i:s")
							, 'date_modified' => date("Y-m-d H:i:s")
						);
		$this->db->insert('section', $section_data);
	}

	//inserts section into the database.
	public function edit_section($id, $section_name, $year_level, $max_student, $waive_flag, $created_by, $modified_by){
		$section_data = Array('section_name' => $section_name
							, 'year_level' => $year_level
							, 'max_student' => $max_student
							, 'waive_flag' => $waive_flag
							, 'modified_by' => $modified_by
							, 'date_modified' => date("Y-m-d H:i:s")
						);
		$this->db->where('id', $id);
		$this->db->update('section', $section_data);
	}

	//retrieve section list
	public function get_sections($limit, $offset, array $search_array = array()){
		
		$count = 0;
		$section_arr = array();
		$section_data = array();
		
		$str_limitoffset = "";

		if($limit !=0 ){
			$str_limitoffset ="LIMIT {$limit} OFFSET {$offset}";
		}
		
		$str_search = "";
		
		//if user entered search keys:
		if (!empty($search_array)){
			if($search_array['section_name']!= NULL){
				$str_search .= "AND section_name LIKE '%{$search_array['section_name']}%' ";
			}
			if($search_array['year_level']!= -1){
				$str_search .= "AND year_level = '{$search_array['year_level']}' ";
			}
			if($search_array['max_student']!= NULL){
				$str_search .= "AND max_student = '{$search_array['max_student']}' ";
			}
			/* if($search_array['waive_flag']!= NULL){
				$str_search .= "AND waive_flag = '{$search_array['waive_flag']}' ";
			} */
		}
		

		$str_select_fields = "*";
		$rs = $this->db->query("SELECT {$str_select_fields} FROM section s WHERE deleted = 0 {$str_search} ORDER BY date_created desc {$str_limitoffset}");
		
		foreach($rs->result() as $row){
			$count = $count + 1;
			$section_data['id'] = $row->id;
			$section_data['section_name'] = $row->section_name;
			$section_data['year_level'] = $row->year_level;
			$section_data['max_student'] = $row->max_student;
			$section_data['created_by'] = $row->created_by;
			$section_data['modified_by'] = $row->modified_by;
			$section_data['date_created'] = $row->date_created;
			$section_data['date_modified'] = $row->date_modified;
			$section_data['waive_flag'] = $row->waive_flag;
			if($row->waive_flag == 1){
				$section_data['waive'] = "Yes";
			}else{
				$section_data['waive'] = "No";
			}
			array_push($section_arr, $section_data);
		}
		
		return $section_arr;	
	}
	
	
	//count sections
	public function get_count(array $search_array = array()){
		
		$count = 0;
		$sections_arr = array();
		
		$section_data = array();
		
		$str_limitoffset = "";
		
		$str_search = "";
		
		//if user entered search keys:
		if (!empty($search_array)){
			if($search_array['section_name']!= NULL){
				$str_search = "AND section_name LIKE '%{$search_array['section_name']}%' ";
			}

		}
		
		$rs = $this->db->query("SELECT count(*) as count FROM section s  WHERE deleted = 0 {$str_search}");
		
		foreach($rs->result() as $row){
			$count = $row->count;
		}
		
		return $count;
		
	}
	
	public function delete($section_ids){
		
		$str_ids = "('".implode("','" , $section_ids)."')";
		$this->db->query("UPDATE section SET deleted = '1' WHERE id IN {$str_ids}");
		
	}
	
	//returns section details
	public function get_section($section_id){
		
		$sectiondata = array();
		
		$rs = $this->db->query("SELECT s.id, s.section_name, s.year_level, s.max_student, s.waive_flag, s.created_by, s.modified_by, s.date_created, s.date_modified, yl.description FROM section s, year_level yl WHERE s.id = '".$section_id."' AND s.deleted = 0 AND yl.id = s.year_level");
		
		foreach($rs->result() as $row){
			
			$sectiondata['id'] = $section_id;
			$sectiondata['section_name'] = $row->section_name;
			$sectiondata['year_level'] =  $row->year_level;
			$sectiondata['max_student'] =  $row->max_student;
			$sectiondata['waive_flag'] =  $row->waive_flag;
			$sectiondata['created_by'] =  $row->created_by;
			$sectiondata['modified_by'] =  $row->modified_by;
			$sectiondata['date_created'] =  $row->date_created;
			$sectiondata['date_modified'] =  $row->date_modified;
			$sectiondata['year_description'] =  $row->description;
		}
		return $sectiondata;
	}
	
	//return subjects in a section
	public function get_subjects_by_section($section_id){
		$count = 0;
		$sec_subject_arr = array();
		$sec_subject_data_arr = array();

		$str_select_fields = "*";
		$rs = $this->db->query("SELECT * FROM section_subject_view s WHERE s.section_id = '{$section_id}'");
		
		foreach($rs->result() as $row){
			$count = $count + 1;
			$sec_subject_data_arr['sec_sub_id'] = $row->sec_sub_id;
			$sec_subject_data_arr['section_id'] = $section_id;
			$sec_subject_data_arr['section_name'] = $row->section_name;
			$sec_subject_data_arr['subject_code'] = $row->subject_code;
			$sec_subject_data_arr['subject_description'] = $row->description;
			$sec_subject_data_arr['teacher'] = $row->fname." ".$row->lname;
			$sec_subject_data_arr['subject_id'] = $row->subject_id;
			$sec_subject_data_arr['user_id'] = $row->user_id;
			
			array_push($sec_subject_arr, $sec_subject_data_arr);
		}
		
		return $sec_subject_arr;
	}
	
	public function update_section_subject($sec_sub_id, $subject_id){
		
		$affected_rows = 0; //set to -1 for update error
		$this->db->query("UPDATE section_subject SET subject_id = '{$subject_id}' WHERE sec_sub_id = {$sec_sub_id}");
		
		return $this->db->affected_rows();
	}
	
	public function update_section_subject_teacher($sec_sub_id, $teacher_id){
		
		$affected_rows = 0; //set to -1 for update error
		$this->db->query("UPDATE section_subject SET user_id = '{$teacher_id}' WHERE sec_sub_id = {$sec_sub_id}");
		
		return $this->db->affected_rows();
	}
	
	public function add_subject($section_id, $subject_id, $teacher_id){
		$this->db->query("INSERT INTO section_subject(section_id, subject_id, user_id) values ('{$section_id}','{$subject_id}','{$teacher_id}')");
	}
	
	public function get_sec_sub_id($section_id, $subject_id, $teacher_id){
		$rs = $this->db->query("SELECT sec_sub_id FROM section_subject s WHERE s.section_id = '{$section_id}' AND s.subject_id = '{$subject_id}' AND s.user_id = '{$teacher_id}'");
		
		$row = $rs->result();
		
		return $row[0]->sec_sub_id;
	}
	
	public function delete_subject($sec_sub_id){
		$this->db->query("DELETE FROM section_subject WHERE sec_sub_id = '{$sec_sub_id}'");
	}
}
?>