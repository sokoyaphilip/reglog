<?php
require_once 'core/init.php';
$user = new User();
$action = new Actions();
if(!$user->isLoggedIn())
   Redirect::to('index.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <title>Dashboard - reglog</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="A simple reistration login system and to upload files to Google cloud bucket as well as retrieve files">
   <meta name="keywords" content="login system, php login system, registration system, google cloud, how to store files on google cloud">
   <meta name="autor" content="SokoyaPhilip">
   <!-- =============== v STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
   
   <!-- ANIMATE.CSS-->
   <link rel="stylesheet" href="assets/css/animate.min.css">
   <!-- WHIRL (spinners)-->
   <link rel="stylesheet" href="v/whirl/dist/whirl.css">
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="assets/css/bootstrap.css" id="bscss">
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="assets/css/app.css" id="maincss">

</head>

<body>
   <div class="wrapper">
      <!-- top navbar-->
      <header class="topnavbar-wrapper">
         <!-- START Top Navbar-->
         <nav class="navbar topnavbar" role="navigation">
            <!-- START navbar header-->
            <div class="navbar-header">
               <a class="navbar-brand" href="#/">
                  <div class="brand-logo">
                     <!-- <img class="img-responsive" src="assets/img/logo.png" alt="App Logo"> -->
                  </div>
                  <div class="brand-logo-collapsed">
                     <!-- <img class="img-responsive" src="assets/img/logo-single.png" alt="App Logo"> -->
                  </div>
               </a>
            </div>
            <!-- END navbar header-->
            <!-- START Nav wrapper-->
            <div class="nav-wrapper">
               <!-- START Left navbar-->
               <ul class="nav navbar-nav">
                  <li>
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a class="hidden-xs" href="#" data-trigger-resize="" data-toggle-state="aside-collapsed">
                        <em class="fa fa-navicon"></em>
                     </a>
                     <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                     <a class="visible-xs sidebar-toggle" href="#" data-toggle-state="aside-toggled" data-no-persist="true">
                        <em class="fa fa-navicon"></em>
                     </a>
                  </li>
                  <!-- START User avatar toggle-->
                  <li>
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a id="user-block-toggle" href="#user-block" data-toggle="collapse">
                        <em class="icon-user"></em>
                     </a>
                  </li>
                  <!-- END User avatar toggle-->
               </ul>
               <!-- END Left navbar-->
               <!-- START Right Navbar-->
               <ul class="nav navbar-nav navbar-right">
                  <!-- START Offsidebar button-->
                  <li>
                     <a href="logout.php" data-toggle-state="offsidebar-open" data-no-persist="true">
                        <em class="fas fa-sign-out-alt"></em> Logout
                     </a>
                  </li>
                  <!-- END Offsidebar menu-->
               </ul>
               <!-- END Right Navbar-->
            </div>
            <!-- END Nav wrapper-->
         </nav>
         <!-- END Top Navbar-->
      </header>
      <!-- sidebar-->
      <aside class="aside">
         <!-- START Sidebar (left)-->
         <div class="aside-inner">
            <nav class="sidebar" data-sidebar-anyclick-close="">
               <!-- START sidebar nav-->
               <ul class="nav">
                  <!-- START user info-->
                  <li class="has-user-block">
                     <div class="collapse" id="user-block">
                        <div class="item user-block">
                           <!-- User picture-->
                           <div class="user-block-picture">
                              <div class="user-block-status">
                                 <img class="img-thumbnail img-circle" src="assets/img/user/02.jpg" alt="Avatar" width="60" height="60">
                                 <div class="circle circle-success circle-lg"></div>
                              </div>
                           </div>
                           <!-- Name and Job-->
                           <div class="user-block-info">
                              <span class="user-block-name">Hello, <?= $user->data()->username ?></span>
                              <span class="user-block-role">Member</span>
                           </div>
                        </div>
                     </div>
                  </li>
                  <!-- END user info-->
                  <!-- Iterates over all sidebar items-->
                  <li class="nav-heading ">
                     <span data-localize="sidebar.heading.HEADER">Main Navigation</span>
                  </li>
                  <li class=" ">
                     <a href="dashboard.php" class="active" title="Dashboard">
                        <em class="fas fa-tachometer-alt"></em>
                        <span>Dashboard</span>
                     </a>
                  </li>
                  <li class=" ">
                     <a href="thrash.php" title="Thrash">
                        <em class="fas fa-trash-alt"></em>
                        <span>Thrash</span>
                     </a>
                  </li>
               </ul>
               <!-- END sidebar nav-->
            </nav>
         </div>
         <!-- END Sidebar (left)-->
      </aside>
      <!-- offsidebar-->
      
      <!-- Main section-->
      <section>
         <!-- Page content-->
         <div class="content-wrapper">
            <div class="pull-right">
               <div class="dropdown">
                  <a href="#" data-toggle="dropdown">
                     <img class="thumb32 img-circle" src="assets/img/user/02.jpg" alt="user">
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right animated fadeInUp" role="menu">
                     <li>
                        <a href="#">
                           <span>Settings</span>
                        </a>
                     </li>
                     <li>
                        <a href="#">
                           <span>Get more Storage</span>
                        </a>
                     </li>
                     <li>
                        <a href="#">
                           <span>Manage permissions</span>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
            <h3>File Manager</h3>
            <div class="row">
               <div class="col-md-3">
                  <div class="status"></div>
                  <div class="mb-lg clearfix">
                     <form id="media_upload" role="form" enctype="multipart/form-data">
                        <input class="form-control filestyle" type="file" name="file" data-input="true" required="" data-buttonname="btn btn-info" data-buttontext="UPLOAD" data-iconname="fa fa-upload mr" accept="audio/*,video/*,image/*"><br />
                        <div class="form-group">
                           <button type="submit" class="btn btn-success btn-md col-md-12" id="media_upload_btn">Submit</button>
                        </div>
                     </form>
                  </div>
                  <div class="panel b">
                     <div class="panel-body">
                        <strong class="text-muted">FOLDERS</strong>
                     </div>
                     <div class="list-group">
                        <a class="active list-group-item" href="#">
                           <span class="badge">49</span>
                           <span class="circle bg-white mr"></span>
                           <span>All</span>
                        </a>
                        <a class="list-group-item" href="#">
                           <span class="badge">9</span>
                           <span class="circle circle-success mr"></span>
                           <span>Video</span>
                        </a>
                        <a class="list-group-item" href="#">
                           <span class="badge">30</span>
                           <span class="circle circle-warning mr"></span>
                           <span>Audio</span>
                        </a>
                        <a class="list-group-item" href="#">
                           <span class="badge">10</span>
                           <span class="circle circle-warning mr"></span>
                           <span>Images</span>
                        </a>
                        <!-- left panel -->
                     </div>
                  </div>
                  
               </div>
               <div class="col-md-9">
                  <div class="delete_status"></div>
                  <div class="row">
                     <div class="content_wrapper">
                        <?php 
                           $authheaders = array(
                              "Authorization: Bearer AUTH_TOKEN_HERE"
                           ); //The access-token has to be generate everytime after one-hour.                           
                           $curl = curl_init();
                           $url = "https://www.googleapis.com/storage/v1/b/{BUCKET_NAME}/o";
                           curl_setopt($curl, CURLOPT_URL,$url);
                           curl_setopt($curl, CURLOPT_HTTPHEADER, $authheaders);
                           curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                           curl_setopt($curl, CURLOPT_TIMEOUT, 300);
                           curl_setopt($curl, CURLOPT_HTTPGET, 1);    
                           curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                           $results = curl_exec($curl);
                           curl_close($curl);

                           $items = json_decode( $results, true);
                           if( isset($items['items']) ) {
                              foreach( $items['items'] as $item  ) {
                                 ( $action->find('files', 'media_name', $item['name']) == true ) ? $status = $action->data()->status : next($items);
                                 
                                 
                                 $list = explode('_', $item['name']);
                                 if( ($user->data()->id == $list[0]) && ($status == 'active') ){ ?>
                                    <div class="col-md-4 col-sm-6">
                                       <?php $media = explode('/', $item['contentType']); ?>
                                       <div class="panel discoverer" data-filter-group="<?= $media[0]; ?>">
                                          <div class="panel-body text-center">
                                             <div class="clearfix discover">
                                                <div class="pull-right">
                                                   <a class="text-muted mr-sm delete_media" data-id="<?= $item['name']; ?>" href="javascript:void" title="Delete">
                                                      <em class="far fa-trash-alt"></em>
                                                   </a>
                                                </div>
                                             </div>
                                             <a class="file-icon ph-lg" href="https://storage.googleapis.com/{BUCKET_NAME}/<?= $item['name'];?>" target="_blank">
                                                <?php 
                                                   switch ($media['0']) {
                                                      case 'audio':
                                                         echo '<em class="fas fa-headphones fa-5x text-primary"></em>';
                                                         break;
                                                      case 'video':
                                                         echo '<em class="fas fa-video fa-5x text-danger"></em>';
                                                         break;                                                      
                                                      default:
                                                         echo '<em class="fas fa-image fa-5x text-success"></em>';
                                                         break;
                                                   }
                                                ?>
                                             </a>
                                             <p>
                                                <small class="text-dark"><?= $list[2]; ?></small>
                                             </p>
                                             <div class="clearfix m0 text-muted">
                                                <!-- <small class="pull-right"><?= filesize('https://storage.googleapis.com/reglog/' .$item['name']) . ' bytes'; ?></small> -->
                                                <small class="pull-left"><?= date('h:ia - l', strtotime($item['timeCreated'])); ?></small>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                        <?php
                                 }
                              }                              
                           }
                        ?>
                     </div> <!-- wrapper -->                    
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Page footer-->
      <footer>
         <span>&copy; <?= date('Y'); ?> - Reglog</span>
      </footer>
   </div>
   <!-- =============== v SCRIPTS ===============-->
   <!-- MODERNIZR-->
   <script src="v/scripts/modernizr.custom.js"></script>
   <!-- MATCHMEDIA POLYFILL-->
   <script src="v/scripts/matchMedia.js"></script>
   <!-- JQUERY-->
   <script src="v/scripts/jquery.js"></script>
   <!-- BOOTSTRAP-->
   <script src="v/scripts/bootstrap.js"></script>
   <!-- STORAGE API-->
   <script src="v/scripts/jquery.storageapi.js"></script>
   <!-- JQUERY EASING-->
   <script src="v/scripts/jquery.easing.js"></script>
   <!-- ANIMO-->
   <script src="v/scripts/animo.js"></script>
   <!-- SLIMSCROLL-->
   <script src="v/scripts/jquery.slimscroll.min.js"></script>
   <!-- SCREENFULL-->
   <script src="v/scripts/screenfull.js"></script>
   <!-- LOCALIZE-->
   <script src="v/scripts/jquery.localize.js"></script>
   <!-- RTL demo-->
   <script src="assets/js/demo/demo-rtl.js"></script>
   <!-- =============== PAGE v SCRIPTS ===============-->
   <!-- FILESTYLE-->
   <script src="v/scripts/bootstrap-filestyle.js"></script>
   <!-- =============== APP SCRIPTS ===============-->
   <script src="assets/js/app.js"></script>
   <script>

      $("#media_upload").submit(function(e){
        e.preventDefault();
        $('#media_upload_btn').attr("disabled", "disabled");
        $('#media_upload_btn').attr("value", "Please wait...");
         var formdata = new FormData(this);

         $.ajax({
            url: "process.php",
            type: "POST",
            data: formdata,
            mimeTypes:"multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(returnedData){
               if( returnedData.status == "success" ){
                  $('#media_upload_btn').removeAttr("disabled");
                     alert = "<p class='alert alert-success'>Media has been uploaded successfully.</p>";
                     $(".status").html(alert).slideDown().delay(4000).slideUp();
                     var data = returnedData.message.split("|");
                     var currentHTML = $('.content_wrapper').html();
                     var container = '<div class="col-md-4 col-sm-6"><div class="panel discoverer" data-filter-group="'+data[1]+'"><div class="panel-body text-center"><div class="clearfix discover"><div class="pull-right"><a class="text-muted mr-sm delete_media" data-id="'+data[0]+'" href="javascript:void" title="Delete"><i class="far fa-trash-alt"></i></a></div></div><a class="file-icon ph-lg" href="https://storage.googleapis.com/reglog/'+data[0]+'" target="_blank"><em class="fas fa-headphones fa-5x text-primary"></em></a><p><small class="text-dark">'+data[3]+'</small</p><div class="clearfix m0 text-muted"><small class="pull-right">'+data[2]+'</small><small class="pull-left">Just now</small></div></div></div></div>';
                     $('.content_wrapper').html(container).append(currentHTML);
               }else{
                  alert(returnedData);
               }
            },error: function(error){
               console.log(error);
            }
         });
      });

      $('.delete_media').on('click', function(){
         var id = $(this).attr('data-id');
         var $button = $(this);
         $.ajax({
            url: "process.php",
            type: "POST",
            data: { 'action': 'delete', 'id' : id},
            dataType: 'json',
            success: function(returnedData){
               if( returnedData.status == "success" ){
                  $button.parent().parent().parent().parent().parent().fadeOut('slow', function(){
                     alert = "<p class='alert alert-success'>"+returnedData.message+"</p>";
                     $('.delete_status').html(alert).slideDown().delay(3000).slideUp();
                  });
               }else{
                  alert = "<p class='alert alert-error'>"+returnedData.message+"</p>";
                  $('.delete_status').html(alert).slideDown().delay(5000).slideUp();
               }
            },error: function(error){
               //
            }
         });         
      })
   </script>
</body>
</html>