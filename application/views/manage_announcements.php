<!DOCTYPE html>
<html>

<?php $this->load->view('header'); ?>

<body>
<?php $this->load->view('add_announcement'); ?>
<?php $this->load->view('view_announcement'); ?>
<div class = "header">header image here</div>
<div class = "container">
	
	<div class = "outer_content">
		<div class = "inner_content">
			
			<?php $this->load->view('menu'); ?>
			
			<div class = "main_content border_thm">
				<div class = "inner_content">
					<div class = "text_title1" style = "margin: 10px;" >Manage Announcements
					<div class = "page_message" id = "page_message"></div>
					</div>
					<div class = "search_box">
						<table style = "width: 100%; ">
							<tr>
								<td style = "width: 25%">Search</td>
								<td><input type = 'text' id = 'search_announcement_text' name = 'search_announcement_text' class = "textinput" /></td>
							</tr>
							<tr>
								<td>Type</td>
								<td>
									<select id = "search_announcement_type">
										<option value = "0">All</option>
										<option value = "1">Teachers</option>
										<option value = "2">Students</option>
									</select>
								</td>
							</tr>
							<tr>
								<td></td>
								<td style = "text-align: right;">
								<input type = "hidden" id = "search_flag_announcement" value = 0 />
								<input type = "hidden" id = "search_text_hidden" value = "" />
								<input type = "hidden" id = "search_type_hidden" value = 0 />
								<input type = "button" class = "button" name = "clear" value = "Clear" id = "clear_search_announcement">
								<input type = "button" class = "button" name = "search" value = "Search" id = "search_announcement_searchbt" >
								</td>
							</tr>
						</table>
					</div>
					
					<div class = "manage_results">
						<p style = "margin-top: 0px;">
						<input type = "button" id = "showPopup" value = "New" class = "button">
						<input type = "button" id = "deleteAnnouncement" class = "button" name = "deleteAnnouncement" value = "Delete" >
						<span class = "current_page" id = "announcement_current_page">
						(Page <?php echo $page ?> of <?php echo $total_page; ?>)</span>
						</p>
						<table style = "width: 100%;" cellpadding = 3 cellspacing = 0 id = "announcement_tbl" >
							<thead>
							<tr class = "table_header">
								<td width = "2%"><input id="ann_checkall" type = 'checkbox'></td>
								<td width = "35%">Announcement Title</td>
								<td width = "17%">Date Created</td>
								<td width = "17%">Date Published</td>
								<td width = "17%">Created By</td>
								<td width = "7%">&nbsp;</td>
							</tr>
							</thead>
							<tbody>
							
							<?php if($no_data <> 1): ?>
							
							<?php foreach($announcement_list as $key => $row){?>
								<tr>
									<td ><input id="checkedAnnouncement" type = 'checkbox' value = "<?php echo $row['id'];?>" /></td>
									<td><a href = "#" class = "announcement_view" data-value="<?php echo $row['id']; ?>"> <?php echo $row['title'];?> </a></td>
									<td><?php echo $row['date_created'];?></td>
									<td><?php echo $row['date_published'];?></td>
									<td><?php echo $row['created_by'];?></td>
									<td><a href = "#" class="announcement_edit" id = "" data-value="<?php echo $row['id'];?>">Edit</a></td>
								</tr>
							<?php } else: ?>
							
							<tr>
									<td colspan = 6 style = "text-align: center; padding 3px;"> There are no data to display.</td>
								</tr>
							<?php endif;?>
							
							</tbody>
						</table>
						<div style = "margin-top: 5px;">
							<input type = "hidden" id = "page_num" value = "<?php echo $page; ?>" />
							<input type = "hidden" id = "enable_next" value = "<?php echo $enable_next;?>" />
							<input type = "hidden" id = "enable_prev" value = "0" />
							<div class = "pagination_button" id = "div_last" >>></div>
							<div class = "pagination_button" id = "div_next">></div>
							<div class = "pagination_button" id = "div_prev"><</div>
							<div class = "pagination_button" id = "div_first"><<</div>
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