<div class="popup_container" id = "edit_section_popup" >
	<div class="popup_box" style = "width: 700px; left: 330px; top: 50px; height: 500px;">
		
		<div class = "search_box_popup" style = "margin-top: 0px; padding-top:0px;">

			<div class = "border_round">
				<div class = "text_title2" style = "margin: 0px 0px 10px 0px;" id = "view_announcement_title" >Edit Section</div>
			
				<table width="100%" cellspacing = "0">
					<tr>
						<td width="30%">Section</td>
						<td width="70%"><input type = 'text' maxlength= "50" id = 'edit_section_name' class = "textinput" style = "width: 400px;" /></td>
					</tr>
					<tr>
						<td>Year</td>
						<td id = "yl_dropdown">
							<select class = "textinput" id = 'edit_section_name' style = "width: 403px;" >
								<option ></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Max Students</td>
						<td><input type = 'text' maxlength= "50" id = 'edit_max_student' class = "textinput" style = "width: 400px;" /></td>
					</tr>
					<tr>
						<td>Waive</td>
						<td><input type = 'checkbox' id = "edit_waive_flag"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type = "submit" class = "button save_announcement" name = "save" value = "Save" id = "save_section_button"></td>
					</tr>
				</table>
			</div>
			<br/>
			
			<div class = "border_round">
				<div class = "text_title2" style = "margin: 0px 0px 10px 0px;"  >Manage Section Subjects</div>
				<table width="100%" cellspacing = "0" id = "add_subject">
					<tr>
						<td width="30%">Subject</td>
						<td width="70%" id = "add_section_subject"><select style = "width:100%;"><option >-test-</option></select></td>
					</tr>
					<tr>
						<td>Teacher</td>
						<td id = "add_subject_teacher"><select style = "width:100%;"><option >-test-</option></select></td>
					</tr>

					<tr>
						<td>&nbsp;</td>
						<td><input type = "submit" class = "button save_announcement" name = "add_subject" value = "Add Subject" id = "add_subject_btn"></td>
					</tr>
					
				</table>

				<br/>

				<table width="100%" cellspacing = "0" id = "form_sec_subjects" class = "tborder" >
					<thead>
						<tr class = "table_header">
							<td width="45%">Subject</td>
							<td width="45%">Teacher</td>
							<td width="5%"></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</tbody>
				</table>
				<br/>
			</div>
			<br/>
			<!--<input type = "hidden" id = "view_subject_id" />-->
			<input type = "hidden" id = "edit_flag" />
			<input id = "discard_subject_button" type = "button" class = "button" name = "Close" value = "Close" >
			</div>
	</div>
</div>