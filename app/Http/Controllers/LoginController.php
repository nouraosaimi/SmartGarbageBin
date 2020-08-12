<?php

namespace App\Http\Controllers;

use App\loginM;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use validator;
use Session;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function successLogin()
    {
         return view('pages.login');
    }
}
