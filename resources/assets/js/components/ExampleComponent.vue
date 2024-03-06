<template>
    <div class="container">
        <div class="callout callout-info">
            <div class="row">
                <div class="col-sm-3">
                  <!-- text input -->
                    <div class="input-group input-group-sm">
                      <span class="input-group-append">
                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-lg">Nuevo</button>
                      </span>
                    </div>
                </div> 
                <div class="col-sm-3">
                  <!-- text input -->
                    <div class="input-group input-group-sm">
                      <span class="input-group-append">
                        <button type="button" class="btn btn-info btn-flat" >Procesar</button>
                      </span>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</template>

<script>

    import axios from 'axios'
    
    export default {
        data() {
            return {
                centros: [],
            }
        },
          created: function(){
                this.getCentros();
            },
            methods: {
                getCentros: function(){
                    var urlCentros = 'centro';
                    axios.get(urlCentros).then(response => {
                        this.centros = response.data
                    })
                }
            }
    }
</script>
