@extends('layouts.template_frontend')
@section('content')
<?php  $banner = DB::table('banners')->where('id', '2')->first();
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
<?php $section = DB::table('sections')->where('id', '5')->first(); ?>
@if($section->status==1)
<section class="bg-section" ng-app="myApp" ng-controller="post">
      <div class="container">
         <div class="row">
            @if($section->status_content==1)
            <div  class="col-md-12">
               <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
               @if($section->content!="" && $lang=='es')
               <?php echo $section->content;?>
               @endif
               @if($section->content_en!="" && $lang=='en')
               <?php echo $section->content_en;?>
               @endif
            </div>
            @endif
            <div  class="col-md-12 hidden-xs">
               <br>
               <?php $i=0; ?>
               @foreach($categories as $rs)
               <?php $i=$i+1; ?>
               <?php if($i==1){ $id_category=$rs->id; } ?>
               <button type="button" class="btn btn-lg @if($i==1) btn-info @else btn-default @endif btn-category" onclick="gotoCategoryProject('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')"><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></button>
               @endforeach
            </div>
            <div class="col-md-12 hidden-lg hidden-md hidden-sm">
               <br>
               <select class="form-control" onchange="GoProjectsCategory()" id="select-category" >
               <?php $i=0; ?>
               @foreach($categories as $rs)
               <?php $i=$i+1; ?>
               <?php if($i==1){ $id_category=$rs->id; } ?>
               <option value="<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>" @if($i==1) selected="selected" @endif><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></option>
               @endforeach
               </select>
            </div>
            <div class="col-md-12 pagination-wrapper no-padding hidden-lg hidden-md hidden-sm" ng-show="filteredItems > 0" style="clear: both;">
               <br>
            </div>
         </div>
      </div>
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
      <div class="container mtop2 bg-list" style="display: none;">
         <div class="row">
            <div ng-show="filteredItems <= 0" class="col-md-12 noresult text-center">
               <img src="<?php echo url('/');?>/uploads/icons/noresult.png" alt="No hay resultados">
               <p><?php echo ($lang == 'es') ? 'No hay proyectos disponible en este momento': 'No proyects available at this time';?></p>
            </div>
         </div>
         <div class="row bg-project" ng-show="filteredItems > 0">
            <div class="col-md-12 clearfix"></div>
            <div class="col-md-4 col-sm-4 no-padding-p" ng-repeat="row in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit">
               <div class="thumbnail card-chica" ng-click="goToProjects(row.url)">
                  <img class="img-rounded" src="<?php echo url('/');?>/images/@{{row.image}}" alt="@{{row.title}}">
                  <div class="post-caption">
                     <h3>@{{row.title}}</h3>
                     <p class="pcc">@{{row.copy}}</p>
                     <div class="text-center">
                        <a ng-click="goToProjects(row.url)" class="btn  btn-primary"> <?php echo ($lang == 'es') ? 'Leer más' : 'Read more' ;?></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="row">
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
   </div>
   
