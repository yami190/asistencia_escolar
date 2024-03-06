@include('menu.cabeza')
@include('menu.menu')
<div class="callout callout-info">
    <div class="row">
        <div class="col-sm-4">
          	<div class="custom-file">
          		<input type="file" class="custom-file-input" id="customFile">
          		<label class="custom-file-label" for="customFile">Subir Lista Socios</label>
        	</div>
        </div>
        <div class="col-sm-4">
           <div class="input-group-append">
                      <a href="{{ route('Export.socio.mov.excel')}}" class="btn btn-info btn-flat" >Exportar</a>
                </div>
        </div> 
        <div class="col-sm-4">
	      
          <form action="Impo-mov-socio" method="post" >

	        	<div class="form-group">
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile">Sube tu Excel aqui</label>
                </div>
                <div class="input-group-append">
                      <button type="submit"  class="btn btn-info btn-flat" >Adjuntar</button>
                </div>
              </div>
            </div>
        	</form>
        </div>

    </div>
</div>
@include('menu.pies')