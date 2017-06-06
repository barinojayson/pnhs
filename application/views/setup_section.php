<!DOCTYPE html>
<html>

<?php $this->load->view('header'); ?>

<body>
<script type = "text/javascript" src="<?php echo base_url();?>assets/js/section.js"></script>

<?php $this->load->view('edit_section'); ?>
<?php //$this->load->view('view_announcement'); ?>
<div class = "header">header image here</div>
<div class = "container">
	
	<div class = "outer_content">
		<div class = "inner_content">
			
			<?php $this->load->view('menu'); ?>
			
			<div class = "main_content border_thm">
				<div class = "inner_content">
					<div class = "text_title1" style = "margin: 10px;" >Manage Section
					<div class = "page_message" id = "page_message"></div>
					</div>
					<div class = "search_box">
						<table style = "width: 100%; ">
							<tr>
								<td style = "width: 25%">Section</td>
								<td><input type = 'text' maxlength= "50" id = 'section' class = "textinput" /></td>
							</tr>
							<tr>
								<td style = "width: 25%">Year</td>
								<td>
									<select style="width: 120px;" id = "add_section_yearlevel">
										<option value = -1> -- </option>
										<?php foreach($year_level as $row => $item){?>
											<option value = "<?php echo $item['id'];?>"><?php echo $item['description'];?></option>
										<?php }?>
									</select>
								</td>
							</tr>
							<tr>
								<td style = "width: 25%">Max No. of Students</td>
								<td><input type = 'text' maxlength= "2" id = 'section_max_student' class = "textinput" style = "width: 116px" /></td>
							</tr>
							<tr>
								<td>Waive</td>
								<td><input type = 'checkbox' id = "waive_flag"></td>
							</tr>
							<tr>
								<td></td>
								<td style = "text-align: right;">
								<input type = "button" class = "button" id = "section_clear" value = "Clear" >
								<input type = "button" class = "button" id = "add_section_button" value = "Add" >
								<input type = "button" class = "button" id = "search_section_button" value = "Search" >
								
								<input type = "hidden" id = "search_flag_section" value = 0 />
								<input type = "hidden" id = "search_section_name" value = "" />
								<input type = "hidden" id = "search_year_level" value = "" />
								<input type = "hidden" id = "search_max_student" value = "" />
								<input type = "hidden" id = "search_waive_flag" value = "" />
								
								</td>
							</tr>
						</table>
					</div>
						
					<div class = "manage_results">
						<p style = "margin-top: 0px;">
						<input type = "button" id = "deleteSection" class = "button" name = "deleteSection" value = "Delete" >
						
						<span class = "current_page" id = "user_current_page">
						(Page <?php echo $page ?> of <?php echo $total_page; ?>)</span>
						
						</p>
						<table style = "width: 100%;" cellpadding = 3 cellspacing = 0 id = "section_tbl" >
							<thead>
							<tr class = "table_header">
								<td width = "2%"><input id="section_checkall" type = 'checkbox'></td>
								<td width = "27%">Section</td>
								<td width = "20%">Year</td>
								<td width = "22%">Max No. of Students</td>
								<td width = "17%">Waive</td>
								<td width = "7%">&nbsp;</td>
							</tr>
							</thead>
							<tbody>
							<?php foreach($section_list as $key => $row){?>
								<tr>
									<td ><input id="checkSection" type = 'checkbox' class = "checkSection" value = "<?php echo $row['id'];?>" /></td>
									<td><a href = "#" class = "" data-value=""><?php echo $row['section_name']; ?></a></td>
									<td><?php echo $row['year_level']; ?></td>
									<td><?php echo $row['max_student']; ?></td>
									<td>
										<?php if($row['waive_flag'] == 1){ echo "Yes"; } else {echo "No";}  ?>
									</td>
									<td><a href = "#" class="section_edit" id = "" data-value="<?php echo $row['id']?>">Edit</a></td>
								</tr>
							<?php } ?>
							<?php if($no_data == 1): ?>
								<tr>
									<td colspan = 7 style = "text-align: center; padding 3px;"> There are no data to display.</td>
								</tr>
							<?php endif; ?>
							</tbody>
						</table>

						<div style = "margin-top: 5px;">
							<input type = 'hidden' value = '<?php echo $page; ?>' id = 'page_num'/>
							<input type = "hidden" id = "enable_next" value = "<?php echo $enable_next;?>" />
							<input type = "hidden" id = "enable_prev" value = "0" />
							<div class = "pagination_button" id = "div_section_last" >>></div>
							<div class = "pagination_button" id = "div_section_next">></div>
							<div class = "pagination_button" id = "div_section_prev"><</div>
							<div class = "pagination_button" id = "div_section_first"><<</div>
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