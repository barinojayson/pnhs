<div class="popup_container" id = "add_section_popup" style = "display:block">
	<div class="popup_box">
		<div class = "text_title1" style = "margin: 10px;" >New Announcement</div>
		<div class = "search_box_popup">
		<form id="frm_announcement" action = "/" method = "POST">
			<table style = "width: 100%; ">
				<tr>
					<td style = "width: 25%">Title</td>
					<td><input type = 'text' name = 'title'  maxlength= "150" id = 'title'  class = "textinput" /></td>
				</tr>
				<tr>
					<td>Type</td>
					<td>
						<select name ="type" id ="type">
							<option value = "0">All</option>
							<option value = "1">Teachers</option>
							<option value = "2">Students</option> 
						</select>
					</td>
				</tr>
				<tr>
					<td>Publish On</td>
					<td>
						<input type = "text" id = "datepicker" name = "datepicker" >
					</td>
				</tr>
				<tr>
					<td colspan = 2>Announcement</td>
				</tr>
				<tr>
					<td colspan = 2>
						<textarea name = "content" id = "content" style = "width: 100%; min-height: 500px;" class = "tinyTextArea"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan = 2>
						<input type = "submit" class = "button save_announcement" name = "save" value = "Save" >
						<input id = "hidePopup"type = "button" class = "button" name = "discard" value = "Discard" >
					</td>
				</tr>
			</table>
			<input type = "hidden" id = "edit_flag" value = "" />
		</form>
		</div>
	</div>
</div>