<template>
  
    <div class="container">
      <div class="col-sm-12 ">
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
              <h5 class="card-header">Lista de Personal</h5>
            </div>
            <div class="col align-self-center">
              <button v-if="user && user.id_rol !== 4" 
                type="button"  
                class="btn rounded-pill btn-outline-success"
                data-bs-toggle="modal"
                data-bs-target="#basicModal"
                 @click="limpiarFormulario()"
              >
                  Nuevo Personal
              </button>
            
              <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Registro de Personal</h5>
                        <button type="button"   class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row g-2">
                        <div class="col mb-3">
                          <label for="cedula" class="form-label">Cédula</label>
                          <input 
                            type="text" 
                            id="cedula" 
                            class="form-control" 
                            v-model="cedula" 
                            autocomplete="off"
                            @keypress="soloNumeros"
                            @input="validarNumero('cedula')"
                          />
                        </div>
                        <div class="col mb-3">
                          <label for="nombre_apellido" class="form-label">Nombres y Apellidos</label>
                          <input 
                            type="text" 
                            id="nombre_apellido" 
                            class="form-control" 
                            v-model="nombre_apellido" 
                            autocomplete="off"
                            @keypress="soloLetras"
                            @input="validarTexto('nombre_apellido')"
                          />
                        </div>
                        <div class="col mb-2">
                          <label for="sexo" class="form-label">Sexo</label>
                          <select class="form-control" v-model="sexo">
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                          </select>
                        </div>
                      </div>
                      <div class="row g-2">
                       
                        <div class="col mb-2">
                          <label for="codigo" class="form-label">Codigo</label>
                          <input 
                            type="text" 
                            id="codigo" 
                            class="form-control" 
                            v-model="codigo" 
                            autocomplete="off"
                            @input="validarNumero('codigo')"
                          />
                        </div>
                        <div class="col mb-2">
                          <label for="cargo" class="form-label">Cargo</label>
                          <input 
                            type="text" 
                            id="cargo" 
                            class="form-control" 
                            v-model="cargo" 
                            autocomplete="off"
                             @input="validarTexto('cargo')"
                          />
                        </div>
                        <div class="col mb-3">
                          <label for="grado" class="form-label">Grado</label>
                          <input 
                            type="text" 
                            id="grado" 
                            class="form-control" 
                            v-model="grado" 
                            autocomplete="off"
                            @keypress="soloLetras"
                            @input="validarTexto('grado')"
                          />
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col mb-3">
                          <label for="horas_academicas" class="form-label">horas</label>
                          <input 
                            type="text" 
                            id="horas_academicas" 
                            class="form-control" 
                            v-model="horas_academicas" 
                            autocomplete="off"
                            @input="validarHorasAcademicas"
                          />
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button v-permiso type="button"  class="btn rounded-pill btn-outline-secondary" data-bs-dismiss="modal">
                        Cerrar
                        </button>
                        <button type="button" class="btn rounded-pill btn-outline-success" @click="registrarPersonal()">Guardar</button>
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
                <th>Cedula</th>
                <th>Nombres y Apellidos</th>
                <th>sexo</th>
                <th>Codigo</th>
                <th>Cargo</th>
                <th>Horas</th>
                <th>grado</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <tr v-for="alumnos in arrayAlumnos">
                <td>{{ alumnos.cedula }}</td>
                <td>{{ alumnos.nombre_apellido }}</td>
                <td>{{ alumnos.sexo }}</td>
                <td>{{ alumnos.codigo }}</td>
                <td>{{ alumnos.cargo }}</td>
                <td>{{ alumnos.horas_academicas }}</td>
                <td>{{ alumnos.grado }}</td>
                <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#editmodal" @click="mostar(alumnos.id_personal)" v-if="user && user.id_rol !== 4" >Editar</button>
                  <button type="button" class="btn btn-outline-success" @click="eliminar(alumnos.id_personal)" v-if="user && user.id_rol !== 4" >Eliminar</button>
                </div>
              </td>
              <!-- eliminar -->
         
              <!-- modal para editar -->
              <div class="modal fade" id="editmodal" tabindex="-1" aria-hidden="true"> 
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel1">Editar Personal</h5>
                      <button type="button" v-permiso class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row g-2">
                        <input type="hidden" v.model="id">
                        <div class="col mb-3">
                          <label for="cedula" class="form-label">Cédula</label>
                          <input 
                            type="text" 
                            id="cedula" 
                            class="form-control" 
                            v-model="cedula" 
                            autocomplete="off"
                            @keypress="soloNumeros"
                            @input="validarNumero('cedula')"
                          />
                        </div>
                        <div class="col mb-3">
                          <label for="nombre_apellido" class="form-label">Nombres y Apellidos</label>
                          <input 
                            type="text" 
                            id="nombre_apellido" 
                            class="form-control" 
                            v-model="nombre_apellido" 
                            autocomplete="off"
                            @keypress="soloLetras"
                            @input="validarTexto('nombre_apellido')"
                          />
                        </div>
                        <div class="col mb-2">
                          <label for="sexo" class="form-label">Sexo</label>
                          <select class="form-control" v-model="sexo">
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                          </select>
                        </div>
                      </div>
                      <div class="row g-2">
                       
                        <div class="col mb-2">
                          <label for="codigo" class="form-label">Codigo</label>
                          <input 
                            type="text" 
                            id="codigo" 
                            class="form-control" 
                            v-model="codigo" 
                            autocomplete="off"
                            @input="validarNumero('codigo')"
                          />
                        </div>
                        <div class="col mb-2">
                          <label for="cargo" class="form-label">Cargo</label>
                          <input 
                            type="text" 
                            id="cargo" 
                            class="form-control" 
                            v-model="cargo" 
                            autocomplete="off"
                             @input="validarTexto('cargo')"
                          />
                        </div>
                        <div class="col mb-3">
                          <label for="grado" class="form-label">Grado</label>
                          <input 
                            type="text" 
                            id="grado" 
                            class="form-control" 
                            v-model="grado" 
                            autocomplete="off"
                            @keypress="soloLetras"
                            @input="validarTexto('grado')"
                          />
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col mb-3">
                          <label for="horas_academicas" class="form-label">horas</label>
                          <input 
                            type="text" 
                            id="horas_academicas" 
                            class="form-control" 
                            v-model="horas_academicas" 
                            autocomplete="off"
                            @input="validarHorasAcademicas"
                          />
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button v-permiso type="button"  class="btn rounded-pill btn-outline-secondary" data-bs-dismiss="modal">
                        Cerrar
                        </button>
                      <button type="button" class="btn rounded-pill btn-outline-success" @click="editarEstudiante()">Editar</button>
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
            cedula: "",
            nombre_apellido: "",
            sexo: "",
            codigo: "",
            cargo: "",
            horas_academicas: "",
            grado: "",
            buscar: "",
            criterio: "",
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
                var url= 'LisPerso?page=' + page + '&buscar=' + buscar;
                axios.get(url).then(response => {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayAlumnos = respuesta.personal.data;
                    me.pagination = respuesta.pagination;
                    })
                    .catch(function (error) {
                    console.log(error);
                    });
            },
            validarHorasAcademicas(event) {
    const valor = event.target.value.trim(); // Obtener el valor del input y eliminar espacios

    // Validar si el campo está vacío
    if (valor === "") {
        this.mostrarError("El campo 'Horas Académicas' es requerido.");
        return; // Detener ejecución si el campo está vacío
    }

    const horasMinimas = 8;
    const horasMaximas = 56;

    // Validar que las horas sean un número y dentro del rango permitido
    if (!/^\d+$/.test(valor)) {
        this.mostrarError("Por favor ingrese un número válido de horas.");
        return;
    }

    const horas = parseInt(valor);

    if (horas < horasMinimas || horas > horasMaximas) {
        this.mostrarError(`Las horas académicas deben estar entre ${horasMinimas} y ${horasMaximas} horas.`);
    } else {
        this.horas_academicas = horas; // Asignar el valor si es válido
        this.msg = ''; // Limpiar el mensaje de error
    }
},


            cambiarPagina(page,buscar){
                let me = this;
                //Actualiza la Pagina Actual
                me.pagination.current_page = page; 
                //Enviar la peticion para visualizar la data de esa pagina 
                me.ListarAlumnos(page,buscar);
            },
            registrarPersonal() {
            // Validación de campos
            const camposRequeridos = {
                cedula: 'El campo "cedula" es requerido',
                nombre_apellido: 'El campo "nombre_apellido" es requerido',
                sexo: 'El campo "sexo" es requerido',
                codigo: 'El campo "codigo" es requerido',
                cargo: 'El campo "cargo" es requerido',
                horas_academicas: 'El campo "horas_academicas" es requerido',
                grado: 'El campo "grado" es requerido',
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
            axios.post('Gpersonal', {
                cedula: this.cedula,
                nombre_apellido: this.nombre_apellido,  // Directamente el valor de nombre_apellido
                sexo: this.sexo,
                codigo: this.codigo,
                cargo: this.cargo,
                horas_academicas: this.horas_academicas,
                grado: this.grado
            }).then(response => {
                this.mostrarExito("Estudiante registrado correctamente.");
                this.limpiarFormulario();
                this.ListarAlumnos(1, this.buscar);
            }).catch(error => {
                // Manejar errores de validación desde el backend
                if (error.response && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    let errorMessage = 'Por favor, corrige los siguientes errores:\n';
                    for (const key in errors) {
                        errorMessage += `${errors[key].join(', ')}\n`;
                    }
                    this.mostrarError(errorMessage);
                } else {
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
                }
            });
        },


        mostar(id_personal) {
     
          this.id = id_personal;
          let me = this;
          var url = 'Bpersonal?id=' + me.id;

          
    axios.get(url)
        .then((response) => {
            const respuesta = response.data;
            this.arrayEstudiante = respuesta.estudiante;

            if (this.arrayEstudiante.length > 0) {
                // Desestructuración para asignar los valores de manera más limpia
                const estudiante = this.arrayEstudiante[0];
                this.cedula = estudiante.cedula;
                this.nombre_apellido = estudiante.nombre_apellido; 
                this.sexo = estudiante.sexo;
                this.codigo = estudiante.codigo;
                this.cargo = estudiante.cargo;
                this.horas_academicas = estudiante.horas_academicas;
                this.grado = estudiante.grado;
            } else {
                // Si no se encuentra el estudiante
                swal("Socio No se encuentra registrado");

                // Limpiar los campos si no se encuentra el estudiante
                this.cedula = '';
                this.nombre_apellido = '';
                this.sexo = '';
                this.codigo = '';
                this.cargo = '';
                this.horas_academicas = '';
                this.grado = '';
            }
        })
        .catch((error) => {
            console.log(error);
        });

    // Mostrar el modal
    const modalElement = document.getElementById('miModal');
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
},

            editarEstudiante() {
                // Validación de campos
            const camposRequeridos = {
                cedula: 'El campo "cedula" es requerido',
                nombre_apellido: 'El campo "nombre_apellido" es requerido',
                sexo: 'El campo "sexo" es requerido',
                codigo: 'El campo "codigo" es requerido',
                cargo: 'El campo "cargo" es requerido',
                horas_academicas: 'El campo "horas_academicas" es requerido',
                grado: 'El campo "grado" es requerido',
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
            axios.post('Epersonal', {
                id: this.id,
                cedula: this.cedula,
                nombre_apellido: this.nombre_apellido,  // Directamente el valor de nombre_apellido
                sexo: this.sexo,
                codigo: this.codigo,
                cargo: this.cargo,
                horas_academicas: this.horas_academicas,
                grado: this.grado
            }).then(response => {
                this.mostrarExito("Estudiante registrado correctamente.");
                this.limpiarFormulario();
                this.ListarAlumnos(1, this.buscar);
            }).catch(error => {
                // Manejar errores de validación desde el backend
                if (error.response && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    let errorMessage = 'Por favor, corrige los siguientes errores:\n';
                    for (const key in errors) {
                        errorMessage += `${errors[key].join(', ')}\n`;
                    }
                    this.mostrarError(errorMessage);
                } else {
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
                }
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
              this.cedula = '';               // Limpiar la variable cedula
              this.nombre_apellido = '';      // Limpiar la variable nombre_apellido
              this.sexo = '';                 // Limpiar la variable sexo
              this.codigo = '';               // Limpiar la variable codigo
              this.cargo = '';                // Limpiar la variable cargo
              this.horas_academicas = '';     // Limpiar la variable horas_academicas
              this.grado = '';                // Limpiar la variable grado
          },
            cerrarModal() {
              // Cerrar el modal usando jQuery
              $('#editmodal').modal('hide');
            },
            eliminar(id_personal) {
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
                axios.get('ELpersonal', {
                  params: {
                    id_personal: id_personal
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