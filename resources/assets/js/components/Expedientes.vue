<template>
   <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card collapsed-card">
              <div class="card-header">
                <h3 class="card-title">Control de Expedientes</h3>

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
                                    <input type="text" v-model="cedula" @keyup.enter="buscarCedula(cedula)"  class="form-control is-info" >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nombre y Apellido</label>
                                    <input type="text" v-model="nombres" class="form-control" disabled>
                                    <div v-show="errorsocio" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjSocio" :key="error" v-text="error">
                                            </div>
                                        </div>
                                    </div>
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
                            <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label>Ubicación</label>
                                <template v-if="id_archivo > 0">
                                    <input type="text" v-model="nombre" class="form-control" disabled>
                                </template>
                                <template v-else>
                                    <select class="form-control" v-model="id_personal">
                                    <option value="null">Archivo</option>
                                    <option value="1">Garcia De D. Katiuska</option>
                                    <option value="2">Pantoja De D. Eudis</option>
                                    <option value="3">Perez B. Karla P.</option>
                                    <option value="6">Vallera Flor Susana</option>
                                    <option value="25">Anayibe Rengle</option>
                                    <option value="13">PEREZ JANFRY</option>
                                    <option value="23">Lil Pantoja</option>
                                    <option value="24">Julio Martinez (Chuki)</option>
                                    <option value="20">Fernando Basanta</option>
                                    <option value="26">Johossmel Barreto</option>
                                </select>
                                </template>
                            </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Fecha de Entrega</label>
                                    <input type="date" class="form-control" v-model="fecha_entrega">
                                </div>
                            </div>
                            <div class="col-sm-2">
                            <div class="form-group">
                                <label>Opciones</label>
                                <input type="hidden" v-model="id_archivo">
                                <template v-if="id_archivo > 0">
                                    <button type="button" class="btn btn-block btn-outline-danger" @click="entregado(id_archivo)" >ELIMINAR</button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-block btn-outline-primary" @click="retirarExpedinete">GUARDAR</button>
                                </template>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
              <!-- /.card-body -->
              <div class="card-footer">
                Footer
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
      <div class="card card-primary card-outline container-fluid">
          <div class="card-header">
            <h4 class="card-title">
              <i class="fas fa-edit"></i>
              Lista de expedientes
            </h4>
          </div>
          <div class="card-body">

            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="katiuska" data-toggle="pill" href="#katiuska-tab" role="tab" aria-controls="katiuska-tab" aria-selected="true">KATIUSKA</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="eudis" data-toggle="pill" href="#eudis-tab" role="tab" aria-controls="eudis-tab" aria-selected="false">EUDIS</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="eucar" data-toggle="pill" href="#eucar-tab" role="tab" aria-controls="eucar-tab" aria-selected="false">ANAYIBE</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="karla" data-toggle="pill" href="#karla-tab" role="tab" aria-controls="karla-tab" aria-selected="false">KARLA</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="jhanfri" data-toggle="pill" href="#jhanfri-tab" role="tab" aria-controls="jhanfri-tab" aria-selected="false">JHANFRI</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="susana" data-toggle="pill" href="#susana-tab" role="tab" aria-controls="susana-tab" aria-selected="false">SUSANA</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="daijanis" data-toggle="pill" href="#daijanis-tab" role="tab" aria-controls="susana-tab" aria-selected="false">LIL</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="julio" data-toggle="pill" href="#julio-tab" role="tab" aria-controls="susana-tab" aria-selected="false">JULIO</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="basanta" data-toggle="pill" href="#basanta-tab" role="tab" aria-controls="basanta-tab" aria-selected="false">BASANTA</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="josmel" data-toggle="pill" href="#josmel-tab" role="tab" aria-controls="josmel-tab" aria-selected="false">Johossmel</a>
              </li>
            </ul>
            <div class="tab-content" id="custom-content-below-tabContent">
              <div class="tab-pane fade show active" id="katiuska-tab" role="tabpanel" aria-labelledby="katiuska-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover">
                                    <thead>
                                        <tr>
                                        <th>ID</th>
                                        <th>CEDULA</th>
                                        <th>NOMBRE Y APELLIDO</th>
                                        <th>NOMINA</th>
                                        <th>FECHA</th>
                                        <th>ACCION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="katiuska in arraykatiuska" :key="katiuska.id_archivo">
                                        <td v-text="katiuska.id_archivo"></td>
                                        <td v-text="katiuska.cedula"></td>
                                        <td v-text="katiuska.nombres"></td>
                                        <td v-text="katiuska.nomina"></td>
                                        <td v-text="katiuska.fecha_entrega"></td>
                                        <td><button type="button" class="btn btn-block btn-outline-danger btn-sm" @click="entregado(katiuska.id_archivo)">Eliminar</button></td>
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
              <div class="tab-pane fade" id="eudis-tab" role="tabpanel" aria-labelledby="eudis-tab">
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>CEDULA</th>
                                    <th>NOMBRE Y APELLIDO</th>
                                    <th>NOMINA</th>
                                    <th>FECHA</th>
                                    <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="eudis in arrayeudis" :key="eudis.id_archivo">
                                    <td v-text="eudis.id_archivo"></td>
                                    <td v-text="eudis.cedula"></td>
                                    <td v-text="eudis.nombres"></td>
                                    <td v-text="eudis.nomina"></td>
                                    <td v-text="eudis.fecha_entrega"></td>
                                    <td><button type="button" class="btn btn-block btn-outline-danger btn-sm" @click="entregado(eudis.id_archivo)">Eliminar</button></td>
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
              <div class="tab-pane fade" id="eucar-tab" role="tabpanel" aria-labelledby="eucar-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>CEDULA</th>
                                    <th>NOMBRE Y APELLIDO</th>
                                    <th>NOMINA</th>
                                    <th>FECHA</th>
                                    <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="eucar in arrayeucar" :key="eucar.id_archivo">
                                    <td v-text="eucar.id_archivo"></td>
                                    <td v-text="eucar.cedula"></td>
                                    <td v-text="eucar.nombres"></td>
                                    <td v-text="eucar.nomina"></td>
                                    <td v-text="eucar.fecha_entrega"></td>
                                    <td><button type="button" class="btn btn-block btn-outline-danger btn-sm" @click="entregado(eucar.id_archivo)">Eliminar</button></td>
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
              <div class="tab-pane fade" id="karla-tab" role="tabpanel" aria-labelledby="karla-tab">
                  <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>CEDULA</th>
                                    <th>NOMBRE Y APELLIDO</th>
                                    <th>NOMINA</th>
                                    <th>FECHA</th>
                                    <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="karla in arraykarla" :key="karla.id_archivo">
                                    <td v-text="karla.id_archivo"></td>
                                    <td v-text="karla.cedula"></td>
                                    <td v-text="karla.nombres"></td>
                                    <td v-text="karla.nomina"></td>
                                    <td v-text="karla.fecha_entrega"></td>
                                    <td><button type="button" class="btn btn-block btn-outline-danger btn-sm" @click="entregado(karla.id_archivo)">Eliminar</button></td>
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
              <div class="tab-pane fade" id="jhanfri-tab" role="tabpanel" aria-labelledby="jhanfri-tab">
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>CEDULA</th>
                                    <th>NOMBRE Y APELLIDO</th>
                                    <th>NOMINA</th>
                                    <th>FECHA</th>
                                    <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="jhanfri in arrayjhanfri" :key="jhanfri.id_archivo">
                                    <td v-text="jhanfri.id_archivo"></td>
                                    <td v-text="jhanfri.cedula"></td>
                                    <td v-text="jhanfri.nombres"></td>
                                    <td v-text="jhanfri.nomina"></td>
                                    <td v-text="jhanfri.fecha_entrega"></td>
                                    <td><button type="button" class="btn btn-block btn-outline-danger btn-sm" @click="entregado(jhanfri.id_archivo)">Eliminar</button></td>
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
              <div class="tab-pane fade" id="susana-tab" role="tabpanel" aria-labelledby="susana-tab">
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>CEDULA</th>
                                    <th>NOMBRE Y APELLIDO</th>
                                    <th>NOMINA</th>
                                    <th>FECHA</th>
                                    <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="susana in arraysusana" :key="susana.id_archivo">
                                    <td v-text="susana.id_archivo"></td>
                                    <td v-text="susana.cedula"></td>
                                    <td v-text="susana.nombres"></td>
                                    <td v-text="susana.nomina"></td>
                                    <td v-text="susana.fecha_entrega"></td>
                                    <td><button type="button" class="btn btn-block btn-outline-danger btn-sm" @click="entregado(susana.id_archivo)">Eliminar</button></td>
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
              <div class="tab-pane fade" id="daijanis-tab" role="tabpanel" aria-labelledby="daijanis-tab">
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>CEDULA</th>
                                    <th>NOMBRE Y APELLIDO</th>
                                    <th>NOMINA</th>
                                    <th>FECHA</th>
                                    <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="daijanis in arraydaijanis" :key="daijanis.id_archivo">
                                    <td v-text="daijanis.id_archivo"></td>
                                    <td v-text="daijanis.cedula"></td>
                                    <td v-text="daijanis.nombres"></td>
                                    <td v-text="daijanis.nomina"></td>
                                    <td v-text="daijanis.fecha_entrega"></td>
                                    <td><button type="button" class="btn btn-block btn-outline-danger btn-sm" @click="entregado(daijanis.id_archivo)">Eliminar</button></td>
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
              <div class="tab-pane fade" id="julio-tab" role="tabpanel" aria-labelledby="julio-tab">
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>CEDULA</th>
                                    <th>NOMBRE Y APELLIDO</th>
                                    <th>NOMINA</th>
                                    <th>FECHA</th>
                                    <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="julio in arrayjulio" :key="julio.id_archivo">
                                    <td v-text="julio.id_archivo"></td>
                                    <td v-text="julio.cedula"></td>
                                    <td v-text="julio.nombres"></td>
                                    <td v-text="julio.nomina"></td>
                                    <td v-text="julio.fecha_entrega"></td>
                                    <td><button type="button" class="btn btn-block btn-outline-danger btn-sm" @click="entregado(julio.id_archivo)">Eliminar</button></td>
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
              <div class="tab-pane fade" id="basanta-tab" role="tabpanel" aria-labelledby="basanta-tab">
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>CEDULA</th>
                                    <th>NOMBRE Y APELLIDO</th>
                                    <th>NOMINA</th>
                                    <th>FECHA</th>
                                    <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="basanta in arraybasanta" :key="basanta.id_archivo">
                                    <td v-text="basanta.id_archivo"></td>
                                    <td v-text="basanta.cedula"></td>
                                    <td v-text="basanta.nombres"></td>
                                    <td v-text="basanta.nomina"></td>
                                    <td v-text="basanta.fecha_entrega"></td>
                                    <td><button type="button" class="btn btn-block btn-outline-danger btn-sm" @click="entregado(basanta.id_archivo)">Eliminar</button></td>
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
              <div class="tab-pane fade" id="josmel-tab" role="tabpanel" aria-labelledby="josmel-tab">
                 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>CEDULA</th>
                                    <th>NOMBRE Y APELLIDO</th>
                                    <th>NOMINA</th>
                                    <th>FECHA</th>
                                    <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="josmel in arrayjosmel" :key="josmel.id_archivo">
                                    <td v-text="josmel.id_archivo"></td>
                                    <td v-text="josmel.cedula"></td>
                                    <td v-text="josmel.nombres"></td>
                                    <td v-text="josmel.nomina"></td>
                                    <td v-text="josmel.fecha_entrega"></td>
                                    <td><button type="button" class="btn btn-block btn-outline-danger btn-sm" @click="entregado(josmel.id_archivo)">Eliminar</button></td>
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
            <div class="tab-custom-content">
              <p class="lead mb-0">Fin de la Linea</p>
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
            nombre : '',
            id_archivo : '',
            id_personal : '',
            fecha_entrega : '',
            arraykatiuska: [],
            arrayeudis: [],
            arrayeucar: [],
            arraykarla: [],
            arrayjhanfri: [],
            arraysusana: [],
            arraydaijanis: [],
            arraybasanta: [],
            arrayjosmel: [],
            arrayjulio: [],
            arayarchivosocio: [],
            errorsocio: 0,
            errorMostrarMsjSocio: [],
        }
    },
    created: function(){
        this.listadoexpedientes();
        this.buscarCedula(this.cedula);
    },
    methods: {
        listadoexpedientes (){
            let me=this;
            var url= 'listado-expedientes';
            axios.get(url).then(response => {

                var respuesta = response.data;
                me.arraykatiuska = respuesta.katiuska;
                me.arrayeudis = respuesta.eudis;
                me.arrayeucar = respuesta.eucar;
                me.arraykarla = respuesta.karla;
                me.arrayjhanfri = respuesta.jhanfri;
                me.arraysusana = respuesta.susana;
                me.arraydaijanis = respuesta.daijanis;
                me.arrayjulio = respuesta.julio;
                me.arraybasanta = respuesta.basanta;
                me.arrayjosmel = respuesta.josmel;
                console.log(respuesta);

              })
              .catch(function (error) {
                console.log(error);
              });
         },
        buscarCedula(cedula){
          let me=this;
          var url= 'buscar-expediente?cedula=' + me.cedula;

          axios.get(url).then(function (response){
            var respuesta = response.data;
            me.arayarchivosocio = respuesta.archivosocio;

            if (me.arayarchivosocio.length>0){
                me.cedula = me.arayarchivosocio[0]['cedula'];
                me.nombres = me.arayarchivosocio[0]['nombres'];
                me.nomina = me.arayarchivosocio[0]['nomina'];
                me.nombre = me.arayarchivosocio[0]['nombre'];
                me.fecha_entrega = me.arayarchivosocio[0]['fecha_entrega'];
                me.id_archivo = me.arayarchivosocio[0]['id_archivo'];
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
            console.log(error);
          });
        },
        retirarExpedinete(){
            let me = this;
            axios.post('asignar-expediente',{
                'cedula': this.cedula,
                'id_personal': this.id_personal,
                'fecha_entrega': this.fecha_entrega
            }).then(response => {
                me.listadoexpedientes();
                this.cedula='';
                this.id_personal='';
                this.nomina='';
                this.nombres='';
                this.nombre='';
                this.fecha_entrega='';
                swal("Buen trabajo", "Los datos han sido guardado con exito", "success");
            }).catch((error) => {
                let mensaje = error//'Error indefinido';
                let err=error.response.data.errors;
                if (err.hasOwnProperty('cedula')) {
                    mensaje  =  err.cedula[0];
                // }else if (err.hasOwnProperty('nombres')) {
                //     mensaje  =  err.nombres[0];
                }else if (err.hasOwnProperty('fecha_entrega')) {
                    mensaje  =  err.fecha_entrega[0];
                }
                // else if (err.hasOwnProperty('cuotas')) {
                //     mensaje  =  err.cuotas[0];
                // }else if (err.hasOwnProperty('descuentos')) {
                //     mensaje  =  err.descuentos[0];
                // }else if (err.hasOwnProperty('frecuencia')) {
                //     mensaje  =  err.frecuencia[0];
                // }
                swal ( "Oops" ,  mensaje ,  "error" )
            });
        },
        entregado(id_archivo){
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
                axios.put('desactivar/expediente',{
                    'id_archivo': id_archivo
                }).then(response => {
                    me.listadoexpedientes();
                    this.cedula='';
                    this.id_personal='';
                    this.nomina='';
                    this.nombres='';
                    this.nombre='';
                    this.fecha_entrega='';
                    this.id_archivo='';
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
        }
        },
}
</script>
