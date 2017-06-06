<!DOCTYPE html>
<html>

<?php $this->load->view('header'); ?>

<body>
<script type = "text/javascript" src="<?php echo base_url();?>assets/js/subject.js"></script>

<?php $this->load->view('add_subject'); ?>
<?php $this->load->view('view_subject'); ?>
<div class = "header">header image here</div>
<div class = "container">
	
	<div class = "outer_content">
		<div class = "inner_content">
			
			<?php $this->load->view('menu'); ?>
			
			<div class = "main_content border_thm">
				<div class = "inner_content">
					<div class = "text_title1" style = "margin: 10px;" >Setup Subjects
					<div class = "page_message" id = "page_message"></div>
					</div>
					<div class = "search_box">
						<table style = "width: 100%; ">
							<tr>
								<td style = "width: 25%">Subect Code</td>
								<td><input type = 'text' maxlength= "50" id = 'search_subject_code' class = "textinput" /></td>
							</tr>
							<tr>
								<td style = "width: 25%">Description</td>
								<td><input type = 'text' maxlength= "50" id = 'search_description' class = "textinput" /></td>
							</tr>
							<tr>
								<td></td>
								<td style = "text-align: right;">
								<input type = "button" class = "button" id = "search_subject_clearbt" value = "Clear" >
								<input type = "button" class = "button" name = "section_add" value = "Search" id = "search_subject_searchbt" >
								
								<input type = "hidden" id = "search_flag_subject" value = 0 />

								<input type = "hidden" id = "search_subject_code_hidden" value = "" />
								<input type = "hidden" id = "search_description_hidden" value = "" />
								
								</td>
							</tr>
						</table>
					</div>
					
					<div class = "manage_results"> 
						<p style = "margin-top: 0px;">
						<input type = "button" id = "add_subject_button" value = "New" class = "button">
						<input type = "button" id = "deactivate_user_button" class = "button" name = "deactivate_user_button" value = "Deactivate" >
						<input type = "button" id = "activate_user_button" class = "button" name = "activate_user_button" value = "Activate" >
						
						<span class = "current_page" id = "user_current_page">
						(Page <?php echo $page ?> of <?php echo $total_page; ?>)</span>
						
						</p>
						<table style = "width: 100%;" cellpadding = 3 cellspacing = 0 id = "subject_tbl" >
							<thead>
							<tr class = "table_header">
								<td width = "2%"><input id="section_checkall" type = 'checkbox'></td>
								<td >Subject Code</td>
								<td >Description</td>
								<td >Date Created</td>
								<td >Date Modified</td>
								<td >Status</td>
								<td >&nbsp;</td>
							</tr>
							</thead>
							<tbody>
							<?php if($no_data <> 1): ?>
							<?php foreach($subject_list as $key => $row){?>
								<tr>
									<td ><input id="checkedUsers" type = 'checkbox' value = "<?php echo $row['id'];?>" /></td>
									<td><a href = "#" class = "subject_view" data-value="<?php echo $row['id'];?>"><?php echo $row['subject_code'];?></a></td>
									<td><?php echo $row['description'];?></td>
									<td><?php echo $row['date_created'];?></td>
									<td><?php echo $row['date_modified'];?></td>
									<td><?php if ($row['status'] == 1){ echo 'Active';} else{ echo 'Inactive';}
									?></td>
									<td><a href = "#" class="subject_edit" id = "" data-value="<?php echo $row['id']?>">Edit</a></td>
								</tr>
							<?php } else:?>
								<tr>
									<td colspan = 7 style = "text-align: center; padding 3px;"> There are no data to display.</td>
								</tr>
							<?php endif;?>
							</tbody>
						</table>

						<div style = "margin-top: 5px;">
							<input type = 'hidden' value = '<?php echo $page; ?>' id = 'page_num'/>
							<input type = "hidden" id = "enable_next" value = "<?php echo $enable_next;?>" />
							<input type = "hidden" id = "enable_prev" value = "0" />
							<div class = "pagination_button" id = "div_subject_last" >>></div>
							<div class = "pagination_button" id = "div_subject_next">></div>
							<div class = "pagination_button" id = "div_subject_prev"><</div>
							<div class = "pagination_button" id = "div_subject_first"><<</div>
							<div class = "clear_b"></div>
						</div>
						
					</div>
						
				</div>
				<div class = "clear_b"></div>
			</div>
			<div class = "clear_b"></div>
		</div>
	</div>
</div>

<?php $this->load->view('footer'); ?>

</body>
</html>