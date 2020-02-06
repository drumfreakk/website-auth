
function loggedIn(){
	$.post("/php/uname.php",
	{
		authcode: getCookie("authcode")
	},
	function(data,status){
		document.getElementById("content").innerHTML = "Welcome, ".concat(data);
	});
}

window.addEventListener('load', function () {
	var authcode = getCookie("authcode");

	if (authcode != null) {
		loggedIn();
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
		username: username,
		password: password
	},
	function(data,status){
		document.cookie = "authcode=".concat(data.split("&")[0]).concat("; expires=").concat(data.split("&")[1]);
		loggedIn();
	});
}

