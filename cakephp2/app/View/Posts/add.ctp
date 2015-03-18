<!-- File: /app/View/Posts/add.ctp -->
<h1>Add Post</h1>
<?php 
//<form id="PostAddForm" method="post" action="/posts/add">
//it assumes you are building a form that submits via POST to the current controller’s add() action
echo $this -> Form -> create('Post'); 
echo $this -> Form -> input('title');
echo $this -> Form -> input('body', array('rows' => 3));
echo $this -> Form -> end('Save Post');	//call generates a submit button and ends the form
?>