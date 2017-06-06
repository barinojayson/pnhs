<div class="popup_container" id = "add_subject_popup" >
	<div class="popup_box" style = "width: 500px; height: 200px; left: 500px; top: 200px; overflow : hidden;">
		<div class = "text_title1" style = "margin: 10px 10px 0px 10px;" >Add Subject</div>
		<div class = "search_box_popup">
		<form id="form_subject" action = "/" method = "POST">
			<table style = "width: 100%; ">
				<tr>
					<td colspan = 2 class = "text_title2">Subject Information</td>
				</tr>
				<tr>
					<td colspan = 2 style = "height: 5px;">&nbsp;</td>
				</tr>
				<tr>
					<td style = "width: 25%">Subject Code</td>
					<td><input type = 'text' name = 'subject_code' id = 'input_subject_subcode'  class = "normal_text_size" /></td>
				</tr>
				<tr>
					<td >Description</td>
					<td><input type = 'text' name = 'description' id = 'input_subject_description'  class = "normal_text_size" /></td>
				</tr>
				
				<tr>
					<td colspan = 2>&nbsp;</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >
						<input type = "button" class = "button" name = "save" value = "Save" id = "save_subject_button">
						<input id = "discard_subject_button"type = "button" class = "button" name = "discard" value = "Discard" >
					</td>
				</tr>
			</table>
			<input type = "hidden" id = "edit_flag" value = "" />
		</form>
		</div>
	</div>
</div>