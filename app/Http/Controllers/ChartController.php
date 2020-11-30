<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\insurance_contract;
use App\Charts\SampleChart;
Use App\carContract;
use App\space_contract;
use DB;
use Auth;
use App\cost_centre;
use Response;
use \RecursiveIteratorIterator;
use \RecursiveArrayIterator;

class ChartController extends Controller
{
    //

    function chartSetAxes($xAxes, $yAxes, $showXaxis = true, $showYaxis = true)
    {
        $axesArray = [
            'xAxes' =>
            [
                [
                    'scaleLabel' =>
                    [
                        'display' => $showXaxis,
                        'labelString' => $xAxes,
                    ],
                ]
            ],

            'yAxes' =>
            [
                [
                    'scaleLabel' =>
                    [
                        'display' => $showYaxis,
                        'labelString' => $yAxes,
                    ],
                ]
            ],


        ];

        return $axesArray;
    }

    public function udiaindex(){
         $year=date('Y');
        $data1 = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data1->push(insurance_contract::select('id')
                    ->whereYear('commission_date', date('Y'))
                    ->whereMonth('commission_date',$days_backwards)
                    //->groupBy(\DB::raw("Month(commission_date)"))
                    ->count());
    }

        $chart = new SampleChart;
        $chart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart->title("Cover Note Sales Activities $year");
        $chart->options(['scales' => self::chartSetAxes('Month','Total Activities')]);
        $chart->dataset('Insurance Covers Sold', 'bar', $data1)->options([
            'fill' => 'true',
            'borderColor' => '#6cb2eb',
            "borderWidth"=>2,
            "backgroundColor"=>'#6cb2eb'
        ]);

        $UDIA_income = collect([]);
        $UDIA_income_motor = collect([]);
        $UDIA_income_fire = collect([]);
        $UDIA_income_fidelity = collect([]);
        $UDIA_income_marine = collect([]);
        $UDIA_income_prof = collect([]);
        $UDIA_income_public = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income->push(DB::table('insurance_invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
        ->whereMonth('invoicing_period_start_date',$days_backwards)
         ->where('payment_status','Paid')
          ->whereYear('invoicing_period_start_date',date('Y'))
        ->groupBy('month')
        ->pluck('total'));
    }

