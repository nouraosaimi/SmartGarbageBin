@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
		<div class="col-md-12">
			   <ol class="breadcrumb">
			     <li class="active"><a href="{{url('/home')}}">الشاشة الرئيسية </a></li>
			     </ol>
			    <div class="panel panel-info">
				    <div class="panel-heading">
				    	<h5 class="panel-title" style="text-align: center;"><i  class="glyphicon glyphicon-list-alt"></i> شاشة المشتريات   </h5>
				     </div>
			            <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                <form id="billform" class="form-horizontal">
                                <div class="form-group">
                                        <label for="BillNumber" class="col-md-2 control-label ">رقم الفاتورة: </label>
                                        <div class="col-md-4">
                                            <input type="text" name="BillNumber" id="BillNumber" class="form-control" disabled="disabled" placeholder="00000"  value="{{old('BillNumber')}}" >
                                        </div>
                                        <div class="col-sm-3">
                                        <button type="button" id="newBill" onclick="createNewBill()" class="btn btn-success" > <i class="glyphicon glyphicon-plus-sign"></i><b> فاتورة جديده</b></button>
                                        <button type="button" title="اختيار مورد" class="btn btn-primary" data-toggle="modal" data-target="#openBillinfo"  id="openDisModal"> <i class="glyphicon glyphicon-plus-sign"></i><b> فتح معلومات المورد</b></button>
                                        <button type="button" onclick="submitBill()" id="submitbill" class="btn btn-info">حفظ الفاتورة</button>

                                        </div>
                                    </div>
                                    <div class="form-group" id="Inventeory-group">
                                        <label for="Inventeory" class="col-sm-2 control-label "> التوريد الى المخزن :</label>
                                        <div class="col-sm-4">
                                        <select class="form-control" id="Inventeory"  name="Inventeory">
                                            @if($Inventeories != null)
                                            @foreach ($Inventeories as $Inventeory )
                                                <option value="{{$Inventeory->id}}"> {{$Inventeory->Name}} </option>
                                            @endforeach
                                            @endif
                                        </select>
                                        </div>
                                    </div>
                                </form>
                                </div>{{--/col-12  - --}}
                            </div>{{--/row purcheases - --}}
                            <br>
                            <div class="row" id="billInfo">
                                <div class="col-md-4">
                                    <div class="row">
                                     
                                        <div class="col-md-12">

                                            <div class="panel panel-warning">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title" style="text-align: center;">بحث  صنف </h3>
                                                </div>{{--/panel-heading supplier --}}
                                                <div class="panel-body">
                                                    <h5 class="panel-title" style="text-align: center;">بحـث بواسطة </h5>
                                                    <hr> 
                                                    <form class="form-horizontal" id="productSearchform" >
                                                    {{csrf_field()}}
                                                        <div class="form-group">
                                                            <label class="col-sm-3" for="Pbarcod">الباركود</label>
                                                            <div class="col-sm-9">
                                                            <input type="number" class="form-control" id="Pbarcod" >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3" for="Pname">الاسم</label>
                                                            <div class="col-sm-9">
                                                            <button type="button"  id="SearchByNameBtn"  data-toggle="modal" data-target="#OpenSearchByName"  class="btn btn-pramiry">بحث عن منتج</button>
                                                            </div>
                                                            <div class="col-sm-9">
                                                            </div>
                                                        </div>
                                                        
                                                    </form>
                                                    <hr>
                                                    <h5 class="panel-title" style="text-align: center;">معلومات الصنف</h5>
                                                    <hr> 
                                                    <form class="form-horizontal" id="productInfoForm" >
                                                    {{csrf_field()}}
                                                        <div class="form-group">
                                                            <label class="col-sm-3" for="PName">الصنف</label>
                                                            <div class="col-sm-9">
                                                            <input type="text" class="form-control" disabled="disabled" id="PName" >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3" for="PUnit">الوحدة</label>
                                                            <div class="col-sm-9">
                                                            <input type="text" class="form-control" disabled="disabled" id="PUnit" >
                                                            </div>
                                                        </div>
                                                         <div class="form-group" id="HasExDate" >
                                                            <label for="HasExDate" class="col-sm-4 control-label ">تاريخ الانتهاء</label>
                                                            <div class="col-sm-8">
                                                                <div class="input-group">
                                                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                                            <input type='text'style="position: relative; z-index: 100000;" class="form-control HasExDate" id="datepicker"name="HasExDate"  />											
                                                            </div>
                                                            </div>
                                                        </div>
                                                         <div class="form-group">
                                                            
                                                            <label class="col-sm-3" for="price">السعر</label>
                                                            <div class="col-sm-9">
                                                            <input type="number" class="form-control" onkeyup="culcTotalPrice()" value="1" min="1" id="price" >
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                        <br>
                                                            <label class="col-sm-3" for="Quantity">الكمية</label>
                                                            <div class="col-sm-9">
                                                            <input type="number" class="form-control" onkeyup="culcTotalPrice()" value="1"  min="1" id="Quantity" >
                                                            </div>
                                                        </div>
                                                        <div id="ProductInfo" ></div>
                                                       
                                                       

                                                        <div class="form-group">
                                                            <br>
                                                            <label class="col-sm-3" for="Totalprice">اجمالي السعر</label>
                                                            <div class="col-sm-9">
                                                            <input type="number" class="form-control" disabled="disabled"  id="Totalprice" >
                                                            </div>
                                                        </div>

                                                        

                                                        <button type="button" style="display:none;"  class="btn btn-primary" id="BarcodBtn" data-toggle="modal" data-target="#OpenProductUnitsModel" > <i class="glyphicon glyphicon-plus-sign"></i><b></b></button>
                                                    </form>
                                                </div>{{--/panale-body supplier --}}
                                                <div class="panel-footer">
                                                           
                                                        
                                                </div>{{--/panel-footer bill --}}
                                            </div>{{--/panal-defult supplier --}}

                                        </div>{{--/col-12 supplier --}}
                                    </div>{{--/row supplier --}}
                                </div>{{--/col-4 suplire and bill information  --}}
                                <div class="col-md-8">
                                 <div class="row">
                                        <div class="col-md-12">

                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title" style="text-align: center;">المعلومات المالية للفاتورة</h3>
                                                </div>{{--/panel-heading bill-action  --}}
                                                <div class="panel-body">
                                                   <form class="form-inline" id="discountForm">
                                                    <div class="form-group" >
                                                        <label for="PerDiscount">خصم %</label>
                                                        <input type="number" class="form-control" onkeyup="clucDiscount()" id="PerDiscount" name="PerDiscount">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="AmountDiscount">خصم مبلغ</label>
                                                        <input type="number"  class="form-control" onkeyup="culcDiscountFromAmount()" id="AmountDiscount" name="AmountDiscount">
                                                    </div>
                                                    </form>
                                                </div>{{--/panale-body bill-action  --}}
                                                <div class="panel-footer">
                                                            <label for="BillTotalPrice">اجمالي الفاتورة : </label>
                                                            <label id="BillTotalPrice" class="label label-success" >0</label>
                                                            <label for="BillTotalProducts">|  عدد الاصناف : </label>
                                                            <label id="BillTotalProducts" class="label label-warning" >0</label>
                                                            <label for="totalAfterDiscount" >|  اجمالي الفاتورة بعد الخصم</label>   
                                                            <label id="totalAfterDiscount" class="label label-danger" >0</label>
                                                </div>{{--/panel-footer bill-action  --}}
                                            </div>{{--/panal-defult bill-action  --}}
                                            
                                        </div>{{--/col-12 bill-action --}}
                                    </div>{{--/row bill-action  --}}

                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="panel panel-success">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title" style="text-align: center;">معلومات اصناف الفاتورة</h3>
                                                </div>{{--/panel-heading bill --}}
                                                <div class="panel-body" >
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered display responsive nowrap footable" style="width:100%" id="BillTB">
                                                                @csrf
                                                                <thead>
                                                                        <tr>
                                                                            
                                                                                <th>المصنف</th>
                                                                                <th>الوحده</th>
                                                                                <th>السعر</th>
                                                                                <th>الكمية</th>
                                                                                <th>الاجمالي</th>
                                                                                <th>تاريخ الانتهاء</th>
                                                                                <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="scroll90">
                                                                       <tr>
                                                                        
                                                                        </tr>
                                                                    </tbody>
                                                            </table>
                                                    </div>
                                                
                                                </div>{{--/panale-body bill --}}
                                                <div class="panel-footer">
                                                    Panel bill
                                                </div>{{--/panel-footer bill --}}
                                            </div>{{--/panal-defult bill --}}
                                            
                                        </div>{{--/col-12 bill --}}
                                    </div>{{--/row bill --}}

                                   
                                </div>

                                
                            </div>
                            {{-- //row bill info and productes  --}}
                         </div><!-- /panel-body -->
                        
                        <div class="panel-footer" >
     	                    <div class="row">
                                <div class="col-md-4">
                                    <span> المستخدم الحالي :   {{Session::get('username')}}  </span>
                                 </div>
                                 <div class="col-md-2">
                                    <span>| نوع المستخدم:   {{Session::get('UserType')}}</span>
                                 </div>
                                 
                                  
                             </div>
   	                    </div><!-- /panel-footer -->

                 </div><!-- /panel-info -->
         </div><!-- /col-md-12 -->

    </div><!-- /row -->

     <div id="openBillinfo" class="modal fade" tabindex="1" role="dialog"  >
                  <div class="modal-dialog" role="document" >
                  <div class="modal-content" style="border-color:#265a88;border-width: 2px;">
                     <div class="modal-header" style="background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color: #fff;"><i class="glyphicon glyphicon-list-alt"></i> معلومات المورد والمعلومات المالية الخاصه بالمورد </h4>
                     </div>
                                    <div class="modal-body BillModal">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form  class="form-horizontal"  name="billInfoForm" id="submitBillForm" auto-compelet="off" >
                                                        {{csrf_field()}}
                                                            
                                                                
                                                            
                                                            <div id="fainacialInfo">
                                                            <div class="form-group" >
                                                                    <label for="SBillTotalPrice" class="col-sm-3">الاجمالي: </label>
                                                                    <div class="col-sm-3">
                                                                    <input type="text" name="SBillTotalPrice" id="SBillTotalPrice" class="form-control" value="0"  >
                                                                    </div>
                                                                   <label for="StotalAfterDiscount" class="col-sm-3">الاجمالي بعد الخصم </label>
                                                                    <div class="col-sm-3">
                                                                    <input type="text" name="StotalAfterDiscount" id="StotalAfterDiscount" class="form-control" value="0"  >
                                                                    </div>
                                                                </div> 
                                                                
                                                               
                                                            <hr>
                                                            <div class="form-group">
                                                                <label for="SupplierName" class="col-md-3 control-label ">اسم المورد:</label>
                                                                <div class="col-md-4">
                                                                    <input type="text" name="SupplierName" id="SupplierName" class="form-control" disabled="disabled" placeholder="اسم المورد "  value="{{old('SupplierName')}}" >
                                                                </div>
                                                                <div class="col-sm-2">
                                                                <button type="button" title="اختيار مورد" class="btn btn-primary" data-toggle="modal" data-target="#OpenSupplieriesModel"  id="openDisModal"> <i class="glyphicon glyphicon-plus-sign"></i><b></b></button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                    <label for="Distributors" class="col-sm-3 control-label "> المندوب :</label>
                                                                    <div class="col-sm-7">
                                                                    <select class="form-control" id="Distributors"  name="Distributors">
                                                                        <option>لم يتم اختيار مورد !<option>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                                                                    
                                                            
                                                            <div class="form-group">
                                                                <label for="GroupStatus" class="col-md-3 control-label ">نوع الدفع:</label>
                                                                <div class="col-md-9">
                                                                        <div class="radio-inline">
                                                                            <input class="form-check-input cash" type="radio" name="inlineRadioOptions" id="hiddingform" value="1"onchange="hideForm(this.value);" >
                                                                            <label for="inlineRadio1">نقد</label>
                                                                        </div>
                                                                        <div class="radio-inline">
                                                                            <input class="form-check-input credit" type="radio" name="inlineRadioOptions" id="hiddingform" value="2" onchange="hideForm(this.value);">
                                                                            <label  for="inlineRadio3">أجل</label>
                                                                        </div>
                                                                        <div class="radio-inline">
                                                                            <input class="form-check-input bank" type="radio" name="inlineRadioOptions" id="hiddingform" value="3"onchange="hideForm(this.value);">
                                                                            <label  for="inlineRadio2">شيك</label>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div id="CashDetail">
                                                                <div class="form-group">
                                                                    <label for="funds" class="col-sm-3 control-label "> الصندوق :</label>
                                                                    <div class="col-sm-9">
                                                                    <select class="form-control"  onchange="getFCurancies(this);" id="funds" name="funds">
                                                                        @if($funds != null)
                                                                        @foreach ($funds as $fund )
                                                                            <option value="{{$fund->id}}"> {{$fund->Name}} </option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="fCurrancies" class="col-sm-3 control-label "> العملة :</label>
                                                                    <div class="col-sm-9">
                                                                    <select class="form-control" onchange="getFExchange(this);" id="fCurrancies" name="fCurrancies">
                                                                        @if($fundsCurrancies != null)
                                                                        @foreach ($fundsCurrancies as $fundCurrancie )
                                                                            <option value="{{$fundCurrancie->CurrancyId}}"> {{$fundCurrancie->CurrancyName}} </option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="FExchange" class="col-sm-3 control-label "> سعر الصرف :</label>
                                                                    <div class="col-sm-9">
                                                                    <input type="number" class="form-control" id="FExchange" min="1" name="FExchange" value="@if($CurrancyInfo != null){{ $CurrancyInfo->Exchange }}@endif">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="FAmount" class="col-sm-3 control-label "> المبلغ :</label>
                                                                    <div class="col-sm-9">
                                                                    <input type="number" class="form-control" onkeyup="clucremining()" value="0" id="FAmount" name="FAmount">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div id="bankDetail">
                                                            <div class="form-group">
                                                                    <label for="Banks" class="col-sm-3 control-label "> البنك :</label>
                                                                    <div class="col-sm-9">
                                                                    <select class="form-control" id="Banks" onchange="getBCurancies(this);" name="Banks">
                                                                        @if($Banks != null)
                                                                        @foreach ($Banks as $Bank )
                                                                            <option value="{{$Bank->id}}"> {{$Bank->Name}} </option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="BCurrancies" class="col-sm-3 control-label "> العملة :</label>
                                                                    <div class="col-sm-9">
                                                                    <select class="form-control" onchange="getBExchange(this);" id="BCurrancies" name="BCurrancies">
                                                                        @if($BanksCurrancies != null)
                                                                        @foreach ($BanksCurrancies as $BanksCurrancy )
                                                                            <option value="{{$BanksCurrancy->CurrancyId}}"> {{$BanksCurrancy->CurrancyName}} </option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="BExchange" class="col-sm-3 control-label "> سعر الصرف :</label>
                                                                    <div class="col-sm-9">
                                                                    <input type="number" class="form-control" id="BExchange" name="BExchange" value="@if($BankCurrancyInfo != null){{ $BankCurrancyInfo->Exchange }}@endif">
                                                                    </div>
                                                                </div>
                                                            <div class="form-group" >
                                                            <label for="chacNum" class="col-sm-3 control-label ">رقم الشيك :</label>
                                                            <div class="col-sm-9">
                                                            <input type="number" class="form-control" name="chacNum" id="chacNum" placeholder=" رقم الشيك "required="required">                                                      </div>
                                                            </div>
  
                                                            
                                                            <div class="form-group">
                                                                    <label for="Bamount" class="col-sm-3 control-label "> المبلغ :</label>
                                                                    <div class="col-sm-9">
                                                                            <input type="number" class="form-control" value="0" onkeyup="clucremining()" name="Bamount" id="Bamount">
                                                                    </div>
                                                            </div> 
                                                            </div>
                                                            <div id="OmDetail">
                                                            <div class="form-group">
                                                                    <label for="OCurrancies" class="col-sm-3 control-label "> العملة :</label>
                                                                    <div class="col-sm-9">
                                                                    <select class="form-control" id="OCurrancies" onchange="getOExchange(this);" name="OCurrancies">
                                                                        @if($Curancies != null)
                                                                        @foreach ($Curancies as $Curancy )
                                                                            <option value="{{$Curancy->id}}">{{$Curancy->Name}}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="OExchange" class="col-sm-3 control-label "> سعر الصرف :</label>
                                                                    <div class="col-sm-9">
                                                                    <input type="number" class="form-control" id="OExchange" name="OExchange" value="@if($CurrancyExchange != null){{ $CurrancyExchange }}@endif">
                                                                    </div>
                                                                </div> 
                                                                </div>

                                                                <div class="form-group" >
                                                                    <label for="Remaining" class="col-sm-3 control-label ">الباقي:</label>
                                                                    <div class="col-sm-9">
                                                                    <input type="number" class="form-control" id="Remaining"  value="0"name="Remaining" >
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" >
                                                                <label for="BillReference" class="col-sm-3 control-label ">رقم المرجع :</label>
                                                                <div class="col-sm-9">
                                                                <input type="text" class="form-control" name="BillReference" id="BillReference" placeholder=" رقم المرجع ">                                                      </div>
                                                                </div> 
                                                                <div class="form-group">
                                                                    <label for="Details" class="col-sm-3 control-label "> الوصف :</label>
                                                                    <div class="col-sm-9">
                                                                            <textarea name="Details" id="Details" class="form-control" rows="3"   value="{{	old('Details')}}"></textarea>
                                                                        </div>
                                                                    </div>

                                                   
                                                    </div>{{-- //financial info --}}
                                                    
                                                    </form>


                                        </div>{{--/col-12  --}}
                                    </div>{{--/row  --}}

                                 </div><!-- /modal-body-->
                                 <div class="modal-footer openBillinfo">
                                            
                                 <button type="button" class="btn btn-default openBillinfoCloseBtn" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i> إلغاء </button>
                                 
                                 </div>
                           
                  </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
         </div><!-- /.modal -->

    <div id="OpenSupplieriesModel" class="modal fade" tabindex="1" role="dialog" style="z-index: 9998;">
                  <div class="modal-dialog" role="document" >
                  <div class="modal-content" style="border-color:#265a88;border-width: 2px;">
                     <div class="modal-header" style="background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color: #fff;"><i class="glyphicon glyphicon-list-alt"></i> قائمة الموردين </h4>
                     </div>
                                    <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                         <div class="responsive-table">
                                                    <table class="table table-bordered display responsive nowrap " style="width:100%;" id="supplierTB">
                                                    @csrf
                                                    <thead>
                                                        <tr>
                                                                <th>رقم المورد</th>
                                                                <th>اسم الشركة </th>
                                                                <th>الاسم</th>
                                                                <th>العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                 </div><!-- /modal-body-->
                                 <div class="modal-footer">
                                 <button type="button" class="btn btn-default SupModalCloseBtn" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i> إلغاء </button>
                                 </div>
                           
                  </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
         </div><!-- /.modal -->

         <div id="OpenDistributorModel" class="modal fade" tabindex="1" role="dialog" >
                  <div class="modal-dialog" role="document" >
                  <div class="modal-content" style="border-color:#265a88;border-width: 2px;">
                     <div class="modal-header" style="background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color: #fff;"><i class="glyphicon glyphicon-list-alt"></i> قائمة المناديب </h4>
                     </div>
                                    <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                         <div class="responsive-table">
                                                    <table class="table table-bordered display responsive nowrap " style="width:100%;" id="DistributorTB">
                                                    @csrf
                                                    <thead>
                                                        <tr>
                                                                <th>رقم المندوب</th>
                                                                <th>اسم المندوب </th>
                                                                <th>العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                 </div><!-- /modal-body-->
                                 <div class="modal-footer">
                                 <button type="button" class="btn btn-default DisModalCloseBtn" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i> إلغاء </button>
                                 </div>
                           
                  </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
         </div><!-- /.modal -->


         <div id="OpenProductUnitsModel" class="modal fade" tabindex="1" role="dialog" >
                  <div class="modal-dialog" role="document" >
                  <div class="modal-content" style="border-color:#265a88;border-width: 2px;">
                     <div class="modal-header" style="background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color: #fff;"><i class="glyphicon glyphicon-list-alt"></i> قائمة الوحدات </h4>
                     </div>
                                    <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                         <div class="table-responsive">
                                            <table class="table table-bordered display responsive nowrap" style="width:100%" id="PUnitsTB">
                                                    @csrf
                                                    <thead>
                                                            <tr>
                                                                   
                                                                    <th>الباركود</th>
                                                                    <th>الوحده</th>
                                                                    <th>السعة</th>
                                                                    <th>العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                 </div><!-- /modal-body-->
                                 <div class="modal-footer">
                                 <button type="button" class="btn btn-default ProductUnitModalCloseBtn" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i> إلغاء </button>
                                 </div>
                           
                  </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
         </div><!-- /.modal -->

         <div id="OpenSearchByName" class="modal fade" tabindex="1" role="dialog" >
                  <div class="modal-dialog" role="document" >
                  <div class="modal-content" style="border-color:#265a88;border-width: 2px;">
                     <div class="modal-header" style="background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color: #fff;"><i class="glyphicon glyphicon-list-alt"></i> قائمة الاصناف </h4>
                     </div>
                                    <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                         <div class="responsive-table">
                                                    <table class="table table-bordered display responsive nowrap " style="width:100%;" id="ProductsListTB">
                                                    @csrf
                                                    <thead>
                                                        <tr>
                                                                <th>الباركود</th>
                                                                <th>اسم الصنف</th>
                                                                <th>المجموعة</th>
                                                                <th>العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                 </div><!-- /modal-body-->
                                 <div class="modal-footer">
                                 <button type="button" class="btn btn-default OpenSearchByNameCloseBtn" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i> إلغاء </button>
                                 </div>
                           
                  </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
         </div><!-- /.modal -->

</div><!-- /continer -->
<script src="{{asset('js/customJS/purchases.js')}}"></script> 
<script type="text/javascript">



var manageSupplierTable ;
var managePUnitTable;
var manageProductsListTable;
  $(function(){
    manageSupplierTable=$('#supplierTB').DataTable({
      
      "language": {
			            "lengthMenu": "عرض   _MENU_ صف في كل صفحة ",
			            "zeroRecords": "لايوجد بيانات ليتم عرضها  ",
			            "info": " الصفحات المعروضه   _PAGE_ من  _PAGES_",
			            "infoEmpty": "لايوجد بيانات ليتم عرضها ",
			            "infoFiltered": "",
			            "sSearch" : " بـــحـــث ",
			            "oPaginate": {
						        "sNext": "التالي ",
						         "sPrevious": "السابق "
						      }
			        	},
      processing: true,
      serverSide: false,
      "order": [[ 0, "desc" ]],
      ajax: {
        "url" :'{!! route('get.PurschingSupplierData') !!}',
         "type": "get"},
      columns : [
        { data: 'id', name: 'id' },
        { data: 'CompanyName', name: 'CompanyName' },
        { data: 'Name', name: 'Name' },
        {data: 'action', name: 'action', orderable: false, searchable: false}
        
      ]
        
      } );

      

});



$('#OpenSupplieriesModel').on('shown.bs.modal', function (e) {
    

 manageSupplierTable.responsive.recalc();
});

  $('#OpenProductUnitsModel').on('shown.bs.modal', function (e) {
 managePUnitTable.responsive.recalc();
 });

function GetProductsTb(){
            
          if ( ! $.fn.DataTable.isDataTable( '#ProductsListTB' ) ) {
          manageProductsListTable =   $('#ProductsListTB').DataTable({
      
                          "language": {
                                      "lengthMenu": "عرض   _MENU_ صف في كل صفحة ",
                                      "zeroRecords": "لايوجد بيانات ليتم عرضها  ",
                                      "info": " الصفحات المعروضه   _PAGE_ من  _PAGES_",
                                      "infoEmpty": "لايوجد بيانات ليتم عرضها ",
                                      "infoFiltered": "",
                                      "sSearch" : " بـــحـــث ",
                                      "oPaginate": {
                                        "sNext": "التالي ",
                                        "sPrevious": "السابق "
                                      }
                                    },
                          processing: true,
                          serverSide: false,
                          ajax: {
                            "url" :'{!! route('get.ProductsList') !!}',
						   //"url" :'/getPUnits',
                            "type": "get"},
                          columns : [
                            { data: 'Barcode', name: 'Barcode' },
                            { data: 'Name', name: 'Name' },
                            { data: 'GroupID', name: 'GroupID' },
                            {data: 'action', name: 'action', orderable: false, searchable: false}
                          ]

                        });
                        //managePUnitTable.responsive.recalc();
          }//if(is table)
		  else{
			  //managePUnitTable = $('#PUnitsTB').DataTable();
			  manageProductsListTable.destroy();
			  //managePUnitTable.empty();
			  manageProductsListTable =   $('#ProductsListTB').DataTable({
      
				"language": {
							"lengthMenu": "عرض   _MENU_ صف في كل صفحة ",
							"zeroRecords": "لايوجد بيانات ليتم عرضها  ",
							"info": " الصفحات المعروضه   _PAGE_ من  _PAGES_",
							"infoEmpty": "لايوجد بيانات ليتم عرضها ",
							"infoFiltered": "",
							"sSearch" : " بـــحـــث ",
							"oPaginate": {
							"sNext": "التالي ",
							"sPrevious": "السابق "
							}
						},
				processing: true,
				serverSide: false,
				ajax: {
				"url" :'{!! route('get.ProductsList') !!}',
				//"url" :'/getPUnits',
				"type": "get"},
				columns : [
				{ data: 'Barcode', name: 'Barcode' },
				{ data: 'Name', name: 'Name' },
				{ data: 'GroupID', name: 'GroupID' },
				{data: 'action', name: 'action', orderable: false, searchable: false}
				]

			});
            //managePUnitTable.responsive.recalc();
		  }
}
function UpdatePUnitTable(){
	 
     //alert(isExiset);
      //******************
      
	  var formData = {
                     Pid : $("#Pbarcod").val(),
                     _token : $('meta[name="csrf-token"]').attr('content') 
                }
            
          if ( ! $.fn.DataTable.isDataTable( '#PUnitsTB' ) ) {
          managePUnitTable =   $('#PUnitsTB').DataTable({
      
                          "language": {
                                      "lengthMenu": "عرض   _MENU_ صف في كل صفحة ",
                                      "zeroRecords": "لايوجد بيانات ليتم عرضها  ",
                                      "info": " الصفحات المعروضه   _PAGE_ من  _PAGES_",
                                      "infoEmpty": "لايوجد بيانات ليتم عرضها ",
                                      "infoFiltered": "",
                                      "sSearch" : " بـــحـــث ",
                                      "oPaginate": {
                                        "sNext": "التالي ",
                                        "sPrevious": "السابق "
                                      }
                                    },
                          processing: true,
                          serverSide: false,
                          ajax: {
                            "url" :'{!! route('get.PPUnit') !!}',
						   //"url" :'/getPUnits',
                            "type": "get",
							"data":formData},
                          columns : [
                            { data: 'Barcode', name: 'Barcode' },
                            { data: 'CurrentUnit', name: 'CurrentUnit' },
                            { data: 'Package', name: 'Package' },
                            {data: 'action', name: 'action', orderable: false, searchable: false}
                          ]

                        });
                        //managePUnitTable.responsive.recalc();
          }//if(is table)
		  else{
			  //managePUnitTable = $('#PUnitsTB').DataTable();
			  managePUnitTable.destroy();
			  //managePUnitTable.empty();
			  managePUnitTable =   $('#PUnitsTB').DataTable({
      
				"language": {
							"lengthMenu": "عرض   _MENU_ صف في كل صفحة ",
							"zeroRecords": "لايوجد بيانات ليتم عرضها  ",
							"info": " الصفحات المعروضه   _PAGE_ من  _PAGES_",
							"infoEmpty": "لايوجد بيانات ليتم عرضها ",
							"infoFiltered": "",
							"sSearch" : " بـــحـــث ",
							"oPaginate": {
							"sNext": "التالي ",
							"sPrevious": "السابق "
							}
						},
				processing: true,
				serverSide: false,
				ajax: {
				"url" :'{!! route('get.PPUnit') !!}',
				//"url" :'/getPUnits',
				"type": "get",
				"data":formData},
				columns : [
				{ data: 'Barcode', name: 'Barcode' },
				{ data: 'CurrentUnit', name: 'CurrentUnit' },
				{ data: 'Package', name: 'Package' },
				{data: 'action', name: 'action', orderable: false, searchable: false}
				]

			});
            //managePUnitTable.responsive.recalc();
		  }
}




</script>



@endsection
