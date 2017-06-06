function repopulateUsers(json_data, message){
			//display success message
			if(message != ""){
				$("#page_message").text(message);
				displayMsg();
			}
			
			//blank out the check box headers
			$("#section_checkall").prop('checked', '');
			
			//reload table contents limit 10
			$("#user_tbl > tbody").empty();
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
					
					trHTML += "<tr><td ><input id='checkedUsers' type = 'checkbox' value = '"+item.user_id+"' /></td> <td><a href = '#' class = 'user_view' data-value= '"+item.user_id+"'>"+item.username+"</a></td> <td>"+item.fname+"</td> <td>"+item.lname+"</td> <td>"+item.position+"</td><td>"+status+"</td><td><a href = '#' class = 'user_edit' id = '' data-value='"+item.user_id+"'>Edit</a></td></tr>";
				}
			});
			$('#user_tbl').append(trHTML);
	   }

//this function will hide password fields from the edit page.
function hide_passwords()
{
	$(".password_row").hide();
}

function show_passwords()
{
	$(".password_row").show();
}
	   
function edit_user($id)
{
	var user_id = $id;
	$("#edit_flag").val(user_id);
	hide_passwords();
	//alert(user_id);
	jQuery.ajax({
		type: "POST",
		url: base_url + "index.php/setup_users/get_user_details",
		dataType: 'json',
		data: {user_id: user_id},
		success: function(res) {
			$("input#input_user_uname").val(res.username);
			$("input#input_user_fname").val(res.fname);
			$("input#input_user_lname").val(res.lname);
			$("select#input_user_position").val(res.usertype);
			$("select#input_user_uaccess").val(res.user_access);
			$("input#input_user_birthdate").val(res.birthdate);
			$("input#input_user_email").val(res.email);
			$("input#input_user_telephone_no").val(res.telephone_no);
			$("input#input_user_cellphone_no").val(res.cellphone_no);
			$("input#input_user_mother").val(res.mother_name);
			$("input#input_user_father").val(res.father_name);
			$("input#input_user_street_address").val(res.city_street);
			$("input#input_user_city").val(res.city_city);
			$("input#input_user_province").val(res.city_province);
			$("input#input_user_zip_code").val(res.zipcode_city);
			$("input#input_user_street_address_pr").val(res.province_street);
			$("input#input_user_provincial_city").val(res.province_city);
			$("input#input_user_provincial_province").val(res.province_province);
			$("input#input_user_provincial_zip_code").val(res.zipcode_province);
			// $("select#type").val(res.type);
			// $("input#datepicker").val(res.date_published);
		},
		error: function(data, status, headers, config){
			alert(status);
		}
	});
	showPopup("#add_user_popup");
}

	$(document).ready( function() {	
		
		//search functions
		
		$("#search_user_searchbt").click( function() {
			var search_username = $("#username_user").val();
			var search_fname = $("#firstname_user").val();
			var search_lname = $("#lastname_user").val();
			var search_flag = 1;
			
			$("#search_flag_user").val(1);
			$("#search_username").val(search_username);
			$("#search_fname").val(search_fname);
			$("#search_lname").val(search_lname);
			
			// if (search_text == "" && search_type == 0){
				// $("#page_message").text("Please enter search text or select type other than 'All'.");
				// $("#page_message").css("background-color","rgba(255, 0, 0, 0.6)");
				// displayMsg();
				// return false;
			// }else{
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_users/page",
				dataType: 'json',
				data: {page: 1, search_flag: search_flag, search_username: search_username, search_fname : search_fname, search_lname : search_lname},
				success: function(res) {
					repopulateUsers(res,"");
				},
				error: function(data, status, headers, config){
					alert(status);
				}
			});
			//}
		});
		
		$("#search_user_clearbt").click( function() {
			$("#username_user").val("");
			$("#firstname_user").val("");
			$("#lastname_user").val("");
			$("#search_flag_user").val(0);
			
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_users/page",
				dataType: 'json',
				data: {page: 1},
				success: function(res) {
					repopulateUsers(res,"");
				}
			});
			
		});
		
		// view > deactivate
		
		$("#view_user_deactivate").click( function() {
			var id = $("#view_user_id").val();
			var ok = confirm("Are you sure you want to deactivate this user?");
			var page = parseInt($("#page_num").val());
			if(ok){
				jQuery.ajax({
					type: "POST",
					url: base_url + "index.php/setup_users/deactivate",
					dataType: 'json',
					data: {id: id, page: page},
					success: function(res) {
						$("#page_message").css("background-color","rgba(0, 217, 54, 0.6)");
						repopulateUsers(res,"User successfully deactivated.");
					}
				});
			}
			
			hidePopup("#view_popup");
		});
		
		// view > activate
		
		$("#view_user_activate").click( function() {
			var id = $("#view_user_id").val();
			var ok = confirm("Are you sure you want to activate this user?");
			var page = parseInt($("#page_num").val());
			if(ok){
				jQuery.ajax({
					type: "POST",
					url: base_url + "index.php/setup_users/activate",
					dataType: 'json',
					data: {id: id, page: page},
					success: function(res) {
						$("#page_message").css("background-color","rgba(0, 217, 54, 0.6)");
						repopulateUsers(res,"User successfully activated.");
					}
				});
			}
			
			hidePopup("#view_popup");
		});
	
		// view > edit
		
		$("#view_user_edit").click( function() {
			hidePopup("#view_popup");
			var id = $("#view_user_id").val();
			edit_user(id);
		});
	
		//view user
		
		$(document).on('click', ".user_view", function() {
			showPopup("#view_popup");
			var user_id = $(this).data("value");
			$("#edit_flag").val(user_id);
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_users/get_user_details",
				dataType: 'json',
				data: {user_id: user_id},
				success: function(res) {
				//alert (res.username);
				$('#view_user_uname').html(res.username);
				$("#view_user_fname").html(res.fname);
				$("#view_user_lname").html(res.lname);
				$("#view_user_position").html(res.pos_descr);
				$("#view_user_uaccess").html(res.ua_descr);
				$("#view_user_birthdate").html(res.birthdate);
				$("#view_user_email").html(res.email);
				$("#view_user_telephone_no").html(res.telephone_no);
				$("#view_user_cellphone_no").html(res.cellphone_no);
				$("#view_user_mother").html(res.mother_name);
				$("#view_user_father").html(res.father_name);
				$("#view_user_street_address").html(res.city_street);
				$("#view_user_city").html(res.city_city);
				$("#view_user_province").html(res.city_province);
				$("#view_user_zip_code").html(res.zipcode_city);
				$("#view_user_street_address_pr").html(res.province_street);
				$("#view_user_provincial_city").html(res.province_city);
				$("#view_user_provincial_province").html(res.province_province);
				$("#view_user_provincial_zip_code").html(res.zipcode_province);
				
				$("#view_user_id").val(res.id);
				
				},
				error: function(data, status, headers, config){
					alert(status);
				}
			});
		});
	
	
		//edit user
		
		$(document).on('click', ".user_edit", function() {
			var user_id = $(this).data("value");
			//hide the password fields
			edit_user(user_id);
		});
		
		//end of edit user
	
		$("#add_user_button").click( function() {
			$("#edit_flag").val('');
			show_passwords();
			showPopup("#add_user_popup");
		});
		
		$("#section_checkall").change(function () {
			$("input:checkbox").prop('checked', $(this).prop("checked"));
		});
		
		$("#discard_user_button").click( function() {
			var ok = confirm("Are you sure you want to discard changes made to users?");
			if(ok){
				$("#form_user").trigger('reset'); //jquery
				hidePopup("#add_user_popup");
			}
		});
		
		$("#save_user_button").click( function() {
			var page = parseInt($("#page_num").val());
			var username = $("#input_user_uname").val();
			var fname = $("#input_user_fname").val();
			var lname = $("#input_user_lname").val();
			var position = $("#input_user_position").val();
			var useraccess = $("#input_user_uaccess").val();
			var birthdate = $("#input_user_birthdate").val();
			var telephone_no = $("#input_user_telephone_no").val();
			var cellphone_no = $("#input_user_cellphone_no").val();
			var email = $("#input_user_email").val();
			var mother_name = $("#input_user_mother").val();
			var father_name = $("#input_user_father").val();
			
			var street_province = $("#input_user_street_address").val();
			var city_province = $("#input_user_provincial_city").val();
			var state_province = $("#input_user_provincial_province").val();
			var zip_province = $("#input_user_provincial_zip_code").val();
			
			var street_city = $("#input_user_street_address").val();
			var city_city = $("#input_user_city").val();
			var state_city = $("#input_user_province").val();
			var zip_city = $("#input_user_zip_code").val();
			
			var edit_flag = $("#edit_flag").val();
			
			var password;
			var vpassword;
			
			if (edit_flag == ""){
				password = $("#input_user_password").val();
				vpassword = $("#confirm_user_password").val();
			}
			
			//validation:
			
			var validation_error = false;
			
			// var edit_flag = true;
			if(validation_error == false){
				jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_users/save",
				dataType: 'json',
				data: {fname: fname, lname: lname, position: position, username: username, password: password, birthdate: birthdate, telephone_no : telephone_no, cellphone_no : cellphone_no, email : email, mother_name : mother_name, father_name : father_name, street_province : street_province, city_province : city_province, state_province : state_province, zip_province : zip_province, street_city : street_city, city_city : city_city, state_city : state_city, zip_city : zip_city, useraccess : useraccess, edit_flag: edit_flag, page: page},
				success: function(res) {
					hidePopup("#add_user_popup");
					//clear fields
					$("#form_user").trigger('reset'); //jquery
					repopulateUsers(res,"User successfully added.");
					//$("#user_tbl > tbody").empty();
				},
				error: function(data, status, headers, config){
					alert(status);
				}
				});
			}
			
		});
		
	
	//pagination here
		
		$("#div_user_next").click( function() {
			var page = parseInt($("#page_num").val()) + 1;
			var next = $("#enable_next").val();
			var search_flag = $("#search_flag_user").val();
			
			var search_username = $("#search_username").val();
			var search_fname = $("#search_fname").val();
			var search_lname = $("#search_lname").val();
			
			//alert(page); alert(next);
			if(next == 1){
				jQuery.ajax({
					type: "POST",
					url: base_url + "index.php/setup_users/page",
					dataType: 'json',
					data: {page: page, search_flag: search_flag, search_username: search_username, search_fname : search_fname, search_lname : search_lname},
					success: function(res) {
						repopulateUsers(res,"");
						//$("#page_num").val(page);
						//$("#enable_prev").val(1);
					}
				});
			}
		});
		
		
		$("#div_user_prev").click( function() {
			var page = parseInt($("#page_num").val()) - 1;
			var prev = $("#enable_prev").val();
			var search_flag = $("#search_flag_user").val();
			
			var search_username = $("#search_username").val();
			var search_fname = $("#search_fname").val();
			var search_lname = $("#search_lname").val();
			
			//alert(page); alert(prev);
			if(prev == 1){
				jQuery.ajax({
					type: "POST",
					url: base_url + "index.php/setup_users/page",
					dataType: 'json',
					data: {page: page, search_flag: search_flag, search_username: search_username, search_fname : search_fname, search_lname : search_lname},
					success: function(res) {
						repopulateUsers(res,"");
						//$("#page_num").val(page);
						//$("#enable_next").val(1);
					}
				});
			}
		});
		
		$("#div_user_first").click( function() {
			var page = 1;
			var search_flag = $("#search_flag_user").val();
			
			var search_username = $("#search_username").val();
			var search_fname = $("#search_fname").val();
			var search_lname = $("#search_lname").val();
			
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_users/page",
				dataType: 'json',
				data: {page: page, search_flag: search_flag, search_username: search_username, search_fname : search_fname, search_lname : search_lname},
				success: function(res) {
					repopulateUsers(res,"");
					//$("#page_num").val(page);
					//$("#enable_next").val(1);
				}
			});
		});
 
 		$("#div_user_last").click( function() {
			var search_flag = $("#search_flag_user").val();
			
			var search_username = $("#search_username").val();
			var search_fname = $("#search_fname").val();
			var search_lname = $("#search_lname").val();
			
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/setup_users/page",
				dataType: 'json',
				data: {page: 0, search_flag: search_flag, search_username: search_username, search_fname : search_fname, search_lname : search_lname},
				success: function(res) {
					repopulateUsers(res,"");
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
				var ok = confirm("Are you sure you want to activate selected user(s)?");
				var page = parseInt($("#page_num").val());
				if(ok){
					jQuery.ajax({
						type: "POST",
						url: base_url + "index.php/setup_users/activate",
						dataType: 'json',
						data: {id: checkedItemsAsString, page: page},
						success: function(res) {
							$("#page_message").css("background-color","rgba(0, 217, 54, 0.6)");
							repopulateUsers(res,"User(s) successfully activated.");
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
				var ok = confirm("Are you sure you want to deactivate selected user(s)?");
				var page = parseInt($("#page_num").val());
				if(ok){
					jQuery.ajax({
						type: "POST",
						url: base_url + "index.php/setup_users/deactivate",
						dataType: 'json',
						data: {id: checkedItemsAsString, page: page},
						success: function(res) {
							$("#page_message").css("background-color","rgba(0, 217, 54, 0.6)");
							repopulateUsers(res,"User(s) successfully deactivated.");
						}
					});
				}
			}
		});
		
    });