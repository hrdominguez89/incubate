@extends('layouts.template_frontend')
@section('content')
<?php  $banner = DB::table('banners')->where('id', '5')->first();
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
                        <li><a href="<?php echo $url_tab;?>"><?php echo $tab;?></a></li>
                        <li class="active"><?php echo ($lang == 'es') ? $category->name : $category->name_en ;?></li>
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
                     <li><a href="<?php echo $url_tab;?>"><?php echo $tab;?></a></li>
                     <li class="active"><?php echo ($lang == 'es') ? $category->name : $category->name_en ;?></li>
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
<?php $section = DB::table('sections')->where('id', '19')->first(); ?>
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
               @foreach($categories as $rs)
               <button type="button" class="btn btn-lg @if($rs->id==$category->id) btn-info @else btn-default @endif btn-category" onclick="gotoCategoryMentor('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')"><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></button>
               @endforeach
            </div>
            <div class="col-md-12 hidden-lg hidden-md hidden-sm">
               <br>
               <select class="form-control" onchange="GoMentorsCategory()" id="select-category" >
               @foreach($categories as $rs)
               <option value="<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>" @if($rs->id==$category->id) selected="selected" @endif><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></option>
               @endforeach
               </select>
            </div>
         <div class="col-md-12 pagination-wrapper no-padding hidden-lg hidden-md hidden-sm" ng-show="filteredItems > 0" style="clear: both;">
            <br><br>
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
   <div class="container bg-list" style="display: none; clear: both;">

      <div class="row" ng-show="filteredItems <= 0">
         <div ng-show="filteredItems <= 0" class="col-md-12 noresult text-center">
            <img src="<?php echo url('/');?>/uploads/icons/noresult.png" alt="No hay resultados">
            <p><?php echo ($lang == 'es') ? 'No hay mentores disponible en este momento': 'No mentors available at this time';?></p>
         </div>
      </div>
      <div class="row list-group list-group-content search-list">
         <br>
         <div class="col-md-4 col-sm-4" ng-repeat="row in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit">
            <div class="thumbnail card-chica">
               <img class="img-rounded avatar-u" src="<?php echo url('/');?>/images/@{{row.image}}" alt="@{{row.title}}">
               <div class="post-caption">
                  <h3>@{{row.name}}</h3>
                  <p class="pcc ph44">@{{row.content}}</p>
                  <div class="text-center">
                     <br>
                     <ul class="mini-social" ng-show="row.linkedin!='' || row.instagram!='' ">
                        <li ng-show="row.instagram!=''"><a href="@{{row.instagram}}" target="_blank"><div  class="m-icon instagram"></div></a></li>
                        <li ng-show="row.linkedin!=''"><a href="@{{row.linkedin}}" target="_blank" ><div  class="m-icon linkedin"></div></a></li>
                     </ul>
                     <br>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12 pagination-wrapper no-padding" ng-show="filteredItems > 0" style="clear: both;">
            <ul class="pagination">
               <li  pagination="" page="currentPage" on-select-page="setPage(page)" total-items="filteredItems" items-per-page="entryLimit" class="page-item" previous-text="" next-text=""></li>
            </ul>
         </div>
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
   </div>
</section>
<input type="hidden" name="category" id="category" value="<?php echo $category->id;?>">
<input type="hidden" name="url" id="url" value="<?php echo url('/');?>">
<input type="hidden" name="lang" id="lang" value="<?php echo $lang;?>">
<?php echo Html::script('frontend/js/mentors.js?v='.time())?>
@endif
@stop