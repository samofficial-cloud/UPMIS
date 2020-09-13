<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\insurance_contract;
use App\Charts\SampleChart;
Use App\carContract;
use App\space_contract;
use DB;

class ChartController extends Controller
{
    //
    public function index()
    {
        $users = insurance_contract::select(\DB::raw("COUNT(*) as count"))
                    ->whereYear('commission_date', date('Y'))
                    ->groupBy(\DB::raw("Month(commission_date)"))
                    ->pluck('count');

        $chart = new SampleChart;
        $chart->labels(['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec','Jan', 'Feb', 'Mar', 'Apr', 'May']);
        $chart->title('UDIA Activities');
        $chart->dataset('Insurance Covers Sold', 'bar', $users)->options([
            'fill' => 'true',
            'borderColor' => '#51C1C0'
        ]);

        $rentedCars=carContract::select(\DB::raw("COUNT(*) as count"))
                    ->whereYear('start_date', date('Y'))
                    ->distinct('vehicle_reg_no')
                    ->groupBy(\DB::raw("Month(start_date)"))
                    ->pluck('count');

        $chart2 = new SampleChart;
        $chart2->labels(['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec','Jan', 'Feb', 'Mar', 'Apr', 'May','Jun']);
        $chart2->title('CPTU Activities');
        $chart2->dataset('Rented Cars', 'bar', $rentedCars)->options([
            'fill' => 'true',
            'borderColor' => '#51C1C0',
            "borderWidth"=>3,
            "backgroundColor"=>'#fff'
            // "backgroundColor"=>["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"]
        ]);

        $spaces=space_contract::select(\DB::raw("COUNT(*) as count"))
                    ->whereYear('start_date', date('Y'))
                    ->distinct('space_id_contract')
                    ->groupBy(\DB::raw("Month(start_date)"))
                    ->pluck('count');

        $chart3 = new SampleChart;
        $chart3->labels(['Aug', 'Sep', 'Oct', 'Nov', 'Dec','Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','Jul']);
        $chart3->title('Space Activities');
        $chart3->dataset('Rented Spaces', 'bar', $spaces)->options([
            'fill' => 'true',
            'borderColor' => '#51C1C0'
        ]);

        $CPTU_income=DB::table('car_rental_invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
    ->groupBy('month')
    ->pluck('total');

    $UDIA_income=DB::table('insurance_invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
    ->groupBy('month')
    ->pluck('total');

    $space_income=DB::table('invoices')
        ->select(array(DB::raw('Month(invoicing_period_start_date) as month'),DB::raw('sum(amount_to_be_paid) as total')))
    ->groupBy('month')
    ->pluck('total');

        $chart4 = new SampleChart;
        $chart4->labels(['Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec','Jan', 'Feb', 'Mar']);
        $chart4->title('UDIA Income Generation');
        $chart4->dataset('UDIA Income', 'bar', $UDIA_income)->options([
            'fill' => 'true',
            'borderColor' => '#51C1C0'
        ]);

        $chart5 = new SampleChart;
        $chart5->labels(['Apr', 'May','Jun','Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec','Jan', 'Feb', 'Mar']);
        $chart5->title('CPTU Income Generation');
        $chart5->dataset('CPTU Income', 'bar', $CPTU_income)->options([
            'fill' => 'true',
            'borderColor' => '#51C1C0'
        ]);

        $chart6 = new SampleChart;
        $chart6->labels(['Aug', 'Sep', 'Oct', 'Nov', 'Dec','Jan', 'Feb', 'Mar','Apr', 'May','Jun','Jul']);
        $chart6->title('Space Income Generation');
        $chart6->dataset('Space Income', 'bar', $space_income)->options([
            'fill' => 'true',
            'borderColor' => '#51C1C0'
        ]);
        $today=date('Y-m-d');

        $space_contract=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->whereRaw('DATEDIFF(end_date,CURDATE()) < 15')->get();

        $invoices=DB::table('invoices')->where('payment_status','Not Paid')->whereRaw('DATEDIFF(invoice_date,CURDATE()) < 30')->orderBy('invoice_date','asc')->get();
        


        return view('dashboard', compact('chart','chart2','chart3','chart4','chart5','chart6','space_contract','invoices'));
    }
}
