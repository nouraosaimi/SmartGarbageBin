<?php

namespace App\Http\Controllers;

use App\loginM;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use validator;
use Session;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;


class CleanersController extends Controller
{
    public function Index()
    {
         if(Session::get('state') == "true")
        {
        
            return view('pages.Cleaners');
        }
        else
        {
            return redirect('/signin'); 
        }
    }
    public function openDashboard()
    {
          if(Session::get('state') == "true")
        {
            return view('pages.Dashbord'); 
        }
        else
        {
            return redirect('/signin'); 
        }
    }

    
     public function login()
    {
        
             return view('pages.index');

        
    }


     public function successLogin(Request $request)
        {

            if($request->input('txtUserName') == "admin" && $request->input('txtPassword') == "admin"){
                Session(['FullName' => 'admin']);
                Session(['UserID' => '0']);
                Session(['state' => "true"]);
               
                
                $response_data = [ 'success' => true, 'msg' => '/Cleaners'];
                    return response()->json($response_data);
            }
            //admin
            else{
            $User = DB::table('Cleaner')->where('UserName',$request->input('txtUserName'))->where('Passwrod',$request->input('txtPassword'))->first();
                if(isset($User)){
                
                Session(['FullName' => $User->FullName]);
                Session(['UserID' => $User->id]);
                Session(['state' => "true"]);
               
                $response_data = [ 'success' => true, 'msg' => '/Dashboard'];
                    return response()->json($response_data);


                }else{
                    $response_data = [ 'success' => true, 'msg' => 'Wrong User Name or Password !'];
                    return response()->json($response_data);
                }
            }
            
        }

    public function Logout()
    {
        Session(['state' => "false"]);
        return view('pages.index');
    }


    
    

    //method to add cleaner
    public function Add(Request $request){
        
       $id = 0;
       $id = DB::table('Cleaner')->insertGetId([
           'FullName' => $request->input('txtFullName'),
           'UserName' =>  $request->input('txtUserName'),
           'Passwrod' =>  $request->input('txtPassword'),
           
             
       ]);
        
       if(isset($id) )
       {
           
           $response_data = [ 'success' => true, 'msg' => 'New Cleaner added succefully'];
           return response()->json($response_data);
           
       }
       else
       {
           return response()->json(['success' => false, 'msg' =>'Erorr']);
           
       } 
     }

      public function getData(){
        $Cleaner = DB::table('Cleaner')->get();
            
        
            return Datatables::of($Cleaner)
            ->addColumn('action', function ($Cleaner) {
                return '<button  type="button" data-toggle="modal" data-target="#updateCleanerModel" title="Edit" onclick="updateCleaner('.$Cleaner->id.')" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> </button> '.
                '<button    type="button" data-toggle="modal" data-target="#deleteCleanerModel" title="delete" onclick="DeleteCleaner('.$Cleaner->id.')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>'.
                 '<button    type="button" data-toggle="modal" data-target="#AssignBinModel" title="assign Bins" onclick="AssignBin('.$Cleaner->id.')" class="btn btn-xs btn-info" style="margin-left :5px;"><i class="fa fa-tasks"></i></button>'.
                 '<button    type="button" data-toggle="modal" data-target="#ViewBinModel" title="view" onclick="ViewBins('.$Cleaner->id.')" class="btn btn-xs btn-warning" style="margin-left :5px;"><i class="fa fa-eye"></i></button>';
            })->make(true);
    }

     public function GetCleanerID(Request $request)
     {
            $cleaner =DB::table("Cleaner")->where('id',$request->input('CleanerID'))->first();
            $response_data = [ 'success' => true, 'Cleaner' => $cleaner];
            return response()->json($response_data);
     }

      public function EditeCleaner(Request $request){

        $id = 0;
       $id = DB::table('Cleaner')->where('id',$request->input('CleanerID'))->update([
                              'FullName' => $request->input('txtFullName'),
                              'UserName' =>  $request->input('txtUserName'),
                              'Passwrod' =>  $request->input('txtPassword'),
                             
                      ]);

                      if($id > 0)
                      {
                          $response_data = [ 'success' => true, 'msg' => 'Cleaner Updated succefully'];
                          return response()->json($response_data);
                        
                      }
                      else
                      {
                          return response()->json(['success' => false, 'msg' =>'Erorr']);
                         
                      }
     }


   public function deleteCleaner(Request $request){
       $id = 0;
       $id = DB::table('Cleaner')->where('id',$request->input('CleanerID'))->delete();

        if($id > 0)
        {
            $response_data = [ 'success' => true, 'msg' => 'Cleaner Deleted succefully'];
            return response()->json($response_data);
            
        }
        else
        {
            return response()->json(['success' => false, 'msg' =>'Erorr']);
            
        }
     }
     

}
