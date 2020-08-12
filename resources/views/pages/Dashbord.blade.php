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
            </div>
            <div class="card-body">
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
        </div>
        
    </div>


</div>

 



<script src="{{asset('js/CustomeJs/Cleaners.js')}}"></script>      
<script src="{{asset('js/CustomeJs/Bin.js')}}"></script>      
 <script type="text/javascript">
   var ManageView;
  $(function(){
    
       var formData = {
                     Personid : $('#Personid').val(),
                     _token : $('meta[name="csrf-token"]').attr('content') 
                }
            //console.log(formData);
      
          
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
  });

  
</script>
@stack('scripts')
 

@endsection