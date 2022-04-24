@extends('layouts.template_frontend')
@section('content')


 @if(env('ACTIVATE_CAPTCHA')==1)
  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo env('CAPTCHA_KEY_SITE');?>"></script>
  @endif
  
<?php  $banner = DB::table('banners')->where('id', '7')->first();
   $image='';
   $vide0='';
   if($banner->image!='' && strpos($banner->image, ',') !== false ){
      $image=explode(",",$banner->image);
      $image=$image[1];
   }
   
   if($banner->video!="" && strpos($banner->video, '=') !== false){
      $video=explode("=",$banner->video);
      $video=$video[1];
   }
   ?>
@if($banner->type=='1' && $image!='')
<section class="block block-system clearfix hidden-xs">
   <div class="pane-content">
      <div class="jumbotron jumbotron-main jumbotron-small area-header" style="background-image: url('<?php echo url('/');?>/images/<?php echo $image;?>');">
         <div class="area-video-container">
            <div class="jumbotron-overlay">
               <div class="container">
                  <nav role="navigation">
                     <ol class="breadcrumb">
                        <li><a href="<?php echo ($lang == 'es') ? url('/') : url('en'); ?>"><?php echo ($lang == 'es') ? 'Inicio' : 'Home' ;?></a></li>
                        <li class="active"><?php echo $tab;?></li>
                     </ol>
                  </nav>
               </div>
            </div>
            <div class="container">
               <div class="area-title">
                  <h1><?php echo ($lang == 'es') ? $banner->title : $banner->title_en ;?></h1>
                  <p class="lead"><?php echo ($lang == 'es') ? $banner->subtitle : $banner->subtitle_en ;?></p>
                  @if($banner->name_boton!="" && $lang=='es')
                  <a href="<?php echo url($banner->url_boton);?>" class="btn btn-lg btn-primary btn-section"><?php echo $banner->name_boton;?></a>
                  @endif
                  @if($banner->name_boton_en!="" && $lang=='en')
                  <a href="<?php echo url($banner->url_boton_en);?>" class="btn btn-lg btn-primary btn-section"><?php echo $banner->name_boton_en;?></a>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endif
@if($banner->type=='2' && $video!='')
<section class="block block-system clearfix hidden-xs" id="youtube-bg" data-video="<?php echo $video;?>">
   <div class="jumbotron jumbotron-main jumbotron-small">
      <div class="area-video-container">
         <div class="jumbotron-overlay">
            <div class="container">
               <nav role="navigation">
                  <ol class="breadcrumb">
                     <li><a href="<?php echo ($lang == 'es') ? url('/') : url('en'); ?>"><?php echo ($lang == 'es') ? 'Inicio' : 'Home' ;?></a></li>
                     <li class="active"><?php echo $tab;?></li>
                  </ol>
               </nav>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="area-title">
            <h1><?php echo ($lang == 'es') ? $banner->title : $banner->title_en ;?></h1>
            <p class="lead"><?php echo ($lang == 'es') ? $banner->subtitle : $banner->subtitle_en ;?></p>
            @if($banner->name_boton!="" && $lang=='es')
            <a href="<?php echo url($banner->url_boton);?>" class="btn btn-lg btn-primary btn-section"><?php echo $banner->name_boton;?></a>
            @endif
            @if($banner->name_boton_en!="" && $lang=='en')
            <a href="<?php echo url($banner->url_boton_en);?>" class="btn btn-lg btn-primary btn-section"><?php echo $banner->name_boton_en;?></a>
            @endif
         </div>
      </div>
   </div>
