<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }

    public function report()
    {
        return view('reports');
    }

    public function spacereport1(){
         
        $space_type="list";
        echo $space_type;
    }

    public function spacereport1PDF(){
       
        $pdf = PDF::loadView('spacereport1pdf');
  
        return $pdf->stream('List of Spaces.pdf');
      }
      
    
}
