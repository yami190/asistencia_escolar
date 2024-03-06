<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Control de Socios</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" >
                                <div class="row">
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Cedula</label>
                                            <input type="text" v-model="cedula" @keyup.enter="buscarCedula(cedula)"  class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Nombre y Apellido</label>
                                            <input type="text" v-model="nombres"  class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Nomina</label>
                                            <input type="text" v-model="nomina" class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Monto</label>
                                            <template v-if="id_liquidacion >= 1">
                                            <input type="text" class="form-control" v-model="monto" placeholder="0.00" disabled>
                                            </template>
                                            <template v-else>
                                                <input type="text" class="form-control" v-model="monto" placeholder="0.00" >
                                            </template>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Observacion</label>
                                            <template v-if="id_liquidacion >= 1">
                                                <input type="text" class="form-control" v-model="observacion" disabled>
                                            </template>
                                            <template v-else>
                                                <input type="text" class="form-control" v-model="observacion" >
                                            </template>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Fecha de Liquidacion</label>
                                            <template v-if="id_liquidacion >= 1">
                                                <input type="date" class="form-control" v-model="fecha_liquidacion" disabled>
                                            </template>
                                            <template v-else>
                                                <input type="date" class="form-control" v-model="fecha_liquidacion" >
                                            </template>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                    <template v-if="id_liquidacion >= 1">
                                        <div class="form-group">
                                            <label>Estatus</label>
                                            <input type="text" v-model="estatus" class="form-control is-invalid" id="inputError" disabled>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="form-group">
                                            <label>Tipo de Salida</label>
                                            <select class="form-control select2" style="width: 100%;" v-model="estatus">
                                                <option value="">SELECCIONE..</option>
                                                <option value="LIQUIDACION">LIQUIDACION</option>
                                                <option value="FALLECIDO">FALLECIDO</option>
                                                <option value="JUBILADOS">JUBILADOS</option>
                                            </select>
                                        </div>
                                    </template>
                                    </div>
                                    <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Opciones</label>
                                        <template v-if="id_liquidacion >= 1">
                                            <button type="button" class="btn btn-block btn-outline-danger" @click="liquidar(id_liquidacion)" >ELIMINAR</button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-block btn-outline-primary" @click="liquidarsocio" >GUARDAR</button>
                                        </template>
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-primary card-outline container-fluid">
            <div class="card-header">
                <h4 class="card-title">
                  <i class="fas fa-edit"></i>
                  Listados
                </h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="liquitotal" data-toggle="pill" href="#liquitotal-tab" role="tab" aria-controls="liquitotal-tab" aria-selected="true">Liquidaciones totales</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="falleliqui" data-toggle="pill" href="#falleliqui-tab" role="tab" aria-controls="falleliqui-tab" aria-selected="false">Fallecidos Totales</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="jubiliqui" data-toggle="pill" href="#jubiliqui-tab" role="tab" aria-controls="jubiliqui-tab" aria-selected="false">Jubilados Totales</a>
                  </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="liquitotal-tab" role="tabpanel" aria-labelledby="liquitotal-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                <th>CEDULA</th>
                                                <th>NOMBRE Y APELLIDO</th>
                                                <th>NOMINA</th>
                                                <th>MONTO</th>
                                                <th>OBSERVACIÓN</th>
                                                <th>FECHA</th>
                                                <th>ACCION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="liqutotal in arrayliquidacionestotales" :key="liqutotal.id_archivo">
                                                <td v-text="liqutotal.cedula"></td>
                                                <td v-text="liqutotal.nombres"></td>
                                                <td v-text="liqutotal.nomina"></td>
                                                <td v-text="liqutotal.monto"></td>
                                                <td v-text="liqutotal.observacion"></td>
                                                <td v-text="liqutotal.fecha_liquidacion"></td>
                                                <td><button type="button" class="btn btn-block btn-outline-danger btn-sm" @click="liquidar(liqutotal.id_liquidacion)">Eliminar</button></td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    <!-- /.card-body -->
                                    </div>
                                <!-- /.card -->
                                </div>
                            </div>
                    </div>
                    <div class="tab-pane fade" id="falleliqui-tab" role="tabpanel" aria-labelledby="falleliqui-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th>CEDULA</th>
                                            <th>NOMBRE Y APELLIDO</th>
                                            <th>NOMINA</th>
                                            <th>MONTO</th>
                                            <th>OBSERVACION</th>
                                            <th>FECHA</th>
                                            <th>ACCION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="fallecidos in arrayfallecidos" :key="fallecidos.id_liquidacion">
                                            <td v-text="fallecidos.cedula"></td>
                                            <td v-text="fallecidos.nombres"></td>
                                            <td v-text="fallecidos.nomina"></td>
                                            <td v-text="fallecidos.monto"></td>
                                            <td v-text="fallecidos.observacion"></td>
                                            <td v-text="fallecidos.fecha_liquidacion"></td>
                                            <td><button type="button" class="btn btn-block btn-outline-danger btn-sm" @click="liquidar(fallecidos.id_liquidacion)">Eliminar</button></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                        <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="jubiliqui-tab" role="tabpanel" aria-labelledby="jubiliqui-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th>CEDULA</th>
                                            <th>NOMBRE Y APELLIDO</th>
                                            <th>NOMINA</th>
                                            <th>MONTO</th>
                                            <th>OBSERVACIÓN</th>
                                            <th>FECHA</th>
                                            <th>ACCION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                            <tr v-for="jubilados in arrayjubilados" :key="jubilados.id_liquidacion">
                                            <td v-text="jubilados.cedula"></td>
                                            <td v-text="jubilados.nombres"></td>
                                            <td v-text="jubilados.nomina"></td>
                                            <td v-text="jubilados.monto"></td>
                                            <td v-text="jubilados.observacion"></td>
                                            <td v-text="jubilados.fecha_liquidacion"></td>
                                            <td><button type="button" class="btn btn-block btn-outline-danger btn-sm" @click="liquidar(jubilados.id_liquidacion)">Eliminar</button></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                        <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </section>
