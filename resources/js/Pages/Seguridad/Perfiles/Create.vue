<template>
  <app-layout title="Catálogo de Roles">
    <template #header>
      <h2 class="h4 font-weight-bold">
        <i class="bi bi-person-lines-fill"></i> {{ titulo }}
      </h2>
    </template>
    <div class="card shadow-sm">
      <div class="row">
        <div class="col-md-12 pe-0">
          <div class="card-body border-right border-bottom p-3 h-100">
            <form class="row g-3 needs-validation" @submit.prevent="guardar">
              <DataForm />
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
import { Link, useForm } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import DataForm from "./DataForm.vue";
import {provide} from "@vue/runtime-core";

export default {
  name: "Create",
  props: {
    titulo: { type: String, required: true },
    routeName: { type: String, required: true },
    modulos: { type: String, required: true },
    permisos: { type: String, required: true },
  },
  components: {
    AppLayout,
    Link,
    JetButton,
    DataForm,
  },
  setup(props) {
    const form = useForm({ name:'', description:'', guard_name:'web', permisos:[]});
    const guardar = () => form.transform( data => ({ ...data, permisos: data.permisos.map(p => p.id)})).post(route('perfiles.store'));
    provide('form', form);
    provide('permisos', props.permisos);
    provide('modulos',  props.modulos);
    return { form, guardar}
  },
};
</script>

<style>
</style>