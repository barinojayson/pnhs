<!DOCTYPE html>
<html>

<?php $this->load->view('header'); ?>
<script>
	tinymce.init({
	selector: '.tinyTextArea',
	toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
	menubar: false,
	height: "320"
	});	
	
	$(function() {
		$( ".datepicker" ).datepicker();
	});
	
	
	function generate_year_end(year_start){
		var year_option = document.getEl
	}
</script>
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
					<div class = "text_title1" style = "margin: 10px;" >Manage Enrollment
					<div class = "page_message" id = "page_message"></div>
					</div>
					<div class = "search_box" style="margin-left:10px;border:1px solid #999999;float:left;width:500px;">
						<table style = "width: 100%; ">
							<tr>
								<td style = "width: 25%">School Year</td>
								<td>
									<select id="year_start">
									<?php
										$year_start = date('Y');
										for($i=0;$i<10;$year_start++,$i++){
											echo "<option>$year_start</option>";
										}
									?>
									</select>
									~
									<select id="year_end">
									<?php
										$year_end = $year_start + 1;
										for($i=0;$i<10;$year_end++,$i++){
											echo "<option>$year_end</option>";
										}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td style = "width: 25%">Begin Date</td>
								<td><input type = "text" class = "datepicker" name = "datepicker" ></td>
							</tr>
							<tr>
								<td style = "width: 25%">End Date</td>
								<td><input type = "text" class = "datepicker" name = "datepicker" ></td>
							</tr>
							<tr>
								<td></td>
								<td style = "text-align: right;">
								<br />
								<input type = "button" class = "button" id = "search_subject_clearbt" value = "Clear" >
								<input type = "button" class = "button" name = "section_add" value = "Search" id = "search_subject_searchbt" >
								<br /><br />
								<input type = "hidden" id = "search_flag_subject" value = 0 />

								<input type = "hidden" id = "search_subject_code_hidden" value = "" />
								<input type = "hidden" id = "search_description_hidden" value = "" />
								
								</td>
							</tr>
						</table>
					</div>
					<div class = "search_box" style="margin-left:10px;border:1px solid #999999;float:left;width:150px;">
						<table style = "width: 100%; ">
							<tr>
								<td style = "width: 10%"><input type="checkbox"></td>
								<td>Auto Enroll</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td style = "width: 10%"><input type="radio"></td>
								<td>Average Score</td>
							</tr>
							<tr>
								<td style = "width: 10%"><input type="radio"></td>
								<td>Divide Students</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</div>
					<div class="clear_b">&nbsp;</div>
					
					<div class = "manage_results"> 
						<p style = "margin-top: 0px;">
						<input type = "button" id = "add_enrollment_button" value = "Open School Year" class = "button">
						<!-- <input type = "button" id = "deactivate_user_button" class = "button" name = "deactivate_user_button" value = "Deactivate" >
						<input type = "button" id = "activate_user_button" class = "button" name = "activate_user_button" value = "Activate" >
						-->
						<span class = "current_page" id = "user_current_page">
						(Page <?php //echo $page ?> of <?php //echo $total_page; ?>)</span>
						
						</p>
						<table style = "width: 100%;" cellpadding = 3 cellspacing = 0 id = "subject_tbl" >
							<thead>
							<tr class = "table_header">
								<td width = "2%"><input id="section_checkall" type = 'checkbox'></td>
								<td >School Year</td>
								<td >Start Date</td>
								<td >Close Date</td>
								<td >Created By</td>
								<td >Status</td>
								<td >&nbsp;</td>
							</tr>
							</thead>
							<tbody>
							
							</tbody>
						</table>

						<div style = "margin-top: 5px;">
							<input type = 'hidden' value = '<?php //echo $page; ?>' id = 'page_num'/>
							<input type = "hidden" id = "enable_next" value = "<?php //echo $enable_next;?>" />
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