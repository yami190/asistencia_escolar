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
                        <i class="fa fa-align-justify"></i> SOCIOS 
                         <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-xl" disabled>
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <!-- /.modal agregar -->
                    <div class="modal fade" id="modal-xl">
                        <div class="modal-dialog modal-xl">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Registrar Cuenta</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="container">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" v-model="cedula" @keyup.enter="buscarcedula(cedula)">
                                        <span class="input-group-append">
                                        <button type="button" class="btn btn-info btn-flat"@click="buscarcedula(cedula)">Buscar</button>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                     <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Nombre" disabled>
                                    </div>   
                                    </div>
                                    <div class="col-sm-12">
                                     <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Nomina" disabled>
                                    </div>   
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control">
                                        <span class="input-group-append">
                                        
                                        </span>
                                        </div>
                                    </div>
                                    
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="cedula">Cedula</option>
                                      <option value="Nombres">Nombres</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="ListarCuenta(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="ListarCuenta(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div> 
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Cedula</th>
                                    <th>Nomina</th>
                                    <th>Nro Cuenta</th>
                                    <th>Banco</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="cuenta in arrayCuenta" :key="cuenta.id_cuenta">
                                    <td v-text="cuenta.id_cuenta"></td>
                                    <td v-text="cuenta.nombres"></td>
                                    <td v-text="cuenta.cedula"></td>
                                    <td v-text="cuenta.nom_nomina"></td>
                                    <td v-text="cuenta.ncuenta"></td>
                                    <td v-text="cuenta.banco"></td>
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
            
        </main>
</template>

<script>
    export default {
            data (){
                return{
                    cedula : '',
                    nombres : '',
                    arrayCuenta : [],
                    arraybuscar : [],
                    errorMostrarMsjSocio: [],
                    pagination: {
                        'total' : 0,
                        'current_page' : 0,
                        'per_page' : 0,
                        'last_page' : 0,
                        'from' : 0,
                        'to' : 0,
                    },
                    offset : 12,
                    criterio : 'cedula',
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
        created: function(){
                this.buscarcedula(cedula);
            },
        methods:{
            ListarCuenta (page,buscar,criterio){
                let me=this;
                var url= 'cuenta?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(response => {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayCuenta = respuesta.cuentas.data;
                    me.pagination = respuesta.pagination;
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
            buscarcedula(cedula){
                let me=this;
                var url= 'buscarcedula?cedula=' + cedula;
                axios.get(url).then(response => {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arraybuscar = respuesta.busqueda;  
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
                me.ListarCuenta(page,buscar,criterio);
            }
    },

        mounted() {
            this.ListarCuenta(1,this.buscar,this.criterio);
        }
    }
</script>
