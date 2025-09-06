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
              @click="limpiarFormulario()"
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
                        <input 
                          type="text" 
                          id="nombres" 
                          class="form-control" 
                          v-model="nombres"
                          autocomplete="off" 
                          @keypress="soloLetras"
                          @input="validarTexto('nombres')"
                        />
                      </div>
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
                        >
                      </div>
                      <div class="col mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input 
                          type="text" 
                          id="telefono" 
                          class="form-control" 
                          v-model="telefono" 
                          autocomplete="off"
                          @keypress="soloNumeros"
                          @input="validarNumero('telefono')"
                        />
                      </div>
                    </div>
                    <div class="row g-2">
                      <div class="col mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input 
                          type="email" 
                          id="correo" 
                          class="form-control" 
                          v-model="correo" 
                          autocomplete="off"
                          
                        >
                      </div>
                      <div class="col mb-3">
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
                        <label for="rol" class="form-label">Niveles de usuario</label>
                        <select class="form-control" v-model="id_rol">
                          <option v-for="rol in arrayRoles" :key="rol.id_rol" :value="rol.id_rol" >{{ rol.descripcion }}</option>
                        </select>
                      </div>
                    </div>
                    <div class="row g-2">
                      <div class="row g-2">
                                       
                        <div class="col mb-3">
                        <label for="respuesta1" class="form-label">¿En qué ciudad naciste?</label>
                        <input 
                            type="password" 
                            id="respuesta1" 
                            class="form-control" 
                            v-model="respuesta1" 
                            autocomplete="off"
                        >
                        </div>
                        <div class="col mb-3">
                        <label for="respuesta2" class="form-label">¿Cuál es tu comida favorita?</label>
                        <input 
                            type="password" 
                            id="respuesta2" 
                            class="form-control" 
                            v-model="respuesta2" 
                            autocomplete="off"
                        >
                        </div>
                        <div class="col mb-3">
                        <label for="respuesta3" class="form-label">¿En qué mes naciste?</label>
                        <input 
                            type="password" 
                            id="respuesta3" 
                            class="form-control" 
                            v-model="respuesta3" 
                            autocomplete="off"
                        >
                        </div>
                    </div>
                      <div class="col mb-3">
                        <!-- Contraseña oculto -->
                        <input type="hidden" id="clave" class="form-control" autocomplete="off">
                      </div>
                      <div class="row">
                        <div class="col mb-3">
                          <label for="clave" class="form-label">Contraseña</label>
                          <input 
                            type="password" 
                            id="clave" 
                            class="form-control" 
                            v-model="clave" 
                            autocomplete="off"
                          >
                        </div>
                        <div class="col mb-3">
                          <label for="confirmar_clave" class="form-label">Confirmar Contraseña</label>
                          <input 
                            type="password" 
                            id="confirmar_clave" 
                            class="form-control" 
                            v-model="confirmar_clave" 
                            autocomplete="off"
                          >
                        </div>
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
                      data-bs-dismiss="modal"
                      aria-label="Close"
                      @click="limpiarFormulario()"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row g-2">
                      <div class="col mb-3">
                        <label for="nombres" class="form-label">Nombres y Apellidos</label>
                        <input 
                          type="text" 
                          id="nombres" 
                          class="form-control" 
                          v-model="nombres"
                          autocomplete="off" 
                          @keypress="soloLetras"
                          @input="validarTexto('nombres')"
                        />
                      </div>
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
                        >
                      </div>
                      <div class="col mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input 
                          type="text" 
                          id="telefono" 
                          class="form-control" 
                          v-model="telefono" 
                          autocomplete="off"
                          @keypress="soloNumeros"
                          @input="validarNumero('telefono')"
                        />
                      </div>
                    </div>
                    <div class="row g-2">
                      <div class="col mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input 
                          type="email" 
                          id="correo" 
                          class="form-control" 
                          v-model="correo" 
                          autocomplete="off"
                          
                        >
                      </div>
                      <div class="col mb-3">
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
                        <label for="rol" class="form-label">Niveles de usuario</label>
                        <select class="form-control" v-model="id_rol">
                          <option v-for="rol in arrayRoles" :key="rol.id_rol" :value="rol.id_rol" >{{ rol.descripcion }}</option>
                        </select>
                      </div>
                    </div>
                    <div class="row g-2">
                      <div class="row g-2">
                                       
                        <div class="col mb-3">
                        <label for="respuesta1" class="form-label">¿En qué ciudad naciste?</label>
                        <input 
                            type="password" 
                            id="respuesta1" 
                            class="form-control" 
                            v-model="respuesta1" 
                            autocomplete="off"
                        >
                        </div>
                        <div class="col mb-3">
                        <label for="respuesta2" class="form-label">¿Cuál es tu comida favorita?</label>
                        <input 
                            type="password" 
                            id="respuesta2" 
                            class="form-control" 
                            v-model="respuesta2" 
                            autocomplete="off"
                        >
                        </div>
                        <div class="col mb-3">
                        <label for="respuesta3" class="form-label">¿En qué mes naciste?</label>
                        <input 
                            type="password" 
                            id="respuesta3" 
                            class="form-control" 
                            v-model="respuesta3" 
                            autocomplete="off"
                        >
                        </div>
                    </div>
                      <div class="col mb-3">
                        <!-- Contraseña oculto -->
                        <input type="hidden" id="clave" class="form-control" autocomplete="off">
                      </div>
                      <div class="row">
                        <div class="col mb-3">
                          <label for="clave" class="form-label">Contraseña</label>
                          <input 
                            type="password" 
                            id="clave" 
                            class="form-control" 
                            v-model="clave" 
                            autocomplete="off"
                          >
                        </div>
                        <div class="col mb-3">
                          <label for="confirmar_clave" class="form-label">Confirmar Contraseña</label>
                          <input 
                            type="password" 
                            id="confirmar_clave" 
                            class="form-control" 
                            v-model="confirmar_clave" 
                            autocomplete="off"
                          >
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn rounded-pill btn-outline-secondary" data-bs-dismiss="modal" @click="limpiarFormulario()">
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
    arrayUser: [],
    isLoad: false,
    id: '',
    buscar: '',
    cedula: '',
    nombres: '',
    telefono: '',
    sexo: '',
    id_rol: '',
    cargo: '',
    correo: '',
    clave: '',
    confirmar_clave: '',
    arrayRoles: [],
    respuesta1: "",
    respuesta2: "",
    respuesta3: "",
    msg: '',               // Mensaje general de error o éxito
    errorClave: '',        // Mensaje específico para error en contraseñas
    pagination: {
      total: 0,
      current_page: 0,
      per_page: 0,
      last_page: 0,
      from: 0,
      to: 0
    }
  }
},

  computed: {
    isActived() {
      return this.pagination.current_page;
    },
    pagesNumber() {
      if (!this.pagination.to) return [];

      let from = this.pagination.current_page - this.offset;
      from = from < 1 ? 1 : from;

      let to = from + (this.offset * 2);
      to = to >= this.pagination.last_page ? this.pagination.last_page : to;

      let pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    }
  },
  created() {
    this.ListarUsuarios(1, this.buscar);
    this.selectRol();
  },
  methods: {
    soloNumeros(event) {
      if (!/[0-9]/.test(event.key)) {
        event.preventDefault();
      }
    },
    validarNumero(campo) {
      this[campo] = this[campo].replace(/\D/g, "");
    },
    soloLetras(event) {
      if (!/^[a-zA-Z\s]+$/.test(event.key)) {
        event.preventDefault();
      }
    },
    validarTexto(campo) {
      this[campo] = this[campo].replace(/[^a-zA-Z\s]/g, "");
    },
    validarCorreo() {
      const correoRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      if (!correoRegex.test(this.correo)) {
        console.log("Correo no válido");
      }
    },
    ListarUsuarios(page, buscar) {
      let me = this;
      const url = `Lusuario?page=${page}&buscar=${buscar}`;
      axios.get(url)
        .then(response => {
          const respuesta = response.data;
          me.arrayUsuarios = respuesta.user.data;
          me.pagination = respuesta.pagination;
        })
        .catch(error => {
          console.log(error);
        });
    },
    cambiarPagina(page, buscar) {
      this.pagination.current_page = page;
      this.ListarUsuarios(page, buscar);
    },
    registarUsuario() {
      
      const camposRequeridos = {
        cedula: 'El campo "Cédula" es requerido',
        nombres: 'El campo "Nombres" es requerido',
        telefono: 'El campo "Teléfono" es requerido',
        id_rol: 'El campo "Rol" es requerido',
        cargo: 'El campo "Cargo" es requerido',
        correo: 'El campo "Correo" es requerido',
        clave: 'El campo "Contraseña" es requerido',
        confirmar_clave: 'El campo "Confirmar Contraseña" es requerido',
        respuesta1: 'El campo "¿En qué ciudad naciste?" es requerido',
        respuesta2: 'El campo "¿Cuál es tu comida favorita?" es requerido',
        respuesta3: 'El campo "¿En qué mes naciste?" es requerido'
      };

      this.msg = '';
      for (const campo in camposRequeridos) {
        if (!this[campo]) {
          this.msg = camposRequeridos[campo];
          break;
        }
      }

      if (this.msg) {
        this.mostrarError(this.msg);
        return;
      }

      // Validar que las contraseñas coincidan
      if (this.clave !== this.confirmar_clave) {
        this.mostrarError('Las contraseñas no coinciden');
        return;
      }

      axios.post('Gusuario', {
        cedula: this.cedula,
        nombres: this.nombres,
        telefono: this.telefono,
        id_rol: this.id_rol,
        cargo: this.cargo,
        correo: this.correo,
        clave: this.clave,
        confirmar_clave: this.confirmar_clave,
        respuesta1: this.respuesta1,
        respuesta2: this.respuesta2,
        respuesta3: this.respuesta3
      }).then(response => {
        this.mostrarExito("Usuario registrado correctamente.");
        this.limpiarFormulario();
        this.ListarUsuarios(1, this.buscar);
      }).catch(error => {
        if (error.response && error.response.status === 422) {
          // Laravel devolvió errores de validación
          const errores = error.response.data.errors;
          const primerCampo = Object.keys(errores)[0];
          this.mostrarError(errores[primerCampo][0]);
        } else {
          this.mostrarError(error.message || "Ocurrió un error al registrar el usuario.");
        }
      });
    },

    mostar(id) {
      const usuario = this.arrayUsuarios.find(u => u.id === id);
      if (usuario) {
        this.id = usuario.id;
        this.cedula = usuario.cedula;
        this.nombres = usuario.nombres;
        this.telefono = usuario.telefono;
        this.correo = usuario.correo;
        this.cargo = usuario.cargo;
        this.id_rol = usuario.id_rol;
        this.respuesta1 = usuario.respuesta1;
        this.respuesta2 = usuario.respuesta2;
        this.respuesta3 = usuario.respuesta3;
        
        // Limpiar los campos de clave por si acaso
        this.clave = '';
        this.confirmar_clave = '';
      }
    },
    editarUsuario() {
      const camposRequeridos = {
        cedula: 'El campo "Cédula" es requerido',
        nombres: 'El campo "Nombres" es requerido',
        telefono: 'El campo "Teléfono" es requerido',
        id_rol: 'El campo "Rol" es requerido',
        cargo: 'El campo "Cargo" es requerido',
        correo: 'El campo "Correo" es requerido',
        respuesta1: 'El campo "¿En qué ciudad naciste?" es requerido',
        respuesta2: 'El campo "¿Cuál es tu comida favorita?" es requerido',
        respuesta3: 'El campo "¿En qué mes naciste?" es requerido'
      };

      this.msg = '';
      for (const campo in camposRequeridos) {
        if (!this[campo]) {
          this.msg = camposRequeridos[campo];
          break;
        }
      }

      if (this.msg) {
        this.mostrarError(this.msg);
        return;
      }

      // Validar que las contraseñas coincidan
      if (this.clave !== this.confirmar_clave) {
        this.mostrarError('Las contraseñas no coinciden');
        return;
      }

      axios.post('Eusuario', {
        id: this.id,
        cedula: String(this.cedula),
        nombres: this.nombres,
        telefono: String(this.telefono),
        id_rol: this.id_rol,
        cargo: this.cargo,
        correo: this.correo,
        clave: this.clave,
        confirmar_clave: this.confirmar_clave,
        respuesta1: this.respuesta1,
        respuesta2: this.respuesta2,
        respuesta3: this.respuesta3
      }).then(response => {
        this.mostrarExito("Usuario registrado correctamente.");
        this.ListarUsuarios(1, this.buscar);
      }).catch(error => {
        if (error.response && error.response.status === 422) {
          // Laravel devolvió errores de validación
          const errores = error.response.data.errors;
          const primerCampo = Object.keys(errores)[0];
          this.mostrarError(errores[primerCampo][0]);
        } else {
          this.mostrarError(error.message || "Ocurrió un error al registrar el usuario.");
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
            swalContainer.style.zIndex = '9999';
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
            swalContainer.style.zIndex = '9999';
          }
        }
      });
    },
    validarCampos() {
        if (
          !this.nombres ||
          !this.cedula ||
          !this.telefono ||
          !this.correo ||
          !this.cargo ||
          !this.id_rol ||
          !this.respuesta1 ||
          !this.respuesta2 ||
          !this.respuesta3
        ) {
          alert("Por favor complete todos los campos obligatorios.");
          return false;
        }
        return true;
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
      this.respuesta1 = '';
      this.respuesta2 = '';
      this.respuesta3 = '';
    },
    cerrarModal() {
      const modal = new bootstrap.Modal(document.getElementById('editmodal'));
      modal.hide();
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
          axios.get('ELusuario', { params: { id: id } })
            .then(response => {
              Swal.fire({
                title: "¡Eliminado!",
                text: "El usuario ha sido eliminado.",
                icon: "success"
              });
              this.ListarUsuarios(1, this.buscar);
            })
            .catch(error => {
              console.error(error);
              Swal.fire({
                title: "Error!",
                text: "Ocurrió un error al eliminar el usuario.",
                icon: "error"
              });
            });
        }
      });
    },
    selectRol() {
      let me = this;
      const url = 'roles';
      axios.get(url)
        .then(response => {
          me.arrayRoles = response.data.roles;
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
}
</script>
