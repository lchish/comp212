function setup(){
    var theForm = document.getElementById("createaccountform");
    theForm.onsubmit = validate;
}

function validate(){
    var result = true;
    var fieldArray = ["username","oldpassword","firstname","lastname","email",
	"address","city","phone"];
    for(var x = 0; x < fieldArray.length;x++){
	if(validateEach(fieldArray[x]) ==false){
	    result = false;
	}
    }
    if(validateRadio("male","female") == false){
	result = false;
    }
    return result;
}
function validateRadio(radio1,radio2){
    var field1 = document.getElementById(radio1);
    var field2 = document.getElementById(radio2);
    var err = document.getElementById("sexerr");
    err.innerHTML = "";
    if(field1.checked || field2.checked){
	return true;
    }
    else{
	err.innerHTML = "please enter male or female";
	field1.focus();
	return false;
    }
}    

function validateEach(item){
    var field = document.getElementById(item);
    var err = document.getElementById(item+"err");
    err.innerHTML = "";
    if(field.value == null || field.value == ""){

	if(item == "phone"){
	    err.innerHTML = "please enter a " + item + " number";
	}else{
	      err.innerHTML = "please enter a " + item;
	}
	field.focus();
	return false;
    }else{
	return true;
    }
}
if(document.getElementById){
    window.onload = setup;
}
