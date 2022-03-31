@extends('layouts.template_frontend')
@section('content')

 @if(env('ACTIVATE_CAPTCHA')==1)
  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo env('CAPTCHA_KEY_SITE');?>"></script>
  @endif
  
<?php  $banner = DB::table('banners')->where('id', '1')->first();
   $image='';
   $vide0='';
   if($banner->image!='' && strpos($banner->image, ',') !== false){
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
                        <li><?php echo ($lang == 'es') ? 'Inicio' : 'Home' ;?></li>
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
                     <li><?php echo ($lang == 'es') ? 'Inicio' : 'Home' ;?></li>
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
<?php $section = DB::table('sections')->where('id', '1')->first(); ?>
@if($section->status==1)
<section class="bg-section clearfix hidden-xs">
   <div class="container">
      <div class="row">
         @if($section->status_content==1)
         <div class="col-md-12">
            <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
         </div>
         @endif
         <div class="col-md-8 col-sm-8 text-center">
            <?php $posts = DB::table('posts')->offset(0)->limit(1)->orderBy('created_at', 'desc')->get(); ?>
            @foreach($posts as $rs)
            @if($rs->image!="" && strpos($rs->image, ',') !== false )
            <div class="post-new" onclick="GoToPost('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')">
               <?php    $image=explode(",",$rs->image) ?>
               <img class="img-rounded" src="<?php echo url('/');?>/images/<?php echo $image[1];?>" alt="<?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>">
               <div class="post-new-title" onclick="GoToPost('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')">
                  <?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>
               </div>
            </div>
            @endif
            @endforeach
         </div>
         <div class="col-md-4 col-sm-4 text-center no-padding">
            <?php $posts = DB::table('posts')->offset(1)->limit(2)->orderBy('created_at', 'desc')->get(); ?>
            @foreach($posts as $rs)
            @if($rs->image!="" && strpos($rs->image, ',') !== false )
            <div class="post-new-1" onclick="GoToPost('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')">
               <?php    $image=explode(",",$rs->image) ?>
               <img class="img-rounded" src="<?php echo url('/');?>/images/<?php echo $image[1];?>" alt="<?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>">
               <div class="post-new-1-title" onclick="GoToPost('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')">
                  <?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>
               </div>
            </div>
            @endif
            @endforeach
         </div>
         <div class="col-md-12 text-center">
            @if($section->name_boton!="" && $lang=='es')
            <a href="<?php echo url($section->url_boton);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton;?></a>
            @endif
            @if($section->name_boton_en!="" && $lang=='en')
            <a href="<?php echo url($section->url_boton_en);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton_en;?></a>
            @endif
         </div>
      </div>
   </div>
</section>

<section class="bg-section clearfix hidden-lg hidden-md hidden-sm">
   <div class="container">
      <div class="row">
          @if($section->status_content==1)
         <div class="col-md-12">
            <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
         </div>
         @endif
         <?php $posts = DB::table('posts')->offset(0)->limit(3)->orderBy('created_at', 'desc')->get(); ?>
         @foreach($posts as $rs)
         @if($rs->image!="" && strpos($rs->image, ',') !== false )
         <div class="col-md-12">
            <div class="thumbnail card-chica" onclick="GoToPost('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')">
               <?php    $image=explode(",",$rs->image) ?>
               <img class="img-rounded" src="<?php echo url('/');?>/images/<?php echo $image[1];?>" alt="<?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>">
               <div class="post-caption">
                  <h3><?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?></h3>
                  <p><?php echo ($lang == 'es') ? $rs->resume : $rs->resume_en ;?></p>
                  <a onclick="GoToPost('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')" class="btn btn-primary"> <?php echo ($lang == 'es') ? 'Leer más' : 'Read more' ;?></a>
               </div>
            </div>
         </div>
         @endif
         @endforeach
         <div class="col-md-12 text-center">
            @if($section->name_boton!="" && $lang=='es')
            <a href="<?php echo url($section->url_boton);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton;?></a>
            @endif
            @if($section->name_boton_en!="" && $lang=='en')
            <a href="<?php echo url($section->url_boton_en);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton_en;?></a>
            @endif
         </div>
      </div>
   </div>
</section>

@endif
<?php $section = DB::table('sections')->where('id', '2')->first(); ?>
@if($section->status==1)
<section class="bg-section-4 clearfix">
   <div class="container">
   <div class="row">
      @if($section->status_content==1)
      <div class="col-md-12">
         <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
      
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
   
      </div>
      @endif
      <div class="col-md-3 col-sm-3 clearfix p-right0 hidden-xs" >
         <ul class="tab-h">
            <?php $i=0; ?>
            @foreach($informations as $rs)
            <?php $i=$i+1; ?>
            <li @if($i==1) class="active" @endif><a data-toggle="tab" href="#info-<?php echo $rs->id;?>" class="btn btn-default"><?php echo ($lang == 'es') ? $rs->boton_name : $rs->boton_name_en ;?></a></li>
            @endforeach
         </ul>
      </div>
      <div class="col-md-4 col-sm-4 clearfix hidden-lg hidden-md hidden-sm" >
            <select class="form-control" onchange="ShowTabs()" id="category" >
               @foreach($informations as $rs)
               <option value="info-<?php echo $rs->id;?>"><?php echo ($lang == 'es') ? $rs->boton_name : $rs->boton_name_en ;?></option>
               @endforeach
            </select>
         </div>
      <div class="col-md-9  col-sm-9">
         <div class="tab-content">
            <?php $i=0; ?>
            @foreach($informations as $rs)
            <?php $i=$i+1; ?>
            <div id="info-<?php echo $rs->id;?>" class="tab-pane fade @if($i==1) in active @endif">
               <div class="row">
                  <div class="col-md-12 col-sm-12">
                     <h3><?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?></h3>
                     <p> <?php echo ($lang == 'es') ? $rs->subtitle : $rs->subtitle_en ;?></p>
                  </div>
                     @if($rs->image!="" && strpos($rs->image, ',') !== false )
                  <div class="col-md-3 col-sm-3 hidden-xs">
                     
                     <?php    $image=explode(",",$rs->image) ?>
                     <img style="width: 100%" src="<?php echo url('/');?>/images/<?php echo $image[1];?>" alt="<?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>">
                   
                  </div>
                  @endif
                  <div   @if($rs->image!="") class="col-md-9 col-sm-9 text-justify" @else class="col-md-12 col-sm-12 text-justify" @endif>
                     <?php echo ($lang == 'es') ? $rs->content : $rs->content_en ;?>
                  </div>
                    <div class="col-md-12 col-sm-12 hidden-lg hidden-md hidden-sm">
                     @if($rs->image!="" && strpos($rs->image, ',') !== false )
                     <?php    $image=explode(",",$rs->image) ?>
                     <img style="width: 100%" src="<?php echo url('/');?>/images/<?php echo $image[1];?>" alt="<?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>">
                     @endif
                  </div>
               </div>
            </div>
            @endforeach
         </div>
      </div>
         <div class="col-md-12 text-center mbs1">
            @if($section->name_boton!="" && $lang=='es')
            <a href="<?php echo url($section->url_boton);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton;?></a>
            @endif
            @if($section->name_boton_en!="" && $lang=='en')
            <a href="<?php echo url($section->url_boton_en);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton_en;?></a>
            @endif
         </div>
      </div>
   </div>
</section>
@endif
<?php $section = DB::table('sections')->where('id', '18')->first(); ?>
@if($section->status==1)
<section class="bg-section clearfix">
   <div class="container">
      <div class="row">
         @if($section->status_content==1)
         <div class="col-md-12">
            <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
         </div>
         @endif
         <div class="col-md-12 text-center clearfix" >
            <br>
         </div>
         @foreach($etapas as $rs)
         @if($rs->image!="" && strpos($rs->image, ',') !== false )
         <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="shortcut">
               <?php    $image=explode(",",$rs->image) ?>
               <img class="icono-shortcut" src="<?php echo url('/');?>/images/<?php echo $image[1];?>" alt="<?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>">
               <h3> <?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?> </h3>
               <?php echo ($lang == 'es') ? $rs->content : $rs->content_en ;?>
            </div>
         </div>
         @endif
         @endforeach
      </div>
   </div>
@endif

           <?php $section = DB::table('sections')->where('id', '3')->first(); ?>
   @if($section->status==1)
   <div class="container hidden-xs">
      <div class="row">
         @if($section->status_content==1)
         <div class="col-md-12">
            <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
         </div>
         @endif
         <div class="col-md-12 text-center clearfix" >
            <br>
         </div>
         @foreach($beneficios as $rs)
         @if($rs->image!="" && strpos($rs->image, ',') !== false )
         <div class="col-md-3 col-sm-3 col-xs-12">
            <div class=" card thumbnail tthome">
               <a href="" class="flex-container-col">
                  <div class="thumbnail-image">
                     <?php    $image=explode(",",$rs->image) ?>
                     <img src="<?php echo url('/');?>/images/<?php echo $image[1];?>" alt="<?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>">
                  </div>
                  <div class="transparencia caption">
                     <h3><?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?></h3>
                     <?php echo ($lang == 'es') ? $rs->content : $rs->content_en ;?>
                  </div>
               </a>
            </div>
         </div>
         @endif
         @endforeach
         <div class="col-md-12 text-center clearfix" >
            @if($section->name_boton!="" && $lang=='es')
            <a href="<?php echo url($section->url_boton);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton;?></a>
            @endif
            @if($section->name_boton_en!="" && $lang=='en')
            <a href="<?php echo url($section->url_boton_en);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton_en;?></a>
            @endif
         </div>
      </div>
   </div>
   @endif
</section>

<?php $section = DB::table('sections')->where('id', '3')->first(); ?>
@if($section->status==1)
          
<section class="bg-section-3 hidden-lg hidden-md hidden-sm">
   @if($section->status_content==1)
   <div class="container">
      <div class="row">
         <div  class="col-md-12">
            <h2 onclick="showSection()"><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?> <i class="glyphicon glyphicon-chevron-down"  id="angle"></i></h2>
         </div>
      </div>
   </div>
   @endif
   <div class="container" id="desplegable" style="display: none;">
      <div class="row">
         <div  class="col-md-12">
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
         </div>
         <div class="col-md-12 text-center clearfix" >
            <br>
         </div>
         @foreach($beneficios as $rs)
         @if($rs->image!="" && strpos($rs->image, ',') !== false )
         <div class="col-md-3 col-sm-3 col-xs-12">
            <div class=" card thumbnail tthome">
               <a href="" class="flex-container-col">
                  <div class="thumbnail-image">
                     <?php    $image=explode(",",$rs->image) ?>
                     <img src="<?php echo url('/');?>/images/<?php echo $image[1];?>" alt="<?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>">
                  </div>
                  <div class="transparencia caption">
                     <h3><?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?></h3>
                     <?php echo ($lang == 'es') ? $rs->content : $rs->content_en ;?>
                  </div>
               </a>
            </div>
         </div>
         @endif
         @endforeach
         <div class="col-md-12 text-center clearfix" >
            @if($section->name_boton!="" && $lang=='es')
            <a href="<?php echo url($section->url_boton);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton;?></a>
            @endif
            @if($section->name_boton_en!="" && $lang=='en')
            <a href="<?php echo url($section->url_boton_en);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton_en;?></a>
            @endif
         </div>
      </div>
   </div>
</section>
@endif

<?php $section = DB::table('sections')->where('id', '4')->first(); ?>
@if($section->status==1)
<section class="bg-section-1 clearfix hidden-xs">
   <div class="container">
      <div class="row">
         <div class="col-md-2 col-sm-2"></div>
         <div class="col-md-8 col-sm-8">
            @if($section->status_content==1)
            <h3><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h3>
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
            @endif
            <form id="form" action="#">
               <input type="hidden" name="captcha" id="captcha" value="">
               <div class="input-group">
                  <input class="form-control input-lg" id="email" name="email" type="text" placeholder="<?php echo ($lang == 'es') ? 'Ingresá tu correo electrónico' : 'Enter your email' ;?>" onkeypress="enter_newsletter(event)">
                  <span class="input-group-btn">
                  <button class="btn btn-lg btn-primary" onclick="send_newsletter()"  data-title="<?php echo ($lang == 'es') ? $section->name_boton : $section->name_boton_en ;?>" type="button" id="btn-newsletter"><?php echo ($lang == 'es') ? $section->name_boton : $section->name_boton_en ;?></button>
                  </span>
               </div>
            </form>
         </div>
         <div class="col-md-2 col-sm-2"></div>
      </div>
   </div>
</section>
@endif
<input type="hidden" value="<?php echo env('CAPTCHA_KEY_SITE');?>" id="captcha-key">
<input type="hidden" value="<?php echo env('ACTIVATE_CAPTCHA');?>" id="activate_captcha">
@stop