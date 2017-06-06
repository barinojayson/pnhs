<!DOCTYPE html>
<html>

<?php $this->load->view('header');?>

<body>
	<div class = "header">header image here</div>
<div class = "container">

	<div class = "outer_content">
		<div class = "inner_content">
			<div class = "outer_login_announcement ">
				<div class = "login_announcement border_thm">
					<div class = "left_content">
						<div class = "text_title1 float">Announcements</div>
						<a href = "#" class = "right_button">View All</a>
						<div class = "clear_b"></div>
						<div class = "announcement_item">
							<div class = "text_title2"><a href = "#" > Buwan ng Wika </a> </div>
							<div class = "text">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id ... <a href = "#"> Read more </a>
							</div>
						</div>
						<div class = "h_line"></div>
						<div class = "announcement_item">
							<div class = "text_title2"><a href = "#" > PNHS - SSS Launched </a> </div>
							<div class = "text">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in ... <a href = "#"> Read more </a>
							</div>
						</div>
						<div class = "h_line"></div>
						<div class = "announcement_item">
							<div class = "text_title2"><a href = "#" > PNHS - SSS Launched </a> </div>
							<div class = "text">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in ... <a href = "#"> Read more </a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class = "login_box border_thm">
				<div class = "left_content">
					<div class = "text_title1">User Login </div>
					<div class = "center_content">
						<form method = "POST" action = "<?php echo base_url();?>index.php/Login">
						<table>
							<?php 
							if(isset($error)): ?>
							<tr >
								<td colspan="3"><?php echo $error; ?></td>
							</tr>
							<?php endif;?>
							<tr>
								<td>User ID: </td> <td>&nbsp;</td><td><input type = "text" class = "input_normal" name = "username"> </input></td>
							</tr>
							<tr>
								<td>Password: </td> <td>&nbsp;</td><td><input type = "password" class = "input_normal" name = "password"> </input></td>
							</tr>
							<tr>
								<td>&nbsp; </td> <td>&nbsp;</td><td><div style = "text-align: right; "><input type = "submit" class = "button" name = "Login" value = "Login" ></input></div></td>
							</tr>
						</table>
						</form>
					</div>
				</div>
			</div>
			<div class = "clear_b"></div>
		</div>
	</div>
</div>

<?php $this->load->view('footer');?>

</body>
</html>