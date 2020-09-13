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


    public function roleManagement()
    {
        $roles=DB::table('general_settings')->get();
        return view('role_management')->with('roles',$roles);
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


        $cost_centre=$request->get('cost_centre');
if($request->get('cost_centre')=='')
    {
        $cost_centre='N/A';

    }


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

        DB::table('users')
            ->where('id', $id)
            ->update(['cost_centre' => $cost_centre]);



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
            'cost_centre' => $request->get('cost_centre'),
            'password' => Hash::make($default_password)

        ]);



        return redirect('/user_role_management')
            ->with('success', 'User added successfully');
    }




    public function addRole(Request $request)
    {


        if(DB::table('general_settings')->where('user_roles',$request->get('user_roles'))->exists()){


            return redirect()->back()->with("error","Role already exists, please try again");

        }



        DB::table('general_settings')->insert([

            'user_roles' => $request->get('user_roles'),
            'category' => $request->get('category'),

        ]);



        return redirect('/role_management')
            ->with('success', 'Role added successfully');
    }



    public function editRole(Request $request,$id)
    {


        DB::table('general_settings')
            ->where('id', $id)
            ->update(['user_roles' => $request->get('user_roles')]);


        DB::table('general_settings')
            ->where('id', $id)
            ->update(['category' => $request->get('category')]);


        return redirect('/role_management')
            ->with('success', 'Role information edited successfully');
    }


    public function deleteRole($id)
    {


        DB::table('general_settings')
            ->where('id', $id)->delete();


        return redirect('/role_management')
            ->with('success', 'Role deleted successfully');
    }



}
