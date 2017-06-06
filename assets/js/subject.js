function repopulateSubjects(json_data, message){
			//display success message
			if(message != ""){
				$("#page_message").text(message);
				displayMsg();
			}
			
			//blank out the check box headers
			$("#section_checkall").prop('checked', '');
			
			//reload table contents limit 10
			$("#subject_tbl > tbody").empty();
			var trHTML = '';
			$.each(json_data, function (i, item) {
				if(i == 0){// alert("prev : " + item.prev + "next : " + item.next);
					$("#page_num").val(item.page_num);
					$("#user_current_page").text("(Page " + item.page_num + " of " + item.total_page + ")");
					if(item.next == 0){ // no more next page
						$("#enable_next").val(0);
					}
					else{
						$("#enable_next").val(1);
					}
					if(item.prev == 0){ // page is first page
						$("#enable_prev").val(0);
					}
					else{
						$("#enable_prev").val(1);
					}
				}
				if(i > 0){
					var status = 'Active';
					if (item.status == 0){
						status = 'Inactive';
					}
					
			trHTML += "<tr><td ><input id='checkedUsers' type = 'checkbox' value = '"+item.id+"'</td> <td><a href = '#' class = 'subject_view' data-value='"+item.id+"'>"+item.subject_code+"</a></td><td>"+item.description+"</td><td>"+item.date_created+"</td><td>"+item.date_modified+"</td><td>"+status+"</td><td><a href = '#' class='subject_edit' id = '' data-value='"+item.id+"'>Edit</a></td></tr>";
				}
			});
			$('#subject_tbl').append(trHTML);
	   }
	   
