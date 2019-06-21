<?php

namespace App\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Infrastructure\Constants;
use Illuminate\Support\Facades\Input;
use Session;
use App\Infrastructure\Common;
use stdClass;



class UserModel extends Model {

    protected $table = 'user';


    public static function saveData($request){
        /*$data = new ContactModel;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->mobile_no = $request->mobile_no;
        $data->website = isset($request->website)? $request->website : NULL;
        $data->message = isset($request->message)? $request->message : NULL;

        $data->save();*/

        DB::table('contactus')->insert(
            array('name' => $request->name)
        );
    }
    
   /* Get User Details */
    public static function getUserData($request) {
        return DB::table('user')->where('password', '=', md5(Input::get('password')))->where('user_name', '=', Input::get('user_name'))->first();
 
        }
    
    /* Get Role Wise User Data */
    public static function getRoleForUser($userID){
        return DB::table('user_role')->where('user_id', '=', $userID)->get();
    }
    
    /* update user profile */ 
    public static function updateUserProfile($request, $id) {
        $user = UserModel::find($id);
        $user->name = $request->name;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->mobile_no = $request->mobile_no;
        $user->status = Constants::$Status_Active;
        $user->updated_at = date(Constants::$DefaultDateTimeFormat);
        
        if ($request->profile_photo) {
                $filename = base_path() .'/'.Constants::$profile_photouploadpath.$user->profile_photo;

                if (file_exists($filename) && $user->profile_photo!='') {

                    unlink($filename); 
                }  
                $myfiles = $request->profile_photo;
                $time = time(). rand(11111, 99999);
                $imageFiles = $myfiles; 
                $fileName = 'user_'.$id.'.'.$imageFiles->getClientOriginalExtension();
                $fileExtensions = $imageFiles->getClientOriginalExtension();
                $fileSize = $imageFiles->getClientSize();
                $imageFiles->move(Constants::$profile_photouploadpath, $fileName);  
                $user->profile_photo = $fileName;  
                
                Session()->put('ProfilePhoto', $fileName);
            }
        
        $user->save();
        
    }
    
    /* Update User Password */
     public static function updateUserPasswordData($request) {
        $user_id = Session::get('UserID');
        $currentPassword = md5(Input::get('currentpassword'));
        $newpassword = $request->newpassword;
        $checkPassword = DB::table('user')->where('id', '=', $user_id)->select('password')->first();
        if ($currentPassword == $checkPassword->password) {
            $user = UserModel::find($user_id);
            $user->original_password = $newpassword;
            $user->password = md5(Input::get('newpassword'));
            $user->updated_by = $user_id;
            $user->updated_at = date(Constants::$DefaultDateTimeFormat);
            $user->save();
            Session::flash('success', trans('messages.successPassword'));
            return redirect(route('admin_change_password'));
        } else {
            Session::flash('error', trans('Wrong Current password'));
            return redirect(route('admin_change_password'));
        }
    }
    
    /* For Update User Data */
    public static function update_user($request,$id){
        $user['name'] = Input::get('name');
        $user['user_name'] = Input::get('user_name');
        $user['email']     = Input::get('email');
        $user['mobile_no']    = Input::get('mobile_no');
        $user['gender']    = Input::get('gender');
        $user['lu_country_id'] = Input::get('lu_country_id');
        $user['lu_state_id']  = Input::get('lu_state_id');
        $user['city']      = Input::get('city');
        $user['zipcode']   = Input::get('zipcode');
        $user['is_email_verified']   = 'Y';
        $user['status']    = Input::get('status');
        $user['updated_at'] = date(Constants::$DefaultDateTimeFormat);


        if (Input::hasFile('profile_photo')) {
            $userImage = UserModel::find($id);
            if($userImage->profile_photo){
                $oldImage = Constants::$profile_photouploadpath.$userImage->profile_photo;
                if(file_exists($oldImage)){
                    unlink($oldImage);
                }
            }
            $file = $request->file('profile_photo');
            $image_name = 'user_'.$id.'.'.$file->getClientOriginalExtension();
            $request->file('profile_photo')->move(Constants::$profile_photouploadpath, $image_name);
            $user['profile_photo'] = $image_name;
        }

        DB::table('user')->where('id',$id)->update($user);
        return true;

    }

