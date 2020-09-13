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

        if(DB::table('insurance')->where('class',$request->get('class'))->where('insurance_company',$request->get('insurance_company'))->where('insurance_type',$request->get('insurance_type'))->where('billing',$request->get('billing'))->exists()){


            return redirect()->back()->with("error","Insurance package already exists. Please try again ");

        }


        if ($request->get('price')<=$request->get('commission')) {

            return redirect()->back()->with("error","Commission cannot be greater than price. Please try again");
        }


        DB::table('insurance')->insert(
            ['class' => $request->get('class'),'insurance_company' => $request->get('insurance_company'),'insurance_type' => $request->get('insurance_type'), 'price' => $request->get('price'), 'commission' => $request->get('commission'),'commission_percentage'=>$request->get('commission_percentage'),'insurance_currency' => $request->get('insurance_currency'),'billing' => $request->get('billing')]
        );


        return redirect('/insurance')
            ->with('success', 'New Insurance package added successfully');
    }

    public function editInsurance(Request $request,$id)
    {

        if ($request->get('price')<=$request->get('commission')) {

            return redirect()->back()->with("error","Commission cannot be greater than price. Please try again");
        }

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

        DB::table('insurance')
            ->where('id', $id)
            ->update(['commission_percentage' => $request->get('commission_percentage')]);

        DB::table('insurance')
            ->where('id', $id)
            ->update(['insurance_currency' => $request->get('insurance_currency')]);

        DB::table('insurance')
            ->where('id', $id)
            ->update(['billing' => $request->get('billing')]);



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



    public function generateTypes(Request $request)
    {

        $insurance_types= DB::table('insurance')->where('insurance_company',$request->get(' insurance_company'))->where('class',$request->get(' insurance_class'))->get();
        $output='';


        $tempOut = array();
        foreach ($insurance_types as $values) {
            $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($values));
            $val = (iterator_to_array($iterator, true));
            $tempoIn = $val['insurance_type'];

            if (!in_array($tempoIn, $tempOut)) {
                $output .= '<option value="'.$val['insurance_type'].'">'.$val['insurance_type'].'</option>';
                array_push($tempOut, $tempoIn);
            }

        }


        echo $request->get(' insurance_company');




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
