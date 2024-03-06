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
                        <button type="button" class="btn btn-info btn-flat" @click="procesar()">Procesar</button>
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
                  <h4 class="modal-title">Prestamos</h4>
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
                        <label>Monto Prestamos</label>
                        <input type="text" v-model="monto" class="form-control">
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label>Cuotas</label>
                        <input type="text" v-model="cuotas" class="form-control"  placeholder="0.00">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Descuento</label>
                        <input type="text" v-model="descuento" class="form-control" disabled>
                           <p><span style="color:red;" v-show="descuento<0">{{ descuento=(monto/cuotas).toFixed(2) }}</span> </p> 
                       
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label>Frecuencia</label>
                        <select class="form-control" v-model="frecuencia">
                          <option value="Quincenal">Quincenal</option>
                          <option value="Mensual">Mensual</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-info" @click="GuardarPrestamos()">Guardar</button>
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
                <h3 class="card-title">Lista de Prestamos 2 Quincena Mes</h3>

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
                        <td>{{ formatPrice(preta_temp.monto) }}</td>
                        <td>{{ formatPrice(preta_temp.descuento) }}</td>
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
                arraytemp_presta: [],
                isLoad: false,
                cedula : '',
                nombres : '',
                nomina : '',
                monto : '',
                descuento : '0.00',
                cuotas : '12',
                frecuencia: 'Quincenal',
            }
        },
          created: function(){
                this.esperarTiempo();
                this.listarPrestatemp();
            },
            methods: {
               esperarTiempo() {
                    setTimeout(function () {
                      this.isLoad= true
                    }.bind(this, 3000));

                  },
            listarPrestatemp (){
                this.isLoad = false
                let me=this;
                var url= 'listar-presta-temp';
                axios.get(url).then(response => {
                    
                    var respuesta = response.data;
                    me.arraytemp_presta = respuesta.temp_presta.data;

                    
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
            GuardarPrestamos(){
              var url = 'presta-temp-socio';
                axios.post(url, {
                      cedula: this.cedula,
                      nombres: this.nombres,
                      monto: this.monto,
                      descuento: this.descuento,
                      cuotas: this.cuotas,
                      frecuencia: this.frecuencia,
                }).then(response => {
                    this.esperarTiempo();
                    this.listarPrestatemp();
                      this.cedula='';
                      this.nombres='',
                      this.nomina= '',
                      this.monto='';
                      this.descuento='0.00';
                      this.cuotas='12';
                      this.frecuencia='Quincenal';
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
                            }else if (err.hasOwnProperty('nombres')) {
                                mensaje  =  err.nombres[0];
                            }else if (err.hasOwnProperty('monto')) {
                                mensaje  =  err.monto[0];
                            }
                            else if (err.hasOwnProperty('cuotas')) {
                                mensaje  =  err.cuotas[0];
                            }else if (err.hasOwnProperty('descuentos')) {
                                mensaje  =  err.descuentos[0];
                            }else if (err.hasOwnProperty('frecuencia')) {
                                mensaje  =  err.frecuencia[0];
                            }
                            swal ( "Oops" ,  mensaje ,  "error" )
                    });
            },
            procesar(){

              swal({
                title: "¿Esta Seguro de procesar la información?",
                text: "Una vez procesada la información no pordra ser revertida",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                 location.href ='Expor-presta-pdf';
                  let me = this;
                    axios.post('procesar-presta',{
                    }).then(function(response){
                       me.listarPrestatemp();
                       me.esperarTiempo();
                    })
                   
                  swal("La información Ha sido procesado con exito", {
                    icon: "success",
                  });
                } else {
                  //swal("Your imaginary file is safe!");
                }
              });
            }
         }
    }
</script>
