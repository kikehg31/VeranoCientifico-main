<template>
  <Head title="Verificación de correo"/>
    <br><br><img src="../../../../public/img/logo.png" width="">

  <jet-authentication-card >
    <br><h2>Verificación de correo electrónico</h2><hr><hr><hr>
      <div class="card text-center">
      
      <div class="text">
        Gracias por registrarte! Antes de comenzar, deberá verificar su dirección de correo electrónico 
        haciendo clic en el enlace que le acabamos de enviar por correo electrónico.
        Si usted no recibió el correo, con gusto te enviaremos otro.
      </div>

      
      <form @submit.prevent="submit">
        <div class="mt-4 d-flex justify-content-between">
          <jet-button class="boton"
            :class="{ 'text-white-50': form.processing }"
            :disabled="form.processing"
            @click = "verificationLinkSent"
          >
            <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            Reenviar Link de Verificación
          </jet-button>

          <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="btn btn-link"
            >Salir</Link
          >
        </div>
      </form>
      </div>
  </jet-authentication-card>
</template>

<script>
import { defineComponent } from "vue";
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard.vue"
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo.vue"
import JetButton from "@/Jetstream/Button.vue"
import { Head, Link } from "@inertiajs/inertia-vue3"
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

export default defineComponent({
  components: {
    Head,
    JetAuthenticationCard,
    JetAuthenticationCardLogo,
    JetButton,
    Link
  },

  props: {
    status: String
  },

  data() {
    return {
      form: this.$inertia.form()
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("verification.send"));
    },

    verificationLinkSent(){
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Link reenviado',
        showConfirmButton: false,
        timer: 3500
      });
    }, 
  },
 
})
</script>
<style :scope>

  img{
    width: 80px;
    margin-left: 48%;
  }

  .card{
    margin-top: -55px;
  }

  .verificacion{
    box-shadow: 14px 14px 20px #cbced1, -14px -14px 20px rgba(216, 213, 213, 0.137);
  }

  h2{
    text-align: center;
    font-weight: bolder;
  }

  .boton{
    background-color: rgb(7, 8, 70);
  }

  .text{
    color: black;
  }

</style>
