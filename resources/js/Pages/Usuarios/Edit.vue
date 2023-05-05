<template>
  <Head>   </Head>
  <Admin v-if="$page.props.user.id_rol == 1"> </Admin>
  <Profe v-if="$page.props.user.id_rol == 2"></Profe>
  <Alumno v-if="$page.props.user.id_rol == 4"> </Alumno>
  <Revisor v-if="$page.props.user.id_rol == 3"></Revisor>


<body>
  <main class="page-wrapper">
   <section class="container pt-4">
        <div class="row">
          <aside class="col-lg-3 col-md-4 border-end pb-5 mt-n5">
            <div class="position-sticky top-0">
              <div class="text-center pt-5">
                <div class="d-table position-relative mx-auto mt-2 mt-lg-4 pt-5 mb-3">
                  <img :src="form.photo" class="d-block rounded-circle" ref="photo"  width="120" alt="John Doe">
                  <button @click="updateImage" type="button" class="btn btn-icon btn-light bg-white btn-sm border rounded-circle shadow-sm position-absolute bottom-0 end-0 mt-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Change picture">
                    <i class="bx bx-refresh"></i>
                  </button>
                </div>
                <h2 class="h5 mb-1">{{ $page.props.user.name}} {{ $page.props.user.lastnamep}} {{ $page.props.user.lastnamem }}</h2>
                <p class="mb-3 pb-3">{{ $page.props.user.email}}</p>
                <button type="button" class="btn btn-secondary w-100 d-md-none mt-n2 mb-3" data-bs-toggle="collapse" data-bs-target="#account-menu">
                  <i class="bx bxs-user-detail fs-xl me-2"></i>
                  Menú
                  <i class="bx bx-chevron-down fs-lg ms-1"></i>
                </button>
                <div id="account-menu" class="list-group list-group-flush collapse d-md-block">
                  <a href="/dashboard" class="list-group-item list-group-item-action d-flex align-items-center ">
                    <i class="bi bi-house fs-xl opacity-60 me-2"></i> &nbsp;
                    Bienvenido
                  </a>
                  <a :href="route('registro.edit', $page.props.user.id)" class="list-group-item list-group-item-action d-flex align-items-center active">
                    <i class="bi bi-person-gear fs-xl opacity-60 me-2"></i>&nbsp;
                    Detalles de la cuenta
                  </a>
                  <a :href="route('profile.show', $page.props.user.id)" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-earmark-lock fs-xl opacity-60 me-2"></i>&nbsp;
                    Seguridad de la cuenta
                  </a>
                  <a v-if="$page.props.user.id_rol == 1" :href="route('reportes.index')" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-bar-graph fs-xl opacity-60 me-2"></i> &nbsp;
                    Reportes PDF
                  </a>
                  <a v-if="$page.props.user.id_rol == 1" href="/indexbackup"  class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-database fs-xl opacity-60 me-2"></i> &nbsp;
                    Base de Datos
                  </a>
                  <a href="account-signin.html" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-box-arrow-left fs-xl opacity-60 me-2"></i>&nbsp;
                    Cerrar sesión
                  </a>
                </div>
              </div>
            </div>
          </aside>
          <div class="col-md-8 offset-lg-md-1 pb-5 mb-2 mb-lg-1 pt-md-5 mt-n3 mt-md-0">
            <div class="ps-md-4 ps-lg-5 mt-md-4 py-md-4">
              <h1 class="h2 pt-xl-1 pb-3" style='color:#11044a'><i class='bx bx-user bx-flashing' style='color:#11044a'></i> Información sobre tu cuenta</h1><hr><br>
              <div v-if="$page.props.flash.success" class="alert d-flex alert-success" role="alert">
                <i class="bx bx-check-circle lead me-3"></i>
                <a href="#" class="alert-link">{{ $page.props.flash.success }}</a>
              </div>
              <!-- Basic info -->
              <jet-validation-errors class="pb-3 pb-lg-4"/>
              <form class="needs-validation border-bottom pb-3 pb-lg-4" enctype="multipart/form-data" @submit.prevent="updateProfileInformation">
                <div class="row pb-4">
                  <div class="col-sm-6 mb-4" v-if="$page.props.user.id_rol == 1">
                    <jet-label class="form-label fs-base" for="name" value="Nombre" />
                    <jet-input type="text" id="sn" class="form-control form-control-lg" v-model="form.name"  :class="{ 'is-invalid': form.errors.name }" autocomplete="name"  required />
                    <jet-input-error :message="form.errors.name" />
                  </div>
                  <div class="col-sm-6 mb-4" v-if="$page.props.user.id_rol == 1">
                    <jet-label class="form-label fs-base" for="name" value="Apellido Paterno" />
                    <jet-input type="text" id="sn" class="form-control form-control-lg" v-model="form.lastnamep"  :class="{ 'is-invalid': form.errors.name }" autocomplete="name"   />
                    <jet-input-error :message="form.errors.lastnamep" />
                  </div>
                  <div class="col-sm-6 mb-4" v-if="$page.props.user.id_rol == 1">
                    <jet-label class="form-label fs-base" for="name" value="Apellido Materno" />
                    <jet-input type="text" id="sn" class="form-control form-control-lg" v-model="form.lastnamem"  :class="{ 'is-invalid': form.errors.name }" autocomplete="name"  r/>
                    <jet-input-error :message="form.errors.lastnamem" />
                  </div>
                  <div class="col-sm-6 mb-4" >
                    <jet-label class="form-label fs-base" for="name" value="Teléfono" />
                    <jet-input type="text" id="sn" class="form-control form-control-lg" v-model="form.phone"  :class="{ 'is-invalid': form.errors.name }" autocomplete="name"  />
                    <jet-input-error :message="form.errors.phone" />
                  </div>
                  <div class="col-sm-6 mb-4">
                    <jet-label class="form-label fs-base" value="Institución de procedencia:" />
                    <select class="form-select form-select-lg" :class="{'is-invalid':form.errors.institution_id}" v-model="form.institution_id">
                      <option v-for="ins in instituciones" :value="ins.id">{{ ins.name }}</option>
                    </select>
                  </div>
                  <div class="col-sm-6 mb-4" v-if="$page.props.user.id_rol == 2">
                    <jet-label class="form-label fs-base" value="Temática:" />
                    <select class="form-select form-select-lg" :class="{'is-invalid':form.errors.thematic_id}" v-model="form.thematic_id">
                      <option v-for="tema in tematicas" :value="tema.id" >{{ tema.name }}</option>
                    </select>
                  </div>
                  <div class="col-sm-6 mb-4" v-if="$page.props.user.id_rol == 2 ">
                    <jet-label class="form-label fs-base" value="Subtemática:" />
                      <select class="form-select form-select-lg"  :class="{'is-invalid':form.errors.subthematic_id}" v-model="form.subthematic_id">

                        <option v-for="item in tematicas[form.thematic_id-1].subtematica" :value="item.id" :key="item" >{{ item.name }}</option>
                      </select>
                  </div>
                  <div class="col-sm-6 mb-4" v-if="$page.props.user.id_rol == 2">
                    <jet-label class="form-label fs-base" value="SNI:" />
                      <select class="form-select form-select-lg" :class="{'is-invalid':form.errors.snilevel}" v-model="form.snilevel">
                        <option>C</option>
                        <option>I</option>
                        <option>II</option>
                        <option>III</option>
                        <option>Ninguno</option>
                      </select>
                  </div>
                  <div class="col-sm-6 mb-4" v-if="$page.props.user.id_rol == 2">
                    <jet-label class="form-label fs-base" for="name" value="Grado Máximo de Estudios" />
                    <select class="form-select form-select-lg" :class="{'is-invalid':form.errors.maxgrade}" v-model="form.maxgrade">
                      <option>Licenciatura</option>
                      <option>Doctorado</option>
                      <option>Maestría</option>
                      </select>
                  </div>
                  <div class="col-sm-6 mb-4" v-if="$page.props.user.id_rol == 2">
                    <jet-label class="form-label fs-base" for="name" value="Línea de investigación" />
                    <jet-input type="text" id="sn" class="form-control form-control-lg" v-model="form.invline"  :class="{ 'is-invalid': form.errors.invline }" />
                    <jet-input-error :message="form.errors.invline" />
                  </div>
                  <div class="col-sm-6 mb-4" v-if="$page.props.user.id_rol == 2">
                    <jet-label class="form-label fs-base" for="name" value="Puesto de trabajo" />
                    <jet-input type="text" id="sn" class="form-control form-control-lg" v-model="form.job"  :class="{ 'is-invalid': form.errors.job }" />
                    <jet-input-error :message="form.errors.job" />
                  </div>
                  <input type="file" id="imgprofile" accept=".png, .jpg, .jpeg" @change="saveImgProfile" style="width:0; height:0; overflow:hidden;">

                </div>
                <div class="d-flex mb-3">
                  <button  @click="guardar"  type="submit" class="btn btn-primary"><i class="bx bx-save fs-xl opacity-60 me-2"></i> Guardar cambios</button>
                </div>
              </form>
            </div>
          </div>
        </div>
