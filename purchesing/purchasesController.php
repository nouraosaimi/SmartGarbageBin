<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use validator;
use Session;
use Yajra\Datatables\Datatables;

class purchasesController extends Controller
{
            public function index()
                    {
                        if(Session::get('state') == "true")
                        {
                            $funds = DB::table('funds')->where('Status',1)->get();
                            $fundsCurrancies = null;
                            $CurrancyInfo = null;
                            $CurrancyExchange = null ;
                        // $fundNames = array();
                            if(!$funds->isEmpty()){
                                $fundsCurrancies = DB::table('fundaccountsvw')->where('id',$funds->first()->id)->where('Status','مفعل')->get();
                                if(!$fundsCurrancies->isEmpty()){
                                    $CurrancyInfo = DB::table('Currencies')->where('id',$fundsCurrancies->first()->CurrancyId)->first();
                                }
                            }
                            //$Banks = DB::table('Banks')->where('Status',1)->get();
                            $Curancies = DB::table('Currencies')->where('State',1)->get();
                            if(!$Curancies->isEmpty()){$CurrancyExchange = $Curancies->first()->Exchange;}
                            
                            $Banks = DB::table('banks')->where('Status',1)->get();
                            $BanksCurrancies = null;
                            $BankCurrancyInfo = null;
                            if(!$Banks->isEmpty()){
                                $BanksCurrancies = DB::table('bankaccountsvw')->where('id',$Banks->first()->id)->where('Status','مفعل')->get();
                                if(!$BanksCurrancies->isEmpty()){
                                    $BankCurrancyInfo = DB::table('Currencies')->where('id',$BanksCurrancies->first()->CurrancyId)->first();
                                }
                            }
                            $Inventeories = DB::table('Inventory')->where('Stata',1)->get();

                            return view('pages.Purchases',compact(['Inventeories','Banks','BanksCurrancies','BankCurrancyInfo','funds','fundsCurrancies','CurrancyInfo','Curancies','CurrancyExchange']));
                        }
                        else
                        {
                            return redirect('/login');
                        }
                    }

                    public function gatPurschingSupplierData()
                    {
                        $Suppliser = DB::table('supplier')->get();
                        return Datatables::of($Suppliser)
                            ->addColumn('action', function ($Suppliser) {
                                return '<button  type="button"  title="انزال البيانات" onclick="selectSupplier('.$Suppliser->id.',\''.$Suppliser->Name.'\')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-download-alt"></i> </button>' ;
                                //return '<button type="button"    title="أنزال بيانات" onclick="selectSupplier('. $Suppliser->id .','. $Suppliser->Name .' )" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> </button> ' ;
                            })->make(true);
                    }
                    public function gatPurschingDistributorData(Request $request)
                    {
                        $Distributor = DB::table('Distributor')->where('SupplierId',$request->input('supID'))->get();
                        if(!$Distributor->isEmpty()){
                            $response_data = [ 'success' => true,'Distributor' => $Distributor];
                            return response()->json($response_data);
                        // $Notfound = false ;
                        }
                        else{
                            $response_data = [ 'success' => false];
                            return response()->json($response_data);
                        }
                        
                    }

                    public function GetProductsSearch(Request $request)
                    {
                        $products = DB::table('productsvw')->get();
                        if(!$products->isEmpty()){
                            return Datatables::of($products)
                            ->addColumn('action', function ($products) {
                                return '<button  type="button"  title="انزال البيانات" onclick="getProductsUnits('.$products->Barcode.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-download-alt"></i> </button>' ;
                                //return '<button type="button"    title="أنزال بيانات" onclick="selectSupplier('. $Suppliser->id .','. $Suppliser->Name .' )" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> </button> ' ;
                            })->make(true);
                        // $Notfound = false ;
                        }
                        
                    }

                    

            public function getProductUnitsData(Request $request)
                    {
                        $product = DB::table('products')->where('Barcode',$request->input('Pid'))->first();
                        if(isset($product)){
                            $PUnits = DB::table('productunitsvw')->where('id',$product->id)->get();
                            return Datatables::of($PUnits)
                            ->addColumn('action', function ($PUnits) {
                                return '<button  type="button"  title="انزال البيانات" onclick="selectUnit('.$PUnits->CurrentUnitId.','.$PUnits->id.',\''.$PUnits->CurrentUnit.'\',\''.$PUnits->Name.'\',\''.$PUnits->HasExDate.'\')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-download-alt"></i> </button>' ;
                            })->make(true);
                        // $Notfound = false ;
                        }
                        else{
                            $response_data = [ 'success' => true, 'Notfound' => true];
                            return response()->json($response_data);
                        }
                        
                        
                    }
            public function checkParcod(Request $request)
                    {
                        $product = DB::table('products')->where('Barcode',$request->input('BarCode'))->first();
                        if(isset($product) && $product->Stata == 1){
                            $response_data = [ 'success' => true,'Notfound' => true];
                            return response()->json($response_data);
                        }
                        else{
                            if(isset($product) && $product->Stata == 2)
                            {
                                $response_data = [ 'success' => false, 'Notfound' => 2];
                                return response()->json($response_data);
                            }
                            else{
                                $response_data = [ 'success' => false, 'Notfound' => false];
                                return response()->json($response_data);
                            }
                            
                        }
                    }

