<template>
  <div class="col-md-6">
    <span class="text-danger mr-1">*</span>
    <jet-label for="name">Nombre</jet-label>
    <jet-input
      id="nombre"
      v-model="form.name"
      :class="{ 'is-invalid': form.errors.name }"
      placeholder="Nombre"
    />
    <jet-input-error :message="form.errors.name" />
  </div>
  <div class="col-md-6">
    <span class="text-danger mr-1">*</span>
    <jet-label for="description">Descripción</jet-label>
    <jet-input
      id="description"
      v-model="form.description"
      :class="{ 'is-invalid': form.errors.description }"
      placeholder="Descripción"
    />
    <jet-input-error :message="form.errors.description" />
  </div>
  <div class="col-12 col-md-3 mb-3">
    <h5 class="text-muted">
      <i class="bi bi-lock"></i>
      Módulos disponibles.
    </h5>
    <div class="input-group flex-nowrap">
      <span class="input-group-append">
        <button
          type="button"
          class="btn btn-sm btn-default"
          @click.prevent="searchModule"
        >
          <i class="bi bi-search"></i>
        </button>
      </span>
      <jet-input
        id="search"
        v-model="inputSearchModule"
        placeholder="Ingrese un parámetro de búsqueda"
        @change="searchModule"
      />
    </div>
    <hr />

    <div class="nav flex-column nav-pills">
                <a v-for  = "(module, key) in modulesFilter"
                   :key   = "key"
                   :href  = "`#${module.key}`"
                   :id    = "`pill-${module.key}`"
                   @click = "changeModule(module.key)"
                   class  = "nav-link"
                   :class = "{'active' : module.key === active}"
                   role   = "tab"
                   data-toggle = "pill"
                   :aria-controls = "module.key"
                   aria-selected = "true"
                   v-text="module.nombre">
                </a>
            </div>
  </div>
  <div class="col-12 col-md-9">
    <div class="tab-content">
      <div class="row">
        <div class="col-12">
          <div class="input-group input-group-sm">
            <span class="input-group-append">
              <button
                :id="`button-add-${active}`"
                type="button"
                class="btn btn-sm btn-outline-primary mr-1"
                @click="addAllPermissions()"
              >
                <i class="bi bi-check-all"></i>&nbsp;Todos
              </button>
              <button
                :id="`button-remove-${active}`"
                type="button"
                class="btn btn-sm btn-outline-danger mr-1"
                @click="removeAllPermissions()"
              >
                <i class="bi bi-reply-fill"></i>&nbsp;Ninguno
              </button>
              <button
                type="button"
                class="btn btn-sm btn-default"
                @click.prevent="searchPermission"
              >
                <i class="bi bi-search"></i>
              </button>
            </span>
            <jet-input
              id="search-module"
              v-model="inputSearchPermission"
              placeholder="Buscar permisos"
              @keyup="searchPermission"
            />
          </div>
        </div>
      </div>
      <hr />
      
      <div
        class="tab-pane"
        :class="{ active: key === active }"
        :id="key"
        v-for="(module, key) in permissionsFilter"
        :key="key"
      >
        <div
          class="row"
          v-if="getActive.value === key"
          style="max-height: 25rem; overflow-y: auto"
        >
          <div
            class="form-group col-12 col-md-4"
            style="word-break: break-all"
            v-for="permiso in module"
            :key="permiso.id"
          >
          
            <div class="form-check form-switch">
              <input
                class="form-check-input"
                type="checkbox"
                v-model="form.permisos"
                :value="{ id: permiso.id, name: permiso.name }"
                :id="permiso.name"
                :checked="isChecked(permiso)"
              />
              <label class="form-check-label" :for="permiso.name">
                {{ permiso.name }} - {{permiso.description}}
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import { computed, inject, reactive, ref, toRefs } from "vue";
import Pagination from "@/Shared/Pagination.vue";
export default {
  components: {
    Pagination,
    JetLabel,
    JetInput,
    JetInputError,
    JetButton,
    JetDangerButton,
  },
  setup() {
    const permisos = inject("permisos", {});
    const modules = inject("modulos", {});
    const form = inject("form");

    const isChecked = (permission) =>
      form.permisos.some((permiso) => permission.id === permiso.id);

    const state = reactive({
      modulesFilter: { ...modules },
      permissionsFilter: { ...permisos },
    });

    // filters
    const active = ref("cat");
    const getActive = computed(() => active);
    const inputSearchPermission = ref("");
    const inputSearchModule = ref("");

    const searchModule = () => {
      if (inputSearchModule.value.trim() !== "") {
        state.modulesFilter = modules.filter((module) => {
          const filter = module.nombre
            .toLowerCase()
            .includes(inputSearchModule.value.toLowerCase());
          if (filter) return module;
        });
        if (state.modulesFilter.length > 0) {
          active.value = state.modulesFilter[0].key;
        }
      } else {
        state.modulesFilter = modules;
      }
    };

    const changeModule = (key) => {
      active.value = key;
      inputSearchPermission.value = "";
      searchPermission();
    };

    const searchPermission = () => {
      const key = active.value;
      if (inputSearchPermission.value.trim() !== "") {
        state.permissionsFilter[key] = permisos[key].filter(
          (item) =>
            item.description
              .toLowerCase()
              .includes(inputSearchPermission.value.toLowerCase()) ||
            item.name
              .toLowerCase()
              .includes(inputSearchPermission.value.toLowerCase())
        );
      } else {
        state.permissionsFilter[key] = permisos[key];
      }
    };

    const addAllPermissions = () => {
      const key = active.value;
      if (state.permissionsFilter[key]) {
        removeAllPermissions();
        state.permissionsFilter[key].forEach((permission) =>
          form.permisos.push({ id: permission.id, name: permission.name })
        );
      }
    };

    const removeAllPermissions = () => {
      const key = active.value;
      if (state.permissionsFilter[key]) {
        state.permissionsFilter[key].forEach((permission) => {
          const index = form.permisos.findIndex(
            (item) => item.id === permission.id
          );
          if (index > -1) form.permisos.splice(index, 1);
        });
      }
    };

    return {
      form,
      isChecked,
      ...toRefs(state),
      inputSearchPermission,
      searchPermission,
      addAllPermissions,
      removeAllPermissions,
      //
      changeModule,
      modules,
      searchModule,
      inputSearchModule,
      //
      active,
      getActive,
    };
  },
};
</script>

<style>
</style>