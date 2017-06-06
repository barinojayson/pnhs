<div class="popup_container" id = "view_popup">
	<div class="popup_box" style = "width: 830px;">
		<div class = "text_title1" style = "margin: 10px;" id = "view_announcement_title" >View User Details</div>
		<div class = "search_box_popup">
			
			
			<table style = "width: 800px;" class = "table_view">
				<tr>
					<td colspan = 4 class = "text_title2">User Information</td>
				</tr>
				
				<tbody>
					<tr >
						<td style = "width: 25%">Username</td>
						<td id = 'view_user_uname' class = "gray" ></td>
					</tr>
					<tr>
						<td >First Name</td>
						<td id = 'view_user_fname' class = "gray" colspan = 3 ></td>
					</tr>
					<tr>
						<td >Last Name</td>
						<td id = 'view_user_lname' class = "gray" colspan = 3  ></td>
					</tr>
				</tbody>
				
				<tr>
					<td colspan = 4>&nbsp;</td>
				</tr>
				<tr>
					<td colspan = 4 class = "text_title2">User Details</td>
				</tr>

				<tbody>
				
					<tr>
						<td style = "width: 25%" >Position</td>
						<td id = "view_user_position" style = "width: 25%" class = "gray" ></td>
						<td style = "width: 25%" >Telephone</td>
						<td id = "view_user_telephone_no" style = "width: 25%"class = "gray"></td>
					</tr>
					<tr>
						<td >User Access</td>
						<td id = "view_user_uaccess" class = "gray">
						</td>
						<td >Cellphone</td>
						<td id = "view_user_cellphone_no" class = "gray"></td>
					</tr>
					<tr>
						<td style = "width: 10%" >Birthdate</td>
						<td id = "view_user_birthdate" class = "gray"></td>
						<td >Mother's Name</td>
						<td id = 'view_user_mother' class = "gray"></td>
					</tr>
					<tr>
						<td >Email Address</td>
						<td id = 'view_user_email' class = "gray"></td>
						<td >Father's Name</td>
						<td id = 'view_user_father' class = "gray"></td>
					</tr>
				
				</tbody>
					
					<tr>
						<td colspan = 4>&nbsp;</td>
					</tr>
					<tr>
						<td colspan = 4 class = "text_title2">City Address</td>
					</tr>

					<tbody>
					<tr>
						<td >Street Address</td>
						<td id = 'view_user_street_address' class = "gray"></td>
					</tr>
					<tr>
						<td >City</td>
						<td id = 'view_user_city' class = "gray" colspan = 3></td>
					</tr>
					<tr>
						<td >Province</td>
						<td id = 'view_user_province' class = "gray" colspan = 3></td>
					</tr>
					<tr>
						<td >Zip Code</td>
						<td id = 'view_user_zip_code' class = "gray" colspan = 3></td>
					</tr>
				</tbody>
				
				<tr>
					<td colspan = 4>&nbsp;</td>
				</tr>
				<tr>
					<td colspan = 4 class = "text_title2">Provincial Address</td>
				</tr>

				<tbody>
					<tr>
						<td >Street Address</td>
						<td id = 'view_user_street_address_pr' class = "gray" colspan = 3></td>
					</tr>
					<tr>
						<td >City</td>
						<td id = 'view_user_provincial_city' class = "gray" colspan = 3></td>
					</tr>
					<tr>
						<td >Province</td>
						<td id = 'view_user_provincial_province' class = "gray" colspan = 3></td>
					</tr>
					<tr>
						<td >Zip Code</td>
						<td id = 'view_user_provincial_zip_code' class = "gray" colspan = 3></td>
					</tr>
					<tr>
						<td colspan = 4>&nbsp;</td>
					</tr>
				</tbody>
			</table>
			
			<input type = "hidden" id = "view_user_id" />
			<input type = "button" id = "view_user_edit" class = "button" name = "edit" value = "Edit">
			<input type = "button" id = "view_user_deactivate" class = "button" name = "deactivate" value = "Deactivate">
			<input type = "button" id = "view_user_activate" class = "button" name = "activate" value = "Activate">
			<input id = "hideViewPopup"type = "button" class = "button" name = "close" value = "Close" >
		</div>
		<div class = "footnote">
		<?php /*
			 <table style = "width: 100%">
				<tr>
					<td id = "view_announcement_created_by">Created By: Jayson Barino</td>
					<td id = "view_announcement_date_created">Created On: 01/23/2016</td>
					<td id = "view_announcement_modified_by">Modified By: Jayson Barino</td>
					<td id = "view_announcement_date_modified">Modified On: 01/24/2016</td>
					<td id = "view_announcement_date_published">Published On: 01/24/2016</td>
				</tr>
			</table> */?>
		</div>
	</div>
</div>