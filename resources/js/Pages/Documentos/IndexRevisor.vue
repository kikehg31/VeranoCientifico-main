<template>
    <Head></Head>
    <Revisor> </Revisor>
  <body>
    <div class="forma1">
        <jet-validation-errors class="mb-3"/>
        <div class="formulario forma2">
            <br>
            <h2><i class='bx bxs-up-arrow-square bx-flashing' style='color:#04023f' ></i> Revisión de expedientes</h2><hr><br>
            <div v-if="$page.props.flash.success" class="msj alert d-flex alert-success" role="alert">
                <i class="bx bx-check-circle lead me-3"></i>
                <a href="#" class="alert-link">{{ $page.props.flash.success }}</a>
            </div>
            <div class="msj alert d-flex alert-info" role="alert">
                <i class="bx bx-info-circle lead me-3"></i>
              <div>
                A continuación se muestran los expedientes de los alumnos de su institución {{datos}}
              </div>
            </div>
            <p>.</p><br>
            <div   class="table-responsive">
                <table v-if="datos === ''"  class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="30%" class="col">Nombre del Alumno</th>
                            <th width="30%" class="col">Estado de Expediente</th>
                            <th width="10%" class="col">Ver</th>
                        </tr>
                    </thead>
                    <tbody v-for="item in expedientes.data" :key="item.id" >
                        <tr v-if="item.expediente.status != 'Documentos Subidos'">
                            <td>{{ item.name+' '+ item.lastnamep+' '+item.lastnamem }}</td>

                            <td ><label v-if="item.expediente.status === 'En Revisión'" class="revision">{{ item.expediente.status }}</label>
                            <label  v-if="item.expediente.status === 'Aceptado'" class="aceptado">{{ item.expediente.status  }}</label>
                            <label v-if="item.expediente.status === 'Rechazado'" class="rechazado">{{ item.expediente.status  }}</label></td>
                            <td>
                                <a :href="route('docuser.edit', item.id)">
                                    <button title="Ver" :href="item.url" class="btn btn-info btn-sm">
                                        <i class='boxi bi bi-eye-fill' style='color:#ffffff' ></i>
                                    </button>&nbsp;&nbsp;
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
            <a :href="route('dashboard')"><button id="cuenta" type="button"
            class="volver ms-4 add btn btn-danger"><i id="boxi3"
            class='bx bx-arrow-back' style='color:#ffffff' ></i>&nbsp;&nbsp;Volver</button></a>
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
      datos: {type: String, required: true},
      expedientes: { type: Object, required: true },
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

      const guardar = () => {

        form.put(route("docuser.update", props.alumn));
      };

      return {guardar};
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

  h2{
  text-align: center;
  color:#04023f;
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

  table{
    width: 70%;
    text-align: center;
    margin-left: 20%;
  }

  .volver{
    margin-top: 5%;
    margin-bottom: 5%;
  }

  .msj{
    width: 60%;
  }

    .aceptado{
    background-color: green;
    color: #ffffff;
    border-radius:10px;
    font-size: 16px;
    padding: 5px 10px 5px 10px;
  }

  .rechazado{
    background-color: red;
    color: #ffffff;
    border-radius:10px;
    font-size: 16px;
    padding: 5px 10px 5px 10px;
  }

  .revision{
    background-color: orange;
    color: #ffffff;
    border-radius:10px;
    font-size: 16px;
    padding: 5px 10px 5px 10px;
  }

  .estado{
    font-weight: bold;
    font-size: 30px;
  }
  </style>
