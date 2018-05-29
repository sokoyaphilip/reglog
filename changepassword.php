<?php
include_once 'core/init.php';

$user = new User();

// if(!$user->isLoggedIn()){
// 	Redirect::to('index.php');
// }
if(Input::exists()){
	if(Token::check(Input::get('token'))){

		//validate
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'password_current' => array(
				'required' => true
			),
			'password_new' => array(
				'required' => true
			),
			'password_new_again' => array(
				'required' => true,
				'matches'	=> 'password_new'
			)
		));

		if($validation->passed()){
			
			//check if password matches the one i n db
			/*echo $user->data()->password; 
			echo '<br />';
			echo Hash::make(Input::get('password_new'), $user->data()->salt);
			Stupid error here
			*/
			//do the changing and update



		}else{
			foreach( $validation->errors() as $error){
				echo $error, '<br />';
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="A simple reistration login system and to upload files to Google cloud bucket as well as retrieve files">
   <meta name="keywords" content="login system, php login system, registration system, google cloud, how to store files on google cloud">
   <meta name="author" content="sokoyaphilip">
   <title>Change Password - Reglog</title>
   <!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="v/fontawesome/css/font-awesome.min.css">
   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="v/simple-line-icons/css/simple-line-icons.css">
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="assets/css/bootstrap.css" id="bscss">
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="assets/css/app.css" id="maincss">
</head>
<body>
   <div class="wrapper">
      <div class="block-center mt-xl wd-xl">
         <!-- START panel-->
         <div class="panel panel-dark panel-flat">
            <div class="panel-heading text-center">
               <a href="#">
                  <!-- <img class="block-center img-rounded" src="assets/img/logo.png" alt="Image"> -->
               </a>
            </div>
            <div class="panel-body">
               <p class="text-center pv">PASSWORD RESET</p>
               <form role="form" method="POST">
                  <p class="text-center">Fill with your mail to receive instructions on how to reset your password.</p>
                  <div class="form-group has-feedback">
                     <label class="text-muted" for="email">Email address</label>
                     <input class="form-control" id="email" type="email" required placeholder="Enter email" autocomplete="off">
                     <span class="fa fa-envelope form-control-feedback text-muted"></span>
                  </div>
                  <button class="btn btn-danger btn-block" type="submit" disabled>Reset</button>
               </form>
               <p class="pt-lg text-center">Need to Signup?</p><a class="btn btn-block btn-default" href="register.php">Register Now</a>
            </div>
         </div>
         <!-- END panel-->
         <div class="p-lg text-center">
            <span>&copy;</span>
            <span><?= date('Y');?></span>
            <span>-</span>
            <span>Reglog</span>
         </div>
      </div>
   </div>
   <!-- =============== v SCRIPTS ===============-->
   <!-- MODERNIZR-->
   <script src="v/scripts/modernizr.custom.js"></script>
   <!-- JQUERY-->
   <script src="v/scripts/jquery.js"></script>
   <!-- BOOTSTRAP-->
   <script src="v/scripts/js/bootstrap.js"></script>
   <!-- STORAGE API-->
   <script src="v/scripts/jquery.storageapi.js"></script>
   <!-- PARSLEY-->
   <script src="v/scripts/parsley.min.js"></script>
   <!-- =============== APP SCRIPTS ===============-->
   <script src="assets/js/app.js"></script>
</body>
</html>