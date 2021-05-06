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

        DB::table('users')->insert([
            'name' => $name,
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'user_name' => $user_name,
            'email' => $request->get('email'),
            'phone_number' => $request->get('phone_number'),
            'role' => $request->get('role'),
            'cost_centre' => $cost_centre,
            'password' => Hash::make($default_password),
            'password_flag' => 0

        ]);



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

            DB::table('general_settings')->insert([

                'user_roles' => 'DVC Administrator',
                'category' => $request->get('category'),
                'privileges' => $request->get('privileges'),

            ]);

        }else{

            DB::table('general_settings')->insert([

                'user_roles' => $request->get('user_roles'),
                'category' => $request->get('category'),
                'privileges' => $request->get('privileges'),

            ]);

        }







        return redirect('/role_management')
            ->with('success', 'Role added successfully');
    }



    public function addInsuranceCompany(Request $request)
    {


        if(DB::table('insurance_parameters')->where('company',$request->get('company'))->exists()){


            return redirect()->back()->with("error","Company already exists, please try again");

        }



        DB::table('insurance_parameters')->insert([

            'company' => $request->get('company'),
            'company_email' => $request->get('company_email'),
            'company_address' => $request->get('company_address'),
            'company_tin' => $request->get('company_tin'),
            'classes' => '',

        ]);



        return redirect('/insurance_companies')
            ->with('success', 'Insurance company added successfully');
    }




    public function addInsuranceClass(Request $request)
    {


        if(DB::table('insurance_parameters')->where('classes',$request->get('classes'))->exists()){


            return redirect()->back()->with("error","Insurance class already exists, please try again");

        }



        DB::table('insurance_parameters')->insert([

            'classes' => $request->get('classes'),
            'company' => '',

        ]);



        return redirect('/insurance_classes')
            ->with('success', 'Insurance class added successfully');
    }



    public function editRole(Request $request,$id)
    {


        DB::table('general_settings')
            ->where('id', $id)
            ->update(['user_roles' => $request->get('user_roles')]);


        DB::table('general_settings')
            ->where('id', $id)
            ->update(['category' => $request->get('category')]);


        DB::table('general_settings')
            ->where('id', $id)
            ->update(['privileges' => $request->get('privileges')]);


        return redirect('/role_management')
            ->with('success', 'Role information edited successfully');
    }







    public function editInsuranceCompany(Request $request,$id)
    {


        DB::table('insurance_parameters')
            ->where('id', $id)
            ->update(['company' => $request->get('company')]);


        DB::table('insurance_parameters')
            ->where('id', $id)
            ->update(['company_email' => $request->get('company_email')]);



        DB::table('insurance_parameters')
            ->where('id', $id)
            ->update(['company_address' => $request->get('company_address')]);


        DB::table('insurance_parameters')
            ->where('id', $id)
            ->update(['company_tin' => $request->get('company_tin')]);



        return redirect('/insurance_companies')
            ->with('success', 'Insurance company information edited successfully');
    }


    public function editInsuranceClass(Request $request,$id)
    {

        DB::table('insurance_parameters')
            ->where('id', $id)
            ->update(['classes' => $request->get('classes')]);

        return redirect('/insurance_classes')
            ->with('success', 'Insurance class information edited successfully');
    }


    public function deleteRole($id)
    {


        DB::table('general_settings')
            ->where('id', $id)->delete();


        return redirect('/role_management')
            ->with('success', 'Role deleted successfully');
    }


    public function deleteInsuranceCompany($id)
    {

            DB::table('insurance_parameters')
                ->where('id', $id)
                ->delete();

        return redirect('/insurance_companies')
            ->with('success', 'Insurance company deleted successfully');
    }


    public function deleteInsuranceClass($id)
    {

            DB::table('insurance_parameters')
                ->where('id', $id)
                ->delete();


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

        DB::table('system_settings')
            ->where('id', 1)
            ->update(['financial_year' => $request->get('financial_year')]);


        DB::table('system_settings')
            ->where('id', 1)
            ->update(['max_no_of_days_to_pay_invoice' => $request->get('max_no_of_days_to_pay_invoice')]);





        DB::table('system_settings')
            ->where('id', 1)
            ->update(['insurance_percentage' => $insurance_percentage]);


        DB::table('system_settings')
            ->where('id', 1)
            ->update(['insurance_invoice_start_day' => $request->get('insurance_invoice_start_day')]);


        DB::table('system_settings')
            ->where('id', 1)
            ->update(['insurance_invoice_end_day' => $request->get('insurance_invoice_end_day')]);


        DB::table('system_settings')
            ->where('id', 1)
            ->update(['day_for_insurance_invoice' => $request->get('day_for_insurance_invoice')]);





        DB::table('system_settings')
            ->where('id', 1)
            ->update(['space_invoice_start_day' => $request->get('space_invoice_start_day')]);


        DB::table('system_settings')
            ->where('id', 1)
            ->update(['space_invoice_end_day' => $request->get('space_invoice_end_day')]);


        DB::table('system_settings')
            ->where('id', 1)
            ->update(['day_to_send_space_invoice' => $request->get('day_to_send_space_invoice')]);





        DB::table('system_settings')
            ->where('id', 1)
            ->update(['default_password' => $request->get('default_password')]);


        DB::table('system_settings')
            ->where('id', 1)
            ->update(['days_in_advance_for_invoices' => $request->get('days_in_advance_for_invoices')]);


        DB::table('system_settings')
            ->where('id', 1)
            ->update(['semester_one_start' => $request->get('semester_one_start')]);


        DB::table('system_settings')
            ->where('id', 1)
            ->update(['semester_one_end' => $request->get('semester_one_end')]);


        DB::table('system_settings')
            ->where('id', 1)
            ->update(['semester_two_start' => $request->get('semester_two_start')]);



        DB::table('system_settings')
            ->where('id', 1)
            ->update(['semester_two_end' => $request->get('semester_two_end')]);



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
