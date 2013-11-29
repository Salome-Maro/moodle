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
        <form id="todolist" action="../admin/index.php" method="post">
        <input type = "text" name="todolist" id="todolist">
        <input type = "button" onclick = "add_todolist()" value = "PIN">
        
        </form>
        </body>
        </html> 
        
    '; 
	return $this->content;
    }   // Here's the closing bracket for the class definition
}

?>