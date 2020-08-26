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
         
         return view('reports');
    }

    public function spacereport1PDF(){
       
        $pdf = PDF::loadView('spacereport1pdf');
  
        return $pdf->stream('List of Spaces.pdf');
      }

      public function spacereport2PDF(){
       
        $pdf = PDF::loadView('spacereport2pdf');
  
        return $pdf->stream('Spaces History.pdf');
      }

      public function insurancereportPDF(){
       if($_GET['report_type']=='sales'){
        $pdf = PDF::loadView('insurancereportpdf')->setPaper('a4', 'landscape');
    }
    else{
        $pdf = PDF::loadView('insurancereportpdf');
    }
  
        return $pdf->stream('Insurance Report.pdf');
      }

      public function tenantreportPDF(){
        if($_GET['report_type']=='list'){
           $pdf=PDF::loadView('tenantreportpdf')->setPaper('a4', 'landscape');
           return $pdf->stream('Tenant Report.pdf');
        }
        elseif($_GET['report_type']=='invoice'){
          $pdf=PDF::loadView('tenantreportpdf')->setPaper('a4', 'landscape');;
           return $pdf->stream('Tenant Invoice Report.pdf');
        }
       
      }

      public function carreportPDF(){
        // if($_GET['report_type']=='clients'){
        //  $pdf=PDF::loadView('carreportpdf')->setPaper('a4', 'landscape');   
        // }
        // else{
        //    $pdf=PDF::loadView('carreportpdf'); 
        // }
        $pdf=PDF::loadView('carreportpdf');
        return $pdf->stream('Car Rental Report.pdf');
      }

      public function carreportPDF2(){
         $pdf=PDF::loadView('operationalreportpdf')->setPaper('a4', 'landscape');    
         return $pdf->stream('Car Rental Operational Report.pdf');
      }

      public function carreportPDF3(){
        $pdf=PDF::loadView('carhistoryreportpdf');    
         return $pdf->stream('Car History Report.pdf');
      }    

      public function contractreportPDF(){
        $pdf=PDF::loadView('contractreportpdf')->setPaper('a4', 'landscape');
        return $pdf->stream('Contract Report.pdf');
      }
      
      public function invoicereportPDF(){
        $pdf=PDF::loadView('invoicereportpdf')->setPaper('a4', 'landscape');
        return $pdf->stream('Invoice Report.pdf');
      }
    
}
