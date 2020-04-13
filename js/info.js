
function uname(){
	$.post("/php/info.php",
	{
		authcode: getCookie("authcode")
	},
	function(data,status){
		alert("Data: " + data + "\nStatus: " + status);
		document.getElementById("comment").innerHTML = data;
	});
}
