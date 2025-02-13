<template>
     <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
              <!--   <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li> -->
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> SOCIOS 
                         <button type="button" class="btn btn-secondary" @click="abrirModal('socio','registrar')">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="cedula">Cedula</option>
                                      <option value="Nombres">Nombres</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarSocio(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarSocio(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div> 
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Cedula</th>
                                    <th>Nomina</th>
                                    <th>Descripcion</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="socio in arraySocio" :key="socio.id_socio">
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('socio','actualizar', socio)">
                                          <i class="icon-pencil"></i>
                                        </button>&nbsp;
                                        <template v-if="socio.condicion">
                                            <button type="button" class="btn btn-danger btn-sn" @click="desactivarSocio(socio.id_socio)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-danger btn-sn" @click="activarSocio(socio.id_socio)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="socio.id_socio"></td>
                                    <td v-text="socio.nombres"></td>
                                    <td v-text="socio.cedula"></td>
                                    <td v-text="socio.nom_nomina"></td>
                                    <td v-text="socio.descripcion"></td>
                                    <td>
                                        <div v-if="socio.condicion">
                                            <span class="badge badge-success">Activo</span>
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
                                    <label class="col-md-3 form-control-label" for="text-input">Cedula</label>
                                    <div class="col-md-9">
                                        <input type="text" id="cedula" v-model="cedula" class="form-control" placeholder="Cedula del Socio">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" id="nombres" v-model="nombres" class="form-control" placeholder="Nombre del Socio">
                                    </div>
                                </div>
                               <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nomina</label>
                                     
                                        <div class="col-md-9">
                                        <!-- <input type="number" id="codigo" v-model="codigo" class="form-control" placeholder="Nombre del Socio"> -->
                                        <select class="form-control" v-model="codigo">
                                              <option v-for="nomina in arrayNomina" :key="nomina.id_nomina" :value="nomina.codigo" > {{ nomina.nombre }}</option>
                                      </select>
                                    </div>  
                                 
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                         <input type="text" id="descripcion" v-model="descripcion" class="form-control" placeholder="Descripcion">
                                    </div>
                                </div>
                                <div v-show="errorSocio" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjSocio" :key="error" v-text="error">
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"  @click="cerrarModal">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarSocio">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarSocio" >Actualizar</button>
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
                    socio_id: 0,
                    cedula : '',
                    nombres : '',
                    codigo : '0',
                    descripcion : '',
                    arraySocio : [],
                    modal : 0,
                    tituloModal : '',
                    tipoAccion: 0,
                    errorSocio: 0,
                    errorMostrarMsjSocio: [],
                    pagination: {
                        'total' : 0,
                        'current_page' : 0,
                        'per_page' : 0,
                        'last_page' : 0,
                        'from' : 0,
                        'to' : 0,
                    },
                    offset : 10,
                    criterio : 'cedula',
                    buscar : '',
                    arrayNomina : []
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
            listarSocio (page,buscar,criterio){
                let me=this;
                var url= 'socio?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(response => {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arraySocio = respuesta.socios.data;
                    me.pagination = respuesta.pagination;
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

            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la Pagina Actual
                me.pagination.current_page = page; 
                //Enviar la peticion para visualizar la data de esa pagina 
                me.listarSocio(page,buscar,criterio);
            },

            registrarSocio(){
                if(this.validarSocio()){
                    return
                }

                let me = this;
                axios.post('registrar/socio',{
                    'cedula': this.cedula,
                    'nombres': this.nombres,
                    'codigo': this.codigo,
                    'descripcion': this.descripcion
                }).then(response => {
                    me.cerrarModal();
                    me.listarSocio(1, '', 'cedula');
                }).catch(function (error){
                    console.log(error);
                });
            },

            actualizarSocio(){
                if(this.validarSocio()){
                    return
                }

                let me = this;
                axios.put('actualizar/socio',{
                    'cedula': this.cedula,
                    'nombres': this.nombres,
                    'codigo': this.codigo,
                    'descripcion': this.descripcion,
                    'id_socio': this.socio_id
                }).then(response => {
                    me.cerrarModal();
                    me.listarSocio(1, '', 'cedula');
                }).catch(function (error){
                    console.log(error);
                });
            },

            desactivarSocio(id_socio){
               swal({
                title: 'Esta seguro de desactivar esta Socio?',
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

                    axios.put('desactivar/socio',{
                        'id_socio': id_socio
                    }).then(response => {
                        me.listarSocio(1, '', 'cedula');
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
            activarSocio(id_socio){
               swal({
                title: 'Esta seguro de activar esta Socio?',
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

                    axios.put('activar/socio',{
                        'id_socio': id_socio
                    }).then(response => {
                        me.listarSocio(1, '', 'cedula');
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

            validarSocio(){
                this.errorSocio = 0;
                this.errorMostrarMsjSocio =[];

                if(!this.nombres) this.errorMostrarMsjSocio.push("El nombre de la socio no puede estar vacio");
                 if(this.errorMostrarMsjSocio.length) this.errorSocio = 1;

                 return this.errorSocio;
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal='';
                this.cedula = '';
                this.nombres = '';
                this.descripcion = '';
            },

            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "socio":
                    {
                    switch(accion){
                        case 'registrar':
                        {
                            this.modal = 1;
                            this.tituloModal = 'Registrar Socio'
                            this.cedula = '';
                            this.nombres = '';
                            this.codigo = '';
                            this.descripcion = "";
                            this.tipoAccion = 1;
                            break;
                        }
                        case 'actualizar':
                        {
                           this.modal=1;
                           this.tituloModal='Actualizar';
                           this.tipoAccion=2;
                           this.socio_id = data['id_socio']
                           this.cedula = data['cedula'];
                           this.nombres = data['nombres'];
                           this.descripcion = data['descripcion'];
                           break;
                        }
                    }
                }
            }
            this.selectNomina();
        }

    },

        mounted() {
            this.listarSocio(1,this.buscar,this.criterio);
            this.selectNomina();
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