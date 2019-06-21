<?php 
namespace App\Http\Controllers\admin;

use App\ViewModels\ServiceResponse;
use Session;
use view;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Infrastructure\Constants;
use App\admin\UserModel;
use Illuminate\Support\Facades\Log;
use App\Infrastructure\Common;
use DB;
use stdClass;


class UserController extends BaseController {
   
    
    /*edit user profile*/
    public function editProfile($encryptedID){	 
       
        $decryptedID = Common::getDecryptedValue($encryptedID);
        $id = Common::getParamValue($decryptedID, Constants::$QueryStringUserID);
        
        $user = UserModel::find($id);
        $user->encryptedUserID = $encryptedID;
       
        return view('admin.user.edit_profile', compact('user'));
    }
    
	
    /*update user profile*/	
    public function updateprofile(Request $request,$encryptedID){	
        $decryptedID = Common::getDecryptedValue($encryptedID);
        $id = Common::getParamValue($decryptedID, Constants::$QueryStringUserID);
	try{
            $rules = [ 
                'user_name' => 'required',
                'email' => 'required',			
                'mobile_no' => 'required'			
            ];
            $messages = [ 
                'email.required'  => 'Email Name is required',
                'user_name'  => 'Name is required',		
                'mobile_no'  => 'Mobile Number is required'		
            ];  
          
            $validator = Validator::make(Input::all(), $rules, $messages);
            
            if ($validator->fails()) {  
                return redirect(route('admin_editprofile',$encryptedID)) ->withErrors($validator)->withInput(); 
            } else {  		 
                UserModel::updateUserProfile($request,$id);
                Session::flash('success',trans('messages.successProfile'));
                return redirect(route('admin_editprofile',$encryptedID)); 			   	   
            }              
        }catch(\Exception $e){
            Log::error('UserController->updateprofile' . $e->getCode());
        } 
    } 
    
    public function changeUserPassword(){
        return view('admin.security.changepassword');
    }
    
    public function storeChangePassword(Request $request) {
           try{     
            $rules = [
                'currentpassword' => 'required',
                'newpassword' => 'required',				
                'confirmpassword' => 'required',
            ];
            $messages = [
                'currentpassword.required' => 'Current Password is required',
                'newpassword.required' => 'New Password is required',
                'confirmpassword.required' => 'Confirm Password is required',				
            ]; 

            $validator = Validator::make(Input::all(), $rules, $messages);

            if ($validator->fails()) {  
                return redirect(route('admin_change_password')) ->withErrors($validator)->withInput(); 
            } else {  
                UserModel::updateUserPasswordData($request);
                return redirect(route('admin_change_password'));
           }              
        }catch(\Exception $e){
            Log::error('UserController->storeChangePassword' . $e->getCode());
        }
   
    }
    
    /* For Get Users Data */
    public function getUsers(){
        $response = new ServiceResponse();
        $model = new stdClass();

        $searchModel = new stdClass();
        $searchModel->search = "";

        $model->frontSearchModel = $searchModel;
        $model->backSearchModel = $searchModel;
        $response = $model;

        return view('admin.user.index')->with('ListModel',json_encode($response));
    }

    public function postUser(Request $request){
        
        $response = new ServiceResponse();
        $request = Input::all();
        if ($request) {
            $data = $request['Data'];
            $results = UserModel::getUsersList($data);
        }

        $response->IsSuccess = true;
        $response->Data = $results;
        return response()->json($response);
    }

    /* For Get Edit user Data */
    public function edit($encryptedID) {
        try {
            
            $decryptedID = Common::getDecryptedValue($encryptedID);
            $id = Common::getParamValue($decryptedID, Constants::$QueryStringUserID);
            
            $user = UserModel::find($id);
            $country = UserModel::getCountryData();
            $state = UserModel::getStateData($user->lu_country_id);
            $user->encryptedID = $encryptedID;
            
            return view('admin.user.edit',array('user'=>$user,'country'=>$country,'state'=>$state));
        } catch (\Exception $e) {
            Log::error('UserController->edit' . $e->getCode());
        }
    }
    
