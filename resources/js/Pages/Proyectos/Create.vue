<template>
  <Head> </Head>

  <Profe> </Profe>

    <div class="contenido">
              <div class="forma1">
                <h2 class="h4 font-weight-bold text-center">
                  <br><i class="bi bi-bricks"></i> {{ titulo }}
                </h2>
                <div class="card-body border-right border-bottom p-3 h-100">
                  <form class="row g-3 needs-validation" @submit.prevent="guardar">
                  <div class="col-sm-12 mb-12" >
                    <jet-label class="label form-label fs-base" value="*Nombre del Proyecto:" />
                    <jet-input placeholder="Introduce el titulo"  type="text"  class="upper form-control form-control-lg" v-model="form.title"  :class="{ 'is-invalid': form.errors.title }" autocomplete="name"  required />
                    <jet-input-error :message="form.errors.title" />
                  </div>
                  <div class="col-sm-6 mb-4" >
                    <jet-label class="label form-label fs-base" value="*Número alumnos:" />
                    <jet-input type="number" id="sn" class="form-control form-control-lg" v-model="form.studentnum"  :class="{ 'is-invalid': form.errors.studentnum }" autocomplete="name"  required />
                    <jet-input-error :message="form.errors.studentnum" />
                  </div>
                  <div class="col-sm-6 mb-4" >
                    <jet-label class="label form-label fs-base" value="Modalidad:" />
                      <select class="form-select form-select-lg" :class="{'is-invalid':form.errors.modality}" v-model="form.modality">
                        <option disabled value="">Seleccione un elemento</option>
                        <option value="Presencial">Presencial</option>
                        <option value="Virtual">Virtual</option>
                        <option value="Mixta">Mixta</option>
                      </select>
                  </div>
                  <div class="col-sm-6 mb-4" >
                    <jet-label class="label form-label fs-base" value="Temática:" />
                      <select class="form-select form-select-lg" :class="{'is-invalid':form.errors.thematic_id}" v-model="form.thematic_id">
                        <option disabled value="">Seleccione un elemento</option>
                        <option v-for="tema in tematica"  v-bind:value="tema.id" v-bind:key="tema.id">{{ tema.name }}</option>
                      </select>
                  </div>

                  <div class="col-sm-6 mb-4" >
                    <jet-label v-if="form.thematic_id != ''" class="label form-label fs-base" for="name" value="*Subárea de conocimiento" />
                      <select  class="form-select form-select-lg" v-if="form.thematic_id != ''" id="subareaconoc" :class="{'is-invalid':form.errors.subthematic_id}" v-model="form.subthematic_id">
                        <option disabled value="">Seleccione un elemento</option>
                        <option v-for="item in tematica[form.thematic_id-1].subtematica" :value="item.id" :key="item" >{{ item.name }}</option>
                      </select>
                  </div>
                  <div class="col-sm-12 mb-12" >
                    <jet-label v-capitalize class="label form-label fs-base" value="*Requisitos:" />
                    <jet-input placeholder="Introduce los requisitos" type="text" id="sn" class="form-control form-control-lg" v-model="form.requirements"  :class="{ 'is-invalid': form.errors.requirements }" autocomplete="name"  required />
                    <jet-input-error :message="form.errors.requirements" />
                  </div>
                    <div class="col-sm-12 mb-12" >
                      <jet-label v-capitalize class="label form-label fs-base" value="*Objetivo general:" />
                      <jet-input type="text" v-model="form.generalobject" :class="{ 'is-invalid': form.errors.generalobject }"     
                      required  placeholder="Introduce el objetivo general" />
                      <jet-input-error :message="form.errors.generalobject" />
                    </div>
                    <div class="col-sm-12 mb-12" >
                      <jet-label class="label form-label fs-base" value="*Palabras clave:" />
                      <jet-input placeholder="Introduce palabras claves de tu proyecto"  type="text" id="sn" class="form-control form-control-lg" v-model="form.keywords"  :class="{ 'is-invalid': form.errors.keywords }" autocomplete="name"  required />
                      <jet-input-error :message="form.errors.keywords" />
                    </div>
                    <div class="px-6 py-4">
                      <Link
                        :href="route(`${routeName}index`)"
                        class="btncancelar btn btn-outline-secondary me-4">
                        <i class="bi bi-chevron-left"></i> Cancelar
                      </Link>
                      <jet-button
                        @click="guardar"
                        class="btnguardar btn btn-outline-secondary "
                        :class="{ 'text-white-50': form.processing }"
                        :disabled="form.processing">
                        <i class="bi bi-save"></i> Guardar
                      </jet-button>
                    </div>
                  </form>
              </div>
            </div>             
    </div>
</template>
  
  <script>