</section>
</main>
</body>
</template>

<script>
import { defineComponent } from 'vue'
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import Admin from "@/Jetstream/Admin.vue";
import Profe from "@/Jetstream/Profe.vue";
import Head from '@/Jetstream/Head.vue';
import Revisor from '@/Jetstream/Revisor.vue';
import Alumno from '@/Jetstream/Alumno.vue';
import Aside from '@/Jetstream/Aside.vue';
import { useForm } from "@inertiajs/inertia-vue3";

export default defineComponent({
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
    Admin,
    Profe,
    Head,
    Alumno,
    Revisor,
    Aside
  },

  props: ['user', 'tematicas', 'instituciones', 'subtematicas'],

  data() {
    return {
      form: this.$inertia.form({
        _method: 'PUT',
        name: this.user.name,
        lastnamep: this.user.lastnamep,
        lastnamem: this.user.lastnamem,
        phone: this.user.phone,
        institution_id: this.user.institution_id,
        thematic_id: this.user.thematic_id,
        subthematic_id: this.user.subthematic_id,
        snilevel: this.user.snilevel,
        maxgrade: this.user.maxgrade,
        invline: this.user.invline,
        job: this.user.job,
        email: this.user.email,
        photo: this.user.photo,
      }),

      photoPreview: this.form.photo,
    }
  },

  setup(props) {
        const form = useForm({ ...props.user });
        const guardar = () => {
          form.put(route("registro.update", props.user.id));
        };
        return { form, guardar};
      },

    methods: {
        updateImage(){
            const input = document.getElementById("imgprofile");
            input.click();
        },

        saveImgProfile(event) {
            let formData = new FormData();
            const img = event.target.files[0];
            formData.append('curp', this.user.curp);
            formData.append('id', this.user.id);
            formData.append('archivo', img);
            axios.post('/img-profile', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                console.log(this.requestform);
                this.photoPreview = response.data.url;
                this.form.photo = response.data.url;
            }).catch(error => {
                // Manejar el error
            });
        }
    },
})
</script>

<style>
h1{
  text-align: center;
  color: rgb(4, 4, 68);
}
</style>