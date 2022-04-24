@extends('layouts.template_frontend_inside')
@section('content')
<?php 
   function clearArchive($archive){
   
     $value=preg_replace('/[^a-zA-Zá-źÁ-Ź[\s]/s', '', $archive);
     $value = str_replace('pdf', '', $value);
     $value = str_replace('png', '', $value);
     $value = str_replace('jpg', '', $value);
     $value = str_replace('jpeg', '', $value);
     $value = str_replace('doc', '', $value);
     $value = str_replace('docx', '', $value);
     $value = str_replace('-', ' ', $value);
     $value = str_replace('_', ' ', $value);
     $value=ucfirst ($value);
     return $value;
   }
   ?>
<section class="bg-section-2">
   <div class="container">
      <div class="row">
         <div class="col-md-12 hidden-xs">
          <ol class="breadcrumb breadcrumb-single">
            <li><a href="<?php echo ($lang == 'es') ? url('/') : url('en'); ?>"><?php echo ($lang == 'es') ? 'Inicio' : 'Home' ;?></a></li>
                        <li><a href="<?php echo $url_tab;?>"><?php echo $tab;?></a></li>
            <li class="active"><?php echo ($lang == 'es') ? $project->title : $project->title_en ;?></li>
          </ol>
        </div>
         <div  class="col-md-9 col-sm-9">
            
            @if($project->image !="" && strpos($project->image, ',') !== false )
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
               <div class="carousel-inner">
                  @for ($i=1;$i<=substr_count($project->image, ',');$i++)
                  <?php  $image= explode(',',$project->image);  ?>
                  <div class="item @if($i==1) active @endif">
                     <img src="<?php echo url('/');?>/images/<?php echo $image[$i];?>"  alt="<?php echo ($lang == 'es') ? $project->title : $project->title_en ;?>">
                  </div>
                  @endfor
               </div>
               <!-- Controls -->
               <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
               <span class="glyphicon glyphicon-chevron-left"></span>
               </a>
               <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
               <span class="glyphicon glyphicon-chevron-right"></span>
               </a>
            </div>
            @endif
         </div>
         <div  class="col-md-12 col-sm-12">
          
            <div class="title-content">
               <h2>
                  <?php echo ($lang == 'es') ? $project->title : $project->title_en ;?>
               </h2>

               <p><?php echo ($lang == 'es') ? $project->resume : $project->resume_en ;?></p>
               <ul class="mini-social">
                  @if($project->facebook!="")
                  <li><a href="<?php echo $project->facebook;?>" target="_blank"><div class="m-icon facebook"></div></a></li>
                  @endif
                  @if($project->twitter!="")
                  <li><a href="<?php echo $project->twitter;?>" target="_blank"><div class="m-icon twitter"></div></a></li>
                  @endif
                  @if($project->instagram!="")
                  <li><a href="<?php echo $project->instagram;?>" target="_blank"><div class="m-icon instagram"></div></a></li>
                  @endif
                  @if($project->linkedin!="")
                  <li><a href="<?php echo $project->linkedin;?>" target="_blank"><div class="m-icon linkedin"></div></a></li>
                  @endif
                  @if($project->youtube!="")
                  <li><a href="<?php echo $project->youtube;?>" target="_blank"><div class="m-icon youtube"></div></a></li>
                  @endif
                  @if($project->flickr!="")
                  <li><a href="<?php echo $project->flickr;?>" target="_blank"><div class="m-icon flickr"></div></a></li>
                  @endif
               </ul>
               <ul class="items-projects">
                  @if($project->website!="")
                  <li onclick="window.open('<?php echo $project->website;?>')"><i class="fa fa-globe"></i> <?php echo ($lang == 'es') ? 'Sitio Web:':'Web Site:';?> <?php echo $project->website;?></li>
                  @endif
                  @if($project->mentor!="")
                  <li><i class="fa fa-user"></i> <?php echo ($lang == 'es') ? 'Mentor:':'Mentor:';?> <?php echo $project->mentor;?></li>
                  @endif
                  @if($project->email!="")
                  <li><i class="fa fa-envelope-o"></i> <?php echo ($lang == 'es') ? 'Email:':'Email:';?> <?php echo $project->email;?></li>
                  @endif
               </ul>
            </div>
            <div class="p-content">
               <?php echo ($lang == 'es') ? $project->content : $project->content_en ;?>
            </div>
            @if($project->video!="" && strpos($project->video, "=") !== false)
            <div class="video-inner">
               <hr>
               <?php  $video= explode('=',$project->video);  ?>
               <iframe src="https://www.youtube.com/embed/<?php echo $video[1];?>?rel=0&controls=0" allowfullscreen="" style="left:0px" ></iframe>
            </div>
            @endif
         </div>
         <div  class="col-md-6 col-sm-6">
             <?php $archives=DB::table('projects_archives')->where('project',$project->id)->get(); ?>
            @if(count($archives)!=0)
            <div class="p-archive" style="margin-top: 1vw; margin-bottom: 1vw">
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
   <?php $section = DB::table('sections')->where('id', '16')->first(); ?>
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
   <div class="row bg-project hidden-xs">
      <div class="col-md-12 clearfix"></div>
      <?php $projects = DB::table('projects')->where('id','!=',$project->id)->offset(0)->limit(3)->orderBy('id', 'desc')->get(); ?>
      @foreach($projects as $rs)
      @if($rs->image!="" && strpos($rs->image, ',') !== false )
      <div class="col-md-4 col-sm-4 no-padding-p">
         <div class="thumbnail card-chica">
            <?php    $image=explode(",",$rs->image) ?>
            <img class="img-rounded" src="<?php echo url('/');?>/images/<?php echo $image[1];?>" alt="<?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>" onclick="GoToProyecto('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')">
            <div class="post-caption">
               <h3 onclick="GoToProyecto('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')"> <?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?></h3>
               <p class="pcc"> <?php echo ($lang == 'es') ? $rs->resume : $rs->resume_en ;?></p>
               <div class="text-center">
                  <a onclick="GoToProyecto('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')" class="btn  btn-primary"> <?php echo ($lang == 'es') ? 'Leer más' : 'Read more' ;?></a>
               </div>
            </div>
         </div>
      </div>
      @endif
      @endforeach
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