/* Set global variables */

var sub_dropdown = "";
var subs = new Array();
var teachers = new Array();
var tea_dropdown = "";
var global_section_id = "";
var yl_dropdown = "";
var section_json = "";

function repopulateSection(json_data, message){
			//display success message
		 	if(message != ""){
				$("#page_message").text(message);
				displayMsg();
			}
			//blank out the check box headers
			$("#section_checkall").prop('checked', '');
			
			//reload table contents limit 10
			$("#section_tbl > tbody").empty();
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
					trHTML += "<tr><td><input id='checkSection' class = 'checkSection' type = 'checkbox' value = '"+item.id+"'</td><td><a href = '#' class = 'section_view' data-value='"+item.id+"'>"+item.section_name+"</a></td><td>"+item.year_level+"</td><td>"+item.max_student+"</td><td>"+item.waive+"</td><td><a href = '#' class='section_edit' id = '' data-value='"+item.id+"'>Edit</a></td></tr>";
				}
			});
			$('#section_tbl').append(trHTML);
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
			alert(data);
		}
	});
	showPopup("#edit_section_popup");
}

function clearFields(){	
	$("#section").val("");
	$("#add_section_yearlevel").val("-1");
	$("#section_max_student").val("");
	$('#waive_flag').attr("checked", false);
}


function save_subject(sec_sub_id, subject_id){
	var error_flag = false;
	
	jQuery.ajax({
		type: "POST",
		url: base_url + "index.php/setup_section/save_subject",
		dataType: 'json',
		data: {sec_sub_id: sec_sub_id, subject_id: subject_id},
		success: function(res) {
			$.each(res, function (i, item) {
				if(i == 'success'){
					if (item == '0'){
						error_flag = true;
					}
				}
				else if(i == 'message' && error_flag){
					alert(item);
				}
			})
		},
		error: function(data, status, headers, config){
			alert(headers);
		}
	});
}


function save_teacher(sec_sub_id, teacher_id){
	var error_flag = false;
	
	jQuery.ajax({
		type: "POST",
		url: base_url + "index.php/setup_section/save_teacher",
		dataType: 'json',
		data: {sec_sub_id: sec_sub_id, teacher_id: teacher_id},
		success: function(res) {
			$.each(res, function (i, item) {
				if(i == 'success'){
					if (item == '0'){
						error_flag = true;
					}
				}
				else if(i == 'message' && error_flag){
					alert(item);
				}
			});
		},
		error: function(data, status, headers, config){
			alert(headers);
		}
	});
}

