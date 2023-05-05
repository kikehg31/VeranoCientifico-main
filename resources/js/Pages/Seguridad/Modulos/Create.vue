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
            <form class="row g-3 needs-validation" @submit.prevent="guardar">
              <div class="col-md-8">
                <jet-label for="Nombre del Módulo" value="Nombre del Módulo:" />
                <jet-input
                  v-model="form.nombre"
                  :class="{ 'is-invalid': form.errors.nombre }"
                  required
                  placeholder="Nombre del módulo"
                />
                <jet-input-error :message="form.errors.nombre" />
              </div>
              <div class="col-md-8">
                <jet-label for="Descripción" value="Descripción:" />
                <jet-input
                  v-model="form.descripcion"
                  :class="{ 'is-invalid': form.errors.descripcion }"
                  required
                  placeholder="Descripción del Módulo"
                />
                <jet-input-error :message="form.errors.descripcion" />
              </div>
              <div class="col-md-8">
                <jet-label for="Clave del Módulo" value="Clave del Módulo:" />
                <jet-input
                  v-model="form.key"
                  :class="{ 'is-invalid': form.errors.key }"
                  required
                  placeholder="Clave del Módulo"
                />
                <jet-input-error :message="form.errors.key" />
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
import { ref } from "vue";

export default {
  name: "Create",
  props: {
    titulo: { type: String, required: true },
    routeName: { type: String, required: true },
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
    const form = useForm({ nombre: "", descripcion: "", key: "" });
    const guardar = () => {
      form.post(route("modulo.store"));
    };

    return { form, guardar };
  },
};
</script>

<style>
</style>