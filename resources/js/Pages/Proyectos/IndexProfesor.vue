<template>
    <Head>   </Head>

    <Profe> </Profe>


  <body>
    <div class="forma1">

        <jet-validation-errors class="mb-3"/>
        <div class="formulario forma2">
            <br>
            <h2><i class='bx bxs-up-arrow-square bx-flashing' style='color:#04023f' ></i> Selección de Alumnos</h2><hr><br>
            <div v-if="$page.props.flash.message" class="msj alert d-flex alert-warning" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>&nbsp;
                <a href="#" class="alert-link">{{ $page.props.flash.message }}</a>
            </div>
            <div class="msj alert d-flex alert-info" role="alert">
              <i class="bx bx-info-circle lead me-3"></i>
            <div>
              A continuación se muestran los alumnos que se han postulado ha sus proyectos.
              <li>Aceptado: El alumno ha sido aceptado en tu proyecto</li>
              <li>Rechazado: El alumno ha sido rechazado en tu proyecto</li>
              <li>En Revisión: No ha sido atendida la solicitud</li>
              <li>No aplica: El alumno ya ha sido seleccionado en otro proyecto</li>


            </div>
            </div>
            <div v-if="$page.props.flash.success" class="alert d-flex alert-success" role="alert">
                <i class="bx bx-check-circle lead me-3"></i>
                <a href="#" class="alert-link">{{ $page.props.flash.success }}</a>
            </div>
            <div class="table-responsive"><br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="25%" class="col">Nombre del Alumno</th>
                            <th width="35%" class="col">Proyecto Solicitante</th>
                            <th width="15%" class="col">Estado</th>
                            <th width="15%" class="col">Correo Alumno</th>
                            <th width="15%" class="col">Ver</th>
                        </tr>
                    </thead>
                    <tbody v-for="proyecto in solicitudes.data" :key="proyecto.id">
                        <tr>
                            <td>{{ proyecto.alumnos.name }} {{ proyecto.alumnos.lastnamep }} {{ proyecto.alumnos.lastnamem }}</td>

                            <td>{{ proyecto.proyecto.title  }}</td>


                            <td v-if="proyecto.status === 'En Revisión'"><label class="revision">{{ proyecto.status }}</label></td>
                            <td v-if="proyecto.status === 'No Aplica'"><label class="rechazado">{{ proyecto.status }}</label></td>
                            <td v-if="proyecto.status === 'Aceptado'"><label class="aceptado">{{ proyecto.status  }}</label></td>
                            <td v-if="proyecto.status === 'Rechazado'"><label class="rechazado">{{ proyecto.status  }}</label></td>

                            <td>{{ proyecto.alumnos.email }}</td>

                            <td >
                                <a v-if="proyecto.status == 'En Revisión'" :href="route('proyectospro.edit', proyecto.id)" target="_blank">
                                    <button title="Ver" class="btn btn-info btn-sm">
                                        <i class='boxi bi bi-eye-fill' style='color:#ffffff' ></i>
                                    </button>&nbsp;&nbsp;
                                </a>
                                <label v-if="proyecto.status != 'En Revisión'" class="listo">Listo</label>
                            </td>
                        </tr>
                    </tbody>
                </table>


        </div>
        <pagination :links="solicitudes.links" :total="solicitudes.total" class="pagination" /><br><br>

            <a :href="route('dashboard')"><button id="cuenta" type="button" class="ms-4 add btn btn-danger"><i id="boxi3" class='bx bx-arrow-back' style='color:#ffffff' ></i>&nbsp;&nbsp;Volver</button></a>

        </div>

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
  import Profe from "@/Jetstream/Profe.vue";
  import Head from '@/Jetstream/Head.vue';
  export default {

    props: {
      titulo: { type: String, required: true },
      docs: { type: Object, required: true },
      alumn: { type: String, required: true },
      status: {type: String, required: true},
      solicitudes: { type: Object, required: true },
      docs: { type: Object, required: true },
    },


    components: {
            Profe,
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
        status: '',
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

    .msj{
    width: 60%;
  }

  td, th {
  text-align: center;
  vertical-align: middle;
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
  .h2pro{
    margin-bottom: 0;
  }

  a{
    text-decoration: none;
  }

  button[id="cuenta"]{
    text-decoration: none;
  }

  table {
  text-align: center;
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

.aceptado{
    background-color: green;
    color: #ffffff;
    border-radius:10px;
    font-size: 16px;
    padding: 5px 10px 5px 10px;
  }
.listo{
    background-color: rgb(25, 25, 112)
;
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
