<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="utf-8" />
      <?php  $site = DB::table('site')->where('id', '1')->first(); ?>
      <title><?php echo $site->name?> - Error </title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
      <meta name="theme-color" content="#fdd306"/>
      <!-- Favicon -->
      <link rel="shortcut icon" type="image/x-icon" href="<?php echo url('/')?>/uploads/icons/favicon.png">
      <link rel="apple-touch-icon" href="<?php echo url('/')?>/uploads/icons/apple-touch-icon.png" />
      <!-- All css files are included here. -->
      <!--Fonts-->
      <?php echo Html::style('backend/css/font-awesome.css')?>
      <!--Alerts-->
      <?php echo Html::style('frontend/css/jquery.growl.css')?>
      <?php echo Html::style('frontend/css/sweetalert.css')?>
      <!-- Bootstrap fremwork main css -->
      <?php echo Html::style('frontend/css/bootstrap.css')?>
      <!-- Theme main style -->
      <?php echo Html::style('frontend/css/bastrap.css')?>
   </head>
   <body style="background-color: transparent!important;" >

      
      <!-- HEADER AREA END -->
      <!--  Content -->
      @yield('content')
      <!--end content -->
      <!-- Start footer area -->
      
      
   </body>
   <input type="hidden" name="url" id="url" value="<?php echo url('/')?>">
   <input type="hidden" name="csrf_token" value="<?php echo  csrf_token() ?>" id="token">
   <!--Jquery-->
   <?php echo Html::script('frontend/js/jquery.min.js')?>
   <!--Boostrap-->
   <?php echo Html::script('frontend/js/bootstrap.min.js')?>
   <!--Alerts-->
   <?php echo Html::script('frontend/js/jquery.growl.js')?>
   <?php echo Html::script('frontend/js/sweetalert-dev.js')?>
   

</html>