@extends('layouts.template_frontend_error')
@section('content')
<section id="content" class="section-contact p-top30"  >
   <div class="container">
      <div class="row text-center">
         <div class="col-md-4 col-sm-4 col-xs-12"></div>
         <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="panel panel-default pnal-top-error">

               <?php
                     $url = env('OID_AUTH');
                     $url.='?client_id=' . env('OID_CLIENT_ID');
                     $url.='&redirect_uri=' . env('APP_URL').'/verifylogin';
                     $url.='&response_type=code&state=1';
                     
                     ?>
                  <form id="cancel" action="<?php echo $url;?>" method="post">
                     <input type="hidden" name="authorize" value="0">
                     <input type="hidden" name="logout" value="1">
               <div class="panel-body">
                  <div class="alert alert-danger" role="alert">
                     Lo sentimos, ha ocurrido un error con tu inicio de sesión ingresa de nuevo para continuar.
                  </div>
                  <br>

                   <input type="submit" id="entrar" class="btn btn-primary btn-block" value="Ingresá">
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4 col-sm-4 col-xs-12"></div>
      </div>
   </div>
</section>
@stop