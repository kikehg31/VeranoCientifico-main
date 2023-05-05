<template>
  <app-layout title="Calendario de Eventos">
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
                  <option v-for="item in modulos" v-bind:value="item.key" v-bind:key="item.id" >{{ item.nombre }}</option>
                </select>
                <jet-input-error :message="form.errors.module_key"/>
              </div>
              <div class="col-md-8">
                <span class="text-danger mr-1">*</span>
                <jet-label>Nombre:</jet-label>
                <jet-input
                    :class      = "{ 'is-invalid': form.errors.name }"
                    v-model     = "form.name"
                    placeholder = "Nombre del Permiso" />
                <jet-input-error :message="form.errors.name" />
              </div>
              <div class="col-md-8">
                <span class="text-danger mr-1">*</span>
                <jet-label for="description">Descripción:</jet-label>
                <jet-input
                    id          = "description"
                    :class      = "{ 'is-invalid': form.errors.description }"
                    v-model     = "form.description"
                    placeholder = "Descripción" />
                <jet-input-error :message="form.errors.description" />
              </div>

              
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
                    v-if="!record.deleted_at"
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

export default {
  name: "Edit",
  props: {
    titulo: { type: String, required: true },
    record: { type: Object, required: true, default: {}},
    routeName: { type: String, required: true },
    modulos: { type: Object, required: true },
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
    const form = useForm({ ...props.record });
    const guardar = () => {
      form.put(route("permissions.update", props.record.id));
    };
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
          form.delete(route("permissions.destroy", props.record.id));
        }
      });
    };
    return { form, guardar, eliminar };
  },
};
</script>

<style>
</style>