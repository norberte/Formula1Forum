function checkForm(){
	var formm = document.getElementById("signUpForm");
	formm.onsubmit = function(e){
		e.preventDefault();
		console.log("Hello2");
		validateForm(e);
	}
	formm.onchange = function(e){
		if(e.target.type == "checkbox"){
			e.target.className = "checkBox";
		} else {
			e.target.className = "formControl";
		}
	}
}

window.onload = checkForm;

function validateForm(event){
	console.log("Hello1");
	var flag = true;	// assume everything is valid until proven otherwise
	var form1 = document.getElementById("signUpForm");
	
	var email = document.getElementById("email");
	var passWord = document.getElementById("password");
	var passWordRepeat = document.getElementById("password-repeat");
	var checkBox = document.getElementById("license");
	
	if(email.value == "" || email.value == null){ // check if email is empty string
		flag = false;
		event.preventDefault();
		email.className = "highlight";
	}
	
	if(passWord.value == "" || passWord.value == null){	// check if passWord is empty string
		flag = false;
		event.preventDefault();
		passWord.className = "highlight";
	}
	if(passWordRepeat.value == "" || passWordRepeat == null){	// check if passWord is empty string
		flag = false;
		event.preventDefault();
		passWordRepeat.className = "highlight";
	}
	
	if(passWord.value != passWordRepeat.value){		// check both passWords and highlight both, if they do not match
		flag = false;
		event.preventDefault();
		passWord.className = "highlight";
		passWordRepeat.className = "highlight";
	}
	
	if(!checBox.checked){
        flag = false;
		event.preventDefault();
        checBox.parentNode.style["background-color"] = "red";
    } else {
        checBox.parentNode.style["background-color"] = "white";
    }
	
	if(flag == true){	// if form is valid
		form1.submit();
	}
}