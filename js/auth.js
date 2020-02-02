
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

	$.post("/php/auth.php",
	{
		uname: username,
		pswd: password
	},
	function(data,status){
		alert("Data: " + data + "\nStatus: " + status);
		document.cookie = "authcode=".concat(data.split("&")[1]).concat("; expires=").concat(data.split("&")[0]);
		loggedIn(data);
	});
}


function unam(){
	$.post("/php/uname.php",
	{
	},
	function(data,status){
		alert("Data: " + data + "\nStatus: " + status);
	});
}

