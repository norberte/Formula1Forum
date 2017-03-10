function checkForm(){
	var formm = document.getElementById("loginForm");
	formm.onsubmit = function(e){
		e.preventDefault();
		validate(e);
	}
	formm.onchange = function(e){
		e.target.className = "formControl";
	}
}
	
window.onload = checkForm;

function validate(event){
	var flag = true;	// assume everything is valid until proven otherwise
	var form1 = document.getElementById("loginForm");
	
	var userName = document.getElementById("username");
	var passWord = document.getElementById("password");
	
	if(userName.value == "" || userName.value == null){	// check if userName is empty string
		flag = false;
		event.preventDefault();
		userName.className="highlight";
	}
	
	if(passWord.value == "" || passWord.value == null){ // check if passWord is empty string
		flag = false;
		event.preventDefault();
		passWord.className="highlight";
	}
	
	if(flag == true){	// if form is valid
		form1.submit();
	}
}

