<template>
    <Head>   </Head>

    <Alumno> </Alumno>

  <body>
    <div class="forma1">
    <h2 class="h4 font-weight-bold">
        <i class="boxi1 bi bi-card-checklist" style='color:#030664'>&nbsp;</i> Tus Solicitudes
      </h2><hr><br>
        <div class="alert d-flex alert-info" role="alert">
            <i class="bx bx-info-circle lead me-3"></i>
            <div>
                Podrás visualizar tus solicitudes que has enviado y el estado en el que se encuentran.
            </div>
        </div>
      <br><br><div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="col">Nombre del proyecto</th>
                  <th class="col">Estado</th>
                  <th class="col">Prioridad</th>
                </tr>
              </thead>
              <tbody v-for="item in solicitudes" :key="item.id">
                <tr>
                  <td>{{ item.proyecto.title}}</td>
                  <td>{{ item.status}}</td>
                  <td v-if="item.priority === 1">Mayor prioridad</td>
                  <td v-if="item.priority === 2">Media prioridad</td>
                  <td v-if="item.priority === 3">Menor prioridad</td>
                </tr>
              </tbody>
            </table>
        </div>
    <a :href="route('dashboard')"><button id="cuenta" type="button" class="ms-4 add btn btn-danger"><i class='boxi3 bx bx-arrow-back' style='color:#ffffff' >&nbsp</i> Volver</button></a>
  </div>
</body>
  </template>

  <script>
  import { Link } from "@inertiajs/inertia-vue3";
  import Pagination from "@/Shared/Pagination.vue";
  import RecordsHelper from "@/Shared/RecordsHelper.vue";
  import { computed, onMounted, reactive, toRefs, watch } from "vue";
  import { Inertia } from "@inertiajs/inertia";
  import Input from "@/Jetstream/Input.vue";
  import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
  import { ref } from "vue";
  import Swal from 'sweetalert2';
  import { useForm } from "@inertiajs/inertia-vue3";
  import JetLabel from "@/Jetstream/Label.vue";
  import JetInput from "@/Jetstream/Input.vue";
  import JetInputError from "@/Jetstream/InputError.vue";
  import JetButton from "@/Jetstream/Button.vue";
  import 'sweetalert2/dist/sweetalert2.min.css';
  import Alumno from "@/Jetstream/Alumno.vue";
  import Head from '@/Jetstream/Head.vue';
  export default {

    props: {
      titulo: { type: String, required: true },
      solicitudes: { type: Object, required: true },
      exp: { type: String, required: true },
    },

    components: {
            Alumno,
            Head,
            Link,
            RecordsHelper,
            Pagination,
            Input,
            JetDropdownLink,
            JetLabel,
            JetInput,
            JetInputError,
            JetButton,
      },

    setup(props) {
      const form = useForm({
        requestform: "",
        academicdoc: "",
        motivedoc: "",
        ine: "",
        cvu: "",
        foto: "",
        ver:"",
      });

      const guardar = () => {
        form.post(route("docuser.store"));
      };

      return {guardar, form};
    },



  }
  </script>
  <style scoped>

  .forma1{
  width: 85%;
  border-radius: 20px;
  /*sizing: border-box;*/
  background-color: #ffffff;
  margin-top: 10%;
  margin-left: 8%;
  }

  .alert{
    width: 60%;
  }

  body{
    margin: 0;
  }

  p{
    margin-bottom: 0 ;
    font-size: 15px;
  }

  .h2pro{
    margin-bottom: 0;
  }

    h2{
    font-size: 30px;
    text-align: center;
    font-weight: bolder;
    color: rgb(5, 5, 107);
    margin-top: -22px;
    }


  .boxi{
    font-size: 20px;
  }

  th{
    width: 10%;
  }

  table{
    width: 50%;
    text-align: center;
    margin-left: 20%;
  }

  a{
    text-decoration: none;
  }

  .aceptado{
    background-color: green;
    color: #ffffff;
    border-radius:10px;
    font-weight: bold;
    font-size: 20px;
    padding: 5px 10px 5px 10px;
  }

  .rechazado{
    background-color: red;
    color: #ffffff;
    border-radius:10px;
    font-weight: bold;
    font-size: 20px;
    padding: 5px 10px 5px 10px;
  }

  .estado{
    font-weight: bold;
    font-size: 30px;
  }

  </style>
