<template>
  <Head> </Head>

  <Profe> </Profe>

    <div class="contenido">
              <div class="forma1">
                <h2 style='color:#04023f' class="h4 font-weight-bold text-center">
                  <br><i class="bi bi-bricks"></i> {{ titulo }}
                </h2>
                <p>
                  <br>El alumno <strong>{{alumno.name}} {{alumno.lastnamep}} {{alumno.lastnamem}}</strong> quiere participar
                  en el proyecto: <strong>{{proyecto.title}}</strong>.
                </p>
                <div class="card-body border-right border-bottom p-3 h-100">
                  <jet-label class="label form-label fs-base" value="CVU del estudiante: " />&nbsp;&nbsp;
                  <a :href="cvu" target="_blank"><button type="button" title="Ver" class="btn btn-info btn-sm">
                    <i class='boxi bi bi-eye-fill' style='color:#ffffff'></i>
                </button></a>&nbsp;&nbsp;<br><br><br>
              
                <button @click="guardar('Aceptado')" type="submit" title="Aceptar Alumno" class="btn btn-success btn-sm">
                    <i class="bi bi-check-circle-fill"></i>&nbsp; Aceptar
                </button>&nbsp;&nbsp;&nbsp;&nbsp;<button @click="guardar('Rechazado')" type="button" title="Rechazar Alumno" class="btn btn-danger btn-sm">
                    <i class="bi bi-x-circle-fill"></i>&nbsp; Rechazar
                </button></div>
            </div>
    </div>
</template>

  <script>
import { defineComponent } from 'vue'
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Link } from '@inertiajs/inertia-vue3'
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import axios from 'axios';
import AppLayout from "@/Layouts/AppLayout.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetButton from "@/Jetstream/Button.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import Profe from "@/Jetstream/Profe.vue";
import Head from "@/Jetstream/Head.vue";


  export default {
    name: "Create",
    props: {
      titulo: { type: String, required: true },
      routeName: { type: String, required: true },
      tematica: {type:Object, required:true},
      subtematica: {type:Object, required:true},
      idlog: {type:Object, required:true},
      idinstlog: {type:Object, required:true},
      cvu: { type: String, required: true },
      alumno: {type:Object, required:true},
      proyecto: {type:Object, required:true},
    },
    components: {
      AppLayout,
      Link,
      Profe,
      JetLabel,
      Head,
      JetInput,
      JetInputError,
      JetButton,
      JetDropdownLink,
    },
    setup(props) {
      const form = useForm({
        seleccion: "",
        alumno: props.alumno.id,

      });

      const guardar = (sel) => {
        if(sel == 'Aceptado'){
            form.seleccion = 'Aceptado';
        }
        if(sel == 'Rechazado'){
            form.seleccion = 'Rechazado';
        }

        form.put(route("proyectospro.update", props.proyecto.id));
      };

      return { form, guardar };
    },

    methods: {
        logout() {
        this.$inertia.post(route('logout'));
        },

      },

  };

  </script>

  <style scoped>

        .forma1{
        width: 65%;
        border-radius: 20px;
        box-sizing: border-box;
        background-color: #ffffff;
        margin-top: 10%;
        margin-left: 17%;
        box-shadow: 19px 14px 14px 20px #cbced1, -14px -14px 20px rgba(216, 213, 213, 0.137);
        }

        a{
          text-decoration: none;
        }

        p{
          color: #000000;
          margin-left: 15px;
        }

        .boxi{
          font-size: 18px;
        }

  </style>

