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
                        <i class="fa fa-align-justify"></i> CONTABILIDAD 
                         <button type="button" class="btn btn-secondary" @click="abrirModal('contabilidad','registrar')">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="cedula">Cedula</option>
                                      <option value="mes">Mes</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarContabilidad(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarContabilidad(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div> 
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>#</th>
                                    <th>beneficiario</th>
                                    <th>Referencia</th>
                                    <th>monto</th>
                                    <th>Observacion</th>
                                    <th>Mes</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="contabilidad in arrayContabilidad" :key="contabilidad.id_contabilidad">
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('contabilidad','actualizar', contabilidad)">
                                          <i class="icon-pencil"></i>
                                        </button>&nbsp;
                                        <template v-if="contabilidad.condicion">
                                            <button type="button" class="btn btn-danger btn-sn" @click="desactivarcontabilidad(contabilidad.id_contabilidad)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-danger btn-sn" @click="activarcontabilidad(contabilidad.id_contabilidad)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="contabilidad.id_contabilidad"></td>
                                    <td v-text="contabilidad.beneficiario"></td>
                                    <td v-text="contabilidad.referencia"></td>
                                    <td v-text="contabilidad.monto"></td>
                                    <td v-text="contabilidad.observacion"></td>
                                    <td v-text="contabilidad.mes"></td>
                                    <td>
                                        <div v-if="contabilidad.condicion">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Referencia</label>
                                    <div class="col-md-9">
                                        <input type="text" id="referencia" v-model="referencia" class="form-control" placeholder="Referencia">
                                    </div>
                                </div>
                               <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Mes</label>
                                    <div class="col-md-9" >
                                        <select class="form-control" v-model="mes">
                                            <option value="0">Seleccione... </option>
                                            <option v-for="mes in arrayMes" :key="mes.id_mes" :value="mes.id_mes"> {{ mes.mes }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Observacion</label>
                                    <div class="col-md-9">
                                         <input type="text" id="observacion" v-model="observacion" class="form-control" placeholder="Observacion">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Observacion</label>
                                    <div class="col-md-9">
                                         <input type="text" id="ncuenta" v-model="ncuenta" class="form-control" placeholder="Ingrese Numero de cuenta">
                                    </div>
                                </div>
                                <div v-show="errorcontabilidad" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjcontabilidad" :key="error" v-text="error">
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"  @click="cerrarModal">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarcontabilidad">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarcontabilidad" >Actualizar</button>
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
                    contabilidad_id: 0,
                    cedula : '',
                    mes : '',
                    id_mes : '',
                    referencia : '',
                    observacion : '',
                    ncuenta : '',
                    id_banco: '',
                    arrayContabilidad : [],
                    modal : 0,
                    tituloModal : '',
                    tipoAccion: 0,
                    errorcontabilidad: 0,
                    errorMostrarMsjcontabilidad: [],
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
                    arrayMes : []
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
            listarContabilidad (page,buscar,criterio){
                let me=this;
                var url= 'contabilidad?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(response => {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayContabilidad = respuesta.contabilidad.data;
                    me.pagination = respuesta.pagination;
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
            selectMes (){
                let me=this;
                var url= 'selectMes/Mes';
                axios.get(url).then(response => {
                    //console.log(response);
                    var respuesta = response.data;
                     me.arrayMes = respuesta.mes;
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
                me.listarContabilidad(page,buscar,criterio);
            },

            registrarcontabilidad(){
                if(this.validarcontabilidad()){
                    return
                }

                let me = this;
                axios.post('/cahorro/public/contabilidad',{
                    'cedula': this.cedula,
                    'mes': this.mes,
                    'referencia': this.referencia,
                    'ncuenta': this.ncuenta,
                    'id_banco': this.id_banco,
                    'observacion': this.observacion
                }).then(response => {
                    me.cerrarModal();
                    me.listarContabilidad(1, '', 'cedula');
                }).catch(function (error){
                    console.log(error);
                });
            },

            actualizarcontabilidad(){
                if(this.validarcontabilidad()){
                    return
                }

                let me = this;
                axios.put('/cahorro/public/contabilidad',{
                    'cedula': this.cedula,
                    'mes': this.mes,
                    'referencia': this.referencia,
                    'ncuenta': this.ncuenta,
                    'id_banco': this.id_banco,
                    'observacion': this.observacion,
                    'id_contabilidad': this.contabilidad_id
                }).then(response => {
                    me.cerrarModal();
                    me.listarContabilidad(1, '', 'cedula');
                }).catch(function (error){
                    console.log(error);
                });
            },

            desactivarcontabilidad(id_contabilidad){
               swal({
                title: 'Esta seguro de desactivar esta contabilidad?',
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

                    axios.put('/cahorro/public/desactivar/contabilidad',{
                        'id_contabilidad': id_contabilidad
                    }).then(response => {
                        me.listarContabilidad(1, '', 'cedula');
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
            activarcontabilidad(id_contabilidad){
               swal({
                title: 'Esta seguro de activar esta contabilidad?',
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

                    axios.put('/cahorro/public/activar/contabilidad',{
                        'id_contabilidad': id_contabilidad
                    }).then(response => {
                        me.listarContabilidad(1, '', 'cedula');
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

            validarcontabilidad(){
                this.errorcontabilidad = 0;
                this.errorMostrarMsjcontabilidad =[];

                if(!this.cedula) this.errorMostrarMsjcontabilidad.push("La cedula de la transferencia no puede estar vacio");
                 if(this.errorMostrarMsjcontabilidad.length) this.errorcontabilidad = 1;

                 return this.errorcontabilidad;
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal='';
                this.cedula = '';
                this.mes = '';
                this.ncuenta= '';
                this.id_banco = '';
                this.observacion = '';
                this.referencia = '';
            },

            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "contabilidad":
                    {
                    switch(accion){
                        case 'registrar':
                        {
                            this.modal = 1;
                            this.tituloModal = 'Registrar contabilidad'
                            this.cedula = '';
                            this.id_mes = '';
                            this.observacion = '';
                            this.referencia = '';
                            this.ncuenta = '';
                            this.id_banco = '';
                            this.tipoAccion = 1;
                            break;
                        }
                        case 'actualizar':
                        {
                           this.modal=1;
                           this.tituloModal='Actualizar';
                           this.tipoAccion=2;
                           this.contabilidad_id = data['id_contabilidad']
                           this.cedula = data['cedula'];
                           this.mes = data['mes'];
                           this.referencia = data['referencia'];
                           this.observacion = data['observacion'];
                           break;
                        }
                    }
                }
            }
            this.selectMes();
        }

    },

        mounted() {
            this.listarContabilidad(1,this.buscar,this.criterio);
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