</section>
@endif
<section class="bg-section  bg-projects clearfix">
   <form enctype="multipart/form-data" id="formP" method="post">
      <input type="hidden" name="captcha" id="captcha" value="">
      <div class="container">
         <div class="row">
            <div class="col-md-6 col-sm-6">
               <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                     0%
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-sm-6"></div>
         </div>
      </div>
      <div class="container" id="sectmyBA">
         <div class="row">
            <?php $section = DB::table('sections')->where('id', '11')->first(); ?>

            <div class="col-md-6 col-sm-6">
                @if($section->status_content==1)
               <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
               @if($section->content!="" && $lang=='es')
               <?php echo $section->content;?>
               @endif
               @if($section->content_en!="" && $lang=='en')
               <?php echo $section->content_en;?>
               @endif
               @endif
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'Nombre' : 'Firts Name' ;?> <small style="color: #fd2923">*</small></label>
                  <input type="text" class="form-control input-lg" id="name_in" name="name_in" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu nombre' : 'Enter your full name' ;?>"  onkeypress="enter_name_in(event)" onchange="increment_bar()" onkeyup="increment_bar()">
               </div>
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'Apellido' : 'Last Name' ;?> <small style="color: #fd2923">*</small></label>
                  <input type="text" class="form-control input-lg" id="last_name_in" name="last_name_in" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu apellido' : 'Enter your last name' ;?>"  onkeypress="enter_last_name_in(event)" onchange="increment_bar()" onkeyup="increment_bar()">
               </div>
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'DNI' : 'DNI' ;?> <small style="color: #fd2923">*</small></label>
                  <input type="tel" class="form-control input-lg" id="dni_in" name="dni_in" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu DNI' : 'Enter your DNI' ;?>"  onkeypress="enter_dni_in(event)" onchange="increment_bar()" onkeyup="increment_bar()">
               </div>
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'Teléfono' : 'Phone' ;?> <small style="color: #fd2923">*</small></label>
                  <input type="tel" class="form-control input-lg" id="phone_in" name="phone_in" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu teléfono' : 'Enter your phone' ;?>"  onkeypress="enter_phone_in(event)" onchange="increment_bar()" onkeyup="increment_bar()">
               </div>
               <div class="form-group">
                  <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
               </div>
               <div class="form-group row">
                  <div class="col-md-6 col-sm-6 text-right"></div>
                  <div class="col-md-6 col-sm-6 text-right">
                     <button class="btn btn-lg btn-default" disabled="disabled" id="btn-1" type="button" onclick="nextmyBA()" ><?php echo ($lang == 'es') ? 'Siguiente' : 'Next' ;?></button>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="container" id="sectTitular" style="display: none;">
         <div class="row">
            <div class="col-md-6 col-sm-6">
               <?php $section = DB::table('sections')->where('id', '12')->first(); ?>
                @if($section->status_content==1)
               <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
               @if($section->content!="" && $lang=='es')
               <?php echo $section->content;?>
               @endif
               @if($section->content_en!="" && $lang=='en')
               <?php echo $section->content_en;?>
               @endif
               @endif
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'Nombre' : 'Firts Name' ;?> <small style="color: #fd2923">*</small></label>
                  <input type="text" class="form-control input-lg" id="name" name="name" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu nombre' : 'Enter your full name' ;?>"  onkeypress="enter_name(event)" onchange="increment_bar()" onkeyup="increment_bar()">
               </div>
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'Apellido' : 'Last Name' ;?> <small style="color: #fd2923">*</small></label>
                  <input type="text" class="form-control input-lg" id="last_name" name="last_name" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu apellido' : 'Enter your last name' ;?>"  onkeypress="enter_last_name(event)" onchange="increment_bar()" onkeyup="increment_bar()">
               </div>
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'DNI' : 'DNI' ;?> <small style="color: #fd2923">*</small></label>
                  <input type="tel" class="form-control input-lg" id="dni" name="dni" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu DNI' : 'Enter your DNI' ;?>"  onkeypress="enter_dni(event)" onchange="increment_bar()" onkeyup="increment_bar()">
               </div>
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'Teléfono' : 'Phone' ;?> <small style="color: #fd2923">*</small></label>
                  <input type="tel" class="form-control input-lg" id="phone" name="phone" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu teléfono' : 'Enter your phone' ;?>"  onkeypress="enter_phone(event)" onchange="increment_bar()" onkeyup="increment_bar()">
               </div>
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'Correo electrónico' : 'Email' ;?> <small style="color: #fd2923">*</small></label>
                  <input type="text" class="form-control input-lg" id="email" name="email" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu correo electrónico' : 'Enter your email' ;?>"  onkeypress="enter_email(event)" onchange="increment_bar()" onkeyup="increment_bar()">
               </div>
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'Confirmar correo electrónico' : 'Confirm Emai' ;?> <small style="color: #fd2923">*</small></label>
                  <input type="text" class="form-control input-lg" id="conf_email" name="conf_email" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu correo electrónico' : 'Enter your email' ;?>" onchange="increment_bar()" onkeyup="increment_bar()">
               </div>
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'Te presentás como:' : 'You present yourself as:' ;?> <small style="color: #fd2923">*</small></label>
               </div>
               <div class="form-group clearfix">
                  @foreach($person as $rs)
                  <div class="demo">
                     <input type="radio" id="person-<?php echo $rs->id;?>" name="person" class="person" value="<?php echo $rs->id;?>" onchange="increment_bar()">
                     <label for="person-<?php echo $rs->id;?>"><span></span><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></label>
                  </div>
                  @endforeach
               </div>
               <div class="form-group clearfix">
                  <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
               </div>
               <div class="form-group row">
                  <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                     <button class="btn btn-lg btn-primary"  type="button" onclick="prevTitular()" ><?php echo ($lang == 'es') ? 'Anterior' : 'Previous' ;?></button>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                     <button class="btn btn-lg btn-default"  type="button" id="btn-2" disabled="disabled" onclick="nextTitular()" ><?php echo ($lang == 'es') ? 'Siguiente' : 'Next' ;?></button>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-sm-6"></div>
         </div>
      </div>
      <div class="container" id="sectEmpr" style="display: none;">
         <div class="row">
            <div class="col-md-6 col-sm-6">
               <?php $section = DB::table('sections')->where('id', '13')->first(); ?> 
                @if($section->status_content==1)
               <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
               @if($section->content!="" && $lang=='es')
               <?php echo $section->content;?>
               @endif
               @if($section->content_en!="" && $lang=='en')
               <?php echo $section->content_en;?>
               @endif
               @endif
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'Nombre del emprendimiento' : 'Nombre del emprendimiento' ;?> <small style="color: #fd2923">*</small></label>
                  <input type="text" class="form-control input-lg" id="project_name" name="project_name" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu nombre de proyecto' : 'Enter your project name' ;?>"  onkeypress="enter_project_name(event)" onchange="increment_bar()" onkeyup="increment_bar()">
               </div>
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'Web del emprendimiento' : 'Web del emprendimiento' ;?></label>
                  <input type="text" class="form-control input-lg" id="website" name="website" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu sitio web' : 'Enter your website' ;?>" >
               </div>
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'Categoría' : 'Category' ;?> <small style="color: #fd2923">*</small></label>
               </div>
               <div class="form-group clearfix">
                  @foreach($categories as $rs)
                   <div class="demo">
                     <input type="checkbox" id="category-<?php echo $rs->id;?>" name="category[]" class="category" value="<?php echo $rs->id;?>" onchange="increment_bar()">
                     <label for="category-<?php echo $rs->id;?>"><span></span><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></label>
                  </div>
                  @endforeach
               </div>
               <div class="form-group clearfix">
                  <label>Cantidad de miembros del equipo <small style="color: #fd2923">*</small></label>
               </div>
               <div class="form-group clearfix">
                  @foreach($member as $rs)
                  <div class="demo">
                     <input type="radio" id="member-<?php echo $rs->id;?>" name="members" class="members" value="<?php echo $rs->id;?>" onchange="increment_bar()">
                     <label for="member-<?php echo $rs->id;?>"><span></span><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></label>
                  </div>
                  @endforeach
               </div>
               <div class="form-group clearfix">
                  <label>Dedicación de los miembros del equipo <small style="color: #fd2923">*</small></label>
               </div>
               <div class="form-group clearfix">
                  @foreach($dedicated as $rs)
                  <div class="demo">
                     <input type="radio" id="dedicated-<?php echo $rs->id;?>" name="dedicated" class="dedicated" value="<?php echo $rs->id;?>" onchange="increment_bar()">
                     <label for="dedicated-<?php echo $rs->id;?>"><span></span><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></label>
                  </div>
                  @endforeach
               </div>
               <div class="form-group clearfix">
                  <label>¿En qué estadio está tu emprendimiento? <small style="color: #fd2923">*</small></label>
               </div>
               <div class="form-group clearfix">
                  @foreach($state as $rs)
                  <div class="demo">
                     <input type="radio" id="state-<?php echo $rs->id;?>" name="state" class="state" value="<?php echo $rs->id;?>" onchange="increment_bar()">
                     <label for="state-<?php echo $rs->id;?>"><span></span><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></label>
                  </div>
                  @endforeach
               </div>
               <div class="form-group clearfix">
                  <label><?php echo ($lang == 'es') ? 'Subí tu video' : 'Subí tu video' ;?></label>
                  <input type="text" class="form-control input-lg" id="video" name="video" placeholder="<?php echo ($lang == 'es') ? 'Ingresá la url de tu video' : 'Enter the url of your video' ;?>" onkeypress="enter_video(event)" onkeyup="increment_bar()" >
               </div>
               <div class="form-group">
                  <label><?php echo ($lang == 'es') ? 'Breve descripción del emprendimiento' : 'Breve descripción del emprendimiento' ;?> <small style="color: #fd2923">*</small></label>
                  <textarea class="form-control input-lg" rows="3" id="description" name="description" placeholder="<?php echo ($lang == 'es') ? 'Escribir comentario' : 'Write comment' ;?>" onchange="increment_bar()" onkeyup="increment_bar()"></textarea>
               </div>
               <div class="form-group">
                  <div class="form-group ">
                  
                     <input  type="file" accept="image/png,image/jpeg,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" id="archive" name="archive" class="inputfile inputfile-1" />
                     <label for="archive" id="iborrainputfile"><?php echo ($lang == 'es') ? 'Subí la documentación *': 'I uploaded the documentation *'; ?> (JPG/PNG/PDF/DOCS)
                     </label>
                  </div>
               </div>
               <div class="form-group clearfix">
                  <label><?php echo ($lang == 'es') ? '¿Que te interesa de IncuBAte?':'What interests you about IncuBAte?';?> <small style="color: #fd2923">*</small></label>
               </div>
               <div class="form-group clearfix">
                  @foreach($interest as $rs)
                  <div class="demo">
                     <input type="checkbox" id="interest-<?php echo $rs->id;?>" name="interest[]" class="interest" value="<?php echo $rs->id;?>" onchange="increment_bar()">
                     <label for="interest-<?php echo $rs->id;?>"><span></span><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></label>
                  </div>
                  @endforeach
               </div>
               <div class="form-group clearfix">
                  <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
               </div>
               <div class="form-group row">
                  <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                     <button class="btn btn-lg btn-primary"  type="button" onclick="prevEmpre()" ><?php echo ($lang == 'es') ? 'Anterior' : 'Previous' ;?></button>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                     <button class="btn btn-lg btn-default" disabled="disabled"  id="btn-finalizar" data-title="<?php echo ($lang == 'es') ? 'Finalizar' : 'Submit' ;?>" type="button" onclick="finalizar()" ><?php echo ($lang == 'es') ? 'Finalizar' : 'Submit' ;?></button>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-sm-6"></div>
         </div>
      </div>
      
      <div class="container hidden-lg hidden-md hidden-sm">
         <div class="row">
            <div class="col-md-6 col-sm-6">
               <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                     0%
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-sm-6"></div>
         </div>
      </div>
   </form>
</section>
<input type="hidden" value="<?php echo env('CAPTCHA_KEY_SITE');?>" id="captcha-key">
<input type="hidden" value="<?php echo env('ACTIVATE_CAPTCHA');?>" id="activate_captcha">
@stop