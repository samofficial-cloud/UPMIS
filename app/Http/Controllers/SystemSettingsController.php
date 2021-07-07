<?php

namespace App\Http\Controllers;

use App\GeneralSetting;
use App\insurance_parameter;
use App\SystemSetting;
use App\User;
use App\users;
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


        $system_settings=DB::table('system_settings')->where('id',1)->get();

        return view('system_settings')->with('system_settings',$system_settings);
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

        $user=User::find($id);
        $user->status=0;
        $user->save();

        return redirect('/user_role_management')
            ->with('success', 'User deactivated successfully');
    }


    public function activateUser($id)
    {

        $user=User::find($id);
        $user->status=1;
        $user->save();

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

        $user=User::find($id);
        $user->name=$name;
        $user->first_name=$request->get('first_name');
        $user->last_name=$request->get('last_name');
        $user->user_name=$user_name;
        $user->email=$request->get('email');
        $user->phone_number=$request->get('phone_number');
        $user->role=$request->get('role');
        $user->cost_centre=$cost_centre;
        $user->save();


        return redirect('/user_role_management')
            ->with('success', 'User information edited successfully');
    }



    public function addUser(Request $request)
    {

        $cost_centre='';

        if($request->get('cost_centre')==''){
            $cost_centre='N/A';

        }else{

            $cost_centre=$request->get('cost_centre');
        }

        $name=$request->get('first_name').' '.$request->get('last_name');

        $user_name=strtolower($request->get('first_name')[0]).strtolower($request->get('last_name'));
        $existing_roles=DB::table('users')->where('user_name',$user_name)->get();

        foreach($existing_roles as $role){
        if (DB::table('users')->where('user_name', $user_name)->where('role',$request->get('role'))->exists()) {


            return redirect()->back()->with("error", "User already exists, please try again");

        }
    }

        $default_password=DB::table('system_settings')->where('id',1)->value('default_password');


        $user= new User();
        $user->name=$name;
        $user->first_name=$request->get('first_name');
        $user->last_name=$request->get('last_name');
        $user->user_name=$user_name;
        $user->email=$request->get('email');
        $user->phone_number=$request->get('phone_number');
        $user->role=$request->get('role');
        $user->cost_centre=$cost_centre;
        $user->password=Hash::make($default_password);
        $user->password_flag=0;
        $user->save();


        return redirect('/user_role_management')
            ->with('success', 'User added successfully');
    }




    public function addRole(Request $request)
    {


        if(DB::table('general_settings')->where('user_roles',$request->get('user_roles'))->exists()){


            return redirect()->back()->with("error","Role already exists, please try again");

        }


        $received_role=strtolower($request->get('user_roles'));

        if($received_role=='dvc administration' || $received_role=='dvc adminstration'){

            $generalSetting= new GeneralSetting();
            $generalSetting->user_roles='DVC Administrator';
            $generalSetting->category=$request->get('category');
            $generalSetting->privileges=$request->get('privileges');
            $generalSetting->save();

        }else{

            $generalSetting= new GeneralSetting();
            $generalSetting->user_roles=$request->get('user_roles');
            $generalSetting->category=$request->get('category');
            $generalSetting->privileges=$request->get('privileges');
            $generalSetting->save();

        }

        return redirect('/role_management')
            ->with('success', 'Role added successfully');
    }



    public function addInsuranceCompany(Request $request)
    {

        if(DB::table('insurance_parameters')->where('company',$request->get('company'))->exists()){


            return redirect()->back()->with("error","Company already exists, please try again");

        }


        $insuranceParameter= new insurance_parameter();
        $insuranceParameter->company=$request->get('company');
        $insuranceParameter->company_email=$request->get('company_email');
        $insuranceParameter->company_address=$request->get('company_address');
        $insuranceParameter->company_tin=$request->get('company_tin');
        $insuranceParameter->classes='';
        $insuranceParameter->save();


        return redirect('/insurance_companies')
            ->with('success', 'Insurance company added successfully');
    }




    public function addInsuranceClass(Request $request)
    {


        if(DB::table('insurance_parameters')->where('classes',$request->get('classes'))->exists()){


            return redirect()->back()->with("error","Insurance class already exists, please try again");

        }


        $insuranceParameter= new insurance_parameter();
        $insuranceParameter->company='';
        $insuranceParameter->classes=$request->get('classes');
        $insuranceParameter->save();



        return redirect('/insurance_classes')
            ->with('success', 'Insurance class added successfully');
    }



    public function editRole(Request $request,$id)
    {

        $generalSetting= GeneralSetting::find($id);
        $generalSetting->user_roles=$request->get('user_roles');
        $generalSetting->category=$request->get('category');
        $generalSetting->privileges=$request->get('privileges');
        $generalSetting->save();


        return redirect('/role_management')
            ->with('success', 'Role information edited successfully');
    }







    public function editInsuranceCompany(Request $request,$id)
    {

        $insuranceParameter= insurance_parameter::find($id);
        $insuranceParameter->company=$request->get('company');
        $insuranceParameter->company_email=$request->get('company_email');
        $insuranceParameter->company_address=$request->get('company_address');
        $insuranceParameter->company_tin=$request->get('company_tin');
        $insuranceParameter->save();


        return redirect('/insurance_companies')
            ->with('success', 'Insurance company information edited successfully');
    }


    public function editInsuranceClass(Request $request,$id)
    {

        $insuranceParameter= insurance_parameter::find($id);
        $insuranceParameter->classes=$request->get('classes');
        $insuranceParameter->save();

        return redirect('/insurance_classes')
            ->with('success', 'Insurance class information edited successfully');
    }


    public function deleteRole($id)
    {

        $generalSetting= GeneralSetting::find($id);
        $generalSetting->delete();


        return redirect('/role_management')
            ->with('success', 'Role deleted successfully');
    }


    public function deleteInsuranceCompany($id)
    {


        $insuranceParameter= insurance_parameter::find($id);
        $insuranceParameter->delete();


        return redirect('/insurance_companies')
            ->with('success', 'Insurance company deleted successfully');
    }


    public function deleteInsuranceClass($id)
    {



        $insuranceParameter= insurance_parameter::find($id);
        $insuranceParameter->delete();


        return redirect('/insurance_classes')
            ->with('success', 'Insurance class deleted successfully');
    }


    public function EditSystemSettings(Request $request)
    {

        if ($request->get('semester_one_start')>$request->get('semester_one_end')) {

            return redirect()->back()->with("error","Semester one start date cannot be greater than semester one end date. Please try again");
        }


        if ($request->get('semester_two_start')>$request->get('semester_two_end')) {

            return redirect()->back()->with("error","Semester two start date cannot be greater than semester two end date. Please try again");
        }

        if ($request->get('semester_one_start')>$request->get('semester_two_start')) {

            return redirect()->back()->with("error","Semester one date(s) cannot be greater than semester two date(s). Please try again");
        }

        if ($request->get('semester_one_start')>$request->get('semester_two_end')) {

            return redirect()->back()->with("error","Semester one date(s) cannot be greater than semester two date(s). Please try again");
        }


        if ($request->get('semester_one_end')>$request->get('semester_two_end')) {

            return redirect()->back()->with("error","Semester one date(s) cannot be greater than semester two date(s). Please try again");
        }


        if ($request->get('semester_one_end')>$request->get('semester_two_start')) {

            return redirect()->back()->with("error","Semester one date(s) cannot be greater than semester two date(s). Please try again");
        }



        $insurance_percentage=$request->get('insurance_percentage')/100;


        $systemSetting=SystemSetting::find(1);
        $systemSetting->financial_year=$request->get('financial_year');
        $systemSetting->max_no_of_days_to_pay_invoice=$request->get('max_no_of_days_to_pay_invoice');
        $systemSetting->insurance_percentage=$insurance_percentage;
        $systemSetting->insurance_invoice_start_day=$request->get('insurance_invoice_start_day');
        $systemSetting->insurance_invoice_end_day=$request->get('insurance_invoice_end_day');
        $systemSetting->day_for_insurance_invoice=$request->get('day_for_insurance_invoice');
        $systemSetting->space_invoice_start_day=$request->get('space_invoice_start_day');
        $systemSetting->space_invoice_end_day=$request->get('space_invoice_end_day');
        $systemSetting->day_to_send_space_invoice=$request->get('day_to_send_space_invoice');
        $systemSetting->unit_price_water=$request->get('unit_price_water');
        $systemSetting->unit_price_electricity=$request->get('unit_price_electricity');
        $systemSetting->default_password=$request->get('default_password');
        $systemSetting->days_in_advance_for_invoices=$request->get('days_in_advance_for_invoices');
        $systemSetting->semester_one_start=$request->get('semester_one_start');
        $systemSetting->semester_one_end=$request->get('semester_one_end');
        $systemSetting->semester_two_start=$request->get('semester_two_start');
        $systemSetting->semester_two_end=$request->get('semester_two_end');
        $systemSetting->save();


        return redirect('/system_settings')
            ->with('success', 'Changes saved successfully');
    }


    public function InsuranceClasses()
    {


    $insurance_classes=DB::table('insurance_parameters')->where('classes','!=','')->get();

        return view('insurance_classes')->with('insurance_classes',$insurance_classes);
    }


    public function InsuranceCompanies()
    {

        $insurance_companies=DB::table('insurance_parameters')->where('company','!=','')->get();

        return view('insurance_companies')->with('insurance_companies',$insurance_companies);
    }



}
