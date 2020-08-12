@extends('layouts.app')

@section('content')

        <div id="content">

        <div id="CreateCleanerMessages" ></div>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" style="background: transparent; border: transparent;" class="btn btn-info">
                  <img src="img/ssss.png" width="250px"  /> 
                        
                        
                    </button>
                    <a href="{{url('/Logout')}}" >
                        <i class="fa fa-sign-out mr-3" style="margin-left: 15px; color: white;"></i>
                    <b style="color: white;">Sign Out </b>
                    </a>
                    
               
                        
       
                    
                    
              
                </div>
            </nav>

   <div class="row"  style="display: inherit; margin-top: -25px;">
        <div class="card ">
            <div class="card-header" >
            <h5 style="color: #17a2b8;">Dashboard <h5>
            <button type="button" data-toggle="modal" data-target="#AddNewCleanerModal" class="btn btn-info mb-2" style="float: right" >Add new Cleaner</button> 
            <button type="button" data-toggle="modal" data-target="#AddNewBinModal" class="btn btn-info mb-2" style="float: right;margin-right : 10px;" >Add new Bin</button> 
            </div>
            <div class="card-body">
                <table id="CleanesTable" class="display responsive nowrap" style="width:100%" >
                    <thead>
                        <tr>
                            <th style="color: #17a2b8;">ID</th>
                            <th style="color: #17a2b8;">Full Name</th>
                            <th style="color: #17a2b8;">User Name</th>
                            <th style="color: #17a2b8;">Password</th>
                            <th style="color: #17a2b8;">Action</th>
                        </tr>
                    </thead>
                    
                </table>

            </div>
        </div>
        
    </div>

</div>

<!-- Modal -->

<div class="modal fade" id="AddNewBinModal" tabindex="-1" role="dialog" aria-labelledby="AddNewBinModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-color:#265a88;border-width: 2px;">
      <form class="form-horizontal" action="{{url('/AddBin')}}" method="POST" auto-compelet="off" id="submitBinForm">
      {{csrf_field()}}
      <div class="modal-header" style="background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);">
         <h4 class="modal-title" id="AddNewBinModalLabel" style="color: #fff;"><i class="fa fa-plus"></i>  Add new Bin</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        

    
    
        <div class="form-group">
            <label for="txtBinName">Bin Name</label>
            <input type="text" class="form-control" name="txtBinName" id="txtBinName" required>
        </div>
        <div class="form-group">
            <label for="txtLocaton">Location</label>
            <input type="text" class="form-control" name="txtLocaton" id="txtLocaton" required>
        </div>
        <div class="form-group">
            <label for="txtBinID">Bin ID</label>
            <input type="text" class="form-control" name="txtBinID" id="txtBinID" required>
        </div>
    

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-defult" data-dismiss="modal"><i class="fa fa-close"></i> close </button>
        <button form="submitBinForm" type="submet"   class="btn btn-info"><i class="fa fa-plus"></i>  Add Bin </button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade"  id="AssignBinModel" tabindex="-1" role="dialog" aria-labelledby="AssignBinModel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-color:#265a88;border-width: 2px;">
     
      <div class="modal-header" style="background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);">
         <h4 class="modal-title" id="AddNewBinModalLabel" style="color: #fff;"><i class="fa fa-tasks"></i>  Assign a bin</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form class="form-horizontal" action="{{url('/AssignBin')}}" method="POST" auto-compelet="off" id="AssignBinForm">
            {{csrf_field()}}
          <div class="form-group row">
              
                    <label for="cbxBins" class="col-sm-2 col-form-label">Bins</label>
                    <div class="col-sm-7">
                    <select class="custom-select" id="cbxBins" required>
                      <option selected disabled value="">Choose...</option>
                    </select>
                    </div>
              <button form="AssignBinForm" type="submet" class="btn btn-info col-sm-2" style="margin-right:2px;" id="AssignBinBtn"><i class="fa fa-plus"></i> Assign </button>
              </div>
        </form>
       
          <table id="AssignBinsTable" class="display responsive nowrap" style="width:100%" >
                    <thead>
                        <tr>
                            <th style="color: #17a2b8;">Name</th>
                            <th style="color: #17a2b8;">Location</th>
                            <th style="color: #17a2b8;">BinID</th>
                            <th style="color: #17a2b8;">Action</th>
                        </tr>
                    </thead>
                    
                </table>

      </div>
      <div class="modal-footer AssignBinsFooter">
        <button type="button" class="btn btn-defult" data-dismiss="modal"><i class="fa fa-close"></i> close </button>
        
      </div>
    </div>
  </div>
