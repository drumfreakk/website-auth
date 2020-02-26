
function loggedIn(authcode){
	$.post("/php/uname.php",
	{
		authcode: authcode
	},
	function(data,status){
		var dat = JSON.parse(data);
		if(dat.status != 0){
			document.getElementById("comment").innerHTML = dat.error;
			if(dat.status == 1){
				//remove cookie
				document.cookie = "authcode=; expires=Thu, 01 Jan 1970 00:00:01 GMT";
			}
		} else {
			document.getElementById("comment").innerHTML = "";
			document.getElementById("content").innerHTML = "Welcome, ".concat(dat.response);
		}
	});
}

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
			var date = new Date(dat.expiry * 1000);
			document.cookie = "authcode=".concat(dat.authcode).concat("; expires=").concat(date);
			loggedIn(dat.authcode);
		}
	});
}

