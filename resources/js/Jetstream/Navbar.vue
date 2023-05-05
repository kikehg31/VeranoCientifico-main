<template>
<Head> </Head>
  <header class="header navbar navbar-expand-lg navbar-light bg-light navbar-sticky">
    <div class="container px-3">
      <a href="/verano" class="navbar-brand pe-3" id="logo">
        <img src="../../../public/img/logo.png" width="47" alt="Silicon">
        TecNM / Cenidet
      </a>
      <div id="navbarNav" class="offcanvas offcanvas-end">
        <div class="offcanvas-header border-bottom">
          <h5 class="offcanvas-title">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="dropdown drop" id="cont1">
              <a href="#" class="nav-link active" data-bs-toggle="dropdown" aria-current="page">Proyectos</a>
              <div class="dropdown-menu p-0">
                <div class="d-lg-flex">
                  <div class="mega-dropdown-column pt-lg-3 pb-lg-4">
                    <ul class="list-unstyled mb-0">
                      <li><a id="lista" :href="route('verano.index')" class="dropdown-item">Proyectos 2023</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </li>
            <li class="dropdown drop" id="cont1">
              <a href="#" class="nav-link active" data-bs-toggle="dropdown" aria-current="page">Profesores</a>
              <div class="dropdown-menu p-0">
                <div class="d-lg-flex">
                  <div class="mega-dropdown-column pt-lg-3 pb-lg-4">
                    <ul class="list-unstyled mb-0">
                      <li ><a id="lista" :href="route('profesores')" class="dropdown-item small">Profesores 2023</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </li>
            <li class="dropdown drop" id="cont1">
              <a href="#" class="nav-link active" data-bs-toggle="dropdown" aria-current="page">Acerca de</a>
              <div class="dropdown-menu p-0">
                <div class="d-lg-flex">
                  <div class="mega-dropdown-column pt-lg-3 pb-lg-4">
                    <ul class="list-unstyled mb-0">
                      <li><a id="lista" :href="route('acerca.index')" class="dropdown-item">Acerca de</a></li>
                      <li><a id="lista" href="https://veranocientifico.cenidet.tecnm.mx/content/convocatorias/Membresia.pdf" class="dropdown-item">Membresia</a></li>
                      <li><a id="lista" href="https://veranocientifico.cenidet.tecnm.mx/content/convocatorias/Membresia.pdf" class="dropdown-item">Videos Tutoriales</a></li>
                      <li><a id="lista" href="https://veranocientifico.cenidet.tecnm.mx/content/convocatorias/Membresia.pdf" class="dropdown-item">Formatos Recomendados</a></li>
                      <li><a id="lista" href="https://veranocientifico.cenidet.tecnm.mx/content/convocatorias/Membresia.pdf" class="dropdown-item">Presentación Reunión</a></li>
                      <li><a id="lista" href="https://veranocientifico.cenidet.tecnm.mx/content/convocatorias/Membresia.pdf" class="dropdown-item">Grabación Reunión</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </li>
            <li class="dropdown drop" id="cont1">
              <a href="#" class="nav-link active" data-bs-toggle="dropdown" aria-current="page">Registro</a>
              <div class="dropdown-menu p-0">
                <div class="d-lg-flex">
                  <div class="mega-dropdown-column pt-lg-3 pb-lg-4">
                    <ul class="list-unstyled mb-0">
                      <li><a id="opt" class="dropdown-item" :href="route('registro.create')">Registrate aquí</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="offcanvas-footer border-top">
          <a :href="route('login')" class="btn btn-primary w-100">
            <i id="boxi" class='bx bx-user bx-flashing' ></i>
            Acceder al sistema
          </a>
        </div>
      </div>
      <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a :href="route('login')" class="btn btn-primary btn-sm fs-sm rounded d-none d-lg-inline-flex">
        <i id="boxi" class='bx bx-user bx-flashing' ></i>
          &nbsp; Acceder al sistema
      </a>
    </div>
  </header>
</template>

<script>
import { defineComponent } from "vue"
import { Link } from '@inertiajs/inertia-vue3';
import Head from '@/Jetstream/Head.vue';

export default defineComponent({
  components: {
    Link,
    Head
  },

  props: {
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
  },

});

let mode = window.localStorage.getItem('mode'),
        root = document.getElementsByTagName('html')[0];
    if (mode !== undefined && mode === 'dark') {
      root.classList.add('dark-mode');
    } else {
    root.classList.remove('dark-mode');
    };

    (function () {
      window.onload = function () {
        const preloader = document.querySelector('.page-loading');
        preloader.classList.remove('active');
        setTimeout(function () {
          preloader.remove();
        }, 1000);
      };
    })();
</script>

<style scoped>

  /*Barra de navegación*/
  .header{
     position: fixed;
   }

   .navbar{
     width: 100%;
     position: fixed;
  top: 0;
  width: 100%;
  z-index: 1000;
     box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
   }

   .drop{
     font-size: 15px;
   }

   li{
     padding: 2px;
   }

   a[id="logo"]{
     height: 50px;
   }

   a[id="lista"]:hover{
     background-color:rgba(195, 197, 214, 0.795);
     border-radius: 15px;
   }

   a[id="opt"]:hover{
     background-color:rgba(230, 231, 240, 0.932);
     color: #092252;
     border-radius: 12px;
   }

   a[id="opt"]{
     cursor: pointer;
     background-color:rgb(255, 255, 255);
     color: #092252;
     padding-top: 5px;
     border-radius: 10px;
   }

   li[id="cont1"]::after, li[id="cont1"]::before{
     content: '';
     position: absolute;
     background-color: rgb(22, 9, 82);
     width: 3px;
     height: 12px;
     top: 16px;
     border-radius: 5px;
     transition: all 0.3s;
   }

   li[id="cont1"]{
     min-height: 45px;
     position: relative;
     width: 170px;
     margin-left: 12px;
     text-align: center;
     cursor: pointer;
     color: #092252;
   }

   li[id="cont1"]::after{
     transform: rotate(45deg);
     left:75%;
   }

   li[id="cont1"]::before{
     transform: rotate(-45deg);
     left:79%;
   }

   li[id="cont1"]:hover::after{
     transform: rotate(135deg);
   }

   li[id="cont1"]:hover::before{
     transform: rotate(-135deg);
   }

   li[id="cont"]::after, li[id="cont"]::before{
     content: '';
     position: absolute;
     background-color: rgb(22, 9, 82);
     width: 3px;
     height: 11px;
     top: 16px;
     border-radius: 5px;
     transition: all 0.3s;
   }

   li[id="cont"]{
     min-height: 45px;
     position: relative;
     width: 150px;
     margin-left: 12px;
     text-align: center;
     cursor: pointer;
     color: #092252;
   }

   li[id="cont"]::after{
     transform: rotate(45deg);
     left:71%;
   }

   li[id="cont"]::before{
     transform: rotate(-45deg);
     left:75%;
   }

   li[id="cont"]:hover::after{
     transform: rotate(135deg);
   }

   li[id="cont"]:hover::before{
     transform: rotate(-135deg);
   }
</style>
