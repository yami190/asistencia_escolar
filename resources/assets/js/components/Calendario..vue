<template>
  <div>
    <div class="col-md-12 col-lg-12 mb-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Calendario Escolar</h5>
        </div>
      </div>
    </div>
    <br />

    <!-- Navegación del mes -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-sm btn-outline-secondary" @click="cambiarMes(-1)">← Anterior</button>
      <h5 class="mb-0">{{ nombreMes }} {{ anio }}</h5>
      <button class="btn btn-sm btn-outline-secondary" @click="cambiarMes(1)">Siguiente →</button>
    </div>

    <!-- Calendario -->
    <div class="calendar-grid">
      <div
        v-for="day in diasDelMes"
        :key="day"
        class="day-cell border p-2 text-center"
        @click="mostrarEfemerides(day)"
      >
        {{ day }}
      </div>
    </div>

    <!-- Modal Efemérides -->
    <div class="modal fade" id="modalEfemerides" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Efemérides del {{ fechaSeleccionada }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>

          <div class="modal-body">
            <!-- Lista de Efemérides -->
            <div v-if="efemerides.length">
              <ul class="list-group mb-3">
                <li
                  v-for="e in efemerides"
                  :key="e.id"
                  class="list-group-item d-flex justify-content-between align-items-start"
                >
                  <div class="ms-2 me-auto">
                    <div class="fw-bold">{{ e.titulo }}</div>
                    {{ e.descripcion }}
                  </div>
                  <div>
                    <button class="btn btn-sm btn-outline-primary me-1" @click="editarEfemeride(e)">Editar</button>
                    <button class="btn btn-sm btn-outline-danger" @click="eliminarEfemeride(e.id)">Eliminar</button>
                  </div>
                </li>
              </ul>
            </div>

            <div v-else>
              <p>No hay efemérides registradas.</p>
              <button class="btn btn-outline-success btn-sm" @click="nuevaEfemeride">Agregar Efeméride</button>
            </div>

            <!-- Formulario -->
            <div v-if="modoEdicion">
              <hr />
              <h6>{{ efemerideActual.id ? 'Editar Efeméride' : 'Registrar Efeméride' }}</h6>
              <div class="row g-2">
                <div class="col mb-3">
                  <label class="form-label">Fecha</label>
                  <input type="date" class="form-control" v-model="efemerideActual.fecha" />
                  <small v-if="errores.fecha" class="text-danger">{{ errores.fecha }}</small>
                </div>
                <div class="col mb-3">
                  <label class="form-label">Título</label>
                  <input type="text" class="form-control" v-model="efemerideActual.titulo" />
                  <small v-if="errores.titulo" class="text-danger">{{ errores.titulo }}</small>
                </div>
              </div>
              <div class="row g-2">
                <div class="col mb-3">
                  <label class="form-label">Descripción</label>
                  <textarea class="form-control" rows="4" v-model="efemerideActual.descripcion"></textarea>
                  <small v-if="errores.descripcion" class="text-danger">{{ errores.descripcion }}</small>
                </div>
              </div>

              <div class="text-end">
                <button class="btn btn-outline-secondary me-2" @click="cancelarEdicion">Cancelar</button>
                <button class="btn btn-success" @click="guardarCambios">
                  {{ efemerideActual.id ? 'Guardar Cambios' : 'Guardar Nueva' }}
                </button>
              </div>
            </div>

            <!-- Botón agregar nueva -->
            <div v-if="efemerides.length && !modoEdicion" class="text-end mt-3">
              <button class="btn btn-outline-success" @click="nuevaEfemeride">Agregar Nueva Efeméride</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    const fechaActual = new Date();
    return {
      anio: fechaActual.getFullYear(),
      mes: fechaActual.getMonth(),
      diasDelMes: [],
      efemerides: [],
      fechaSeleccionada: '',
      modoEdicion: false,
      efemerideActual: {
        id: null,
        titulo: '',
        descripcion: '',
        fecha: ''
      },
      errores: {
        titulo: '',
        descripcion: '',
        fecha: ''
      }
    };
  },
  computed: {
    nombreMes() {
      const nombres = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
      ];
      return nombres[this.mes];
    }
  },
  methods: {
    generarDiasDelMes() {
      const diasEnMes = new Date(this.anio, this.mes + 1, 0).getDate();
      this.diasDelMes = Array.from({ length: diasEnMes }, (_, i) => i + 1);
    },
    cambiarMes(valor) {
      this.mes += valor;
      if (this.mes < 0) {
        this.mes = 11;
        this.anio -= 1;
      } else if (this.mes > 11) {
        this.mes = 0;
        this.anio += 1;
      }
      this.generarDiasDelMes();
    },
    mostrarEfemerides(dia) {
      this.modoEdicion = false;
      this.errores = { titulo: '', descripcion: '', fecha: '' };
      const fecha = `${this.anio}-${String(this.mes + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
      this.fechaSeleccionada = fecha;

      axios.get(`/efemerides?fecha=${fecha}`)
        .then(res => {
          this.efemerides = res.data;
          const modal = new bootstrap.Modal(document.getElementById('modalEfemerides'));
          modal.show();
        })
        .catch(err => console.error('Error al cargar efemérides:', err));
    },
    editarEfemeride(efemeride) {
      this.efemerideActual = { ...efemeride };
      this.modoEdicion = true;
    },
    nuevaEfemeride() {
      this.efemerideActual = {
        id: null,
        titulo: '',
        descripcion: '',
        fecha: this.fechaSeleccionada
      };
      this.modoEdicion = true;
    },
    cancelarEdicion() {
      this.modoEdicion = false;
      this.efemerideActual = { id: null, titulo: '', descripcion: '', fecha: '' };
      this.errores = { titulo: '', descripcion: '', fecha: '' };
    },
    guardarCambios() {
      this.errores = { titulo: '', descripcion: '', fecha: '' };
      let valido = true;

      if (!this.efemerideActual.titulo.trim()) {
        this.errores.titulo = 'El título es obligatorio';
        valido = false;
      }
      if (!this.efemerideActual.descripcion.trim()) {
        this.errores.descripcion = 'La descripción es obligatoria';
        valido = false;
      }
      if (!this.efemerideActual.fecha) {
        this.errores.fecha = 'La fecha es obligatoria';
        valido = false;
      }
      if (!valido) return;

      const data = {
        titulo: this.efemerideActual.titulo,
        descripcion: this.efemerideActual.descripcion,
        fecha: this.efemerideActual.fecha
      };

      const modalEl = document.getElementById('modalEfemerides');
      const modal = bootstrap.Modal.getInstance(modalEl);

      const peticion = this.efemerideActual.id
        ? axios.put(`/efemerides/${this.efemerideActual.id}`, data)
        : axios.post('/efemerides', data);

      peticion.then(() => {
        modal.hide();
        Swal.fire({
          icon: 'success',
          title: this.efemerideActual.id ? 'Efeméride actualizada' : 'Efeméride registrada',
          timer: 1500,
          showConfirmButton: false
        }).then(() => location.reload());
      }).catch(() => {
        Swal.fire({
          icon: 'error',
          title: 'Error al guardar',
          text: 'Revisa los datos e intenta de nuevo.'
        });
      });
    },
    eliminarEfemeride(id) {
      Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then(result => {
        if (result.isConfirmed) {
          axios.delete(`/efemerides/${id}`)
            .then(() => {
              Swal.fire({
                icon: 'success',
                title: 'Eliminado correctamente',
                timer: 1500,
                showConfirmButton: false
              }).then(() => location.reload());
            })
            .catch(() => {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo eliminar.'
              });
            });
        }
      });
    }
  },
  mounted() {
    this.generarDiasDelMes();
  }
};
</script>

<style scoped>
.calendar-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 4px;
}
.day-cell {
  background: #f9f9f9;
  cursor: pointer;
  border-radius: 4px;
}
.day-cell:hover {
  background: #e9ecef;
}
.text-danger {
  font-size: 0.85em;
}
</style>
