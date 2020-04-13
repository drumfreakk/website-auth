
function uname(){
	$.post("/php/uname.php",
	{
		authcode: getCookie("authcode")
	},
	function(data,status){
		var dat = JSON.parse(data);
		if(dat.status == 2){
			document.getElementById("comment").innerHTML = dat.error;
		} else {
			document.getElementById("comment").innerHTML = dat.username;
		}
	});
}