import { defineComponent } from 'vue'
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Link } from '@inertiajs/inertia-vue3'
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import axios from 'axios';
import AppLayout from "@/Layouts/AppLayout.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetButton from "@/Jetstream/Button.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import Profe from "@/Jetstream/Profe.vue";
import Head from "@/Jetstream/Head.vue";
  
  
  export default {
    name: "Create",
    props: {
      titulo: { type: String, required: true },
      routeName: { type: String, required: true },
      tematica: {type:Object, required:true},
      subtematica: {type:Object, required:true},
      idlog: {type:Object, required:true},
      idinstlog: {type:Object, required:true}
    },
    components: {
      AppLayout,
      Link,
      Profe,
      JetLabel,
      Head,
      JetInput,
      JetInputError,
      JetButton,
      JetDropdownLink,
    },
    setup(props) {
      const form = useForm({ 
        title: "", 
        studentnum: "", 
        thematic_id: "",
        subthematic_id: "",
        generalobject: "",
        modality: "",
        requirements: "",
        keywords:"",
        institution_id:"",
        user_id: "",
      });

      const guardar = () => {
        form.user_id = props.idlog;
        form.institution_id = props.idinstlog;
        form.post(route("proyectos.store"));
      };
  
      return { form, guardar };
    },
  
    methods: {
        logout() {
        this.$inertia.post(route('logout'));
        }
      },
     
  };
  
  </script>
  
  <style scoped>
      
        .btncancelar{
          background-color: #920707;
          color: #ffffff;
        }
      
        .btnguardar{
          background-color: #092252;
          color: #ffffff;
        }

        .label{
          color: #092252;
        }
  
        .forma1{
        width: 65%;
        border-radius: 20px;
        box-sizing: border-box;
        background-color: #ffffff;
        margin-top: 10%;
        margin-left: 17%;
        box-shadow: 19px 14px 14px 20px #cbced1, -14px -14px 20px rgba(216, 213, 213, 0.137);
        }
      
        .contenido{
          background-color: #ffffff;
        }
      
      
        [id="cuenta"]:hover{
          background-color: #c90c0cec;
          color: rgb(255, 255, 255);
          font-style: bold;
        }
      
        [id="btn"]:hover, [id="guardar"]:hover{
          background-color: rgba(6, 42, 107, 0.986);
          color: rgb(255, 255, 255);
          font-style: bold;
        }
      
        [id="btn"]{
          background-color: #092252;
          color: rgb(255, 255, 255);
          width: 16%;
          border-radius: 10px;
          padding: 12px;
          margin-left: 40px;
          margin-right: -8%;
        }
      
        [id="guardar"]{
          background-color: #092252;
          color: rgb(255, 255, 255);
          width: 16%;
          padding: 12px;
          margin-left:10%;
          border-radius: 10px;
          margin-right: -8%;
          outline: none;
          border: #092252;
        }
      
        i[id="boxi2"]{
          font-size: 21px;
          padding: 5px;
        }
      
        i[id="boxi3"]{
          font-size: 17px;
          padding: 1px;
        }
      
        [id="guardar"]:hover{
          background-color: rgba(6, 42, 107, 0.986);
          color: rgb(255, 255, 255);
          font-style: bold;
        }
      
        /*Barra de navegacion */
        .header{
          position: fixed;
        }
      
        i[id="boxi"]{
          font-size: 19px;
          padding: 5px;
        }
      
       
        .navbar{
          width: 100%;
        }
      
        a[id="text"]{
          font-size: bold;
          padding-top: 10px;
          display: block;
        }
      
        nav[id="navegador"]{
        font-size: 18px;
        color: #092252; 
        margin-left: 2%;
        }
      
        li{
          padding: 18px;
        }
      
        a[id="logo"]{
          margin-left: -8%;
          height: 80px;
        }
      
        a[id="lista"]:hover{
          background-color:rgba(195, 197, 214, 0.795);
          border-radius: 15px;
        }
      
      
        a[id="opt"]:hover{
          background-color:rgba(230, 231, 240, 0.932);
          color: #092252; 
          border-radius: 12px;
        }
      
        a[id="opt"]{
          cursor: pointer;
          background-color:rgb(255, 255, 255);
          color: #092252; 
          padding-top: 5px;
          border-radius: 10px;
        }
      
        li[id="cont"]::after, li[id="cont"]::before{
          content: '';
          position: absolute;
          background-color: rgb(22, 9, 82);
          width: 3px;
          height: 11px;
          top: 35px;
          border-radius: 5px;
          transition: all 0.3s;
        }
      
        div[id="auth"]{
          left: 330px;
        }
      
        p[id="auth_user"]{
          position: absolute;
          left: 50px;
          width: 220px;
          font-size: 15px;
          color: #092352a8;
        }
      
        li[id="cont"]{
          min-height: 45px;
          position: relative;
          width: 150px;
          margin-left: -10px;
          text-align: center;
          cursor: pointer;
          color: #092252; 
        }
      
        li[id="cont"]::after{
          transform: rotate(45deg);
          left:171%;
        }
      
        li[id="cont"]::before{
          transform: rotate(-45deg);
          left:175%;
        }
      
        li[id="cont"]:hover::after{
          transform: rotate(135deg);
        }
      
        li[id="cont"]:hover::before{
          transform: rotate(-135deg);
        }
      
        p{
          margin-bottom: 0 ;
          font-size: 18px;
        }
  
  </style>
  
  