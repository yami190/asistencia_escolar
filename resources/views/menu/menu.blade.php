@include('menu.cabeza')

<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    <!-- Menu -->

    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
      <div class="app-brand demo">

         
          E.B.N "Villa Bolívar"


        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
          <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
      </div>

      <div class="menu-inner-shadow"></div>

      <ul class="menu-inner py-1">
        <!-- Components -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Opciones</span></li>
        <!-- Cards -->
        <li class="menu-item">
          <a href="Calendario" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">Calendario</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="Resumen" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">Asis. Alumnos</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="ResumenPersonal" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">Asis. Personal</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="Alumnos" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">Alumnos</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="Personal" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">Personal</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="MANUAL_DE_SISTEMA_DE_ASISTENCIA" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">Manual</div>
          </a>
        </li>
        @if(Auth::user()->id_rol == 1 || Auth::user()->id_rol == 2 || Auth::user()->id_rol == 3)
        <li class="menu-item">
          <a href="reportes" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">Reportes</div>
          </a>
        </li>
        @endif
        @if(Auth::user()->id_rol == 1)  {{-- Solo para administradores --}}
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Configuraciones</span></li>

        <li class="menu-item">
            <a href="Adminstrador" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Usuarios</div>
            </a>
        </li>
        <li class="menu-item">
          <a href="GestorBD" class="menu-link">
              <i class="menu-icon tf-icons bx bx-collection"></i>
              <div data-i18n="Basic">Gestor de BD</div>
          </a>
      </li>
    @endif
        {{-- <li class="menu-header small text-uppercase"><span class="menu-header-text">Administrador</span></li>
        <!-- Cards -->
        <li class="menu-item">
          <a href="AdmUser" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">Usuarios</div>
          </a>
        </li> --}}
        
        <li class="menu-item">
          <a href="logout" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Basic">Salir</div>
          </a>
        </li>
      </ul>
    </aside>
    <!-- / Menu -->

    <!-- Layout container -->
    <div class="layout-page">
      

      <!-- / Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
          
               
          <script>
            window.Laravel = {!! json_encode(['user' => Auth::user()]) !!};
        </script>
       
        <div id="app">
        <!-- / Content -->

       
