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

        if($request->get('rent_price_guide_checkbox')==null){

        DB::table('spaces')->insert(
            ['space_id' => $request->get('space_id'),'space_type' => $request->get('space_type'), 'location' => $request->get('space_location'), 'size' => $request->get('space_size'),'rent_price_guide_from' => $request->get('rent_price_guide_from'),'rent_price_guide_to' => $request->get('rent_price_guide_to'),'rent_price_guide_currency' => $request->get('rent_price_guide_currency'),'rent_price_guide_checkbox' => 0]);
        }else{
        DB::table('spaces')->insert(
            ['space_id' => $request->get('space_id'),'space_type' => $request->get('space_type'), 'location' => $request->get('space_location'), 'size' => $request->get('space_size'),'rent_price_guide_from' => $request->get('rent_price_guide_from'),'rent_price_guide_to' => $request->get('rent_price_guide_to'),'rent_price_guide_currency' => $request->get('rent_price_guide_currency'),'rent_price_guide_checkbox' => 1]
        );
    }




        return redirect('/Space')
            ->with('success', 'New Renting space added successfully');
    }

    public function editSpace(Request $request,$id)
    {


        DB::table('spaces')
            ->where('id', $id)
            ->update(['space_id' => $request->get('space_id')]);

        DB::table('spaces')
            ->where('id', $id)
            ->update(['space_type' => $request->get('space_type')]);


        DB::table('spaces')
            ->where('id', $id)
            ->update(['location' => $request->get('space_location')]);

        DB::table('spaces')
            ->where('id', $id)
            ->update(['size' => $request->get('space_size')]);

        DB::table('spaces')
            ->where('id', $id)
            ->update(['rent_price_guide_from' => $request->get('rent_price_guide_from')]);

        DB::table('spaces')
            ->where('id', $id)
            ->update(['rent_price_guide_to' => $request->get('rent_price_guide_to')]);


        DB::table('spaces')
            ->where('id', $id)
            ->update(['rent_price_guide_currency' => $request->get('rent_price_guide_currency')]);

        if($request->get('rent_price_guide_checkbox')==null) {

            DB::table('spaces')
                ->where('id', $id)
                ->update(['rent_price_guide_checkbox' => 0]);
        }else {

            DB::table('spaces')
                ->where('id', $id)
                ->update(['rent_price_guide_checkbox' => 1]);

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


    public function autoCompleteSpaceId(Request $request)
    {



        if($request->get('query'))
        {
            $query = $request->get('query');
            $space_type=$request->get('space_type');
            $space_location=$request->get('space_location');

        $space_id=DB::table('spaces')->where('space_type',$space_type)->where('location',$space_location)->where('space_id', 'LIKE', "%{$query}%")->get();



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



    public function autoCompleteSpaceSize(Request $request)
    {



        if($request->get('selected_space_id'))
        {
            $selected_space_id = $request->get('selected_space_id');


            $space_size=DB::table('spaces')->where('space_id',$selected_space_id)->value('size');



            if($space_size!=null){

                echo $space_size;
            }
            else{
                echo "0";
            }

        }


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