function populateSubjects(json_data){
	var sub_descr;
	var sub_id;
	$.each(json_data, function (i, item) {
		
		switch(i){
			
			case "0": /*　All year levels - format the dropdown */
				
				yl_dropdown = "<select class = 'edit_section_yl textinput' style = 'width: 404px;' id = 'edit_yl' >";
				yl_dropdown = yl_dropdown+"<option value = '-1'>--Please Select--</option>";
				$.each(item, function(i2, item2){
					var sub_code;
					
					$.each(item2, function(i3, item3){
						// alert(subs[i3]);
						
						if (i3 == "id"){
							yl_id = item3;
						}else if(i3 == "grade_level"){
							yl_grade_level = item3;
						}else if(i3 == "description"){
							yl_descr = yl_grade_level+" - "+item3;
							yl_dropdown = yl_dropdown+"<option value = '"+ yl_id +"'>"+yl_descr+"</option>";
							//subs[yl_id] = item3;
						}
					});
				});
				yl_dropdown = yl_dropdown+"</select>";
				break;
			
			case "1": /*　All subjects - format the dropdown */
				
				sub_dropdown = "<select class = 'edit_section_subject' name = 'edit_section_subject' style = 'width: 240px;' >";
				sub_dropdown = sub_dropdown+"<option value = '0'>--Please Select--</option>";
				$.each(item, function(i2, item2){
					var sub_code;
					
					$.each(item2, function(i3, item3){
						// alert(subs[i3]);
						if (i3 == "subject_code"){
							sub_code = item3;
						}else if(i3 == "id"){
							sub_id = item3;
						}else if(i3 == "description"){
							sub_descr = sub_code+" - "+item3;
							sub_dropdown = sub_dropdown+"<option value = '"+ sub_id +"' descr = '"+item3+"'>"+sub_descr+"</option>";
							subs[sub_id] = item3;
						}
					});
				});
				sub_dropdown = sub_dropdown+"</select>";
				break;
			
			case "2":　/* All　Teachers. Create Teacher dropdown. */
			
				tea_dropdown = "<select class = 'edit_section_subject_teacher' style = 'width: 240px;'>";
				tea_dropdown = tea_dropdown+"<option value = '0'>--Please Select--</option>";
				
				var user_id; 
				var tfname;
				var tlname;
				$.each(item, function(i2, item2){
					$.each(item2, function(i3, item3){
						switch(i3){
							case 'user_id':
								user_id = item3;
								break;
							case 'fname':
								tfname = item3;
								break;
							case 'lname':
								tlname = item3;
								tea_dropdown = tea_dropdown+"<option value = '"+ user_id +"'>"+tfname+" "+tlname+"</option>";
								teachers[user_id] = tfname+" "+tlname;
								break;
						}
					});
				});
				tea_dropdown = tea_dropdown+"</select>";
				break;
			
			case "3":　/*　Section subjects. */
				$("#form_sec_subjects > tbody").empty();
				$.each(item, function(i2, item2){
					
					/* Create TR */
					trSubHTML = "<tr class = 'sec_sub_row' >";
					trTeachHTML = "";
					trSubCodeHTML = "";
					valId = "";
					var sec_sub_id;
					$.each(item2, function(i3, item3){
						switch(i3){
							case 'sec_sub_id':
								sec_sub_id = item3;
								break;
							case 'section_id':
								valId = valId + item3;
								break;
							case 'subject_id':
								valId = valId + item3;
								break;
							case 'subject_description':
								trSubCodeHTML = "<td width = '45%' class = 'sec_sub' ><input type = 'hidden' class = 'id_holder' value ="+sec_sub_id+" ><div class = 'sec_sub_content' >"+item3+"</div></td>";
								break;
							case 'teacher':
								trTeachHTML = "<td width = '45%' class = 'sec_sub_teach' ><div class = 'sec_sub_content' >"+item3+"</div></td>";
								break;
							default:
						}
					});
					trSubHTML = trSubHTML + trSubCodeHTML + trTeachHTML;
					trSubHTML = trSubHTML+ "<td width = '5%'><input type='button' value = '-' class = 'button del_sec_sub' /> </td> </tr>";
					$('#form_sec_subjects').find('tbody').append(trSubHTML);
					/* End Create TR */
				});
				break;
				
			default:
				switch(i){
					case 'section_name':
						$('#edit_section_name').val(item);
						break;
					case 'max_student':
						$('#edit_max_student').val(item);
						break;
					case 'year_level':
						$('#yl_dropdown').html(yl_dropdown);
						$("#edit_yl").val(item);
						break;
					case 'waive_flag':
						if(item == 1){
							$('#edit_waive_flag').attr("checked", true);							
						}
						break;
				}

		}
			
		//if(i == 'section_name'){
			//alert(i);
			//alert(item.section_name);
			//$("input#edit_section_name").val(item[i].section_name);
			//$("input#edit_year_level").val(item.year_level);
			//$("input#edit_max_student").val(item.max_student);
			// if(item.waive_flag == 1){
				// $('#edit_waive_flag').prop("checked", true);
			// }
		//}
	});
	
	//format add drop downs
	
	$('#add_section_subject').html(sub_dropdown);
	$('#add_section_subject').find('.edit_section_subject').removeClass('edit_section_subject');
	
	$('#add_subject_teacher').html(tea_dropdown);
	$('#add_subject_teacher').find('.edit_section_subject_teacher').removeClass('edit_section_subject_teacher');
	
}
	
//end function definition


/* Set global variables */

