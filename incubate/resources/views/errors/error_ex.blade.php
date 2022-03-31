@extends('layouts.template_frontend_error')
@section('content')
<section id="content" class="section-contact p-top30"  >
   <div class="container">
      <div class="row text-center">
          <div class="col-md-12 pnal-top-error ">
         <img src="<?php echo url('/');?>/uploads/bg/error_404.png" alt="No hay resultados" class="img-error">
        
            <h1 class="title-error-p">Lo sentimos, ha ocurrido un error</h1>
            <br>
            <a href="{{url('/')}}" class="btn btn-primary">Ir al inicio</a>
         </div>
        
      </div>
   </div>
</section>
@stop