<template>
  <app-layout title="Catálogo de Módulos">
    <template #header>
      <h2 class="h4 font-weight-bold">
        <i class="bi bi-check-circle-fill"></i> {{ titulo }}
      </h2>
    </template>
    <div class="card shadow-sm">
      <div class="row">
        <div class="col-md-12 pe-0">
          <div class="card-body border-right border-bottom p-3 h-100">
            <form class="row g-3 needs-validation" @submit.prevent="guardar">
              <div class="col-md-8">
                <span class="text-danger mr-1">*</span>
                <jet-label for="Nombre del Módulo" value="Nombre del Módulo:" />
                <select class="form-select" id="module_key" :class="{'is-invalid':form.errors.module_key}" v-model="form.module_key">
                  <option value=null>Seleccione una opción</option>
                  <option v-for="item in modulos" v-bind:value="item.key" v-bind:key="item.id" >{{ item.nombre }}</option>
                </select>
                <jet-input-error :message="form.errors.module_key"/>
              </div>
              <div class="col-md-8">
                <span class="text-danger mr-1">*</span>
                <jet-label>Nombre (nombre_modulo.index, nombre_modulo.store, nombre_modulo.update, nombre_modulo.delete):</jet-label>
                <jet-input
                    :class      = "{ 'is-invalid': form.errors.name }"
                    v-model     = "form.name"
                    placeholder = "Nombre del Permiso" />
                <jet-input-error :message="form.errors.name" />
              </div>
              <div class="col-md-8">
                <span class="text-danger mr-1">*</span>
                <jet-label for="description">Descripción(index=Leer Registros, store=Crear Registros, update=Actualizar Registros, delete=Eliminar Registros):</jet-label>
                <jet-input
                    id          = "description"
                    :class      = "{ 'is-invalid': form.errors.description }"
                    v-model     = "form.description"
                    placeholder = "Descripción" />
                <jet-input-error :message="form.errors.description" />
              </div>

              <div class="px-6 py-4">
                <Link
                  :href="route(`${routeName}index`)"
                  class="btn btn-outline-secondary btn-sm me-2"
                >
                  <i class="bi bi-chevron-left"></i> Cancelar
                </Link>
                <jet-button
                  @click="guardar"
                  class="btn btn-outline-secondary btn-sm"
                  :class="{ 'text-white-50': form.processing }"
                  :disabled="form.processing"
                >
                  <i class="bi bi-save"></i> Guardar
                </jet-button>
              </div>
            </form>
           
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetButton from "@/Jetstream/Button.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import {provide, watchEffect} from "@vue/runtime-core";
import { ref } from "vue";

export default {
  name: "Create",
  props: {
    titulo:{type: String, required: true },
    routeName:{type: String, required: true},
    modulos:{type:Object, required: true},
  },
  components: {
    AppLayout,
    Link,
    JetLabel,
    JetInput,
    JetInputError,
    JetButton,
  },
  setup(props) {
    const form = useForm({ name: '', guard_name: 'web', description: '', module_key: null});
    const guardar = () => {
      form.post(route(`${props.routeName}store`));
    };

    watchEffect(() => {
            if(form.module_key) {
                form.name = form.module_key + '.';
            }
        });

    return { form, guardar };
  },
};
</script>

<style>
</style>