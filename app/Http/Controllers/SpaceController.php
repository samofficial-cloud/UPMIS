<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        DB::table('spaces')->insert(
            ['space_id' => $request->get('space_id'),'type' => $request->get('space_type'), 'location' => $request->get('space_location'), 'size' => $request->get('space_size'),'rent_price_guide' => $request->get('rent_price_guide')]
        );


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
            ->update(['type' => $request->get('space_type')]);


        DB::table('spaces')
            ->where('id', $id)
            ->update(['location' => $request->get('space_location')]);



        DB::table('spaces')
            ->where('id', $id)
            ->update(['size' => $request->get('space_size')]);

        DB::table('spaces')
            ->where('id', $id)
            ->update(['rent_price_guide' => $request->get('rent_price_guide')]);


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

}
