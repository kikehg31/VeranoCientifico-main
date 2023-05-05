<template>
    <Head>   </Head>
    <Revisor> </Revisor>

  <body>
    <div class="forma1">
        <jet-validation-errors class="mb-3"/>
        <div class="formulario forma2">
            <form @submit.prevent="guardar">
            <br><h2><i class='bx bxs-up-arrow-square bx-flashing' style='color:#04023f' ></i> Revisión de expediente.</h2><hr><br>
             <div class="msj alert d-flex alert-warning" role="alert">
                <i class="bx bx-error lead me-3"></i>
              <div>
                A continuación se pide verificar cuidadosamente cada uno de los documentos que le ha enviado el alumno.
              </div>
            </div><br>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="30%" class="col">Documento</th>
                            <th width="30%" class="col">Ver</th>
                        </tr>
                    </thead>
                    <tbody v-for="item in docs" :key="item.id">
                        <tr>
                            <td>{{ item.name}}</td>

                            <td>
                                    <a :href="item.url" target="_blank"><button type="button" title="Ver" class="btn btn-info btn-sm">
                                        <i class='boxi bi bi-eye-fill' style='color:#ffffff' ></i>
                                    </button>&nbsp;&nbsp; </a>

                            </td>
                        </tr>
                    </tbody>
                </table><br>
        </div>
        <div class="comments">
        <jet-label class="label form-label fs-base" value="Estado del Expediente: " /> &nbsp;&nbsp;
        <br>
        <input class="form-check-input" name="estado" value="Aceptado" type="radio" v-model="form.status">
        &nbsp;&nbsp;<jet-label class="form-check-label" value="Aceptado" />
        <br>

        <input class="form-check-input" name="estado" value="Rechazado" type="radio" v-model="form.status">
        &nbsp;&nbsp;<jet-label class="form-check-label" value="Rechazado" />

        <br><br>

        <jet-label class="label form-label fs-base" value="Observaciones Expediente: " /> &nbsp;&nbsp;
        <textarea class="form-control" rows="4" name="comentario" v-model="form.comments"></textarea>
        <br><br>
      </div>
    </form>
    <div class="info">
           <a :href="route('dashboard')"><button id="cuenta" type="button" class="ms-4 add btn btn-danger"><i id="boxi3" class='bx bx-arrow-back' style='color:#ffffff' ></i>&nbsp;&nbsp;Volver</button></a>

            <button id="guardar" class="ms-4 add btn btn-primary" :class="{ 'text-white-50': form.processing }">
              <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                 <span class="visually-hidden">Loading...</span>
               </div>
              <i id="boxi3" class="bi bi-save"></i>&nbsp;&nbsp; Guardar
            </button>

            <button @click="guardar" id="enviar" class="ms-4 add btn btn-info" :class="{ 'text-white-50': form.processing }">
              <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                 <span class="visually-hidden">Loading...</span>
               </div>
               <i id="boxi3" class='bx bx-send' style='color:#ffffff' ></i>&nbsp;&nbsp; Enviar
            </button>
      </div><br>
    </div>
  </div>
  </body>
  <div class="pie">
            <hr><br><br>
            <p>© Todos los derechos Reservados. Hecho con <i class='bx bxs-heart bx-flashing' style="color:#f30909" ></i> por el <a id="linktec" target="blank" href="https://cenidet.tecnm.mx/">TecNM/Cenidet</a></p><br><br>
    </div>
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
  import Revisor from "@/Jetstream/Revisor.vue";
  import Head from '@/Jetstream/Head.vue';
  export default {

    props: {
      titulo: { type: String, required: true },
      docs: { type: Object, required: true },
      alumn: { type: String, required: true },
      status: {type: String, required: true}
    },


    components: {
            Revisor,
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
        status: props.status,
        comments: '',
      });

      const guardar = () => {

        form.put(route("docuser.update", props.alumn));
      };

      return {guardar, form};
    },

  }
  </script>
  <style scoped>

  .forma1{
 width: 85%;
  border-radius: 20px;
  background-color: #ffffff;
  margin-top: 7%;
  margin-left: 8%;
  }

   table{
    width: 50%;
    text-align: center;
    margin-left: 20%;
  }

  h2{
  text-align: center;
  }

  .formulario{
    padding: 0px 0px 0px 20px;
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

  a{
    text-decoration: none;
  }

  button[id="cuenta"]{
    text-decoration: none;
  }

  .add{
    font-size: 15px;
  }

  .boxi{
    font-size: 18px;
  }

  .info{
    padding: -10px 20px 0px 0px;
  }

  .pestana{
    width: 40%;
    border-bottom: 1px solid rgb(12, 12, 12);
    background-color:rgb(3, 3, 51);
  }

  textarea{
    width: 60%;
  }

  .comments{
    margin-left: 10%;
  }

  .msj{
    width: 80%;
  }

  .pie{
    text-align: center;
    margin-top: -3%;
    color: white;
    background-color: #04023f;
  }

  a[id="linktec"]{
    color: white;
    background-color: #252440;
  }

  </style>
