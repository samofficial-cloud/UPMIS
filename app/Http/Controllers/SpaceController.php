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


        $code_name=DB::table('space_classification')->where('minor_industry',$request->get('minor_industry'))->value('code_name');

        $space_id_number=DB::table('spaces')->where('space_id_code',$code_name)->orderBy('id','desc')->limit(1)->value('space_id_number');


        $integer = '';
        $incremented = '';
        $new_space_id_number = '';

        if($space_id_number!="") {


            $integer = ltrim($space_id_number, '0');
            $incremented = $integer + 1;
            $new_space_id_number = sprintf("%04d", $incremented);

        }else{


            $incremented = 1;
            $new_space_id_number = sprintf("%04d", $incremented);

        }

        $final_space_id=$code_name.''.$new_space_id_number;

        $comments='';

        if($request->get('comments')!=null){
            $comments=$request->get('comments');

        }else{

            $comments='None';
        }





        if($request->get('rent_price_guide_checkbox')==null){

//        DB::table('spaces')->insert(
//            ['space_id' => $final_space_id,'space_id_code'=>$code_name,'space_id_number'=>$new_space_id_number,'major_industry' => $request->get('major_industry'), 'location' => $request->get('space_location'), 'size' => $request->get('space_size'),'rent_price_guide_from' => '','rent_price_guide_to' => '','rent_price_guide_currency' => '','rent_price_guide_checkbox' => 0,'sub_location'=>$request->get('space_sub_location'),'minor_industry'=>$request->get('minor_industry'),'comments'=>$comments,'has_water_bill_space'=>$request->get('has_water_bill'),'has_electricity_bill_space'=>$request->get('has_electricity_bill')]);

        $space= new space();
        $space->space_id=$final_space_id;
        $space->space_id_code=$code_name;
        $space->space_id_number=$new_space_id_number;
        $space->major_industry=$request->get('major_industry');
        $space->location=$request->get('space_location');
        $space->size=$request->get('space_size');
        $space->rent_price_guide_checkbox=0;
        $space->sub_location=$request->get('space_sub_location');
        $space->minor_industry=$request->get('minor_industry');
        $space->comments=$comments;
        $space->has_water_bill_space=$request->get('has_water_bill');
        $space->has_electricity_bill_space=$request->get('has_electricity_bill');

        $space->save();


        }else{
//        DB::table('spaces')->insert(
//            ['space_id' => $final_space_id,'space_id_code'=>$code_name,'space_id_number'=>$new_space_id_number,'major_industry' => $request->get('major_industry'), 'location' => $request->get('space_location'), 'size' => $request->get('space_size'),'rent_price_guide_from' => $request->get('rent_price_guide_from'),'rent_price_guide_to' => $request->get('rent_price_guide_to'),'rent_price_guide_currency' => $request->get('rent_price_guide_currency'),'rent_price_guide_checkbox' => 1,'sub_location'=>$request->get('space_sub_location'),'minor_industry'=>$request->get('minor_industry'),'comments'=>$comments,'has_water_bill_space'=>$request->get('has_water_bill'),'has_electricity_bill_space'=>$request->get('has_electricity_bill')]
//        );

            $space= new space();
            $space->space_id=$final_space_id;
            $space->space_id_code=$code_name;
            $space->space_id_number=$new_space_id_number;
            $space->major_industry=$request->get('major_industry');
            $space->location=$request->get('space_location');
            $space->size=$request->get('space_size');
            $space->rent_price_guide_from=$request->get('rent_price_guide_from');
            $space->rent_price_guide_to=$request->get('rent_price_guide_to');
            $space->rent_price_guide_currency=$request->get('rent_price_guide_currency');


            $space->rent_price_guide_checkbox=1;
            $space->sub_location=$request->get('space_sub_location');
            $space->minor_industry=$request->get('minor_industry');
            $space->comments=$comments;
            $space->has_water_bill_space=$request->get('has_water_bill');
            $space->has_electricity_bill_space=$request->get('has_electricity_bill');

            $space->save();






    }

        $newly_created_space_id=DB::table('spaces')->orderBy('id','desc')->limit('1')->value('id');

