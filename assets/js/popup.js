    function showPopup(div_id){
	   $(div_id).fadeIn("10");
	   $(div_id).css({"visibility":"visible","display":"block"});	   
	}
			
	function hidePopup(div_id){
		$(div_id).fadeOut("10");
		$(div_id).css({ // this is just for style        
			"opacity": "1"  
		}); 
	}
	
	function displayMsg(){
		$( ".page_message").fadeIn(300).delay(800).fadeOut(2000);
	}
	
	$(document).ready( function() {

		/*Search Functions*/
		
		$("#search_announcement_searchbt").click( function() {
			var search_text = $("#search_announcement_text").val();
			var search_type = $("#search_announcement_type").val();
			var search_flag = 1;
			$("#search_flag_announcement").val(1);
			$("#search_text_hidden").val(search_text);
			$("#search_type_hidden").val(search_type);
			if (search_text == "" && search_type == 0){
				$("#page_message").text("Please enter search text or select type other than 'All'.");
				$("#page_message").css("background-color","rgba(255, 0, 0, 0.6)");
				displayMsg();
				return false;
			}else{
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/manage_announcements/page",
				dataType: 'json',
				data: {page: 1, search_flag: search_flag, search_text: search_text, search_type: search_type},
				success: function(res) {
					repopulateAnnouncement(res,"");
				}
			});
			}
		});
		
		$("#clear_search_announcement").click( function() {
			$("#search_announcement_text").val("");
			$("select#search_announcement_type").val("0");
			$("#search_flag_announcement").val(0);
			
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/manage_announcements/page",
				dataType: 'json',
				data: {page: 1},
				success: function(res) {
					repopulateAnnouncement(res,"");
				}
			});
			
		});
		
		/*View Announcement*/
		
		// function showPopup(div_id){
		   // $(div_id).fadeIn("10");
		   // $(div_id).css({"visibility":"visible","display":"block"});
		// }
		
		$("#hideViewPopup").click( function() {
			hidePopup("#view_popup");
		});
		
		// function hidePopup(div_id){
			// $(div_id).fadeOut("10");
            // $(div_id).css({ // this is just for style        
                // "opacity": "1"  
            // }); 
		// }
		
		$(document).on('click', ".announcement_view", function() {
			showPopup("#view_popup");
			var announcement_id = $(this).data("value");
			$("#edit_flag").val(announcement_id);
			//alert(announcement_id);
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/manage_announcements/get_announcement_detail",
				dataType: 'json',
				data: {announcement_id: announcement_id},
				success: function(res) {
					var audience = "All";
					if (res.type == 1 ){
						audience = "Teachers";
					}else if(res.type == 2){
						audience = "Students";
					}
					$("#view_announcement_title").text(res.title);
					$("#view_announcement_type").text("Audience: " + audience);
					$("#view_announcement_date_published").text("Date Published: " + res.date_published);
					$("#view_announcement_id").val(res.id);
					$("#view_announcement_content").html(res.content);
					$("#view_announcement_created_by").text("Created By: " + res.created_by);
					$("#view_announcement_date_created").text("Date Created: " +res.date_created);
					$("#view_announcement_modified_by").text("Modified By: " + res.modified_by);
					$("#view_announcement_date_modified").text("Date Modified: " +res.date_modified);
				}
			});
		});
		
		$("#view_announcement_delete").click( function() {
			var id = $("#view_announcement_id").val();
			var ok = confirm("Are you sure you want to delete this announcement?");
			var page = parseInt($("#page_num").val());
			if(ok){
				jQuery.ajax({
					type: "POST",
					url: base_url + "index.php/manage_announcements/delete",
					dataType: 'json',
					data: {id: id, page: page},
					success: function(res) {
						$("#page_message").css("background-color","rgba(0, 217, 54, 0.6)");
						repopulateAnnouncement(res,"Announcement(s) successfully deleted.");
					}
				});
			}
			
			hidePopup("#view_popup");
		});
		
		$("#view_announcement_edit").click( function() {
			hidePopup("#view_popup");
			var id = $("#view_announcement_id").val();
			edit_announcement(id);
		});
		
		function edit_announcement($id)
		{
			var announcement_id = $id;
			$("#edit_flag").val(announcement_id);
			//alert(announcement_id);
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/manage_announcements/get_announcement_detail",
				dataType: 'json',
				data: {announcement_id: announcement_id},
				success: function(res) {
					$("input#title").val(res.title);
					$("select#type").val(res.type);
					$("input#datepicker").val(res.date_published);
					tinyMCE.activeEditor.setContent(res.content);
				}
			});
			addAnnouncement_popup();
		}
		
		/*Add Announcement*/
		
		$("#showPopup").click( function() {
			$("#edit_flag").val('');
			showPopup("#add_popup");
		});
		
	   $("#hidePopup").click( function() {
			var ok = confirm("Are you sure you want to discard changes?");
			if(ok){
				$("#frm_announcement").trigger('reset'); //jquery
				hidePopup("#add_popup");
			}

		});
	   
	   $(".save_announcement").click(function(event) {
		event.preventDefault();
		var page = parseInt($("#page_num").val());
		var title = $("input#title").val();
		var type = $("#type").val();
		var datepicker = $("input#datepicker").val();
		var content = tinymce.get("content").getContent();
		var edit_flag = $("#edit_flag").val();
		jQuery.ajax({
		type: "POST",
		url: base_url + "index.php/manage_announcements/save",
		dataType: 'json',
		data: {title: title, type: type, datepicker: datepicker, content: content, edit_flag: edit_flag, page: page},
		success: function(res) {
			//addAnnouncement_hidepopup();
			hidePopup("#add_popup");
			repopulateAnnouncement(res,"Announcement successfully saved.");
		}
		});
		});
	   
	   function repopulateAnnouncement(json_data, success_message){
			//display success message
			if(success_message != ""){
				$("#page_message").text(success_message);
				displayMsg();
			}
			
			//clear fields
			$("#frm_announcement").trigger('reset'); //jquery
			
			//reload table contents limit 10
			$("#announcement_tbl > tbody").empty();
			var trHTML = '';
			$.each(json_data, function (i, item) {
				if(i == 0){// alert("prev : " + item.prev + "next : " + item.next);
					$("#page_num").val(item.page_num);
					$("#announcement_current_page").text("(Page " + item.page_num + " of " + item.total_page + ")");
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
					trHTML += "<tr> <td ><input id = 'checkedAnnouncement' type = 'checkbox' value = " + item.id + " /></td> <td> <a href = '#' class='announcement_view' id = '"+ item.id +"' data-value='" + item.id + "'>" +item.title+"</a></td> <td> " + item.date_created + " </td> <td> " + item.date_published + " </td><td> " + item.created_by + " </td><td><a href = '#' class='announcement_edit' id = '' data-value='" + item.id + "'>Edit</a></td></tr>";
				}
			});
			$('#announcement_tbl').append(trHTML);
	   }
	   
	
        function addAnnouncement_hidepopup() {    // TO Unload the Popupbox
            $('#add_popup').fadeOut("10");
            $("#add_popup").css({ // this is just for style        
                "opacity": "1"  
            }); 
        }
      
	 	function addAnnouncement_popup()
		{
		   $("#add_popup").fadeIn("10");
		   $("add_popup").css({"visibility":"visible","display":"block"});
		}
		
		$("#deleteAnnouncement").click( function() {
			var checkedItemsAsString = $('[id ="checkedAnnouncement"]:checked').map(function() { return $(this).val().toString(); } ).get().join(",");
			if(checkedItemsAsString == ""){
				$("#page_message").text("no selected item");
				$("#page_message").css("background-color","rgba(255, 0, 0, 0.6)");
				displayMsg();
				return false;
			}
			else{
				var ok = confirm("Are you sure you want to delete selected item(s)?");
				var page = parseInt($("#page_num").val());
				if(ok){
					jQuery.ajax({
						type: "POST",
						url: base_url + "index.php/manage_announcements/delete",
						dataType: 'json',
						data: {id: checkedItemsAsString, page: page},
						success: function(res) {
							$("#page_message").css("background-color","rgba(0, 217, 54, 0.6)");
							repopulateAnnouncement(res,"Announcement(s) successfully deleted.");
						}
					});
				}
			}
		});
		
		$("#ann_checkall").change(function () {
			$("input:checkbox").prop('checked', $(this).prop("checked"));
		});
		   
		$(document).on('click', ".announcement_edit", function() {
			var announcement_id = $(this).data("value");
			edit_announcement(announcement_id);
		});
		
		//pagination here
		
		$("#div_next").click( function() {
			var page = parseInt($("#page_num").val()) + 1;
			var next = $("#enable_next").val();
			var search_flag = $("#search_flag_announcement").val();
			var search_text = $("#search_text_hidden").val();
			var search_type = $("#search_type_hidden").val();
			//alert(page); alert(next);
			if(next == 1){
				jQuery.ajax({
					type: "POST",
					url: base_url + "index.php/manage_announcements/page",
					dataType: 'json',
					data: {page: page, search_flag : search_flag, search_text : search_text, search_type : search_type },
					success: function(res) {
						repopulateAnnouncement(res,"");
						//$("#page_num").val(page);
						$("#enable_prev").val(1);
					}
				});
			}
		});
		
		$("#div_prev").click( function() {
			var page = parseInt($("#page_num").val()) - 1;
			var prev = $("#enable_prev").val();
			var search_flag = $("#search_flag_announcement").val();
			var search_text = $("#search_text_hidden").val();
			var search_type = $("#search_type_hidden").val();
			//alert(page); alert(prev);
			if(prev == 1){
				jQuery.ajax({
					type: "POST",
					url: base_url + "index.php/manage_announcements/page",
					dataType: 'json',
					data: {page: page, search_flag : search_flag, search_text : search_text, search_type : search_type },
					success: function(res) {
						repopulateAnnouncement(res,"");
						//$("#page_num").val(page);
						$("#enable_next").val(1);
					}
				});
			}
		});
		
		$("#div_first").click( function() {
			var page = 1;
			var search_flag = $("#search_flag_announcement").val();
			var search_text = $("#search_text_hidden").val();
			var search_type = $("#search_type_hidden").val();
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/manage_announcements/page",
				dataType: 'json',
				data: {page: page, search_flag : search_flag, search_text : search_text, search_type : search_type },
				success: function(res) {
					repopulateAnnouncement(res,"");
					//$("#page_num").val(page);
					//$("#enable_next").val(1);
				}
			});
		});
		
		$("#div_last").click( function() {
			var search_flag = $("#search_flag_announcement").val();
			var search_text = $("#search_text_hidden").val();
			var search_type = $("#search_type_hidden").val();
			jQuery.ajax({
				type: "POST",
				url: base_url + "index.php/manage_announcements/page",
				dataType: 'json',
				data: {page: 0, search_flag : search_flag, search_text : search_text, search_type : search_type },
				success: function(res) {
					repopulateAnnouncement(res,"");
				}
			});
		});
		
		//end pagination
 
    });