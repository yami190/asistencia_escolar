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
                v-model="buscar" @keyup.enter="ListarUsuarios(1,buscar)"
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
            <h5 class="card-header">Lista de Usuarios</h5>
          </div>
          <div class="col align-self-center">
            <button
              type="button"
              class="btn rounded-pill btn-outline-success"
              data-bs-toggle="modal"
              data-bs-target="#basicModal"
            >
                Nuevo Usuario
            </button>
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Usuario</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <div class="row g-2">
                      <div class="col mb-3">
                        <label for="nombres" class="form-label">Nombres y Apellidos</label>
                        <input type="text" id="nombres" class="form-control" v-model="nombres"autocomplete="off"/>
                      </div>
                      <div class="col mb-3">
                        <label for="cedula" class="form-label">Cedula</label>
                        <input type="text" id="cedula" class="form-control" v-model="cedula" autocomplete="off">
                      </div>
                      <div class="col mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" id="telefono" class="form-control" v-model="telefono" autocomplete="off"/>
                      </div>
                    </div>
                    <div class="row g-2">
                      <div class="col mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="text" id="correo" class="form-control" v-model="correo" autocomplete="off">
                      </div>
                      <div class="col mb-3">
                        <label for="cargo" class="form-label">Cargo</label>
                        <input type="text" id="cargo" class="form-control" v-model="cargo" autocomplete="off"/>
                      </div>
                      <div class="col mb-3">
                        <label for="rol" class="form-label">Niveles de usuario</label>
                        <select class="form-control" v-model="id_rol" >
                          <option v-for="rol in arrayRoles" :key="rol.id_rol" :value="rol.id_rol" > {{ rol.descripcion }}</option>
                      </select>
                      </div>
                    </div>
                    <div class="row g-2">
                      <div class="col mb-3">
                        <label for="clave" class="form-label">Contraseña</label>
                        <input type="password" id="clave" class="form-control" v-model="clave" autocomplete="off">
                      </div>
                      <div class="col mb-3">
                        <!-- <label for="clave" class="form-label">Contraseña</label> -->
                        <input type="hidden" id="clave" class="form-control"  autocomplete="off">
                      </div>
                      <div class="col mb-3">
                        <!-- <label for="clave" class="form-label">Contraseña</label> -->
                        <input type="hidden" id="clave" class="form-control"  autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn rounded-pill btn-outline-secondary" data-bs-dismiss="modal">
                      Close
                    </button>
                    <button type="button" class="btn rounded-pill btn-outline-success" @click="registarUsuario()">Guardar</button>
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
              <th>Nombres y Apellidos</th>
              <th>Cedula</th>
              <th>Telefono</th>
              <th>Correo</th>
              <th>Cargo</th>
              <th>Rol</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <tr v-for="usuarios in arrayUsuarios">
              <td>{{ usuarios.nombres }}</td>
              <td>{{ usuarios.cedula }}</td>
              <td>{{ usuarios.telefono }}</td>
              <td>{{ usuarios.correo }}</td>
              <td>{{ usuarios.cargo }}</td>
              <td>{{ usuarios.rol }}</td>
              <td>
              <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#editmodal" @click="mostar(usuarios.id)">Editar</button>
                <button type="button" class="btn btn-outline-success" @click="eliminar(usuarios.id)">Eliminar</button>
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
                    ></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col mb-3">
                        <label for="nameSlideTop" class="form-label">¿Esta Seguro de eliminar el registro?</label>
                        
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                      ¡No!
                    </button>
                    <button type="button" class="btn btn-danger" @click="eliminar(usuarios.id)">¡Sí!</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- modal para editar -->
            <div class="modal fade" id="editmodal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Editar Usuario</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <div class="row g-2">
                      <div class="col mb-3">
                        <label for="nombres" class="form-label">Nombres y Apellidos</label>
                        <input type="text" id="nombres" class="form-control" v-model="nombres"autocomplete="off"/>
                      </div>
                      <div class="col mb-3">
                        <label for="cedula" class="form-label">Cedula</label>
                        <input type="text" id="cedula" class="form-control" v-model="cedula" autocomplete="off">
                      </div>
                      <div class="col mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" id="telefono" class="form-control" v-model="telefono" autocomplete="off"/>
                      </div>
                    </div>
                    <div class="row g-2">
                      <div class="col mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="text" id="correo" class="form-control" v-model="correo" autocomplete="off">
                      </div>
                      <div class="col mb-3">
                        <label for="cargo" class="form-label">Cargo</label>
                        <input type="text" id="cargo" class="form-control" v-model="cargo" autocomplete="off"/>
                      </div>
                      <div class="col mb-3">
                        <label for="rol" class="form-label">Niveles de usuario</label>
                        <select class="form-control" v-model="id_rol" >
                          <option v-for="rol in arrayRoles" :key="rol.id_rol" :value="rol.id_rol" > {{ rol.descripcion }}</option>
                      </select>
                      </div>
                    </div>
                    <div class="row g-2">
                      <div class="col mb-3">
                        <label for="clave" class="form-label">Contraseña</label>
                        <input type="password" id="clave" class="form-control" v-model="clave" autocomplete="off">
                      </div>
                      <div class="col mb-3">
                        <!-- <label for="clave" class="form-label">Contraseña</label> -->
                        <input type="hidden" id="clave" class="form-control"  autocomplete="off">
                      </div>
                      <div class="col mb-3">
                        <!-- <label for="clave" class="form-label">Contraseña</label> -->
                        <input type="hidden" id="clave" class="form-control"  autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn rounded-pill btn-outline-secondary" data-dismiss="modal" @click="limpiarFormulario()">
                      Close
                    </button>
                    <button type="button" class="btn rounded-pill btn-outline-success" @click="editarUsuario()">Editar</button>
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
    data() {
        return {
            arrayUsuarios: [],
            arrrayusuarios: [],
            arrayUser:[],
            isLoad: false,
            id:'',
            buscar:'',
            cedula : '',
            nombres : '',
            telefono : '',
            sexo : '',
            id_rol: '',
            cargo: '',
            correo: '',
            clave: '',
            arrayRoles: '',
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
            this.ListarUsuarios(1,this.buscar);
            this.selectRol();
            
        },
        methods: {
          ListarUsuarios (page,buscar){
              let me=this;
              var url= 'Lusuario?page=' + page + '&buscar=' + buscar;
              axios.get(url).then(response => {
                  //console.log(response);
                  var respuesta = response.data;
                  me.arrayUsuarios = respuesta.user.data;
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
              me.ListarUsuarios(page,buscar);
          },
          registarUsuario() {
             // Validación de campos
             const camposRequeridos = {
                cedula: 'El campo "Cédula" es requerido',
                nombres: 'El campo "Nombres" es requerido',
                telefono: 'El campo "Teléfono" es requerido',
                id_rol: 'El campo "Rol" es requerido',
                cargo: 'El campo "Cargo" es requerido',
                correo: 'El campo "Correo" es requerido',
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
      axios.post('Gusuario', {
                'cedula': this.cedula,
                'nombres': this.nombres,
                'telefono': this.telefono,
                'id_rol': this.id_rol,
                'cargo': this.cargo,
                'correo': this.correo,
                'clave': this.clave,
            }).then(response => {
                this.mostrarExito("Usuario editado correctamente.");
                this.limpiarFormulario();
                this.ListarUsuarios(1, this.buscar);
         
            }).catch(function (error) {
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
                //footer: '<a href="#">Why do I have this issue?</a>'
              });
                //me.showToast('Oops...', 'Mensaje: ' + error.message, 'bg-danger');
            });
          },
          mostar(id){
            this.id = id;
            let me=this;
            //alert(id)
          var url= 'Bususuario?id=' + me.id;
        
          axios.get(url).then(function (response){
              var respuesta = response.data;
              me.arrayUser = respuesta.user;
              if (me.arrayUser.length>0){
                
                  me.id = me.arrayUser[0]['id'];
                  me.cedula = me.arrayUser[0]['cedula'];
                  me.nombres = me.arrayUser[0]['nombres'];
                  me.telefono = me.arrayUser[0]['telefono'];
                  me.id_rol = me.arrayUser[0]['id_rol'];
                  me.cargo = me.arrayUser[0]['cargo'];
                  me.correo = me.arrayUser[0]['correo'];
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
          editarUsuario() {
              // Validación de campos
              const camposRequeridos = {
                cedula: 'El campo "Cédula" es requerido',
                nombres: 'El campo "Nombres" es requerido',
                telefono: 'El campo "Teléfono" es requerido',
                id_rol: 'El campo "Rol" es requerido',
                cargo: 'El campo "Cargo" es requerido',
                correo: 'El campo "Correo" es requerido',
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
      axios.post('Eusuario', {
        id: this.id,
        cedula: this.cedula,
        nombres: this.nombres,
        telefono: this.telefono,
        id_rol: this.id_rol,
        cargo: this.cargo,
        correo: this.correo,
        clave: this.clave,
      })
      .then(response => {

        this.mostrarExito("Usuario editado correctamente.");
        this.limpiarFormulario();
        this.ListarUsuarios(1, this.buscar);
        this.cerrarModal();
        
      })
      .catch(error => {
        // Mostrar mensaje de error
        this.mostrarError(error.message || "Ocurrió un error al editar el usuario.");
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
            this.id = '';
            this.cedula = '';
            this.nombres = '';
            this.telefono = '';
            this.id_rol = '';
            this.cargo = '';
            this.correo = '';
            this.clave = '';
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
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "¡Sí, bórralo!"
          }).then((result) => {
            if (result.isConfirmed) {
              // Realiza la solicitud de eliminación usando Axios
              axios.get('ELusuario', {
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
                this.ListarUsuarios(1, this.buscar);
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
        selectRol(){
          let me=this;
          var url= 'roles';
          axios.get(url).then(response => {
              console.log(response);
              var respuesta = response.data;
              me.arrayRoles = respuesta.roles;
              
          })
          .catch(function (error) {
              console.log(error);
          });
      },
     }
}
  </script>