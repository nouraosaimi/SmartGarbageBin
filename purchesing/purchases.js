function hideForm(inlineRadioOptions) {
    if (inlineRadioOptions == "1") {
        document.getElementById("CashDetail").style.display = 'block';
        document.getElementById("bankDetail").style.display = 'none';
        document.getElementById("OmDetail").style.display = 'none';
        $("#FAmount").val(0);
        clucremining();
    }else if(inlineRadioOptions == "3"){
        document.getElementById("bankDetail").style.display = 'block';
        document.getElementById("CashDetail").style.display = 'none';
        document.getElementById("OmDetail").style.display = 'none';
        $("#Bamount").val(0);
        clucremining();

    }else if(inlineRadioOptions == "2"){
        document.getElementById("OmDetail").style.display = 'block';
        document.getElementById("CashDetail").style.display = 'none';
        document.getElementById("bankDetail").style.display = 'none';
        clucremining();
    }
}
window.onload = function() {
    document.billInfoForm.inlineRadioOptions[0].checked = true;
    document.getElementById("CashDetail").style.display = 'block';
    document.getElementById("bankDetail").style.display = 'none';
    document.getElementById("OmDetail").style.display = 'none';
    document.getElementById("billInfo").style.display = 'none';
    document.getElementById("fainacialInfo").style.display = 'none';
   // document.getElementById("openDisModal").style.display = 'none';
    $("#openDisModal").hide();
    $("#HasExDate").hide();
    $("#submitbill").hide();
    $("#Inventeory-group").hide();
    
    
    
    
  }
      

var PbarcodesArray ;
var productsInfoArray; 

function restbill()
{
    PbarcodesArray.length = 0;
    productsInfoArray.length = 0;
     //console.log(response['Exchange']);
     $('#BillNumber').val("00000");
     document.billInfoForm.inlineRadioOptions[0].checked = true;
    document.getElementById("CashDetail").style.display = 'block';
    document.getElementById("bankDetail").style.display = 'none';
    document.getElementById("OmDetail").style.display = 'none';
    document.getElementById("billInfo").style.display = 'none';
    document.getElementById("fainacialInfo").style.display = 'none';
    $("#BillTB tbody").empty();
     $('#BillTB tbody').html($("<tr></tr>")); 
     $("#productSearchform")[0].reset();
     $("#productInfoForm")[0].reset();
     $("#discountForm")[0].reset();
     $("#billform")[0].reset();
     $("#submitBillForm")[0].reset();
    //$("#billform").rest
     $("#openDisModal").hide();
     $("#newBill").show();
     $("#BillTotalPrice").text("0");
     $("#BillTotalProducts").text("0");
     $("#totalAfterDiscount").text("0");
     $("#newBill").focus();
     $('#openBillinfo').modal('hide');
     $("#submitbill").hide();
     $("#Inventeory-group").hide();

       // $('body').removeClass('modal-open');
       // $('.modal-backdrop').remove();
     
    //$('#openBillinfo').modal('toggle');
    //$('#openBillinfo').hide();
    //$("#openBillinfo").data('bs.modal', null);
     

}
function  createNewBill(){

    $.ajax({
        url: '/getBillAutoNumber',
        type:'get',
        dataType: 'json',
        success:function(response){
            if(response['success'] == true){
                  //console.log(response['Exchange']);
                  $('#BillNumber').val(response['newID']);
                  document.getElementById("billInfo").style.display = 'block';
                  document.getElementById("fainacialInfo").style.display = 'block';
                  //document.getElementById("openDisModal").style.display = 'block';
                  $("#openDisModal").show();
                  $("#newBill").hide();
                  $("#submitbill").show();
                  PbarcodesArray = ["new"];
                  productsInfoArray = ["0"];
                  $("#Inventeory-group").show();
            }// /if(response)
            else{
                alert('المورد لايملك اي مندوب ');
            }
        }// /response function success  
    });// /.ajax
   
}
$( "#SearchByNameBtn" ).click(function() {
   GetProductsTb();
  });

  $('#OpenSearchByName').on('shown.bs.modal', function (e) {
    manageProductsListTable.responsive.recalc();
    $("#ProductsListTB_paginate").removeClass('dataTables_paginate paging_simple_numbers');
    $("#Pbarcod").addClass('ui right floated pagination menu');
    });

