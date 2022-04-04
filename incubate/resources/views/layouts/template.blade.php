
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
      <title>Área Administrativa - IncuBAte</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="theme-color" content="#fdd306"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
      <link rel="shortcut icon" type="image/x-icon" href="<?php echo url('/')?>/uploads/icons/favicon.png">
      <!-- Styles -->
      <?php echo Html::style('backend/css/font-awesome.css')?>
      <?php echo Html::style('backend/css/materialize.min.css')?>
      <?php echo Html::style('backend/css/icons.css')?>
      <?php echo Html::style('backend/css/bootstrap.min.css')?>
      <?php echo Html::style('backend/css/style.css')?>
      <?php echo Html::style('backend/css/responsive.css')?>
      <?php echo Html::style('backend/css/color.css')?>
      <?php echo Html::style('backend/css/jquery.growl.css')?>
      <?php echo Html::style('backend/css/sweetalert.css')?>
      <?php echo Html::style('backend/css/dropzone.css')?>
      <?php echo Html::style('backend/css/bootstrap-select.min.css')?>
      <?php echo Html::style('backend/css/bootstrap-datetimepicker.css')?>
      <!-- Scripts -->
      <?php echo Html::script('backend/js/jquery.min.js')?>
      <?php echo Html::script('backend/js/angular.min.js')?>
      <?php echo Html::script('backend/js/bootstrap.min.js')?>
      <?php echo Html::script('backend/js/ui-bootstrap-tpls.min.js')?>
      <?php echo Html::script('backend/js/materialize.min.js')?>
      <?php echo Html::script('backend/js/moment.min.js')?>
      <?php echo Html::script('backend/js/es.js')?>
      <?php echo Html::script('backend/js/bootstrap-datetimepicker.min.js')?>
      <?php echo Html::script('backend/js/jquery-ui.js')?>
   <body>
    <div id="mask" style="display: none;">
     <div class="loader-p">
       <div class="col-md-12 text-center">
        <i class="fa fa-circle-o-notch fa-spin" style="font-size: 50px;
        color: #fdd306;"></i>
      </div>
    </div>
  </div>
      <div class="topbar">
         <a class="sidemenu-btn" href="#" title=""><i class="ti-menu"></i></a><!-- Sidemenu Button -->
         <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
         <!-- Logo -->
         <!-- Sidemenu Button -->
         <div class="topbar-links">
            <div class="launcher">
              
               <a class="click-btn" href="#" title="">{{Auth::guard('admin')->User()->name}} <i class="fa fa-chevron-down"></i></a>
               <div class="launcher-dropdown z-depth-2">
                <a href="<?php echo url('/')?>" title="" class="launch-btn" target="_blank"><i class="ti-world purple-text"></i> <span>Ver sitio</span></a>
                  <a href="<?php echo url('my-account')?>" title="" class="launch-btn"><i class="ti-user green-text"></i> <span>Mi cuenta</span></a>
                  <a onclick="logout()" title="" class="launch-btn"><i class="ti-lock orange-text"></i> <span>Cerrar sesión</span></a>
               </div>
            </div>
            <!-- Launcher -->
         </div>
             
         <!-- Topbar Links -->
      </div>
      <!-- Top Bar -->
      <div class="sidemenu">
         <div class="sidemenu-inner scroll">
            <!-- Admin -->
            <a href="<?php echo url('dashboard')?>" class="sSidebar_hide sidebar_logo_large ">
            <img class="logo_regular" src="<?php echo url('/')?>/uploads/backend/logo.png" style="    width: 150px;
    float: left;
    margin-left: 10%;" />
            </a>
            <nav class="admin-nav">
               <h6>Área Administrativa</h6>
               <ul>
           
               <li>
                  <a class="waves-effect" href="<?php echo url('dashboard')?>" title="Escritorio"><i class="ti-desktop red lighten-1"></i> Escritorio</a>
               </li>
             
               <!-- /Dashboard-->
               @if (Auth::guard('admin')->User()->level=='1')
               @foreach(DB::table('modules')->get() as $rs)
               <!--module-->
               <li class="waves-effect" title="{{$rs->name}}">
                  <a href="#"><i class="{{$rs->class}}"></i>  {{$rs->name}} </a>
                  <ul>
                     @foreach(DB::table('submodules')->where('id_module','=',$rs->id)->get() as $rs_s)
                     <li><a href="<?php echo url($rs_s->url)?>" title="{{$rs_s->name}}">{{$rs_s->name}}</a></li>
                     @endforeach
                  </ul>
               </li>
               @endforeach
               @else
               @foreach(DB::table('permissions')->where('role','=',Auth::guard('admin')->User()->rol)->where('type','=','1')->where('status','=','1')->get() as $rs)
               <?php $module=DB::table('modules')->where('id','=',$rs->module)->first(); ?>
               <li class="waves-effect" title="{{$module->name}}">
                  <a href="#"><i class="{{$module->class}}"></i> {{$module->name}} </a>
                  <ul>
                     @foreach( DB::table('permissions')->where('role','=',Auth::guard('admin')->User()->rol)->where('module','=',$rs->module)->where('type','=','2')->where('status','=','1')->get()  as $rs_s)
                     <?php $submodule=DB::table('submodules')->where('id','=',$rs_s->submodule)->first(); ?>
                     <li><a href="<?php echo url($submodule->url)?>" title="{{$submodule->name}}">{{$submodule->name}}</a></li>
                     @endforeach
                  </ul>
               </li>
               @endforeach
               @endif 
            </nav>
         </div>
      </div>
      <!-- Sidemenu -->
      <!--=================================
         Content -->
      @yield('content')
      <!--=================================
         Content -->            
      <!--Scripts-->
      <?php echo Html::script('backend/js/enscroll-0.5.2.min.js')?>
      <?php echo Html::script('backend/js/animate-headline.js')?>
      <?php echo Html::script('backend/js/slick.min.js')?>
      <?php echo Html::script('backend/js/impromptu.js')?>
      <?php echo Html::script('backend/js/script.js')?>
      <?php echo Html::script('backend/js/isotope.js')?>
      <?php echo Html::script('backend/js/jquery.growl.js')?>
      <?php echo Html::script('backend/js/dropzone.js')?>
      <?php echo Html::script('backend/js/sweetalert-dev.js')?>
      <?php echo Html::script('backend/js/ckeditor/ckeditor.js')?>
      <input type="hidden" id="id_timer" name="">

      <script type="text/javascript">
        $(window).on("load", function() {
 if ( $("#editor1").length > 0 ) {
          CKEDITOR.replace('editor1', {
            language: 'es',
            toolbar: [
            { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
            { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
            { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
            { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline','Subscript', 'Superscript', '-', 'CopyFormatting' ] },
            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
            { name: 'links', items: [ 'Link', 'Unlink'] },
            { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
            { name: 'styles', items: ['Format', 'Font', 'FontSize' ] },
            { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
            { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
            ]

          });
        }
  
        if ( $("#editor2").length > 0 ) {
          CKEDITOR.replace('editor2', {
            language: 'es',
            toolbar: [
            { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
            { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
            { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
            { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline','Subscript', 'Superscript', '-', 'CopyFormatting' ] },
            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
            { name: 'links', items: [ 'Link', 'Unlink'] },
            { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
            { name: 'styles', items: ['Format', 'Font', 'FontSize' ] },
            { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
            { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
            ]

          });
        }
      });
Dropzone.autoDiscover = false;
$("#dropzone-thumb").dropzone({
  url: "<?php echo url('upload-thumb')?>",
  addRemoveLinks: true,
  maxFileSize: 1000000000000000000,
  dictResponseError: "Ha ocurrido un error en el servidor",
   acceptedFiles: 'image/*,.jpeg,.jpg,.JPEG,.JPG,.PNG,',
     accept: function(file, done) {
     $(".orange").attr("disabled", true);
      done();
   },
  success: function(response, serverFileName) {
    var image = $("#image").val();
    image = image + "," + serverFileName.photo;
    $("#image").val(image);
    $(".orange").removeAttr('disabled');
  },
  error: function(file) {
    $.growl.error({title: "<i class='fa fa-exclamation-circle'></i> Error ",message: "Error subiendo el archivo " + file.name});
  },
  removedfile: function(file, serverFileName) {
    var image = $("#image").val();
    var patron = "," + file.name;
    image = image.replace(patron, '');
    $("#image").val(image);
    $(".orange").removeAttr('disabled');
    var element;
    (element = file.previewElement) != null ?
      element.parentNode.removeChild(file.previewElement) :
      false;
  }
});
$("#dropzone").dropzone({
  url: "<?php echo url('upload-image')?>",
  addRemoveLinks: true,
  maxFileSize: 1000000000000000000,
  dictResponseError: "Ha ocurrido un error en el servidor",
   acceptedFiles: 'image/*,.jpeg,.jpg,.JPEG,.JPG,.PNG,',
   accept: function(file, done) {
     $(".orange").attr("disabled", true);
      done();
   },
  success: function(response, serverFileName) {
    var image = $("#image").val();
    image = image + "," + serverFileName.photo;
    $("#image").val(image);
    $(".orange").removeAttr('disabled');
  },
  error: function(file) {
    $.growl.error({title: "<i class='fa fa-exclamation-circle'></i> Error ",message: "Error subiendo el archivo " + file.name});
  },
  removedfile: function(file, serverFileName) {
    var image = $("#image").val();
    var patron = "," + file.name;
    image = image.replace(patron, '');
    $("#image").val(image);
    $(".orange").removeAttr('disabled');
    var element;
    (element = file.previewElement) != null ?
      element.parentNode.removeChild(file.previewElement) :
      false;
  }
});
$("#dropzone-1").dropzone({
  url: "<?php echo url('upload-image')?>",
  addRemoveLinks: true,
  maxFileSize: 1000000000000000000,
  dictResponseError: "Ha ocurrido un error en el servidor",
   acceptedFiles: 'image/*,.jpeg,.jpg,.JPEG,.JPG,.PNG,',
   accept: function(file, done) {
     $(".orange").attr("disabled", true);
      done();
   },
  success: function(response, serverFileName) {
    var image = $("#image-1").val();
    image = image + "," + serverFileName.photo;
    $("#image-1").val(image);
    $(".orange").removeAttr('disabled');
  },
  error: function(file) {
    $.growl.error({title: "<i class='fa fa-exclamation-circle'></i> Error ",message: "Error subiendo el archivo " + file.name});
  },
  removedfile: function(file, serverFileName) {
    var image = $("#image-1").val();
    var patron = "," + file.name;
    image = image.replace(patron, '');
    $("#image-1").val(image);
    var element;
    $(".orange").removeAttr('disabled');
    (element = file.previewElement) != null ?
      element.parentNode.removeChild(file.previewElement) :
      false;
  }
});
$("#dropzone-2").dropzone({
  url: "<?php echo url('upload-image')?>",
  addRemoveLinks: true,
  maxFileSize: 1000000000000000000,
  dictResponseError: "Ha ocurrido un error en el servidor",
   acceptedFiles: 'image/*,.jpeg,.jpg,.JPEG,.JPG,.PNG,',
     accept: function(file, done) {
     $(".orange").attr("disabled", true);
      done();
   },
  success: function(response, serverFileName) {
    var image = $("#image-2").val();
    image = image + "," + serverFileName.photo;
    $("#image-2").val(image);
    $(".orange").removeAttr('disabled');
  },
  error: function(file) {
    $.growl.error({title: "<i class='fa fa-exclamation-circle'></i> Error ",message: "Error subiendo el archivo " + file.name});
  },
  removedfile: function(file, serverFileName) {
    var image = $("#image-2").val();
    var patron = "," + file.name;
    image = image.replace(patron, '');
    $("#image-2").val(image);
    var element;
    $(".orange").removeAttr('disabled');
    (element = file.previewElement) != null ?
      element.parentNode.removeChild(file.previewElement) :
      false;
  }
});
$("#dropzone-3").dropzone({
  url: "<?php echo url('upload-image')?>",
  addRemoveLinks: true,
  maxFileSize: 1000000000000000000,
  dictResponseError: "Ha ocurrido un error en el servidor",
   acceptedFiles: 'image/*,.jpeg,.jpg,.JPEG,.JPG,.PNG,',
     accept: function(file, done) {
     $(".orange").attr("disabled", true);
      done();
   },
  success: function(response, serverFileName) {
    var image = $("#image-3").val();
    image = image + "," + serverFileName.photo;
    $("#image-3").val(image);
       $(".orange").removeAttr('disabled');
  },
  error: function(file) {
    $.growl.error({title: "<i class='fa fa-exclamation-circle'></i> Error ",message: "Error subiendo el archivo " + file.name});
  },
  removedfile: function(file, serverFileName) {
    var image = $("#image-3").val();
    var patron = "," + file.name;
    image = image.replace(patron, '');
    $("#image-3").val(image);
    var element;
    $(".orange").removeAttr('disabled');
    (element = file.previewElement) != null ?
      element.parentNode.removeChild(file.previewElement) :
      false;
  }
});
$("#dropzone-doc").dropzone({
  url: "<?php echo url('upload-docs')?>",
  addRemoveLinks: true,
  maxFileSize: 345000000000,
  dictResponseError: "Ha ocurrido un error en el servidor",
  acceptedFiles: 'image/*,.jpeg,.JPEG,.JPG,.PNG,.GIF,application/pdf,.psd,.doc,.docx',
  maxFiles: 1,
  maxfilesexceeded: function(file) {
    this.removeAllFiles();
    this.addFile(file);
  },
     accept: function(file, done) {
     $(".orange").attr("disabled", true);
      done();
   },
  success: function(response, serverFileName) {
    $("#archive").val(serverFileName.photo);
    $("#file_size").val(serverFileName.file_size);
       $(".orange").removeAttr('disabled');
  },
  error: function(file) {
    $.growl.error({title: "<i class='fa fa-exclamation-circle'></i> Error ",message: "Error subiendo el archivo " + file.name});
  },
  removedfile: function(file, serverFileName) {
    $("#archive").val('');
    $("#file_size").val('');
    var element;
    $(".orange").removeAttr('disabled');
    (element = file.previewElement) != null ?
    element.parentNode.removeChild(file.previewElement) :
    false;
  }
});


function confirmarCierre() {
  var cerrar = setTimeout(cerrarSesion, 10000); //5 segs de prueba
  swal({
    title: "Confirmá que querés cerrar sesión",
    text: "Su sesión expiró, presione cancelar para extender la sesión ",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#fd2923',
    confirmButtonText: "Si, Cerrar sesión",
    cancelButtonText: "Cancelar",
    closeOnConfirm: false,
    closeOnCancel: false
  }, function(isConfirm) {
    if (isConfirm) {
      cerrarSesion();
    } else {
      swal.close();
      //si presiona OK
      clearTimeout(cerrar); //elimino el tiempo a la funcion cerrarSesion
      clearTimeout(temp); //elimino el tiempo a la funcion confirmarCierre
      temp = setTimeout(confirmarCierre, 900000); //y aca le doy un nuevo tiempo a la funcion confirmarCierre (5 segs)
    }
  });
}

function cerrarSesion() {
  var stateObj = {
    foo: "cms"
  };
  history.pushState(stateObj, "Área Administrativa", "cms")
  window.location = '<?php echo url("/");?>/logout';
}
// se llamará a la función que confirmar Cierre después de 10 segundos
var temp = setTimeout(confirmarCierre, 900000);
// cuando se detecte actividad en cualquier parte de la app
$(document).on('click keyup keypress keydown blur change', function(e) {
  // borrar el temporizador de la funcion confirmarCierre
  clearTimeout(temp);
  // y volver a iniciarlo con 10segs
  temp = setTimeout(confirmarCierre, 900000);
});
         
         @foreach($errors->all() as $error)
         $.growl.error({title: "<i class='fa fa-exclamation-circle'></i> Error ",message: "<?php echo $error; ?>"});
         @endforeach
         
          @if(Session::has('notice'))
         $.growl.notice({title: "<i class='fa fa-exclamation-circle'></i> Atención",message: "Registro exitoso"});
         @endif
         @if(Session::has('warning'))
         $.growl.warning({title: "<i class='fa fa-exclamation-circle'></i> Atención",message: "Datos actualizados"});
         @endif
         @if(Session::has('submit'))
         $.growl.warning({title: "<i class='fa fa-exclamation-circle'></i> Atención",message: "Su respuesta ha sido enviada"});
         @endif
         @if(Session::has('error'))
         $.growl.error({title: "<i class='fa fa-exclamation-circle'></i> Error ",message: "Registro eliminado"});
         @endif
         @if(Session::has('already'))
         $.growl.error({title: "<i class='fa fa-exclamation-circle'></i> Atención",message: "Registration already exists"});
         @endif

         @if(Session::has('no-results'))

         swal({
                     type: "warning",
                     title: 'Opps!',
                     text: "No se encontraron resultados en el rango de fechas seleccionado",
                     confirmButtonColor: '#00B9f1',
                     cancelButtonColor: '#00B9f1',
                     cancelButtonText: "Volver",
                  },
                  function() {
                     location.reload();
                  });

         @endif


         function logout(){


          <?php 

          $url=env('OID_AUTH') . '?client_id=' . env('OID_CLIENT_ID') . '&redirect_uri=' . env('APP_URL') . '/verifylogin&response_type=code&state=1';

          ?>


          $("#send-logout").html('<form id="logs" action="<?php echo $url;?>" method="post">\
           <input type="hidden" name="authorize" value="0">\
           <input type="hidden" name="logout" value="1">\
         </form>');

          $("#logs").submit();
         }
         
         
      </script>


       <div id="send-logout"></div>

   </body>
</html>