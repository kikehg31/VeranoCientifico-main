<template>
    <Head> </Head>
    <Navbar> </Navbar>
 <main>
   <body><br><br><br><br>
   <div class="encabezado d-lg-flex align-items-center justify-content-between py-4 mt-lg-2 mt-3 mb-2 ml-4 mr-4">
          <h1 class="me-3">Profesores 2023</h1>
          <div class="busqueda d-md-flex mb-3">
            <select @change="search" class="form-select me-md-4 mb-2 mb-md-0" placeholder="Seleccione una temática" id="areaconoci" v-model="filters.tematica" style="min-width: 240px;">
              <option value="" selected>Todas las temáticas</option>
            <option v-for="tema in tematicas" v-bind:value="tema.id" v-bind:key="tema.id">{{ tema.name }}</option>
            </select>
            <div class="position-relative" style="min-width: 300px;">
              <input type="text" class="form-control pe-5"  placeholder="Ingrese un parámetro de búsqueda" @change="search" v-model="filters.search">
              <i class="bx bx-search text-nav fs-lg position-absolute top-50 end-0 translate-middle-y me-3"></i>
            </div>
          </div>
    </div><hr><br>

    <div v-if="mostrarDetalle">
    <section class="container pb-5 mb-2 mb-md-4 mb-lg-5">
        <h2 class="h1 pb-3 pb-lg-4">{{ profesorSeleccionado.name }} {{ profesorSeleccionado.lastnamep }} {{ profesorSeleccionado.lastnamem }}
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0L12.6798 4.12733C13.2879 7.81883 16.1812 10.7121 19.8727 11.3202L24 12L19.8727 12.6798C16.1812 13.2879 13.2879 16.1812 12.6798 19.8727L12 24L11.3202 19.8727C10.7121 16.1812 7.81882 13.2879 4.12733 12.6798L0 12L4.12733 11.3202C7.81883 10.7121 10.7121 7.81882 11.3202 4.12733L12 0Z"></path></svg>
        </h2><br>
        <div class="row">
          <div class="col-md-4 d-none d-md-block">
            <!-- Swiper tabs (Author images) -->
            <div class="swiper-tabs">
              <!-- Author 1 image -->
              <div id="author-1" class="card bg-transparent border-0 swiper-tab active">
                <img id="especifica" class="card-body p-0 rounded-3 bg-size-cover bg-repeat-0 bg-position-top-center" :src="profesorSeleccionado.photo">
              </div>
            </div>
          </div>
          <div class="infpro col-md-7">
            <div class="infpro card border-0 shadow-sm mt-4 pt-5 p-4 p-xxl-5 ms-xxl-5">
              <span class="btn btn-icon btn-primary btn-lg shadow-primary pe-none position-absolute top-0 translate-middle-y">
                <i class="bx bxs-quote-left"></i>
              </span>
                <div class="swiper-wrapper">
                  <div class="swiper-slide h-auto" data-swiper-tab="#author-1">
                    <figure class="card h-100 position-relative border-0 bg-transparent">
                      <blockquote class="card-body p-0 mb-0">
                        <p class="fs-lg mb-0"><strong>Institución de Procedencia:</strong> {{ profesorSeleccionado.institutions.name}}</p>
                        <p class="fs-lg mb-0"><strong>Email:</strong> {{ profesorSeleccionado.email}}</p>
                        <p class="fs-lg mb-0"><strong>Puesto:</strong> {{ profesorSeleccionado.job}}</p>
                        <p class="fs-lg mb-0"><strong>Grado Máximo de Estudios:</strong> {{ profesorSeleccionado.maxgrade}}</p>
                        <p class="fs-lg mb-0"><strong>Área Prioritaria:</strong> {{ profesorSeleccionado.invline}}</p>
                        <p class="fs-lg mb-0"><strong>Área:</strong> {{ profesorSeleccionado.thematics.name}}</p>
                        <p class="fs-lg mb-0"><strong>Área:</strong> {{ profesorSeleccionado.snilevel}}</p>
                      </blockquote>
                    </figure>
                    <button class="volver btn btn-sm btn-danger float-end" @click="mostrarLista"><i class="bi bi-arrow-left-square"></i>&nbsp; Regresar</button>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div v-else class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 gx-3 gx-md-4 mt-n2 mt-sm-0">
    <div >
        <div v-for="profe in profesores.data" :key="profe.id" class="card1 col pb-3">
            <article class=" card border-0 shadow-sm h-100">
              <div class="position-relative">
                <a id="detalles" @click.prevent="mostrarInfoProfesor(profe.id)" href="#" class="eye btn btn-primary btn-sm position-absolute top-0 end-0 zindex-2 me-3 mt-3" data-bs-toggle="tooltip" data-bs-placement="left" title="Ver detalles">
                  <i class="bi bi-eye"></i>
                </a>
                <img :src="profe.photo" class="card-img-top" alt="Image">
              </div>
              <div class="card-body pb-4">
                <h3 class="h5 mb-0">
                  <p class="bg-secondary">{{ profe.name }} {{ profe.lastnamep }} {{ profe.lastnamem }}</p>
                </h3>
            </div>
              <div class="card-footer py-4">
                <p><i class="bx bx-map-pin fs-xl me-1"></i> <strong>{{ profe.institutions.name }}</strong></p>
              </div>
            </article>
        </div>
       </div>
    </div>
   </body>
 </main>
 </template>

 <script>
  import { Link } from '@inertiajs/inertia-vue3'
   import 'sweetalert2/dist/sweetalert2.min.css';
   import AppLayout from "@/Layouts/AppLayout.vue";
   import JetLabel from "@/Jetstream/Label.vue";
   import JetInput from "@/Jetstream/Input.vue";
   import JetInputError from "@/Jetstream/InputError.vue";
   import JetButton from "@/Jetstream/Button.vue";
   import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
   import Head from '@/Jetstream/Head.vue';
   import Navbar from '@/Jetstream/Navbar.vue';
   import { Inertia } from "@inertiajs/inertia";
   import { useForm } from "@inertiajs/inertia-vue3";
   import Swal from 'sweetalert2';
   import { computed, onMounted, reactive, toRefs, watch } from "vue";


     export default {
        data() {
    return {
      profesorSeleccionado: null,
      mostrarDetalle: false,
    };
  },
       name: "Create",
       props: {
            title: { type: String, required: true },
            routeName: { type: String, required: true },
            profesores: { type: Object, required: true },
            loadingResults: { type: Boolean, required: true, default: true },
            search: { type: String, required: true },
            status: { type: Boolean, required: true, default: true },
            tematica: { type: String, required: true },
            tematicas: { type: Object, required: true },
        },
       components: {
         AppLayout,
         Head,
         Link,
         JetLabel,
         JetInput,
         JetInputError,
         JetButton,
         JetDropdownLink,
         Navbar,
         Swal
       },

     methods: {
        mostrarInfoProfesor(profeId) {
        console.log(profeId);
        const profesor = this.profesores.data.find(p => p.id === profeId);
        this.profesorSeleccionado = profesor;
        this.mostrarDetalle = true;
        },

        mostrarLista() {
            this.mostrarDetalle = false;
        },
    },

       setup(props) {
          const form = useForm({ ...props.profesores });
            const thereAreResults = computed(() => props.profesores.total > 0);
            const state = reactive({
                filters: {
                    page: props.profesores.current_page,
                    search: props.search,
                    tematica: props.tematica,
                    status: props.status ?? 1,
                },
            });

            const search = () => {
                props.loadingResults = true;
                Inertia.replace(route(`profesores`, state.filters));
            };

            return {
                ...toRefs(state),
                search,
                thereAreResults,
                form
            };
          },
     };
 </script>

 <style scoped>

 img[id="especifica"]{
    height:60%;
    width:80%;
 }

 .eye{
    font-size:20px;
 }

 .volver{
    margin-top: -4%;
    margin-right: -4%;
 }

 .busqueda{
    margin-right: 3%;
 }

 .infpro{
    box-shadow: 0 0 8px rgba(0, 0, 0.5, 0.5);
 }

 .encabezado{
    margin-left:40px;
 }

 svg{
    color:#f6a700;
    width:30px;
    height:30px;
}

 .card1{
     margin-left: 40px;
     margin-top: 15px;
     margin-bottom: 45px;
     background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transform-style: preserve-3d;
    transform: perspective(1000px) rotateY(0deg);
    transition: all 0.5s ease;
    padding-bottom: 2%;
   }

   .card1:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

  h5{
    text-align: center;
    margin-top: 1%;
    padding: 1%;
  }

   h2{
    text-align: center;
   }

   h6{
    text-align: center;
   }

   img{
    width:50%;
    height:90%;
    display: block;
    margin: 0 auto;
    margin-top: 10px;

   }

  .info{
    margin-left: 30px;
    width: 357px;
    margin-top: -380px;
   }

  p{
    margin-left:10px;
    text-align:center;
  }

 strong, p{
  color: #252440;
}

 </style>
