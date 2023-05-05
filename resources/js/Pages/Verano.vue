<template>
    <Head> </Head>
    <Navbar> </Navbar>
    <main>
        <body><br><br><br><br>
            <div class="encabezado d-lg-flex align-items-center justify-content-between py-4 mt-lg-2 mt-3 mb-2 ml-4 mr-4">
                <h1 class="me-3">Propuestas de Verano 2023</h1>
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
        <h2 class="h2 pb-3 pb-lg-4">{{ proyectoSeleccionado.title }}
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0L12.6798 4.12733C13.2879 7.81883 16.1812 10.7121 19.8727 11.3202L24 12L19.8727 12.6798C16.1812 13.2879 13.2879 16.1812 12.6798 19.8727L12 24L11.3202 19.8727C10.7121 16.1812 7.81882 13.2879 4.12733 12.6798L0 12L4.12733 11.3202C7.81883 10.7121 10.7121 7.81882 11.3202 4.12733L12 0Z"></path></svg>
        </h2><br>
        <div class="row">
          <div class="infpro col-md-7">
            <div class="card border-0 shadow-sm mt-4 pt-5 p-4 p-xxl-5 ms-xxl-5">
                <div class="swiper-wrapper">
                  <div class="swiper-slide h-auto" data-swiper-tab="#author-1">
                    <figure class="card h-100 position-relative border-0 bg-transparent">
                      <blockquote class="card-body p-0 mb-0">
                        <p class="fs-lg mb-0"><strong>Número de estudiantes:</strong> {{ proyectoSeleccionado.studentnum}} alumnos</p>
                        <p class="fs-lg mb-0"><strong>Temática</strong> {{ proyectoSeleccionado.thematics.name}}</p>
                        <p class="fs-lg mb-0"><strong>Subtemática:</strong> {{ proyectoSeleccionado.subthematics.name}}</p>
                        <p class="fs-lg mb-0"><strong>Objetivo General:</strong> {{ proyectoSeleccionado.generalobject}}</p>
                        <p class="fs-lg mb-0"><strong>Modalidad:</strong> {{ proyectoSeleccionado.modality}}</p>
                        <p class="fs-lg mb-0"><strong>Requerimientos:</strong> {{ proyectoSeleccionado.requirements}}</p>
                        <p class="fs-lg mb-0"><strong>Profesor:</strong> {{ proyectoSeleccionado.users.name}} {{ proyectoSeleccionado.users.lastnamep}} {{ proyectoSeleccionado.users.lastnamem}}</p>
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
            <div  v-else class="proyect row">
                <br><br><h5 v-if="proyectos != ''">Listado de proyectos 2023</h5><h5 v-if="proyectos == ''"><i v-if="proyectos == ''" class='bx bxs-confused bx-tada' style='color:#0a0a0a; font-size: 4em;' ></i></h5><h5 v-if="proyectos == ''">No se ha encontrado ningun resultado.</h5>
                <div v-for="proyecto in proyectos.data" :key="proyecto.id" class="cardproyectos prueba col-10 col-lg-4" style="display: flex; flex-direction: column;">
                    <aside class="ver"><p class="upper vertical">{{ proyecto.thematics.name }}</p></aside>
                    <div class="info" style="flex-grow: 1;">
                        <h6 style="width: 90%">{{ proyecto.title }}</h6><hr><br>
                        <p><strong>Institución que la imparte:</strong> {{ proyecto.institutions.name }}</p>
                        <p><strong>Subtemática:</strong> {{ proyecto.subthematics.name }} </p>
                        <p><strong>Número de Alumnos Permitidos:</strong> {{ proyecto.studentnum}}</p>
                        <p><strong>Modalidad:</strong> {{ proyecto.modality}} </p>
                        <p><strong>Profesor:</strong> {{ proyecto.users.name }} {{ proyecto.users.lastnamep }} {{ proyecto.users.lastnamem }}</p>
                    </div>
                    <a id="detalles" @click.prevent="mostrarInfo(proyecto.id)" href="#" class="eye btn btn-primary detalles button ml-4 text-xl" data-bs-toggle="tooltip" data-bs-placement="left" title="Ver detalles">
                        <i class="bi bi-eye"></i>&nbsp; Detalles
                    </a>
                </div>
                <div class="pagination-wrapper">
                    <pagination :links="proyectos.links" class="pagination" />
                </div><br>
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
   import Pagination from "@/Shared/Pagination.vue";


     export default {
       name: "Create",
        data() {
            return {
                proyectoSeleccionado: null,
                mostrarDetalle: false,
            };
        },
        props: {
            title: { type: String, required: true },
            routeName: { type: String, required: true },
            proyectos: { type: Object, required: true },
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
            Swal,
            Pagination,
        },

        methods: {
            mostrarInfo(proyId) {
                console.log(proyId);
                const proyecto = this.proyectos.data.find(p => p.id === proyId);
                this.proyectoSeleccionado = proyecto;
                this.mostrarDetalle = true;
            },

            mostrarLista() {
                this.mostrarDetalle = false;
            },
        },

       setup(props) {
          const form = useForm({ ...props.proyectos });
            const thereAreResults = computed(() => props.proyectos.total > 0);
            const state = reactive({
                filters: {
                    page: props.proyectos.current_page,
                    search: props.search,
                    tematica: props.tematica,
                    status: props.status ?? 1,
                },
            });

            const search = () => {
                props.loadingResults = true;
                Inertia.replace(route(`verano.index`, state.filters));
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
 .eye{
    font-size:20px;
 }

 .volver{
    margin-top: -5%;
    margin-right: -4%;
 }

 blockquote{
    margin-top: -30px;
 }

 .busqueda{
    margin-right: 3%;
 }

 .infpro{
    box-shadow: 0 0 8px rgba(0, 0, 0.5, 0.5);
    margin-left: 20%;
 }

 .encabezado{
    margin-left:40px;
 }

 svg{
    color:#f6a700;
    width:30px;
    height:30px;
}

.pagination-wrapper {
  display: flex;
  justify-content: center;
}

 .cardproyectos{
     height: 400px;
     margin-left: 40px;
     margin-top: 15px;
     width: 400px;
     margin-bottom: 45px;
     background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transform-style: preserve-3d;
    transform: perspective(1000px) rotateY(0deg);
    transition: all 0.5s ease;
    padding-bottom: 2%;
     /*padding-top: 45px;*/
   }

   .cardproyectos:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
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

  .info{
    margin-left: 30px;
    width: 357px;
    margin-top: -380px;
   }

   .pagination{
    position: relative;
    left: 50px;
   }

  p{
    margin-left:10px;
    text-align:center;
  }

  .bsq{
    position: absolute;
    color: rgb(8, 8, 102);
    font-size: 20px;
    top: 39%;
    left: 177px;
    font-weight: bold;
  }

  .bsqt{
    position: absolute;
    color: rgb(8, 8, 102);
    font-size: 20px;
    top: 15%;
    left: 173px;
    font-weight: bold;
  }

  .bsqn{
    position: absolute;
    font-size: 16px;
    top: 40%;
    left: -120px;
  }

   .vertical {
     writing-mode: vertical-lr;
     transform: rotate(180deg);
     background-color: rgb(8, 8, 102);
     color: azure;
     height: 400px;
     width: 25px;
     margin-left: 8px ;
     text-align: center;
 }

 .ver{
   background-color: rgb(8, 8, 102);
   height: 400px;
   width: 40px;
   margin-left: -12px;
 }

 aside{
   margin: 0;
   padding: 0;

 }

 strong, p{
  color: #252440;
 }

  .detalles {
    background-color: rgb(23, 33, 123);
    color: #fff;
    padding: 0.5rem 0.8rem;
    border-radius: 0.25rem;
    font-size: 1rem;
    width: 30%;
    font-weight: 400;
    transition: all 0.3s ease;
    border: none;
    margin-left: 35%;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.25), 0px 4px 4px rgba(0, 0, 0, 0.15), 0px 8px 8px rgba(0, 0, 0, 0.1), 0px 16px 16px rgba(0, 0, 0, 0.05);
    }

.detalles:hover {
    background-color: #5b69c5;
}

.detalles:active {
    background-color: #4c59a3;
}

.busqueda{
  float: right;
  margin-right: 27px;
}

 </style>
