<?php

namespace App\Infrastructure;
use Illuminate\Support\Facades\DB;

class Common{
    
		public static function ipaddress(){
			return '192.168.10.10';
		}
        
        public static  function filesize_formatted($size){
            $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $power = $size > 0 ? floor(log($size, 1024)) : 0;
            return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
        }
        
        public static function GetCsvFromArray($array){
            $csv = "";
            for ($i = 0; $i < count($array); $i++) {
                $csv .= str_replace('"', '""', $array[$i]->id);
                if ($i < count($array) - 1) $csv .= ",";
            }
            return $csv;
        }
        
        
        public static function getEncryptedValue($propertyName) {
         return urlencode(Common::encryptor(Constants::$encrypt, $propertyName));
        }   

        public static function getDecryptedValue($propertyName) {
            return urldecode(Common::encryptor(Constants::$decrypt, $propertyName));
        }
        
        public static function getParamValue($multiQueryString,$queryStringKey){
            if(str_contains($multiQueryString,'&'.$queryStringKey.'=') < 0){
                $first = explode('=',$multiQueryString);
                return $first[1];
            }

            if( starts_with($multiQueryString,$queryStringKey.'=') == 1 || str_contains($multiQueryString,'&'.$queryStringKey.'=') > 0) {
                $MultiQueryStringArray = explode('&', $multiQueryString);
                $first = current(array_filter($MultiQueryStringArray, function ($keyValue) use ($multiQueryString, $queryStringKey) {
                    return starts_with($keyValue, $queryStringKey . '=')== 1 ;
                }));
                if(!empty($first))
                    return explode('=',$first)[1];
            }
            return '0';
        }
        
        
         public static function encryptor($action, $string) {
            $output = false;

            $encrypt_method = "AES-256-CBC";
            
            //pls set your unique hashing key
            $secret_key = 'test';
            $secret_iv = 'test123';

            // hash
            $key = hash('sha256', $secret_key);

            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hash('sha256', $secret_iv), 0, 16);

            //do the encyption given text/string/number
            if( $action == 'encrypt' ) {
                $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
                $output = base64_encode($output);
            }
            else if( $action == 'decrypt' ){
                //decrypt the given text/string/number
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
            }

            return $output;
        }
        
        /* For Unique Record */
        public static function getUniqueRecord($tableName,$name,$field_name,$id=''){
         $query = DB::table($tableName)->where($field_name, $name)->where('status','!=',Constants::$Status_Delete);
          if($id){
              $query->where('id','!=',$id);
          }    
          return $query->count();
        }
        
        /* For Delete Record */
        public static function DeleteRecord($tableName,$id,$key=''){
            if($key =='')
                $key = 'id';
            
            DB::table($tableName)->where($key, $id)->update(['status' => Constants::$Status_Delete]);
        } 
        
        /* Get Active Record Count */
        public static function getActiveCount($table_name){
            return DB::table($table_name)->where('status','=', Constants::$Status_Active)->count(); 
        }
        /* Get In Active Record Count */
        public static function getInActiveCount($table_name){
            return DB::table($table_name)->where('status','=', Constants::$Status_InActive)->count(); 
        }

        public static function displayCommonData($filedName){
            $data =  DB::table('setting')->select('value')->where('field', $filedName)->first();
            if($data){
                return $data->value;
            }
        }
        
        public static function GetCsvFromArrayProperty($array,$propertyName) {
        
        $csv = "";
        for( $i = 0; $i < count($array); $i++ ) {
            
            $csv .= str_replace('"', '""', $array[$i]->$propertyName);
            if( $i < count($array) - 1 ) $csv .= ",";
        }
        return $csv;
    }
}
