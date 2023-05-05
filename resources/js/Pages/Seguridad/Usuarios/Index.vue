<template>
  <Admin> </Admin>
    <div class="contenido">
      <div class="forma1">
        <h2 class="h4 font-weight-bold">
          <i class='boxi bx bx-book' style='color:#030664' ></i> {{ titulo }}
        </h2><hr>
        <div class="col-md-12 pe-0">
          <div class="card-body border-right border-bottom p-3 h-100">
            <div v-if="$page.props.flash.success" class="alert d-flex alert-success" role="alert">
                <i class="bx bx-check-circle lead me-3"></i>
                <a href="#" class="alert-link">{{ $page.props.flash.success }}</a>
              </div>
            <div class="mb-2 d-flex justify-content-start">
              <Link
                :href="route(`${routeName}create`)"
                class="add btn btn-sm" >
              <i class="bi bi-plus-circle"></i> <p class="text-add">
                Agregar Usuarios</p>
              </Link>
              <form @submit.prevent="filtrar" class="d-flex-row d-md-inline-flex flex-nowrap align-items-center flex-grow-1">
                    <select class="form-select form-select-sm" v-model="form.profile">
                        <option value="null">Seleccione una opción</option>
                        <option v-for="profile in profiles" v-bind:value="profile.id" v-bind:key="profile.id" v-text="profile.name"></option>
                    </select>
                    <input
                        type="text"
                        class="form-control form-control-sm mr-1 mb-2 mb-md-0"
                        placeholder="Búsqueda por nombre o correo electrónico"
                        v-model="form.search"
                    />
                    <button
                        class="btn btn-outline-primary btn-sm mb-2 mb-md-0 w-auto"
                        type="submit"
                        :class="[thereAreFilter() ? 'd-inline-flex align-items-center' : 'd-none']"
                        >
                        <i class="bi bi-funnel"/>&nbsp;Buscar
                    </button>
                    <button class="btn btn-outline-secondary btn-sm d-inline-flex w-auto align-items-center mb-2 mr-1 mb-md-0" type="button" @click="limpiarFiltro()">
                        <i class="bi bi-eraser"></i>&nbsp;Limpiar
                    </button>
              </form>
            </div><br>

            <div class="table-responsive">
              <table class="table table-bordered border-primary">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Ver</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                  <tr v-for="item in usuarios.data" :key="item.id">
                    <td>
                      <Link
                        :href="route('usuarios.edit', item.id)"
                        class="d-flex text-decoration-none text-reset"
                        >{{ item.name }} {{ item.lastnamep }} {{ item.lastnamem }}</Link
                      >
                    </td>
                    <td>
                      <Link
                        :href="route('usuarios.edit', item.id)"
                        class="d-flex text-decoration-none text-reset"
                        >{{ item.email }}</Link
                      >
                    </td>
                    <td>
                        <Link :href="route('usuarios.edit', item.id)" class="d-flex text-decoration-none text-reset">
                            {{ item.roles.map( r => r.name ).join(', ') }}
                        </Link>
                    </td>
                    <td>
                      <button class="btn1 btn btn-warning btn-sm" >
                        <a :href="route('usuarios.edit', item.id)">
                          <i class="lapiz bi bi-eye"></i>
                        </a></button>
                    </td>
                    <td>
                      <button class="btn1 btn btn-info btn-sm" >
                        <a :href="route('usuarios.edit', item.id)">
                        <i class="lapiz bi bi-pencil-fill">
                        </i></a></button>
                    </td>
                    <td>
                    <form action="">
                      <button class="btn1 btn btn-danger btn-sm" type="button"  @click="eliminar(item.id)" >
                          <i class="basura bi bi-trash-fill"></i>
                      </button>
                    </form>
                    </td>

                  </tr>
                </tbody>
              </table>
            </div>
            <pagination :links="usuarios.links" :total="usuarios.total" class="pagination" />
            <RecordsHelper
            :thereAreResults="thereAreResults"
            :loadingResults="loadingResults"
          />
          </div>
        </div>
      </div>
    </div>

</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm} from "@inertiajs/inertia-vue3";
import Pagination from "@/Shared/Pagination.vue";
import RecordsHelper from "@/Shared/RecordsHelper.vue";
import { computed, onMounted, reactive, toRefs, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Input from "@/Jetstream/Input.vue";
import { ref } from "vue";
import Admin from "@/Jetstream/Admin.vue";
import 'sweetalert2/dist/sweetalert2.min.css';
import Swal from 'sweetalert2';


export default {
  name: "Index",
  props:{
    titulo: { type: String, required: true },
    usuarios: {
      type: Object,
      default: {},
      required: true,
    },
    profiles: {
      type: Object,
      default: {},
      required: true,
    },
    filtro: {
      type: Object,
      default: {},
      required: true,
    },
    routeName: { type: String, required: true },
    loadingResults: { type: Boolean, required: true, default: true }
  },
  components: {
    AppLayout,
    Link,
    Pagination,
    RecordsHelper,
    Input,
    Admin,
    Swal
  },
  setup(props) {
    const form = useForm({ ...props.filtro });
    const thereAreResults = computed(() => props.usuarios.total > 0);
    const filtrar = () => form.get(route('usuarios.index'));

    const search = () => {
      props.loadingResults = true;
      Inertia.replace(route(`${props.routeName}index`, state.filters));
    };

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
                form.delete(route("usuarios.destroy", idel));
              }
            });
          };

    return {
      form,
      search,
      eliminar,
      thereAreResults,
      thereAreFilter: () => computed(() => form.profile).value,
      filtrar,
      limpiarFiltro: () => {
                form.profile = null;
                form.search = null;
                filtrar();
            },
    };


  },
};
</script>

<style scoped>

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
</style>
