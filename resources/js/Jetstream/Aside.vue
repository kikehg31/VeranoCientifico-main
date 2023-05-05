<template>
     <Head> </Head>
<body>
  <div class="page-wrapper">
    <section class="container pt-5">
      <div class="row">
        <aside class="col-lg-3 col-md-4 border-end pb-5 mt-n5">
            <div class="position-sticky top-0">
              <div class="text-center pt-5">
                <div class="d-table position-relative mx-auto mt-2 mt-lg-4 pt-5 mb-3">
                  <img :src="user.profile_photo_url" class="d-block rounded-circle" ref="photo"  width="120" alt="John Doe">
                  <button  type="button" class="btn btn-icon btn-light bg-white btn-sm border rounded-circle shadow-sm position-absolute bottom-0 end-0 mt-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Change picture">
                    <i class="bx bx-refresh"></i>
                  </button>
                </div>
                <h2 class="h5 mb-1">{{ $page.props.user.name}} {{ $page.props.user.lastnamep}} {{ $page.props.user.lastnamem }}</h2>
                <p class="mb-3 pb-3">{{ $page.props.user.email}}</p>
                <button type="button" class="btn btn-secondary w-100 d-md-none mt-n2 mb-3" data-bs-toggle="collapse" data-bs-target="#account-menu">
                  <i class="bx bxs-user-detail fs-xl me-2"></i>
                  Menú
                  <i class="bx bx-chevron-down fs-lg ms-1"></i>
                </button>
                <div id="account-menu" class="list-group list-group-flush collapse d-md-block">
                  <a href="account-details.html" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bx bx-cog fs-xl opacity-60 me-2"></i>
                    Bienvenido
                  </a>
                  <a :href="route('registro.edit', $page.props.user.id )" class="list-group-item list-group-item-action d-flex align-items-center active">
                    <i class="bx bx-cog fs-xl opacity-60 me-2"></i>
                    Detalles de la cuenta
                  </a>
                  <a :href="route('profile.show')" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bx bx-lock-alt fs-xl opacity-60 me-2"></i>
                    Seguridad de la cuenta
                  </a>
                  <a href="account-notifications.html" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bx bx-bell fs-xl opacity-60 me-2"></i>
                    Notificaciones
                  </a>
                  <a href="account-signin.html" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bx bx-log-out fs-xl opacity-60 me-2"></i>
                    Cerrar sesión
                  </a>
                </div>
              </div>
            </div>
          </aside>
        
        </div>
  </section>
    </div>
    </body>
</template>
<script>
  import { Link } from '@inertiajs/inertia-vue3'
  import 'sweetalert2/dist/sweetalert2.min.css';
  import axios from 'axios';
  import AppLayout from "@/Layouts/AppLayout.vue";
  import JetLabel from "@/Jetstream/Label.vue";
  import JetInput from "@/Jetstream/Input.vue";
  import JetInputError from "@/Jetstream/InputError.vue";
  import JetButton from "@/Jetstream/Button.vue";
  import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
  import Head from '@/Jetstream/Head.vue';
  
    export default {
      name: "Create",
      props: {
        title: { type: String, required: true },
        routeName: { type: String, required: true },
      },
      components: {
        Link,
        JetLabel,
        JetInput,
        JetInputError,
        JetButton,
        JetDropdownLink,
        Head,
      },
    
      methods: {
          logout() {
          this.$inertia.post(route('logout'));
          }
        },
       
    };
    
</script>
<style></style>