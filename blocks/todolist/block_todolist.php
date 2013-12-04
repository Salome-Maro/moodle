<?php
class block_todolist extends block_base {
    public function init() {
        $this->title = get_string('todolist', 'block_todolist');
    }
    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section.
    
    public function get_content() {
    	if ($this->content !== null) {
    		return $this->content;
    	}
    
    	$this->content         =  new stdClass;
    	$this->content->text   = '
    
<html>
    	<head>
        <script SRC="todolist.js"></script>
        </head>
        <body>
    	<p id="demo1"> What is next? </p>
    	<p id="demo">  </p>
        <form id="todolist" action="../admin/index.php" method="post">
        <input type = "text" name="todolist" id="todo">
        <input type = "button" onclick = "add_todolist()" value = "PIN">
        
    	<script>
    			function add_todolist(){
				var url = "todolist.php";
    			var todotext = document.getElementById("todo").value;
    			document.getElementById("demo").innerHTML = todotext;
    			document.getElementById("todo").value = "";
				http.open("POST", url, true);	
				}
    	</script>
        </form>
        </body>
        </html> 
        
    '; 
	return $this->content;
    }   // Here's the closing bracket for the class definition
}

?>