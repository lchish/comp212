function setup(){
    var theForm = document.getElementById("createauctionform");
    theForm.onsubmit = validate;
}
    /*note:
* there is no point in client side verification of dropdowns
* as a default is always going to be selected
*/
function validate(){
    var result = true;
    var fieldArray = ["title","reserve"];
        for(var x = 0; x < fieldArray.length;x++){
	if(validateEach(fieldArray[x]) ==false){
	    result = false;
	}
    }
    return result;
}

function validateEach(item){
    var field = document.getElementById(item);
    var err = document.getElementById(item+"err");
    err.innerHTML = " ";
    if(field.value == ""){
	err.innerHTML = "please enter a " + item;
	field.focus();
	return false;
    }else{
	return true;
    }
}
if(document.getElementById){
    window.onload = setup;
}
