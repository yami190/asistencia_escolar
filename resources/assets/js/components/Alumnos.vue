<template>
  
    <div class="container">
      <div class="col-sm-12 ">
        <!-- <p>Usuario : {{ $root.user ? $root.user.nombres : 'No autenticado' }}</p> -->
        <div class="card p-3">            
          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse"></div>
            <!-- Search -->
            <div class="navbar-nav align-items">
              <div class="nav-item d-flex align-items">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input
                  type="text"
                  class="form-control border-0 shadow-none"
                  placeholder="Buscador"
                  aria-label="Buscador..."
                  v-model="buscar" @keyup.enter="ListarAlumnos(1,buscar)"
                />
              </div>
            </div>
  
          </div>
      </div>
      <br>
      <div class="card">
        <!-- Contenedor para los toasts -->
        <div class="toast-container position-fixed top-0 end-0 p-3"></div>
        <div class="container">
          <div class="row align-items-start">
            <div class="col align-self-start">
              <h5 class="card-header">Lista de Alumnos</h5>
            </div>
            <div class="col align-self-center">
              <button v-if="user && user.id_rol !== 4" 
                      type="button"
                      class="btn rounded-pill btn-outline-success"
                      data-bs-toggle="modal"
                      data-bs-target="#basicModal"
                      @click="limpiarFormulario()">
                Nuevo Alumno
              </button>
              <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Registro de Estudiante</h5>
                        <button type="button" v-permiso class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row g-2">
                        <div class="col mb-3">
                          <label for="cedulaEscolar" class="form-label">Cédula Escolar</label>
                          <input 
                            type="text" 
                            id="cedulaEscolar" 
                            class="form-control" 
                            v-model="cedul_esco" 
                            autocomplete="off"
                            @keypress="soloNumeros"
                            @input="validarNumero('cedul_esco')"
                          />
                        </div>
                        <div class="col mb-3">
                          <label for="nombre" class="form-label">Nombre</label>
                          <input 
                            type="text" 
                            id="nombre" 
                            class="form-control" 
                            v-model="nombres" 
                            autocomplete="off"
                            @keypress="soloLetras"
                            @input="validarTexto('nombres')"
                          />
                        </div>
                        <div class="col mb-3">
                          <label for="apellido" class="form-label">Apellido</label>
                          <input 
                            type="text" 
                            id="apellido" 
                            class="form-control" 
                            v-model="apellidos" 
                            autocomplete="off"
                            @keypress="soloLetras"
                            @input="validarTexto('apellidos')"
                          />
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col mb-2">
                          <label for="sexo" class="form-label">Sexo</label>
                          <select class="form-control" v-model="sexo">
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                          </select>
                        </div>
                        <div class="col mb-2">
                          <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                          <input 
                            type="date" 
                            id="fechaNacimiento" 
                            class="form-control" 
                            v-model="fecha_naci" 
                            autocomplete="off"
                          />
                        </div>
                        <div class="col mb-3">
                          <label for="estado" class="form-label">Estado</label>
                          <input 
                            type="text" 
                            id="estado" 
                            class="form-control" 
                            v-model="estado" 
                            autocomplete="off"
                            @keypress="soloLetras"
                            @input="validarTexto('estado')"
                          />
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col mb-3">
                          <label for="entidad" class="form-label">Entidad</label>
                          <input 
                            type="text" 
                            id="entidad" 
                            class="form-control" 
                            v-model="entidad" 
                            autocomplete="off"
                            @keypress="soloLetras"
                            @input="validarTexto('entidad')"
                          />
                        </div>
                        <div class="col mb-3">
                          <label for="aula" class="form-label">Aula</label>
                          <select class="form-control" v-model="id_aula">
                            <option v-for="a in arrayAulas" :key="a.id_aula" :value="a.id_aula">{{ a.nombres }}</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                        <button v-permiso type="button"  class="btn rounded-pill btn-outline-secondary" data-bs-dismiss="modal">
                        Cerrar
                        </button>
                        <button  type="button" v-permiso class="btn rounded-pill btn-outline-success" @click="registrarAlumnos()">Guardar</button>
                    </div>
                    </div>
                </div>
                </div>

            </div>
          </div>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead class="table-success ">
              <tr>
                <th>Cedula Escolar</th>
                <th>Nombres y Apellidos</th>
                <th>sexo</th>
                <th>Fecha de Nacimiento</th>
                <th>Estado</th>
                <th>Entidad</th>
                <th>Aula</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <tr v-for="alumnos in arrayAlumnos">
                <td>{{ alumnos.cedul_esco }}</td>
                <td>{{ alumnos.nombres }}, {{ alumnos.apellidos }}</td>
                <td>{{ alumnos.sexo }}</td>
                <td>{{ alumnos.fecha_naci }}</td>
                <td>{{ alumnos.estado }}</td>
                <td>{{ alumnos.entidad }}</td>
                <td>{{ alumnos.aula }}</td>
                <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" v-permiso class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#editmodal" @click="mostar(alumnos.id)">Editar</button>
                  <button type="button" v-permiso class="btn btn-outline-success" @click="eliminar(alumnos.id)">Eliminar</button>
                </div>
              </td>
              <!-- eliminar -->
              <div class="modal modal-top fade" id="elimodal" tabindex="-1">
                <div class="modal-dialog">
                  <form class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="elimodalTitle">Modal title</h5>
                      <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                      @click="limpiarFormulario()"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameSlideTop" class="form-label">¿Esta Seguro de eliminar el registro?</label>
                          
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" v-permiso class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        ¡No!
                      </button>
                      <button type="button" v-permiso class="btn btn-danger" @click="eliminar(usuarios.id)">¡Sí!</button>
                    </div>
                  </form>
                </div>
              </div>
              <!-- modal para editar -->
              <div class="modal fade" id="editmodal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel1">Editar Alumno</h5>
                      <button type="button" v-permiso class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="limpiarFormulario()"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row g-2">
                        <div class="col mb-3">
                          <label for="cedulaEscolar" class="form-label">Cédula Escolar</label>
                          <input 
                            type="text" 
                            id="cedulaEscolar" 
                            class="form-control" 
                            v-model="cedul_esco" 
                            autocomplete="off"
                            @keypress="soloNumeros"
                            @input="validarNumero('cedul_esco')"
                          />
                        </div>
                        <div class="col mb-3">
                          <label for="nombre" class="form-label">Nombre</label>
                          <input 
                            type="text" 
                            id="nombre" 
                            class="form-control" 
                            v-model="nombres" 
                            autocomplete="off"
                            @keypress="soloLetras"
                            @input="validarTexto('nombres')"
                          />
                        </div>
                        <div class="col mb-3">
                          <label for="apellido" class="form-label">Apellido</label>
                          <input 
                            type="text" 
                            id="apellido" 
                            class="form-control" 
                            v-model="apellidos" 
                            autocomplete="off"
                            @keypress="soloLetras"
                            @input="validarTexto('apellidos')"
                          />
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col mb-2">
                          <label for="sexo" class="form-label">Sexo</label>
                          <select class="form-control" v-model="sexo">
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                          </select>
                        </div>
                        <div class="col mb-2">
                          <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                          <input 
                            type="date" 
                            id="fechaNacimiento" 
                            class="form-control" 
                            v-model="fecha_naci" 
                            autocomplete="off"
                          />
                        </div>
                        <div class="col mb-3">
                          <label for="estado" class="form-label">Estado</label>
                          <input 
                            type="text" 
                            id="estado" 
                            class="form-control" 
                            v-model="estado" 
                            autocomplete="off"
                            @keypress="soloLetras"
                            @input="validarTexto('estado')"
                          />
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col mb-3">
                          <label for="entidad" class="form-label">Entidad</label>
                          <input 
                            type="text" 
                            id="entidad" 
                            class="form-control" 
                            v-model="entidad" 
                            autocomplete="off"
                            @keypress="soloLetras"
                            @input="validarTexto('entidad')"
                          />
                        </div>
                        <div class="col mb-3">
                          <label for="aula" class="form-label">Aula</label>
                          <select class="form-control" v-model="id_aula">
                            <option v-for="a in arrayAulas" :key="a.id_aula" :value="a.id_aula">{{ a.nombres }}</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button v-permiso type="button"  class="btn rounded-pill btn-outline-secondary" data-bs-dismiss="modal" @click="limpiarFormulario()">
                        Cerrar
                        </button>
                      <button type="button" v-permiso class="btn rounded-pill btn-outline-success" @click="editarEstudiante()">Editar</button>
                    </div>
                  </div>
                </div>
              </div>
              </tr>  
            </tbody>
            <div class="demo-inline-spacing">
              <nav aria-label="Page navigation">
                <ul class="pagination">
                  <li class="page-item prev" v-if="pagination.current_page > 1">
                    <a class="page-link" href="#" @click.prevent = "cambiarPagina(pagination.current_page - 1,buscar,criterio )"
                      ><i class="tf-icon bx bx-chevrons-left"></i
                    ></a>
                  </li>
                  <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                  </li>
                  <li class="page-item next" v-if="pagination.current_page < pagination.last_page">
                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)"><i class="tf-icon bx bx-chevrons-right"></i
                    ></a>
                  </li>
                </ul>
              </nav>
  
            </div>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  <script>
    
    import axios from 'axios'
   
    
  export default {
    props: ['user'],
      data() {
          return {
            arrayAlumnos: [],
            cedul_esco: "",
            nombres: "",
            apellidos: "",
            sexo: "",
            fecha_naci: "",
            estado: "",
            entidad: "",
            id_aula: "0",
            buscar: "",
            arrayAulas: [],
              pagination: {
                        'total' : 0,
                        'current_page' : 0,
                        'per_page' : 0,
                        'last_page' : 0,
                        'from' : 0,
                        'to' : 0,
                    },
              cedula : '',
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
              this.ListarAlumnos(1,this.buscar);
              this.selectAula();
              
          },
          methods: {
            soloNumeros(event) {
              if (!/[0-9]/.test(event.key)) {
                event.preventDefault();
              }
            },
            validarNumero(campo) {
              this[campo] = this[campo].replace(/\D/g, ""); // Solo números
            },
            soloLetras(event) {
              if (!/^[a-zA-Z\s]+$/.test(event.key)) {
                event.preventDefault();
              }
            },
            validarTexto(campo) {
              this[campo] = this[campo].replace(/[^a-zA-Z\s]/g, ""); // Solo letras
            },
            ListarAlumnos (page,buscar){
                let me=this;
                var url= 'LisAlumno?page=' + page + '&buscar=' + buscar;
                axios.get(url).then(response => {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayAlumnos = respuesta.alumnos.data;
                    me.pagination = respuesta.pagination;
                    })
                    .catch(function (error) {
                    console.log(error);
                    });
            },
            cambiarPagina(page,buscar){
                let me = this;
                //Actualiza la Pagina Actual
                me.pagination.current_page = page; 
                //Enviar la peticion para visualizar la data de esa pagina 
                me.ListarAlumnos(page,buscar);
            },
            registrarAlumnos() {
                // Validación de campos
                const camposRequeridos = {
                    cedul_esco: 'El campo "Cédula Escolar" es requerido',
                    nombres: 'El campo "Nombre" es requerido',
                    apellidos: 'El campo "Apellido" es requerido',
                    sexo: 'El campo "Sexo" es requerido',
                    fecha_naci: 'El campo "Fecha de Nacimiento" es requerido',
                    estado: 'El campo "Estado" es requerido',
                    entidad: 'El campo "Entidad" es requerido',
                    id_aula: 'El campo "Aula" es requerido',
                };

                // Buscar el primer campo vacío
                this.msg = '';
                for (const campo in camposRequeridos) {
                    if (!this[campo]) {
                    this.msg = camposRequeridos[campo];
                    break;
                    }
                }

                // Mostrar mensaje de error si hay campos vacíos
                if (this.msg) {
                    this.mostrarError(this.msg);
                    return; // Detener la ejecución si hay errores
                }

                // Enviar datos a la API
                axios.post('Gestudiante', {
                    'cedul_esco': this.cedul_esco,
                    'nombres': this.nombres,
                    'apellidos': this.apellidos,
                    'sexo': this.sexo,
                    'fecha_naci': this.fecha_naci,
                    'estado': this.estado,
                    'entidad': this.entidad,
                    'id_aula': this.id_aula
                }).then(response => {
                    this.mostrarExito("Estudiante registrado correctamente.");
                    this.limpiarFormulario();
                    this.ListarAlumnos(1, this.buscar);
                }).catch(error => {
                    Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: error.message,
                    didOpen: () => {
                        const swalContainer = document.querySelector('.swal2-container');
                        if (swalContainer) {
                        swalContainer.style.zIndex = '9999'; // Cambia este valor según sea necesario
                        }
                    }
                    });
                });
                },

            mostar(id){
             // alert(id)
              this.id = id;
              let me=this;
              //alert(id)
            var url= 'Bestuadiante?id=' + me.id;
          
            axios.get(url).then(function (response){
                var respuesta = response.data;
                me.arrayEstudiante = respuesta.estudiante;
                if (me.arrayEstudiante.length>0){
                  
                  me.id_estudiante = me.arrayEstudiante[0]['id_estudiante'];
                  me.cedul_esco = me.arrayEstudiante[0]['cedul_esco'];
                  me.nombres = me.arrayEstudiante[0]['nombres'];
                  me.apellidos = me.arrayEstudiante[0]['apellidos'];
                  me.sexo = me.arrayEstudiante[0]['sexo'];
                  me.fecha_naci = me.arrayEstudiante[0]['fecha_naci'];
                  me.estado = me.arrayEstudiante[0]['estado'];
                  me.entidad = me.arrayEstudiante[0]['entidad'];
                  me.id_aula = me.arrayEstudiante[0]['id_aula'];

                }
                else{
                    /// alert(me.cedula)
                if (nombres == null ) {
                    swal("Socio No se encuentra registrado");
  
                    me.nombres='';
                    me.apellidos='';
                    me.nombres='';
                    
                }
                
                }
            })
            .catch(function (error) {
                console.log(error);
            });
            const modalElement = document.getElementById('miModal');
            const modal = new bootstrap.Modal(modalElement);
              modal.show();
              
            },
            editarEstudiante() {
              // Validación de campos
              const camposRequeridos = {
                  cedul_esco: 'El campo "Cédula Escolar" es requerido',
                  nombres: 'El campo "Nombre" es requerido',
                  apellidos: 'El campo "Apellido" es requerido',
                  sexo: 'El campo "Sexo" es requerido',
                  fecha_naci: 'El campo "Fecha de Nacimiento" es requerido',
                  estado: 'El campo "Estado" es requerido',
                  entidad: 'El campo "Entidad" es requerido',
                  id_aula: 'El campo "Aula" es requerido',
              };

              // Buscar el primer campo vacío
              this.msg = '';
              for (const campo in camposRequeridos) {
                  if (!this[campo]) {
                      this.msg = camposRequeridos[campo];
                      break;
                  }
              }

              // Mostrar mensaje de error si hay campos vacíos
              if (this.msg) {
                  this.mostrarError(this.msg);
                  return; // Detener la ejecución si hay errores
              }

              // Enviar datos al servidor
              axios.post('Eestudiante', {
                  id: this.id,
                  cedul_esco: this.cedul_esco,
                  nombres: this.nombres,
                  apellidos: this.apellidos,
                  sexo: this.sexo,
                  fecha_naci: this.fecha_naci,
                  estado: this.estado,
                  entidad: this.entidad,
                  id_aula: this.id_aula
              })
              .then(response => {
                  this.mostrarExito("Estudiante editado correctamente.");
                  this.limpiarFormulario();
                  this.ListarAlumnos(1, this.buscar);
                  this.cerrarModal();
              })
              .catch(error => {
                  // Mostrar mensaje de error
                  this.mostrarError(error.message || "Ocurrió un error al editar el estudiante.");
              });
          },

          mostrarError(mensaje) {
              Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: mensaje,
                  didOpen: () => {
                      const swalContainer = document.querySelector('.swal2-container');
                      if (swalContainer) {
                          swalContainer.style.zIndex = '9999'; // Cambia este valor según sea necesario
                      }
                  }
              });
          },

          mostrarExito(mensaje) {
              Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: mensaje,
                  showConfirmButton: false,
                  timer: 1500,
                  didOpen: () => {
                      const swalContainer = document.querySelector('.swal2-container');
                      if (swalContainer) {
                          swalContainer.style.zIndex = '9999'; // Cambia este valor según sea necesario
                      }
                  }
              });
          },

          limpiarFormulario() {
                this.id_estudiante = '';
                this.cedul_esco = '';
                this.nombres = '';
                this.apellidos = '';
                this.sexo = '';
                this.fecha_naci = '';
                this.estado = '';
                this.entidad = '';
                this.id_aula = '';
            },
            cerrarModal() {
              // Cerrar el modal usando jQuery
              $('#editmodal').modal('hide');
            },
            eliminar(id) {
            Swal.fire({
              title: "¿Estas seguro?",
              text: "¡No podrás revertir esto!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#4ed571",
              cancelButtonColor: "#d33",
              confirmButtonText: "¡Sí, bórralo!"
            }).then((result) => {
              if (result.isConfirmed) {
                // Realiza la solicitud de eliminación usando Axios
                axios.get('ELtudiante', {
                  params: {
                    id: id
                  }
                })
                .then(response => {
                  // Muestra un mensaje de éxito
                  Swal.fire({
                    title: "¡Eliminado!",
                    text: "Su archivo ha sido eliminado.",
                    icon: "success"
                  });
  
                  // Llama al método para actualizar la lista de usuarios
                  this.ListarAlumnos(1, this.buscar);
                })
                .catch(error => {
                  console.error(error);
                  // Muestra un mensaje de error
                  Swal.fire({
                    title: "Error!",
                    text: "There was an error deleting the file.",
                    icon: "error"
                  });
                });
              }
            });
          },
          selectAula (){
                let me=this;
                var url= 'aula';
                axios.get(url).then(response => {
                    console.log(response);
                    var respuesta = response.data;
                    me.arrayAulas = respuesta.aulas;
                        me.id_aula = me.arrayAulas[0]['id_aula'];
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
       }
  }
    </script>
