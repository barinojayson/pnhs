function add_year(){
	var error_msg = "";
	var year = $("input#year").val();
	var description = $("input#year_description").val();

	if(year == ""){
		error_msg = error_msg + "Please input year level. \n";
	}
	
	if(year <= 0 ){
		error_msg = error_msg + "Please specify a non-zero positive numeric. \n";
	}
	
	if(error_msg != ""){
		alert("Add Year Level Error \n \n" + error_msg);
	}
	else{
	
		jQuery.ajax({
			type: "POST",
			url: base_url + "index.php/setup_year_level/save",
			dataType: 'json',
			data: {year: year, description:description},
			success: function(res) {
				clearFields();
				//addAnnouncement_hidepopup();
				repopulateYearLevel(res,"New Year Level has been created.");
			},
			error: function(data, status, headers, config){
				alert(status);
			}
		});
	}
}

function isInt(number){
	return Number(number) === number && number % 1 === 0;
}

$(document).ready( function() {
	
	$("#yl_checkall").change(function () {
		$(".checkYl").prop('checked', $(this).prop("checked"));
	});
	
	$("#add_year").click( function() {
		add_year();
	});
	
	//clear button
	
	$("#clear_year").click( function() {
		//identify page to load
		//if the user is currently using search, reset the fields and bring the user back to the page 1
		if($("#search_flag_yl").val() == 1){
			//reset hidden fields
			$("#search_flag_yl").val(0);
			$("#search_yl_hidden").val(0);
			$("#search_yl_descr_hidden").val(""); 
			
			//reload table
			jQuery.ajax({
			type: "POST",
			url: base_url + "index.php/setup_year_level/page",
			dataType: 'json',
			data: {page: 1},
			success: function(res) {
				repopulateYearLevel(res,"Search keys cleared.");
				}
			});
			
		 }
		//reset text fields
		clearFields();		
	});

//add discard button

	$("#discard_subject_button").click( function() {
		var ok = confirm("Are you sure you want to discard any changes?");
		if(ok){
			$("#form_section").trigger('reset');
			$("#form_sec_subjects").trigger('reset');			
			hidePopup("#edit_section_popup");
		}
	});
	
	//Start function definition here//
	
	
	$("#search_year").click( function() {
			var search_yl = $("#year").val();
			var search_yl_descr = $("#year_description").val();			
			var search_flag = 1;
			//alert(search_yl_descr);
			//set hidden fields
			$("#search_flag_yl").val(1);
			$("#search_yl_hidden").val(search_yl); 
			$("#search_yl_descr_hidden").val(search_yl_descr);
			
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_year_level/page",
				dataType: 'json',
				data: {page: 1, search_flag: search_flag, search_yl: search_yl,  search_yl_descr: search_yl_descr},
				success: function(res) {
					repopulateYearLevel(res,"");
				},
				error: function(data, status, headers, config){
					alert(headers);
				}
			});
	});
	
	//delete function
	
	//edit click function
	
	$(document).on('click', ".section_edit", function() {
		var section_id = $(this).data("value");
		edit_section(section_id);
	});
	
	//end of edit click function

	//view functions
	
	$(document).on('click', ".year_level_view", function() {
		showPopup("#view_popup");
		var yl_id = $(this).data("value");
		// $("#edit_flag").val(user_id);
		jQuery.ajax({
			type: "POST",
			url: base_url + "index.php/year_level/get_year_level_details",
			dataType: 'json',
			data: {yl_id: yl_id},
			success: function(res) {
			//alert (res.username);
			$('#view_yl_year').html(res.grade_level);
			$(".view_yl_description").html(res.description);
			//$("#view_user_lname").html(res.lname);			
			//$("#view_user_id").val(res.id);
			
			},
			error: function(data, status, headers, config){
				alert(headers);
			}
		}); 
	});
		
		//end of view
	
	$("#deleteYl").click( function() {
		var checkedItemsAsString = $('[class ="checkYl"]:checked').map(function() { return $(this).val().toString(); } ).get().join(",");
		if(checkedItemsAsString == ""){
			$("#page_message").text("no selected item");
			$("#page_message").css("background-color","rgba(255, 0, 0, 0.6)");
			displayMsg();
			return false;
		}
		else{
			var ok = confirm("Are you sure you want to delete selected section(s)?");
			var page = parseInt($("#page_num").val());
			if(ok){
				jQuery.ajax({
					type: "POST",
					url: base_url + "index.php/setup_year_level/delete",
					dataType: 'json',
					data: {id: checkedItemsAsString, page: 1},
					success: function(res) {
						$("#page_message").css("background-color","rgba(0, 217, 54, 0.6)");
						repopulateYearLevel(res,"Section(s) has been deleted.");
					},
					error: function(data, status, headers, config){
						alert(headers);
					}
				});
			}
		}
	});
		
	// end of delete function
	
	//pagination here
	
	$("#div_yl_next").click( function() {
		
		var page = parseInt($("#page_num").val()) + 1;
		var next = $("#enable_next").val();

		var search_yl = $("#search_yl_hidden").val();
		var search_yl_descr = $("#search_yl_descr_hidden").val();			
		var search_flag = $("#search_flag_yl").val();
		
		//alert(page); alert(next);
		if(next == 1){
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_year_level/page",
				dataType: 'json',
				data: {page: page, search_flag: search_flag, search_yl: search_yl, search_yl_descr : search_yl_descr},
				success: function(res) {
					repopulateYearLevel(res,"");
				}
			});
		}
	});
	
	
	$("#div_yl_prev").click( function() {
		var page = parseInt($("#page_num").val()) - 1;
		var prev = $("#enable_prev").val();
		
		var search_yl = $("#search_yl_hidden").val();
		var search_yl_descr = $("#search_yl_descr_hidden").val();			
		var search_flag = $("#search_flag_yl").val();
		
		//alert(page); alert(prev);
		if(prev == 1){
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_year_level/page",
				dataType: 'json',
				data: {page: page, search_flag: search_flag, search_yl: search_yl, search_yl_descr : search_yl_descr},
				success: function(res) {
					repopulateYearLevel(res,"");
				}
			});
		}
	});
	
	$("#div_yl_first").click( function() {
		var page = 1;
		
		var search_yl = $("#search_yl_hidden").val();
		var search_yl_descr = $("#search_yl_descr_hidden").val();			
		var search_flag = $("#search_flag_yl").val();
		
		jQuery.ajax({
			type: "POST",
			url: base_url + "index.php/setup_year_level/page",
			dataType: 'json',
			data: {page: page, search_flag: search_flag, search_yl: search_yl, search_yl_descr : search_yl_descr},
			success: function(res) {
				repopulateYearLevel(res,"");
			}
		});
	});

	$("#div_yl_last").click( function() {
		
		page = 0;
		
		var search_yl = $("#search_yl_hidden").val();
		var search_yl_descr = $("#search_yl_descr_hidden").val();			
		var search_flag = $("#search_flag_yl").val();
		
		jQuery.ajax({
			type: "POST",
			url: base_url + "index.php/setup_year_level/page",
			dataType: 'json',
			data: {page: page, search_flag: search_flag, search_yl: search_yl, search_yl_descr : search_yl_descr},
			success: function(res) {
				repopulateYearLevel(res,"");
			},
				error: function(data, status, headers, config){
					alert(status);
			}
		});
	});
	
	//end pagination
});	
	
	
function repopulateYearLevel(json_data, message){
	//display success message
	if(message != ""){
		$("#page_message").text(message);
		displayMsg();
	}
	//blank out the check box headers
	$("#yl_checkall").prop('checked', '');
	
	//reload table contents limit 10
	$("#yl_tbl > tbody").empty();
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
			
			trHTML += "<tr> <td ><input class='checkYl' type = 'checkbox' value = '"+item.id+"' /></td><td>"+item.grade_level+"</td><td><a href = '#' class = '' data-value='"+item.id+"'> "+item.description+"</a></td><td>"+item.date_created+"</td><td><a href = '#' class='' id = '' data-value='"+item.id+"'>Edit</a></td></tr>";
		}
	});
	$('#yl_tbl').append(trHTML);
}

function edit_section(id)
{
	var section_id = id;
	$("#edit_flag").val(section_id);
	//alert(section_id);
	jQuery.ajax({
		type: "POST",
		url: base_url + "index.php/setup_section/get_section_details",
		dataType: 'json',
		data: {section_id: section_id},
		success: function(res) {
			populateSubjects(res);
		},
		error: function(data, status, headers, config){
			alert(status);
		}
	});
	showPopup("#edit_section_popup");
}

function clearFields(){	
	$("#year").val("");
	$("#year_description").val("");
}
//end function definition