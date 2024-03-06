<template>
     <main class="main">
            <ol class="breadcrumb">
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> SOCIOS 
                         <button type="button" class="btn btn-secondary" @click="abrirModal('pagos','registrar')">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="cedula">Cedula</option>
                                      <option value="refrecibida">referencia</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPagos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarPagos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div> 
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre Socio</th>
                                    <th>Cedula</th>
                                    <th>Banco</th>
                                    <th>Refrencia</th>
                                    <th>Fecha</th>
                                    <th>monto</th>
                                    <th>Analista</th>
                                    <th>Banco</th>
                                    <th>Refrencia</th>
                                    <th>Fecha</th>
                                    <th>monto</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="transfe in arraytransferencias" :key="transfe.id_pago">
                                    <td>
<!--                                         <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('pagos','actualizar', transfe)">
                                          <i class="icon-pencil"></i>
                                        </button>&nbsp; -->
                                        <template v-if="transfe.estatus">
<!--                                             <button type="button" class="btn btn-danger btn-sn" @click="desactivarSocio(transfe.id_pago)">
                                                <i class="icon-trash"></i>
                                            </button> -->
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sn" @click="procesarpago(transfe.id_pago)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="transfe.socio"></td>
                                    <td v-text="transfe.cedula"></td>
                                    <td v-text="transfe.bancorecibido"></td>
                                    <td v-text="transfe.refrecibida"></td>
                                    <td v-text="transfe.fecharecibido"></td>
                                    <td v-text="transfe.montoreci"></td>
                                    <td v-text="transfe.analista"></td>
                                    <td v-text="transfe.banco"></td>
                                    <td v-text="transfe.refenviado"></td>
                                    <td v-text="transfe.fechaenviado"></td>
                                    <td v-text="transfe.montoenvi"></td>
                                    <td>
                                        <div v-if="transfe.estatus">
                                            <span class="badge badge-success">Procesado</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Pendiente</span>
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
                            <div class="container">
                                <div class="row">
                                    <div  class="col-sm-12">
                                        <p>SOCIO QUE APORTA</p>
                                    </div>
                                    <div class="col-sm-3">
                                      <!-- text input -->
                                      <div class="form-group">
                                        <label>CEDULA SOCIO</label>
                                        <input type="text" v-model="nombres" class="form-control" >
                                      </div>
                                    </div>
                                    <div class="col-sm-3">
                                      <div class="form-group">
                                        <label>NOMBRE SOCIO</label>
                                        <input type="text" v-model="nombres" class="form-control" >
                                      </div>
                                    </div>
                                      <div class="col-sm-3">
                                      <!-- text input -->
                                      <div class="form-group">
                                        <label>NOMINA</label>
                                        <input type="text" v-model="codigo" class="form-control" >
                                      </div>
                                    </div>
                                    <div class="col-sm-3">
                                      <div class="form-group">
                                        <label>BANCO</label>
                                        <input type="text" v-model="banco_analista" class="form-control" >
                                      </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                          <label>REFERENCIA</label>
                                          <input type="text" v-model="refrecibida" class="form-control" >
                                        </div>
                                      </div>
                                    <div class="col-sm-3">
                                      <!-- text input -->
                                      <div class="form-group">
                                        <label>MONTO</label>
                                        <input type="text" v-model="monto_socio" class="form-control" >
                                      </div>
                                    </div>
                                    <div class="col-sm-3">
                                      <div class="form-group">
                                        <label>FECHA DE TRANS.</label>
                                        <input type="text" v-model="fecharecibido" class="form-control" >
                                      </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div  class="col-sm-12">
                                        <p>ANALISTA QUE RECIBE</p>
                                    </div>
                                    <div class="col-sm-3">
                                      <!-- text input -->
                                      <div class="form-group">
                                        <label>NOMBRE DE ANALISTA</label>
                                        <input type="text" v-model="nombres" class="form-control" >
                                      </div>
                                    </div>
                                    <div class="col-sm-3">
                                      <div class="form-group">
                                        <label>BANCO</label>
                                        <input type="text" v-model="banco_caja" class="form-control" >
                                    </div>
                                    </div>
                                      <div class="col-sm-3">
                                      <!-- text input -->
                                      <div class="form-group">
                                        <label>MONTO</label>
                                        <input type="text" v-model="monto_caja" class="form-control" >
                                      </div>
                                    </div>
                                    <div class="col-sm-3">
                                      <div class="form-group">
                                        <label>REFERENCIA</label>
                                        <input type="text" v-model="referencia" class="form-control" >
                                      </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                          <label>FECHA TRANS</label>
                                          <input type="text" v-model="referencia" class="form-control" >
                                        </div>
                                      </div>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"  @click="cerrarModal">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarpago">Guardar</button>
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
                    id_socio : '',
                    banco_analista : '',
                    monto_socio : '',
                    refrecibida : '',
                    fecharecibido : '',
                    id_analista : '',
                    banco_caja : '',
                    referencia : '',
                    monto_caja : '',
                    fecha : '',
                    descripcion : '',
                    nombres : '',
                    codigo : '',
                    arraytransferencias : [],
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
            listarPagos (page,buscar,criterio){
                let me=this;
                var url= 'transferencia?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(response => {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arraytransferencias = respuesta.transferencias.data;
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
                me.listarPagos(page,buscar,criterio);
            },

            registrarpago(){

                alert('prueba');
            //     if(this.validarSocio()){
            //         return
            //     }

            //     let me = this;
            //     axios.post('registrar/socio',{
            //         'cedula': this.cedula,
            //         'refrecibida': this.refrecibida,
            //         'codigo': this.codigo,
            //         'descripcion': this.descripcion
            //     }).then(response => {
            //         me.cerrarModal();
            //         me.listarPagos(1, '', 'cedula');
            //     }).catch(function (error){
            //         console.log(error);
            //     });
             },

            actualizarSocio(){
                if(this.validarSocio()){
                    return
                }

                let me = this;
                axios.put('actualizar/socio',{
                    'cedula': this.cedula,
                    'refrecibida': this.refrecibida,
                    'codigo': this.codigo,
                    'descripcion': this.descripcion,
                    'id_pago': this.socio_id
                }).then(response => {
                    me.cerrarModal();
                    me.listarPagos(1, '', 'cedula');
                }).catch(function (error){
                    console.log(error);
                });
            },

            desactivarSocio(id_pago){
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
                        'id_pago': id_pago
                    }).then(response => {
                        me.listarPagos(1, '', 'cedula');
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
            procesarpago(id_pago){
               swal({
                title: 'Esta seguro de Procesar el pago? NOTA: en caso de un equivocarse debera de dirigirse al administrador de sistemas para revertirlo',
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

                    axios.put('procesar/pago',{
                        'id_pago': id_pago
                    }).then(response => {
                        me.listarPagos(1, '', 'cedula');
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

                if(!this.refrecibida) this.errorMostrarMsjSocio.push("El nombre de la socio no puede estar vacio");
                 if(this.errorMostrarMsjSocio.length) this.errorSocio = 1;

                 return this.errorSocio;
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal='';
                this.cedula = '';
                this.refrecibida = '';
                this.descripcion = '';
            },

            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "pagos":
                    {
                    switch(accion){
                        case 'registrar':
                        {
                            this.modal = 1;
                            this.tituloModal = 'Registrar Pago'
                            this.id_socio = '';
                            this.banco_analista = '';
                            this.monto_socio = '';
                            this.refrecibida = '';
                            this.fecharecibido = '';
                            this.id_analista = '';
                            this.banco_caja = '';
                            this.referencia = '';
                            this.monto_caja = '';
                            this.fecha = '';
                            this.tipoAccion = 1;
                            break;
                        }
                        case 'actualizar':
                        {
                           this.modal=1;
                           this.tituloModal='Actualizar';
                           this.tipoAccion=2;
                           this.socio_id = data['id_pago']
                           this.cedula = data['cedula'];
                           this.refrecibida = data['refrecibida'];
                           this.descripcion = data['descripcion'];
                           break;
                        }
                    }
                }
            }
        }

    },

        mounted() {
            this.listarPagos(1,this.buscar,this.criterio);
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