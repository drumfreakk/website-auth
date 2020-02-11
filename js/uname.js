
function uname(){
	$.post("/php/uname.php",
	{
		authcode: getCookie("authcode")
	},
	function(data,status){
		var dat = JSON.parse(data);
		document.getElementById("comment").innerHTML = data.username;
	});
}
