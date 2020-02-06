
function uname(){
	$.post("/php/uname.php",
	{
		authcode: getCookie("authcode")
	},
	function(data,status){
		document.getElementById("comment").innerHTML = data;
	});
}
