@extends('layouts.template_frontend')
@section('content')
  <?php  $site = DB::table('site')->where('id', '1')->first(); ?>

  
  @if(env('ACTIVATE_CAPTCHA')==1)
  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo env('CAPTCHA_KEY_SITE');?>"></script>
  @endif


<?php  $banner = DB::table('banners')->where('id', '6')->first();
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

 <?php $section = DB::table('sections')->where('id', '10')->first(); ?>

 @if($section->status==1)
<section class="bg-section-1 clearfix">
   <div class="container">
      <div class="row">
        
         <div class="col-md-6 col-sm-6">

            @if($section->status_content==1)
            <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
           

            @endif
            
            <form id="form" action="#" >
               <input type="hidden" name="captcha" id="captcha" value="">
               <div class="form-group">
                  <label for="name"><?php echo ($lang == 'es') ? 'Nombre y apellido' : 'Full Name' ;?> <small style="color: #fd2923">*</small></label>
                  <input type="text" class="form-control input-lg" id="name" name="name" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu nombre y apellido' : 'Enter your full name' ;?>"  onkeypress="enter_name_c(event)" onkeyup="validateContact()" onchange="validateContact()">
               </div>
               <div class="form-group">
                  <label for="email"><?php echo ($lang == 'es') ? 'Correo electrónico' : 'Email' ;?> <small style="color: #fd2923">*</small></label>
                  <input type="text" class="form-control input-lg" id="email" name="email" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu correo electrónico' : 'Enter your email' ;?>"  onkeypress="enter_email_c(event)" onkeyup="validateContact()" onchange="validateContact()">
               </div>
               <div class="form-group">
                  <label for="message"><?php echo ($lang == 'es') ? 'Mensaje' : 'Message' ;?> <small style="color: #fd2923">*</small></label>
                  <textarea class="form-control input-lg" rows="3" id="message" name="message" onkeypress="enter_message_c(event)" placeholder="<?php echo ($lang == 'es') ? 'Escribir comentario' : 'Write comment' ;?>" onkeyup="validateContact()" onchange="validateContact()"></textarea>
               </div>
                <div class="form-group">
                        <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
                      </div>
               <div class="form-group text-right">
                  <button class="btn btn-lg btn-default" disabled="disabled" id="btn-contact" data-title="<?php echo ($lang == 'es') ? $section->name_boton : $section->name_boton_en ;?>" type="button" onclick="send_message()"> <?php echo ($lang == 'es') ? $section->name_boton : $section->name_boton_en ;?></button>
               </div>
            </form>
         </div>
         <div class="col-md-6 col-sm-6">
            <div class="container-cc" >
             @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif

             <ul class="mini-social">
               @if($site->facebook!='')
                  <li><a href="<?php echo $site->facebook;?>" target="_blank"><div  class="m-icon facebook"></div></a></li>
                  @endif
                     @if($site->twitter!='')
                  <li><a href="<?php echo $site->twitter;?>" target="_blank"><div  class="m-icon twitter"></div></a></li>
                  @endif
                    @if($site->instagram!='')
                  <li><a href="<?php echo $site->instagram;?>" target="_blank"><div  class="m-icon instagram"></div></a></li>
                  @endif
                  @if($site->youtube!='')
                  <li><a href="<?php echo $site->youtube;?>" target="_blank"><div  class="m-icon youtube"></div></a></li>
                  @endif
               </ul>
         </div>
         </div>
      </div>
   </div>
</section>
@endif
<input type="hidden" value="<?php echo env('CAPTCHA_KEY_SITE');?>" id="captcha-key">
<input type="hidden" value="<?php echo env('ACTIVATE_CAPTCHA');?>" id="activate_captcha">
@stop