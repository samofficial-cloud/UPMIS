<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsuranceController extends Controller
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
        $insurance=DB::table('insurance')->where('status',1)->get();



        return view('insurance')->with('insurance',$insurance);
    }

    public function addinsurance(Request $request)
    {

        DB::table('insurance')->insert(
            ['class' => $request->get('class'),'insurance_company' => $request->get('insurance_company'),'insurance_type' => $request->get('insurance_type'), 'price' => $request->get('price'), 'commission' => $request->get('commission')]
        );


        return redirect('/insurance')
            ->with('success', 'New Insurance package added successfully');
    }

    public function editInsurance(Request $request,$id)
    {


        DB::table('insurance')
            ->where('id', $id)
            ->update(['class' => $request->get('class')]);


        DB::table('insurance')
            ->where('id', $id)
            ->update(['insurance_company' => $request->get('insurance_company')]);

        DB::table('insurance')
            ->where('id', $id)
            ->update(['insurance_type' => $request->get('insurance_type')]);


        DB::table('insurance')
            ->where('id', $id)
            ->update(['price' => $request->get('price')]);



        DB::table('insurance')
            ->where('id', $id)
            ->update(['commission' => $request->get('commission')]);





        return redirect('/insurance')
            ->with('success', 'Insurance package details edited successfully');
    }

    public function deactivateInsurance(Request $request,$id)
    {

        DB::table('insurance')
            ->where('id', $id)
            ->update(['status' => 0]);



        return redirect('/insurance')
            ->with('success', 'Insurance deactivated successfully');
    }


    public function autoCompleteinsuranceId(Request $request)
    {



        if($request->get('query'))
        {
            $query = $request->get('query');
            $insurance_type=$request->get('insurance_type');
            $insurance_location=$request->get('insurance_location');

        $insurance_id=DB::table('insurance')->where('insurance_type',$insurance_type)->where('location',$insurance_location)->where('insurance_id', 'LIKE', "%{$query}%")->get();



            if(count($insurance_id)!=0){
                $output = '<ul class="dropdown-menu_custom" style="display:block; width: 100%; margin-top: -25px;
    margin-bottom: 10px; ">';
                foreach($insurance_id as $row)
                {
                    $output .= '
       <li id="listinsurancePerTypeLocation">'.$row->insurance_id.'</li>
       ';
                }
                $output .= '</ul>';
                echo $output;
            }
            else{
                echo "0";
            }

        }


    }



    public function autoCompleteinsuranceize(Request $request)
    {



        if($request->get('selected_insurance_id'))
        {
            $selected_insurance_id = $request->get('selected_insurance_id');


            $insurance_size=DB::table('insurance')->where('insurance_id',$selected_insurance_id)->value('size');



            if($insurance_size!=null){

                echo $insurance_size;
            }
            else{
                echo "0";
            }

        }


    }




}
