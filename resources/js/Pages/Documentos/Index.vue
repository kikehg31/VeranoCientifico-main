<template>
  <Head>   </Head>

  <Alumno v-if="$page.props.user.id_rol == 4"> </Alumno>

<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>
  <div class="forma1">
    <br>
    {{ $mensaje }}
    <jet-validation-errors class="mb-3"/>

    <div class="formulario forma2">

    <form @submit.prevent="guardar" enctype="multipart/form-data">
    <br><h2 style='color:#030664'><i class='bx bxs-up-arrow-square bx-flashing' style='color:#04023f' ></i> Carga de documentos</h2>
      <div v-if="comentarios != ''" class="alert alert-warning d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        <div>
            Favor de atender las siguientes observaciones a la brevedad:<br>
            <ul>
                 <li>{{ comentarios }}</li>
            </ul>

            Una vez que se hayan atendido las observaciones debe enviar nuevamente los documentos.<br>
            Es importante que no cambie ningun otro archivo que no se le indique
        </div>
    </div>
      <br><p v-if="!comentarios">A continuación se pide llenar el formulario con los respectivos documentos, lo más legible posible</p><br>
        <jet-label class="label form-label fs-base" value="*Formato solicitud" />
        <div class="col-sm-10 mb-5 r">
            <jet-input  class="form-control form-control-lg" v-if="requestform === ''" id="request" accept="application/pdf" type="file" ref="request" @change="saveStorage($event, 'request')" required :class="{ 'is-invalid': form.errors.requestform }" />
            <jet-input class="form-control form-control-lg" v-if="requestform != ''" id="request" type="text" v-model="form.requestform" disabled/>
            <jet-input-error :message="form.errors.requestform" />
            <a v-if="requestform != ''" :href="requestform" target="_blank"><button type="button" title="Ver" class="btn btn-info btn-sm">
            <i class='boxi bi bi-eye-fill' style='color:#ffffff' ></i></button></a>&nbsp;&nbsp;
            <button v-if="requestform != ''" type="button" title="Borrar" v-on:click="borrar(requestform, 'request')" class="btn btn-danger btn-sm">
            <i class='boxi bi bi-trash-fill' style='color:#ffffff' ></i>
            </button>
        </div>

        <jet-label class="label form-label fs-base" value="*Carta academica" />
        <div class="col-sm-10 mb-5 r">
            <jet-input v-if="academicdoc === ''" id="academic" accept="application/pdf" type="file" @change="saveStorage($event, 'academicdoc')" class="form-control form-control-lg" required  :class="{ 'is-invalid': form.errors.academicdoc }" />
            <jet-input v-if="academicdoc != ''" id="request" type="text" v-model="form.academicdoc" class="form-control form-control-lg" disabled/>
            <jet-input-error :message="form.errors.academicdoc" />
            <a v-if="academicdoc != ''" :href="academicdoc" target="_blank"><button type="button" title="Ver" class="btn btn-info btn-sm">
            <i class='boxi bi bi-eye-fill' style='color:#ffffff' ></i>
            </button></a>&nbsp;&nbsp;
            <button v-if="academicdoc != ''" type="button" title="Borrar" v-on:click="borrar(academicdoc, 'academicdoc')" class="btn btn-danger btn-sm">
            <i class='boxi bi bi-trash-fill' style='color:#ffffff' ></i></button>
        </div>

        <jet-label class="label form-label fs-base" value="*Carta motivos" />
        <div class="col-sm-8 mb-5 r">
            <jet-input v-if="motivedoc === ''" id="motivedoc" accept="application/pdf" type="file" @change="saveStorage($event, 'motivedoc')" class="form-control form-control-lg" required  :class="{ 'is-invalid': form.errors.motivedoc }" />
            <jet-input v-if="motivedoc != ''" id="motivedoc" type="text" v-model="form.motivedoc" class="form-control form-control-lg" disabled/>
            <jet-input-error :message="form.errors.motivedoc" />
            <a v-if="motivedoc != ''" :href="motivedoc" target="_blank"><button type="button" title="Ver" class="btn btn-info btn-sm">
            <i class='boxi bi bi-eye-fill' style='color:#ffffff' ></i>
            </button></a>&nbsp;&nbsp;
            <button v-if="motivedoc != ''" type="button" title="Borrar" v-on:click="borrar(motivedoc, 'motivedoc')" class="btn btn-danger btn-sm">
            <i class='boxi bi bi-trash-fill' style='color:#ffffff' ></i></button>
        </div>

        <jet-label class="label form-label fs-base" value="*INE" />
        <div class="col-sm-8 mb-5 r">
            <jet-input v-if="ine === ''" id="ine" type="file" accept="application/pdf" @change="saveStorage($event, 'ine')" class="form-control form-control-lg" required  :class="{ 'is-invalid': form.errors.ine }" />
            <jet-input v-if="ine != ''" id="ine" type="text" v-model="form.ine" class="form-control form-control-lg" disabled/>
            <jet-input-error :message="form.errors.ine" />
            <a v-if="ine != ''" :href="ine" target="_blank"><button type="button" title="Ver" class="btn btn-info btn-sm">
            <i class='boxi bi bi-eye-fill' style='color:#ffffff' ></i></button></a>&nbsp;&nbsp;
            <button v-if="ine != ''" type="button" title="Borrar" v-on:click="borrar(ine, 'ine')" class="btn btn-danger btn-sm">
            <i class='boxi bi bi-trash-fill' style='color:#ffffff' ></i></button>
        </div>

        <jet-label class="label form-label fs-base" value="*CVU" />
        <div class="col-sm-8 mb-5 r">
            <jet-input v-if="cvu === ''" id="cvu" type="file" accept="application/pdf" @change="saveStorage($event, 'cvu')" class="form-control form-control-lg" required  :class="{ 'is-invalid': form.errors.cvu }" />
            <jet-input v-if="cvu != ''" id="cvu" type="text" v-model="form.cvu" class="form-control form-control-lg" disabled/>
            <jet-input-error :message="form.errors.cvu" />
            <a v-if="cvu != ''" :href="cvu" target="_blank"><button type="button" title="Ver" class="btn btn-info btn-sm">
            <i class='boxi bi bi-eye-fill' style='color:#ffffff' ></i></button></a>&nbsp;&nbsp;
            <button v-if="cvu != ''" type="button" title="Borrar" v-on:click="borrar(cvu, 'cvu')" class="btn btn-danger btn-sm">
            <i class='boxi bi bi-trash-fill' style='color:#ffffff' ></i></button>
        </div>

        <jet-label class="label form-label fs-base" value="*Fotografía" />
        <div class="col-sm-8 mb-2 r">
            <jet-input v-if="foto === ''" id="foto" type="file"  @change="saveStorage($event, 'foto')" class="form-control form-control-lg" required  :class="{ 'is-invalid': form.errors.foto }" />
            <jet-input v-if="foto != ''" id="foto" type="text" v-model="form.foto" class="form-control form-control-lg" disabled/>
            <jet-input-error :message="form.errors.foto" />
            <a v-if="foto != ''" :href="foto" target="_blank"><button type="button" title="Ver" class="btn btn-info btn-sm">
            <i class='boxi bi bi-eye-fill' style='color:#ffffff' ></i></button></a>&nbsp;&nbsp;
            <button v-if="foto != ''" type="button" title="Borrar" v-on:click="borrar(foto, 'foto')" class="btn btn-danger btn-sm">
            <i class='boxi bi bi-trash-fill' style='color:#ffffff' ></i></button>
        </div>

        <div class="info">
         <a :href="route('dashboard')"><button id="cuenta" type="button" class="ms-4 add btn btn-danger"><i class='boxi3 bx bx-arrow-back' style='color:#ffffff' >&nbsp</i> Volver</button></a>


          <button type="submit" id="enviar" class="ms-4 add btn btn-info" :class="{ 'text-white-50': form.processing }">
            <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
               <span class="visually-hidden">Loading...</span>
             </div>
             <i id="boxi3" class="boxi3 bx bx-send" style='color:#ffffff' >&nbsp;</i> Siguiente
          </button>
    </div><br>
  </form>