            public function getfundCurrancies(Request $request)
                    {
                        $fundsCurrancies = DB::table('fundsandcurranciesandexvw')->where('id',$request->input('option'))->where('StatusID',1)->get();
                        if(!$fundsCurrancies->isEmpty()){
                            $response_data = [ 'success' => true,'fundsCurrancies' => $fundsCurrancies , 'Exchange' => $fundsCurrancies->first()->Exchange ];
                            return response()->json($response_data);
                        }else{
                            $response_data = [ 'success' => false];
                            return response()->json($response_data);
                        }
                    }
            public function getCurrancyExchange(Request $request)
            {
                $CurrancyExchange = DB::table('Currencies')->where('id',$request->input('option'))->get();
                if(!$CurrancyExchange->isEmpty()){
                    $response_data = [ 'success' => true, 'Exchange' => $CurrancyExchange->first()->Exchange ];
                    return response()->json($response_data);
                }else{
                    $response_data = [ 'success' => false];
                    return response()->json($response_data);
                }
            }
            public function getBankCurrancies(Request $request)
                    {
                        $BankCurrancies = DB::table('BanksAndCurranciesAndExvw')->where('id',$request->input('option'))->where('StatusID',1)->get();
                        if(!$BankCurrancies->isEmpty()){
                            $response_data = [ 'success' => true,'BankCurrancies' => $BankCurrancies , 'Exchange' => $BankCurrancies->first()->Exchange ];
                            return response()->json($response_data);
                        }else{
                            $response_data = [ 'success' => false];
                            return response()->json($response_data);
                        }
                    }
                    public function getBillAutoNumber()
                    {
                        $oldId = DB::table('SupplierBills')->orderBy('id','desc')->first();
                        if(isset($oldId)){
                            $newID = $oldId->id+1;
                            $response_data = [ 'success' => true,'newID' => $newID];
                            return response()->json($response_data);
                        }else{

                            $response_data = [ 'success' => true,'newID'=>1];
                            return response()->json($response_data);
                        }
                    }
                    public function Addbill(Request $request){

                        
                       $id = 0; 
                       $id = DB::table('SupplierBills')->insert([
                           'id' => $request->input('BillNumber'),
                           'status' =>  $request->input('Billstatus'),
                           'SupplierID' =>  $request->input('SupplierId'),
                           'DistributorId' =>  $request->input('DistributorId'),
                           'BillItemsCount' =>  $request->input('billItems'),
                           'TotalPrice' =>  $request->input('BillTotalPrice'),
                           'DiscontAmount' =>  $request->input('billAmountDiscount'),
                           'DicountPer' =>  $request->input('billPreDiscount'),
                           'BillDiscount' =>  $request->input('Billdescount'),
                           'PaidType' =>  $request->input('billPaidType'),
                           'fundId' =>  $request->input('fundId'),
                           'PaidCash' =>  $request->input('PaidCash'),
                           'paidCashCurrancy' =>  $request->input('paidCashCurrancy'),
                           'paidCashExchange' =>  $request->input('paidCashExchange'),
                           'BankId' =>  $request->input('Bankid'),
                           'paidCheckCurrancy' =>  $request->input('paidCheckCurrancy'),
                           'paidCheckExchange' =>  $request->input('paidCheckExchange'),
                           'checkNumber' =>  $request->input('paidCheckNo'),
                           'PaidCheck' =>  $request->input('paidCheckAmount'),
                           'CreditCurrancy' =>  $request->input('paidCreditCurrancy'),
                           'CreditExchange' =>  $request->input('paidCreditExchange'),
                           'Remaining' =>  $request->input('Remaining'),
                           'BillReference' =>  $request->input('BillReference'),
                           'Details' =>  $request->input('Details'),
                           'DataEntry' =>  Session::get('CurentUserId'),
                           "created_at" =>  \Carbon\Carbon::now()
                       ]);
                        
                       if($id > 0 )
                       {
                        
                        $BillProductsDetails =  $request->input('BillProductsDetails');
                        unset($BillProductsDetails[0]);
                         $productCount = count($BillProductsDetails);
                         $inserted = 0 ;                        
                        for($i = 1 ; $i <= $productCount ;$i++ ){
                            $ProductAdd = DB::table('SupplierBillsDetails')->insert([
                                            'Bid' => $BillProductsDetails[$i]['billId'],
                                            'Pid' =>  $BillProductsDetails[$i]['productID'],
                                            'PUnit'=> $BillProductsDetails[$i]['unitId'],
                                            'Quantity' =>  $BillProductsDetails[$i]['Quantity'],
                                            'price' =>  $BillProductsDetails[$i]['price'],
                                            'totalPrice' => $BillProductsDetails[$i]['Totalprice'],
                                            'ExDate' =>  $BillProductsDetails[$i]['exdate']
                                        ]);
                                        $inserted +=1;
                        }
                        if($inserted == $productCount)
                        {
                            $response_data = [ 'success' => true, 'messages' => 'تم اضافة الفاتورة بنجاح'];
                            return response()->json($response_data);
                               
                        }
                       
                           
                           //return redirect('/usersManagement')->with('success', 'تم اضافة المستخدم بنجاح ');
                       }
                       else
                       {
                           return response()->json(['success' => false, 'messages' =>'خطاء في عملية الاضافة']);
                       }
                     
            
    
            
            

   
                }


            }