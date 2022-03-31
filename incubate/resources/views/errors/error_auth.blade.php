@extends('layouts.template_frontend_error')
@section('content')
<section id="content" class="section-contact p-top30"  >
   <div class="container">
      <div class="row text-center">
         <div class="col-md-4 col-sm-4 col-xs-12"></div>
         <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="panel panel-default pnal-top-error">
               <div class="panel-body">
                  <div class="alert alert-danger" role="alert">
                     Lo sentimos, ha ocurrido un error con tu inicio de sesión ingresa de nuevo para continuar.
                  </div>
                  <br>
                  <a href="<?php echo url('cerrar-sesion');?>" class="btn btn-primary">Igresar a MiBA</a>
                  
               </div>
            </div>
         </div>
         <div class="col-md-4 col-sm-4 col-xs-12"></div>
      </div>
   </div>
</section>
@stop