    /* Update User Data */
    public function update(Request $request, $encryptedID) {

        try{

            $rules = [
                'name' => 'required',
                'email'     => 'required',
                'mobile_no'    => 'required|min:10',
                'lu_country_id'  => 'required',
                'lu_state_id'  => 'required',
                'city'  => 'required',
                'zipcode'  => 'required',
            ];
            $messages = [
                'name.required' => 'Name is required',
                'email.required'  => 'Email is required',
               // 'email.unique'       => 'Email already exists',
                'mobile_no.required'      => 'Mobile Number required',
                'lu_country_id.required' => 'Country is required',
                'lu_state_id.required' => 'State is required',
                'city.required' => 'City is required',
                'zipcode.required' => 'Zipcode is required',
            ];
            $validator = Validator::make(Input::all(), $rules, $messages);
            
            if ($validator->fails()) {
                
                return redirect('admin/user/edit/'.$encryptedID)->withErrors($validator)->withInput();
            } else {
                $decryptedID = Common::getDecryptedValue($encryptedID);
                $id = Common::getParamValue($decryptedID, Constants::$QueryStringUserID);
                
                UserModel::update_user($request,$id);
                Session::flash('success',trans('messages.updateSuccessMessage'));
                return redirect()->route('admin_user_list');
            }
        }catch(\Exception $e){
            Log::error('UserController->update'.$encryptedID . $e->getCode());
        }
    }
    
    /* Delete User Data */
    public function destroy(){
        try {
            $response = new ServiceResponse();
            $request = Input::all();
           
            if ($request) {
                $decryptedUserID = Common::getDecryptedValue($request['id']);
                $id = Common::getParamValue($decryptedUserID, Constants::$QueryStringUserID);
                Common::DeleteRecord(Constants::$tableNameUser, $id, Constants::$defaultKey);
                $response->IsSuccess = true;
            } else {
                $response->IsSuccess = false;
            }
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('UserController->destroy' . $e->getCode());
        }
    }
    
    /* Add User Data */
    public function add() {
        try {
            $country = DB::table('lu_country')->where('status', Constants::$Status_Active)->get();
            return view('admin.user.create',array('country'=>$country));
        } catch (\Exception $e) {
            Log::error('UserController->add' . $e->getCode());
        }
    }
    
    /* Store User Data */
    public function Store(Request $request){
        try{

            $rules = [
                'name' => 'required',
                'email'     => 'required|unique:user,email',
                'mobile_no'    => 'required|min:10',
                'lu_country_id'  => 'required',
                'lu_state_id'  => 'required',
                'city'  => 'required',
                'zipcode'  => 'required',
                'password'     => 'required',
            ];
            $messages = [
                'name.required' => 'Name is required',
                'email.required'  => 'Email is required',
                'email.unique'       => 'Email already exists',
                'mobile_no.required'      => 'Mobile Number required',
                'lu_country_id.required' => 'Country is required',
                'lu_state_id.required' => 'State is required',
                'city.required' => 'City is required',
                'zipcode.required' => 'Zipcode is required',
                'password.required' => 'Password is required',
            ];
            $validator = Validator::make(Input::all(), $rules, $messages);
            
            if ($validator->fails()) {
                return redirect(route('admin_user_add'))->withErrors($validator)->withInput();
            } else {
                UserModel::SaveUser($request);
                Session::flash('success',trans('messages.updateSuccessMessage'));
                return redirect()->route('admin_user_list');
            }
        }catch(\Exception $e){
            Log::error('UserController->userStore'. $e->getCode());
        }
    }
    
    /* For Get State Data */
    public function getState(){
        $lu_country_id = Input::get('lu_country_id');
        return DB::table('lu_state')->where('lu_country_id',$lu_country_id)->get();
    }
}
