<?php
class Announcement extends CI_Model {

	function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
		$this->load->database();
	}
	
	//retrieves teacher announcements
	//function will return recent n announcement titles where n = $limit
	//if $limit and $offset = 0 then, retrieve all data
	//returns result in a form of multidimentional array.
	public function get_teacher_announcements($limit, $offset){
		$contents = array();
		$content_data = array();
		
		if ($limit == 0 && $offset == 0){
			$rs = $this->db->query("SELECT * FROM announcement WHERE type IN('1','0') AND deleted = '0' ORDER BY date_published desc limit".$limit.", ".$offset);
		}else{
			$rs = $this->db->query("SELECT * FROM announcement WHERE type IN('1','0') AND deleted = '0' ORDER BY date_published desc limit");
		}
		
		foreach($rs->result() as $row){
			$content_data['id'] = $row->id;
			$content_data['title'] = $row->title;
			$content_data['type'] = $row->type;
			$content_data['date_created'] = $row->date_created;
			$content_data['date_published'] = $row->date_published;
			array_push($contents, $content_data);
		}
		
		return $contents;
	}
	
	//retrieves student's announcements
	//function will return recent n announcement titles where n = $limit
	//if $limit and $offset = 0 then, retrieve all data
	//returns result in a form of multidimentional array.
	public function get_student_announcements($limit, $offset){
		$contents = array();
		$content_data = array();
		
		if ($limit == 0 && $offset == 0){
			$rs = $this->db->query("SELECT * FROM announcement WHERE type IN('2','0') AND deleted = '0' ORDER BY date_published desc limit".$limit.", ".$offset);
		}else{
			$rs = $this->db->query("SELECT * FROM announcement WHERE type IN('2','0') AND deleted = '0' ORDER BY date_published desc limit");
		}
		
		foreach($rs->result() as $row){
			$content_data['id'] = $row->id;
			$content_data['title'] = $row->title;
			$content_data['type'] = $row->type;
			$content_data['date_created'] = $row->date_created;
			$content_data['date_published'] = $row->date_published;
			array_push($contents, $content_data);
		}
		
		return $contents;
	}

	//retrieves all announcements
	//function will return recent n announcement titles where n = $limit
	//if $limit and $offset = 0 then, retrieve all data
	//returns result in a form of multidimentional array.
	public function get_recent_announcements($limit, $offset, $search_text = "", $search_type = 0){
		
		$count = 0;
		$contents = array();
		$content_data = array();
		
		$str_limitoffset = "";

		if($limit !=0 ){
			$str_limitoffset ="LIMIT {$limit} OFFSET {$offset}";
		}
		
		$str_search = "";
		
		if($search_text != ""){
			$str_search = "AND (title LIKE '%{$search_text}%' OR content LIKE '%{$search_text}%') ";
		}
		
		if($search_type > 0){
			$str_search = $str_search."AND type = {$search_type} ";
		}

		$str_select_fields = "a.id, a.title, a.type, a.date_created, a.date_published, u.fname, u.lname";
		$rs = $this->db->query("SELECT {$str_select_fields} FROM announcement a, user u WHERE a.deleted = '0' AND u.id = a.created_by {$str_search} ORDER BY date_created desc {$str_limitoffset}");
		
		foreach($rs->result() as $row){
			$count = $count + 1;
			$content_data['id'] = $row->id;
			$content_data['title'] = (strlen($row->title) < 30)?$row->title: substr($row->title, 0, 30)."...";
			$content_data['type'] = $row->type;
			$content_data['date_created'] = $row->date_created;
			$content_data['created_by'] = $row->fname." ".$row->lname;
			$content_data['date_published'] = $row->date_published;
			array_push($contents, $content_data);
		}
		if ($count == 0)
		{
			return $count;
		}
		return $contents;
	}
	
	//retrieves an announcement based on the announcement ID passed
	//returns result in a form of array.
	public function get_announcement($id){
		$content_data = array();
		$rs = $this->db->query("SELECT a.id, a.title, a.type, a.date_created, a.date_published, a.modified_date, a.content, u.fname, u.lname, u2.fname AS mfname, u2.lname AS mlname FROM announcement a, user u, user u2 WHERE a.id = '".$id."' AND a.deleted = '0' AND a.created_by = u.id AND u2.id = a.modified_by");
		
		foreach($rs->result() as $row){
			$content_data['id'] = $row->id;
			$content_data['title'] = $row->title;
			$content_data['type'] = $row->type;
			$content_data['date_created'] = $row->date_created;
			$content_data['date_published'] = $row->date_published;
			$content_data['date_modified'] = $row->modified_date;
			$content_data['content'] = $row->content;
			$content_data['created_by'] = $row->fname." ".$row->lname;
			$content_data['modified_by'] = $row->mfname." ".$row->mlname;
		}
		return $content_data;
	}
	
	//insert announcement data in to the database
	public function add_announcement($id, $title, $type, $date_created, $date_published, $created_by, $content, $modified_by, $modified_date){
		$content_data = Array('id' => $id
								, 'title' => $title
								, 'type' => $type
								, 'date_created' => $date_created
								, 'date_published' => $date_published
								, 'created_by' => $created_by
								, 'content' => $content
								, 'modified_date' => $modified_date
								, 'modified_by' => $modified_by);
		$this->db->insert('announcement', $content_data);
	}
	
	//update announcement
	//if date_published is not empty, announcement considered as published
	public function update_announcement($id, $title, $type, $date_created, $date_published, $created_by, $content,  $modified_by, $modified_date){
		$content_data = Array('title' => $title
								, 'type' => $type
								, 'date_published' => $date_published
								, 'created_by' => $created_by
								, 'content' => $content
								, 'modified_date' => $modified_date
								, 'modified_by' => $modified_by);
		$this->db->where('id', $id);
		$this->db->update('announcement', $content_data);
	}
	
	//delete_announcement
	//deletes a specific announcement given the announcement id
	public function delete_announcement($id){
		$this->db->delete('announcement', array('id'=>$id));
	}	
	
	//deletes multiple rows of announcements given the announcement array
	public function delete_announcements($ids){
		$str_ids = "('".implode("','" , $ids)."')";
		$this->db->query("UPDATE announcement SET deleted = '1' WHERE id IN {$str_ids}");
	}
	
	public function count_announcements($search_text = "", $search_type = 0){
		$count = 0;
		$str_where = "";
		if($search_type > 0){
			$str_where = "AND type = {$search_type}";
		}
		if($search_text != ""){
			$str_where = $str_where . " AND (title LIKE '%{$search_text}%' OR content LIKE '%{$search_text}%') ";
		}
		
		$rs = $this->db->query("SELECT count(*) AS count FROM announcement WHERE deleted = '0' {$str_where}");
		
		foreach($rs->result() as $row){
			$count = $row->count;
		}
		
		return $count;
		
		// $this->db->where('deleted',0);
		// if($search_type > 0){
			// $this->db->where('type', $search_type);
		// }
		// if($search_text != ""){
			// $this->db->like('title',$search_text);
			// $this->db->or_like('title',$search_text);
		// }
		// $count = $this->db->get('announcement');
		// return $count->num_rows();
	}
}

?>