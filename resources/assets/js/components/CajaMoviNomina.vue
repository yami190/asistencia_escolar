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
                        <!--  <button type="button" class="btn btn-secondary" @click="abrirModal('socio','registrar')">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button> -->
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
                                    <th>Nombre</th>
                                    <th>Cedula</th>
                                    <th>Nomina</th>
                                    <th>Socio</th>
                                    <th>Patrono</th>
                                    <th>Prestamo</th>
                                    <th>Enero</th>
                                    <th>Año</th>
                                    <th>Condición</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="socio in arraycajaahorro" :key="socio.id_nominaca">
                                    <td v-text="socio.nombre"></td>
                                    <td v-text="socio.cedula"></td>
                                    <td v-text="socio.nom_nomina"></td>
                                    <td v-text="socio.nombre"></td>
                                    <td v-text="socio.ahor_socio_caja"></td>
                                    <td v-text="socio.cuota_presta"></td>
                                    <td v-text="socio.mes"></td>
                                    <td v-text="socio.ano"></td>
                                    <td>
                                        <div v-if="socio.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Inactivo</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody>
                               
                                <tr v-for="cal in calcular" :key="cal.ahorro">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Total Ahorro:</td>
                                    <td v-text="cal.ahorro"></td>
                                    <td></td>
                                    <td></td>
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
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
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
                   // socio_id: 0,
                    cedula : '',
                    nombres : '',
                    arraycajaahorro : [],
                    errorMostrarMsjSocio: [],
                    calcular: [],
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
        methods:{
            listarSocio (page,buscar,criterio){
                let me=this;
                var url= 'movimientoCaja?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(response => {
                    
                    var respuesta = response.data;
                    me.arraycajaahorro = respuesta.cajaahorro.data;
                    me.calcular = respuesta.calcular;
                    me.pagination = respuesta.pagination;
                    console.log(respuesta);
                    
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
            }


       

    },

        mounted() {
            this.listarSocio(1,this.buscar,this.criterio);
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