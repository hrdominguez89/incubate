@extends('layouts.template')
@section('content')
<div class="content-area">
<div class="breadcrumb-bar">
   <div class="page-title">
      <h1><i class="ti-bookmark-alt"></i> Presentaciones</h1>
   </div>
   <ul class="admin-breadcrumb">
      <li><a href="{{url('dashboard')}}" title="Escritorio"><i class="ti-desktop"></i> Escritorio</a></li>
      <li>Presentaciones</li>
   </ul>
</div>
<!-- Breadcrumb Bar -->
<div class="widgets-wrapper">
   <div class="row">
      <div class="masonary">
         <div class="col s6">
            <div class="widget z-depth-1">
               <div class="widget-bar">
                  <div class="col s6">
                     <p style="margin-bottom: 10px">Registro de presentación #<?php echo $presentation->id;?></p>
                  </div>
               </div>
               <div class="widget-content">
                  <h6 style="color: #000; padding-bottom: 0px;margin-bottom: 10px">Titular del proyecto:</h6>
                  <p style="margin-bottom: 10px">Nombre: <?php echo $presentation->last_name;?></p>
                  <p style="margin-bottom: 10px">Apellido: <?php echo $presentation->last_name;?></p>
                  <p style="margin-bottom: 10px">DNI: <?php echo $presentation->dni;?></p>
                  <p style="margin-bottom: 10px">Teléfono: <?php echo $presentation->phone;?></p>
                  <p style="margin-bottom: 10px">Correo electrónico: <?php echo $presentation->email;?></p>
                  <?php $person=DB::table('persons')->where('id', $presentation->person)->first(); ?>
                  <p style="margin-bottom: 10px">Te presentás como: <?php echo $person->name;?></p>
                  <hr>
                  <h6 style="color: #000; padding-bottom: 0px;margin-bottom: 10px">Detalle del  emprendimiento:</h6>
                  <p style="margin-bottom: 10px">Nombre del emprendimiento: <?php echo $presentation->project_name;?></p>
                  <p style="margin-bottom: 10px">Web del emprendimiento: <?php if($presentation->website!="") { echo $presentation->website; } else { echo "N/A";} ?></p>
                  <?php 
                     $category='';
                     for ($i = 0; $i <= substr_count($presentation->category, ','); $i++) {
                       $category_es= explode(',', $presentation->category);
                       $get_category = DB::table('categories_job')->where('id',$category_es[$i])->first();
                       if(isset($get_category)!=0){
                          $category .= $get_category->name.' ';
                       }
                     }
                     ?>
                  <p style="margin-bottom: 10px">Categoría: <?php echo $category;?></p>
                  <?php $members=DB::table('members_job')->where('id', $presentation->members)->first(); ?>
                  <p style="margin-bottom: 10px">Cantidad de miembros del equipo: <?php echo $members->name;?></p>
                  <?php $dedicated=DB::table('dedicated')->where('id', $presentation->dedicated)->first(); ?>
                  <p style="margin-bottom: 10px">Dedicación de los miembros del equipo: <?php echo $dedicated->name;?></p>
                  <?php $state=DB::table('states')->where('id', $presentation->state)->first(); ?>
                  <p style="margin-bottom: 10px">Estadio del emprendimiento: <?php echo $state->name;?></p>
                  <p style="margin-bottom: 10px">URL del video: <?php if($presentation->website!="") { echo $presentation->video; } else { echo "N/A"; };?></p>
                  <p style="margin-bottom: 10px">Descripción: <?php echo $presentation->description;?></p>
                  <hr>
                  <h6 style="color: #000; padding-bottom: 0px;margin-bottom: 10px">Documentación:</h6>
                  <?php 
                     for ($i = 1; $i <= substr_count($presentation->documents, ','); $i++) {
              
                       $document= explode(',', $presentation->documents);
                       echo '<div class="col s3" ><br>';
                       echo '<img src="'.url('/').'/uploads/icons/archive.png" alt="Photo" style="width: 80px">';
                       echo '<a style="cursor:pointer;font-size: 13px;" href="'.url('/').'/descarga/'.$document[0].'" target="_blank">'.$document[0].'</a>';
                       echo '</div>';
                     
                     }
                     
                     ?>
                
                  <div class="col s12" style="clear: both;"><br></div>
                    <hr style="clear: both;">
                  <h6 style="color: #000; padding-bottom: 0px;margin-bottom: 10px; clear: both;">Intereses:</h6>
                  <p><?php 
                     $interest='';
                     for ($i = 0; $i <= substr_count($presentation->interest, ','); $i++) {
                       $interes= explode(',', $presentation->interest);
                       $get_interest = DB::table('interests')->where('id',$interes[$i])->first();
                       if(isset($get_interest)!=0){
                          $interest .= $get_interest->name.' ';
                       }
                     }
                     echo $interest;
                     ?>
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@stop