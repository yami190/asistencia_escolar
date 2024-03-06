<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                     <div class="container text-center">

                  <h1>Crear un Efecto Cargando Imagen con Vue JS 2 </h1>
                    

                            <!-- <img v-show="isLoad"  @load="esperarTiempo" class="img-fluid mt-5 mb-5"> -->
            <template v-if="isLoad">
                <table class="table" >
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Cedula</th>
                      <th>Nombre</th>
                      <th>Nomina</th>
                      <th>Prestamo</th>
                      <th>Descuento</th>
                      <th>Cuota</th>
                      <th>tipo</th>
                      <th>Fecha</th>
                      <th>Estatus</th> 
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="preta_temp in arraytemp_presta">
                      <td>{{ preta_temp.id_prestamo }}</td>
                      <td>{{ preta_temp.cedula }}</td>
                      <td>{{ preta_temp.nombres }}</td>
                      <td>{{ preta_temp.nomina }}</td>
                      <td>{{ preta_temp.monto }}</td>
                      <td>{{ preta_temp.descuento }}</td>
                      <td>{{ preta_temp.cuotas }}</td>
                      <td>{{ preta_temp.frecuencia }}</td>
                      <td>{{ preta_temp.fecha_registro }}</td>
                      <td>{{ preta_temp.estatus }}</td>
                    </tr>
                  </tbody>
                </table>


                    </template>
                    <template v-else><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></template>
                  

                      
             
                  
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
                arraytemp_presta: [],
                isLoad: false,
                error:[]
            }
        },
          created: function(){
                this.esperarTiempo();  
                this.cargarImagen()
            },
            methods: {
                cargarImagen() {
                    this.isLoad = false
                  
                    
                let me=this;
                var url= 'listar-presta-temp';
                axios.get(url).then(response => {
                    
                    var respuesta = response.data;
                    me.arraytemp_presta = respuesta.temp_presta.data;
                    console.log(response)
                    
                  })
                  .catch(function (error) {
                    console.log(error);
                   // swal ( "Oops" ,  error.massage ,  "error" )
                  });
                  },
                  esperarTiempo() {
                    setTimeout(function () {
                      this.isLoad= true
                    }.bind(this, 3000));

                  }      
              }
    }
</script>

