@extends('layouts.template_frontend_inside')
@section('content')
<?php 
   function nameMonth($month, $lang) {
     switch ($month) {
       case 1:
       $month = ($lang == 'es') ? 'Enero' : 'January';
       break;
       case 2:
       $month = ($lang == 'es') ? 'Febrero' : 'February';
       break;
       case 3:
       $month = ($lang == 'es') ? 'Marzo' : 'March';
       break;
       case 4:
       $month = ($lang == 'es') ? 'Abril' : 'April';
       break;
       case 5:
       $month = ($lang == 'es') ? 'Mayo' : 'May';
       break;
       case 6:
       $month = ($lang == 'es') ? 'Junio' : 'June';
       break;
       case 7:
       $month = ($lang == 'es') ? 'Julio' : 'July';
       break;
       case 8:
       $month = ($lang == 'es') ? 'Agosto' : 'August';
       break;
       case 9:
       $month = ($lang == 'es') ? 'Septiembre' : 'September';
       break;
       case 10:
       $month = ($lang == 'es') ? 'Octubre' : 'October';
       break;
       case 11:
       $month = ($lang == 'es') ? 'Noviembre' : 'November';
       break;
       case 12:
       $month = ($lang == 'es') ? 'Diciembre' : 'December';
       break;
     }
     return $month;
   }
   
   function nameDay($day, $lang) {
   
           switch ($day) {
               case 0:
               $day = ($lang == 'es') ? 'Domingo' : 'Sunday';
               break;
               case 1:
               $day = ($lang == 'es') ? 'Lunes' : 'Monday';
               break;
               case 2:
               $day = ($lang == 'es') ? 'Martes' : 'Tuesday';
               break;
               case 3:
               $day = ($lang == 'es') ? 'Miércoles' : 'Wednesday';
               break;
               case 4:
               $day = ($lang == 'es') ? 'Jueves' : 'Thursday';
               break;
               case 5:
               $day = ($lang == 'es') ? 'Viernes' : 'Friday';
               break;
               case 6:
               $day = ($lang == 'es') ? 'Sábado' : 'Saturday';
               break;
           }
           return $day;
    }
   
   ?>