    /* For Save User Data */
    public static function SaveUser($request){
        $user = new UserModel();
        $user->name = Input::get('name');
        $user->user_name = Input::get('user_name');
        $user->email     = Input::get('email');
        $user->password     = md5(Input::get('password'));
        $user->original_password     = Input::get('password');
        $user->mobile_no    = Input::get('mobile_no');
        $user->gender    = Input::get('gender');
        $user->lu_country_id = Input::get('lu_country_id');
        $user->lu_state_id   = Input::get('lu_state_id');
        $user->city      = Input::get('city');
        $user->zipcode   = Input::get('zipcode');
        $user->status    = Input::get('status') != '' ? Input::get('status') : Constants::$Status_Active;
        $user->is_email_verified    = 'Y';
        $user->created_at = date(Constants::$DefaultDateTimeFormat);
        $user->updated_at = date(Constants::$DefaultDateTimeFormat);
        $user->save();


        /* Upload Profile */
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $image_name = 'user_'.$user->id.'.'.$file->getClientOriginalExtension();
            $request->file('profile_photo')->move(Constants::$profile_photouploadpath, $image_name);
            $UpdateImageName = UserModel::find($user->id);
            $UpdateImageName->profile_photo = $image_name;
            $UpdateImageName->save();
        }

        return true;
    }
    
     /* For Users List */
    public static function getUsersList($data){
       
          if(empty($data['SortIndex'])){
                $data->SortIndex = Constants::$SortIndex;
            }
            if(empty($data['SortDirection'])){
                $data->SortDirection = Constants::$SortIndexDESC;
            }

            $sortIndex = $data['SortIndex'];
            $sortDirection = $data['SortDirection'];
            $pageIndex = $data['PageIndex'];
            $pageSizeCount = $data['PageSize'];

            $search = '';
            if(!empty($data['SearchParams']['search'])){
                $search = $data['SearchParams']['search'];
            }
           
            $limit = $pageSizeCount;
            $offset = $pageIndex ? ( ($pageIndex - Constants::$Value_True) * $pageSizeCount ):Constants::$Value_True;
             
            $query = DB::table('user')->Where(function ($query) use ($search) {
                  $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')         
                        ->orWhere('mobile_no', 'like', '%' . $search . '%');           
                  })
                  ->skip($offset)->take($limit)
                  ->where('status','!=',Constants::$Status_Delete)      
                  ->orderBy($sortIndex,$sortDirection);
                    
            $countQuery = DB::table('user')->Where(function ($countQuery) use ($search) {
               $countQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                       ->orWhere('mobile_no', 'like', '%' . $search . '%');
                })
               ->where('status','!=',Constants::$Status_Delete)
               ->orderBy($sortIndex,$sortDirection);
                   
            $projectData = $query->get();
            $totalRecordCount= $countQuery->count();
           
            if($projectData){
                foreach ($projectData as $projectData1){
                    $projectData1->created_at =  date(Constants::$displayDateFormatForAll, strtotime($projectData1->created_at));
                    $encryptedID = Constants::$QueryStringUserID.'='.$projectData1->id;
                    $projectData1->EncryptedUserID = Common::getEncryptedValue($encryptedID);
                }
            }
            
            $results = new stdClass();
            $results->CurrentPage = $pageIndex;
            $results->ItemsPerPage = $pageSizeCount;
            $results->Items = $projectData;
            $results->TotalItems = intval($totalRecordCount);	
            return $results;
    }
    
    /* For Country Data */
    public static function getCountryData(){
        return DB::table('lu_country')->where('status', Constants::$Status_Active)->get();
    }
    
    /* For Country Data */
    public static function getStateData($lu_country_id){
        return DB::table('lu_state')->where('status', Constants::$Status_Active)->where('lu_country_id', $lu_country_id)->get();
    }
}
