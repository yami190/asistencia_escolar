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
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Pagos Caja</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Cedula</label>
                        <input type="text" class="form-control" v-model="cedula" @keyup.enter="buscarCedula(cedula)" maxlength="8">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Nombres</label>
                        <input type="text" v-model="nombres" class="form-control" disabled>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Nomina</label>
                        <input type="text" v-model="nomina" class="form-control" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Deuda</label>
                        <input type="text" v-model="deuda" class="form-control" placeholder="0.00">
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label>Monto a pagar</label>
                        <input type="text" v-model="montoP" class="form-control"  placeholder="0.00">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Referencia Bancaria</label>
                        <input type="text" v-model="referencia" class="form-control" >
                           <p><span style="color:red;"></span> </p> 
                       
                      </div>
                    </div>
            
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-info" @click="GuardarPagos()">Guardar</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Tablas -->
        <div class="callout callout-info">
            <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de Socios</h3>

                <div class="card-tools">
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <template v-if="isLoad">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Nomina</th>
                        <th>pago</th>
                        <th>Deuda</th>
                        <th>Referencia</th>
                        <th>Fecha</th>
                        <th>Estatus</th> 
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="cuotas in array_cuota">
                        <td>{{ cuotas.id_prestamo }}</td>
                        <td>{{ cuotas.cedula }}</td>
                        <td>{{ cuotas.nombres }}</td>
                        <td>{{ cuotas.nomina }}</td>
                        <td>{{ formatPrice(cuotas.montop) }}</td>
                        <td>{{ formatPrice(cuotas.deuda) }}</td>
                        <td>{{  cuotas.referencia }}</td>
                        <td>{{ cuotas.fecha }}</td>
                        <td v-if="cuotas.status">activo</td>
                        <td v-else>inactivo</td>

                      </tr>
                    </tbody>
                  </table>
                </template>
                <template v-else><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></template>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
    </div>

</template>

<script>

    import axios from 'axios'

    
    export default {
        data() {
            return {
                array_cuota: [],
                isLoad: false,
                cedula : '',
                nombres : '',
                nomina : '',
                deuda : '0.00',
                referencia : '',
                montoP : '0.00',
            }
        },
          created: function(){
                this.esperarTiempo();
                this.listarCuotas();
            },
            methods: {
               esperarTiempo() {
                    setTimeout(function () {
                      this.isLoad= true
                    }.bind(this, 3000));

                  },
            listarCuotas (){
                this.isLoad = false
                let me=this;
                var url= 'listar-Pagos';
                axios.get(url).then(response => {
                    
                    var respuesta = response.data;
                    me.array_cuota = respuesta.temp_presta.data;

                    
                  })
                  .catch(function (error) {
                     swal ( "Oops" ,  error.massage ,  "error" )
                  });
             },
             formatPrice(value) {
              let val = (value/1).toFixed(2).replace('.', ',')
              return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            buscarCedula(cedula){
                let me=this;
                var url= 'Estado-Presta?cedula=' + me.cedula;

                axios.get(url).then(function (response){
                  var respuesta = response.data;
                  me.arraysocio = respuesta.socio;


                  if (me.arraysocio.length>0){
                      me.nombres = me.arraysocio[0]['nombres'];
                      me.nomina = me.arraysocio[0]['nomina'];
                  }
                  else{
                    swal ( "Oops" ,  'el socio no se encuentra registrado, ó no posee movimientos este año' ,  "error" )
                    me.nombres='';
                    me.nomina='';
                  }
                })
                .catch(function (error) {
                  swal ( "Oops" ,  error ,  "error" )
                });
            },
            GuardarPagos(){
              var url = 'Guardar-Cuotas';
                axios.post(url, {
                      cedula: this.cedula,
                      deuda: this.deuda,
                      referencia: this.referencia,
                      montoP: this.montoP,
                }).then(response => {
                    this.esperarTiempo();
                    this.listarCuotas();
                      this.cedula='';
                      this.nombres='';
                      this.nomina='';
                      this.deuda='0.00';
                      this.referencia='';
                      this.montoP='0.00';
                     swal({
                        title: "!Mensaje del sistema!",
                        text: "El proceso fue ejecutado con exito!",
                        icon: "success",
                      });
                    }).catch((error) => {
                        let mensaje = error//'Error indefinido';
                            let err=error.response.data.errors;

                            if (err.hasOwnProperty('cedula')) {
                                mensaje  =  err.cedula[0];
                            }else if (err.hasOwnProperty('montoP')) {
                                mensaje  =  err.montoP[0];
                            }
                            else if (err.hasOwnProperty('referencia')) {
                                mensaje  =  err.referencia[0];
                            }else if (err.hasOwnProperty('deuda')) {
                                mensaje  =  err.deuda[0];
                            }
                            swal ( "Oops" ,  mensaje ,  "error" )
                    });
            },
           
         }
    }
</script>