<section class="bg-section-2">
   <div class="container">
      <div class="row">
        <div class="col-md-12 hidden-xs">
          <ol class="breadcrumb breadcrumb-single">
            <li><a href="<?php echo ($lang == 'es') ? url('/') : url('en'); ?>"><?php echo ($lang == 'es') ? 'Inicio' : 'Home' ;?></a></li>
            <li><a href="<?php echo $url_tab;?>"><?php echo $tab;?></a></li>
            <li class="active"><?php echo ($lang == 'es') ? $new->title : $new->title_en ;?></li>
          </ol>
        </div>
         <div  class="col-md-8 col-sm-8">
            
            <div class="title-content">
               <h2>
                  <?php echo ($lang == 'es') ? $new->title : $new->title_en ;?>
               </h2>
               <p><?php echo ($lang == 'es') ? $new->resume : $new->resume_en ;?></p>
               <?php 
                  if($lang=='es'){
                  
                    $facebook='http://www.facebook.com/sharer.php?u='.url('/').$_SERVER['REQUEST_URI'];
                    $twitter='https://twitter.com/intent/tweet?text='.$new->title.': '.url('/').$_SERVER['REQUEST_URI'];
                    $whatsapp='https://api.whatsapp.com/send?text='.$new->title.': '.url('/').$_SERVER['REQUEST_URI'];
                    $linkedin='http://www.linkedin.com/shareArticle?url='.url('/').$_SERVER['REQUEST_URI'];
                  
                  
                  }else{
                  
                    $facebook='http://www.facebook.com/sharer.php?u='.url('/').$_SERVER['REQUEST_URI'];
                    $twitter='https://twitter.com/intent/tweet?text='.$new->title_en.': '.url('/').$_SERVER['REQUEST_URI'];
                    $whatsapp='https://api.whatsapp.com/send?text='.$new->title_en.': '.url('/').$_SERVER['REQUEST_URI'];
                     $linkedin='http://www.linkedin.com/shareArticle?url='.url('/').$_SERVER['REQUEST_URI'];
                  
                  
                  }
                  
                  ?>
               <ul class="mini-social">
                  <li><a href="javascript: void(0);" onclick="share('<?php echo $facebook;?>')"><div  class="m-icon facebook"></div></a></li>
                  <li><a href="javascript: void(0);" onclick="share('<?php echo $twitter;?>')"><div  class="m-icon twitter"></div></a></li>
                  <li><a href="javascript: void(0);" onclick="share('<?php echo $whatsapp;?>')"><div  class="m-icon whatsapp"></div></a></li>
                  <li><a href="javascript: void(0);" onclick="share('<?php echo $linkedin;?>')"><div  class="m-icon linkedin"></div></a></li>
               </ul>
               @if($lang=='es')
               <div class="field-items-date">
                  <?php echo nameDay(date("w",strtotime($new->created_at)),$lang).' '.date("d",strtotime($new->created_at)).' de '.nameMonth(date("m",strtotime($new->created_at)),$lang).' del '.date("Y",strtotime($new->created_at)); ?>
               </div>
               @else
               <div class="field-items-date">
                  <?php echo nameMonth(date("m",strtotime($new->created_at)),$lang).' '.date("d",strtotime($new->created_at)).', '.date("Y",strtotime($new->created_at)); ?>
               </div>
               @endif
            </div>
            <div class="p-content">
               <?php echo ($lang == 'es') ? $new->content : $new->content_en ;?>
            </div>
            <?php $archives=DB::table('news_archives')->where('post',$new->id)->get(); ?>
            @if(count($archives)!=0)
            <div class="p-archive hidden-xs" style="margin-top: 1vw; margin-bottom: 1vw">
               <h2><?php echo ($lang == 'es') ? 'Descargas:':'Downloads:';?></h2>
               <div class="table-responsive">
                  <table class="table table-hover">
                     <thead>
                        <tr>
                           <td style="width: 40%"><?php echo ($lang == 'es') ? 'Archivo' : 'Archive' ;?></td>
                           <td style="width: 20%"><?php echo ($lang == 'es') ? 'Tamaño' : 'Size' ;?></td>
                           <td style="width: 40%;text-align: right;"><?php echo ($lang == 'es') ? 'Descargar' : 'To Download' ;?></td>
                        </tr>
                     </thead>
                     <tbody>
                       @foreach($archives as $rs)
                        <tr>
                           <td style="vertical-align: middle;"><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></td>
                           <td style="vertical-align: middle;"><?php echo $rs->file_size;?></td>
                           <td  style="vertical-align: middle; text-align: right;">
                              <a class="btn btn-primary" target="_blank" href="<?php echo url('/');?>/descargar/<?php echo $rs->archive;?>">
                              <i class="fa fa-download" aria-hidden="true">
                              </i></a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
            @endif
         </div>
         <div class="col-md-4 col-sm-4">
            @if($new->image !="" && strpos($new->image, ',') !== false )
            <ul class="new-gallery">
               @for ($i=1;$i<=substr_count($new->image, ',');$i++)
               <?php  $image= explode(',',$new->image);  ?>
               <li>
                  <a href="<?php echo url('/');?>/images/<?php echo $image[$i];?>" data-lightbox="image-1" data-title="<?php echo ($lang == 'es') ? $new->title : $new->title_en ;?>">
                  <img src="<?php echo url('/');?>/images/<?php echo $image[$i];?>"  alt="<?php echo ($lang == 'es') ? $new->title : $new->title_en ;?>" style="cursor: pointer;" class="img-responsive">
                  </a>
               </li>
               @endfor
            </ul>
            @endif
            @if($new->video!="" && strpos($new->video, "=") !== false)
            <div class="video">
               <hr>
               <?php  $video= explode('=',$new->video);  ?>
               <iframe src="https://www.youtube.com/embed/<?php echo $video[1];?>?rel=0&controls=0" allowfullscreen="" style="left:0px" ></iframe>
            </div>
            @endif
            <?php $archives=DB::table('news_archives')->where('post',$new->id)->get(); ?>
            @if(count($archives)!=0)
            <div class="p-archive hidden-lg hidden-md hidden-sm" style="margin-top: 4vw; margin-bottom: 1vw">
               <h2><?php echo ($lang == 'es') ? 'Descargas:':'Downloads:';?></h2>
               <div class="table-responsive">
                  <table class="table table-hover">
                     <thead>
                        <tr>
                           <td style="width: 40%"><?php echo ($lang == 'es') ? 'Archivo' : 'Archive' ;?></td>
                           <td style="width: 20%"><?php echo ($lang == 'es') ? 'Tamaño' : 'Size' ;?></td>
                           <td style="width: 40%;text-align: right;"><?php echo ($lang == 'es') ? 'Descargar' : 'To Download' ;?></td>
                        </tr>
                     </thead>
                     <tbody>
                       @foreach($archives as $rs)
                        <tr>
                           <td style="vertical-align: middle;"><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></td>
                           <td style="vertical-align: middle;"><?php echo $rs->file_size;?></td>
                           <td  style="vertical-align: middle; text-align: right;">
                              <a class="btn btn-primary" target="_blank" href="<?php echo url('/');?>/descargar/<?php echo $rs->archive;?>">
                              <i class="fa fa-download" aria-hidden="true">
                              </i></a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
            @endif
         </div>
      </div>
   </div>
   </div>
   <?php $section = DB::table('sections')->where('id', '15')->first(); ?>
   @if($section->status==1)
   <div class="container hidden-xs">
      <div class="row">
         <div  class="col-md-12 col-sm-12">
            <hr>
            @if($section->status_content==1)
            <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
            @endif
         </div>
      </div>
      <div class="row list-group list-group-content search-list">
         <?php $posts = DB::table('posts')->where('id','!=',$new->id)->offset(0)->limit(4)->orderBy('created_at', 'desc')->get(); ?>
         @foreach($posts as $rs)
         @if($rs->image!="" && strpos($rs->image, ',') !== false )
         <div class="views-row views-row-1 views-row-odd views-row-first col-md-6 col-sm-6  no-image">
            <a  class="list-group-item list-group-new list-thumb" href="javascript:;">
               <?php    $image=explode(",",$rs->image) ?>
               <div class="thmb-img" onclick="GoToPost('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')" style="background-image:url('<?php echo url('/');?>/images/<?php echo $image[1];?>');">
               </div>
               <div class="thmb-content">
                  <h4 onclick="GoToPost('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')">
                     <?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>
                  </h4>
                  <p onclick="GoToPost('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')">
                     <?php echo ($lang == 'es') ? $rs->resume : $rs->resume_en ;?>
                  </p>
                  @if($lang=='es')
                  <p class="list-small"> 
                     <?php echo nameDay(date("w",strtotime($rs->created_at)),$lang).' '.date("d",strtotime($rs->created_at)).' de '.nameMonth(date("m",strtotime($rs->created_at)),$lang).' del '.date("Y",strtotime($rs->created_at)); ?>
                  </p>
                  @else
                  <p class="list-small"> 
                     <?php echo nameMonth(date("m",strtotime($rs->created_at)),$lang).' '.date("d",strtotime($rs->created_at)).', '.date("Y",strtotime($rs->created_at)); ?>
                  </p>
                  @endif
                  @if($rs->categories!="")
                  <p>
                  @for ($i = 1; $i 
                  <= substr_count($rs->categories, ','); $i++)
                  <?php 
                     $category = explode(',', $rs->categories);
                     $get_category=DB::table('categories_post')->where('id', $category[$i])->first(); 
                     ?>
                  @if($lang=='es')
                 
                     <span class="label label-default" onclick="window.location='<?php echo url('/');?>/es/noticias/<?php echo $get_category->url;?>'">
                     <?php echo $get_category->name  ;?>
                     </span> 
                  
                  @else
                  
                     <span class="label label-default" onclick="window.location='<?php echo url('/');?>/es/new/<?php echo $get_category->url_en;?>'">
                     <?php echo $get_category->name_en  ;?>
                     </span> 
                 
                  @endif
                  @endfor
                </p>
                  @endif
               </div>
            </a>
         </div>
         @endif
         @endforeach
      </div>
   </div>
   <div class="container hidden-xs">
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
   @endif
</section>
@stop