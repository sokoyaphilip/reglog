<?php
require_once 'core/init.php';
if(isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"])){
   $folder = 'uploads/';
   $permitted = array( "jpg", "jpeg", "gif", "png", "mov", "mp4", "3gp", "ogg" );  
   //get file details we need
   $file_tmp_name   = $_FILES['file']['tmp_name'];
   $file_name       = $_FILES['file']['name'];
   $file_size       = $_FILES['file']['size'];
   $ext             = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
   $file_error      = $_FILES['file']['error'];

   if( in_array( $ext, $permitted ) || $file_size < (2048 * 1536)  ){
         if (!file_exists("$folder")) {
            mkdir("$folder/", 0755);
         }
         $user = new User();
         $new_name = time();
         $move = move_uploaded_file( $_FILES['file']['tmp_name'], $folder.$new_name );
         if( $move ){
            // upload to Gcloud bucket            
            if( $result = get_curl( $file_size, $user->data()->id.'_'.$new_name.'_'.$file_name, $folder.$new_name) ){
               // Store in Database
               $media_type = mime_content_type($folder.$new_name);
               // remove the file from the server, memory leaching
               $temp = explode('.', $file_name);
               @unlink($folder.$new_name);
               try {
                     $user->create('files', array(
                         'uid' => $user->data()->id,
                         'media_name' => $user->data()->id.'_'.$new_name.'_'.$temp[0],
                         'media_type' => $media_type,
                         'status' => 'active',
                         'postdate' => date('Y-m-d H:i:s')
                     ));
                  
                  $message = $user->data()->id.'_'.$new_name.'_'.$temp[0].'|'.$media_type.'|'.format_size($file_size).'|'.ucwords($file_name);
                  echo json_encode(array('status' => 'success', 'message' => $message ));
                  exit;
                 } catch (Exception $e) {
                     die($e->getMessage());
                 }
            }else{
               echo json_encode(array('status' => 'error', 'message' => 'There was an error when uploading'));
               exit;
            }
         }else{
            echo json_encode(array('status' => 'error', 'message' => 'File can not be moved'));
            exit;
         }      
   }else{
      echo json_encode(array('status'=>'error', 'message'=>'Please upload only image, audio and video'));
      exit;
   }
}
/***
Move media to trash
@param : delete
@param: media_id
***/
if( isset($_POST['action']) && ($_POST['action'] == 'delete')){
   // delete
   // Still gonna use User Class, and boject cos no time...
   $user = new User();
   // die( $_POST['id']);
   try {
      $user->update_media('files', array('status' => 'thrash'), $_POST['id']);
      echo json_encode(array('status'=>'success', 'message'=>'Media has been moved to thrash successfully.'));
      exit;
   } catch (Exception $e) {
      echo json_encode(array('status'=>'error', 'message'=> $e->getMessage()) );
      exit;
   }
}

/***
Move media to file manager
@param : activate
@param: media_id
***/

if( isset($_POST['action']) && ($_POST['action'] == 'activate')){
   // active
   // Still gonna use User Class, and boject cos no time...
   $user = new User();
   try {
      $user->update_media('files', array('status' => 'active'), $_POST['id']);
      echo json_encode(array('status'=>'success', 'message'=>'Media has been moved to file manager successfully.'));
      exit;
   } catch (Exception $e) {
      echo json_encode(array('status'=>'error', 'message'=> $e->getMessage()) );
      exit;
   }
}

function get_curl( $file_size, $file_name, $loc ){
   $authheaders = array(
      "Content-Type: ". mime_content_type($loc),
      "Content-Length:".$file_size,
      "Authorization: Bearer {AUTH_TOKEN_HERE}"
   ); //The access-token has to be generate everytime after one-hour.
   $uploadRequest = file_get_contents($loc);
   $file_name = explode('.', $file_name);
   // Execute remote upload
   $curl = curl_init();
   $url = "https://www.googleapis.com/upload/storage/v1/b/{BUCKET_NAME}/o?uploadType=media&name=".$file_name[0];
   curl_setopt($curl, CURLOPT_URL,$url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, $authheaders);
   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($curl, CURLOPT_TIMEOUT, 300);
   curl_setopt($curl, CURLOPT_POST, 1);    
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_POSTFIELDS, $uploadRequest);
   $response = curl_exec($curl);
   curl_close($curl);
   return $response;
}

function format_size($size) {
      $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
      if ($size == 0) { return('n/a'); } else {
      return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]); }
}