</div>

<div class="modal fade"  id="ViewBinModel" tabindex="-1" role="dialog" aria-labelledby="ViewBinModel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-color:#265a88;border-width: 2px;">
     
      <div class="modal-header" style="background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);">
         <h4 class="modal-title" id="AddNewBinModalLabel" style="color: #fff;"><i class="fa fa-eye"></i>  View Bins</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
                <table id="ViewTable" class="display responsive nowrap" style="width:100%" >
                    <thead>
                        <tr>
                            <th style="color: #17a2b8;">Name</th>
                            <th style="color: #17a2b8;">Location</th>
                            <th style="color: #17a2b8;">Status</th>
                        </tr>
                    </thead>
                    
                </table>

      </div>
      <div class="modal-footer ViewFooter">
        <button type="button" class="btn btn-defult" data-dismiss="modal"><i class="fa fa-close"></i> close </button>
        
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="AddNewCleanerModal" tabindex="-1" role="dialog" aria-labelledby="AddNewCleanerModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-color:#265a88;border-width: 2px;">
      <form class="form-horizontal" action="{{url('/AddCleaner')}}" method="POST" auto-compelet="off" id="submitCleanerForm">
      {{csrf_field()}}
      <div class="modal-header" style="background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);">
         <h4 class="modal-title" id="AddNewCleanerModalLabel" style="color: #fff;"><i class="fa fa-plus"></i>  Add new Cleaner</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        

    
    
        <div class="form-group">
            <label for="txtFullName">Full Name</label>
            <input type="text" class="form-control" name="txtFullName" id="txtFullName" required>
        </div>
        <div class="form-group">
            <label for="txtUserName">User Name</label>
            <input type="text" class="form-control" name="txtUserName" id="txtUserName" required>
        </div>
        <div class="form-group">
            <label for="txtPassword">Password</label>
            <input type="password" class="form-control" name="txtPassword" id="txtPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"required>
        </div>
    

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-defult" data-dismiss="modal"><i class="fa fa-close"></i> close </button>
        <button form="submitCleanerForm" type="submet"   class="btn btn-info"><i class="fa fa-plus"></i>  Add Cleaner </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- _________________________- -->

<div class="modal fade" id="updateCleanerModel" tabindex="-1" role="dialog" aria-labelledby="updateCleanerModel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-color:#419641;border-width: 2px;">
      <form class="form-horizontal" action="{{url('/EditCleaner')}}" method="POST" auto-compelet="off" id="submitEditCleanerForm">
      {{csrf_field()}}
      <div class="modal-header" style="background-image: linear-gradient(to bottom,#5cb85c 0,#419641 100%);">
         <h4 class="modal-title" id="EditCleanerModalLabel" style="color: #fff;"><i class="fa fa-edit"></i>  Update Cleaner</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        

    
    
        <div class="form-group">
            <label for="txtFullName">Full Name</label>
            <input type="text" class="form-control" name="EtxtFullName" id="EtxtFullName" required>
        </div>
        <div class="form-group">
            <label for="txtUserName">User Name</label>
            <input type="text" class="form-control" name="EtxtUserName" id="EtxtUserName" required >
        </div>
        <div class="form-group">
            <label for="txtPassword">Password</label>
            <input type="password" class="form-control" name="EtxtPassword" id="EtxtPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"required>
        </div>
    

      </div>
      <div class="modal-footer updateCleanerfooter">
        <button type="button" class="btn btn-defult" data-dismiss="modal"><i class="fa fa-close"></i> close </button>
        <button form="submitEditCleanerForm" type="submet" class="btn btn-success"  id="updateCleanerBtn"><i class="fa fa-edit"></i> Update Cleaner </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- _________________________- -->

