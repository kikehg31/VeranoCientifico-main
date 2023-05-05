<template>
    <Head> </Head>
    <Admin v-if="$page.props.user.id_rol == 1"> </Admin>
  <body>
    <main class="page-wrapper">
     <section class="container pt-3">
          <div class="row">
            <aside class="col-lg-3 col-md-4 border-end pb-5 mt-n5">
              <div class="position-sticky top-0">
                <div class="text-center pt-5">
                  <div class="d-table position-relative mx-auto mt-2 mt-lg-4 pt-5 mb-3">
                    <img :src="user.photo" class="d-block rounded-circle" ref="photo"  width="120" alt="John Doe">
                  </div>
                  <h2 class="h5 mb-1">{{ $page.props.user.name}} {{ $page.props.user.lastnamep}} {{ $page.props.user.lastnamem }}</h2>
                  <p class="mb-3 pb-3">{{ $page.props.user.email}}</p>
                  <button type="button" class="btn btn-secondary w-100 d-md-none mt-n2 mb-3" data-bs-toggle="collapse" data-bs-target="#account-menu">
                    <i class="bx bxs-user-detail fs-xl me-2"></i>
                    Menú
                    <i class="bx bx-chevron-down fs-lg ms-1"></i>
                  </button>
                  <div id="account-menu" class="list-group list-group-flush collapse d-md-block">
                  <a href="/dashboard" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-house fs-xl opacity-60 me-2"></i> &nbsp;
                    Bienvenido
                  </a>
                  <a :href="route('registro.edit', $page.props.user.id)" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-person-gear fs-xl opacity-60 me-2"></i>&nbsp;
                    Detalles de la cuenta
                  </a>
                  <a :href="route('registro.edit', $page.props.user.id)" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-earmark-lock fs-xl opacity-60 me-2"></i>&nbsp;
                    Seguridad de la cuenta
                  </a>
                  <a v-if="$page.props.user.id_rol == 1" :href="route('reportes.index')" class="list-group-item list-group-item-action d-flex align-items-center">
                    <i class="bi bi-file-bar-graph fs-xl opacity-60 me-2"></i> &nbsp;
                    Reportes PDF
                  </a>
                  <a v-if="$page.props.user.id_rol == 1" href="/indexbackup"  class="list-group-item list-group-item-action d-flex align-items-center active">
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
            <div class="col-md-8 offset-lg-1 pb-5 mb-2 mb-lg-4 pt-md-5 mt-n3 mt-md-0">
              <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                <h1 class="h2 pt-xl-1 pb-1" style='color:#11044a'><i class='bx bxs-report' style='color:#07179a'></i> Respaldo y Recuperacion de la Base de Datos</h1>
              </div>
              <div v-if="bd === false" class="col-sm-6 mb-4">
              <a href="/backup"><button
                    class="button ml-4 text-xl" :class="{ '': form.processing }"
                    :disabled="form.processing">
                    <i class="bi bi-arrow-down-circle"></i> <span class="animate-spin mr-1" v-show="form.processing">&#9696;</span> Generar Respaldo
                </button></a>
                <button
                    @click="restorebd(true)"
                    class="button ml-4 text-xl" :class="{ '': form.processing }"
                    :disabled="form.processing">
                    <i class="bi bi-arrow-up-circle"></i> <span class="animate-spin mr-1" v-show="form.processing">&#9696;</span> Recuperar Base de Datos
                </button>
               </div>
            <div class="col-sm-6 mb-4" v-if="bd === true">
            <form enctype="multipart/form-data">
                <jet-input type="file" accept=".sql" @change="saveStorage" @input="form.archivo = $event.target.files[0]"  class="form-control form-control-lg" required />
                <button
                    @click="guardar"
                    class="button ml-4 text-xl" :class="{ '': form.processing }"
                    :disabled="form.processing">
                    <i class="bi bi-arrow-up-circle"></i><span class="animate-spin mr-1" v-show="form.processing">&#9696;</span> Recuperar Base de datos
                </button>

                <button
                    v-if="bd  === true"
                    @click="restorebd(false)"
                    class="button ml-4 text-xl" :class="{ '': form.processing }"
                    :disabled="form.processing"> Volver
                </button>
            </form>
            </div>
          </div>
        </div>
  </section>
  </main>
  </body>
  </template>

  <script>
  import Main from "../../Main.vue";
  import Admin from "@/Jetstream/Admin.vue";
  import Profe from "@/Jetstream/Profe.vue";
  import Head from '@/Jetstream/Head.vue';
  import Revisor from '@/Jetstream/Revisor.vue';
  import Alumno from '@/Jetstream/Alumno.vue';
  import JetInput from '@/Jetstream/Input.vue'
  import JetInputError from '@/Jetstream/InputError.vue'
  import JetLabel from '@/Jetstream/Label.vue'
  import { defineComponent } from 'vue'
  import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
  import { useForm } from "@inertiajs/inertia-vue3";
  import JetButton from '@/Components/Button.vue';

  export default defineComponent({
    name:"Dashboard",
    data() {
        return {
            bd: false,
        }
    },
    props: {
      user:{type: Object, required: true},
      instituto: { type: Object, required: true },
    },
    components: {
      Main,
      Admin,
      Profe,
      Head,
      Alumno,
      Revisor,
      JetInput,
      JetInputError,
      JetLabel,
      JetSecondaryButton,
      useForm,
      JetButton
    },
    setup(props) {
        const form = useForm({  archivo: "", url: "" });

        const guardar = () => {
            form.post(route('restore'));

        };

        return { form, guardar };
    },

     methods: {
        saveStorage(event) {
            let formData = new FormData();
            const archivo = event.target.files[0];
            formData.append('archivo', archivo);
            axios.post('/guardar-sql', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                console.log(this.requestform);
                this.form.url = response.data.url;

            }).catch(error => {
                // Manejar el error
            });

        },

        restorebd(state){
            this.bd = state;
        }
    }

  });

  </script>

  <style>
  h1{
    text-align: center;
  }

  .bx{
    font-size: 38px;
  }

  .button {
    background-color: rgb(23, 33, 123);
    padding: 0.7rem 1.5rem;
    color: white;
    margin: 15px 0px 15px 0px;
    border-radius: 0.25rem;
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.25), 0px 4px 4px rgba(0, 0, 0, 0.15), 0px 8px 8px rgba(0, 0, 0, 0.1), 0px 16px 16px rgba(0, 0, 0, 0.05);
    }
    
    .button:hover {
        background-color: #5b69c5;
    }

    .button:active {
        background-color: #4c59a3;
    }
  </style>
