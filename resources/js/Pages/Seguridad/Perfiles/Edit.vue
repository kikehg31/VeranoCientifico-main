<template>
  <app-layout title="Catálogos de Roles">
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
              <DataForm />
              <hr>
              <div
                class="btn-toolbar justify-content-between"
                role="toolbar"
                aria-label="Toolbar with button groups"
              >
                <div class="btn-group">
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
                <div class="input-group">
                  <button
                    class="btn btn-outline-danger btn-sm"
                    v-if="!perfil.deleted_at"
                    type="button"
                    @click="eliminar"
                  >
                    <i class="bi bi-trash"></i> Eliminar Registro
                  </button>
                </div>
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
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import DataForm from "./DataForm.vue";
import {provide} from "@vue/runtime-core";

export default {
  name: "Edit",
  props: {
    titulo: { type: String, required: true },
    perfil: { type: Object, required: true, default: {}},
    permisos: { type: String, required: true,efault: {} },
    modules: { type: Object, required: true,default: {} },
    routeName: { type: String, required: true },
  },
  components: {
    AppLayout,
    Link,
    JetLabel,
    JetInput,
    JetInputError,
    JetButton,
    DataForm
  },
  setup(props) {
    const form = useForm({
            name       : props.perfil.name,
            description: props.perfil.description,
            guard_name : props.perfil.guard_name,
            permisos   : [...props.perfil.permissions.map(p => ({id : p.id, name : p.name}))],
        });
    const guardar = () => form.transform( data => ({ ...data, permisos: data.permisos.map( p => p.id ) })).put(route('perfiles.update', props.perfil.id))
    const eliminar = () => {
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
          form.delete(route("perfiles.destroy", props.perfil.id));
        }
      });
    };
    provide('form', form);
    provide('permisos', props.permisos);
    provide('modulos', props.modules);

    return { form, guardar, eliminar, }
  },
};
</script>

<style>
</style>