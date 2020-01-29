
function loggedIn(name){
	document.getElementById("content").innerHTML = "Welcome, ".concat(name);
}

window.addEventListener('load', function () {
	var authcode = getCookie("authcode");

	if (authcode != null) {
		loggedIn(authcode);
	}
})



function submitCreds(){
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;

	if(username == ""){
		document.getElementById("comment").innerHTML = "Please fill in a username";
		return;
	}
	if(password == ""){
		document.getElementById("comment").innerHTML = "Please fill in a password";
		return;
	}

	//var authcode = getAuthcode(username, password);

	var date = new Date();
	date.setDate(date.getDate() + 10);	

	document.cookie = "authcode=".concat(username).concat("; expires=").concat(date.toString());
	loggedIn(username);
}
