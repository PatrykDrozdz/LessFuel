  function showCarRoad(value){
                if(value==""){
                    document.getElementById("roadSelect").innerHTML="";
                    return;
                } else{
                    //document.getElementById("roadSelect").innerHTML="tekst"+value;
                    if(window.XMLHttpRequest){
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    
                    $.post('gettingDatas.php', {postvalue2: value}, 
                    function(data){
                        $('#right_info').html(data);
                    }
                    
                    );
                    
                    
                }
            }