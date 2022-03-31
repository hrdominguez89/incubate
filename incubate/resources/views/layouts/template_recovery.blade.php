<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>Área Administrativa - IncuBAte</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="theme-color" content="#fdd306"/>
          <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo url('/')?>/uploads/icons/favicon.png">
        <!-- Styles -->
        <?php echo Html::style('backend/css/font-awesome.css')?>
        <?php echo Html::style('backend/css/materialize.min.css')?>
        <?php echo Html::style('backend/css/icons.css')?>
        <?php echo Html::style('backend/css/style.css')?>
        <?php echo Html::style('backend/css/responsive.css')?>
        <?php echo Html::style('backend/css/color.css')?>
        <?php echo Html::style('backend/css/jquery.growl.css')?>
        <?php echo Html::style('backend/css/sweetalert.css')?>
        <?php echo Html::script('backend/js/jquery.min.js')?>
        <?php echo Html::script('backend/js/materialize.min.js')?>
  

    </head>
    <style type="text/css">
        body {
         margin: 0px;
         width: 100%;
         overflow-x: hidden;
         background-color: #f3f3f4;
     }
      .login-form-box form {
    margin-top:50px
}
</style>
    <body>
        <div class="loader-container circle-pulse-multiple">
            <div class="page-loader">
                <div id="loading-center-absolute">
                    <div class="object" id="object_four"></div>
                    <div class="object" id="object_three"></div>
                    <div class="object" id="object_two"></div>
                    <div class="object" id="object_one"></div>
                </div>
            </div>
        </div>
        <div class="login-page">
            <div class="login-form-box z-depth-1">
                <img class="logo_regular" src="<?php echo url('/')?>/uploads/backend/logo.png"  style="    width: 230px;
    float: none;
    margin-top: 20px;
    margin-bottom: 20px;"/>
                <h1 style="color: #000">Recuperar Contraseña</h1>
                <h3 style="color: #000">Por favor ingresá tu correo electrónico</h3>
                @yield('content')
                <p><a href="<?php echo url('/')?>/cms" style="color: #000; font-size: 14px">Iniciá sesión</a></p>
                  <span>&nbsp;</span>
                <?php $site = DB::table('site')->where('id', '1')->first(); ?>
                <a href="<?php echo url('/')?>" style="color: #000"><i class="ti-arrow-left" style="color:#000"> </i> Regresá a IncuBAte</a>
            </div>
            <p style="text-align: center;color: #000"> <span >IncuBAte </span> © {{date("Y")}} Todos los derechos reservados</p>
        </div>
        <input type="hidden" name="url" value="<?php echo url('/')?>" id="url">
        <?php echo Html::script('backend/js/enscroll-0.5.2.min.js')?>
        <?php echo Html::script('backend/js/slick.min.js')?>
        <?php echo Html::script('backend/js/script.js')?>
        <?php echo Html::script('backend/js/jquery.growl.js')?>
        <?php echo Html::script('backend/js/sweetalert-dev.js')?>
        <?php echo Html::script('backend/js/aes.js')?>
        <?php echo Html::script('backend/js/function.js')?>
    </body>
</html>
