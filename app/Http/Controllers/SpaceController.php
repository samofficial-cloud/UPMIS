<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\space;

class SpaceController extends Controller
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
        $spaces=DB::table('spaces')->where('status',1)->get();



        return view('Space')->with('spaces',$spaces);
    }

    public function addSpace(Request $request)
    {

        if ($request->get('rent_price_guide_from')>$request->get('rent_price_guide_to')) {

            return redirect()->back()->with("error","'From' field cannot be greater than 'To' field. Please try again");
        }elseif($request->get('rent_price_guide_from')!=null AND $request->get('rent_price_guide_to')!=null  AND $request->get('rent_price_guide_from')==$request->get('rent_price_guide_to')){
            return redirect()->back()->with("error","'From' and 'To' fields cannot be equal. Please try again");

        }else{


        }

        $comments='';

        if($request->get('comments')!=null){
            $comments=$request->get('comments');

        }else{

            $comments='None';
        }





        if($request->get('rent_price_guide_checkbox')==null){

        DB::table('spaces')->insert(
            ['space_id' => $request->get('space_id'),'major_industry' => $request->get('major_industry'), 'location' => $request->get('space_location'), 'size' => $request->get('space_size'),'rent_price_guide_from' => '','rent_price_guide_to' => '','rent_price_guide_currency' => '','rent_price_guide_checkbox' => 0,'sub_location'=>$request->get('space_sub_location'),'minor_industry'=>$request->get('minor_industry'),'comments'=>$comments,'has_water_bill_space'=>$request->get('has_water_bill'),'has_electricity_bill_space'=>$request->get('has_electricity_bill')]);
        }else{
        DB::table('spaces')->insert(
            ['space_id' => $request->get('space_id'),'major_industry' => $request->get('major_industry'), 'location' => $request->get('space_location'), 'size' => $request->get('space_size'),'rent_price_guide_from' => $request->get('rent_price_guide_from'),'rent_price_guide_to' => $request->get('rent_price_guide_to'),'rent_price_guide_currency' => $request->get('rent_price_guide_currency'),'rent_price_guide_checkbox' => 1,'sub_location'=>$request->get('space_sub_location'),'minor_industry'=>$request->get('minor_industry'),'comments'=>$comments,'has_water_bill_space'=>$request->get('has_water_bill'),'has_electricity_bill_space'=>$request->get('has_electricity_bill')]
        );
    }




        return redirect('/Space')
            ->with('success', 'New Renting space added successfully');
    }

    public function editSpace(Request $request,$id)
    {

        if ($request->get('rent_price_guide_from')>$request->get('rent_price_guide_to')) {

            return redirect()->back()->with("error","'From' field cannot be greater than 'To' field. Please try again");
        }elseif($request->get('rent_price_guide_from')!=null AND $request->get('rent_price_guide_to')!=null  AND $request->get('rent_price_guide_from')==$request->get('rent_price_guide_to')){
            return redirect()->back()->with("error","'From' and 'To' fields cannot be equal. Please try again");

        }else{


        }

        DB::table('spaces')
            ->where('id', $id)
            ->update(['space_id' => $request->get('space_id')]);

        DB::table('spaces')
            ->where('id', $id)
            ->update(['major_industry' => $request->get('major_industry')]);


        DB::table('spaces')
            ->where('id', $id)
            ->update(['location' => $request->get('space_location')]);

        DB::table('spaces')
            ->where('id', $id)
            ->update(['sub_location' => $request->get('space_sub_location')]);


        DB::table('spaces')
            ->where('id', $id)
            ->update(['size' => $request->get('space_size')]);


        DB::table('spaces')
            ->where('id', $id)
            ->update(['minor_industry' => $request->get('minor_industry')]);

        DB::table('spaces')
            ->where('id', $id)
            ->update(['has_water_bill_space' => $request->get('has_water_bill')]);


        DB::table('spaces')
            ->where('id', $id)
            ->update(['has_electricity_bill_space' => $request->get('has_electricity_bill')]);


        $comments='';

        if($request->get('comments')!=null){
            $comments=$request->get('comments');

        }else{

            $comments='None';
        }


        DB::table('spaces')
            ->where('id', $id)
            ->update(['comments' => $comments]);



        if($request->get('rent_price_guide_checkbox')==null) {

            DB::table('spaces')
                ->where('id', $id)
                ->update(['rent_price_guide_checkbox' => 0]);


            DB::table('spaces')
                ->where('id', $id)
                ->update(['rent_price_guide_from' => '']);

            DB::table('spaces')
                ->where('id', $id)
                ->update(['rent_price_guide_to' => '']);



        }else {

            DB::table('spaces')
                ->where('id', $id)
                ->update(['rent_price_guide_checkbox' => 1]);

            DB::table('spaces')
                ->where('id', $id)
                ->update(['rent_price_guide_from' => $request->get('rent_price_guide_from')]);

            DB::table('spaces')
                ->where('id', $id)
                ->update(['rent_price_guide_to' => $request->get('rent_price_guide_to')]);

            DB::table('spaces')
                ->where('id', $id)
                ->update(['rent_price_guide_currency' => $request->get('rent_price_guide_currency')]);


        }

        return redirect('/Space')
            ->with('success', 'Renting space details edited successfully');
    }

    public function deleteSpace(Request $request,$id)
    {

        DB::table('spaces')
            ->where('id', $id)
            ->update(['status' => 0]);


        return redirect('/Space')
            ->with('success', 'Renting space deleted successfully');
    }


    public function spaceIdSuggestions(Request $request)
    {



        if($request->get('query'))
        {
            $query = $request->get('query');


        $space_id=DB::table('spaces')->where('space_id', 'LIKE', "%{$query}%")->where('status',1)->get();



            if(count($space_id)!=0){
                $output = '<ul class="dropdown-menu_custom" style="display:block; width: 100%; margin-top: -25px;
    margin-bottom: 10px; ">';
                foreach($space_id as $row)
                {
                    $output .= '
       <li id="listSpacePerTypeLocation">'.$row->space_id.'</li>
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



    public function autoCompleteSpaceFields(Request $request)
    {



        if($request->get('selected_space_id'))
        {
            $selected_space_id = $request->get('selected_space_id');


            $space_fields=DB::table('spaces')->where('space_id',$selected_space_id)->get();



            if($space_fields!=null){

                foreach ($space_fields as $space_field) {

                    $data = [
                        'major_industry'   => $space_field->major_industry,
                        'minor_industry'   => $space_field->minor_industry,
                        'location'   => $space_field->location,
                        'sub_location'   => $space_field->sub_location,
                        'size'   => $space_field->size,
                        'has_electricity_bill'   => $space_field->has_electricity_bill_space,
                        'has_water_bill'   => $space_field->has_water_bill_space,



                    ];

                }



                echo json_encode($data);
            }
            else{
                echo "0";
            }

        }


    }




    public function generateMinorList(Request $request) {


        $minor_industries= DB::table('space_classification')->where('major_industry',$request->get('major'))->get();
        $output='';

foreach($minor_industries as $minor_industry) {

    $output .= '<option value="'.$minor_industry->minor_industry.'">'.$minor_industry->minor_industry.'</option>';


}

        echo $output;


    }




    public function fetchspaceid(Request $request)
    {
     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = space::where('space_id', 'LIKE', "%{$query}%")->get();
      if(count($data)!=0){
      $output = '<ul class="dropdown-menu form-card" style="display: block;
    width: 100%; margin-left: 0%; margin-top: -3%;">';
      foreach($data as $row)
      {
       $output .= '
       <li id="list" style="margin-left: -3%;">'.$row->space_id.'</li>
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




}
