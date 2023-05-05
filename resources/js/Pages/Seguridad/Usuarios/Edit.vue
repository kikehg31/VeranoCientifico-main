<template>
  <Admin> </Admin>
    
  <div class="contenido">
    <div class="forma1">
      <h2 class="h4 font-weight-bold">
        <i class="bi bi-people-fill"></i> {{ titulo }} 
      </h2>
          <form class="formulario" @submit.prevent="guardar">
            <div class=" row pb-5">
                  <div class="col-sm-6 mb-4" >
                    <span class="text-danger mr-1">*</span><jet-label class="form-label fs-base" value="Nombre completo" />
                    <jet-input type="text" id="sn" class="form-control form-control-lg" v-model="form.allname" disabled />
                  </div>
                  <div class="col-sm-6 mb-4" >
                    <span class="text-danger mr-1">*</span><jet-label class="form-label fs-base" for="name" value="Teléfono" />
                    <jet-input type="text" id="sn" class="form-control form-control-lg" v-model="form.phone"  :class="{ 'is-invalid': form.errors.name }" autocomplete="name"  />
                    <jet-input-error :message="form.errors.phone" />
                  </div>
                  <div class="col-sm-6 mb-4">
                    <span class="text-danger mr-1">*</span><jet-label class="form-label fs-base" value="Institución de procedencia:" />
                    <select class="form-select form-select-lg" :class="{'is-invalid':form.errors.institution_id}" v-model="form.institution_id">
                      <option v-for="ins in instituciones" :value="ins.id">{{ ins.name }}</option>
                    </select>
                  </div>
                  <div class="col-sm-6 mb-4" v-if="user.rol === '2'">
                    <jet-label class="form-label fs-base" value="Temática:" />
                    <select class="form-select form-select-lg" :class="{'is-invalid':form.errors.thematic_id}" v-model="form.thematic_id">
                      <option v-for="tema in tematicas" :value="tema.id" >{{ tema.name }}</option>
                    </select>
                  </div>
                  <!----<div class="col-sm-6 mb-4" v-if="user.rol === '2'">
                    <jet-label class="form-label fs-base" value="Subtemática:" />
                      <select class="form-select form-select-lg"  :class="{'is-invalid':form.errors.subthematic_id}" v-model="form.subthematic_id">
                        
                        <option v-for="item in tematicas[form.thematic_id-1].subtematica" :value="item.id" :key="item" >{{ item.name }}</option>
                      </select>
                  </div>-->
                  <div class="col-sm-6 mb-4" v-if="user.rol === '2'">
                    <jet-label class="form-label fs-base" value="SNI:" />
                      <select class="form-select form-select-lg" :class="{'is-invalid':form.errors.snilevel}" v-model="form.snilevel">
                        <option>C</option>
                        <option>I</option>
                        <option>II</option>
                        <option>III</option>
                        <option>Ninguno</option>
                      </select>
                  </div>
                  <div class="col-sm-6 mb-4" v-if="user.rol === '2'">
                    <jet-label class="form-label fs-base" for="name" value="Grado Máximo de Estudios" />
                    <select class="form-select form-select-lg" :class="{'is-invalid':form.errors.maxgrade}" v-model="form.maxgrade">
                      <option>Licenciatura</option>
                      <option>Doctorado</option>
                      <option>Maestría</option>
                      </select>
                  </div>
                  <div class="col-sm-6 mb-4" v-if="user.rol === '2'">
                    <jet-label class="form-label fs-base" for="name" value="Línea de investigación" />
                    <jet-input type="text" id="sn" class="form-control form-control-lg" v-model="form.invline"  :class="{ 'is-invalid': form.errors.invline }" />
                    <jet-input-error :message="form.errors.invline" />
                  </div>
                  <div class="col-sm-6 mb-4" v-if="user.rol === '2'">
                    <jet-label class="form-label fs-base" for="name" value="Puesto de trabajo" />
                    <jet-input type="text" id="sn" class="form-control form-control-lg" v-model="form.job"  :class="{ 'is-invalid': form.errors.job }" />
                    <jet-input-error :message="form.errors.job" />
                  </div>
              <div
                class="btn-toolbar justify-content-between"
                role="toolbar"
                aria-label="Toolbar with button groups"
              >
                <div class="btn-group">
                  <Link
                    :href="route(`${routeName}index`)"
                    class="btn btn-danger btn-sm me-2"
                  >
                    <i class="bi bi-chevron-left"></i> Cancelar
                  </Link>
                  <jet-button
                    @click="guardar"
                    class="btnguardar btn btn-secondary btn-sm me-2"
                    :class="{ 'text-white-50': form.processing }"
                    :disabled="form.processing"
                  >
                    <i class="bi bi-save"></i>&nbsp;Guardar
                  </jet-button>
                </div>
              </div>
            </div>
            </form>
          </div>
        </div>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import Admin from "@/Jetstream/Admin.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import {provide} from "@vue/runtime-core";
import {ref} from "vue";
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

export default {
    name: "Edit",
    
    props:{
        titulo: String, 
        user:  { type: String, required: true },
        tematicas:  { type: String, required: true },
        instituciones:  { type: String, required: true },
        subtematicas:  { type: String, required: true },
        routeName: { type: String, required: true },
    },
    components:{
        AppLayout,
        Link,
        JetLabel,
        JetInput,
        JetInputError,
        JetButton,
        Admin
    },

    setup(props) {
      const form = useForm({
            id : props.user.id,
            rol : props.user.rol,
            name: props.user.name,
            lastnamem: props.user.lastnamem,  
            lastnamep : props.user.lastnamep,
            phone : props.user.phone,
            institution_id: props.user.institution_id,
            thematic_id: props.user.thematic_id,
            subthematic_id : props.user.subthematic_id,
            snilevel : props.user.snilevel,
            maxgrade: props.user.maxgrade,
            invline: props.user.invline,
            job: props.user.job,
            allname: props.user.name + ' ' + props.user.lastnamep + ' ' + props.user.lastnamem,
        });
      const guardar = () => {
        form.put(route("usuarios.update", props.user.id));
      }; 
        return {form,guardar};
    },

    
    
};
</script>

<style scoped>
.formulario{
  padding: 0px 20px 0px 20px;
}

h2{
  font-size: 30px;
  text-align: center;
  font-weight: bolder;
  color: rgb(5, 5, 107);
  margin-top: -22px;
  padding: 20px;
}

.forma1{
  width: 80%;
  border-radius: 20px;
  background-color: #ffffff;
  margin-top: 10%;
  margin-left: 11%;
  box-shadow: 14px 14px 20px #cbced1, -14px -14px 20px rgba(216, 213, 213, 0.137);
}

.contenido{
  background-color: #ffffff;
}

.btnguardar{
  background-color: #092252;
  color: #ffffff;
}

.btnguardar:hover{
  background-color: #092c6d;
  color: #ffffff;
}

a{
  text-decoration: none;
}

p{
  margin-bottom: 0 ;
  font-size: 18px;
}

</style>