<template>

  <Head> </Head>
  <Profe v-if="$page.props.user.id_rol == 2"> </Profe>

  <Admin v-if="$page.props.user.rol == 1"> </Admin>

<div class="contenido">
      <div class="forma1">
        <h2 class="h4 font-weight-bold">
        <i class='boxi bx bxs-notepad' style='color:#030664' ></i> Mis proyectos
        </h2><hr><br>
        <div class="col-md-12 pe-0">
          <div class="card-body border-right border-bottom p-3 h-100">
            <div class="mb-2 d-flex justify-content-start">
              <Link :href="route(`${routeName}create`)" class="add btn btn-sm">
              <i class="bi bi-plus-circle"></i> <p class="text-add">Agregar Proyecto</p>
              </Link>
              <div class="input-group w-50 ml-2">
                <input
                  type="text"
                  class="busqueda form-control form-control-sm form-control bg-light shadow-sm"
                  placeholder="Ingrese un parámetro de búsqueda"
                  v-model="filters.search"
                  @change="search"
                />
                <div class="input-group-append input-group-append-sm">
                  <button
                    @click="search"
                    class="btn btn-primary" type="button"
                  >
                    <i class="buscar bi bi-search"></i>
                  </button>
                </div>
              </div>
              <!---<select @change="search"
                class="custom-select-sm custom-select bg-light shadow-sm border-0 w-25 ml-2"
                v-model="filters.status">
                <option :value="true">Activos</option>
                <option :value="false">Eliminados</option>
              </select>-->
            </div><br>
            <div v-if="$page.props.flash.success" class="alert d-flex alert-success" role="alert">
                <i class="bx bx-check-circle lead me-3"></i>
                <a href="#" class="alert-link">{{ $page.props.flash.success }}</a>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered border-primary">
                <thead>
                  <tr>
                    <th class="col">Titulo</th>
                    <th class="col">Descripción</th>
                    <th class="col">Modalidad</th>
                    <th class="col">Alumnos Permitidos</th>
                    <th class="col">Alumnos Inscritos</th>
                    <th width="10%" class="col">Editar</th>
                    <th width="10%" class="col">Eliminar</th>
                  </tr>
                </thead>
                <tbody v-for="item in proyectos.data" :key="item.id">
                  <tr>
                    <td>{{ item.title  }}</td>
                    <td>{{ item.generalobject }}</td>
                    <td>{{ item.modality }}</td>
                    <td>{{ item.studentnum }}</td>
                    <td>{{ item.students }}</td>
                    <td><button class="btn btn btn-info btn-sm" >
                      <a :href="route('proyectos.edit', item.id)">
                      <i class="lapiz bi bi-pencil-fill">
                      </i></a></button>
                    </td>
                    <td>
                      <form action="">
                    <button
                    class="btn btn btn-danger btn-sm"
                    type="button"
                    @click="eliminar(item.id)">
                    <i class="basura bi bi-trash-fill"></i>
                  </button>
                </form>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <RecordsHelper
            :thereAreResults="thereAreResults"
            :loadingResults="loadingResults"
          />
            <pagination :links="proyectos.links" :total="proyectos.total" />

          </div>
        </div>
      </div>
    </div>
</template>


<script>
    import AppLayout from "@/Layouts/AppLayout.vue";
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
    import Admin from "@/Jetstream/Admin.vue";
    import Profe from "@/Jetstream/Profe.vue";
    import Head from "@/Jetstream/Head.vue";

    export default {
        name: "Index",
        props: {
            title: { type: String, required: true },
            routeName: { type: String, required: true },
            proyectos: { type: Object, required: true },
            loadingResults: { type: Boolean, required: true, default: true },
            search: { type: String, required: true },
            status: { type: Boolean, required: true, default: true },
        },
        components: {
            AppLayout,
            Link,
            RecordsHelper,
            Pagination,
            Input,
            JetDropdownLink,
            JetLabel,
            JetInput,
            JetInputError,
            JetButton,
            Admin,
            Profe,
        },

        methods: {
        logout() {
        this.$inertia.post(route('logout'));
        }
      },

        setup(props) {
          const form = useForm({ ...props.proyectos });
            const thereAreResults = computed(() => props.proyectos.total > 0);
            const state = reactive({
                filters: {
                    page: props.proyectos.current_page,
                    search: props.search,
                    status: props.status ?? 1,
                },
            });


            const eliminar = (idel) => {
              Swal.fire({
              title: "¿Esta seguro?",
              text: "Esta acción no se puede revertir",
              icon: "warning",
              showCancelButton: true,
              cancelButtonColor: "#d33",
              confirmButtonColor: "#3085d6",
              confirmButtonText: "Si!, eliminar registro!",
            }).then((res) => {
              if (res.isConfirmed) {
                form.delete(route("proyectos.destroy", idel));
              }
            });
          };

          const search = () => {
                props.loadingResults = true;
                Inertia.replace(route(`${props.routeName}index`, state.filters));
            };

          return {
                ...toRefs(state),
                search,
                thereAreResults,
                eliminar,
                form
            };
        },
    }
</script>


<style scoped>

  :root{
    --main-color: rgb(23, 33, 123);
    --second-color:rgba(29, 43, 172, 0.795);
    --black: #000000;
    --white: #ffffff;
  }

  h2{
    font-size: 30px;
    text-align: center;
    font-weight: bolder;
    color: rgb(5, 5, 107);
    margin-top: -22px;
    }

  .boxi{
    font-size: 30px;
  }

  table{
    text-align: center;
  }

  .forma1{
  width: 85%;
  border-radius: 20px;
  /*sizing: border-box;*/
  background-color: #ffffff;
  margin-top: 10%;
  margin-left: 8%;
  }

  .contenido{
    background-color: #ffffff;
  }

  .forma{
    padding: 0px;
  }

  [id="cuenta"]:hover{
    background-color: #c90c0cec;
    color: rgb(255, 255, 255);
    font-style: bold;
  }

  [id="btn"]:hover, [id="guardar"]:hover{
    background-color: rgba(6, 42, 107, 0.986);
    color: rgb(255, 255, 255);
    font-style: bold;
  }

  [id="btn"]{
    background-color: #092252;
    color: rgb(255, 255, 255);
    width: 16%;
    border-radius: 10px;
    padding: 12px;
    margin-left: 40px;
    margin-right: -8%;
  }

  [id="guardar"]{
    background-color: #092252;
    color: rgb(255, 255, 255);
    width: 16%;
    padding: 12px;
    margin-left:10%;
    border-radius: 10px;
    margin-right: -8%;
    outline: none;
    border: #092252;
  }

  /*Tabla */

  .col{
    text-align:center;
  }

  a{
    text-decoration: none;
  }

  .lapiz{
    font-size: 18px;
    color: #ffffff;
  }

  .basura{
    font-size: 18px;
    color: #ffffff;
  }
  .add{
    font-size: 15px;
  }

  .text-add{
    font-size: 12px;
    margin-left: 10px;
  }

  .add{
  background-color: rgb(3, 4, 112);
  }

.add:hover{
  background-color: rgb(5, 7, 145);
}

  .busqueda{
    margin-left: 10px;

  }

  p{
    margin-bottom: 0 ;
    font-size: 18px;
  }
  td, th {
  text-align: center;
  vertical-align: middle;
}

</style>
