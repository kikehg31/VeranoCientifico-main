<template>
<Head>   </Head>
  <Admin v-if="$page.props.user.id_rol == 1"> </Admin>
  <Profe v-if="$page.props.user.id_rol == 2"></Profe>
  <Alumno v-if="$page.props.user.id_rol == 4"> </Alumno>
  <Revisor v-if="$page.props.user.id_rol == 3"></Revisor>

<body>
  <main class="page-wrapper">
   <section class="container pt-4">
        <div class="row">
          <aside class="col-lg-3 col-md-4 border-end pb-5 mt-n5">
            <div class="position-sticky top-0">
              <div class="text-center pt-5">
                <div class="d-table position-relative mx-auto mt-2 mt-lg-4 pt-5 mb-3">
                  <img :src="$page.props.user.photo" class="d-block rounded-circle" ref="photo"  width="120" alt="John Doe">
                </div>
                <h2 class="h5 mb-1">{{ $page.props.user.name}} {{ $page.props.user.lastnamep}} {{ $page.props.user.lastnamem }}</h2>
                <p class="mb-3 pb-3">{{ $page.props.user.email}}</p>
                <button type="button" class="btn btn-secondary w-100 d-md-none mt-n2 mb-3" data-bs-toggle="collapse" data-bs-target="#account-menu">
                  <i class="bx bxs-user-detail fs-xl me-2"></i>
                  Menú
                  <i class="bx bx-chevron-down fs-lg ms-1"></i>
                </button>
                <div id="account-menu" class="list-group list-group-flush collapse d-md-block">
                  <a href="/dashboard" class="list-group-item list-group-item-action d-flex align-items-center ">
                    <i class="bi bi-house fs-xl opacity-60 me-2"></i> &nbsp;
                    Bienvenido
                  </a>
                  <a :href="route('registro.edit', $page.props.user.id)" class="list-group-item list-group-item-action d-flex align-items-center ">
                    <i class="bi bi-person-gear fs-xl opacity-60 me-2"></i>&nbsp;
                    Detalles de la cuenta
                  </a>
                  <a :href="route('profile.show', $page.props.user.id)" class="list-group-item list-group-item-action d-flex align-items-center active">
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
                  <a href="account-signin.html" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-box-arrow-left fs-xl opacity-60 me-2"></i>&nbsp;
                    Cerrar sesión
                  </a>
                </div>
              </div>
            </div>
          </aside>
        <div class="col-md-8 offset-lg-md-1 pb-5 mb-2 mb-lg-1 pt-md-5 mt-n3 mt-md-0">
            <div class="ps-md-4 ps-lg-5 mt-md-4 py-md-4">
                <h1 class="h2 pt-xl-1 pb-3" style='color:#11044a'><i class='bx bx-lock bx-flashing' style='color:#11044a'></i> Actualizar Contraseña</h1><hr><br>
                    <div v-if="$page.props.flash.success" class="alert d-flex alert-success" role="alert">
                        <i class="bx bx-check-circle lead me-3"></i><a href="#" class="alert-link">{{ $page.props.flash.success }}</a>
                    </div>
                <form class="tex needs-validation border-bottom pb-3 pb-lg-4" @submitted="updatePassword">


      <div class="row pb-4">
        <div class="col-sm-6 mb-4">
          <jet-label class="form-label fs-base" for="current_password" value="Current Password" />
          <jet-input id="current_password" type="password" class="form-control form-control-lg"
                     :class="{ 'is-invalid': form.errors.current_password }" v-model="form.current_password" ref="current_password" autocomplete="current-password" />
          <jet-input-error :message="form.errors.current_password" class="mt-2" />
        </div>

        <div class="col-sm-6 mb-4">
          <jet-label class="form-label fs-base" for="password" value="New Password" />
          <jet-input id="password" type="password" class="form-control form-control-lg"
                     :class="{ 'is-invalid': form.errors.password }" v-model="form.password" autocomplete="new-password" />
          <jet-input-error :message="form.errors.password" class="mt-2" />
        </div>

        <div class="col-sm-6 mb-4">
          <jet-label class="form-label fs-base" for="password_confirmation" value="Confirm Password" />
          <jet-input class="form-control form-control-lg" id="password_confirmation" type="password"
                     :class="{ 'is-invalid': form.errors.password_confirmation }" v-model="form.password_confirmation" autocomplete="new-password" />
          <jet-input-error :message="form.errors.password_confirmation" class="mt-2" />
        </div>
      </div>

      <button @click="updatePassword" class="button ml-4 text-xl" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
        <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <i class="bi bi-save"></i> &nbsp Guardar
      </button>
 
  </form>
            </div>
          </div>
        </div>
</section>
</main>
</body>
</template>

<script>
import { defineComponent } from 'vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import Admin from "@/Jetstream/Admin.vue";
import Profe from "@/Jetstream/Profe.vue";
import Head from '@/Jetstream/Head.vue';
import Revisor from '@/Jetstream/Revisor.vue';
import Alumno from '@/Jetstream/Alumno.vue';
import { useForm } from "@inertiajs/inertia-vue3";

export default defineComponent({
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    Admin,
    Head,
    Profe,
    Alumno,
    Revisor
  },

    props: {
    user:{type: Object, required: true},
  },

  data() {
    return {
      form: this.$inertia.form({
        current_password: '',
        password: '',
        password_confirmation: '',
      }),
    }
  },

  methods: {
    updatePassword() {
      this.form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => this.form.reset(),
        onError: () => {
          if (this.form.errors.password) {
            this.form.reset('password', 'password_confirmation')
            this.$refs.password.focus()
          }

          if (this.form.errors.current_password) {
            this.form.reset('current_password')
            this.$refs.current_password.focus()
          }
        }
      })
    },
  },
})
</script>

<style>
h1{
    text-align: center;
}

  .button {
    background-color: rgb(23, 33, 123);
    color: #fff;
    padding: 0.7rem 1.5rem;
    border-radius: 0.25rem;
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.25), 0px 4px 4px rgba(0, 0, 0, 0.15), 0px 8px 8px rgba(0, 0, 0, 0.1), 0px 16px 16px rgba(0, 0, 0, 0.05);
    }
    
.button:hover {
    background-color: #5b69c5;
}

.button:active {
    background-color: #4c59a3;
}
</style>