function getProductsUnits(productBarcode){

    $("#Pbarcod").val(productBarcode);
    $('#OpenSearchByName').hide();
        $( ".OpenSearchByNameCloseBtn" ).on( "click", function() {
            $('#OpenSearchByName').modal('toggle');
          });
        $( ".OpenSearchByNameCloseBtn" ).trigger( "click" );
    var newProduct = false;
        if(PbarcodesArray[0] == "one")
        {
            
            for(var i=0; i<=PbarcodesArray.length; i++) 
                {
                    if(PbarcodesArray[i] == $("#Pbarcod").val())
                    {newProduct = false ;  break;}
                    else{newProduct = true ;}
                }
                //if(newProduct){PbarcodesArray.push($("#Pbarcod").val().toString());}

        }else{
           // PbarcodesArray[0]= $("#Pbarcod").val();
            newProduct = true;
        }

       
         if(newProduct)
         {

            if($("#Pbarcod").val()){
                var formData = {
                    BarCode : $("#Pbarcod").val(),
                    _token : $('meta[name="csrf-token"]').attr('content') 
                }
                
                $.ajax({
                    url: '/checkParcod',
                    type:'post',
                    data: formData,
                    dataType: 'json',
                    success:function(response){
                        if(response['success'] == true){
                            //$("#Pbarcod").find('.text-danger').remove();
                            $("#Pbarcod").closest('.form-group').removeClass('has-error');
                            UpdatePUnitTable();
                            $("#BarcodBtn").click();
                            

                        }// /if(response)
                        else{
                            //$("#Pbarcod").after('<p class="text-danger"> لايوجد صنف بهذا الباركود </p>');
                            if(response['Notfound'] == 2){
                                alert("هذا  الصنف ملغي من قبل ادارة المخازن ");
                                $("#Pbarcod").closest('.form-group').addClass('has-error');
                                return false;
                            }else{
                                alert("لايوجد صنف بهذا الباركود");
                                $("#Pbarcod").closest('.form-group').addClass('has-error');
                                return false;
                            }
                        }
                    }// /response function success  
                });// /.ajax
            }//if validtion pass
         }//if new product
         else
         {
            alert("لايمكن تكرار نفس الصنف في الفاتورة ! يمكنك تعديل الكمية او السعر من خلال جدول معلومات الفاتورة ويمكنك حذف الصنف اذا اردت اضافته مره اخرى");
         }
}

$(document).ready( function () {
   
   
    
    document.querySelector('#Pbarcod').addEventListener('keypress', function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) { // 13 is enter
         // alert($("#Pbarcod").val());
         ///document.getElementById("OpenSupplieriesModel").showModal();
        // $('#OpenSupplieriesModel').modal('show');
         //showModel();

        //  var arr = [];
        //     for(var i=1; i<=mynumber; i++) {
        //     arr.push(i.toString());
        //     }
        //fruits.length
        
        var newProduct = false;
        if(PbarcodesArray[0] == "one")
        {
            
            for(var i=0; i<=PbarcodesArray.length; i++) 
                {
                    if(PbarcodesArray[i] == $("#Pbarcod").val())
                    {newProduct = false ;  break;}
                    else{newProduct = true ;}
                }
                //if(newProduct){PbarcodesArray.push($("#Pbarcod").val().toString());}

        }else{
           // PbarcodesArray[0]= $("#Pbarcod").val();
            newProduct = true;
        }

       
         if(newProduct)
         {

            if($("#Pbarcod").val()){
                var formData = {
                    BarCode : $("#Pbarcod").val(),
                    _token : $('meta[name="csrf-token"]').attr('content') 
                }
                
                $.ajax({
                    url: '/checkParcod',
                    type:'post',
                    data: formData,
                    dataType: 'json',
                    success:function(response){
                        if(response['success'] == true){
                            //$("#Pbarcod").find('.text-danger').remove();
                            $("#Pbarcod").closest('.form-group').removeClass('has-error');
                            UpdatePUnitTable();
                            $("#BarcodBtn").click();
                            

                        }// /if(response)
                        else{
                            //$("#Pbarcod").after('<p class="text-danger"> لايوجد صنف بهذا الباركود </p>');
                            if(response['Notfound'] == 2){
                                alert("هذا  الصنف ملغي من قبل ادارة المخازن ");
                                $("#Pbarcod").closest('.form-group').addClass('has-error');
                                return false;
                            }else{
                                alert("لايوجد صنف بهذا الباركود");
                                $("#Pbarcod").closest('.form-group').addClass('has-error');
                                return false;
                            }
                        }
                    }// /response function success  
                });// /.ajax
            }//if validtion pass
         }//if new product
         else
         {
            alert("لايمكن تكرار نفس الصنف في الفاتورة ! يمكنك تعديل الكمية او السعر من خلال جدول معلومات الفاتورة ويمكنك حذف الصنف اذا اردت اضافته مره اخرى");
         }
        
         
         //$('#OpenSupplieriesModel').modal('toggle');
        
        }
    });

    $(".HasExDate").focusout(function(){
        $("#price").focus();
        $("#price").select();

      });

});

function clucDiscount(){

  
        var total = Number($("#BillTotalPrice").text());
        var preDiscount = Number($("#PerDiscount").val());
        var totalValue = total * ( (100-preDiscount) / 100 ); // the total after discount 
        var totalValue2 = (total * preDiscount)/100 ;  // the discount amount 
        $("#AmountDiscount").val(totalValue2.toFixed(2)) ;
        $("#totalAfterDiscount").text(0);
        $('#totalAfterDiscount').text(totalValue);
        $('#StotalAfterDiscount').val(totalValue); 
        
    
    
}

