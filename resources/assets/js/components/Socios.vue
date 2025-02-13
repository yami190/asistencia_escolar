<template>
    <div class="container">
        <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Control de Expedientes</h3>

                <div class="card-tools">
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button> -->
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
                                    <input type="text" v-model="nombres" class="form-control" >
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
                                    <select class="form-control" v-model="codigo">
                                              <option v-for="nomina in arrayNomina" :key="nomina.id_nomina" :value="nomina.codigo" > {{ nomina.nombre }}</option>
                                    </select>
                                    <!-- <input type="text" v-model="nomina" class="form-control" disabled> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label>Condicion</label>
                               
                                <template >
                                    <select class="form-control" v-model="condicion">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                                </template>
                            </div>
                            </div>
                           
                            <div class="col-sm-2">
                            <div class="form-group">
                                <label>Acción</label>
                                <input type="hidden" v-model="id_socio">
                                <template v-if="id_socio > 0">
                                    <button type="button" class="btn btn-block btn-outline-danger" @click="editarSocio" >EDITAR</button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-block btn-outline-primary" @click="registrarSocio"  >GUARDAR</button>
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
    </div>
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
            codigo : '',
            condicion : '',
            id_socio : '',
            arayarchivosocio: [],
            errorsocio: 0,
            errorMostrarMsjSocio: [],
            arrayNomina : []
            }
        },
          created: function(){
                this.buscarCedula();
                this.selectNomina();
            },
            methods: {
                buscarCedula(cedula){
          let me=this;
          var url= 'buscar-socios?cedula=' + me.cedula;

          axios.get(url).then(function (response){
            var respuesta = response.data;
            me.arayarchivosocio = respuesta.archivosocio;

            if (me.arayarchivosocio.length>0){
                me.cedula = me.arayarchivosocio[0]['cedula'];
                me.nombres = me.arayarchivosocio[0]['nombres'];
                //me.nomina = me.arayarchivosocio[0]['nomina'];
                me.codigo = me.arayarchivosocio[0]['codigo'];
                //me.nombre = me.arayarchivosocio[0]['nombre'];
                me.condicion = me.arayarchivosocio[0]['condicion'];
                me.id_socio = me.arayarchivosocio[0]['id_socio'];
            }
            else{
              if (cedula > 0 ) {
                  swal("Socio No se encuentra registrado");

                  me.nombres='';
                  me.codigo='';
                  me.condicion='';
                  me.id_socio='';
              }
            }
          })
          .catch(function (error) {
            console.log(error);
          });
        },
        selectNomina (){
                let me=this;
                var url= 'selectNomina/nomina';
                axios.get(url).then(response => {
                    //console.log(response);
                    var respuesta = response.data;
                     me.arrayNomina = respuesta.nominas;
                    // me.pagination = respuesta.pagination;
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
            registrarSocio(){
                axios.post('registrar/socio',{
                    'cedula': this.cedula,
                    'nombres': this.nombres,
                    'codigo': this.codigo,
                    'condicion': this.condicion
                }).then(response => {
                    this.cedula='';
                    this.nombres='';
                    this.codigo='';
                    this.condicion='';

                    swal("Buen trabajo", "Los datos han sido guardado con exito", "success");
                }).catch(error => {
                let mensaje = 'Ocurrió un error inesperado';

                if (error.response && error.response.data && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    let errorMessages   
                = [];

                    if (errors.cedula) {
                    errorMessages.push("El campo de cédula está vacío.");
                    }

                    if (errors.nombres) {
                    errorMessages.push("El campo de nombres está vacío.");
                    }

                    mensaje = errorMessages;
                } else {
                    // Si no hay una respuesta de error estructurada, podemos intentar extraer más información del error
                    mensaje = error.message || mensaje;
                }

                swal("Oops", mensaje, "error");
                });
            },

            editarSocio(){
                alert('1');
                axios.put('actualizar/socio',{
                    'cedula': this.cedula,
                    'nombres': this.nombres,
                    'codigo': this.codigo,
                    'condicion': this.condicion
                }).then(response => {
                    this.cedula='';
                    this.nombres='';
                    this.codigo='';
                    this.condicion='';

                    swal("Buen trabajo", "Los datos han sido guardado con exito", "success");
                }).catch(error => {
                let mensaje = 'Ocurrió un error inesperado';

                if (error.response && error.response.data && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    let errorMessages   
                = [];

                    if (errors.cedula) {
                    errorMessages.push("El campo de cédula está vacío.");
                    }

                    if (errors.nombres) {
                    errorMessages.push("El campo de nombres está vacío.");
                    }

                    mensaje = errorMessages;
                } else {
                    // Si no hay una respuesta de error estructurada, podemos intentar extraer más información del error
                    mensaje = error.message || mensaje;
                }

                swal("Oops", mensaje, "error");
                });
            },

            }
    }
</script>
