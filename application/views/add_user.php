<script>
	$(function() {
		$( "#input_user_birthdate" ).datepicker();
	});
</script>

<div class="popup_container" id = "add_user_popup" >
	<div class="popup_box">
		<div class = "text_title1" style = "margin: 10px;" >Add User</div>
		<div class = "search_box_popup">
		<form id="form_user" action = "/" method = "POST">
			<table style = "width: 100%; ">
				<tr>
					<td colspan = 2 class = "text_title2">User Information</td>
				</tr>
				<tr>
					<td colspan = 2>&nbsp;</td>
				</tr>
				<tr>
					<td style = "width: 25%">Username</td>
					<td><input type = 'text' name = 'username' id = 'input_user_uname'  class = "normal_text_size" /></td>
				</tr>
				<tr class = "password_row">
					<td >Password</td>
					<td><input type = 'password' name = 'password' id = 'input_user_password'  class = "normal_text_size" /></td>
				</tr>
				<tr class = "password_row">
					<td >Confirm Password</td>
					<td><input type = 'password' name = 'password' id = 'confirm_user_password'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td >First Name</td>
					<td><input type = 'text' name = 'fname' id = 'input_user_fname'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td >Last Name</td>
					<td><input type = 'text' name = 'lname' id = 'input_user_lname'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td colspan = 2>&nbsp;</td>
				</tr>
				<tr>
					<td colspan = 2 class = "text_title2">User Details</td>
				</tr>
				<tr>
					<td colspan = 2>&nbsp;</td>
				</tr>
				<tr>
					<td >Position</td>
					<td>
					<select name = "position" id = "input_user_position" class = "normal_text_size">
						<option value = -1>-Please Select-</option>
						<?php foreach($positions as $position): ?>
						<option value = <?php echo $position['type']; ?>><?php echo $position['description']; ?></option>
						<?php endforeach; ?>
					</select>
					</td>
				</tr>
				<tr>
					<td >User Access</td>
					<td>
					<select name = "user_access" id = "input_user_uaccess" class = "normal_text_size">
						<option value = -1>-Please Select-</option>
						<option value = 0>Super Admin</option>
						<option value = 1>Administrator</option>
						<option value = 2>Teacher</option>
						<option value = 3>Student</option>
					</select>
					</td>
				</tr>
				<tr>
					<td style = "width: 10%" >Birthdate</td>
					<td>
					<input type = "text" name = "birthdate" id = "input_user_birthdate"></input>
					</td>
				</tr>
				<tr>
					<td >Email Address</td>
					<td><input type = 'text' name = 'email_address' id = 'input_user_email'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td >Telephone Number</td>
					<td><input type = 'text' name = 'phone' id = 'input_user_telephone_no'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td >Cellphone Number</td>
					<td><input type = 'text' name = 'phone' id = 'input_user_cellphone_no'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td >Mother's Name</td>
					<td><input type = 'text' name = 'mother' id = 'input_user_mother'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td >Father's Name</td>
					<td><input type = 'text' name = 'father' id = 'input_user_father'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td colspan = 2>&nbsp;</td>
				</tr>
				<tr>
					<td colspan = 2 class = "text_title2">City Address</td>
				</tr>
				<tr>
					<td colspan = 2>&nbsp;</td>
				</tr>
				<tr>
					<td >Street Address</td>
					<td><input type = 'text' name = 'street_address' id = 'input_user_street_address'  class = "textinput" /></td>
				</tr>
				<tr>
					<td >City</td>
					<td><input type = 'text' name = 'city' id = 'input_user_city'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td >Province</td>
					<td><input type = 'text' name = 'province' id = 'input_user_province'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td >Zip Code</td>
					<td><input type = 'text' name = 'zip_code' id = 'input_user_zip_code'  class = "normal_text_size" /></td>
				</tr>
				
				<tr>
					<td colspan = 2>&nbsp;</td>
				</tr>
				<tr>
					<td colspan = 2 class = "text_title2">Provincial Address</td>
				</tr>
				<tr>
					<td colspan = 2>&nbsp;</td>
				</tr>
				<tr>
					<td >Street Address</td>
					<td><input type = 'text' name = 'provincial_street_address' id = 'input_user_street_address_pr'  class = "textinput" /></td>
				</tr>
				<tr>
					<td >City</td>
					<td><input type = 'text' name = 'provincial_city' id = 'input_user_provincial_city'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td >Province</td>
					<td><input type = 'text' name = 'provincial_province' id = 'input_user_provincial_province'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td >Zip Code</td>
					<td><input type = 'text' name = 'provincial_zip_code' id = 'input_user_provincial_zip_code'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td colspan = 2>&nbsp;</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >
						<input type = "button" class = "button" name = "save" value = "Save" id = "save_user_button">
						<input id = "discard_user_button"type = "button" class = "button" name = "discard" value = "Discard" >
					</td>
				</tr>
			</table>
			<input type = "hidden" id = "edit_flag" value = "" />
		</form>
		</div>
	</div>
</div>