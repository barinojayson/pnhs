<!DOCTYPE html>
<html>

<?php $this->load->view('header'); ?>

<body>
<script type = "text/javascript" src="<?php echo base_url();?>assets/js/year.js"></script>


<?php //$this->load->view('add_announcement'); ?>
<?php $this->load->view('view_year_level'); ?>
<div class = "header">header image here</div>
<div class = "container">
	
	<div class = "outer_content">
		<div class = "inner_content">
			
			<?php $this->load->view('menu'); ?>
			
			<div class = "main_content border_thm">
				<div class = "inner_content">
					<div class = "text_title1" style = "margin: 10px;" >Year Level Management
					<div class = "page_message" id = "page_message"></div>
					</div>
					<div class = "search_box">
						<table style = "width: 100%; ">
							<tr>
								<td style = "width: 25%">Year Level</td>
								<td><input type = 'number' id = 'year' class = "textinput" /></td>
							</tr>
							<tr>
								<td style = "width: 25%">Description</td>
								<td><input type = 'text' id = 'year_description' class = "textinput" /></td>
							</tr>
							<tr>
								<td></td>
								<td style = "text-align: right;">
								<input type = "button" class = "button" id = "clear_year" value = "Clear" >
								<input type = "button" class = "button" id = "add_year" value = "Add" >
								<input type = "button" class = "button" id = "search_year" value = "Search" >
								
								<input type = "hidden" id = "search_flag_yl" value = 0 />
								<input type = "hidden" id = "search_yl_hidden" value = "" />
								<input type = "hidden" id = "search_yl_descr_hidden" value = "" />
								
								</td>
							</tr>
						</table>
					</div>
					
					<div class = "manage_results">
						<p style = "margin-top: 0px;">
						<input type = "button" id = "deleteYl" class = "button" name = "deleteYl" value = "Delete" >
						
						<span class = "current_page" id = "user_current_page">
						(Page <?php echo $page ?> of <?php echo $total_page; ?>)</span>
						
						</p>
						<table style = "width: 100%;" cellpadding = 3 cellspacing = 0 id = "yl_tbl" >
							<thead>
							<tr class = "table_header">
								<td width = "2%"><input id="yl_checkall" type = 'checkbox'></td>
								<td width = "20%">Year Level</td>
								<td width = "52%">Description</td>
								<td width = "19%">Date Created</td>
								<td width = "7%">&nbsp;</td>
							</tr>
							</thead>
							<tbody>
							<?php if($no_data <> 1): ?>
							<?php foreach($year_list as $key => $row){?>
								<tr>
									<td ><input class="checkYl" type = 'checkbox' value = "<?php echo $row['id'];?>" /></td>
									<td><?php echo  $row['grade_level']; ?></td>
									<td><a href = "#" class = "year_level_view" data-value="<?php echo  $row['id']; ?>"> <?php echo  $row['description']; ?> </a></td>
									<td><?php echo $row['date_created']; ?></td>
									<td><a href = "#" class="" id = "" data-value="">Edit</a></td>
								</tr>
							<?php }else: ?>
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
						
							<div class = "pagination_button" id = "div_yl_last" >>></div>
							<div class = "pagination_button" id = "div_yl_next">></div>
							<div class = "pagination_button" id = "div_yl_prev"><</div>
							<div class = "pagination_button" id = "div_yl_first"><<</div>
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