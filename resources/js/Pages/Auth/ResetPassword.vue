<template>
  <Head title="Reset Password" />

  <br><img src="../../../../public/img/logo.png" width="">

  <jet-authentication-card>
    <div class="card card-body">
      
      <jet-validation-errors class="mb-4" />

      <div v-if="status" class="alert alert-success" role="alert">
        {{ status }}
      </div>

      <form @submit.prevent="updatePassword">
        <div class="col-sm-12 mb-3">
          <jet-label for="email" value="Email" />
          <jet-input id="email" type="email" v-model="form.email" required autofocus :class="{ 'is-invalid': form.errors.email }" />
        </div>

        <div class="col-sm-12 mb-3">
          <jet-label for="password" value="Password" />
          <jet-input id="password" type="password" v-model="form.password" required autocomplete="new-password" :class="{ 'is-invalid': form.errors.password }" />
          <jet-input-error :message="form.errors.password" />
        </div>

        <div class="col-sm-12 mb-3">
          <jet-label for="password_confirmation" value="Confirm Password" />
          <jet-input id="password_confirmation" type="password" v-model="form.password_confirmation" required autocomplete="new-password" :class="{ 'is-invalid': form.errors.password_confirmation }"/>
          <jet-input-error :message="form.errors.password_confirmation" />
        </div>

        <!----<div class="mb-3">
          <jet-label for="password" value="Password" />
          <jet-input id="password" type="password" v-model="form.password" required autocomplete="new-password" />
        </div>

        <div class="mb-3">
          <jet-label for="password_confirmation" value="Confirm Password" />
          <jet-input id="password_confirmation" type="password" v-model="form.password_confirmation" required autocomplete="new-password" />
        </div>-->

        <div class="mb-0">
          <div class="d-flex justify-content-end">
            <jet-button class="boton" 
            :class="{ 'text-white-50': form.processing }" 
            :disabled="form.processing"
            >
              <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              Reset Password
            </jet-button>
          </div>
        </div>
      </form>
    </div>
  </jet-authentication-card>
</template>

<script>
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3'
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import axios from 'axios';

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
    email: String,
    token: String,
    status: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        token: this.token,
        email: this.email,
        password: '',
        password_confirmation: '',
        message:''
      })
    }
  },

  methods: {
    updatePassword() {
      this.form.post(this.route('password.update'), {
        onFinish: () => this.form.reset('password', 'password_confirmation'),
      })
    },
  },
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

.boton{
  background-color: #070846;
  }

.boton:hover{
  background-color: #0a0daf;
}

.card{
  margin-top: -15px;
}
</style>
