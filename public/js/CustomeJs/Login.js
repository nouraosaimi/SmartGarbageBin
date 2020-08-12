$(document).ready( function () {

        $("#LoginForm").unbind('submit').bind('submit', function(){
            event.preventDefault();
       
            var txtUserName = $("#txtUserName").val();
            var txtPassword = $("#txtPassword").val();

            
            
            
            if(txtUserName != "" && txtPassword != ""   )
            {
                var form = $(this);
                var formData = {
                     txtUserName :txtUserName,
                     txtPassword : txtPassword,
                     _token : $('meta[name="csrf-token"]').attr('content') 
                };
                
            
                console.error(txtPassword);
                $.ajax({
                    url : '/checkUser',
                    type: 'post',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
    
                        
                        if(response['success'] == true){
                           if(response['msg']== '/Cleaners'){
                            window.location.replace('/Cleaners');
                           }else if(response['msg']== '/Dashboard')
                           {
                            window.location.replace(response['msg']);
                           }else{
                            $("#LoginMessages").html('<div class="alert alert-danger">'+
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                            '<strong><i class="glyphicon glyphicon-ok-sign"></i> '+ response['msg'] + '</strong></div>');
    
                            $(".alert-success").delay(500).show(10, function() {
                                $(this).delay(3000).hide(10, function() {
                                    $(this).remove();
                                });
                            });// /.alert 
                           }

                           
                            }// / if response   
                    }
                });// /ajax
            }//if
            return false;
        });// / add cleaneer function
}); // / function ready 