//        DB::table('spaces')->where('id',$newly_created_space_id)->update(['flag'=>0]);
        DB::table('spaces')
            ->where('id', $newly_created_space_id)
            ->update(['flag' => '0']);


        return redirect('/businesses')
            ->with('success', 'Request sent successfully');
    }




    public function approveSpace(Request $request)
    {

        if($request->get('approval_status')=='Rejected'){

            DB::table('spaces')
                ->where('id', $request->get('id'))
                ->update(['flag' => '1']);


            DB::table('spaces')
                ->where('id', $request->get('id'))
                ->update(['approval_remarks' => $request->get('reason')]);

        }else{

            DB::table('spaces')
                ->where('id', $request->get('id'))
                ->update(['flag' => '2']);

        }



        return redirect('/businesses')
            ->with('success', 'Operation completed successfully');
    }



    public function CancelSpaceAddition(Request $request,$id)
    {

        DB::table('spaces')
            ->where('id', $id)
            ->delete();

        return redirect('/businesses')
            ->with('success', 'Space deleted successfully');
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

        return redirect('/businesses')
            ->with('success', 'Renting space details edited successfully');
    }



    public function ResubmitSpace(Request $request,$id)
    {

        if ($request->get('rent_price_guide_from')>$request->get('rent_price_guide_to')) {

            return redirect()->back()->with("error","'From' field cannot be greater than 'To' field. Please try again");
        }elseif($request->get('rent_price_guide_from')!=null AND $request->get('rent_price_guide_to')!=null  AND $request->get('rent_price_guide_from')==$request->get('rent_price_guide_to')){
            return redirect()->back()->with("error","'From' and 'To' fields cannot be equal. Please try again");

        }else{


        }



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


        DB::table('spaces')
            ->where('id', $id)
            ->update(['flag' => '0']);


        return redirect('/businesses')
            ->with('success', 'Request sent successfully');
    }



    public function deleteSpace(Request $request,$id)
    {

        DB::table('spaces')
            ->where('id', $id)
            ->update(['status' => 0]);


        return redirect('/businesses')
            ->with('success', 'Renting space deactivated successfully');
    }


    public function spaceIdSuggestions(Request $request)
    {



        if($request->get('query'))
        {
            $query = $request->get('query');


        $space_id=DB::table('spaces')->where('space_id', 'LIKE', "%{$query}%")->where('status',1)->where('occupation_status',0)->get();



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
        $output .= '<option value="'."".'">'."".'</option>';

        $tempOut = array();

foreach($minor_industries as $minor_industry) {

    $tempoIn=$minor_industry->minor_industry;
    if(!in_array($tempoIn, $tempOut)) {
        $output .= '<option value="' . $minor_industry->minor_industry . '">' . $minor_industry->minor_industry . '</option>';
        array_push($tempOut,$tempoIn);
    }
}

        echo $output;


    }










    public function generateLocationList(Request $request) {


        $locations= DB::table('spaces')->where('minor_industry',$request->get('minor'))->where('major_industry',$request->get('major'))->get();
        $output='';
        $output .= '<option value="'."".'">'."".'</option>';

        $tempOut = array();
        foreach($locations as $location) {
            $tempoIn=$location->location;

            if(!in_array($tempoIn, $tempOut)) {
                $output .= '<option value="' . $location->location . '">' . $location->location . '</option>';
                array_push($tempOut,$tempoIn);
            }

        }

        echo $output;


    }


    public function generateSubLocationList(Request $request) {


        $sub_locations= DB::table('spaces')->where('location',$request->get('location'))->where('major_industry',$request->get('major'))->where('minor_industry',$request->get('minor'))->get();
        $output='';
        $output .= '<option value="'."".'">'."".'</option>';

        $tempOut = array();
        foreach($sub_locations as $sub_location) {
            $tempoIn=$sub_location->sub_location;
            if(!in_array($tempoIn, $tempOut))
            {
            $output .= '<option value="'.$sub_location->sub_location.'">'.$sub_location->sub_location.'</option>';
                array_push($tempOut,$tempoIn);
            }

        }

        echo $output;


    }


    public function generateSpaceIdList(Request $request) {


        $space_ids= DB::table('spaces')->where('sub_location',$request->get('sub_location'))->where('location',$request->get('location'))->where('major_industry',$request->get('major'))->where('minor_industry',$request->get('minor'))->get();
        $output='';
        $output .= '<option value="'."".'">'."".'</option>';
        $tempOut = array();
        foreach($space_ids as $space_id) {
            $tempoIn=$space_id->space_id;
            if(!in_array($tempoIn, $tempOut))
            {
            $output .= '<option value="'.$space_id->space_id.'">'.$space_id->space_id.'</option>';
                array_push($tempOut,$tempoIn);
            }

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




    public function conferencesManagement(Request $request)
    {


        $events=DB::table('conference_events')->where('status',1)->get();

        return View('conferences_management')->with('events',$events);



    }



    public function addEvent(Request $request)
    {



        DB::table('conference_events')->insert(['client_name' =>$request->get('client_name'), 'conference_id' => $request->get('conference_id'), 'event_description' => $request->get('event_description'),'rent' =>  $request->get('rent'),'rent_currency' =>  $request->get('rent_currency'),'event_date' =>  $request->get('event_date')]);



        return redirect()->back()->with("success","Event Added Successfully");



    }


    public function editEvent(Request $request,$id)
    {


        DB::table('conference_events')
            ->where('id', $id)
            ->update(['client_name' =>$request->get('client_name')]);



        DB::table('conference_events')
            ->where('id', $id)
            ->update(['conference_id' => $request->get('conference_id')]);




        DB::table('conference_events')
            ->where('id', $id)
            ->update(['event_description' => $request->get('event_description')]);

        DB::table('conference_events')
            ->where('id', $id)
            ->update(['rent' =>  $request->get('rent')]);




        DB::table('conference_events')
            ->where('id', $id)
            ->update(['rent_currency' =>  $request->get('rent_currency')]);



        DB::table('conference_events')
            ->where('id', $id)
            ->update(['event_date' =>  $request->get('event_date')]);



        return redirect()->back()->with("success","Event Edited Successfully");



    }




    public function deleteEvent($id)
    {

        DB::table('conference_events')
            ->where('id', $id)
            ->update(['status' =>  0]);


        return redirect()->back()->with("success","Event deleted Successfully");


    }




 public function fetchspaceidss(Request $request){
if($request->get('query')){
    $data = space::select('space_id', 'sub_location')->where('major_industry', $request->get('query'))->where('flag',2)->orderBy('space_id','asc')->get();
     if(count($data)!=0){
        $output = '<select class="form-control" id="space_id" name="space_id">';
        $output .='<option value="" disabled selected hidden>Select Space</option>';
          foreach($data as $row){
            $output .= '<option value="'.$row->space_id.'"> '.$row->space_id.' - '.$row->sub_location.'</option>';
          }
        $output .= '</select>';
        echo $output;
     }
     else{
         $output = '<select class="form-control" id="space_id" name="space_id">';
        $output .='<option value="" disabled selected hidden>No any registered space for this industry</option>';
        echo $output;
     }
  }
}




}
