<template>
  <div>
    <!-- Encabezado -->
    <div class="col-12 mb-3">
      <div class="card fondo-verde-manzana">
        <div class="card-body">
          <h5 class="card-title">Calendario Escolar</h5>
        </div>
      </div>
    </div>

    <!-- Navegación del calendario -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn rounded-pill btn-outline-success" @click="cambiarMes(-1)">← Anterior</button>
      <h5 class="mb-0">{{ nombreMes }} {{ anio }}</h5>
      <button class="btn rounded-pill btn-outline-success" @click="cambiarMes(1)">Siguiente →</button>
    </div>

    <!-- Calendario -->
    <div class="calendar-grid fondo-calendario">
      <div v-for="(dia, index) in diasSemana" :key="'semana-' + index" class="day-cell fw-bold bg-light">
        {{ dia }}
      </div>

      <div v-for="n in primerDiaMes" :key="'vacio-' + n" class="day-cell"></div>

      <div
        v-for="day in diasDelMes"
        :key="'dia-' + day"
        class="day-cell border p-2 text-center"
        :class="{ 'efemeride-dia': diasConEfemerides.includes(day) }"
        @click="mostrarEfemerides(day)"
      >
        {{ day }}
      </div>
    </div>

    <!-- Modal Efemérides -->
    <div class="modal fade" id="modalEfemerides" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Efemérides del {{ fechaSeleccionada }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div v-if="efemerides.length">
              <ul class="list-group mb-3">
                <li v-for="e in efemerides" :key="e.id" class="list-group-item d-flex justify-content-between align-items-start">
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
              <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" rows="4" v-model="efemerideActual.descripcion"></textarea>
                <small v-if="errores.descripcion" class="text-danger">{{ errores.descripcion }}</small>
              </div>
              <div class="text-end">
                <button class="btn btn-outline-secondary me-2" @click="cancelarEdicion">Cancelar</button>
                <button class="btn btn-success" @click="guardarCambios">
                  {{ efemerideActual.id ? 'Guardar Cambios' : 'Guardar Nueva' }}
                </button>
              </div>
            </div>

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
      primerDiaMes: 0,
      diasSemana: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
      diasDelMes: [],
      diasConEfemerides: [],
      efemerides: [],
      fechaSeleccionada: '',
      modoEdicion: false,
      efemerideActual: { id: null, titulo: '', descripcion: '', fecha: '' },
      errores: { titulo: '', descripcion: '', fecha: '' }
    };
  },
  computed: {
    nombreMes() {
      return ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
              'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'][this.mes];
    }
  },
  methods: {
    generarDiasDelMes() {
      const diasEnMes = new Date(this.anio, this.mes + 1, 0).getDate();
      this.primerDiaMes = new Date(this.anio, this.mes, 1).getDay();
      this.diasDelMes = Array.from({ length: diasEnMes }, (_, i) => i + 1);
      axios.get(`efemerides/mes?anio=${this.anio}&mes=${this.mes + 1}`)
        .then(res => this.diasConEfemerides = res.data.map(Number))
        .catch(err => console.error('Error al cargar efemérides del mes:', err));
    },
    cambiarMes(valor) {
      this.mes += valor;
      if (this.mes < 0) {
        this.mes = 11;
        this.anio--;
      } else if (this.mes > 11) {
        this.mes = 0;
        this.anio++;
      }
      this.generarDiasDelMes();
    },
    mostrarEfemerides(dia) {
      this.modoEdicion = false;
      this.errores = { titulo: '', descripcion: '', fecha: '' };
      const fecha = `${this.anio}-${String(this.mes + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
      this.fechaSeleccionada = fecha;
      axios.get(`efemerides?fecha=${fecha}`)
        .then(res => {
          this.efemerides = res.data;
          new bootstrap.Modal(document.getElementById('modalEfemerides')).show();
        })
        .catch(err => console.error('Error al cargar efemérides:', err));
    },
    nuevaEfemeride() {
      this.efemerideActual = { id: null, titulo: '', descripcion: '', fecha: this.fechaSeleccionada };
      this.modoEdicion = true;
    },
    editarEfemeride(e) {
      this.efemerideActual = { ...e };
      this.modoEdicion = true;
    },
    cancelarEdicion() {
      this.modoEdicion = false;
      this.efemerideActual = { id: null, titulo: '', descripcion: '', fecha: '' };
      this.errores = { titulo: '', descripcion: '', fecha: '' };
    },
    guardarCambios() {
      this.errores = { titulo: '', descripcion: '', fecha: '' };
      if (!this.efemerideActual.titulo.trim()) this.errores.titulo = 'El título es obligatorio';
      if (!this.efemerideActual.descripcion.trim()) this.errores.descripcion = 'La descripción es obligatoria';
      if (!this.efemerideActual.fecha) this.errores.fecha = 'La fecha es obligatoria';

      if (Object.values(this.errores).some(e => e)) return;

      const metodo = this.efemerideActual.id ? axios.put : axios.post;
      const url = this.efemerideActual.id ? `efemerides/${this.efemerideActual.id}` : 'efemerides';
      metodo(url, this.efemerideActual)
        .then(() => {
          bootstrap.Modal.getInstance(document.getElementById('modalEfemerides')).hide();
          Swal.fire({
            icon: 'success',
            title: this.efemerideActual.id ? 'Efeméride actualizada' : 'Efeméride registrada',
            timer: 1500,
            showConfirmButton: false
          }).then(() => location.reload());
        })
        .catch(() => {
          Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo guardar la efeméride.' });
        });
    },
    eliminarEfemeride(id) {
      bootstrap.Modal.getInstance(document.getElementById('modalEfemerides')).hide();
      setTimeout(() => {
        Swal.fire({
          title: '¿Estás seguro?',
          text: 'Esta acción eliminará la efeméride.',
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#4ed571",
          cancelButtonColor: "#d33",
          confirmButtonText: "Sí, eliminar"
        }).then((result) => {
          if (result.isConfirmed) {
            axios.delete(`efemerides/${id}`)
              .then(() => Swal.fire('¡Eliminado!', 'Efeméride eliminada exitosamente.', 'success')
                .then(() => location.reload()))
              .catch(() => Swal.fire('Error', 'No se pudo eliminar la efeméride.', 'error'));
          } else {
            bootstrap.Modal.getInstance(document.getElementById('modalEfemerides')).show();
          }
        });
      }, 250);
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
  padding: 10px;
  border-radius: 8px;
}

.fondo-calendario {
  background-image: url('/asistencia/public/images/calendario.jpg');
  background-size: cover;
  background-position: center;
  border: 1px solid #ccc;
}

.day-cell {
  background: rgba(255, 255, 255, 0.8);
  cursor: pointer;
  border-radius: 4px;
  transition: all 0.2s;
}

.day-cell:hover {
  background: rgba(255, 255, 255, 1);
  font-weight: bold;
}

.efemeride-dia {
  background-color: #e3f8d7 !important;
  font-weight: bold;
  border: 2px solid #e3f8d7;
}

.fondo-verde-manzana {
  background-color: #e3f8d7;
}
</style>
