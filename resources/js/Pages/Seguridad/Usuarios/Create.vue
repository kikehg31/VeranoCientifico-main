<template >
  <Admin v-if="$page.props.user.rol == 1"></Admin>

  <div class="contenido">
    <!---<a target="blank" href="https://api.whatsapp.com/send?phone=7774525374&text=Hola,%20%C2%BFme%20puedes%20apoyar?" class="circulo"><i class='bx bxl-whatsapp'></i></a>-->
    <div class="forma1">

      <div class="alumno" v-if="form.rol === 4"><br>
        <h3>Solicitud de Registro para Estudiantes</h3><br>
        <p>Para registrarte en algunas de las temáticas del verano debes primero tener un perfil.</p>
        <p>Ingresa la siguiente información para crearlo. Posteriormente, revisa la bandeja de entrada</p>
        <p>del correo proporcionado y activa tu cuenta. Dependiendo de la configuración del correo</p> 
        <p>proporcionado, puede ser que dicho correo se encuentre en su Spam.</p><br><br>
      </div>

      <div class="revisor" v-if="form.rol === 3"><br>
        <h3>Solicitud de Registro para Revisores Institucionales</h3><br>
        <p>Para registrarte en algunas de las temáticas del verano debes primero tener un perfil.</p>
        <p>Ingresa la siguiente información para crearlo. Posteriormente, revisa la bandeja de entrada</p>
        <p>del correo proporcionado y activa tu cuenta. Dependiendo de la configuración del correo</p> 
        <p>proporcionado, puede ser que dicho correo se encuentre en su Spam.</p><br>
        <a target="_blank" href="https://docs.google.com/document/d/1WzD9VWNIoyt1FG8hrDlhd6KOn8KFq4Gq/edit"><button type="button" class="btn btn-info"><i id="boxi2" class='bx bxs-file-pdf'></i> Descargar Formato de Solicitud de Participación</button></a><br><br><br>
      </div>

      <div class="profesor2" v-if="form.rol === 2"><br>
        <h3 class="h2pro">Solicitud de Registro para Profesores Nuevo Ingreso</h3><br>
        <p>Ingresa los siguientes datos. Posteriormente, el Administrador validará tu cuenta. Una vez</p>
        <p>que te notifique el Administrador que tu cuenta ya fue activada, ya podrás empezar a crear</p>
        <p>proyectos.</p><br><br>
      </div>

      <jet-validation-errors class="mb-3"/>
      <div class="formulario forma2"> 
        <div class="curp col-sm-10 mb-5">
          <br><jet-label class="label form-label fs-base" for="name" value="*CURP" />
            <div class="input-group">
              <jet-input v-on:keyup.enter="formSubmit()" id="curp" type="text" v-model="curp.curp" required />
              <button class="btn btn-primary" type="button"  v-on:click="formSubmit()" > <i class="bi bi-search"></i></button>
            </div>
            <div>
            <div class="me-3 text-decoration-none" v-if="form.feedback != ''">
              <span style="color: red" v-text="form.feedback"></span>
            </div>
          </div>
        </div><br>
      <form @submit.prevent="guardar" enctype="multipart/form-data" v-if="form.curp!=''">
        <div class=" row pb-5">
        <div class="tipo">
          <div class="col-sm-5 mb-5">
              <jet-label class="label form-label fs-base" for="name" value="*Tipo de usuario" />
                <select required class="form-select form-select-lg" id="tipouser" :class="{'is-invalid':form.errors.rol}" v-model="form.rol">
                  <option disabled value="">Seleccione un elemento</option>
                  <option v-for="rol in roles" v-bind:value="rol.id" v-bind:key="rol.id">{{ rol.name }}</option>
                </select>
          </div>
        </div>

          <div class="col-sm-4 mb-4">
                    <jet-label class="label form-label fs-base" for="name" value="*Nombre" />
                    <jet-input type="text" class="form-control form-control-lg" v-model="form.name" disabled />
                    <jet-input-error :message="form.errors.name" />
          </div>

          <div class="col-sm-4 mb-4">
                    <jet-label class="label form-label fs-base" for="name" value="*Apellido Paterno" />
                    <jet-input type="text" class="form-control form-control-lg" v-model="form.lastnamep" disabled />
                    <jet-input-error :message="form.errors.lastnamep" />
          </div>

          <div class="col-sm-4 mb-5">
                    <jet-label class="label form-label fs-base" for="name" value="*Apellido Materno" />
                    <jet-input type="text" class="form-control form-control-lg" v-model="form.lastnamem"  disabled/>
                    <jet-input-error :message="form.errors.lastnamem" />
          </div>

          <div class="col-sm-4 mb-4" v-if="form.rol != 3 && form.rol != 2">
                    <jet-label  class="label form-label fs-base" for="name" value="*CURP" />
                    <jet-input  type="text" class="form-control form-control-lg" v-model="form.curp"  disabled />
                    <jet-input-error :message="form.errors.curp" />
          </div>

          <div class="col-sm-4 mb-4" v-if="form.rol === 3 | form.rol === 2">
                    <jet-label  class="label form-label fs-base" for="name" value="*RFC" />
                    <jet-input  type="text" class="form-control form-control-lg" v-model="form.rfc"  disabled />
                    <jet-input-error :message="form.errors.rfc" />
          </div>

          <div class="col-sm-4 mb-4" >
                    <jet-label class="label form-label fs-base" for="name" value="*Correo" />
                    <div class="invalid-feedback">Please enter your first name!</div>

                    <jet-input placeholder="Teclee su correo" type="email" id="sn" class="form-control form-control-lg" v-model="form.email"  :class="{ 'is-invalid': form.errors.email }" required/>
                    <jet-input-error :message="form.errors.email" />
          </div>
          <div class="col-sm-4 mb-5" >
                    <jet-label class="label form-label fs-base" for="name" value="*Confirmar correo" />
                    <jet-input placeholder="Teclee su correo nuevamente" type="email" id="sn" class="form-control form-control-lg" v-model="form.emailcon"  :class="{ 'is-invalid': form.errors.emailcon }"  required />
                    <jet-input-error :message="form.errors.emailcon" />
          </div>

          <div class="col-sm-4 mb-4" >
                    <jet-label class="label form-label fs-base" for="name" value="*Teléfono" />
                    <jet-input placeholder="Teclee su teléfono" type="text" id="sn" class="form-control form-control-lg" v-model="form.phone"  :class="{ 'is-invalid': form.errors.phone }" />
                    <jet-input-error :message="form.errors.phone" />
          </div>

          <div class="col-sm-4 mb-4" >
                    <jet-label class="label form-label fs-base" for="name" value="*Institución de procedencia" />
                    <select class="form-select form-select-lg" v-model="form.institution_id">
                      <option disabled value="">Seleccione un elemento </option>
                      <option v-for="item in instituto" v-bind:value="item.id" v-bind:key="item.id">{{ item.name }}</option>
                    </select>
          </div>

          <div class="col-sm-4 mb-5" v-if="form.rol === 2" >
                    <jet-label class="label form-label fs-base" for="name" value="*Área de conocimiento" />
                    <select class="form-select form-select-lg" id="areaconoci" :class="{'is-invalid':form.errors.thematic_id}" v-model="form.thematic_id">
                      <option disabled value="">Seleccione un elemento</option>
                      <option v-for="tema in tematica"  v-bind:value="tema.id" v-bind:key="tema.id">{{ tema.name }}</option>
                    </select>
          </div>

          <div class="col-sm-4 mb-4" v-if="form.rol === 2" >
                    <jet-label v-if="form.thematic_id != ''" class="label form-label fs-base" for="name" value="*Subárea de conocimiento" />
                    <select  class="form-select form-select-lg" v-if="form.thematic_id != ''" id="subareaconoc" :class="{'is-invalid':form.errors.subthematic_id}" v-model="form.subthematic_id">
                      <option disabled value="">Seleccione un elemento</option>
                      <option v-for="item in tematica[form.thematic_id-1].subtematica" :value="item.id" :key="item">{{ item.name }}</option>
                    </select>
          </div>

          <div class="col-sm-4 mb-4" v-if="form.rol === 2" >
                    <jet-label class="label form-label fs-base" value="*Grado Máximo de Estudios" />
                    <select  class="form-select form-select-lg" :class="{'is-invalid':form.errors.maxgrade}" v-model="form.maxgrade">
                      <option disabled value="">Seleccione un elemento</option>
                      <option>Licenciatura</option>
                      <option>Doctorado</option>
                      <option>Maestría</option>
                    </select>
          </div>

          <div class="col-sm-4 mb-5" v-if="form.rol === 2" >
                    <jet-label class="label form-label fs-base" value="*Línea de Investigación" />
                    <jet-input placeholder="Teclee su Línea de Investigación" type="text" class="form-control form-control-lg" v-model="form.invline"  :class="{ 'is-invalid': form.errors.invline }" />
                    <jet-input-error :message="form.errors.invline" />
          </div>

          <div class="col-sm-4 mb-4" v-if="form.rol === 2" >
                    <jet-label class="label form-label fs-base" value="*Nivel SNI" />
                    <select  class="form-select form-select-lg" :class="{'is-invalid':form.errors.snilevel}" v-model="form.snilevel">
                      <option disabled value="">Seleccione un elemento</option>
                      <option>C</option>
                      <option>I</option>
                      <option>II</option>
                      <option>III</option>
                      <option>Ninguno</option>
                    </select>
          </div>

          <div class="col-sm-4 mb-4" v-if="form.rol === 2" >
                    <jet-label class="label form-label fs-base" value="*Puesto que Desempeña" />
                    <jet-input placeholder="Teclee su Puesto que Desempeña" type="text" class="form-control form-control-lg" v-model="form.job"  :class="{ 'is-invalid': form.errors.job }" />
                    <jet-input-error :message="form.errors.job" />
          </div>

          <div class="col-sm-4 mb-5" >
                    <jet-label class="label form-label fs-base" value="*Contraseña" />
                    <jet-input placeholder="Teclee su contraseña" type="password" id="password" class="form-control form-control-lg" v-model="form.password"  :class="{ 'is-invalid': form.errors.password }" />
                    <jet-input-error :message="form.errors.password" />
          </div>

          <div class="col-sm-4 mb-2" >
                    <jet-label for="password_confirmation" class="label form-label fs-base" value="*Confirmar Contraseña" />
                    <div class="password-toggle">
                    <jet-input placeholder="Teclee Nuevamente su Contraseña" type="password" id="password" class="form-control form-control-lg" v-model="form.password_confirmation"  :class="{ 'is-invalid': form.errors.password_confirmation }" />
                    <label class="password-toggle-btn" aria-label="Show/hide password">
                        <input class="password-toggle-check" type="checkbox">
                        <span class="password-toggle-indicator"></span>
                      </label>
                    </div>
                    <jet-input-error :message="form.errors.password_confirmation" />
          </div>

          <div class="col-sm-8 mb-2" v-if="form.rol === 2" >
                    <jet-label class="label form-label fs-base" value="*Constancia de personal activo o comprobante de pago" />
                    <jet-input type="file" class="form-control form-control-lg" @input="form.constancy = $event.target.files[0]" required  :class="{ 'is-invalid': form.errors.constancy }" />
                    <jet-input-error :message="form.errors.constancy" />
          </div>

          <div class="col-sm-8 mb-2" v-if="form.rol === 3" >
                    <jet-label class="label form-label fs-base" value="*Formato de solicitud" />
                    <jet-input placeholder="Teclee su *Puesto que Desempeña" type="file" class="form-control form-control-lg" @input="form.requestform = $event.target.files[0]" required  :class="{ 'is-invalid': form.errors.requestform }" />
                    <jet-input-error :message="form.errors.requestform" />
          </div>
      </div>

        <div class="forma">
          <i class='bx bxs-x-circle bx-flip-horizontal bx-tada' v-if="form.password != form.password_confirmation"  style='color:#ff0000' ></i><label 
          for="password" value="Password"  v-if="form.password != form.password_confirmation"  style="color: red"
          >No coinciden las Contraseñas*</label>
        </div>

        <div class="forma" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
          <div class="custom-control custom-checkbox">
            <jet-checkbox name="terms" id="terms" v-model:checked="form.terms" />

            <label class="custom-control-label" for="terms">
              I agree to the <a target="_blank" :href="route('terms.show')">Terms of Service</a> and <a target="_blank" :href="route('policy.show')">Privacy Policy</a>
            </label>
          </div>
        </div>

        <div class="info">
            <a :href="route('login')"><button id="cuenta" type="button" class="add btn btn-info"><i id="boxi3" class="bi bi-box-arrow-in-right"></i> ¿Ya tienes cuenta?</button></a>

            <button @click="guardar" id="guardar" class="add btn btn" :class="{ 'text-white-50': form.processing }" :disabled="form.password != form.password_confirmation">
                <i id="boxi3" class="bi bi-save"></i> Guardar
            </button>
        </div><br>
      </form>
    </div>
  </div>