</template>

<script>
import axios from 'axios' 
export default {
    data() {
        return {
            cedula : '',
            nombres : '',
            nomina : '',
            monto : '',
            fecha_liquidacion : '',
            observacion : '',
            estatus : '',
            id_liquidacion : '',
            arrayliquidacion:[],
            arrayfallecidos:[],
            arrayliquidacionestotales:[],
            arrayjubilados:[]
        }
    },
    created: function(){
        this.liquidaciones();
        this.buscarCedula(this.cedula);
        },
    methods: {
        liquidaciones(){
            let me=this;
            var url= 'listado-liquidaciones';
            axios.get(url).then(response => {
                var respuesta = response.data;
                me.arrayliquidacionestotales = respuesta.liquidacionestotales;
                me.arrayfallecidos = respuesta.fallecidostotales;
                me.arrayjubilados = respuesta.jubiladostotales;
                //  console.log(respuesta);
              })
              .catch(function (error) {
                console.log(error);
              });
        },
        liquidarsocio(){
            let me = this;
            axios.post('liquidar-socio',{
                'cedula': this.cedula,
                'fecha_liquidacion': this.fecha_liquidacion,
                'monto': this.monto,
                'estatus': this.estatus
            }).then(response => {
                me.liquidaciones();
                this.cedula='';
                this.fecha_liquidacion='';
                this.nomina='';
                this.nombres='';
                this.monto='';
                this.estatus='';
                swal("Buen trabajo", "Los datos han sido guardado con exito", "success");
            }).catch((error) => {
                let mensaje = error//'Error indefinido';
                let err=error.response.data.errors;
                if (err.hasOwnProperty('cedula')) {
                    mensaje  =  err.cedula[0];
                }else if (err.hasOwnProperty('monto')) {
                    mensaje  =  err.monto[0];
                }else if (err.hasOwnProperty('fecha_liquidacion')) {
                    mensaje  =  err.fecha_liquidacion[0];
                }else if (err.hasOwnProperty('estatus')) {
                    mensaje  =  err.estatus[0];
                }
                swal ( "Oops" ,  mensaje ,  "error" )
            });
        },
        buscarCedula(cedula){
          let me=this;
          var url= 'buscar-socio?cedula=' + me.cedula;

          axios.get(url).then(function (response){
            var respuesta = response.data;
            me.arrayliquidacion = respuesta.liquidacion;

            if (me.arrayliquidacion.length>0){
                me.cedula = me.arrayliquidacion[0]['cedula'];
                me.nombres = me.arrayliquidacion[0]['nombres'];
                me.nomina = me.arrayliquidacion[0]['nomina'];
                me.monto = me.arrayliquidacion[0]['monto'];
                me.estatus = me.arrayliquidacion[0]['estatus'];
                me.observacion = me.arrayliquidacion[0]['observacion'];
                me.fecha_liquidacion = me.arrayliquidacion[0]['fecha_liquidacion'];
                me.id_liquidacion = me.arrayliquidacion[0]['id_liquidacion'];
            }
            else{
                if (cedula > 0 ) {
                  swal("Socio No se encuentra registrado");
                  me.nombres='';
                  me.nomina='';
                }
            }
          })
          .catch(function (error) {
            //console.log(error);
          });
        },
        liquidar(id_liquidacion){
            swal({
            title: "¿Esta Seguro de procesar la información?",
            text: "Una vez procesada la información no pordra ser revertida",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                let me = this;
                axios.put('eliminar/liquidacion',{
                    'id_liquidacion': id_liquidacion
                }).then(response => {
                    me.liquidaciones();
                    this.cedula='';
                    this.fecha_liquidacion='';
                    this.nomina='';
                    this.nombres='';
                    this.monto='';
                    this.estatus='';
                    this.id_liquidacion='';
                }).catch(function (error) {
                    console.log(error);
                });
              swal("La información Ha sido procesado con exito", {
                icon: "success",
              });
            } else {
              //swal("Your imaginary file is safe!");
            }
          });
        },
    },
}
</script>
