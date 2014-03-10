$(document).ready(function(){
	$("#userId").change(changeUser);
	$("#userForm").find("input[name=submit]").click(postUser);
	$("#userForm").find("input[name=delete]").click(deleteUser);
});

function changeUser(){
	clearForm();
	if($(this).val() != ""){
		$.fancybox.showLoading();
		$.ajax({
			cache 		: false,
			data		: "userId=" + $(this).val(),
			type 		: 'GET',
			url 		: "/ajax/user",
			complete 	: $.fancybox.hideLoading,
			success		: function(resp){
				if(resp.status){
					loadUser(resp);
				} else {
					showError("An error occured: " + resp.message);
				}
			},
			error		: function(){
				showError("An unexpected error has occured");
				
			}
		});
	}
}

function postUser(){
	var theForm = $("#userForm");
	if(theForm.find("input[name=submit]").val() == 'Create User'){
		if(!validateInsert(theForm)){
			return false;
		}
		$.fancybox.showLoading();
		$.ajax({
			cache 		: false,
			data		: theForm.find("input[name!=userId]").serialize(),
			type 		: 'POST',
			url 		: "/ajax/user",
			complete 	: $.fancybox.hideLoading,
			success		: function(resp){
				if(resp.status){
					loadNewUser(resp);
				} else {
					showError("An error occured: " + resp.message);
				}
			}
		});
	} else {
		if(!validateUpdate(theForm)){
			return false;
		}
		$.fancybox.showLoading();
		$.ajax({
			cache 		: false,
			data		: theForm.serialize(),
			type 		: 'POST',
			url 		: "/ajax/user",
			complete 	: $.fancybox.hideLoading,
			success		: function(resp){
				if(resp.status){
					updateUser();
					$.fancybox("Update Successful!");
				} else {
					showError("An error occured: " + resp.message);
				}
			}
		});
	}
	
}

function deleteUser(){
	if($("#userId").val().length == 0){
		showError("Please select a user to delete");
		return false;
	}
	$.ajax({
		cache		: false,
		data		: "userId=" + $("#userId").val(),
		type		: "POST",
		url			: "/ajax/user/delete",
		complete 	: $.fancybox.hideLoading,
		success		: function(resp){
			if(resp.status){
				removeUser();
				$.fancybox("Update Successful!");
			} else {
				showError("An error occured: " + resp.message);
			}
		}
	});
}

function clearForm(){
	var theForm = $("#userForm");
	theForm.find("input[type=text],input[type=password]").val("");
	theForm.find("input[name=submit]").val("Create User");
}

function showError(msg){
	$.fancybox(msg);
}

function removeUser(){
	$("#userId option:selected").remove();
	$("#userId option:first").attr("selected",true);
}

function updateUser(){
	$("#userId option:selected").text($("#first").val()+ " " + $("#last").val());
}

function loadUser(resp){
	var theForm = $("#userForm");
	theForm.find("[name=username]").val(resp.rs[0].username);
	theForm.find("[name=email]").val(resp.rs[0].email);
	theForm.find("[name=first]").val(resp.rs[0].first);
	theForm.find("[name=last]").val(resp.rs[0].last);
	theForm.find("input[name=submit]").val("Update User");
}

function loadNewUser(resp){
	var theForm = $("#userForm");
	var title = theForm.find("[name=first]").val() + " " + theForm.find("[name=last]").val();
	 $("<option/>").val(resp.rs.insertId).text(title).appendTo("#userId");
}

function validateUpdate(theForm){
	if(theForm.find("[name=password1]").val().length < 7 && theForm.find("[name=password1]").val().length > 1){
		theForm.find("[name=password1]").focus();
		showError("Password must be at least 7 Characters");
		return false;
	}
	if(theForm.find("[name=password1]").val() != theForm.find("[name=password2]").val()){
		theForm.find("[name=password1]").focus();
		showError("Passwords must match");
		return false;
	}
	if(theForm.find("[name=email]").val().length && !validateEmail(theForm.find("[name=email]").val())){
		theForm.find("[name=email]").focus();
		showError("Email is not in a recognized format");
		return false;
	}
	return true;
}

function validateInsert(theForm){
	if(theForm.find("[name=username]").val().length < 7){
		theForm.find("[name=username]").focus();
		showError("Username must be at least 7 Characters");
		return false;
	}
	if(theForm.find("[name=password1]").val().length < 7){
		theForm.find("[name=password1]").focus();
		showError("Password must be at least 7 Characters");
		return false;
	}
	if(theForm.find("[name=password1]").val() != theForm.find("[name=password2]").val()){
		theForm.find("[name=password1]").focus();
		showError("Passwords must match");
		return false;
	}
	if(!validateEmail(theForm.find("[name=email]").val())){
		theForm.find("[name=email]").focus();
		showError("Email was not entered, or not in a recognized format");
		return false;
	}
	if(theForm.find("[name=first]").val().length < 1){
		theForm.find("[name=first]").focus();
		showError("First is required");
		return false;
	}
	if(theForm.find("[name=last]").val().length < 1){
		theForm.find("[name=last]").focus();
		showError("Last is required");
		return false;
	}
	return true;
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 