</div>
</template>

<script>
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Link } from '@inertiajs/inertia-vue3'
import { useForm } from "@inertiajs/inertia-vue3";
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import axios from 'axios';
import Admin from "@/Jetstream/Admin.vue";
import Head from '@/Jetstream/Head.vue';


export default{
  name: "Register",
  
  props: {
    tematica: { type: Object, required: true },
    roles: {type: Object, required: true},
    instituto: {type: Object, required: true},
    subtematica: {type:Object, required:true},

  },

  components: {
    Head,
    JetAuthenticationCard,
    JetAuthenticationCardLogo,
    JetButton,
    JetInput,
    JetCheckbox,
    JetLabel,
    JetValidationErrors,
    Link,
    Admin,
  },

  
    
  setup(props) {

    const curp = useForm({ curp: "" });

    const form = useForm({ 
      rol: "", 
      name: "",
      lastnamep: "", 
      lastnamem:"", 
      email:"", 
      curp:"",
      rfc:"",
      emailcon:"", 
      phone:"", 
      institution_id:"", 
      requestform:"", 
      thematic_id:"", 
      subthematic_id:"",  
      snilevel:"",  
      maxgrade:"",  
      invline:"",  
      job:"",  
      constancy:"",
      name_doc:"", 
      password:"", 
      password_confirmation:"", 
      feedback:""
    });

      const guardar = () => {
        if(form.rol == "4" && form.name != "" && form.lastnamep != "" && form.lastnamem != "" && form.curp != "" && form.email != "" && form.emailcon != "" && form.phone != "" && form.institution_id != "" && form.password != "" && form.password_confirmation != ""){
          const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })
          swalWithBootstrapButtons.fire({
            title: '¿Desea confirmar su registro?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
              form.post(route("registro.store"));
            
              
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                'Registro cancelado',
                '',
                'error'
                )
              }
            })
        }else if (form.rol == "2" && form.name != "" && form.lastnamep != "" && form.lastnamem != "" && form.curp != "" && form.email != "" && form.emailcon != "" && form.phone != "" && form.institution_id != "" && form.password != "" && form.password_confirmation != "" && form.thematic_id != "" && form.subthematic_id != "" && form.maxgrade != "" && form.invline != "" && form.snilevel != ""&& form.constancy != ""){
          const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })
          swalWithBootstrapButtons.fire({
            title: '¿Desea confirmar su registro?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {

              form.name_doc = "Constancia";
      
              form.post(route("registro.store"));
            
              
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                'Registro cancelado',
                '',
                'error'
                )
              }
            })


        }else if(form.rol == "3" && form.name != "" && form.lastnamep != "" && form.lastnamem != "" && form.curp != "" && form.email != "" && form.emailcon != "" && form.phone != "" && form.institution_id != "" && form.password != "" && form.password_confirmation != "" && form.requestform != ""){
          const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })
          swalWithBootstrapButtons.fire({
            title: '¿Desea confirmar su registro?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {

              form.name_doc = "FormatoSolicitud";
      
              form.post(route("registro.store"));
            
              
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                'Registro cancelado',
                '',
                'error'
                )
              }
            })
        }else{
          console.log('Hola');
        }
      };
    return { form, guardar, curp};
  },

  methods: {
  formSubmit() {
    console.log(this.form.area);
    axios
      .get(route("registro.show", this.curp.curp))
      .then((response) => {
        this.form.curp = response["data"]["curp"];
        this.form.name = response["data"]["nombres"];
        this.form.lastnamep = response["data"]["apellidoPaterno"];
        this.form.lastnamem = response["data"]["apellidoMaterno"];
        this.form.rfc = response["data"]["curp"].slice(0,10);
        this.form.feedback = "";
      })
      .catch((error) => {
        this.form.curp = "";
        this.form.name = "";
        this.form.lastnamep = "";
        this.form.lastnamem = "";
        this.form.rol = "";
        this.form.rfc = "";
        error.response.data.exception == "TypeError"
          ? (this.form.feedback = "Curp Incorrecta")
          : (this.form.feedback = "Curp Incorrecta");
      });
  },
  submit() {
    this.form.post(this.route("register"), {
      onFinish: () => this.form.reset("password", "password_confirmation"),
    });
  },
},

  
};
</script>