$(document).ready( function() {
	
	$("#section_checkall").change(function () {
		$(".checkSection").prop('checked', $(this).prop("checked"));
	});
	
	$("#add_section_button").click( function() {	
		add_section();
	});
	
	//clear button
	
	$("#section_clear").click( function() {
		//identify page to load
		//if the user is currently using search, reset the fields and bring the user back to the page 1
		if($("#search_flag_section").val() == 1){
			//reset hidden fields
			$("#search_flag_section").val(0);
			$("#search_section_name").val(""); 
			$("#search_year_level").val(-1);
			$("#search_max_student").val("");
			$("#search_waive_flag").val(0);
			
			//reload table
			jQuery.ajax({
			type: "POST",
			url: base_url + "index.php/setup_section/page",
			dataType: 'json',
			data: {page: 1},
			success: function(res) {
				repopulateSection(res,"");
				}
			});
			
		}
		//reset text fields
		clearFields();		
	});

	//close button

	$("#discard_subject_button").click( function() {
		var ok = confirm("Are you sure you want to close the edit page? Any unsaved changes will be discarded.");
		if(ok){
			$("#form_section").trigger('reset');
			$("#form_sec_subjects").trigger('reset');			
			hidePopup("#edit_section_popup");
			if (section_json != ""){
				repopulateSection(section_json, "");
			}
		}
	});
	
	//Start function definition here//
	
	function add_section(){
		var error_msg = "";
		var section = $("input#section").val();
		var year_level = $("#add_section_yearlevel").val();
		var max_student = $("input#section_max_student").val();
		var waive = 0;
		if($('#waive_flag').is(":checked")){
			waive = 1;
		}
		
 		if(section == ""){
			error_msg = error_msg + "Section Name is required. \n";
		}
		
		if(year_level == -1){
			error_msg = error_msg + "Year Level is required. \n";
		}

		if(max_student == ""){
			error_msg = error_msg + "Max No. of Students is required. \n";
		} 
		
		if(error_msg != ""){
			alert("Add Section Error \n \n" + error_msg);
		}
		else{
		
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_section/save",
				dataType: 'json',
				data: {section: section, year_level: year_level, max_student: max_student, waive: waive},
				success: function(res) {
					clearFields();
					//addAnnouncement_hidepopup();
					repopulateSection(res,"New Section has been created.");
				},
				error: function(data, status, headers, config){
					alert(status);
				}
			});
		}
	}
	
	
	$("#search_section_button").click( function() {
			var search_section_name = $("#section").val();
			var search_year_level = $("#add_section_yearlevel").val();
			var search_max_student = $("#section_max_student").val();
			var search_waive_flag = 0;
			
			if($('#waive_flag').is(":checked")){
				search_waive_flag = 1;
			}
			
			var search_flag = 1;
			
			//set hidden fields
			$("#search_flag_section").val(1);
			$("#search_section_name").val(search_section_name); 
			$("#search_year_level").val(search_year_level);
			$("#search_max_student").val(search_max_student);
			$("#search_waive_flag").val(search_waive_flag);
			
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_section/page",
				dataType: 'json',
				data: {page: 1, search_flag: search_flag, section_name: search_section_name, year_level : search_year_level, max_student : search_max_student, waive_flag : search_waive_flag},
				success: function(res) {
					repopulateSection(res,"");
				},
				error: function(data, status, headers, config){
					alert(status);
				}
			});
		});
	
	//edit click function
	
	$(document).on('click', ".section_edit", function() {
		var section_id = $(this).data("value");
		global_section_id = section_id;
		edit_section(section_id);
	});
	
	//end of edit click function
	
	$(document).on('click', ".del_sec_sub", function() {
		sec_sub_id = $(this).parent('td').parent('.sec_sub_row').find('.sec_sub').find('.id_holder').val();
		var ok = confirm("Are you sure you want to delete this subject?");
		if (ok){
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_section/delete_subject",
				dataType: 'text',
				data: {sec_sub_id : sec_sub_id},
				success: function(res) {
					edit_section(global_section_id);
				},
				error: function(data, status, headers, config){
					alert(headers);
				}
			});
		}
	});
	
	
	$("#deleteSection").click( function() {
			var checkedItemsAsString = $('[id ="checkSection"]:checked').map(function() { return $(this).val().toString(); } ).get().join(",");
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
						url: base_url + "index.php/setup_section/delete",
						dataType: 'json',
						data: {id: checkedItemsAsString, page: page},
						success: function(res) {
							$("#page_message").css("background-color","rgba(0, 217, 54, 0.6)");
							repopulateSection(res,"Section(s) has been deleted.");
						},
						error: function(data, status, headers, config){
								alert(status);
						}
					});
				}
			}
		});
		
	// end of delete function
	
	//pagination here
	
	$("#div_section_next").click( function() {
		
		var page = parseInt($("#page_num").val()) + 1;
		var next = $("#enable_next").val();
		
		var search_flag = $("#search_flag_section").val();
		var search_section_name = $("#search_section_name").val();
		var search_year_level = $("#search_year_level").val();
		var search_max_student = $("#search_max_student").val();
		var search_waive_flag = $("#search_waive_flag").val();
		
		//alert(page); alert(next);
		if(next == 1){
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_section/page",
				dataType: 'json',
				data: {page: page, search_flag: search_flag, section_name: search_section_name, year_level : search_year_level, max_student : search_max_student, waive_flag : search_waive_flag},
				success: function(res) {
					repopulateSection(res,"");
				}
			});
		}
	});
	
	
	$("#div_section_prev").click( function() {
		var page = parseInt($("#page_num").val()) - 1;
		var prev = $("#enable_prev").val();
		
		var search_flag = $("#search_flag_section").val();
		var search_section_name = $("#search_section_name").val();
		var search_year_level = $("#search_year_level").val();
		var search_max_student = $("#search_max_student").val();
		var search_waive_flag = $("#search_waive_flag").val();
		
		//alert(page); alert(prev);
		if(prev == 1){
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_section/page",
				dataType: 'json',
				data: {page: page, search_flag: search_flag, section_name: search_section_name, year_level : search_year_level, max_student : search_max_student, waive_flag : search_waive_flag},
				success: function(res) {
					repopulateSection(res,"");
				}
			});
		}
	});
	
	$("#div_section_first").click( function() {
		var page = 1;
		
		var search_flag = $("#search_flag_section").val();
		var search_section_name = $("#search_section_name").val();
		var search_year_level = $("#search_year_level").val();
		var search_max_student = $("#search_max_student").val();
		var search_waive_flag = $("#search_waive_flag").val();
		
		jQuery.ajax({
			type: "POST",
			url: base_url + "index.php/setup_section/page",
			dataType: 'json',
			data: {page: page, search_flag: search_flag, section_name: search_section_name, year_level : search_year_level, max_student : search_max_student, waive_flag : search_waive_flag},
			success: function(res) {
				repopulateSection(res,"");
			}
		});
	});

	$("#div_section_last").click( function() {
		
		page = 0;
		
		var search_flag = $("#search_flag_section").val();
		var search_section_name = $("#search_section_name").val();
		var search_year_level = $("#search_year_level").val();
		var search_max_student = $("#search_max_student").val();
		var search_waive_flag = $("#search_waive_flag").val();
		
		jQuery.ajax({
			type: "POST",
			url: base_url + "index.php/setup_section/page",
			dataType: 'json',
			data: {page: page, search_flag: search_flag, section_name: search_section_name, year_level : search_year_level, max_student : search_max_student, waive_flag : search_waive_flag},
			success: function(res) {
				repopulateSection(res,"");
			},
				error: function(data, status, headers, config){
					alert(status);
			}
		});
	});
	
	//end pagination
	
	//add subjects
	$(document).on('click', "#add_subject_btn", function() {
		var section_id = global_section_id;
		var subject_id = $("#add_section_subject").find("select").val();
		var teacher_id = $("#add_subject_teacher").find("select").val();
		$("#add_section_subject").find("select").val(0);
		$("#add_subject_teacher").find("select").val(0);
	
		if(subject_id != 0 && teacher_id != 0 ){
			//to update
			jQuery.ajax({
			type: "POST",
			url: base_url + "index.php/setup_section/add_subject",
			dataType: 'json',
			data: {section_id: section_id, subject_id: subject_id, teacher_id: teacher_id},
			success: function(res) {
				$.each(res, function (i, item) {
					if(i == 'sec_sub_id'){
						sec_sub_id = item;
					}
					else if(i == 'subject_id'){
						subject_id = item;
					}
					else if(i == 'teacher_id'){
						teacher_id = item;
					}
				});
				//populate row
				trSubHTML = "<tr class = 'sec_sub_row' >";
				
				trSubCodeHTML = "<td width = '45%' class = 'sec_sub' ><input type = 'hidden' class = 'id_holder' value ="+sec_sub_id+" ><div class = 'sec_sub_content' >"+subs[subject_id]+"</div></td>";
				trTeachHTML = "<td width = '45%' class = 'sec_sub_teach' ><div class = 'sec_sub_content' >"+teachers[teacher_id]+"</div></td>";
				trSubHTML = trSubHTML + trSubCodeHTML + trTeachHTML;
				trSubHTML = trSubHTML+ "<td width = '5%'><input type='button' value = '-' class = 'button del_sec_sub' /> </td> </tr>";
				$('#form_sec_subjects').find('tbody').append(trSubHTML);
				
			},
			error: function(data, status, headers, config){
				alert(headers);
			}
			});
		}else{
			alert("Error: Please select subject and teacher.");
		}
		
	});
	
	//edit subjects
	$(document).on('dblclick', ".sec_sub", function() {
		$(this).find('.sec_sub_content').html(sub_dropdown);
	});
	
	$(document).on('change', ".edit_section_subject", function() {
				
		var val = $(this).val();
		var sec_sub_id;
		sec_sub_id = $(this).parent('.sec_sub_content').parent('td').find(".id_holder").val();
		save_subject(sec_sub_id, val);
		$(this).parent('.sec_sub_content').html(subs[val]);
	});	
	

	$(document).on('dblclick', ".sec_sub_teach", function() {
		$(this).find('.sec_sub_content').html(tea_dropdown);
	});
	
	$(document).on('change', ".edit_section_subject_teacher", function() {
		//do save		
		var val = $(this).val();
		var sec_sub_id;
		sec_sub_id = $(this).parent('.sec_sub_content').parent('td').parent('tr').find('.sec_sub').find(".id_holder").val();
		
		save_teacher(sec_sub_id, val);
		
		$(this).parent('.sec_sub_content').html(teachers[val]);
	});	
	
	
	
	$(document).on('click', "#save_section_button", function() {
		
		var page = parseInt($("#page_num").val());
		var edit_flag = global_section_id;

		var error_msg = "";
		var section = $("#edit_section_name").val();
		var year_level = $("#edit_yl").val();
		var max_student = $("#edit_max_student").val();
		var waive = 0;
		if($('#edit_waive_flag').is(":checked")){
			waive = 1;
		}
		
 		if(section == ""){
			error_msg = error_msg + "Section Name is required. \n";
		}
		
		if(year_level == -1){
			error_msg = error_msg + "Year Level is required. \n";
		}

		if(max_student == ""){
			error_msg = error_msg + "Max No. of Students is required. \n";
		} 
		
		if(error_msg != ""){
			alert("Add Section Error \n \n" + error_msg);
		}
		else{
		
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_section/save",
				dataType: 'json',
				data: {page: page, edit_flag: edit_flag, section: section, year_level: year_level, max_student: max_student, waive: waive},
				success: function(res) {
					//clearFields();
					//repopulateSection(res,"New Section has been created.");
					section_json = res;
					alert('Section details has been saved.');
				},
				error: function(data, status, headers, config){
					alert(data.status);
					alert(data.responseText);
				}
			});
		}
	
	});
	
});	