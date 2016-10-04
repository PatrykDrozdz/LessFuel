var number = Math.floor(Math.random()*5)+1;


function hide_slide(){
    $("#photos").hide(4500);
}

function change_slide(){
    
    number++;
    if(number>5){
        number=1;
    }
    
    var file = "<img src=\"slajdy/slajd"+number+".jpg\" />";
            
    document.getElementById("photos").innerHTML = file;
    
     $("#photos").show(4500);
     setTimeout("change_slide()", 11000);
     setTimeout("hide_slide()", 6500);
}