<style scoped>


:root{
    --main-color: rgb(23, 33, 123);
    --second-color:rgba(29, 43, 172, 0.795);
    --black: #000000;
    --white: #ffffff;
  }

  .formulario{
    padding: 0px 20px 0px 20px;
  }

  .tipo{
    margin-left: 28%;
    text-align: center;
  }

 

  .forma1{
  width: 75%;
  border-radius: 20px;
  box-sizing: border-box;
  background-color: #ffffffef;
  margin-top: 10%;
  margin-left: 13%;
  box-shadow: 14px 14px 20px #cbced1, -14px -14px 20px rgba(216, 213, 213, 0.137);
  }

  .contenido{
    background-color: #ffffff;
  }

  .label{
          color: #092252;
  }

  .add{
    font-size: 15px;
  }

  .curp{
    margin-left: 8%;
  }

  .alumno, .revisor, .profesor2{
    text-align: center;
  }

  p{
    margin-bottom: 0 ;
    font-size: 18px;
  }
  .h2pro{
    margin-bottom: 0;
  }

  [id="cuenta"]{
    background-color: #a70d0d;
    color: rgb(255, 255, 255);
    width: 16%;
    border-radius: 10px;
    padding: 12px;
    margin-left: 5px;
    margin-right: -8%;
    border: #a70d0d;
  }

  a{
    text-decoration: none;
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

</style>