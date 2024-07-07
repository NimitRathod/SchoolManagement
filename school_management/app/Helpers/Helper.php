<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;

class Helper
{
    static function randomToken()
    {
        return sha1(md5(time()) . time() . rand());
    }
    /*
    static function encryptValue($value)
    {
        $inputKey = '12345678901234561234567890123456';
        
        $blockSize = 256;
        $aes = new \AES($value, $inputKey, $blockSize);
        $enc = $aes->encrypt();
        return base64_encode($enc);
    }
    
    static function decyptValue($value)
    {
        
        $inputKey = '12345678901234561234567890123456';
        $blockSize = 256;
        $aes = new \AES(base64_decode($value), $inputKey, $blockSize);
        $enc = $aes->decrypt();
        return ($enc);
    }
    */
    
    //For Validation Message
    static function validation_message($message, $keys = array())
    {
        return $message->all()[0];
    }
    
    static function make_slug(string $string)
    {
        return Str::slug(strtolower($string));
    }
    
    static function get_login_user_profile_img($id = null){
        $return_image = "";
        if($id == NULL){
            $id = Auth::user()->id;
        }
        
        // $user_image = ProjectImages::where('parent_title','user_image')->where('parent_id',$id)->orderBy('id','DESC')->first();
        $user_image = ProjectImages::where('parent_title','user_image')->where('parent_id',$id)->orderBy('id','DESC')->first();
        $return_image = asset('defaultuser.jpg');
        if(isset($user_image) && $user_image != ''){
            $return_image = $user_image->image;
            if(File::exists(env('DIR_PUBLIC_IMAGES').$return_image)){
                $return_image = env('APP_URL').$return_image;
            }
        }
        return $return_image;
    }
    
    static function convert_date($dateString = "",$current_format = 'd/m/Y',$new_format = 'd/m/Y'){
        if($dateString == ""){
            $dateString = \Carbon\Carbon::now();
            return $dateString->format($new_format);
        }
        /*if($current_format == 'Y-m-d H:i:s'){
            return \Carbon\Carbon::createFromFormat($current_format, $dateString)->format($new_format);
        }*/
        return \Carbon\Carbon::createFromFormat($current_format, $dateString)->format($new_format);
    }
    
    static function getAfterAuthRole(){
        $login_user_role = Auth::user()->getRoleNames()->first();
        $roles = new Role();
        if($login_user_role != "developer"){
            $roles = $roles->whereNotIn("name", ["developer"]);
        }
        return $roles = $roles->get();
    }
    
    static function getRoleName($id){
        if(!in_array($id,['-1','0'])){
            $findRole = Role::where('id',$id)->first();
            if($findRole && isset($findRole->name)){
                return $findRole->name;
            }
        }
        return "";
    }
    
    static function getLoginUserRole(){
        $login_user_role = Auth::user()->getRoleNames()->first();
        return $login_user_role;
    }
    
    
    /** Current Date */
    public function trait_current_date($format = 'Y-m-d H:i:s'){
        return Carbon::now()->format($format);
    }

    public function RandomString($length = 40) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    static function existingImageConverToWebp($extension, $root_path, $file_name, $upload_file_name, $quality = 100, $imagedestroy = false)
	{
		try {
			$file_path = $root_path . $file_name;
			if (file_exists($file_path)) {
                // dd("L-274", 'exist', $extension, $root_path, $file_name, $upload_file_name, $quality, $imagedestroy, $upload_file_name . '.webp', $root_path.$upload_file_name . '.webp');
				$image = null;
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$getFileMimeType = finfo_file($finfo, $file_path); // image/png | image/jpeg | image/jpg
				finfo_close($finfo);
				
				if (strtolower($getFileMimeType) == 'image/png') {
					$image = imagecreatefrompng($file_path);
					imagepalettetotruecolor($image);
				} else  if (strtolower($getFileMimeType) == "image/jpg" || strtolower($getFileMimeType) == "image/jpeg") {
					$image = imagecreatefromjpeg($file_path);
				} else  if (strtolower($getFileMimeType) == "image/webp") {
					$image = imagecreatefromwebp($file_path);
				} else {
					if (strtolower($extension) == 'png') {
						$image = imagecreatefrompng($file_path);
						imagepalettetotruecolor($image);
					} else  if (strtolower($extension) == "jpg" || strtolower($extension) == "jpeg") {
						$image = imagecreatefromjpeg($file_path);
					} else {
						return '';
					}
				}
				// return 
				$upload_file_name = self::make_slug($upload_file_name) . '.webp';
                // dd("L-288", 'exist', $extension, $root_path, $dir, $file_name, $upload_file_name, $quality, $imagedestroy, $getFileMimeType, $image, $upload_file_name);
				
				imagewebp($image, $root_path . $upload_file_name, $quality);
				
				// If file is not store in proper folder copy file
				// copy(public_path($upload_file_name), $dir.$upload_file_name);
				
                // dd("L-295", 'exist', $extension, $root_path, $dir, $file_name, $upload_file_name, $quality, $imagedestroy, $root_path.$upload_file_name . '.webp', $getFileMimeType, $image);
				//delete initial uploaded png image
				if ($imagedestroy) {
					unlink($file_path);
					// imagedestroy($file_path);
				}
				return $upload_file_name;
			}
			return null;
		} catch (\Exception $e) {
			dd("Helper existingImageConverToWebp NR-106",$e);
			return null;
			dump($e);
		}
		dd("L-320", 'not exist', $root_path, $file_name, $upload_file_name, $imagedestroy);
	}
}