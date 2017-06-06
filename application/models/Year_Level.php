<?php
class Year_Level extends CI_Model {

	function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
		$this->load->database();
	}
	
	//inserts year level in to the database.
	public function add_year_level($year_id, $year_level, $description, $created_by){
		$year_level_data = Array('id' => $year_id
								, 'grade_level' => $year_level
								, 'description' => $description
								, 'date_created' => date("Y-m-d H:i:s")
								, 'created_by' => $created_by
								, 'deleted' => 0);
		$this->db->insert('year_level', $year_level_data);
	}
	
	//updates year level in the database
	public function update_year_level($year, $description, $comments, $date_created, $created_by){
		$year_level_data = Array('description' => $description
								, 'comments' => $comments
								, 'date_created' => $date_created
								, 'created_by' => $created_by);
		$this->db->where('year', $year);
		$this->db->update('year_level', $year_level_data);
	}
	
	//deletes a specific year level given the year
	public function delete_year_level($year){
		$this->db->delete('year_level', array('year'=>$year));
	}

	//retrieves all year levels
	//returns result in a form of multidimentional array.
	public function get_all_year_levels(){
		$year_levels = array();
		$year_level_data = array();
		
		$rs = $this->db->query("SELECT * FROM year_level WHERE deleted = '0'");
		foreach($rs->result() as $row){
			$year_level_data['id'] = $row->id;
			$year_level_data['grade_level'] = $row->grade_level;
			$year_level_data['description'] = $row->description;
			$year_level_data['date_created'] = $row->date_created;
			array_push($year_levels, $year_level_data);
		}
		return $year_levels;
	}

	//retrieves year level given a year
	//returns result in a form of array.
	public function get_year_level($year){
		$year_level_data = array();
		$rs = $this->db->query("SELECT * FROM year_level WHERE year = '".$year."'");
		$row = $rs->result();
		
		$year_level_data['year'] = $row->year;
		$year_level_data['description'] = $row->description;
		$year_level_data['comments'] = $row->comments;
		$year_level_data['date_created'] = $row->date_created;
		$year_level_data['created_by'] = $row->created_by;
		
		return $year_level_data;
	}
	
	public function get_year_level_by_id($yl_id){
		
		$data = array();
		
		$rs = $this->db->query("SELECT yl.*, u.fname, u.lname FROM year_level yl LEFT JOIN USER u ON yl.created_by = u.id WHERE yl.id = '{$yl_id}' AND yl.deleted = 0");
		
		foreach($rs->result() as $row){
			
			$data['id'] = $yl_id;
			$data['grade_level'] = $row->grade_level;
			$data['description'] =  $row->description;
			$data['date_created'] =  $row->date_created;
			$data['created_by'] =  $row->created_by;
			$data['creator_name'] = $row->fname." ".$row->lname;
		}
		return $data;
	}
	
	public function get_count(array $search_array = array()){
		
		$count = 0;
		$year_levels = array();
		$year_level_data = array();
		$str_limitoffset = "";
		
		$str_search = "";
		
		// if user entered search keys:
		if (!empty($search_array)){
			if($search_array['year_level']!= NULL){
				$str_search = "AND grade_level LIKE '%{$search_array['year_level']}%' ";
			}
			
			if($search_array['description']!= NULL){
				$str_search = $str_search."AND description LIKE '%{$search_array['description']}%' ";
			}
		}
		
		$rs = $this->db->query("SELECT count(*) as count FROM year_level WHERE deleted <> '1' {$str_search}");
		
		foreach($rs->result() as $row){
			$count = $row->count;
		}
		
		return $count;	
	}
	
	public function get_year_levels($limit, $offset, array $search_array = array()){
		
		$count = 0;
		$year_levels = array();
		$yl_data = array();
		
		$str_limitoffset = "";

		if($limit !=0 ){
			$str_limitoffset ="LIMIT {$limit} OFFSET {$offset}";
		}
		
		$str_search = "";
		
		//if user entered search keys:
		if (!empty($search_array)){
			if($search_array['year_level']!= NULL){
				$str_search = "AND grade_level LIKE '%{$search_array['year_level']}%' ";
			}
			
			if($search_array['description']!= NULL){
				$str_search = $str_search."AND description LIKE '%{$search_array['description']}%' ";
			}
		}

		$str_select_fields = "*";
		$rs = $this->db->query("SELECT {$str_select_fields} FROM year_level y WHERE deleted <> '1' {$str_search} ORDER BY date_created desc {$str_limitoffset}");
		
		foreach($rs->result() as $row){
			$count = $count + 1;
			$yl_data['id'] = $row->id;
			$yl_data['grade_level'] = $row->grade_level;
			$yl_data['description'] = $row->description;
			$yl_data['date_created'] = $row->date_created;
			
			array_push($year_levels, $yl_data);
		}
		
		return $year_levels;	
	}
	
	
	public function delete($year_ids){
		$str_ids = "('".implode("','" , $year_ids)."')";
		$this->db->query("UPDATE year_level SET deleted = '1' WHERE id IN {$str_ids}");
	}
	
}

?>