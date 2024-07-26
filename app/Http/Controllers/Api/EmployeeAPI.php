<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class EmployeeAPI extends Controller
{
    use ApiResponse;
    //
    public function getEmployees(Request $request){
        $where = [];
        // email number search
        if($request->get('email')){
            $email = $request->get('email');
            $where [] = DB::raw('email LIKE %' . $email . '%'); 
        }
         // contact no search
         if($request->get('mobile')){
            $mobile = $request->get('mobile');
            $where [] = DB::raw( 'contact_no LIKE %' . $mobile . '%'); 
        }
        // register no search
        if($request->get('reg_no')){
            $registerNo = $request->get('reg_no');
            $where [] = DB::raw('register_no LIKE %' . $registerNo . '%'); 
        }
        
        if( count($where) > 0 ){
            $where = implode(" AND ", $where );
            $employees = Employee::where($where)->get();
        } else {
            $employees = Employee::all();
        }
        
        return response()->json($employees);
    }
    /**
     * Summary of getEmployee based on either email, mobile or reg no or search by combination of those data
     * @param \Illuminate\Http\Request $request
     * @param mixed $searchBy
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployee(Request $request){
        
        $where = [];
        // email number search
        if($request->get('email')){
            $email = $request->get('email');
            $where [] = DB::raw( 'email LIKE %' . $email . '%'); 
        }
         // contact no search
         if($request->get('mobile')){
            $mobile = $request->get('mobile');
            $where [] = DB::raw( 'contact_no LIKE %' . $mobile . '%'); 
        }
        // register no search
        if($request->get('reg_no')){
            $registerNo = $request->get('reg_no');
            $where [] = DB::raw('register_no LIKE %' . $registerNo . '%'); 
        }
        $where = implode(" AND ", $where );
        $employee = [];
        if( count($where) > 0 ){
            $employee = Employee::where($where)->first();
        } 
        return $this->success('Data retrieved successfully', $employee);
        
    }
    /**
     * Summary of getEmployeeByEmail
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployeeByEmail(Request $request){
        $email = $request->get('email');
        if(empty($email)){
            return $this->error('Email is mandatory');
        }
        $employee = Employee::where('email', $email)->first();
        if( $employee ){
            return $this->success('Data retrieved successfully', $employee);
        } else {
            return $this->error('The given email doesnot have the data');
        }
    }
    /**
     * Summary of getEmployeeByRegistrationNumber
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployeeByRegisterNumber(Request $request){
        $reg_no = $request->get('reg_no');
        if(empty($reg_no)){
            return $this->error('Registration Number is mandatory, Please use \'reg_no\' as the parameter to send');
        }
        $employee = Employee::where('register_no', $reg_no)->first();
        if( $employee ){
            return $this->success('Data retrieved successfully', $employee);
        } else {
            return $this->error('The given registered no doesnot have the data');
        }
    }

    /**
     * Summary of getEmployeeByContactNumber
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployeeByContactNumber(Request $request){
        $mobile = $request->get('mobile');
        if(empty($mobile)){
            return $this->error('Mobile Number is mandatory, Please use \'mobile\' as the parameter to send');
        }
        $employee = Employee::where('contact_no', $mobile)->first();
        if( $employee ){
            return $this->success('Data retrieved successfully', $employee);
        } else {
            return $this->error('The given contact number doesnot have the data');
        }
    }

}