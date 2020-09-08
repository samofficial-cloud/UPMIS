<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\space;
use Illuminate\Support\Facades\Hash;

class SystemSettingsController extends Controller
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




        return view('system_settings');
    }


    public function userRoleManagement()
    {
        $users=DB::table('users')->get();
        return view('user_role_management')->with('users',$users);
    }


    public function deactivateUser($id)
    {

        DB::table('users')
            ->where('id', $id)
            ->update(['status' => 0]);


        return redirect('/user_role_management')
            ->with('success', 'User deactivated successfully');
    }


    public function activateUser($id)
    {

        DB::table('users')
            ->where('id', $id)
            ->update(['status' => 1]);


        return redirect('/user_role_management')
            ->with('success', 'User activated successfully');
    }

    public function editUser($id,Request $request)
    {

        $name=$request->get('first_name').' '.$request->get('last_name');

        $user_name=strtolower($request->get('first_name')[0]).strtolower($request->get('last_name'));



        DB::table('users')
            ->where('id', $id)
            ->update(['name' => $name]);

        DB::table('users')
            ->where('id', $id)
            ->update(['first_name' => $request->get('first_name')]);


        DB::table('users')
            ->where('id', $id)
            ->update(['last_name' => $request->get('last_name')]);

        DB::table('users')
            ->where('id', $id)
            ->update(['user_name' => $user_name]);

        DB::table('users')
            ->where('id', $id)
            ->update(['email' => $request->get('email')]);

        DB::table('users')
            ->where('id', $id)
            ->update(['phone_number' => $request->get('phone_number')]);


        DB::table('users')
            ->where('id', $id)
            ->update(['role' => $request->get('role')]);




        return redirect('/user_role_management')
            ->with('success', 'User information edited successfully');
    }



    public function addUser(Request $request)
    {

        $name=$request->get('first_name').' '.$request->get('last_name');

        $user_name=strtolower($request->get('first_name')[0]).strtolower($request->get('last_name'));

        if(DB::table('users')->where('user_name',$user_name)->exists()){


            return redirect()->back()->with("error","User already exists, please try again");

        }


        $default_password=DB::table('system_settings')->where('id',1)->value('default_password');

        DB::table('users')->insert([
            'name' => $name,
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'user_name' => $user_name,
            'email' => $request->get('email'),
            'phone_number' => $request->get('phone_number'),
            'role' => $request->get('role'),
            'password' => Hash::make($default_password)

        ]);



        return redirect('/user_role_management')
            ->with('success', 'User added successfully');
    }




}