function culcDiscountFromAmount(){

        var total = Number($("#BillTotalPrice").text());
        var amount = Number($("#AmountDiscount").val());
        var per = Math.floor((amount / total) * 100) ; //the discount persentage
        var totalValue = total - amount;
        $("#PerDiscount").val(per) ;
        $("#totalAfterDiscount").text(0);
        $('#totalAfterDiscount').text(totalValue);
        $('#StotalAfterDiscount').val(totalValue); 
        
  
}

function culcTotalPrice(){
    //alert(document.getElementById("Quantity").value);
    //document.getElementById("Quantity").value
    
    var pattern = /^[0-9]/;
    if(pattern.test($("#Quantity").val()) && pattern.test($("#price").val()) ){
        if($("#price").val() == 0){$("#price").val(1);}
        if($("#Quantity").val() == 0){$("#Quantity").val(1);}
        $("#Totalprice").val($("#Quantity").val() * $("#price").val());
    }
    else{
        $("#Totalprice").val(0);
    }

}




$(document).ready(function() {
    
    document.querySelector('#Quantity').addEventListener('keypress', function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) { // 13 is enter
            // var group_data = '<tr>' + 
            // '<td>'+$("#PName").val()+'</td>'+
            // '<td>'+$("#PUnit").val()+'</td>'+
            // '<td>'+$("#price").val()+'</td>'+
            // '<td>'+$("#Quantity").val()+'</td>'+
            // '<td>'+$("#Totalprice").val()+'</td>'+
            // '<td>' + '<a  title="تعديل" href="/editGropus/' + $("#productID").val()+'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> </a> '+
            // '</tr>';
            var table = document.getElementById("BillTB");
            var row = table.insertRow(1);// the frist row start at 3
           // row.append(group_data);
            var cell0 = row.insertCell(0);
            var cell1 = row.insertCell(1);
            var cell2 = row.insertCell(2);
            var cell3 = row.insertCell(3);
            var cell4 = row.insertCell(4);
            var cell5 = row.insertCell(5);
            var cell6 = row.insertCell(6);
            var rowCount = $('#BillTB tr').length;
           // alert(rowCount);
           var exdate ="لايوجد";
           if($(".HasExDate").is(":visible")){
            exdate = $(".HasExDate").val();
            }
            else
            {
                exdate ="لايوجد";
            }
            
            cell0.innerHTML = $("#PName").val();
            cell1.innerHTML = $("#PUnit").val();
            cell2.innerHTML = '<p class="label label-default" title="انقر هنا لتعديل السعر" onclick="editePrice(\''+rowCount+'_2\',\''+rowCount+'\',\'_2\')" id="'+rowCount+'_2">'+$("#price").val()+'</p>';//
            cell3.innerHTML = '<p class="label label-warning" title="انقر هنا لتعديل الكمية" onclick="editePrice(\''+rowCount+'_3\',\''+rowCount+'\',\'_3\')" id="'+rowCount+'_3">'+$("#Quantity").val()+'</p>';
            cell4.innerHTML = '<p class="label label-success" id="'+rowCount+'_4">'+$("#Totalprice").val()+'</p>';
            cell6.innerHTML = '<button type="button" onclick="DeleteRow(this,\''+rowCount+'\',\'#Code'+rowCount+'\')" class="btn btn-xs btn-danger"><i class="fas fa-times"></i> </button><p style="display:none;" id="Code'+rowCount+'">'+$("#Pbarcod").val()+'</p>';
            cell5.innerHTML = '<p class="label label-danger" onclick="editePrice(\''+rowCount+'_5\',\''+rowCount+'\',\'_5\')" id="'+rowCount+'_5">'+exdate+'</p>';

            var BillTotal = parseInt($("#BillTotalPrice").text()) + parseInt($("#Totalprice").val());
            $("#BillTotalPrice").text(BillTotal);
            $("#SBillTotalPrice").val(BillTotal);
            var productsCounts = parseInt($("#BillTotalProducts").text()) + 1;
            $("#BillTotalProducts").text(productsCounts);
            
            // alert($("productID").val());
            PbarcodesArray[0] = 'one';
            PbarcodesArray.push($("#Pbarcod").val());
            productsInfoArray.push({billId:$("#BillNumber").val(),productID:$("#productID").val(),unitId:$("#unitId").val(),Quantity:$("#Quantity").val(),price:$("#price").val(),Totalprice:$("#Totalprice").val(),exdate:exdate});
            $("#PName").val("");
            $("#PUnit").val("");
            $("#price").val("1");
            $("#Quantity").val("1");
            $("#Totalprice").val("1");
            $("#HasExDate").val("01/01/2019");
            $("#HasExDate").hide();
            $("#Pbarcod").focus();
            $("#Pbarcod").select();
            

        }
    });

    document.querySelector('#price').addEventListener('keypress', function (e) {
        var key = e.which || e.keyCode;
        if (key === 13) { // 13 is enter
            $("#Quantity").focus();
            $("#Quantity").select();
        }
    });
});




