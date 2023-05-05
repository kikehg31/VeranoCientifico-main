<template>
  <Head title="Forgot Password" />

  <br><img src="../../../../public/img/logo.png" width="">

  <jet-authentication-card >
   <br><h2>¿Olvidaste tu contraseña?</h2><hr>
    <div class="card card-body">
      <div class="mb-2">
        No hay problema. Simplemente háganos saber su dirección de correo electrónico y le enviaremos un enlace de restablecimiento de contraseña que le permitirá elegir una nueva.
      </div><br>

      <div v-if="status" class="alert alert-success" role="alert">
        {{ status }}
      </div>

      <jet-validation-errors class="mb-2" />

      <form @submit.prevent="submit">
        <div class="col-sm-12 mb-3">
          <jet-label for="email" value="Correo Electrónico:" />
          <jet-input id="email" type="email" v-model="form.email" required autofocus :class="{ 'is-invalid': form.errors.email }"/>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <jet-button class="boton" 
          :class="{ 'text-white-50': form.processing }" 
          :disabled="form.processing"
          >
            <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
              <span class="visually-hidden">Loading...</span>
            </div><i class='bx bx-mail-send' style='color:#fdfbfb'></i>
             Resetear Password
          </jet-button>
        </div>
      </form>
    </div>
  </jet-authentication-card>
</template>

<script>
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

export default defineComponent({
  components: {
    Head,
    JetAuthenticationCard,
    JetAuthenticationCardLogo,
    JetButton,
    JetInput,
    JetLabel,
    JetValidationErrors
  },

  props: {
    status: String
  },

  data() {
    return {
      form: this.$inertia.form({
        email: ''
      })
    }
  },

  methods: {
    submit() {
      this.form.post(this.route('password.email'))
    },
  }
})
</script>
<style>

img{
  width: 80px;
  margin-left: 48%;
}

h2{
  text-align: center;
  font-weight: bolder;
  }

.card{
  margin-top: -42px;
}

.boton{
  background-color: #070846;
  }

.boton:hover{
  background-color: #0a0daf;
}

</style>
