<template>
  <Head>   </Head>

  <Admin v-if="$page.props.user.id_rol == 1"> </Admin>

<div class="contenido">
    <div class="forma1">
      <h2 class="h4 font-weight-bold">
        <i class='boxi bx bx-book' style='color:#030664' ></i> Temáticas Registradas
      </h2><hr><br>
      <div class="col-md-12 pe-0">
        <div class="card-body border-right border-bottom p-3 h-100">
          <div v-if="$page.props.flash.success" class="alert alert-success" role="alert">
            {{ $page.props.flash.success }}
          </div>
          <div class="mb-3 d-flex justify-content-start divbus">
            <Link :href="route(`${routeName}create`)" class="add btn btn" >
              <i class="bi bi-plus-circle"></i> <p class="text-add">Agregar Temática</p>
            </Link>
            <div class="input-group w-50 ml-2">
              <input id="search-input" type="text"
                class="busqueda form-control form-control-sm form-control bg-light shadow-sm"
                placeholder="Ingrese un parámetro de búsqueda"
                v-model="filters.search"
                @change="search"
              />
              <div class="input-group-append input-group-append-sm">
                 <button
                    @click="search"
                    class="btn btn-primary btn-sm" >
                    <i class="buscar bi bi-search"></i>
                  </button>
              </div>
            </div>
            
          </div><br>

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="5%" class="col">No.</th>
                  <th width="35%" class="col">Nombre</th>
                  <th width="9%" class="col">Editar</th>
                  <th width="9%" class="col">Eliminar</th>
                </tr>
              </thead>
              <tbody v-for="item in tematicas.data" :key="item.id">
                <tr>
                  <td>{{ item.id  }}</td>
                  <td>{{ item.name }}</td>
                  
                  <td><button class="btn1 btn btn-info btn-sm" >
                    <a :href="route('tematicas.edit', item.id)">
                    <i class="lapiz bi bi-pencil-fill">
                    </i></a></button> 
                  </td>
                  <td>  
                    <form action="">
                  <button
                  class="btn1 btn btn-danger btn-sm"
                  type="button"
                  @click="eliminar(item.id)"
                >
                  <i class="basura bi bi-trash-fill"></i>
                </button>
              </form>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <RecordsHelper :thereAreResults="thereAreResults" :loadingResults="loadingResults"/>
          <pagination  :links="tematicas.links" :total="tematicas.total" class="pagination"/>
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
    import Head from '@/Jetstream/Head.vue';
    
    export default {
        name: "Index",
        props: {
            titulo: { type: String, required: true },
            routeName: { type: String, required: true },
            tematicas: { type: Object, required: true },
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
            Head,
        },

        setup(props) {
          const form = useForm({ ...props.tematicas });
            const thereAreResults = computed(() => props.tematicas.total > 0);
            const state = reactive({
                filters: {
                    page: props.tematicas.current_page,
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
                form.delete(route("tematicas.destroy", idel));
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

  .buscar{
   
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