function editePrice(id,rowid,cellid){
    // alert("row" + element.parentNode.parentNode.rowIndex + 
    // " - column" + element.parentNode.cellIndex);
    //alert(id);
   // pid = 66;
    if(cellid == "_2")
    {
        var price = prompt("يرجى ادخال السعر الجديد");
            var  pattern = /^[0-9]/;
            if (price == null || price == "" || price == 0 || !pattern.test(price)){
                alert("القيمة المدخلة غير صحيحه !");
            } else {
                var val = $("#"+id+"").text();
                var index = productsInfoArray.findIndex(p => p.price == val);
                
                var oldTotal = $("#"+rowid+"_4").text();
                var total = $("#"+rowid+"_3").text() * price;
                $("#"+id+"").text(price);
                productsInfoArray[index]['price'] = price;
                $("#"+rowid+"_4").text(total);
                productsInfoArray[index]['Totalprice'] = total;
                
                var newTotal = $("#"+rowid+"_4").text();
                var BillTotal = parseInt($("#BillTotalPrice").text()) - oldTotal;
                $("#BillTotalPrice").text(parseInt(BillTotal) + parseInt(newTotal));
                $("#SBillTotalPrice").val(parseInt(BillTotal) + parseInt(newTotal));
                if($('#AmountDiscount').val() != "" || $('#AmountDiscount').val() != 0 )
                {
                    $('#AmountDiscount').val(0);
                    $('#AmountDiscount').keyup();
                    //$("#AmountDiscount").after('<p class="text-danger"> تم الغاء التخصم  </p>');
                    $("#AmountDiscount").closest('.form-group').addClass('has-error');
                    alert("تم الغاء الخصم يرجى تحديد الخصم بعد التاكد ان جميع المنتجات صحيحة !");
                }
                
                //alert(total);// * $("#"+id+"").text()
            }
    }
    if(cellid == "_3")
    {
        var Quantity = prompt("يرجى ادخال الكمية الجديده");
            var  pattern = /^[0-9]/;
            if (Quantity == null || Quantity == "" || Quantity == 0 || !pattern.test(Quantity)){
                alert("القيمة المدخلة غير صحيحه !");
            } else {
                var val = $("#"+id+"").text();
                var index = productsInfoArray.findIndex(p => p.Quantity == val);

 
                var oldTotal = $("#"+rowid+"_4").text();
                var total = $("#"+rowid+"_2").text() * Quantity;
                $("#"+id).text(Quantity);
                productsInfoArray[index]['Quantity'] = Quantity;
                $("#"+rowid+"_4").text(total);
                productsInfoArray[index]['Totalprice'] = total;
                var newTotal = $("#"+rowid+"_4").text();
                var BillTotal = parseInt($("#BillTotalPrice").text()) - oldTotal;
                $("#BillTotalPrice").text(parseInt(BillTotal) + parseInt(newTotal));
                $("#SBillTotalPrice").val(parseInt(BillTotal) + parseInt(newTotal));
                //alert(total);// * $("#"+id+"").text()
                if($('#AmountDiscount').val() != "" || $('#AmountDiscount').val() != 0 )
                {
                    $('#AmountDiscount').val(0);
                    $('#AmountDiscount').keyup();
                    //$("#AmountDiscount").after('<p class="text-danger"> تم الغاء التخصم  </p>');
                    $("#AmountDiscount").closest('.form-group').addClass('has-error');
                    alert("تم الغاء الخصم يرجى تحديد الخصم بعد التاكد ان جميع المنتجات صحيحة !");
                }
            }

            
    }
    if(cellid == "_5")
    {
        var  pattern = /^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/;
        var x =$("#"+rowid+"_5").text();
        //alert($("#"+rowid+"_5").text());
        
           if(x != "لايوجد")
           {
            var date = prompt("يرجى ادخال تاريخ الانتهاء الجديد",$("#"+id+"").text());
            if (date == null || date == "" || !pattern.test(date)){
                alert("القيمة المدخلة غير صحيحه !");
            } else {
                var val = $("#"+id+"").text();
                var index = productsInfoArray.findIndex(p => p.exdate == val);

                $("#"+rowid+"_5").text(date);
                productsInfoArray[index]['exdate'] = date;
               
            }
            }
            

    }
    console.log(productsInfoArray);
}



    

