  function selRoad(value){
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
                    
                    $.post('gettingDatas.php', {postvalue: value}, 
                    function(data){
                        $('#roadSelect').html(data);
                    }
                  
                    
                    );
                    
                    
                }
            }