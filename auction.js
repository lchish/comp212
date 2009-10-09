var currentImageNumber = 0;
var imageDir = "/~leslie/assign2/auctionimages/";
function setup()
{
    var leftButton = document.getElementById("leftarrow");
    var rightButton = document.getElementById("rightarrow");
    leftButton.onclick = function(){
	startRequest(--currentImageNumber);
    }
    rightButton.onclick = function(){
	startRequest(++currentImageNumber);
    }
}
function startRequest(imageNumber){
    var auctionNumber = document.getElementById("auctionnumber").value;
    $.ajax({
	type: "GET",
	url: "getimage.php",
	dataType : "text",
	data: "img=" + imageNumber + "&auction=" + auctionNumber,
	success: function(imageLocation){
	    if(imageLocation.substring(0,3) == "low"){
		currentImageNumber = imageLocation.substring(3) -1;
		imageLocation = 
		    imageDir+auctionNumber+"_"+currentImageNumber+".jpg";
	    }else if(imageLocation == "high"){
		currentImageNumber = 0;
		imageLocation = imageDir+auctionNumber+"_0.jpg";
	    }
	    resizeImage(imageLocation);
	    $("#image").attr('src',imageLocation);
	}
    });
}
function resizeImage(imageName){
    var img = new Image();
    img.src = imageName;
    img.onload = function(){
	var myImage = document.getElementById("image");
	var width = img.width;
	var height = img.height;
	var target = 250;
	var percentage;
	if(width > height){
	    percentage = (target / width);
	}else{
	    percentage = (target / height);
	}
	myImage.width = Math.round(width * percentage);
	myImage.height = Math.round(height * percentage);
    }
}

if (document.getElementById)
{
    window.onload = setup;
}