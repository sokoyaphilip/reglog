<?php
include_once 'core/init.php';
$user = new User();
if($user->isLoggedIn()){
    Redirect::to('dashboard.php');
}

if(isset($_POST['login_form'])){
    $validate = new Validate();
    $validation = $validate->check( $_POST, array(
        'email' => array('required' => true),
        'password' => array('required' => true)
    ));    
    if($validation->passed()) {
        //log in        
        $remember = (Input::get('remember') === 'on') ? true : false;
        $login = $user->login(Input::get('email'), Input::get('password'), $remember);
        if($login) {
            Session::flash('home', 'You have successfully logged in');
            Redirect::to('dashboard.php');
        }else {
            Session::flash('error', 'Incorrect login details.');
            Redirect::to('index.php');
        }
    }else {
        $error_holder = '';
        foreach($validation->errors() as $error){
            $error_holder .= $error . ' <br/>';
        }
        Session::flash('error', $error_holder);
        Redirect::to('index.php');
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
   <meta name="autor" content="SokoyaPhilip">
   <title>Login - Reglog</title>
   <!-- Welcome  -->
   <!-- =============== v STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
   <!-- SIMPLE LINE ICONS-->
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
               <p class="text-center pv">SIGN IN TO CONTINUE.</p>
               <?php include_once 'msg_view.php';?>
               <form method="POST" action="" class="mb-lg" role="form" data-parsley-validate="" novalidate="">
                  <div class="form-group has-feedback">
                     <input class="form-control" id="email" type="email" name="email" placeholder="Enter email" autocomplete="off" required>
                     <span class="fa fa-envelope form-control-feedback text-muted"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <input class="form-control" id="exampleInputPassword1" name="password" type="password" placeholder="Password" required>
                     <span class="fa fa-lock form-control-feedback text-muted"></span>
                  </div>
                  <div class="clearfix">
                     <div class="checkbox c-checkbox pull-left mt0">
                        <label>
                           <input type="checkbox" value="" name="remember">
                           <span class="fa fa-check"></span>Remember Me</label>
                     </div>
                     <div class="pull-right"><a class="text-muted" href="changepassword.php">Change your password?</a>
                     </div>
                  </div>
                  <input type="hidden" name="login_form" value="">
                  <button class="btn btn-block btn-primary mt-lg" type="submit">Login</button>
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
   <!-- <script src="assets/js/app.js"></script> -->
</body>
</html>