</div>

</div>
</body>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import Pagination from "@/Shared/Pagination.vue";
import RecordsHelper from "@/Shared/RecordsHelper.vue";
import { computed, onMounted, reactive, toRefs, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Input from "@/Jetstream/Input.vue";
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import { ref } from "vue";
import Swal from 'sweetalert2';
import { useForm } from "@inertiajs/inertia-vue3";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetButton from "@/Jetstream/Button.vue";
import 'sweetalert2/dist/sweetalert2.min.css';
import Alumno from "@/Jetstream/Alumno.vue";
import Head from '@/Jetstream/Head.vue';
import axios from 'axios';
import Toastify from 'toastify-js';
export default {

  props: {
    titulo: { type: String, required: true },
    documento1: { type: String, required: true },
    documento2: { type: String, required: true },
    documento3: { type: String, required: true },
    documento4: { type: String, required: true },
    documento5: { type: String, required: true },
    documento6: { type: String, required: true },
    comentarios: { type: String, required: true },
    user: { type: Object, required: true },
  },

  components: {
          Alumno,
          Head,
          Link,
          RecordsHelper,
          Pagination,
          Input,
          JetDropdownLink,
          JetLabel,
          JetInput,
          JetInputError,
          JetButton,
    },



  setup(props) {
    const form = useForm({
      requestform: props.documento1,
      academicdoc: props.documento2,
      motivedoc: props.documento3,
      ine: props.documento4,
      cvu: props.documento5,
      foto: props.documento6,
      ver:"",
    });


    const guardar = () => {
      form.post(route("docuser.store"));
    };

    return {guardar, form};
  },

  data() {
      return {

        requestform: this.documento1,
        academicdoc: this.documento2,
        motivedoc: this.documento3,
        ine: this.documento4,
        cvu: this.documento5,
        foto: this.documento6,
        curp: this.user.curp,
        id: this.user.id,
        imageUrl: '../../../../public/assets/img/avatar/02.jpg',
      }
  },


  methods: {
    showToast() {
        Toastify({
            text: '¡Hola, mundo!',
            backgroundColor: 'green',
        }).showToast()
    },
    saveStorage(event, doc) {
        let formData = new FormData();
        const archivo = event.target.files[0];
        const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                color: '#fff',
                background: '#3FDA3D',
                didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        if(doc == 'request'){
            formData.append('namedoc', 'formato_solicitudd');
            formData.append('curp', this.curp);
            formData.append('id', this.id);
            formData.append('archivo', archivo);
            axios.post('/guardar-archivo', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            })
            .then(response => {
                console.log(this.requestform);
                this.requestform = response.data.url;
                this.form.requestform = this.requestform;

                Toast.fire({
                    icon: 'success',
                    title: 'Archivo Cargado',
                    customClass: {
                        background: 'my-custom-class'
                    }
                })
            })
            .catch(error => {
            // Manejar el error
            });
        }

        if(doc == 'academicdoc'){
            formData.append('namedoc', 'carta_academicA');
            formData.append('curp', this.curp);
            formData.append('id', this.id);
            formData.append('archivo', archivo);
            axios.post('/guardar-archivo', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            })
            .then(response => {
                console.log(this.requestform);
                this.academicdoc = response.data.url;
                this.form.academicdoc = this.academicdoc

                Toast.fire({
                    icon: 'success',
                    title: 'Archivo Cargado'
                })
            })
            .catch(error => {
            // Manejar el error
            });
        }

        if(doc == 'motivedoc'){
            formData.append('namedoc', 'carta_motivos');
            formData.append('curp', this.curp);
            formData.append('id', this.id);
            formData.append('archivo', archivo);
            axios.post('/guardar-archivo', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            })
            .then(response => {
                console.log(this.requestform);
                this.motivedoc = response.data.url;
                this.form.motivedoc = this.motivedoc;

                Toast.fire({
                    icon: 'success',
                    title: 'Archivo Cargado'
                })
            })
            .catch(error => {
            // Manejar el error
            });
        }

        if(doc == 'ine'){
            formData.append('namedoc', 'INE');
            formData.append('curp', this.curp);
            formData.append('id', this.id);
            formData.append('archivo', archivo);
            axios.post('/guardar-archivo', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            })
            .then(response => {
                console.log(this.requestform);
                this.ine = response.data.url;
                this.form.ine = this.ine;

                Toast.fire({
                    icon: 'success',
                    title: 'Archivo Cargado'
                })
            })
            .catch(error => {
            // Manejar el error
            });
        }

        if(doc == 'cvu'){
            formData.append('namedoc', 'CVU');
            formData.append('curp', this.curp);
            formData.append('id', this.id);
            formData.append('archivo', archivo);
            axios.post('/guardar-archivo', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            })
            .then(response => {
                console.log(this.requestform);
                this.cvu = response.data.url;
                this.form.cvu = this.cvu;

                Toast.fire({
                    icon: 'success',
                    title: 'Archivo Cargado'
                })
            })
            .catch(error => {
            // Manejar el error
            });
        }

        if(doc == 'foto'){
            formData.append('namedoc', 'fotografia');
            formData.append('curp', this.curp);
            formData.append('id', this.id);
            formData.append('archivo', archivo);
            axios.post('/guardar-archivo', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            })
            .then(response => {
                console.log(this.requestform);
                this.foto = response.data.url;
                this.form.foto = this.foto;

                Toast.fire({
                    icon: 'success',
                    title: 'Archivo Cargado'
                })
            })
            .catch(error => {
            // Manejar el error
            });
        }



    },

    borrar: function (path, archivo) {
        let formData = new FormData();
        let inputId = '#' + archivo;
        const $elemento = document.querySelector(inputId);
        const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                color: '#fff',
                background: '#E92727',
                didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        formData.append('path', path);
        axios.post('/eliminar-archivo', formData, {
        })
        .then(response => {
            if(archivo == 'request'){
                this.requestform = '';
                $elemento.value = ""
                Toast.fire({
                    icon: 'warning',
                    title: 'Archivo Eliminado'
                })
            }
            if(archivo == 'academicdoc'){
                this.academicdoc = '';
                $elemento.value = ""
                Toast.fire({
                    icon: 'warning',
                    title: 'Archivo Eliminado'
                })
            }
            if(archivo == 'motivedoc'){
                this.motivedoc = '';
                $elemento.value = ""
                Toast.fire({
                    icon: 'warning',
                    title: 'Archivo Eliminado'
                })
            }
            if(archivo == 'ine'){
                this.ine = '';
                $elemento.value = ""
                Toast.fire({
                    icon: 'warning',
                    title: 'Archivo Eliminado'
                })
            }
            if(archivo == 'cvu'){
                this.cvu = '';
                $elemento.value = ""
                Toast.fire({
                    icon: 'warning',
                    title: 'Archivo Eliminado'
                })
            }
            if(archivo == 'foto'){
                this.foto = '';
                $elemento.value = ""
                Toast.fire({
                    icon: 'warning',
                    title: 'Archivo Eliminado'
                })
            }


        })
        .catch(error => {
            // Manejar el error
        });
    },

}
}
</script>
<style scoped>
.my-custom-class {
  background-color: white;
}
.forma1{
    width: 70%;
    border-radius: 20px;
    box-sizing: border-box;
    background-color: #fffffe;
    margin-top: 8%;
    margin-left: 14%;
    box-shadow: 14px 14px 20px #cbced1, -14px -14px 20px rgba(216, 213, 213, 0.137);
    display: flex;
}

h2{
    text-align: center;
    margin-left: 15%;
}

a{
    text-decoration: none;
}

.r{
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 110%;
}

.r input {
  flex-grow: 1;
  margin-right: 1rem;
}

.r button {
  margin-left: 1rem;
}

.formulario{
    margin-left: 6%;
}

.info{
margin-top: 7%;
}

.boxi3{
    font-size:18px;
}

.boxi{
    font-size:18px;
}

.boxi2{
    font-size:15px;
}

</style>
