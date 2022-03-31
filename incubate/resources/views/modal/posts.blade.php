<div id="docs-modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
      <input type="hidden" name="id" value="" id="id">
      <input type="hidden" name="archive" value="" id="archive">
      <input type="hidden" name="file_size" value="" id="file_size">

      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" ng-click="closeModal()" alt="Close" title="Close">&times;</button>
            <h4 class="modal-title" style="text-transform: uppercase; font-size: 12px"><i class="fa fa-upload" aria-hidden="true"></i>  @{{titulo}}</h4>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="input-field col s12">
                  <label>Nombre en Español<small style="color: #fd2923">*</small></label>
                  {!!Form::text('name',null,['id'=>'name'])!!}
                  <span class="md-input-bar "></span>
               </div>
               <div class="input-field col s12">
                  <label>Nombre en Inglés<small style="color: #fd2923">*</small></label>
                  {!!Form::text('name_en',null,['id'=>'name_en'])!!}
                  <span class="md-input-bar "></span>
               </div>

               <div class="input-field col s12">
                  <p>Máximo 1 archivo</p>
                  <div id="dropzone-doc" class="dropzone" style="    min-height: 140px;"></div>
               </div>
               <div class="input-field col s12">
                  <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
               </div>
               <div class="input-field col s12 text-center" style="clear: both;">
                  <br>
                  <button type="button" class="btn waves-effect waves-light orange" ng-click="guardar()">@{{btn}}</button> 
               </div>
            </div>
         </div>
      </div>
   </div>
</div>