//function to get the id of the row  and delete it
function  DeleteRow(element,rowid,deleteID) {
   // var barcode = $("#Code"+rowid).text();
   var index =  PbarcodesArray.indexOf($(deleteID).text());
    if (index > -1) {
        //alert(index + " " + PbarcodesArray[index]);
        PbarcodesArray.splice(index, 1);
        productsInfoArray.splice(index, 1);
        console.log(productsInfoArray);
        var Total = $("#"+rowid+"_4").text();
        var BillTotal = parseInt($("#BillTotalPrice").text()) - Total;
        $("#BillTotalPrice").text(BillTotal);
        //var BillTotal = parseInt($("#SBillTotalPrice").text()) - Total;
        $("#SBillTotalPrice").val(BillTotal);
        var productsCounts = parseInt($("#BillTotalProducts").text()) - 1;
        $("#BillTotalProducts").text(productsCounts);
        
        //culcDiscountFromAmount();
        if($('#AmountDiscount').val() != "" || $('#AmountDiscount').val() != 0 )
        {
            $('#AmountDiscount').val(0);
            $('#AmountDiscount').keyup();
            //$("#AmountDiscount").after('<p class="text-danger"> تم الغاء التخصم  </p>');
            $("#AmountDiscount").closest('.form-group').addClass('has-error');
            alert("تم الغاء الخصم يرجى تحديد الخصم بعد التاكد ان جميع المنتجات صحيحة !");
        }
       
        document.getElementById("BillTB").deleteRow(element.parentNode.parentNode.rowIndex);
        if($("#BillTotalProducts").text() == 0 ){$('#totalAfterDiscount').text(0); $('#StotalAfterDiscount').val(0); }
    }
    else{
       // $("#Code"+rowid+"").text()
        alert("not found " + $(deleteID).text() +"  " + rowid );
    }
    
}

