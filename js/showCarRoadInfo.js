  function showCarRoad(value){
                if(value==""){
                    document.getElementById("roadSelect").innerHTML="";
                    return;
                } else{
                    
                    if(window.XMLHttpRequest){
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    
                    $.post('gettingDatas.php', {postvalue2: value}, 
                    function(data){
                        $('#right_info_final').html(data);
                    }
                    
                    );
                    
                    
                }
            }