function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    // because unescape has been deprecated, replaced with decodeURI
    //return unescape(dc.substring(begin + prefix.length, end));
    return decodeURI(dc.substring(begin + prefix.length, end));
}

function loggedIn(){
	alert("Logged in as ".concat(getCookie("username")));
}




var authCode = getCookie("authCode");

if (authCode == null) {
	document.cookie = "username=John Doe; expires=Fri, 18 Dec 2020 12:00:00 GMT+0100";
} else {
	loggedIn();
}


