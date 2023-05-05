<template>
  <div class="col-md-4">
    <span class="text-danger mr-1">*</span>
    <jet-label for="name">Nombre del Usuario:</jet-label>
    <jet-input
      id="nombre"
      
      v-model="form.name"
      :class="{ 'is-invalid': form.errors.name }"
      placeholder="Nombre del usuario"
    />
    <jet-input-error :message="form.errors.name" />
  </div>
  <div class="col-md-4">
    <span class="text-danger mr-1">*</span>
    <jet-label for="description">Correo Electrónico:</jet-label>
    <jet-input
      id="email"
      type="email"
      v-model="form.email"
      :class="{ 'is-invalid': form.errors.email }"
      placeholder="Correo electrónico"
    />
    <jet-input-error :message="form.errors.email" />
  </div>
  <div class="col-md-4">
    <span class="text-danger mr-1">*</span>
    <jet-label>Contraseña:</jet-label>
    <jet-input
      id="password"
      v-model="form.password"
      :class="{ 'is-invalid': form.errors.password }"
      placeholder="Contraseña"
    />
    <jet-input-error :message="form.errors.password" />
  </div>
  <hr />
  <div class="d-flex flex-row bd-highlight pt-2">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th style="width: 5%">&nbsp;</th>
          <th style="width: 30%">Nombre del Rol</th>
          <th style="width: 40%">Descripción</th>
          <th style="width: 20%">Estatus</th>
          <th style="width: 30%">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in profiles" :key="item.id">
          <td>&nbsp;</td>
          <td v-html="item.name"></td>
          <td v-html="item.description"></td>
          <td>
            <div class="form-check form-switch">
              <input
                class="form-check-input"
                type="checkbox"
                v-model="form.profiles"

                :value="{ id: item.id, name: item.name }"
                :id="`chk${item.id}`"
                :checked="isCheckedProfile(item)"
                :idrol="`chk${item.id}`"
                @change="associateProfile(item)"
              />
              <label
                class="custom-control-label font-weight-bold"
                :for="`chk${item.id}`"
              ></label>
            </div>
          </td>
          <td>&nbsp;</td>
        </tr>
      </tbody>
    </table>
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
  name: "DataForm",
  components: {
    Pagination,
    JetLabel,
    JetInput,
    JetInputError,
    JetButton,
    JetDangerButton,
  },
  setup() {
    const form = inject("form");
    const profiles = inject("profiles");

    const isChecked = (permission) =>
      form.permissions.some((permiso) => permission.id === permiso.id);

    // Associate profile and select all permissions
    const associateProfile = (profile) => {
      if (form.profiles.some((item) => profile.id === item.id)) {
        profile.permissions.forEach((item) =>
          form.permissions.push({ id: item.id, name: item.name })
        );
      } else {
        profile.permissions.forEach((item) => {
          const index = form.permissions.findIndex(
            (formItem) => formItem.id === item.id
          );
          if (index > -1) {
            form.permissions.splice(index, 1);
          }
        });
      }
    };

    const isCheckedProfile = (profile) =>
      form.profiles.some((item) => profile.id === item.id);


    return {
      form: this.$inertia.form({
        rol: '',
        nombre: '',
        apellidop: '',
        apellidom: '',
        curp: '',
        rfc: '',
        correo:'',
        telefono: '',
        institucionproced: '',
        formatosolicitud: '',
        areaconoc: '',
        subareaconoc: '',
        nivelsni: '',
        gradomax: '',
        lineainv: '',
        puesto: '',
        constancia: '',
        password: '',
        password_confirmation: '',
        terms: false,
      }),
      associateProfile,
      isCheckedProfile,
      // injects
      profiles,
      isChecked,
    };
  },
};
</script>

