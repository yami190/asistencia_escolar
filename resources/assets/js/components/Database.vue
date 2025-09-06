<template>
     <div class="container">
        
        <div class="col-md-12 col-lg-12 mb-12">
            <div class="card">
            <div class="card-body fondo-verde-manzana">
                <h5 class="card-title">Gestor de Base de Datos</h5>
            </div>
            </div>
        </div>
        <br>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 mb-12 mb-xl-12">
                        <div class="demo-inline-spacing mt-3">
                            <div class="list-group">
                                <div class="row">
                                    <h5 class="card-title">Exportar Base de Datos</h5>
                                    <div class="col-sm-3">
                                        <label for="exampleFormControlSelect1" class="form-label"></label>
                                        
                                        <input type="submit"  class="form-control btn rounded-pill btn-outline-success" value="Exportar" @click="exportDatabase()">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 mb-12 mb-xl-12">
                        <div class="demo-inline-spacing mt-3">
                            <div class="list-group">
                                <div class="row">
                                    <h5 class="card-title">Importar Base de Datos</h5>
                                    <form @submit.prevent="importDatabase">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <input class="form-control"  type="file" @change="handleFileUpload" accept=".sql" required />
                                            </div>
                                            <div class="col-sm-4">
                                                <select v-model="option" required class="form-select">
                                                <option value="clear">Eliminar todo antes de importar</option>
                                                <!-- <option value="append">Mantener lo anterior y solo agregar datos nuevos</option>
                                                <option value="clear_data">Borrar solo los datos pero mantener las tablas</option> -->
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="submit" class="form-control btn rounded-pill btn-outline-success" :disabled="loading">Importar</button>
                                            </div>
                                        </div>
                                    </form>
                                
                                    <div v-if="loading">Cargando...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>        
        </div>
    
    
    </div>
    <!-- <div> -->
      <!-- <form @submit.prevent="importDatabase">
        <input type="file" @change="handleFileUpload" accept=".sql" required />
        <select v-model="option" required>
          <option value="clear">Eliminar todo antes de importar</option>
          <option value="append">Mantener lo anterior y solo agregar datos nuevos</option>
          <option value="clear_data">Borrar solo los datos pero mantener las tablas</option>
        </select>
        <button type="submit" :disabled="loading">Importar Base de Datos</button>
      </form>
  
      <div v-if="loading">Cargando...</div>
    </div> -->
  </template>
  
  <script>
  import Swal from 'sweetalert2';
  
  export default {
    data() {
      return {
        file: null,
        option: 'clear',
        loading: false,
        selectedFile: null
      };
    },
    methods: {

      exportDatabase() {
          Swal.fire({
            title: "¿Estás seguro?",
            text: "Estás a punto de exportar la base de datos. ¿Quieres continuar?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#4ed571",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, exportar",
            cancelButtonText: "Cancelar"
          }).then((result) => {
            if (result.isConfirmed) {
              window.open('export-db', '_blank');
              Swal.fire({
                title: "¡Exportación iniciada!",
                text: "La base de datos se está exportando en una nueva pestaña.",
                icon: "success"
              });
            }
          });
        },

      
      handleFileUpload(event) {
        this.file = event.target.files[0];
        // Verificar si el archivo es .sql
        if (this.file && !this.file.name.endsWith(".sql")) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'El archivo debe ser un archivo SQL (.sql)',
          });
          this.file = null;
          return;
        }

        // Opcional: Verificar el tamaño del archivo si es necesario
        if (this.file.size > 2097152) { // 2MB en bytes
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'El archivo es demasiado grande. El tamaño máximo es 2MB.',
          });
          this.file = null;
          return;
        }
    },

    async importDatabase() {
  if (!this.file) {
    return Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Por favor, seleccione un archivo de base de datos.',
      confirmButtonColor: '#d33'
    });
  }

  // Preguntar si está seguro de realizar la acción
  const result = await Swal.fire({
    icon: 'warning',
    title: '¿Estás seguro?',
    text: 'Esta acción importará la base de datos seleccionada.',
    showCancelButton: true,
    confirmButtonColor: '#4ed571',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, continuar',
    cancelButtonText: 'Cancelar'
  });

  if (!result.isConfirmed) {
    return; // Si el usuario cancela, no realizar la importación
  }

  const formData = new FormData();
  formData.append('database_file', this.file);
  formData.append('option', this.option);

  this.loading = true;

  try {
    const response = await axios.post('import-db', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    Swal.fire({
      title: '¡Importación exitosa!',
      text: 'La base de datos se ha importado correctamente.',
      icon: 'success',
      confirmButtonColor: '#e3f8d7'
    });

  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Ocurrió un error al importar la base de datos.',
      confirmButtonColor: '#d33'
    });
  } finally {
    this.loading = false;
  }
}
,

    },
  };
  </script>
   <style>
   .fondo-verde-manzana {
       background-color: #e3f8d7 !important;
   }
   </style>
  