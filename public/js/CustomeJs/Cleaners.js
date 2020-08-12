
$(document).ready( function () {
        $('#AddNewCleanerModal').on('shown.bs.modal', function (e) {
            $("#submitCleanerForm")[0].reset();
             $("#txtFullName").focus();
            
        });
        $("#submitCleanerForm").unbind('submit').bind('submit', function(){
            event.preventDefault();
            
             
            $(".text-danger").remove();
            
            $(".form-group").removeClass("has-error").removeClass('has-success');
        
        
            var txtFullName = $("#txtFullName").val();
            var txtUserName = $("#txtUserName").val();
            var txtPassword = $("#txtPassword").val();
            

            
            if(txtFullName != "" && txtUserName != ""  && txtPassword != "" )
            {
                var form = $(this);
                var formData = {
                     txtFullName :txtFullName,
                     txtUserName : txtUserName,
                     txtPassword : txtPassword,
                     _token : $('meta[name="csrf-token"]').attr('content') 
                };
                
            
  
                $.ajax({
                    url : form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
    
                        
                        if(response['success'] == true){
                           
                            CleanesTable.ajax.reload(null,false);
                         
                            $("#submitCleanerForm")[0].reset();
                         
                            $(".text-danger").remove();
                            
                            $(".form-group").removeClass('has-error').removeClass("has-success");
    
                            $("#CreateCleanerMessages").html('<div class="alert alert-success">'+
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                            '<strong><i class="glyphicon glyphicon-ok-sign"></i> '+ response['msg'] + '</strong></div>');
    
                            $(".alert-success").delay(500).show(10, function() {
                                $(this).delay(3000).hide(10, function() {
                                    $(this).remove();
                                });
                            });
                            }  
                    }
                });
            }
            return false;
        });
});  


function updateCleaner(CleanerID = null){
if(CleanerID){

$("#CleanerID").remove();

$("#submitEditCleanerForm")[0].reset();

$('.text-danger').remove();

$('.form-group').removeClass('has-error').removeClass('has-success');

$('.updateCleanerfooter').after('<input type="hidden" name="CleanerID" id="CleanerID" value="'+ CleanerID +'"  />');

var formData = {
CleanerID : CleanerID,
_token : $('meta[name="csrf-token"]').attr('content') 
}
$.ajax({
    url: '/GetCleaner',
    type: 'post',
    data: formData,
    dataType: 'json',
    success: function(response){
            $("#EtxtFullName").val(response['Cleaner']['FullName']);
             $("#EtxtUserName").val(response['Cleaner']['UserName']);
             $("#EtxtPassword").val(response['Cleaner']['Passwrod']);
            
            $("#submitEditCleanerForm").unbind('submit').bind('submit', function(){
              
                $(".text-danger").remove();
               
                $(".form-group").removeClass("has-error").removeClass('has-success');


                var EtxtFullName = $("#EtxtFullName").val();
                var EtxtUserName = $("#EtxtUserName").val();
                var EtxtPassword = $("#EtxtPassword").val();

                
         
             if(EtxtFullName != "" && EtxtUserName != ""  && EtxtPassword != "" )
                {
                    
                    var form = $(this);
                    var formData = {
                        CleanerID: $("#CleanerID").val(),
                        txtFullName :EtxtFullName,
                        txtUserName : EtxtUserName,
                        txtPassword : EtxtPassword,
                         _token : $('meta[name="csrf-token"]').attr('content') 
                    }

                       
                        $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                
                                if(response['success'] == true){
                                   
                                    CleanesTable.ajax.reload(null,false);
                                   
                                    $(".text-danger").remove();
                                   
                                    $(".form-group").removeClass('has-error').removeClass("has-success");
                                    

                                    $("#CreateCleanerMessages").html('<div class="alert alert-success">'+
                                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                          '<strong><i class="glyphicon glyphicon-ok-sign"></i>  '+ response['msg'] +
                                          '</strong> </div>');

                                    
                                    $(".alert-success").delay(500).show(10, function() {
                                        $(this).delay(3000).hide(10, function() {
                                            $(this).remove();
                                        });
                                    });
                                    
                                 
                                   

                                    }
                            }
                        });
                        
                    }
                    return false;
                
                
            });
    
           
            
            

    }
});

}
}
// / update  cleaner function 
function DeleteCleaner(CleanerID=null){
if(CleanerID){
$("#DeleteCleanerBtn").unbind('click').bind('click', function(){

var formData = {
    CleanerID : CleanerID,
    _token : $('meta[name="csrf-token"]').attr('content') 
}
$.ajax({
    url: '/deleteCleaner',
    type:'post',
    data: formData,
    dataType: 'json',
    success:function(response){
        if(response['success'] == true){
         

            
            $('#deleteCleanerModel').hide();
            $( ".deleteCleanerCancelBtn" ).on( "click", function() {
                $('#deleteCleanerModel').modal('toggle');
              });
              $( ".deleteCleanerCancelBtn" ).trigger( "click" );

          
            CleanesTable.ajax.reload(null,false);
            $(".reomve-messages").html('<div class="alert alert-success">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong><i class="glyphicon glyphicon-ok-sign"></i>  '+  response['msg']  +' </strong> </div>');
           

        $(".alert-success").delay(500).show(10, function() {
            $(this).delay(3000).hide(10, function() {
                $(this).remove();
            });
        }); 

        }
    } 
});
});
}
}