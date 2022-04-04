<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="utf-8" />
      <?php  $site = DB::table('site')->where('id', '1')->first(); ?>
      <title><?php echo preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[\s]/s', '', $site->name)?> <?php echo $subtitle?></title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
      <link rel="manifest" href="<?php echo url('/');?>/frontend/js/manifest.json">
      <meta name="mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <meta name="theme-color" content="#fdd306"/>

      @if(isset($title_ogg))


      <meta name="description" content="<?php echo $content_ogg;?>">
      <meta property="og:url" content="<?php echo url('/');?>/<?php echo ($lang == 'es') ? $url_es: $url_en;?>" />
      <meta property="og:type" content="article" />
      <meta property="og:title" content="<?php echo $title_ogg?>" />
      <meta property="og:description" content="<?php echo $content_ogg;?>"/>
      <meta property="og:image" content="<?php echo url('/');?>/uploads/icons/incubate.png">
      <meta property="og:image:alt" content="<?php echo $site->name?> <?php echo $subtitle?>" />

      @else


      <meta name="description" content="<?php echo ($lang == 'es') ? $site->description : $site->description_en;?>">
      <meta name="keywords" content="<?php echo ($lang == 'es') ? $site->keywords : $site->keywords_en;?>">
      <meta property="og:url" content="<?php echo url('/');?>/<?php echo ($lang == 'es') ? $url_es: $url_en;?>" />
      <meta property="og:type" content="article" />
      <meta property="og:title" content="<?php echo $site->name?> <?php echo $subtitle?>" />
      <meta property="og:description" content="<?php echo ($lang == 'es') ? $site->description : $site->description_en;?>"/>
      <meta property="og:image" content="<?php echo url('/');?>/uploads/icons/incubate.png">
      <meta property="og:image:alt" content="<?php echo $site->name?> <?php echo $subtitle?>" />

      @endif
      <!-- Favicon -->
      <link rel="shortcut icon" type="image/x-icon" href="<?php echo url('/')?>/uploads/icons/favicon.png">
      <link rel="apple-touch-icon" href="<?php echo url('/')?>/uploads/icons/apple-touch-icon.png" />
      <link rel="apple-touch-icon" sizes="57x57" href="<?php echo url('/')?>/uploads/icons/apple-touch-icon-57x57.png" />
      <link rel="apple-touch-icon" sizes="72x72" href="<?php echo url('/')?>/uploads/icons/apple-touch-icon-72x72.png" />
      <link rel="apple-touch-icon" sizes="76x76" href="<?php echo url('/')?>/uploads/icons/apple-touch-icon-76x76.png" />
      <link rel="apple-touch-icon" sizes="114x114" href="<?php echo url('/')?>/uploads/icons/apple-touch-icon-114x114.png" />
      <link rel="apple-touch-icon" sizes="120x120" href="<?php echo url('/')?>/uploads/icons/apple-touch-icon-120x120.png" />
      <link rel="apple-touch-icon" sizes="144x144" href="<?php echo url('/')?>/uploads/icons/apple-touch-icon-144x144.png" />
      <link rel="apple-touch-icon" sizes="152x152" href="<?php echo url('/')?>/uploads/icons/apple-touch-icon-152x152.png" />
      <link rel="apple-touch-icon" sizes="180x180" href="<?php echo url('/')?>/uploads/icons/apple-touch-icon-180x180.png" />
      <link rel="apple-touch-startup-image" href="<?php echo url('/')?>/uploads/splash/launch-640x1136.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
      <link rel="apple-touch-startup-image" href="<?php echo url('/')?>/uploads/splash/launch-750x1294.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
      <link rel="apple-touch-startup-image" href="<?php echo url('/')?>/uploads/splash/launch-1242x2148.png" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
      <link rel="apple-touch-startup-image" href="<?php echo url('/')?>/uploads/splash/launch-1125x2436.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
      <link rel="apple-touch-startup-image" href="<?php echo url('/')?>/uploads/splash/launch-1536x2048.png" media="(min-device-width: 768px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
      <link rel="apple-touch-startup-image" href="<?php echo url('/')?>/uploads/splash/launch-1668x2224.png" media="(min-device-width: 834px) and (max-device-width: 834px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
      <link rel="apple-touch-startup-image" href="<?php echo url('/')?>/uploads/splash/launch-2048x2732.png" media="(min-device-width: 1024px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
      <!-- All css files are included here. -->
      <!--Fonts-->
      <?php echo Html::style('backend/css/font-awesome.css')?>
      <!--Alerts-->
      <?php echo Html::style('frontend/css/jquery.growl.css')?>
      <?php echo Html::style('frontend/css/sweetalert.css')?>
      <!-- Bootstrap fremwork main css -->
      <?php echo Html::style('frontend/css/bootstrap.css')?>
      <!--LighBox-->
      <?php echo Html::style('frontend/css/lightbox.min.css')?>
      <!-- Theme main style -->
      <?php echo Html::style('frontend/css/bastrap.css')?>
      <?php echo Html::script('frontend/js/jquery.min.js')?>
      <?php echo Html::script('frontend/js/angular.min.js')?>
      <?php echo Html::script('frontend/js/bootstrap.min.js')?>
      <?php echo Html::script('frontend/js/ui-bootstrap-tpls.min.js')?>
      <?php echo Html::script('frontend/js/moment.min.js')?>
      <?php echo Html::script('frontend/js/materialize.js')?>
   </head>
   <body >
      <div class="preloader bg-2" id="mask">
         <div class="container mtop2 bg-preload">
            <div class="row">
               <div  class="col-md-12 content-spinner" >
                  <div class="spinner">
                     <div class="double-bounce1"></div>
                     <div class="double-bounce2"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div  class="content-sidenav" id="content-sidenav" style="display: none;">
         <div  class="sidenav-right">
            <div class="menu-box">
               <ul class="menu-movil">
                  <li 