function clucremining(){
    if($('.cash').is(':checked')) {
         
            if($("#StotalAfterDiscount").val() == 0)
            {
                if(Number($("#SBillTotalPrice").val()) < Number($("#FAmount").val()) )
                {
                    $("#FAmount").val(Number($("#SBillTotalPrice").val()));
                    $("#Remaining").val(0);
                }
                else{
                    $("#Remaining").val(Number($("#SBillTotalPrice").val()) - Number($("#FAmount").val()) );
                }
                
            }
            else{

                if(Number($("#StotalAfterDiscount").val()) < Number($("#FAmount").val()) )
                {
                    $("#FAmount").val(Number($("#StotalAfterDiscount").val()));
                    $("#Remaining").val(0);
                }
                else{
                    $("#Remaining").val(Number($("#StotalAfterDiscount").val()) - Number($("#FAmount").val()) );
                }
               
            }

    }
    if($('.credit').is(':checked')) {
         
        if($("#StotalAfterDiscount").val() == 0)
        {
            $("#Remaining").val(Number($("#SBillTotalPrice").val()));
        }
        else{
            $("#Remaining").val(Number($("#StotalAfterDiscount").val()));
        }

    }
    if($('.bank').is(':checked')) {
         
        if($("#StotalAfterDiscount").val() == 0)
        {
            if(Number($("#SBillTotalPrice").val()) < Number($("#Bamount").val()) )
                {
                    $("#Bamount").val(Number($("#SBillTotalPrice").val()));
                    $("#Remaining").val(0);
                }
                else{
                    $("#Remaining").val(Number($("#SBillTotalPrice").val()) - Number($("#Bamount").val()) );
                }
            
        }
        else{
            if(Number($("#StotalAfterDiscount").val()) < Number($("#Bamount").val()) )
                {
                    $("#Bamount").val(Number($("#StotalAfterDiscount").val()));
                    $("#Remaining").val(0);
                }
                else{
                    $("#Remaining").val(Number($("#StotalAfterDiscount").val()) - Number($("#Bamount").val()) );
                }
            
        }

    }

   
}
function submitBill(){

            //productsInfoArray.splice(0, 1);
            //console.log(productsInfoArray);

        if($('.cash').is(':checked')) {
            var totalpriceDis = Number($("#StotalAfterDiscount").val());
            var totalPrice = Number($("#SBillTotalPrice").val());
            var FAmount =  Number($("#FAmount").val());

            var reminnig = $("#Remaining").val();
            var suplierId = $("#supID").val();

            if(productsInfoArray.length < 2){
                alert("لايمكن حفظ فاتورة بدون منتجات");
                return false;
            }
            if(!suplierId > 0)
            {
                alert("يجب اختيار مورد اولاً !");
                return false;
            }

            if(FAmount == "" || FAmount == 0 || FAmount == null)
            {
                alert("يجب ادخال المبلغ المدفوع");
                return false;
            }

            if(totalpriceDis != 0 )
            {
                if(!FAmount == totalpriceDis)
                {
                    alert("يجب ان يكون المبلغ المدفوع مساوي لأجمالي الفاتورة بعد التخفيض");
                    return false;
                }
                
            }
            else{
                if(!FAmount == totalPrice)
                {
                    alert("يجب ان يكون المبلغ المدفوع مساوي لأجمالي الفاتورة");
                    return false;
                }
            }

            if(totalpriceDis < 0)
            {
                alert("التخفيض غير مقبول");
                return false;
            }
            var paidType = 1;
            var billStatus = 1;
            if(reminnig != 0){
               
                if (confirm('سيتم تحويل الفاتورة الى أجل وذالك  بسبب ان المبلغ المدفوع  لايساوي الاجمالي ?')) {
                    paidType = 2;
                    billStatus = 2;
                } else {
                    return false;
                }
            }
            
            var formData = {
                BillNumber:$("#BillNumber").val(),
                Billstatus:billStatus,
                SupplierId:$("#supID").val(),
                DistributorId:$("#Distributors").val(),
                billItems:$("#BillTotalProducts").text(),
                BillTotalPrice:$("#BillTotalPrice").text(),
                billPreDiscount:$("#PerDiscount").val(),
                billAmountDiscount:$("#AmountDiscount").val(),
                Billdescount:$("#totalAfterDiscount").text(),
                billPaidType:paidType,
                fundId:$("#funds").val(),
                PaidCash:$("#FAmount").val(),
                paidCashCurrancy:$("#fCurrancies").val(),
                paidCashExchange:$("#FExchange").val(),
                Bankid: null,
                paidCheckCurrancy: null,
                paidCheckExchange: null,
                paidCheckNo: null,
                paidCheckAmount: null,
                paidCreditCurrancy: null,
                paidCreditExchange: null,
                Remaining:$("#Remaining").val(),
                BillReference:$("#BillReference").val(),
                Details:$("#Details").val(),
                Inventeory:$("#Inventeory").val(),
                BillProductsDetails:productsInfoArray,
                _token : $('meta[name="csrf-token"]').attr('content') 
            }
            
            $.ajax({
                url: '/SaveBills',
                type:'post',
                data: formData,
                dataType: 'json',
                success:function(response){
                    if(response['success'] == true){
                          //console.log(response['Exchange']);
                          alert(response['messages']);
                          restbill();
                          //console.log(response['messages']);
                          //console.log(response['billDetails']);
    
                        
                    }// /if(response)
                    else{
                        console.log(response['messages']);
                    }
                }// /response function success  
            });// /.ajax
    
        }
        if($('.credit').is(':checked')) {
            var totalpriceDis = Number($("#StotalAfterDiscount").val());
            var totalPrice = Number($("#SBillTotalPrice").val());
            var FAmount =  Number($("#FAmount").val());

            var reminnig = $("#Remaining").val();
            var suplierId = $("#supID").val();

            if(productsInfoArray.length < 2){
                alert("لايمكن حفظ فاتورة بدون منتجات");
                return false;
            }
            if(!suplierId > 0)
            {
                alert("يجب اختيار مورد اولاً !");
                return false;
            }

            if(totalpriceDis < 0)
            {
                alert("التخفيض غير مقبول");
                return false;
            }
           
            
            var formData = {
                BillNumber:$("#BillNumber").val(),
                Billstatus:2,
                SupplierId:$("#supID").val(),
                DistributorId:$("#Distributors").val(),
                billItems:$("#BillTotalProducts").text(),
                BillTotalPrice:$("#BillTotalPrice").text(),
                billPreDiscount:$("#PerDiscount").val(),
                billAmountDiscount:$("#AmountDiscount").val(),
                Billdescount:$("#totalAfterDiscount").text(),
                billPaidType:2,
                fundId:null,
                PaidCash:null,
                paidCashCurrancy:null,
                paidCashExchange:null,
                Bankid: null,
                paidCheckCurrancy: null,
                paidCheckExchange: null,
                paidCheckNo: null,
                paidCheckAmount: null,
                paidCreditCurrancy:null,
                paidCreditExchange: null,
                Remaining:$("#Remaining").val(),
                BillReference:$("#BillReference").val(),
                Details:$("#Details").val(),
                Inventeory:$("#Inventeory").val(),
                BillProductsDetails:productsInfoArray,
                _token : $('meta[name="csrf-token"]').attr('content') 
            }
            
            $.ajax({
                url: '/SaveBills',
                type:'post',
                data: formData,
                dataType: 'json',
                success:function(response){
                    if(response['success'] == true){
                          //console.log(response['Exchange']);
                          alert(response['messages']);
                          restbill();
                          //console.log(response['messages']);
                          //console.log(response['billDetails']);
    
                        
                    }// /if(response)
                    else{
                        console.log(response['messages']);
                    }
                }// /response function success  
            });// /.ajax
    
        }
        if($('.bank').is(':checked')) {
            var totalpriceDis = Number($("#StotalAfterDiscount").val());
            var totalPrice = Number($("#SBillTotalPrice").val());
            var Bamount =  Number($("#Bamount").val());

            var reminnig = $("#Remaining").val();
            var suplierId = $("#supID").val();

            if(productsInfoArray.length < 2){
                alert("لايمكن حفظ فاتورة بدون منتجات");
                return false;
            }
            if(!suplierId > 0)
            {
                alert("يجب اختيار مورد اولاً !");
                return false;
            }

            if(Bamount == "" || Bamount == 0 || Bamount == null)
            {
                alert("يجب ادخال المبلغ المدفوع");
                return false;
            }

            if(totalpriceDis != 0 )
            {
                if(!Bamount == totalpriceDis)
                {
                    alert("يجب ان يكون المبلغ المدفوع مساوي لأجمالي الفاتورة بعد التخفيض");
                    return false;
                }
                
            }
            else{
                if(!Bamount == totalPrice)
                {
                    alert("يجب ان يكون المبلغ المدفوع مساوي لأجمالي الفاتورة");
                    return false;
                }
            }

            if(totalpriceDis < 0)
            {
                alert("التخفيض غير مقبول");
                return false;
            }
            var paidType = 3;
            var billStatus = 1;
            if(reminnig != 0){
               
                if (confirm('سيتم تحويل الفاتورة الى أجل وذالك  بسبب ان المبلغ المدفوع  لايساوي الاجمالي ?')) {
                    paidType = 2;
                    billStatus = 2;
                } else {
                    return false;
                }
            }
            
            var formData = {
                BillNumber:$("#BillNumber").val(),
                Billstatus:billStatus,
                SupplierId:$("#supID").val(),
                DistributorId:$("#Distributors").val(),
                billItems:$("#BillTotalProducts").text(),
                BillTotalPrice:$("#BillTotalPrice").text(),
                billPreDiscount:$("#PerDiscount").val(),
                billAmountDiscount:$("#AmountDiscount").val(),
                Billdescount:$("#totalAfterDiscount").text(),
                billPaidType:paidType,
                fundId:null,
                PaidCash:null,
                paidCashCurrancy:null,
                paidCashExchange:null,
                Bankid: $("#Banks").val(),
                paidCheckCurrancy: $("#BCurrancies").val(),
                paidCheckExchange: $("#BExchange").val(),
                paidCheckNo: $("#Bamount").val(),
                paidCheckAmount: $("#chacNum").val(),
                paidCreditCurrancy:null,
                paidCreditExchange: null,
                Remaining:$("#Remaining").val(),
                BillReference:$("#BillReference").val(),
                Details:$("#Details").val(),
                Inventeory:$("#Inventeory").val(),
                BillProductsDetails:productsInfoArray,
                _token : $('meta[name="csrf-token"]').attr('content') 
            }
            
            $.ajax({
                url: '/SaveBills',
                type:'post',
                data: formData,
                dataType: 'json',
                success:function(response){
                    if(response['success'] == true){
                          //console.log(response['Exchange']);
                          alert(response['messages']);
                          restbill();
                          //console.log(response['messages']);
                          //console.log(response['billDetails']);
    
                        
                    }// /if(response)
                    else{
                        console.log(response['messages']);
                    }
                }// /response function success  
            });// /.ajax
        }
        
        
        

}