function edit_subject(id)
{
	var subject_id = id;
	$("#edit_flag").val(subject_id);
	//alert(subject_id);
	jQuery.ajax({
		type: "POST",
		url: base_url + "index.php/setup_subject/get_subject_details",
		dataType: 'json',
		data: {subject_id: subject_id},
		success: function(res) {
			$("input#input_subject_subcode").val(res.subject_code);
			$("input#input_subject_description").val(res.description);
		},
		error: function(data, status, headers, config){
			alert(status);
		}
	});
	showPopup("#add_subject_popup");
}

	$(document).ready( function() {	
		
		//search functions
		
		$("#search_subject_searchbt").click( function() {
			var search_subject_code = $("#search_subject_code").val();
			var search_description = $("#search_description").val();
			var search_flag = 1;
			
			//set hidden fields
			$("#search_flag_user").val(1);
			$("#search_subject_code_hidden").val(search_subject_code);
			$("#search_description_hidden").val(search_description);
			
			// if (search_text == "" && search_type == 0){
				// $("#page_message").text("Please enter search text or select type other than 'All'.");
				// $("#page_message").css("background-color","rgba(255, 0, 0, 0.6)");
				// displayMsg();
				// return false;
			// }else{
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_subject/page",
				dataType: 'json',
				data: {page: 1, search_flag: search_flag, search_subject_code: search_subject_code, search_description : search_description},
				success: function(res) {
					repopulateSubjects(res,"");
				},
				error: function(data, status, headers, config){
					alert(headers);
				}
			});
			//}
		});
		
		$("#search_subject_clearbt").click( function() {

			$("#search_subject_code_hidden").val("");
			$("#search_description_hidden").val("");

			$("#search_subject_code").val("");
			$("#search_description").val("");
			
			$("#search_flag_user").val(0);
			$("#search_subject_code_hidden").val("");
			$("#search_description_hidden").val("");
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_subject/page",
				dataType: 'json',
				data: {page: 1},
				success: function(res) {
					repopulateSubjects(res,"");
				}
			});
			
		});
		
		// view > deactivate
		
		$("#view_subject_deactivate").click( function() {
			var id = $("#view_subject_id").val();
			var ok = confirm("Are you sure you want to deactivate this subject?");
			var page = parseInt($("#page_num").val());
			if(ok){
				jQuery.ajax({
					type: "POST",
					url: base_url + "index.php/setup_subject/deactivate",
					dataType: 'json',
					data: {id: id, page: page},
					success: function(res) {
						$("#page_message").css("background-color","rgba(0, 217, 54, 0.6)");
						repopulateSubjects(res,"Subject successfully deactivated.");
					}
				});
			}
			
			hidePopup("#view_popup");
		});
		
		// view > activate
		
		$("#view_subject_activate").click( function() {
			var id = $("#view_subject_id").val();
			var ok = confirm("Are you sure you want to activate this subject? ");
			var page = parseInt($("#page_num").val());
			if(ok){
				jQuery.ajax({
					type: "POST",
					url: base_url + "index.php/setup_subject/activate",
					dataType: 'json',
					data: {id: id, page: page},
					success: function(res) {
						$("#page_message").css("background-color","rgba(0, 217, 54, 0.6)");
						repopulateSubjects(res,"Subject successfully activated.");
					},
					error: function(data, status, headers, config){
					alert(status);
					}
				});
			}
			
			hidePopup("#view_popup");
		});
	
		// view > edit
		
		$("#view_subject_edit").click( function() {
			hidePopup("#view_popup");
			var id = $("#view_subject_id").val();
			edit_subject(id);
		});
	
		//view user
		
		$(document).on('click', ".subject_view", function() {
			showPopup("#view_popup");
			var subject_id = $(this).data("value");
			$("#edit_flag").val(subject_id);
			
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_subject/get_subject_details",
				dataType: 'json',
				data: {subject_id: subject_id},
				success: function(res) {
				
				var status_str = "Inactive";
				
				if (res.status == 1){
					status_str = "Active";
					$("#view_subject_activate").css("display","none");
					$("#view_subject_deactivate").css("display","inline");
				}else{
					$("#view_subject_activate").css("display","inline");
					$("#view_subject_deactivate").css("display","none");
				}
			
				//alert (res.username);
				$('#view_subject_code').text(res.subject_code);
				$("#view_subject_description").html(res.description);
				$("#view_subject_status").html(status_str);
				
			    $("#view_created_by").html("Created By: <br/>"+res.creator_name);
				$("#view_modified_by").html("Modified By: <br/>"+res.modifier_name);
				$("#view_date_created").html("Created On:<br/>"+res.date_created);
				$("#view_date_modified").html("Modified On: <br/>"+res.date_modified);
				$("#view_subject_id").val(res.id);
				
				},
				error: function(data, status, headers, config){
					alert(status);
				}
			});
		});

		//edit subject
		
		$(document).on('click', ".subject_edit", function() {
			var subject_id = $(this).data("value");
			//hide the password fields
			edit_subject(subject_id);
		});
		
		//end of edit subject
	
		$("#add_subject_button").click( function() {
			$("#edit_flag").val('');
			showPopup("#add_subject_popup");
		});
		
		$("#section_checkall").change(function () {
			$("input:checkbox").prop('checked', $(this).prop("checked"));
		});
		
		$("#discard_subject_button").click( function() {
			var ok = confirm("Are you sure you want to discard any changes?");
			if(ok){
				$("#form_subject").trigger('reset'); 
				hidePopup("#add_subject_popup");
			}
		});
		
		$("#save_subject_button").click( function() {
			var page = parseInt($("#page_num").val());
			var edit_flag = $("#edit_flag").val();
			
			var subject_code = $("#input_subject_subcode").val();
			var description = $("#input_subject_description").val();
			
			var validation_error = false;
			var error_msg = "";
			
			//validation:
			//to add validation
		
			if (subject_code == ""){
				validation_error = true;
				error_msg = "Subject Code is required.\n";
			}
			
			if (description == ""){
				validation_error = true;
				error_msg = error_msg + "Description is required.\n";
			}
			
			// var edit_flag = true;
			if(validation_error == false){
				jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_subject/save",
				dataType: 'json',
				data: {subject_code : subject_code, description : description, edit_flag: edit_flag, page: page},
				success: function(res) {
					hidePopup("#add_subject_popup");
					//clear fields
					$("#form_subject").trigger('reset'); 
					repopulateSubjects(res,"Subject has been saved successfully.");
					//$("#user_tbl > tbody").empty();
				},
				error: function(data, status, headers, config){
					alert(status);
				}
				});
			}else{
				alert(error_msg);
			}
			
		});
		
	
	//pagination here
		
		$("#div_subject_next").click( function() {
			
			var page = parseInt($("#page_num").val()) + 1;
			var next = $("#enable_next").val();
			
			var search_flag = $("#search_flag_subject").val();
			var search_subject_code = $("#search_subject_code").val();
			var search_description = $("#search_description").val();
			
			//alert(page); alert(next);
			if(next == 1){
				jQuery.ajax({
					type: "POST",
					url: base_url + "index.php/setup_subject/page",
					dataType: 'json',
					data: {page: page, search_flag: search_flag, search_subject_code: search_subject_code, search_description : search_description},
					success: function(res) {
						repopulateSubjects(res,"");
						//$("#page_num").val(page);
						//$("#enable_prev").val(1);
					}
				});
			}
		});
		
		
		$("#div_subject_prev").click( function() {
			var page = parseInt($("#page_num").val()) - 1;
			var prev = $("#enable_prev").val();
			
			var search_flag = $("#search_flag_subject").val();
			var search_subject_code = $("#search_subject_code").val();
			var search_description = $("#search_description").val();
			
			//alert(page); alert(prev);
			if(prev == 1){
				jQuery.ajax({
					type: "POST",
					url: base_url + "index.php/setup_subject/page",
					dataType: 'json',
					data: {page: page, search_flag: search_flag, search_subject_code: search_subject_code, search_description : search_description},
					success: function(res) {
						repopulateSubjects(res,"");
						//$("#page_num").val(page);
						//$("#enable_next").val(1);
					}
				});
			}
		});
		
		$("#div_subject_first").click( function() {
			var page = 1;
			
			var search_flag = $("#search_flag_subject").val();
			var search_subject_code = $("#search_subject_code").val();
			var search_description = $("#search_description").val();
			
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_subject/page",
				dataType: 'json',
				data: {page: page, search_flag: search_flag, search_subject_code: search_subject_code, search_description : search_description},
				success: function(res) {
					repopulateSubjects(res,"");
					//$("#page_num").val(page);
					//$("#enable_next").val(1);
				}
			});
		});
 
 		$("#div_subject_last").click( function() {
			
			var search_flag = $("#search_flag_subject").val();
			var search_subject_code = $("#search_subject_code").val();
			var search_description = $("#search_description").val();
			
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_subject/page",
				dataType: 'json',
				data: {page: 0, search_flag: search_flag, search_subject_code: search_subject_code, search_description : search_description},
				success: function(res) {
					repopulateSubjects(res,"");
				}
			});
		});
		
		//end pagination
		
		$("#activate_user_button").click( function() {
			var checkedItemsAsString = $('[id ="checkedUsers"]:checked').map(function() { return $(this).val().toString(); } ).get().join(",");
			if(checkedItemsAsString == ""){
				$("#page_message").text("no selected item");
				$("#page_message").css("background-color","rgba(255, 0, 0, 0.6)");
				displayMsg();
				return false;
			}
			else{
				var ok = confirm("Are you sure you want to activate selected subject(s)?");
				var page = parseInt($("#page_num").val());
				if(ok){
					jQuery.ajax({
						type: "POST",
						url: base_url + "index.php/setup_subject/activate",
						dataType: 'json',
						data: {id: checkedItemsAsString, page: page},
						success: function(res) {
							$("#page_message").css("background-color","rgba(0, 217, 54, 0.6)");
							repopulateSubjects(res,"User(s) successfully activated.");
						}
					});
				}
			}
		});

		$("#deactivate_user_button").click( function() {
			var checkedItemsAsString = $('[id ="checkedUsers"]:checked').map(function() { return $(this).val().toString(); } ).get().join(",");
			if(checkedItemsAsString == ""){
				$("#page_message").text("no selected item");
				$("#page_message").css("background-color","rgba(255, 0, 0, 0.6)");
				displayMsg();
				return false;
			}
			else{
				var ok = confirm("Are you sure you want to deactivate selected subject(s)?");
				var page = parseInt($("#page_num").val());
				if(ok){
					jQuery.ajax({
						type: "POST",
						url: base_url + "index.php/setup_subject/deactivate",
						dataType: 'json',
						data: {id: checkedItemsAsString, page: page},
						success: function(res) {
							$("#page_message").css("background-color","rgba(0, 217, 54, 0.6)");
							repopulateSubjects(res,"User(s) successfully deactivated.");
						}
					});
				}
			}
		});
		
    });