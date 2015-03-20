//functions.js


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
