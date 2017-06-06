<!DOCTYPE html>
<html>

<?php $this->load->view('header'); ?>

<body>
<div class = "header">header image here</div>
<div class = "container">
	
	<div class = "outer_content">
		<div class = "inner_content">
			
			<?php $this->load->view('menu'); ?>
			
			<div class = "main_content border_thm">
				<div class = "inner_content">
					<div class = "content_announcement">
						<div class = "left_content">
							<div class = "text_title1">Announcements</div>
							<div class = "text_title2">Buwan ng Wika</div>
							<div class = "announcement_text">
							<p>
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id. xercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunti in culpa qui officia deserunt mollit.
							</p>
							<p>
							 Cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id. xercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
							</p>
							<br/><br/>
							Action Required:
							<ol>
								<li>Lorem ipsum dolor si</li>
								<li>Excepteur sint occaecat</li>
							</ol>
							
							</div>
						</div>
						<div style = "padding: 0px 10px;">
							<div class = "pagination_button" style = "padding: 0px 8px;">Next</div>
							<div class = "pagination_button" style = "float: left; padding: 0px 8px;">Previous</div>
						</div>
					</div>
					
					<div class = "content_navigator">
						<div class = "left_content" style  = "padding-left: 0px;">
						<form >
						<table cellpadding = 0 cellspacing = 0>
							<tr>
								<td><input class = "input_normal" type = "text" style = "width: 164px" value = "Type to search..."></input></td>
								<td>&nbsp;&nbsp;<input type = "submit" value = "Search" class = "button"></td>
							</tr>
						</table>
						</form>
						</div>
						
						<div class = "left_content" style = "border: 1px solid #33CCFF; padding-bottom: 0px; padding-right: 0px;">
							<div class = "text_title2">Teachers</div>
							<ul class = "announcement_list">
								<li><a href = "#">Announcement 1</a></li>
								<li><a href = "#">Announcement Two</a></li>
								<li><a href = "#">Third Announcement</a></li>
							</ul>
							<div>
								<div class = "pagination_button">>></div>
								<div class = "pagination_button">></div>
								<div class = "pagination_button"><</div>
								<div class = "pagination_button"><<</div>
								<div class = "clear_b"></div>
							</div>
						</div>
						
						<div class = "left_content" style = "border: 1px solid #33CCFF; padding-bottom: 0px; padding-right: 0px; margin-top: 10px;">
							<div class = "text_title2">Students</div>
							<ul class = "announcement_list">
								<li><a href = "#">Announcement 1</a></li>
								<li><a href = "#">Announcement Two</a></li>
								<li><a href = "#">Third Announcement</a></li>
							</ul>
							<div>
								<div class = "pagination_button">>></div>
								<div class = "pagination_button">></div>
								<div class = "pagination_button"><</div>
								<div class = "pagination_button"><<</div>
								<div class = "clear_b"></div>
							</div>
						</div>
						
					</div>
					
					<div class = "clear_b"></div>
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