function selectSupplier(supID=null ,supName= null){
    if(supID && supName){
        
        $("#SupplierName").val(supName);
        $("#SupplierName").attr("disabled",true);
        $('.openBillinfo').after('<input type="hidden" name="supID" id="supID" value="'+ supID +'"  />');
        $('#OpenSupplieriesModel').hide();
        $( ".SupModalCloseBtn" ).on( "click", function() {
            $('#OpenSupplieriesModel').modal('toggle');
          });
          $( ".SupModalCloseBtn" ).trigger( "click" );
          GetDistributors(supID);
          //$("#openDisModal").click();
         // $("#openBillinfo").css("z-index", "9998");
          
         // $('#openBillinfo').hide();
          //$('#openBillinfo').show();
          //$("#openBillinfo").focus();
    }
}

function GetDistributors(supID=null){
    if(supID){
        var formData = {
            supID : supID,
            _token : $('meta[name="csrf-token"]').attr('content') 
        }
        
        $.ajax({
            url: '/gatPurschingDistributorData',
            type:'post',
            data: formData,
            dataType: 'json',
            success:function(response){
                if(response['success'] == true){
                      //console.log(response['Exchange']);
                      $('#Distributors').find('option').remove();
                      response['Distributor'].forEach(function(element) {
                          $('#Distributors').append($("<option></option>").attr("value",element['id']).text(element['Name']));
                        });
                    
                }// /if(response)
                else{
                    alert('المورد لايملك اي مندوب ');
                }
            }// /response function success  
        });// /.ajax

       
        
    }
}



