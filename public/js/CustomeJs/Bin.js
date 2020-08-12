
$(document).ready( function () {
        $('#AddNewBinModal').on('shown.bs.modal', function (e) {
            $("#submitBinForm")[0].reset();
             $("#txtBinName").focus();
            
        });
        $("#submitBinForm").unbind('submit').bind('submit', function(){
            event.preventDefault();
            
            //remove error text 
            $(".text-danger").remove();
            //remove form error
            $(".form-group").removeClass("has-error").removeClass('has-success');
        
        
            var txtBinName = $("#txtBinName").val();
            var txtLocaton = $("#txtLocaton").val();
            var txtBinID = $("#txtBinID").val();
            

            
            if(txtBinName != "" && txtLocaton != ""  && txtBinID != "" )
            {
                var form = $(this);
                var formData = {
                     txtBinName :txtBinName,
                     txtLocaton : txtLocaton,
                     txtBinID : txtBinID,
                     _token : $('meta[name="csrf-token"]').attr('content') 
                };
                
            
  
                $.ajax({
                    url : form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
    
                        //button loading
                       // $('#addUserBtn').button('reset');
                        if(response['success'] == true){
                            //console.log(response['data']);
                            // reload the manage users table 
                         
                            // rest the form text 
                            $("#submitBinForm")[0].reset();
                            // remove the error text
                            $(".text-danger").remove();
                            // remove the form error
                            $(".form-group").removeClass('has-error').removeClass("has-success");
    
                            $("#CreateCleanerMessages").html('<div class="alert alert-success">'+
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                            '<strong><i class="glyphicon glyphicon-ok-sign"></i> '+ response['msg'] + '</strong></div>');
    
                            $(".alert-success").delay(500).show(10, function() {
                                $(this).delay(3000).hide(10, function() {
                                    $(this).remove();
                                });
                            });// /.alert 
                            }// / if response   
                    }
                });// /ajax
            }//if
            return false;
        });// / add cleaneer function
}); // / function ready 

  $("#AssignBinForm").unbind('submit').bind('submit', function(){
            event.preventDefault();
            
            var isExiset1 = false;

            
            //remove error text 
            $(".text-danger").remove();
            //remove form error
            $(".form-group").removeClass("has-error").removeClass('has-success');
        
        
            var cbxBins = $("#cbxBins").val();
            var Personid = $("#Personid").val();

            if(cbxBins != "" && Personid != ""  )
            {
                
                 
                            var form = $(this);
                var formData = {
                     cbxBins :cbxBins,
                     Personid : Personid,
                     _token : $('meta[name="csrf-token"]').attr('content') 
                };
                
            
            
  
                $.ajax({
                    url : form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if(response['success'] == true){
                            
                            if(response['msg'] == 'this bin is alrady assigned'){
                                alert('this bin is alrady assigned');
                                return;
                            }
                            $("#submitBinForm")[0].reset();
                            // remove the error text
                            $(".text-danger").remove();
                            // remove the form error
                            $(".form-group").removeClass('has-error').removeClass("has-success");
                            ManageAssignedBins.ajax.reload(null,false);
                           
                            }// / if response   
                    }
                });
                    
                // /ajax
                
            }//if
            return false;
        });// / add cleaneer function

 
function AssignBin(Personid = null){

  if(Personid){

    $("#Personid").remove();
    $('.AssignBinsFooter').after('<input type="hidden" name="Personid" id="Personid" value="'+ Personid +'"  />');
    //console.log(SupplierID);
    fillBinsCombo();
    openAssign();
}
}

function fillBinsCombo(){

   
    var formData = {
            _token : $('meta[name="csrf-token"]').attr('content') 
    };
    $.ajax({
        url : '/GetAllBins',
        type: 'post',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if(response['success'] == true){
               // $("#EBankName").val(response['Bank']['Name']);
                
                $("#cbxBins").empty()
               for(var i = 0; i < response['Bins'].length ; i++){
                var opt = document.createElement("option");
                opt.value= response['Bins'][i]['id'];
                opt.innerHTML = String(response['Bins'][i]['BinName']); // whatever property it has
                // then append it to the select element
                $("#cbxBins").append(opt);
               }
                
                }// / if response   
        }
    });// /ajax

}

function ViewBins(Personid = null){

  if(Personid){

    $("#Personid").remove();
    $('.ViewFooter').after('<input type="hidden" name="Personid" id="Personid" value="'+ Personid +'"  />');
    //console.log(SupplierID);

    openView();
  }
}

function DeleteAssinedBins(Personid=null){
if(Personid){
    var Conf = confirm("Are sure you want to delete this Bin ?");
if (Conf == true) {
  var formData = {
    Personid : Personid,
    _token : $('meta[name="csrf-token"]').attr('content') 
}
$.ajax({
    url: '/DeleteAssinedBins',
    type:'post',
    data: formData,
    dataType: 'json',
    success:function(response){
        if(response['success'] == true){
            ManageAssignedBins.ajax.reload(null,false);
         

        }// /if(response)
    }// /response function success  
});// /.ajax
}
}// /if
}// / delete AssignedBin function 
  



/*


*/