     for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income_fire->push(DB::table('insurance_contracts')
        ->select(array(DB::raw('Month(commission_date) as month'),DB::raw('sum(premium) as total')))
        ->whereMonth('commission_date',$days_backwards)
        ->whereYear('commission_date',date('Y'))
        ->where('insurance_class','FIRE')
        ->groupBy('month')
        ->pluck('total'));
    }

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income_fidelity->push(DB::table('insurance_contracts')
        ->select(array(DB::raw('Month(commission_date) as month'),DB::raw('sum(premium) as total')))
        ->whereMonth('commission_date',$days_backwards)
        ->whereYear('commission_date',date('Y'))
        ->where('insurance_class','FIDELTY GUARANTEE')
        ->groupBy('month')
        ->pluck('total'));
    }

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income_motor->push(DB::table('insurance_contracts')
        ->select(array(DB::raw('Month(commission_date) as month'),DB::raw('sum(premium) as total')))
        ->whereMonth('commission_date',$days_backwards)
        ->whereYear('commission_date',date('Y'))
        ->where('insurance_class','MOTOR')
        ->groupBy('month')
        ->pluck('total'));
    }

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income_marine->push(DB::table('insurance_contracts')
        ->select(array(DB::raw('Month(commission_date) as month'),DB::raw('sum(premium) as total')))
        ->whereMonth('commission_date',$days_backwards)
        ->whereYear('commission_date',date('Y'))
        ->where('insurance_class','MARINE HULL')
        ->groupBy('month')
        ->pluck('total'));
    }

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income_prof->push(DB::table('insurance_contracts')
        ->select(array(DB::raw('Month(commission_date) as month'),DB::raw('sum(premium) as total')))
        ->whereMonth('commission_date',$days_backwards)
        ->whereYear('commission_date',date('Y'))
        ->where('insurance_class','PROFFESIONAL INDEMNITY')
        ->groupBy('month')
        ->pluck('total'));
    }

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income_public->push(DB::table('insurance_contracts')
        ->select(array(DB::raw('Month(commission_date) as month'),DB::raw('sum(premium) as total')))
        ->whereMonth('commission_date',$days_backwards)
        ->whereYear('commission_date',date('Y'))
        ->where('insurance_class','PUBLIC LIABILITY')
        ->groupBy('month')
        ->pluck('total'));
    }

    $chart1 = new SampleChart;
        $chart1->labels(['Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart1->title("Income Generated from Principals $year");
        $chart1->options(['scales' => self::chartSetAxes('Month','Income (TZS)')]);
        $chart1->dataset('Income Generated', 'bar', $UDIA_income)->options([
            'fill' => 'true',
            'borderColor' => '#6cb2eb',
            "borderWidth"=>2,
            "backgroundColor"=>'#6cb2eb'
        ]);

        $chart2 = new SampleChart;
        $chart2->labels(['Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart2->title("Year $year");
        $chart2->options(['scales' => self::chartSetAxes('Month','Income (TZS)')]);
        //$chart2->options(['scales' ['yAxes'['scaleLabel']]]);
        $chart2->dataset('Motor Income', 'bar', $UDIA_income_motor)->options([
            'fill' => 'true',
            'borderColor' => '#51C1C0',
            "borderWidth"=>2,
            "backgroundColor"=>'#51C1C0'
        ]);
        $chart2->dataset('Marine Income', 'bar', $UDIA_income_marine)->options([
            'fill' => 'true',
            'borderColor' => '#3490dc',
            "borderWidth"=>2,
            "backgroundColor"=>'#3490dc'
        ]);
        $chart2->dataset('Fidelity Income', 'bar', $UDIA_income_fidelity)->options([
            'fill' => 'true',
            'borderColor' => '#6574cd',
            "borderWidth"=>2,
            "backgroundColor"=>'#6574cd'
        ]);
        $chart2->dataset('Fire Income', 'bar', $UDIA_income_fire)->options([
            'fill' => 'true',
            'borderColor' => '#e3342f',
            "borderWidth"=>2,
            "backgroundColor"=>'#e3342f'
        ]);
        $chart2->dataset('Public Income', 'bar', $UDIA_income_public)->options([
            'fill' => 'true',
            'borderColor' => '#f6993f',
            "borderWidth"=>2,
            "backgroundColor"=>'#f6993f'
        ]);
        $chart2->dataset('Proffesional Income', 'bar', $UDIA_income_prof)->options([
            'fill' => 'true',
            'borderColor' => '#6c757d',
            "borderWidth"=>2,
            "backgroundColor"=>'#6c757d'
        ]);


        $contracts=DB::table('insurance_contracts')->whereRaw('DATEDIFF(end_date,CURDATE()) < 15')->whereRaw('DATEDIFF(end_date,CURDATE()) > 0')->get();

      return view('dashboard_udia',compact('chart','chart1','chart2','contracts'));
    }

    public function udia_activity_filter(){

    $motor=insurance_contract::where('insurance_class','MOTOR')->whereYear('commission_date',$_GET['year'])->count();
  $fire=insurance_contract::where('insurance_class','FIRE')->whereYear('commission_date',$_GET['year'])->count();
  $money=insurance_contract::where('insurance_class','MONEY')->whereYear('commission_date',$_GET['year'])->count();
  $fidelity=insurance_contract::where('insurance_class','FIDELTY GUARANTEE')->whereYear('commission_date',$_GET['year'])->count();
  $public=insurance_contract::where('insurance_class','PUBLIC LIABILITY')->whereYear('commission_date',$_GET['year'])->count();
  $marine=insurance_contract::where('insurance_class','MARINE HULL')->whereYear('commission_date',$_GET['year'])->count();
  $prof=insurance_contract::where('insurance_class','PROFFESIONAL INDEMNITY')->whereYear('commission_date',$_GET['year'])->count();

  $total=$motor + $fire + $fidelity +  $marine + $prof + $public;

    $data1 = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data1->push(insurance_contract::select('id')
                    ->whereYear('commission_date', $_GET['year'])
                    ->whereMonth('commission_date',$days_backwards)
                    ->count());
    }

    if ($data1 instanceof Collection) {
           $data1 = $data1->toArray();
    }

    $UDIA_income = collect([]);
     for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income->push(DB::table('insurance_invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
        ->whereMonth('invoicing_period_start_date',$days_backwards)
         ->where('payment_status','Paid')
          ->whereYear('invoicing_period_start_date',$_GET['year'])
        ->groupBy('month')
        ->pluck('total'));
    }

     if ($UDIA_income instanceof Collection) {
           $UDIA_income = $UDIA_income->toArray();
    }

    $flat2 = array();
        foreach($UDIA_income as $i) {
            if (count($i)==0){
                $flat2[]=0;
            }
            else{
               foreach ($i as $value) {
                $flat2[]= $value;   
            } 
        }
            
            
        }

    return response()->json(['activity'=>$data1, 'udia'=>$flat2, 'fire'=>$fire, 'fidelity'=>$fidelity, 'marine'=>$marine, 'motor'=>$motor, 'prof'=>$prof, 'public'=>$public, 'total'=>$total]);

    }

    public function udia_income_filter(){

        $UDIA_income_motor = collect([]);
        $UDIA_income_fire = collect([]);
        $UDIA_income_fidelity = collect([]);
        $UDIA_income_marine = collect([]);
        $UDIA_income_prof = collect([]);
        $UDIA_income_public = collect([]);


     for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income_fire->push(DB::table('insurance_contracts')
        ->select(array(DB::raw('Month(commission_date) as month'),DB::raw('sum(premium) as total')))
        ->whereMonth('commission_date',$days_backwards)
        ->whereYear('commission_date',$_GET['year'])
        ->where('insurance_class','FIRE')
        ->groupBy('month')
        ->pluck('total'));
    }

        if ($UDIA_income_fire instanceof Collection) {
           $UDIA_income_fire = $UDIA_income_fire->toArray();
        }

    $fire = array();
        foreach($UDIA_income_fire as $i) {
            if (count($i)==0){
                $fire[]=0;
            }
            else{
               foreach ($i as $value) {
                $fire[]= $value;   
                } 
            }  
        }



    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income_fidelity->push(DB::table('insurance_contracts')
        ->select(array(DB::raw('Month(commission_date) as month'),DB::raw('sum(premium) as total')))
        ->whereMonth('commission_date',$days_backwards)
        ->whereYear('commission_date',$_GET['year'])
        ->where('insurance_class','FIDELTY GUARANTEE')
        ->groupBy('month')
        ->pluck('total'));
    }

         if ($UDIA_income_fidelity instanceof Collection) {
           $UDIA_income_fidelity = $UDIA_income_fidelity->toArray();
        }

    $fidelity = array();
        foreach($UDIA_income_fidelity as $i) {
            if (count($i)==0){
                $fidelity[]=0;
            }
            else{
               foreach ($i as $value) {
                $fidelity[]= $value;   
                } 
            }  
        }

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income_motor->push(DB::table('insurance_contracts')
        ->select(array(DB::raw('Month(commission_date) as month'),DB::raw('sum(premium) as total')))
        ->whereMonth('commission_date',$days_backwards)
        ->whereYear('commission_date',$_GET['year'])
        ->where('insurance_class','MOTOR')
        ->groupBy('month')
        ->pluck('total'));
    }

        if ($UDIA_income_motor instanceof Collection) {
           $UDIA_income_motor = $UDIA_income_motor->toArray();
        }

    $motor = array();
        foreach($UDIA_income_motor as $i) {
            if (count($i)==0){
                $motor[]=0;
            }
            else{
               foreach ($i as $value) {
                $motor[]= $value;   
                } 
            }  
        }

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income_marine->push(DB::table('insurance_contracts')
        ->select(array(DB::raw('Month(commission_date) as month'),DB::raw('sum(premium) as total')))
        ->whereMonth('commission_date',$days_backwards)
        ->whereYear('commission_date',$_GET['year'])
        ->where('insurance_class','MARINE HULL')
        ->groupBy('month')
        ->pluck('total'));
    }

    if ($UDIA_income_marine instanceof Collection) {
           $UDIA_income_marine = $UDIA_income_marine->toArray();
        }

    $marine = array();
        foreach($UDIA_income_marine as $i) {
            if (count($i)==0){
                $marine[]=0;
            }
            else{
               foreach ($i as $value) {
                $marine[]= $value;   
                } 
            }  
        }

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income_prof->push(DB::table('insurance_contracts')
        ->select(array(DB::raw('Month(commission_date) as month'),DB::raw('sum(premium) as total')))
        ->whereMonth('commission_date',$days_backwards)
        ->whereYear('commission_date',$_GET['year'])
        ->where('insurance_class','PROFFESIONAL INDEMNITY')
        ->groupBy('month')
        ->pluck('total'));
    }

    if ($UDIA_income_prof instanceof Collection) {
           $UDIA_income_prof = $UDIA_income_prof->toArray();
        }

    $prof = array();
        foreach($UDIA_income_prof as $i) {
            if (count($i)==0){
                $prof[]=0;
            }
            else{
               foreach ($i as $value) {
                $prof[]= $value;   
                } 
            }  
        }

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income_public->push(DB::table('insurance_contracts')
        ->select(array(DB::raw('Month(commission_date) as month'),DB::raw('sum(premium) as total')))
        ->whereMonth('commission_date',$days_backwards)
        ->whereYear('commission_date',$_GET['year'])
        ->where('insurance_class','PUBLIC LIABILITY')
        ->groupBy('month')
        ->pluck('total'));
    }

    if ($UDIA_income_public instanceof Collection) {
           $UDIA_income_public = $UDIA_income_public->toArray();
        }

    $public = array();
        foreach($UDIA_income_public as $i) {
            if (count($i)==0){
                $public[]=0;
            }
            else{
               foreach ($i as $value) {
                $public[]= $value;   
                } 
            }  
        }

     return response()->json(['fire'=>$fire, 'fidelity'=>$fidelity,'motor'=>$motor, 'marine'=>$marine, 'prof'=>$prof, 'public'=>$public]);

    }

    public function cptuindex(){
        $year=date('Y');
        $data = collect([]); 

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data->push(carContract::select('id')
                    ->whereYear('start_date', date('Y'))
                    ->where('form_completion','1')
                    ->whereMonth('start_date',$days_backwards)
                    ->distinct('vehicle_reg_no')
                    ->count());
    }

        $chart = new SampleChart;
        $chart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart->title("Rental Activities $year");
        $chart->options(['scales' => self::chartSetAxes('Month','Rented Car(s)')]);
        $chart->dataset('Rented Cars', 'bar', $data )->options([
            'fill' => 'true',
            'borderColor' => '#38c172',
            "borderWidth"=>2,
            "backgroundColor"=>'#38c172'
            // "backgroundColor"=>["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"]
        ]);

        $CPTU_income = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $CPTU_income->push(DB::table('car_rental_invoices')
            ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
            ->whereMonth('invoicing_period_start_date',$days_backwards)
            ->where('payment_status','Paid')
            ->whereYear('invoicing_period_start_date',date('Y'))
            ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
            ->pluck('total'));
    }
    $chart2 = new SampleChart;
        $chart2->labels(['Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart2->title("Income Generation $year");
        $chart2->options(['scales' => self::chartSetAxes('Month','Income (TZS)')]);
        $chart2->dataset('CPTU Income', 'bar', $CPTU_income)->options([
            'fill' => 'true',
            'borderColor' => '#38c172',
            "borderWidth"=>2,
            "backgroundColor"=>'#38c172'
        ]);

        $invoices=DB::table('car_rental_invoices')->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')->where('payment_status','Not Paid')->whereRaw('DATEDIFF(invoice_date,CURDATE()) < 30')->orderBy('invoice_date','asc')->get();

        return view('dashboard_cptu',compact('chart','chart2','invoices'));
    }


    public function cptu_activity_filter(){
        $data = collect([]); 

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data->push(carContract::select('id')
                    ->whereYear('start_date', $_GET['year'])
                    ->where('form_completion','1')
                    ->whereMonth('start_date',$days_backwards)
                    ->distinct('vehicle_reg_no')
                    ->count());
    }

    if ($data instanceof Collection) {
           $data = $data->toArray();
    }

     $CPTU_income = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $CPTU_income->push(DB::table('car_rental_invoices')
            ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
            ->whereMonth('invoicing_period_start_date',$days_backwards)
            ->where('payment_status','Paid')
            ->whereYear('invoicing_period_start_date',$_GET['year'])
            ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
            ->pluck('total'));
    }

    if ($CPTU_income instanceof Collection) {
           $CPTU_income = $CPTU_income->toArray();
    }

    $flat2 = array();
        foreach($CPTU_income as $i) {
            if (count($i)==0){
                $flat2[]=0;
            }
            else{
               foreach ($i as $value) {
                $flat2[]= $value;   
            } 
        }
            
            
        }

    $within=carContract::where('area_of_travel','Within')->whereYear('start_date',$_GET['year'])->where('form_completion','1')->count();
    $outside=carContract::where('area_of_travel','Outside')->whereYear('start_date',$_GET['year'])->where('form_completion','1')->count();
    $total = $within +$outside;

    return response()->json(['activity'=>$data, 'income'=>$flat2,'within'=>$within,'outside'=>$outside,'total'=>$total]);

    }

    public function spaceindex(){
        $year=date('Y');
        $data2 = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data2->push(space_contract::select('contract_id')
                    ->whereYear('start_date', date('Y'))
                    ->whereMonth('start_date',$days_backwards)
                    ->distinct('contract_id')
                    ->count());
    }

        $chart = new SampleChart;
        $chart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart->title("Lease Activities $year");
        $chart->options(['scales' => self::chartSetAxes('Month','Lease Activities')]);
        $chart->dataset('Rented Spaces', 'bar', $data2)->options([
            'fill' => 'true',
            'borderColor' => '#3490dc',
            "borderWidth"=>2,
            "backgroundColor"=>'#3490dc'
        ]);

         $space_income = collect([]); 

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $space_income->push(DB::table('invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
        ->whereMonth('invoicing_period_start_date',$days_backwards)
        ->where('payment_status','Paid')
        ->where('currency_invoice','TZS')
        ->whereYear('invoicing_period_start_date',date('Y'))
        ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
        ->pluck('total'));
    }

    $space_income2 = collect([]);
    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $space_income2->push(DB::table('invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
        ->whereMonth('invoicing_period_start_date',$days_backwards)
        ->where('payment_status','Paid')
        ->where('currency_invoice','USD')
        ->whereYear('invoicing_period_start_date',date('Y'))
        ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
        ->pluck('total'));
    }

    $chart1 = new SampleChart;
        $chart1->labels(['Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart1->title("Space Income Generation $year");
        $chart1->options(['scales' => self::chartSetAxes('Month','Income')]);
        $chart1->dataset('TZS', 'bar', $space_income)->options([
            'fill' => 'true',
            'borderColor' => '#3490dc',
            "borderWidth"=>2,
            "backgroundColor"=>'#3490dc'
        ]);
        $chart1->dataset('USD', 'bar', $space_income2)->options([
            'fill' => 'true',
            'borderColor' => '#4dc0b5',
            "borderWidth"=>2,
            "backgroundColor"=>'#4dc0b5'
        ]);

        // $contracts=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->whereRaw('DATEDIFF(end_date,CURDATE()) < 15')->whereRaw('DATEDIFF(end_date,CURDATE()) > 0')->get();
        $contracts=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->whereRaw('DATEDIFF(end_date,CURDATE()) < 30')->whereRaw('DATEDIFF(end_date,CURDATE()) > 0')->get();

        $invoices=DB::table('invoices')->join('clients','clients.full_name','=','invoices.debtor_name')->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('payment_status','Not Paid')->whereRaw('DATEDIFF(CURDATE(),invoice_date) > 30')->orderBy('invoice_date','asc')->get();

        $electric_invoices=DB::table('electricity_bill_invoices')->join('clients','clients.full_name','=','electricity_bill_invoices.debtor_name')->join('space_contracts','space_contracts.contract_id','=','electricity_bill_invoices.contract_id')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('payment_status','Not Paid')->whereRaw('DATEDIFF(CURDATE(),invoice_date) > 30')->orderBy('invoice_date','asc')->get();
        $water_invoices=DB::table('water_bill_invoices')->join('clients','clients.full_name','=','water_bill_invoices.debtor_name')->join('space_contracts','space_contracts.contract_id','=','water_bill_invoices.contract_id')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('payment_status','Not Paid')->whereRaw('DATEDIFF(CURDATE(),invoice_date) > 30')->orderBy('invoice_date','asc')->get();


        return view('dashboard_space',compact('chart','chart1','contracts','invoices','electric_invoices','water_invoices'));
    }

    public function space_activity_filter(){
      $data2 = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data2->push(space_contract::select('contract_id')
                    ->whereYear('start_date', $_GET['year'])
                    ->whereMonth('start_date',$days_backwards)
                    ->distinct('contract_id')
                    ->count());
    }

     if ($data2 instanceof Collection) {
           $data2 = $data2->toArray();
    }

    $space_income = collect([]); 

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $space_income->push(DB::table('invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
        ->whereMonth('invoicing_period_start_date',$days_backwards)
        ->where('payment_status','Paid')
        ->where('currency_invoice','TZS')
        ->whereYear('invoicing_period_start_date',$_GET['year'])
        ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
        ->pluck('total'));
    }

    $space_income2 = collect([]);
    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $space_income2->push(DB::table('invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
        ->whereMonth('invoicing_period_start_date',$days_backwards)
        ->where('payment_status','Paid')
        ->where('currency_invoice','USD')
        ->whereYear('invoicing_period_start_date',date('Y'))
        ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
        ->pluck('total'));
    }

    if ($space_income instanceof Collection) {
           $space_income = $space_income->toArray();
    }

    $flat2 = array();
        foreach($space_income as $i) {
            if (count($i)==0){
                $flat2[]=0;
            }
            else{
               foreach ($i as $value) {
                $flat2[]= $value;   
                } 
            }      
        }

    if ($space_income2 instanceof Collection) {
           $space_income2 = $space_income2->toArray();
    }

    $flat3 = array();
        foreach($space_income2 as $i) {
            if (count($i)==0){
                $flat3[]=0;
            }
            else{
               foreach ($i as $value) {
                $flat3[]= $value;   
                } 
            }      
        }

    $main=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','J.K Nyerere')->whereYear('end_date','>=',$_GET['year'])->whereYear('start_date','<=',$_GET['year'])->count();
  $knyama=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','Kijitonyama')->whereYear('end_date','>=',$_GET['year'])->whereYear('start_date','<=',$_GET['year'])->count();
  $kunduchi=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','Kunduchi')->whereYear('end_date','>=',$_GET['year'])->whereYear('start_date','<=',$_GET['year'])->count();
  $mabibo=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','Mabibo')->whereYear('end_date','>=',$_GET['year'])->whereYear('start_date','<=',$_GET['year'])->count();
  $mikocheni=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','Mikocheni')->whereYear('end_date','>=',$_GET['year'])->whereYear('start_date','<=',$_GET['year'])->count();
  $mlimani=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','Mlimani City')->whereYear('end_date','>=',$_GET['year'])->whereYear('start_date','<=',$_GET['year'])->count();
  $ubungo=space_contract::join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('location','Ubungo')->whereYear('end_date','>=',$_GET['year'])->whereYear('start_date','<=',$_GET['year'])->count();

  $total = $main + $knyama + $kunduchi +  $mabibo +$mikocheni + $mlimani + $ubungo;

  return response()->json(['activity'=>$data2, 'income'=>$flat2, 'income2'=>$flat3, 'main'=>$main,'knyama'=>$knyama,'kunduchi'=>$kunduchi,'mabibo'=>$mabibo,'mikocheni'=>$mikocheni, 'mlimani'=>$mlimani, 'ubungo'=>$ubungo, 'total'=>$total]);

    }

    public function voteholderindex(){
        $year=date('Y');
        $centre=Auth::user()->cost_centre;
        $centre_name=cost_centre::select('costcentre')->where('costcentre_id',$centre)->value('costcentre');
        $data = collect([]); 

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data->push(carContract::select('id')
                    ->whereYear('start_date', date('Y'))
                    ->where('form_completion','1')
                    ->where('cost_centre',$centre)
                    ->whereMonth('start_date',$days_backwards)
                    ->distinct('vehicle_reg_no')
                    ->count());
    }

        $chart = new SampleChart;
        $chart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart->title("Rental Activities $year");
        $chart->options(['scales' => self::chartSetAxes('Month','Rental Activities')]);
        $chart->dataset('Rented Cars', 'bar', $data )->options([
            'fill' => 'true',
            'borderColor' => '#38c172',
            "borderWidth"=>2,
            "backgroundColor"=>'#38c172'
            // "backgroundColor"=>["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"]
        ]);


         $CPTU_income = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $CPTU_income->push(DB::table('car_rental_invoices')
            ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
            ->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')
            ->whereMonth('invoicing_period_start_date',$days_backwards)
            ->where('cost_centre',$centre)
            ->where('payment_status','Paid')
            ->whereYear('invoicing_period_start_date',date('Y'))
            ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
            ->pluck('total'));
    }
    $chart2 = new SampleChart;
        $chart2->labels(['Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart2->title("Amount Paid to CPTU $year");
        $chart2->options(['scales' => self::chartSetAxes('Month','Amount Paid')]);
        $chart2->dataset("Expenditures on CPTU", 'bar', $CPTU_income)->options([
            'fill' => 'true',
            'borderColor' => '#38c172',
            "borderWidth"=>2,
            "backgroundColor"=>'#38c172'
        ]);


        $unpaid=DB::table('car_rental_invoices')
        ->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')
        ->where('payment_status','Not Paid')
         ->where('cost_centre',$centre)
        ->get();

        return view('dashboard_voteholder',compact('chart','chart2','unpaid','centre','centre_name'));
    }

    public function voteholder_activity_filter(){
        $centre=Auth::user()->cost_centre;
        $data = collect([]); 

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data->push(carContract::select('id')
                    ->whereYear('start_date', $_GET['year'])
                    ->where('form_completion','1')
                    ->where('cost_centre',$centre)
                    ->whereMonth('start_date',$days_backwards)
                    ->distinct('vehicle_reg_no')
                    ->count());
    }

    if ($data instanceof Collection) {
           $data = $data->toArray();
    }

    $CPTU_income = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $CPTU_income->push(DB::table('car_rental_invoices')
            ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
            ->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')
            ->whereMonth('invoicing_period_start_date',$days_backwards)
            ->where('cost_centre',$centre)
            ->where('payment_status','Paid')
            ->whereYear('invoicing_period_start_date',$_GET['year'])
            ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
            ->pluck('total'));
    }


    if ($CPTU_income instanceof Collection) {
           $CPTU_income = $CPTU_income->toArray();
    }

    $flat2 = array();
        foreach($CPTU_income as $i) {
            if (count($i)==0){
                $flat2[]=0;
            }
            else{
               foreach ($i as $value) {
                $flat2[]= $value;   
                } 
            }      
        }

        return response()->json(['activity'=>$data, 'income'=>$flat2]);
    }

    public function index()
    {
        $year=date('Y');
        $users = insurance_contract::select(\DB::raw("COUNT(*) as count"))
                    ->whereYear('commission_date', date('Y'))
                    ->groupBy(\DB::raw("Month(commission_date)"))
                    ->pluck('count');

    $data1 = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data1->push(insurance_contract::select('id')
                    ->whereYear('commission_date', date('Y'))
                    ->whereMonth('commission_date',$days_backwards)
                    //->groupBy(\DB::raw("Month(commission_date)"))
                    ->count());
    }

        $chart = new SampleChart;
        $chart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart->title("UDIA Activities $year");
        $chart->options(['scales' => self::chartSetAxes('Month','Total Activities')]);
        $chart->dataset('Insurance Covers Sold', 'bar', $data1)->options([
            'fill' => 'true',
            'borderColor' => '#6cb2eb',
            "borderWidth"=>2,
            "backgroundColor"=>'#6cb2eb'
        ]);

        $rentedCars=carContract::select(\DB::raw("COUNT(*) as count"))
                    ->whereYear('start_date', date('Y'))
                    ->orderBy(\DB::raw("Month(start_date)",'dsc'))
                    ->distinct('vehicle_reg_no')
                    ->groupBy(\DB::raw("MonthName(start_date)"))
                    ->pluck('count');

    $data = collect([]); 

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data->push(carContract::select('id')
                    ->whereYear('start_date', '2019')
                    ->whereMonth('start_date',$days_backwards)
                    ->distinct('vehicle_reg_no')
                    ->count());
    }

        $chart2 = new SampleChart;
        $chart2->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        //$chart2->labels($rentedCars->pluck('month'));
        $chart2->title("CPTU Activities $year");
        $chart2->options(['scales' => self::chartSetAxes('Month','Total Activities')]);
        $chart2->dataset('Rented Cars', 'bar', $data )->options([
            'fill' => 'true',
            'borderColor' => '#6cb2eb',
            "borderWidth"=>1,
            "backgroundColor"=>'#6cb2eb'
            // "backgroundColor"=>["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"]
        ]);

        $spaces=space_contract::select(\DB::raw("COUNT(*) as count"))
                    ->whereYear('start_date', date('Y'))
                    ->distinct('space_id_contract')
                    ->groupBy(\DB::raw("Month(start_date)"))
                    ->pluck('count');

    $data2 = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data2->push(space_contract::select('contract_id')
                    ->whereYear('start_date', date('Y'))
                    ->whereMonth('start_date',$days_backwards)
                    ->distinct('contract_id')
                    ->count());
    }

        $chart3 = new SampleChart;
        $chart3->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart3->title("Space Activities $year");
        $chart3->options(['scales' => self::chartSetAxes('Month','Total Activities')]);
        $chart3->dataset('Rented Spaces', 'bar', $data2)->options([
            'fill' => 'true',
            'borderColor' => '#6cb2eb',
            "borderWidth"=>1,
            "backgroundColor"=>'#6cb2eb'
        ]);


    $CPTU_income = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $CPTU_income->push(DB::table('car_rental_invoices')
            ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
            ->whereMonth('invoicing_period_start_date',$days_backwards)
            ->where('payment_status','Paid')
            ->whereYear('invoicing_period_start_date',date('Y'))
            ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
            ->pluck('total'));
    }

     $UDIA_income = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income->push(DB::table('insurance_invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
        ->whereMonth('invoicing_period_start_date',$days_backwards)
         ->where('payment_status','Paid')
        ->whereYear('invoicing_period_start_date',date('Y'))
        ->groupBy('month')
        ->pluck('total'));
    }


    $space_income = collect([]); 

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $space_income->push(DB::table('invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
        ->whereMonth('invoicing_period_start_date',$days_backwards)
         ->where('payment_status','Paid')
         ->where('currency_invoice','TZS')
        ->whereYear('invoicing_period_start_date',date('Y'))
        ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
        ->pluck('total'));
    }

    $space_income2 = collect([]);
    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $space_income2->push(DB::table('invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
        ->whereMonth('invoicing_period_start_date',$days_backwards)
        ->where('payment_status','Paid')
        ->where('currency_invoice','USD')
        ->whereYear('invoicing_period_start_date',date('Y'))
        ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
        ->pluck('total'));
    }


        $chart4 = new SampleChart;
        $chart4->labels(['Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart4->title("UDIA Income Generation $year");
        $chart4->options(['scales' => self::chartSetAxes('Month','Income (TZS)')]);
        $chart4->dataset('UDIA Income', 'bar', $UDIA_income)
                ->options([
                    'fill' => 'true',
                    'borderColor' => '#6cb2eb',
                    "borderWidth"=>1,
                    "backgroundColor"=>'#6cb2eb'
                ]);

        $chart5 = new SampleChart;
        $chart5->labels(['Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart5->title("CPTU Income Generation $year");
        $chart5->options(['scales' => self::chartSetAxes('Month','Income (TZS)')]);
        $chart5->dataset('CPTU Income', 'bar', $CPTU_income)
        ->options([
            'fill' => 'true',
            'borderColor' => '#6cb2eb',
            "borderWidth"=>1,
            "backgroundColor"=>'#6cb2eb',
        ]);

        $chart6 = new SampleChart;
        $chart6->labels(['Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart6->title("Space Income Generation $year");
        $chart6->options(['scales' => self::chartSetAxes('Month','Income')]);
        $chart6->dataset('TZS', 'bar', $space_income)->options([
            'fill' => 'true',
            'borderColor' => '#6cb2eb',
            "borderWidth"=>1,
            "backgroundColor"=>'#6cb2eb'
        ]);
          $chart6->dataset('USD', 'bar', $space_income2)->options([
            'fill' => 'true',
            'borderColor' => '#4dc0b5',
            "borderWidth"=>1,
            "backgroundColor"=>'#4dc0b5'
        ]);
        $today=date('Y-m-d');

        $space_contract=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->whereRaw('DATEDIFF(end_date,CURDATE()) < 30')->whereRaw('DATEDIFF(end_date,CURDATE()) > 0')->get();

        $invoices=DB::table('invoices')->join('clients','clients.full_name','=','invoices.debtor_name')->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')->where('payment_status','Not Paid')->whereRaw('DATEDIFF(CURDATE(),invoice_date) > 30')->orderBy('invoice_date','asc')->get();

        $cptu_invoices=DB::table('car_rental_invoices')->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')->where('payment_status','Not Paid')->whereRaw('DATEDIFF(invoice_date,CURDATE()) < 30')->orderBy('invoice_date','asc')->get();
        


        return view('dashboard', compact('chart','chart2','chart3','chart4','chart5','chart6','space_contract','invoices','cptu_invoices'));
    }

    public function income_filter(){
        $CPTU_income = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $CPTU_income->push(DB::table('car_rental_invoices')
            ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
            ->whereMonth('invoicing_period_start_date',$days_backwards)
            ->where('payment_status','Paid')
            ->whereYear('invoicing_period_start_date',$_GET['year'])
            ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
            ->pluck('total'));
    }

     $UDIA_income = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $UDIA_income->push(DB::table('insurance_invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
        ->whereMonth('invoicing_period_start_date',$days_backwards)
         ->where('payment_status','Paid')
        ->whereYear('invoicing_period_start_date',$_GET['year'])
        ->groupBy('month')
        ->pluck('total'));
    }


    $space_income = collect([]); 

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $space_income->push(DB::table('invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
        ->whereMonth('invoicing_period_start_date',$days_backwards)
         ->where('payment_status','Paid')
        ->whereYear('invoicing_period_start_date',$_GET['year'])
        ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
        ->pluck('total'));
    }

    if ($CPTU_income instanceof Collection) {
           $CPTU_income = $CPTU_income->toArray();
    }
        //$CPTU_income = array_flatten($CPTU_income);

    if ($UDIA_income instanceof Collection) {
           $UDIA_income = $UDIA_income->toArray();
    }

    if ($space_income instanceof Collection) {
           $space_income = $space_income->toArray();
    }

        $flat = array();
        foreach($CPTU_income as $i) {
            if (count($i)==0){
                $flat[]=0;
            }
            else{
               foreach ($i as $value) {
                $flat[]= $value;   
            } 
        }
            
            
        }

        $flat2 = array();
        foreach($UDIA_income as $i) {
            if (count($i)==0){
                $flat2[]=0;
            }
            else{
               foreach ($i as $value) {
                $flat2[]= $value;   
            } 
        }
            
            
        }

        $flat3 = array();
        foreach($space_income as $i) {
            if (count($i)==0){
                $flat3[]=0;
            }
            else{
               foreach ($i as $value) {
                $flat3[]= $value;   
            } 
        }
            
            
        }

        return response()->json(['cptu'=>$flat, 'udia'=>$flat2, 'space'=>$flat3]);
    
    }

    public function activity_filter(){
   
    $data = collect([]); 

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data->push(carContract::select('id')
                    ->whereYear('start_date', $_GET['year'])
                    ->whereMonth('start_date',$days_backwards)
                    ->distinct('vehicle_reg_no')
                    ->count());
    }

    $data1 = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data1->push(insurance_contract::select('id')
                    ->whereYear('commission_date', $_GET['year'])
                    ->whereMonth('commission_date',$days_backwards)
                    ->count());
    }

    $data2 = collect([]);

    for ($days_backwards = 1; $days_backwards <= 12; $days_backwards++) {
        $data2->push(space_contract::select('contract_id')
                    ->whereYear('start_date', $_GET['year'])
                    ->whereMonth('start_date',$days_backwards)
                    ->distinct('contract_id')
                    ->count());
    }

    if ($data instanceof Collection) {
           $data = $data->toArray();
    }


    if ($data1 instanceof Collection) {
           $data1 = $data1->toArray();
    }

    if ($data2 instanceof Collection) {
           $data2 = $data2->toArray();
    }

   

    return response()->json(['cptu'=>$data, 'udia'=>$data1, 'space'=>$data2]);

    }
}