<div class="modal fade" id="deleteCleanerModel" tabindex="-1" role="dialog" aria-labelledby="deleteCleanerModel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-color:#c12e2a;border-width: 2px;">
      
      <div class="modal-header" style="background-image:  linear-gradient(to bottom,#d9534f 0,#c12e2a 100%);">
         <h4 class="modal-title" id="EditCleanerModalLabel" style="color: #fff;"><i class="fa fa-trash"></i>  delete Cleaner</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        

    <p>Are sure you want to delete this cleaner ?</p>
   

      </div>
      <div class="modal-footer DeleteCleanerfooter">
        <button type="button" class="btn btn-defult deleteCleanerCancelBtn"  data-dismiss="modal"><i class="fa fa-close"></i> close </button>
        <button  type="submet" class="btn btn-danger"  id="DeleteCleanerBtn"><i class="fa fa-trash"></i> Delete Cleaner </button>
     
      </div>
    </div>
  </div>
</div>

<script src="{{asset('js/CustomeJs/Cleaners.js')}}"></script>      
<script src="{{asset('js/CustomeJs/Bin.js')}}"></script>      
 <script type="text/javascript">
   var CleanesTable ;
   var ManageAssignedBins;
   var ManageView;
  $(function(){
    
     CleanesTable = $('#CleanesTable').DataTable({
             rowReorder: {
            selector: 'td:nth-child(4)'
        },
               processing: true,
               serverSide: false,
                "info":     false,
                "paging":   false,
                 "ordering": false,
                "searching":     false, 
               "order": [[ 0, "asc" ], [ 4, "desc" ]],
               ajax: {
                 "url" :'{!! route('get.cleaners') !!}',
                  "type": "get"},
               columns : [
                { data: 'id', name: 'id' },
                { data: 'FullName', name: 'FullName' },
                { data: 'UserName', name: 'UserName' },
                { data: 'Passwrod', name: 'Passwrod' },
                {data: 'action', name: 'action', orderable: false, searchable: false}
        
               ]
         
             });
  });

  function openAssign(){
  
  
    var formData = {
                     Personid : $("#Personid").val(),
                     _token : $('meta[name="csrf-token"]').attr('content') 
                }
           
      
          if ( ! $.fn.DataTable.isDataTable( '#AssignBinsTable' ) ) {
          ManageAssignedBins =   $('#AssignBinsTable').DataTable({
                        "paging":   false,
                        "ordering": false,
                        "info":     false,
                        "searching":     false,
                          processing: true,
                          serverSide: false,
                         "order": [[ 1, "asc" ],[ 0, "desc" ]],
                          ajax: {
                            "url" :'{!! route('get.getAssignedBinsData') !!}',
                            "type": "get",
                            "data":formData},
                          columns : [
                            { data: 'BinName', name: 'BinName' },
                            { data: 'Locaton', name: 'Locaton' },
                            { data: 'BinCode', name: 'BinCode' },
                            {data: 'action', name: 'action', orderable: false, searchable: false}
                            ]

                        });
                        $('#AssignBinModel').trigger('click');
          }
      else{
        
        ManageAssignedBins.destroy();
       
        ManageAssignedBins =   $('#AssignBinsTable').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching":     false,    
        processing: true,
        serverSide: false,
        "order": [[ 1, "asc" ],[ 0, "desc" ]],
        ajax: {
          "url" :'{!! route('get.getAssignedBinsData') !!}',
          "type": "get",
          "data":formData},
        columns : [
            { data: 'BinName', name: 'BinName' },
            { data: 'Locaton', name: 'Locaton' },
            { data: 'BinCode', name: 'BinCode' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
            ]

      });
            $('#AssignBinModel').trigger('click');
      }
  }  

 function openView(){
  
  
    var formData = {
                     Personid : $("#Personid").val(),
                     _token : $('meta[name="csrf-token"]').attr('content') 
                }
          
      
          if ( ! $.fn.DataTable.isDataTable( '#ViewTable' ) ) {
          ManageView =   $('#ViewTable').DataTable({
                        "paging":   false,
                        "ordering": false,
                        "info":     false,
                        "searching":     false,
                          processing: true,
                          serverSide: false,
                         "order": [[ 1, "asc" ],[ 0, "desc" ]],
                          ajax: {
                            "url" :'{!! route('get.getViewData') !!}',
                            "type": "get",
                            "data":formData},
                          columns : [
                            { data: 'BinName', name: 'BinName' },
                            { data: 'Locaton', name: 'Locaton' },
                              { data: 'BinStatus', name: 'BinStatus' ,"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
              
                                  if(sData == 0){
                                      $(nTd).empty();$(nTd).append("<div class='progress'><div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: "+sData+"%' aria-valuenow='"+sData+"' aria-valuemin='0' aria-valuemax='100'></div><b>Empty</b></div>");
                                  }else if(sData <= 50){
                                      $(nTd).empty();$(nTd).append("<div class='progress'><div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: "+sData+"%' aria-valuenow='"+sData+"' aria-valuemin='0' aria-valuemax='100'><b>"+sData+"%</b></div></div>");
                                  }else if(sData > 50 && sData <= 80){
                                      $(nTd).empty();$(nTd).append("<div class='progress'><div class='progress-bar progress-bar-striped bg-warning' role='progressbar' style='width: "+sData+"%' aria-valuenow='"+sData+"' aria-valuemin='0' aria-valuemax='100'><b>"+sData+"%</b></div></div>");
                                  }else if(sData > 80 && sData <= 100){
                                      $(nTd).empty();$(nTd).append("<div class='progress'><div class='progress-bar progress-bar-striped bg-danger' role='progressbar' style='width: "+sData+"%' aria-valuenow='"+sData+"' aria-valuemin='0' aria-valuemax='100'><b>"+sData+"%</b></div></div>");
                                  }
                                }
                              
                                }
                            ]

                        });
                        $('#ViewBinModel').trigger('click');
          }
      else{
        
        ManageView.destroy();
        
        ManageView =   $('#ViewTable').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false, 
        "searching":     false,   
        processing: true,
        serverSide: false,
        "order": [[ 1, "asc" ],[ 0, "desc" ]],
        ajax: {
          "url" :'{!! route('get.getViewData') !!}',
          "type": "get",
          "data":formData},
        columns : [
            { data: 'BinName', name: 'BinName' },
            { data: 'Locaton', name: 'Locaton' },
            { data: 'BinStatus', name: 'BinStatus' ,"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {

                if(sData == 0){
                    $(nTd).empty();$(nTd).append("<div class='progress'><div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: "+sData+"%' aria-valuenow='"+sData+"' aria-valuemin='0' aria-valuemax='100'></div><b>Empty</b></div>");
                }else if(sData <= 50){
                    $(nTd).empty();$(nTd).append("<div class='progress'><div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: "+sData+"%' aria-valuenow='"+sData+"' aria-valuemin='0' aria-valuemax='100'><b>"+sData+"%</b></div></div>");
                }else if(sData > 50 && sData <= 80){
                    $(nTd).empty();$(nTd).append("<div class='progress'><div class='progress-bar progress-bar-striped bg-warning' role='progressbar' style='width: "+sData+"%' aria-valuenow='"+sData+"' aria-valuemin='0' aria-valuemax='100'><b>"+sData+"%</b></div></div>");
                }else if(sData > 80 && sData <= 100){
                    $(nTd).empty();$(nTd).append("<div class='progress'><div class='progress-bar progress-bar-striped bg-danger' role='progressbar' style='width: "+sData+"%' aria-valuenow='"+sData+"' aria-valuemin='0' aria-valuemax='100'><b>"+sData+"%</b></div></div>");
                }
              }

              }
            ]

      });
            $('#ViewBinModel').trigger('click');
      }
  } 

  
  
</script>
@stack('scripts')
 

@endsection