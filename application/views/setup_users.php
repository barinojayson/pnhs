<!DOCTYPE html>
<html>

<?php $this->load->view('header'); ?>

<body>
<script type = "text/javascript" src="<?php echo base_url();?>assets/js/user.js"></script>

<?php $this->load->view('add_user'); ?>
<?php $this->load->view('view_user'); ?>
<div class = "header">header image here</div>
<div class = "container">
	
	<div class = "outer_content">
		<div class = "inner_content">
			
			<?php $this->load->view('menu'); ?>
			
			<div class = "main_content border_thm">
				<div class = "inner_content">
					<div class = "text_title1" style = "margin: 10px;" >Manage Users
					<div class = "page_message" id = "page_message"></div>
					</div>
					<div class = "search_box">
						<table style = "width: 100%; ">
							<tr>
								<td style = "width: 25%">Username</td>
								<td><input type = 'text' maxlength= "50" id = 'username_user' class = "textinput" /></td>
							</tr>
							<tr>
								<td style = "width: 25%">First Name</td>
								<td><input type = 'text' maxlength= "50" id = 'firstname_user' class = "textinput" /></td>
							</tr>
							<tr>
								<td style = "width: 25%">Last Name</td>
								<td><input type = 'text' maxlength= "50" id = 'lastname_user' class = "textinput"  /></td>
							</tr>
							<tr>
								<td></td>
								<td style = "text-align: right;">
								<input type = "button" class = "button" id = "search_user_clearbt" value = "Clear" >
								<input type = "button" class = "button" name = "section_add" value = "Search" id = "search_user_searchbt" >
								
								<input type = "hidden" id = "search_flag_user" value = 0 />
								<input type = "hidden" id = "search_username" value = "" />
								<input type = "hidden" id = "search_fname" value = "" />
								<input type = "hidden" id = "search_lname" value = "" />
								
								</td>
							</tr>
						</table>
					</div>
					
					<div class = "manage_results">
						<p style = "margin-top: 0px;">
						<input type = "button" id = "add_user_button" value = "New" class = "button">
						<input type = "button" id = "deactivate_user_button" class = "button" name = "deactivate_user_button" value = "Deactivate" >
						<input type = "button" id = "activate_user_button" class = "button" name = "activate_user_button" value = "Activate" >
						
						<span class = "current_page" id = "user_current_page">
						(Page <?php echo $page ?> of <?php echo $total_page; ?>)</span>
						
						</p>
						<table style = "width: 100%;" cellpadding = 3 cellspacing = 0 id = "user_tbl" >
							<thead>
							<tr class = "table_header">
								<td width = "2%"><input id="section_checkall" type = 'checkbox'></td>
								<td >Username</td>
								<td >First Name</td>
								<td >Last Name</td>
								<td >School Position</td>
								<td >Status</td>
								<td >&nbsp;</td>
							</tr>
							</thead>
							<tbody>
							<?php foreach($user_list as $key => $row){?>
								<tr>
									<td ><input id="checkedUsers" type = 'checkbox' value = "<?php echo $row['user_id'];?>" /></td>
									<td><a href = "#" class = "user_view" data-value="<?php echo $row['user_id'];?>"><?php echo $row['username']; ?></a></td>
									<td><?php echo $row['fname']; ?></td>
									<td><?php echo $row['lname']; ?></td>
									<td><?php echo $row['position']; ?></td>
									<td><?php if($row['status']==0){echo "Inactive";} else {echo "Active";}; ?></td>
									<td><a href = "#" class="user_edit" id = "" data-value="<?php echo $row['user_id'];?>">Edit</a></td>
								</tr>
							<?php }?>
							</tbody>
						</table>

						<div style = "margin-top: 5px;">
							<input type = 'hidden' value = '<?php echo $page; ?>' id = 'page_num'/>
							<input type = "hidden" id = "enable_next" value = "<?php echo $enable_next;?>" />
							<input type = "hidden" id = "enable_prev" value = "0" />
							<div class = "pagination_button" id = "div_user_last" >>></div>
							<div class = "pagination_button" id = "div_user_next">></div>
							<div class = "pagination_button" id = "div_user_prev"><</div>
							<div class = "pagination_button" id = "div_user_first"><<</div>
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