@if($_SERVER["REQUEST_URI"]=="/es" || $_SERVER["REQUEST_URI"]=="/en" || $_SERVER["REQUEST_URI"]=="/")

                  class="active"

                  @endif
                  >
                     <a href="<?php echo ($lang == 'es') ? url('/') : url('en');?>"><img src="<?php echo url('/');?>/uploads/icons/home.png" alt=""> <?php echo ($lang == 'es') ? 'Inicio' : 'Home';?></a>
                  </li>
                  <?php   $menu=DB::table('menus')->where('status','1')->orderBy('position', 'asc')->get(); ?>
                  @foreach($menu as $rs)
                  <li


                  @if($_SERVER["REQUEST_URI"]=="/es/".$rs->url || $_SERVER["REQUEST_URI"]=="/en/".$rs->url_en || $_SERVER["REQUEST_URI"]=="/".$rs->url)

                  class="active"

                  @endif


                  >
                     <a href="<?php echo url('/')?>/<?php echo ($lang == 'es') ? $rs->url: $rs->url_en;?>" >

                        @if($rs->image!="")

                         <?php    $image=explode(",",$rs->image) ?>


                          <img src="<?php echo url('/');?>/images/<?php echo $image[1];?>" alt="<?php echo ($lang == 'es') ? $rs->title: $rs->title_en;?>">

                        @endif

                        <?php echo ($lang == 'es') ? $rs->title: $rs->title_en;?></a>
                  </li>
                  @endforeach
                  <li>
                     @if($lang=='es')
                     <a href="<?php echo url($url_en);?>"><img src="<?php echo url('/');?>/uploads/icons/lang.png" alt=""> Inglés</a>
                     @else
                     <a href="<?php echo url($url_es);?>"><img src="<?php echo url('/');?>/uploads/icons/lang.png" alt=""> Spanish</a>
                     @endif
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <header class="navbar navbar-primary navbar-top box-header hidden-xs" id="sticky-header">
         <div class="container">
         <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6">
               <span id="btn-toogle" class="btn-toogle"></span>
               <a class="navbar-brand bac-header" href="<?php echo ($lang == 'es') ? url('/') : url('en');?>">
               <img src="<?php echo url('/').'/images/'.$site->image_1;?>" alt="<?php echo $site->name?>">
               </a>
            </div>
            <div class="col-md-9 col-sm-9 text-right hidden-xs">
               <ul class="nav navbar-nav navbar-right search-nav">
                  <li>
                     <div class="form-group has-button search-nav">
                        <input type="text" class="form-control input-lg" id="search" placeholder="<?php echo ($lang == 'es') ? '¿Qué estás buscando?' : 'What are you looking for?';?>" >
                        <button class="btn btn-search" id="btn-search">
                        <span class="glyphicon glyphicon-search"></span>
                        </button>
                     </div>
                  </li>
                  <li><a href="#" onclick="hideSearch()"><i class="glyphicon glyphicon-remove"></i></a></li>
               </ul>
               <ul class="nav navbar-nav navbar-right nav-header">
                  <li>
                     <a href="<?php echo ($lang == 'es') ? url('/') : url('en');?>"><?php echo ($lang == 'es') ? 'Inicio' : 'Home';?></a>
                  </li>
                  <?php   $menu=DB::table('menus')->where('status','1')->orderBy('position', 'asc')->get(); ?>
                  @foreach($menu as $rs)
                  <li>
                     <a href="<?php echo url('/')?>/<?php echo ($lang == 'es') ? $rs->url: $rs->url_en;?>" ><?php echo ($lang == 'es') ? $rs->title: $rs->title_en;?></a>
                  </li>
                  @endforeach
                  <li class="expanded dropdown father-menu">
                     <a href="javascript:;" data-toggle="dropdown" title="<?php echo ($lang == 'es') ? 'Idioma' : 'Language';?>" style="font-weight: normal!important;">
                     <?php if($lang=='es'){ ?>
                     <i class="fa fa-globe"></i> Español
                     <?php } else { ?>
                     <i class="fa fa-globe"></i> English
                     <?php } ?>
                     <span class="caret"></span>
                     </a>
                     <ul class="dropdown-menu">
                        <?php if($lang=='es'){ ?>
                        <li><a href="<?php echo url($url_en);?>">Inglés</a></li>
                        <li><a href="<?php echo url($url_es);?>">Español</a></li>
                        <?php } else { ?>
                        <li><a href="<?php echo url($url_es);?>">Spanish</a></li>
                        <li><a href="<?php echo url($url_en);?>">English</a></li>
                        <?php } ?>
                     </ul>
                  </li>
                  <li><a href="#" onclick="showSearch()" style="font-weight: normal!important;"><i class="glyphicon glyphicon-search"></i></a></li>
               </ul>
            </div>
         </div>
      </header>
       <header class="navbar navbar-primary navbar-top hidden-lg hidden-md hidden-sm" id="sticky-header">
         <div class="container">
            <div class="row">
               <div class="col-md-3 col-sm-9 col-xs-10">
                  <a href="javascript:history.back()" class="btn-back"></a>
                  <a class="navbar-brand bac-header" href="<?php echo ($lang == 'es') ? url('/') : url('en');?>">
                  <img src="<?php echo url('/').'/images/'.$site->image_3;?>" alt="<?php echo $site->name?>">
                  </a>
               </div>
               <div class="col-md-3 col-sm-9 col-xs-1 p-lang hidden-lg hidden-md hidden-sm text-right">
                  <a  onclick="showAppSearch()"><i id="btn-q" class="glyphicon glyphicon-search"></i></a>
               </div>
            </div>
            <div class="row search-nav" id="search-nav" style="display: none;">
               <div class="col-md-12">
                  <ul class="nav navbar-nav navbar-right">
                     <li>
                        <div class="form-group has-button">
                           <input type="text" class="form-control input-lg" id="search-mov" placeholder="<?php echo ($lang == 'es') ? '¿Qué estás buscando?' : 'What are you looking for?';?>" >
                           <button class="btn btn-search" id="btn-search-mov">
                           <span class="glyphicon glyphicon-search"></span>
                           </button>
                        </div>
                     </li>
                     
                  </ul>
               </div>
            </div>
         </div>
      </header>
      <!-- HEADER AREA END -->
      <!--  Content -->
      @yield('content')
      <!--end content -->
      <!-- Start footer area -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12 hidden-xs">
                     <img src="<?php echo url('/');?>/images/{{$site->image}}" alt="<?php echo $site->name;?>" class="img-footer1">
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12  no_padding">
                     <ul class="social-network">
                         @if($site->facebook!='')
                        <li><a href="<?php echo $site->facebook;?>" target="_blank"><div class="m-icon facebook"></div></a></li>
                        @endif
                        @if($site->twitter!='')
                        <li><a href="<?php echo $site->twitter;?>" target="_blank"><div class="m-icon twitter"></div></a></li>
                        @endif
                        @if($site->instagram!='')
                        <li><a href="<?php echo $site->instagram;?>" target="_blank"><div class="m-icon instagram"></div></a></li>
                        @endif
                        @if($site->youtube!='')
                        <li><a href="<?php echo $site->youtube;?>" target="_blank"><div class="m-icon youtube"></div></a></li>
                        @endif
                     </ul>
                  </div>
                  <div class="col-md-12 col-sm-12 brd-menu">
                     <div class="row">
                        <div class="col-md-3 col-sm-3 center-movil">
                           <h2><?php echo ($lang == 'es') ? 'Contactanos' : 'Contact us';?></h2>
                           <p onclick="window.open('mailto:<?php echo preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[?¿¡!.,@\s]/s', '', $site->email);?>')" style="cursor: pointer;"><?php echo preg_replace('/[^a-zA-Z0-9á-źÁ-Ź[?¿¡!.,@\s]/s', '', $site->email);?></p>
                        </div>
                        <div class="col-md-3 col-sm-3 hidden-xs">
                           <ul class="menu-footer">
                              <?php   $menu_footer=DB::table('footer')->where('status','1')->offset(0)->limit(2)->orderBy('position', 'asc')->get(); ?>
                              @foreach($menu_footer as $rs)
                              <li>
                                 <a href="<?php echo url('/')?>/<?php echo ($lang == 'es') ? $rs->url: $rs->url_en;?>" ><?php echo ($lang == 'es') ? $rs->title: $rs->title_en;?></a>
                              </li>
                              @endforeach
                           </ul>
                        </div>
                        <div class="col-md-3 col-sm-3 hidden-xs">
                           <ul class="menu-footer">
                              <?php   $menu_footer=DB::table('footer')->where('status','1')->offset(2)->limit(2)->orderBy('position', 'asc')->get(); ?>
                              @foreach($menu_footer as $rs)
                              <li>
                                 <a href="<?php echo url('/')?>/<?php echo ($lang == 'es') ? $rs->url: $rs->url_en;?>" ><?php echo ($lang == 'es') ? $rs->title: $rs->title_en;?></a>
                              </li>
                              @endforeach
                           </ul>
                        </div>
                        <div class="col-md-3 col-sm-3 hidden-xs">
                           <ul class="menu-footer">
                              <?php   $menu_footer=DB::table('footer')->where('status','1')->offset(4)->limit(2)->orderBy('position', 'asc')->get(); ?>
                              @foreach($menu_footer as $rs)
                              <li>
                                 <a href="<?php echo url('/')?>/<?php echo ($lang == 'es') ? $rs->url: $rs->url_en;?>" ><?php echo ($lang == 'es') ? $rs->title: $rs->title_en;?></a>
                              </li>
                              @endforeach
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 col-sm-12 brd-phone">
                     <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6 text-center">
                           @if($site->phone_emergencia!="")
                           <div class="sp-phone" onclick="window.open('tel:<?php echo preg_replace('/[^0-9[.+-_\s]/s', '', $site->phone_emergencia);?>')"><i class="fa fa-phone"></i> <?php echo preg_replace('/[^0-9[.+-_\s]/s', '', $site->phone_emergencia);?></div>
                           <div class="sm-phone sm-phone1" onclick="window.open('tel:<?php echo $site->phone_emergencia;?>')"><?php echo ($lang == 'es') ? 'Emergencias' : 'Emergencies';?></div>
                           @endif
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 text-center">
                           @if($site->phone_same!="")
                           <div class="sp-phone" onclick="window.open('tel:<?php echo preg_replace('/[^0-9[.+-_\s]/s', '', $site->phone_same);?>')"><i class="fa fa-phone"></i> <?php echo preg_replace('/[^0-9[.+-_\s]/s', '', $site->phone_same);?></div>
                           <div class="sm-phone sm-phone2" onclick="window.open('tel:<?php echo $site->phone_same;?>')">SAME</div>
                           @endif
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6 text-center">
                           @if($site->phone_social!="")
                           <div class="sp-phone" onclick="window.open('tel:<?php echo preg_replace('/[^0-9[.+-_\s]/s', '', $site->phone_social);?>')"><i class="fa fa-phone"></i> <?php echo preg_replace('/[^0-9[.+-_\s]/s', '', $site->phone_social);?></div>
                           <div class="sm-phone sm-phone3" onclick="window.open('tel:<?php echo $site->phone_social;?>')"><?php echo ($lang == 'es') ? 'Línea Social' : 'Social Line';?></div>
                           @endif
                        </div>
                        <div class="col-md-3 col-sm-3  col-xs-6 text-center">
                           @if($site->phone_ciudadano!="")
                           <div class="sp-phone" onclick="window.open('tel:<?php echo preg_replace('/[^0-9[.+-_\s]/s', '', $site->phone_ciudadano);?>')"><i class="fa fa-phone"></i> <?php echo preg_replace('/[^0-9[.+-_\s]/s', '', $site->phone_ciudadano);?></div>
                           <div class="sm-phone sm-phone4" onclick="window.open('tel:<?php echo $site->phone_ciudadano;?>')"><?php echo ($lang == 'es') ? 'Atención Ciudadana' : 'Citizen Attention';?></div>
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                     <img src="<?php echo url('/');?>/images/{{$site->image_2}}" alt="Buenas Aires Ciudad" class="logo-ciudad">
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <span id="top-button" class="top-button">
      <i class="glyphicon glyphicon-chevron-up"></i>
      </span>
   </body>
   <input type="hidden" name="url" id="url" value="<?php echo url('/')?>">
   <input type="hidden" id="lang" value="<?php echo $lang?>" name="">
   <input type="hidden" name="csrf_token" value="<?php echo  csrf_token() ?>" id="token">
   <input type="hidden" id="device" value="desktop">
   <!--Alerts-->
   <?php echo Html::script('frontend/js/jquery.growl.js')?>
   <?php echo Html::script('frontend/js/sweetalert-dev.js')?>
   <!--LighBox-->
   <?php echo Html::script('frontend/js/ekko-lightbox.js')?>
   <!--YoutubePayer-->
   <?php echo Html::script('frontend/js/jquery.mb.YTplayer.js')?>
   <!--theme-->
   <?php echo Html::script('frontend/js/aes.js')?>
   <?php echo Html::script('frontend/js/theme.js?v='.time())?>
</html>