</section>
@endif
<?php $section = DB::table('sections')->where('id', '6')->first(); ?>
@if($section->status==1)
<section class="bg-section hidden-xs">
   @if($section->status_content==1)
   <div class="container">
      <div class="row">
         <div  class="col-md-12">
            <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
         </div>
      </div>
   </div>
   @endif
   <div class="container">
      <div class="row">
         <div  class="col-md-4 col-sm-4 ">
            <nav>
               <ul class="page-sidebar">
                  @foreach($documents as $rs)
                  @if($rs->archive!="")
                  <?php    $archive=explode(",",$rs->archive) ?>
                  @endif
                  <li ><a data-toggle="tab"  target="_blank" @if($rs->type='1' && $rs->archive!="" ) onclick="descargar('<?php echo $archive[1];?>','1')"  @else onclick="descargar('<?php echo $rs->video;?>','2')" @endif>
                     <?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>
                     </a>
                  </li>
                  @endforeach
               </ul>
            </nav>
         </div>
         <div  class="col-md-8  col-sm-8">
            @if($section->status_content==1)
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
            @endif
         </div>
      </div>
   </div>
   <div class="container">
      <div class="row">
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
<section class="bg-section-3 hidden-lg hidden-md hidden-sm">
   <div class="container">
      @if($section->status_content==1)
      <div class="row">
         <div  class="col-md-12">
            <h2 onclick="showSection()"><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?> <i class="glyphicon glyphicon-chevron-down"  id="angle"></i></h2>
         </div>
      </div>
      @endif
   </div>
   <div class="container" id="desplegable" style="display: none;">
      @if($section->status_content==1)
      <div class="row">
         <div  class="col-md-12">
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
         </div>
      </div>
      @endif
      <div class="row">
         <div  class="col-md-12">
            <nav>
               <ul class="page-sidebar">
                  @foreach($documents as $rs)
                  @if($rs->archive!="")
                  <?php    $archive=explode(",",$rs->archive) ?>
                  @endif
                  <li ><a data-toggle="tab"  target="_blank" @if($rs->type='1' && $rs->archive!="" ) onclick="descargar('<?php echo $archive[1];?>','1')"  @else onclick="descargar('<?php echo $rs->video;?>','2')" @endif>
                     <?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>
                     </a>
                  </li>
                  @endforeach
               </ul>
            </nav>
         </div>
      </div>
   </div>
   <div class="container">
      <div class="row">
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
<?php $section = DB::table('sections')->where('id', '9')->first(); ?>
@if($section->status==1)
<section class="bg-section">
   <div class="container">
      <div class="row">
         @if($section->status_content==1)
         <div  class="col-md-12">

            <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
         </div>
         @endif
      </div>
   </div>
   <div class="container mtop2">
      <div class="row">
         @if(count($faqs)==0)

         <div  class="col-md-12 noresult text-center">
            <img src="<?php echo url('/');?>/uploads/icons/noresult.png" alt="No hay resultados">
            <p><?php echo ($lang == 'es') ? 'No hay preguntas frecuentes disponible en este momento': 'No FAQs available at this time';?></p>
         </div>
   
         @else
         <div class="col-md-4 col-sm-4 clearfix hidden-xs" >
            <nav>
               <ul class="page-sidebar" style="width: 100%">
                  <?php $i=0; ?>
                  @foreach($faqs as $rs)
                  <?php $i=$i+1; ?>
                  <li @if($i==1) class="active" @endif><a data-toggle="tab" href="#<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>"><?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?></a></li>
                  @endforeach
               </ul>
            </nav>
         </div>

         <div class="col-md-12 clearfix hidden-lg hidden-md hidden-sm" >
            <select class="form-control" onchange="ShowTabs()" id="category" >
               @foreach($faqs as $rs)
               <option value="<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>"><?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?></option>
               @endforeach
            </select>
         </div>
         <div class="col-md-8  col-sm-8 col-xs-12">
            <div class="tab-content">
               <?php $i=0; ?>
               @foreach($faqs as $rs)
               <?php $i=$i+1; ?>
               <div id="<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>" class="tab-pane fade @if($i==1) in active @endif">
                  <div class="row">
                     <div class="col-md-12 col-sm-12">
                        <h3><?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?></h3>
                        <?php echo ($lang == 'es') ? $rs->content : $rs->content_en ;?>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
         @endif
      </div>
   </div>
   <div class="container">
      <div class="row">
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
<input type="hidden" name="category" id="project_category" value="<?php echo $id_category;?>">
<input type="hidden" name="url" id="url" value="<?php echo url('/');?>">
<input type="hidden" name="lang" id="lang" value="<?php echo $lang;?>">
<?php echo Html::script('frontend/js/projects.js?v='.time())?>
<?php echo Html::script('frontend/js/faq.js?v='.time())?>
@stop