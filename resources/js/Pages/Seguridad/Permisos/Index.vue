<template>
  <app-layout title="Catálogo de Permisos">
    <template #header>
      <h2 class="h4 font-weight-bold">
        <i class="bi bi-check-circle-fill"></i> {{ titulo }}
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
                Agregar Permisos
              </Link>
              <div class="input-group w-50 ml-2">
                <input
                  type="text"
                  class="
                    form-control form-control-sm
                    bg-light
                    shadow-sm
                  "
                  placeholder="Ingrese un parámetro de búsqueda"
                  v-model="filters.search"
                  @change="search"
                  @keyup      = "search"
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
            </div>

            <div class="table-responsive">
              <table class="table table-dark table-striped">
                <thead>
                  <tr>
                        <th style="width: 5%;"></th>
                        <th style="width: 25%;">Nombre</th>
                        <th style="width: 30%;">Descripción</th>
                        <th style="width: 30%;">Módulo</th>
                        <th style="width: 5%;">&nbsp;</th>
                        <th style="width: 5%;"></th>
                    </tr>
                </thead>
                <tbody>
                  <tr v-for="item in records.data" :key="item.id">
                    <td>
                      <Link
                        :href="route('permissions.edit', item.id)"
                        class="d-flex text-decoration-none text-reset"
                        >&nbsp;</Link
                      >
                    </td>
                    <td>
                      <Link
                        :href="route('permissions.edit', item.id)"
                        class="d-flex text-decoration-none text-reset"
                        >{{ item.name }}</Link
                      >
                    </td>
                    <td>
                      <Link
                        :href="route('permissions.edit', item.id)"
                        class="d-flex text-decoration-none text-reset"
                        >{{ item.description }}</Link
                      >
                    </td>
                    <td>
                      <Link
                        :href="route('permissions.edit', item.id)"
                        class="d-flex text-decoration-none text-reset"
                        >{{ item.module_key }}</Link
                      >
                    </td>
                    <td>
                      <Link
                        :href="route('permissions.edit', item.id)"
                        class="d-flex text-decoration-none text-reset"
                      >
                        <i class="bi bi-caret-right-fill"></i>
                      </Link>
                    </td>
                    <td>
                      <Link
                        :href="route('permissions.edit', item.id)"
                        class="d-flex text-decoration-none text-reset"
                        >&nbsp;</Link
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination :links="records.links" :total="records.total" />
            <RecordsHelper
            :thereAreResults="thereAreResults"
            :loadingResults="loadingResults"
          />
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
    records: {
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
    const thereAreResults = computed(() => props.records.total > 0);
    const state = reactive({
      filters: {
        page: props.records.current_page,
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