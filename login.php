<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>

<script type="text/javascript">
    function validateForm(formName)
    {
        var field = document.getElementById(formName).elements;
        for(var i = 0; i < field.length-1; i++)
        {
        	if (field[i].value == null || field[i].value == ''){
        		alert(field[i].name + " must be filled in. ");
        		return false;
        	}
        } 

    }
    
    function loadXMLDoc(){
    	var xmlhttp;
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
			}
	  }
xmlhttp.open("POST","demo_post2.asp",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("fname=Henry&lname=Ford");
}
</script>
</head>
<body>
	<h2>Dog Database</h2>
	<fieldset style="width:250px">
	<legend> Login </legend>
    <form method="post" action="errors.php" id="loginForm" name="loginForm" onsubmit=" return validateForm(this.id);">
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><b>
        <br />
        <input type="submit" value="Login" " /> 
    </form>
    </fieldset>
</body>
</html>
