<template>
<Head><link rel="icon" type="image/png" href="/public/logo.png" sizes="16x16, 32x32, 48x48"></Head>
  <Profe v-if="$page.props.user.id_rol == 2"></Profe>
  <Admin v-if="$page.props.user.id_rol == 1"></Admin>
  <Alumno v-if="$page.props.user.id_rol == 4"></Alumno>
  <Revisor v-if="$page.props.user.id_rol == 3"></Revisor>
<body>
  <main class="page-wrapper">
   <section class="container pt-4">
        <div class="row">
          <aside class="col-lg-3 col-md-4 border-end pb-5 mt-n5">
            <div class="position-sticky top-0">
              <div class="text-center pt-5">
                <div class="d-table position-relative mx-auto mt-2 mt-lg-4 pt-5 mb-3">
                  <img :src="user.photo" class="d-block rounded-circle" ref="photo"  width="120" alt="John Doe">
                </div>
                <h2 class="h5 mb-1">{{ $page.props.user.name}} {{ $page.props.user.lastnamep}} {{ $page.props.user.lastnamem }}</h2>
                <p class="mb-3 pb-3">{{ $page.props.user.email}}</p>
                <button type="button" class="btn btn-secondary w-100 d-md-none mt-n2 mb-3" data-bs-toggle="collapse" data-bs-target="#account-menu">
                  <i class="bx bxs-user-detail fs-xl me-2"></i>
                  Menú
                  <i class="bx bx-chevron-down fs-lg ms-1"></i>
                </button>
                <div id="account-menu" class="list-group list-group-flush collapse d-md-block">
                  <a href="/dashboard" class="list-group-item list-group-item-action d-flex align-items-center active">
                    <i class="bi bi-house fs-xl opacity-60 me-2"></i> &nbsp;
                    Bienvenido
                  </a>
                  <a :href="route('registro.edit', $page.props.user.id)" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-person-gear fs-xl opacity-60 me-2"></i>&nbsp;
                    Detalles de la cuenta
                  </a>
                  <a :href="route('registro.edit', $page.props.user.id)" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-earmark-lock fs-xl opacity-60 me-2"></i>&nbsp;
                    Seguridad de la cuenta
                  </a>
                  <a v-if="$page.props.user.id_rol == 1" :href="route('reportes.index')" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-bar-graph fs-xl opacity-60 me-2"></i> &nbsp;
                    Reportes PDF
                  </a>
                  <a v-if="$page.props.user.id_rol == 1" href="/indexbackup"  class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-database fs-xl opacity-60 me-2"></i> &nbsp;
                    Base de Datos
                  </a>
                  <a class="list-group-item list-group-item-action d-flex align-items-center" @click="logout" style="cursor: pointer;">
                    <i class="bi bi-box-arrow-left fs-xl opacity-60 me-2"></i>&nbsp;
                    Cerrar sesión
                </a>
                </div>
              </div>
            </div>
          </aside>
          <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
        </svg>
        <div class="col-md-8 offset-lg-md-1 pb-5 mb-2 mb-lg-1 pt-md-5 mt-n3 mt-md-0">
            <div class="ps-md-4 ps-lg-5 mt-md-4 py-md-4">

                <div v-if="$page.props.flash.success" class="alert d-flex alert-info" role="alert">
                    <i class="bx bx-info-circle lead me-3"></i>{{ $page.props.flash.success }}
                </div>

                <div v-if="$page.props.flash.message" class="alert alert-warning d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                        {{ $page.props.flash.message }}
                    </div>
                </div>
                <div>
                    <h1 class="h2 pt-xl-1 pb-1" style='color:#11044a'><i class='bx bx-lock-open-alt bx-flashing'></i> B I E N V E N I D O</h1></div>
                    <img src="../../../public/assets/img/services/single/map.png" alt="Map">
                </div>

        </div>
      </div>
</section>
</main>
</body>
</template>

<script>
import Main from "./Main.vue"
import Admin from "@/Jetstream/Admin.vue";
import Profe from "@/Jetstream/Profe.vue";
import Head from '@/Jetstream/Head.vue';
import Revisor from '@/Jetstream/Revisor.vue';
import Alumno from '@/Jetstream/Alumno.vue';
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import { defineComponent } from 'vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

export default defineComponent({
  name:"Dashboard",
  props: {
    user:{type: Object, required: true},
    instituto: { type: Object, required: true },
    subtematicas: { type: Object, required: true },
    tematicas: { type: Object, required: true },
    tematica: { type: Object, required: true },
    instituciones: { type: Object, required: true },
  },
  components: {
    Main,
    Admin,
    Profe,
    Head,
    Alumno,
    Revisor,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
  },

    methods: {
        downloadBackup() {
            window.location.href = '/backup';
        },

        logout() {
           this.$inertia.post(route('logout'));
        }
    },

});

</script>

<style>
h1{
  text-align: center;
  color: rgb(4, 4, 68);
}



</style>


