        $(document).ready(function(){








        });


        function get_data(type,file)
        {
             	if(type == "content")
                {
                      	$("#content").html('<div style="text-align:center"><img  align="middle" src="theme/default/img/ajax-loader2.gif" alt="Loading"/></div>');
						$.get(file, {},function(data){
                                 	$("#content").html(data);
                                        tb_init('a.thickbox, area.thickbox, input.thickbox');
	                  });
				}



        }
	

