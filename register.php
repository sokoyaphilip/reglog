<?php
include_once 'core/init.php';
$user = new User();
if($user->isLoggedIn()){
    Redirect::to('dashboard.php');
}

// check which form
if( isset($_POST['reg_form']) ){
    $user = new User();
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'name' => array(
            'name' =>'Fullname',            
            'required' => true,
            'min'   => 5,
            'max'   => 50
        ),
        'email' => array(
            'name' =>'Email',            
            'required' => true,
            'min'   => 2,
            'unique'    => 'users'
        ),
        'password' => array(    
            'name' =>'Password',        
            'required' => true,
            'min'   => 2,
            'max'   => 20
        ),
        'confirm_password' => array(
            'name' =>'Confirm Password',         
            'required' => true,
            'matches' => 'password',
            'min'   => 2,
            'max'   => 20
        )
    ));
    if( $validation->passed() ){        
        $salt = Hash::salt(32);
        try {
            $user->create('users', array(
                'email' => Input::get('email'),
                'password' => Hash::make(Input::get('password'), $salt),
                'salt' => $salt,
                'name' => Input::get('name'),
                'joined' => date('Y-m-d H:i:s')
            ));
        Session::flash('success','Registration successfuly, please login to access your dashboard.' );
        Redirect::to('index.php');

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }else{
        $error_holder = '';
        foreach($validation->errors() as $error){
            $error_holder .= $error . ' <br/>';
        }
        Session::flash('error', $error_holder);
        Redirect::to('register.php');
    } 
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="A simple reistration login system and to upload files to Google cloud bucket as well as retrieve files">
   <meta name="keywords" content="login system, php login system, bootstrap registration and login system, registration system, google cloud, how to store files on google cloud">
   <meta name="autor" content="SokoyaPhilip">
   <!-- =============== v STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
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
               <p class="text-center pv">SIGNUP TO GET INSTANT ACCESS.</p>
               <?php include_once('msg_view.php'); ?>
               <form method="POST" class="mb-lg" role="form" data-parsley-validate="" novalidate="">
                  <div class="form-group has-feedback">
                     <label class="text-muted" for="name">Full name</label>
                     <input class="form-control" id="name" type="text" name="name" placeholder="Enter fullname" autocomplete="off" required>
                     <span class="fa fa-envelope form-control-feedback text-muted"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label class="text-muted" for="email">Email address</label>
                     <input class="form-control" id="email" type="email" name="email" placeholder="Enter email" autocomplete="off" required>
                     <span class="fa fa-envelope form-control-feedback text-muted"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label class="text-muted" for="password">Password</label>
                     <input class="form-control" id="password" type="password" name="password" placeholder="Password" autocomplete="off" required>
                     <span class="fa fa-lock form-control-feedback text-muted"></span>
                  </div>
                  <div class="form-group has-feedback">
                     <label class="text-muted" for="confirm_password">Confirm Password</label>
                     <input class="form-control" id="confirm_password" name="confirm_password" type="password" placeholder="Confirm Password" autocomplete="off" required data-parsley-equalto="#password">
                     <span class="fa fa-lock form-control-feedback text-muted"></span>
                  </div>
                  <div class="clearfix">
                     <div class="checkbox c-checkbox pull-left mt0">
                        <label>
                           <input type="checkbox" value="" required name="agreed">
                           <span class="fa fa-check"></span>I agree with the <a href="#">terms</a>
                        </label>
                     </div>
                  </div>
                  <input type="hidden" name="reg_form" value="">
                  <button class="btn btn-block btn-primary mt-lg" type="submit">Create account</button>
               </form>
               <p class="pt-lg text-center">Have an account?</p><a class="btn btn-block btn-default" href="index.php">Login</a>
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
   <!-- JQUERY-->
   <script src="v/scripts/jquery.js"></script>
   <!-- MODERNIZR-->
   <script src="v/scripts/modernizr.custom.js"></script>
   <!-- BOOTSTRAP-->
   <script src="v/scripts/bootstrap.js"></script>
   <!-- STORAGE API-->
   <script src="v/scripts/jquery.storageapi.js"></script>
   <!-- PARSLEY-->
   <script src="v/scripts/parsley.min.js"></script>
   <!-- =============== APP SCRIPTS ===============-->
   <script src="assets/js/app.js"></script>
</body>
</html>