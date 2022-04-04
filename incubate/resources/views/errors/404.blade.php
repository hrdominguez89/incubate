@extends('layouts.template_frontend_error')
@section('content')
<section id="content" class="section-contact p-top30"  >
   <div class="container">
      <div class="row text-center">
         
         <img src="<?php echo url('/');?>/uploads/bg/error_404.png" alt="No hay resultados" class="img-error">
         <div class="col-md-12">
            <h1 class="title-error-p">Lo sentimos, no pudimos encontrar la página</h1>
         </div>
         <div class="col-md-12">
            <br>
            <a href="{{url('/')}}" class="btn btn-primary">Ir al inicio</a>
         </div>
        
      </div>
   </div>
   <br>
   <br>
   <br>
</section>
@stop