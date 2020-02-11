
function loggedIn(){
	$.post("/php/uname.php",
	{
		authcode: getCookie("authcode")
	},
	function(data,status){
		var dat = JSON.parse(data);
		document.getElementById("comment").innerHTML = "";
		document.getElementById("content").innerHTML = "Welcome, ".concat(dat.username);
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
		var dat = JSON.parse(data);
		if(dat.status != 0){
			document.getElementById("comment").innerHTML = dat.error;
		}else{
			document.cookie = "authcode=".concat(dat.authcode).concat("; expires=").concat(dat.expiry);
			loggedIn();
		}
	});
}

