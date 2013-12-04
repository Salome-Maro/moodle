/**
 *  Add todo list to database and show in block
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
		
var http = createRequestObject(); 

function add_todolist(){
	var url = "todolist.php";
	var s = document.getElementById("todo").value;
	document.getElementById("todo").innerHTML="Hello world";
	
	var params = "&s="+s;
	http.open("POST", url, true);	
	
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", params.length);
	http.setRequestHeader("Connection", "close");
	
	http.send(params);
	}