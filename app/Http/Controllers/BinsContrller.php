<?php

namespace App\Http\Controllers;
use App\loginM;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use validator;
use Session;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class BinsContrller extends Controller
{
    
     public function Add(Request $request){
        
       $id = 0;
       $id = DB::table('Bins')->insertGetId([
           'BinName' => $request->input('txtBinName'),
           'Locaton' =>  $request->input('txtLocaton'),
           'BinID' =>  $request->input('txtBinID'),
          
             
       ]);
        
       if(isset($id) )
       {
           
           $response_data = [ 'success' => true, 'msg' => 'New Bin added succefully'];
           return response()->json($response_data);
           
       }
       else
       {
           return response()->json(['success' => false, 'msg' =>'Erorr']);
           
       } 
     }

     public function getAssignedBinsData(Request $request)
        {
            $Bins = DB::table('CleanersBinsVw')->where('CleanerID',$request->input('Personid'))->get();
            if(isset($Bins)){
                return Datatables::of($Bins)
                ->addColumn('action', function ($Bins) {
                    return '  <button    type="button"  title="Delete Bin" onclick="DeleteAssinedBins('.$Bins->id.')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>  ' ;
                })->make(true);
            }
        }
         public function getViewData(Request $request)
        {
            $Bins = DB::table('CleanersBinsVw')->where('CleanerID',$request->input('Personid'))->get();
            if(isset($Bins)){
                return Datatables::of($Bins)->make(true);;
            }
        }


        

    public function AssignBin(Request $request){
        

        
       $Bins = DB::table('CleanersBins')->where('CleanerID',$request->input('Personid'))->where('BinID',$request->input('cbxBins'))->count();
            if($Bins > 0){
                $response_data = [ 'success' => true, 'msg' => 'This bin is already assigned'];
                return response()->json($response_data);
            }


       $id = 0;
       $id = DB::table('CleanersBins')->insertGetId([
           'CleanerID' => $request->input('Personid'),
           'BinID' =>  $request->input('cbxBins'),
          
       ]);
        
       if(isset($id) )
       {
           
           $response_data = [ 'success' => true, 'msg' => 'New Bin Assigned succefully'];
           return response()->json($response_data);
       }
       else
       {
           return response()->json(['success' => false, 'msg' =>'Erorr']);
       } 
     }

     public function GetAllBins(){
        $Bins = DB::table('Bins')->get();
        
       if(isset($Bins) )
       {
           
           $response_data = [ 'success' => true, 'msg' => 'New Bin Assigned succefully','Bins'=>$Bins];
           return response()->json($response_data);
       }
       else
       {
           return response()->json(['success' => false, 'msg' =>'Erorr']);
       } 
     }

public function DeleteAssinedBins(Request $request){
       $id = 0;
       $id = DB::table('CleanersBins')->where('id',$request->input('Personid'))->delete();

        if($id > 0)
        {
            $response_data = [ 'success' => true];
            return response()->json($response_data);
            
        }
        else
        {
            return response()->json(['success' => false, 'msg' =>'Erorr']);
            
        }
     }

     public function CheckAssignedBins(Request $request){
       
       
        
       $id = DB::table('CleanersBins')->where('CleanerID',$request->input('Personid'))->where('BinID',$request->input('cbxBins'))->count();
        


            $response_data = [ 'success' => true,'msg'=>"".$id];
            return response()->json($response_data);
           


     }

     

     
}
