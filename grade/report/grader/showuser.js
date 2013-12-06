/*********************************
 * On going development
 * 
 */

function createRequestObject(){
		var request_o;
		var browser = navigator.appName;
		if(browser == "Microsoft Internet Explorer"){
		request_o = new ActiveXObject("Microsoft.XMLHTTP");
		}else{
		request_o = new XMLHttpRequest();
		}
		return request_o;
		}

function showUser()
		{
			var url = "showuser.php";
			var s = document.getElementById('qsearch').value;
			var params = "&s="+s;
			http.open("POST", url, true);
			
			document.getElementById("demo").innerHTML="Query result";
			document.getElementById('searchResults').innerHTML = http.responseText;
		}