function selectUnit(unitId = null,productID=null ,unitName= null,productName = null,HasExDate = null){
    if(unitId && productID && unitName && productName && HasExDate){
        //alert(unitId+" "+productID+" "+ unitName +" "+ productName);
        
        if(HasExDate == 1){$("#HasExDate").show();
        $(".HasExDate").val("01/01/20019");
        }else{$("#HasExDate").hide();}
        $("#PName").val(productName);
        $("#PUnit").val(unitName);
        $('#ProductInfo').after('<input type="hidden" name="productID" id="productID" value="'+ productID +'"  />');
        $('#ProductInfo').after('<input type="hidden" name="unitId" id="unitId" value="'+ unitId +'"  />');
        $('#OpenProductUnitsModel').hide();
        $( ".ProductUnitModalCloseBtn" ).on( "click", function() {
            $('#OpenProductUnitsModel').modal('toggle');
          });
        $( ".ProductUnitModalCloseBtn" ).trigger( "click" );
        if($(".HasExDate").is(":visible")){
            $(".HasExDate").focus();
            $(".HasExDate").select();
        }
        else{
            $("#price").focus();
            $("#price").select();
        }
       
    }
}

function getFCurancies(sel)
{
    var option = sel.value;
    if(option){
        var formData = {
            option : option,
            _token : $('meta[name="csrf-token"]').attr('content') 
        }
        
        $.ajax({
            url: '/getfundCurrancies',
            type:'post',
            data: formData,
            dataType: 'json',
            success:function(response){
                if(response['success'] == true){
                    $('#fCurrancies').find('option').remove();
                    response['fundsCurrancies'].forEach(function(element) {
                        $('#fCurrancies').append($("<option></option>").attr("value",element['CurrancyId']).text(element['CurrancyName']));
                      });
                      //console.log(response['Exchange']);
                      $('#FExchange').val(response['Exchange']);
                    
                }// /if(response)
                else{
                    alert('الصندوق لايملك اي حساب في العملات');
                }
            }// /response function success  
        });// /.ajax
    }//if validtion pass
    
    //$('#fCurrancies').find('option').remove();
//     $.each(selectValues, function(key, value) {   
//         $('#mySelect')
//             .append($("<option></option>")
//                        .attr("value",key)
//                        .text(value)); 
//    });
}

function getFExchange(sel)
{
    var option = sel.value;
    //alert(option);
    if(option){
        var formData = {
            option : option,
            _token : $('meta[name="csrf-token"]').attr('content') 
        }
        
        $.ajax({
            url: '/getCurrancyExchange',
            type:'post',
            data: formData,
            dataType: 'json',
            success:function(response){
                if(response['success'] == true){
                      //console.log(response['Exchange']);
                      $('#FExchange').val(response['Exchange']);
                    
                }// /if(response)
                else{
                    alert('حصل خطاء اثناء استرجاع البيانات ');
                }
            }// /response function success  
        });// /.ajax
    }//if validtion pass
    
    //$('#fCurrancies').find('option').remove();
//     $.each(selectValues, function(key, value) {   
//         $('#mySelect')
//             .append($("<option></option>")
//                        .attr("value",key)
//                        .text(value)); 
//    });
}

function getOExchange(sel)
{
    var option = sel.value;
    //alert(option);
    if(option){
        var formData = {
            option : option,
            _token : $('meta[name="csrf-token"]').attr('content') 
        }
        
        $.ajax({
            url: '/getCurrancyExchange',
            type:'post',
            data: formData,
            dataType: 'json',
            success:function(response){
                if(response['success'] == true){
                      //console.log(response['Exchange']);
                      $('#OExchange').val(response['Exchange']);
                    
                }// /if(response)
                else{
                    alert('حصل خطاء اثناء استرجاع البيانات ');
                }
            }// /response function success  
        });// /.ajax
    }//if validtion pass
    
}

function getBCurancies(sel)
{
    var option = sel.value;
    if(option){
        var formData = {
            option : option,
            _token : $('meta[name="csrf-token"]').attr('content') 
        }
        
        $.ajax({
            url: '/getBankCurrancies',
            type:'post',
            data: formData,
            dataType: 'json',
            success:function(response){
                if(response['success'] == true){
                    $('#BCurrancies').find('option').remove();
                    response['BankCurrancies'].forEach(function(element) {
                        $('#BCurrancies').append($("<option></option>").attr("value",element['CurrancyId']).text(element['CurrancyName']));
                      });
                      //console.log(response['Exchange']);
                      $('#BExchange').val(response['Exchange']);
                    
                }// /if(response)
                else{
                    alert('الصندوق لايملك اي حساب في العملات');
                }
            }// /response function success  
        });// /.ajax
    }//if validtion pass

}

function getBExchange(sel)
{
    var option = sel.value;
    //alert(option);
    if(option){
        var formData = {
            option : option,
            _token : $('meta[name="csrf-token"]').attr('content') 
        }
        
        $.ajax({
            url: '/getCurrancyExchange',
            type:'post',
            data: formData,
            dataType: 'json',
            success:function(response){
                if(response['success'] == true){
                      //console.log(response['Exchange']);
                      $('#BExchange').val(response['Exchange']);
                    
                }// /if(response)
                else{
                    alert('حصل خطاء اثناء استرجاع البيانات ');
                }
            }// /response function success  
        });// /.ajax
    }//if validtion pass

}


