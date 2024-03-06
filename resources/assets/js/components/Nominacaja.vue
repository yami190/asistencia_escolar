<template>
     <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Personal de la Caja de Ahorro del Estado Bolivar 
                         <button type="button" class="btn btn-secondary" @click="abrirModal('nomina','registrar')">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="cedula">Cedula</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarNomina(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarNomina(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div> 
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Cedula</th>
                                    <th>Nombres y Apellidos</th>
                                    <th>Cargo</th>
                                    <th>Fecha de Ingreso</th>
                                    <th>Tipo de Nomina</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="nomina in personal_caja" :key="nomina.id_personal">
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('nomina','actualizar', nomina)">
                                          <i class="icon-pencil"></i>
                                        </button>&nbsp;
                                        <template v-if="nomina.condicion">
                                            <button type="button" class="btn btn-success btn-sn" @click="desactivarNomina(nomina.id_personal)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-danger btn-sn" @click="activarNomina(nomina.id_personal)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="nomina.cedula"></td>
                                    <td v-text="nomina.nombre"></td>
                                    <td v-text="nomina.cargo"></td>
                                    <td v-text="nomina.fecha_ingreso"></td>
                                    <td>
                                        <div v-if="nomina.tipo_nomina === 1">
                                            Caja de Ahorro
                                        </div>
                                        <div v-else-if="nomina.tipo_nomina === 2">
                                           Consultor
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="nomina.condicion">
                                            <span class="icon-check badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent = "cambiarPagina(pagination.current_page - 1,buscar,criterio )">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#"  @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item"v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" :class="{'mostrar' : modal}"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                  <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Cedula de Trabajador</label>
                                    <div class="col-md-9">
                                        <input type="text" id="cedula" v-model="cedula" class="form-control" placeholder="Cedula del Trabajador">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombres y apellidos</label>
                                    <div class="col-md-9">
                                        <input type="text" id="nombre" v-model="nombre" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="fecha_ingreso-input">Fecha de Ingreso</label>
                                    <div class="col-md-9">
                                         <input type="date" id="fecha_ingreso" v-model="fecha_ingreso" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="cargo-input">Cargo</label>
                                    <div class="col-md-9">
                                         <input type="text" id="cargo" v-model="cargo" class="form-control" >
                                    </div>
                                </div>
                                <div v-show="errorNomina" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjNomina" :key="error" v-text="error">
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"  @click="cerrarModal">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarNomina">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarNomina" >Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            
        </main>
</template>

<script>
    export default {
            data (){
                return{
                    nomina_id: 0,
                    cedula : '',
                    nombre : '',
                    cargo : '',
                    fecha_ingreso : '',
                    personal_caja : [],
                    modal : 0,
                    tituloModal : '',
                    tipoAccion: 0,
                    errorNomina: 0,
                    errorMostrarMsjNomina: [],
                    pagination: {
                        'total' : 0,
                        'current_page' : 0,
                        'per_page' : 0,
                        'last_page' : 0,
                        'from' : 0,
                        'to' : 0,
                    },
                    offset : 10,
                    criterio : 'nombre',
                    buscar : ''
                }
            },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la pagination
            pagesNumber: function() {
                if(!this.pagination.to){
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1){
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods:{
            listarNomina (page,buscar,criterio){
                let me=this;
                var url= 'lista-nominacaja?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(response => {
                    //console.log(response);
                    var respuesta = response.data;
                    me.personal_caja = respuesta.personal_caja.data;
                    me.pagination = respuesta.pagination;
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },

            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la Pagina Actual
                me.pagination.current_page = page; 
                //Enviar la peticion para visualizar la data de esa pagina 
                me.listarNomina(page,buscar,criterio);
            },

            registrarNomina(){
                if(this.validarNomina()){
                    return
                }

                let me = this;
                axios.post('guardar-nominacaja',{
                    'cedula': this.cedula,
                    'nombre': this.nombre,
                    'cargo': this.cargo,
                    'fecha_ingreso': this.fecha_ingreso
                }).then(response => {
                    me.cerrarModal();
                    alertify.confirm("This is a confirm dialog.",
                      function(){
                        alertify.success('Ok');
                      },
                      function(){
                        alertify.error('Cancel');
                      });
                    me.listarNomina(1, '', 'nombre');
                }).catch(function (error){
                    console.log(error);
                });
            },

            actualizarNomina(){
                if(this.validarNomina()){
                    return
                }

                let me = this;
                axios.put('actualizar/nomina',{
                    'cedula': this.cedula,
                    'nombre': this.nombre,
                    'fecha_ingreso': this.fecha_ingreso,
                    'id_personal': this.id_personal
                }).then(response => {
                    me.cerrarModal();
                    me.listarNomina(1, '', 'nombre');
                }).catch(function (error){
                    console.log(error);
                });
            },

            desactivarNomina(id_personal){
               swal({
                title: 'Esta seguro de desactivar esta Nomina?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('desactivar/personal',{
                        'id_personal': id_personal
                    }).then(response => {
                        me.listarNomina(1, '', 'nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarNomina(id_personal){
               swal({
                title: 'Esta seguro de activar esta Nomina?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('activar/personal',{
                        'id_personal': id_personal
                    }).then(response => {
                        me.listarNomina(1, '', 'nombre');
                        swal(
                        'activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },

            validarNomina(){
                this.errorNomina = 0;
                this.errorMostrarMsjNomina =[];

                if(!this.nombre) this.errorMostrarMsjNomina.push("El nombre de la nomina no puede estar vacio");
                 if(this.errorMostrarMsjNomina.length) this.errorNomina = 1;

                 return this.errorNomina;
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal='';
                this.cedula = '';
                this.nombre = '';
                this.fecha_ingreso = '';
            },

            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "nomina":
                    {
                    switch(accion){
                        case 'registrar':
                        {
                            this.modal = 1;
                            this.tituloModal = 'Registrar Nomina'
                            this.cedula = '';
                            this.nombre = '';
                            this.fecha_ingreso = "";
                            this.Cargo = "";
                            this.tipoAccion = 1;
                            break;
                        }
                        case 'actualizar':
                        {
                           this.modal=1;
                           this.tituloModal='Actualizar';
                           this.tipoAccion=2;
                           this.id_personal = data['id_personal']
                           this.cedula = data['cedula'];
                           this.nombre = data['nombre'];
                            this.Cargo = "";
                           this.fecha_ingreso = data['fecha_ingreso'];
                           break;
                        }
                    }
                }
            }
        }

    },

        mounted() {
            this.listarNomina(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>