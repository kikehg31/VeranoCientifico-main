<template>
  <app-layout title="Catálogo de Módulos">
    <template #header>
      <h2 class="h4 font-weight-bold">
        <i class="bi bi-bricks"></i> {{ titulo }}
      </h2>
    </template>
    <div class="card shadow-sm">
      <div class="row">
        <div class="col-md-12 pe-0">
          <div class="card-body border-right border-bottom p-3 h-100">
            <div v-if="$page.props.flash.success" class="alert alert-success" role="alert">
              {{ $page.props.flash.success }}
            </div>
            <div class="mb-2 d-flex justify-content-start">
              <Link
                :href="route(`${routeName}create`)"
                class="btn btn-outline-secondary btn-sm"
              >
                <i class="bi bi-plus"></i>
                Agregar Módulo
              </Link>
              <div class="input-group w-50 ml-2">
                <input
                  type="text"
                  class="
                    form-control form-control-sm form-control
                    bg-light
                    shadow-sm
                  "
                  placeholder="Ingrese un parámetro de búsqueda"
                  v-model="filters.search"
                  @change="search"
                />
                <div class="input-group-append input-group-append-sm">
                  <button
                    @click="search"
                    class="btn btn-outline-secondary btn-sm"
                  >
                    <i class="bi bi-search"></i>
                  </button>
                </div>
              </div>
              <select
                @change="search"
                class="
                  custom-select-sm custom-select
                  bg-light
                  shadow-sm
                  border-0
                  w-25
                  ml-2
                "
                v-model="filters.status"
              >
                <option :value="true">Activos</option>
                <option :value="false">Eliminados</option>
              </select>
            </div>

            <div class="d-flex flex-row bd-highlight pt-2">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Módulo</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Clave</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in modulos.data" :key="item.id">
                    <td>
                      <Link
                        :href="route('modulo.edit', item.id)"
                        class="d-flex text-decoration-none text-reset"
                        >{{ item.nombre }}</Link
                      >
                    </td>
                    <td>
                      <Link
                        :href="route('modulo.edit', item.id)"
                        class="d-flex text-decoration-none text-reset"
                        >{{ item.descripcion }}</Link
                      >
                    </td>
                    <td>
                      <Link
                        :href="route('modulo.edit', item.id)"
                        class="d-flex text-decoration-none text-reset"
                        >{{ item.key }}</Link
                      >
                    </td>
                    <td>
                      <Link
                        :href="route('modulo.edit', item.id)"
                        class="d-flex text-decoration-none text-reset"
                      >
                        <i class="bi bi-caret-right-fill"></i>
                      </Link>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <RecordsHelper
            :thereAreResults="thereAreResults"
            :loadingResults="loadingResults"
          />
            <pagination :links="modulos.links" :total="modulos.total" />
            
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import Pagination from "@/Shared/Pagination.vue";
import RecordsHelper from "@/Shared/RecordsHelper.vue";
import { computed, onMounted, reactive, toRefs, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Input from "@/Jetstream/Input.vue";
import { ref } from "vue";

export default {
  name: "Index",
  props: {
    titulo: { type: String, required: true },
    modulos: {
      type: Object,
      default: {},
      required: true,
    },
    routeName: { type: String, required: true },
    loadingResults: { type: Boolean, required: true, default: true },
    search: { type: String, required: true },
    status: { type: Boolean, required: true, default: true },
  },
  components: {
    AppLayout,
    Link,
    Pagination,
    RecordsHelper,
    Input,
  },
  setup(props) {
    const thereAreResults = computed(() => props.modulos.total > 0);
    const state = reactive({
      filters: {
        page: props.modulos.current_page,
        search: props.search,
        status: props.status ?? 1,
      },
    });
    const search = () => {
      props.loadingResults = true;
      Inertia.replace(route(`${props.routeName}index`, state.filters));
    };

    return {
      ...toRefs(state),
      search,
      thereAreResults,
    };
  },
};
</script>

<style>
</style>