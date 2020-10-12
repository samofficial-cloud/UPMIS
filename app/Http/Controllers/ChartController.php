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

class ChartController extends Controller
{
    //

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
        ->where('insurance_class','FIDELITY')
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
        $chart1->dataset('Income Generated', 'bar', $UDIA_income)->options([
            'fill' => 'true',
            'borderColor' => '#6cb2eb',
            "borderWidth"=>2,
            "backgroundColor"=>'#6cb2eb'
        ]);

        $chart2 = new SampleChart;
        $chart2->labels(['Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart2->title("Income Collected from Cover Note Sales per each Class $year");
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
        $chart2->dataset('CPTU Income', 'bar', $CPTU_income)->options([
            'fill' => 'true',
            'borderColor' => '#38c172',
            "borderWidth"=>2,
            "backgroundColor"=>'#38c172'
        ]);

        $invoices=DB::table('car_rental_invoices')->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')->where('payment_status','Not Paid')->whereRaw('DATEDIFF(invoice_date,CURDATE()) < 30')->orderBy('invoice_date','asc')->get();

        return view('dashboard_cptu',compact('chart','chart2','invoices'));
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
        ->whereYear('invoicing_period_start_date',date('Y'))
        ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
        ->pluck('total'));
    }

    $chart1 = new SampleChart;
        $chart1->labels(['Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart1->title("Space Income Generation $year");
        $chart1->dataset('Space Income', 'bar', $space_income)->options([
            'fill' => 'true',
            'borderColor' => '#3490dc',
            "borderWidth"=>2,
            "backgroundColor"=>'#3490dc'
        ]);

        $contracts=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->whereRaw('DATEDIFF(end_date,CURDATE()) < 15')->whereRaw('DATEDIFF(end_date,CURDATE()) > 0')->get();

        $invoices=DB::table('invoices')->join('clients','clients.full_name','=','invoices.debtor_name')->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')->where('payment_status','Not Paid')->whereRaw('DATEDIFF(CURDATE(),invoice_date) > 30')->orderBy('invoice_date','asc')->get();

        $electric_invoices=DB::table('electricity_bill_invoices')->join('clients','clients.full_name','=','electricity_bill_invoices.debtor_name')->join('space_contracts','space_contracts.contract_id','=','electricity_bill_invoices.contract_id')->where('payment_status','Not Paid')->whereRaw('DATEDIFF(CURDATE(),invoice_date) > 30')->orderBy('invoice_date','asc')->get();
        $water_invoices=DB::table('water_bill_invoices')->join('clients','clients.full_name','=','water_bill_invoices.debtor_name')->join('space_contracts','space_contracts.contract_id','=','water_bill_invoices.contract_id')->where('payment_status','Not Paid')->whereRaw('DATEDIFF(CURDATE(),invoice_date) > 30')->orderBy('invoice_date','asc')->get();


        return view('dashboard_space',compact('chart','chart1','contracts','invoices','electric_invoices','water_invoices'));
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
                    ->whereYear('start_date', date('Y'))
                    ->whereMonth('start_date',$days_backwards)
                    ->distinct('vehicle_reg_no')
                    ->count());
    }

        $chart2 = new SampleChart;
        $chart2->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        //$chart2->labels($rentedCars->pluck('month'));
        $chart2->title("CPTU Activities $year");
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
        ->whereYear('invoicing_period_start_date',date('Y'))
        ->groupBy(DB::raw('MONTH(invoicing_period_start_date)'))
        ->pluck('total'));
    }


        $chart4 = new SampleChart;
        $chart4->labels(['Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart4->title("UDIA Income Generation $year");
        $chart4->dataset('UDIA Income', 'bar', $UDIA_income)->options([
            'fill' => 'true',
            'borderColor' => '#6cb2eb',
            "borderWidth"=>1,
            "backgroundColor"=>'#6cb2eb'
        ]);

        $chart5 = new SampleChart;
        $chart5->labels(['Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart5->title("CPTU Income Generation $year");
        $chart5->dataset('CPTU Income', 'bar', $CPTU_income)->options([
            'fill' => 'true',
            'borderColor' => '#6cb2eb',
            "borderWidth"=>1,
            "backgroundColor"=>'#6cb2eb'
        ]);

        $chart6 = new SampleChart;
        $chart6->labels(['Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $chart6->title("Space Income Generation $year");
        $chart6->dataset('Space Income', 'bar', $space_income)->options([
            'fill' => 'true',
            'borderColor' => '#6cb2eb',
            "borderWidth"=>1,
            "backgroundColor"=>'#6cb2eb'
        ]);
        $today=date('Y-m-d');

        $space_contract=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->whereRaw('DATEDIFF(end_date,CURDATE()) < 30')->whereRaw('DATEDIFF(end_date,CURDATE()) > 0')->get();

        $invoices=DB::table('invoices')->join('clients','clients.full_name','=','invoices.debtor_name')->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')->where('payment_status','Not Paid')->whereRaw('DATEDIFF(CURDATE(),invoice_date) > 30')->orderBy('invoice_date','asc')->get();

        $cptu_invoices=DB::table('car_rental_invoices')->join('car_contracts','car_contracts.id','=','car_rental_invoices.contract_id')->where('payment_status','Not Paid')->whereRaw('DATEDIFF(invoice_date,CURDATE()) < 30')->orderBy('invoice_date','asc')->get();
        


        return view('dashboard', compact('chart','chart2','chart3','chart4','chart5','chart6','space_contract','invoices','cptu_invoices'));
    }
}
