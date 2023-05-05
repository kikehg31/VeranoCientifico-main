<template>
    <Head> </Head>
    <Alumno> </Alumno>
 <main>

   <body><br><br><br><br>
   <h2 class="h4 font-weight-bold">
        Listado de Proyectos 2023
      </h2><hr>
        <div v-if="success" class="alert d-flex alert-success" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
                {{ success }}
            </div>
        </div>
    <div class="card-body ">
        <div class="busqueda input-group w-50 ml-2 ">
            <input type="text" class="form-control form-control rounded-3"
            placeholder="Ingrese un parámetro de búsqueda" @change="search" v-model="filters.search"/>
                <select @change="search" class="form-select form-select-lg" placeholder="Seleccione una temática" id="areaconoci"  v-model="filters.tematica">
                    <option selected value="">Todas las temáticas</option>
                    <option v-for="tema in tematicas"  v-bind:value="tema.id" v-bind:key="tema.id">{{ tema.name }}</option>
                </select>
            <div class="input-group-append input-group-append-sm">
                <button type="submit" class="btn btn-icon btn-primary rounded-3 ms-3" @click="search">
                    <i class=' bx bx-search'></i>
                </button>
                    <div class="cont-carrito">
                        <button class="carrito" @click="showCart = !showCart, notify = false"><span v-if="notify == true" class="punto-rojo"></span><i class='bi bi-bag' style="font-size: 1.7em;"></i></button>
                    </div>
            </div>
        </div>
    </div><br>
    <div v-if="mostrarDetalle">
     <section class="container pb-5 mb-2 mb-md-4 mb-lg-5">
        <h2 class="h1 pb-3 pb-lg-4">{{ proyectoSeleccionado.title }}
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
     <div v-else class="row">
       <div v-for="proyecto in proyectoss" :key="proyecto.id" class="cardproyectos prueba col-10 col-lg-4">
         <aside class="ver"><p class="upper vertical">
          {{ proyecto.thematics.name }}
         </p></aside>
         <div class="info">
            <h3>{{ proyecto.title }}</h3><hr><br>
            <p><strong>Institución que la imparte: </strong> {{ proyecto.institutions.name }}</p>
            <p><strong>Subtemática: </strong> {{ proyecto.subthematics.name }} </p>
            <p><strong>Número de Alumnos Permitidos: </strong> {{ proyecto.studentnum}}</p>
            <p><strong>Modalidad: </strong> {{ proyecto.modality}} </p>
            <p><strong>Profesor: </strong>{{ proyecto.users.name }}</p>
            <div class="botones">
             <a id="detalles" @click.prevent="mostrarInfo(proyecto.id)" href="#" class="eye btn btn-primary detalles button ml-4 text-xl" data-bs-toggle="tooltip" data-bs-placement="left" title="Ver detalles">
               <i class="bi bi-eye"></i>&nbsp; Detalles
             </a>
            &nbsp; <button class="btn btn-danger btn-sm" @click="delItem(proyecto.id, proyecto.title)" v-if="cart.includes(proyecto.title)"><i class="bi bi-trash3"></i></button>
            &nbsp; <button class="btn btn-warning btn-sm" @click="addItem(proyecto.id, proyecto.title)" v-if="!cart.includes(proyecto.title) && ready === 'si' && proyecto.students < proyecto.studentnum "><i class="bi bi-plus-circle"></i></button>
            </div>
         </div>
       </div>
     </div>
     <div class="cart-container" v-if="showCart">

      <div  style="text-align:center;" v-if="cart.length">
        <h2>Proyectos Seleccionados</h2><hr><br>
        <div v-if="cart[1]" class="ind alert d-flex alert-warning" role="alert">
                <i class="bx bx-info-circle lead me-3"></i>
                <div>
                  <p class="alerta" >Utiliza el botón AZUL para asignar la prioridad a tus proyectos seleccionados, toma en cuenta lo siguiente: Arriba = Mayor prioridad, Abajo = Menor prioridad.</p>
                </div>
              </div>
          <div >
            <ul>
            <div >
                <li v-if="cart[0] != null" class="cart-item"><label class="my-label">Proyecto: {{ cart[0] }}</label><button class="del2 btn btn-danger" @click="delItem(form.proyecto1, cart[0])" v-if="cart[0]"><i class='bx bxs-trash' style="font-size: 1.7em;" ></i></button></li>
                <li v-if="cart[1] != null" class="cart-item"><label class="my-label">Proyecto: {{ cart[1] }}</label> <button class="up1 btn btn-primary"  v-if="cart[1]" @click="up(cart[1])"><i class='bx bxs-up-arrow-circle bx-tada' style="font-size: 2em;" ></i></button> <button class="del1 btn btn-danger" @click="delItem(form.proyecto2, cart[1])" v-if="cart[1]"><i class='bx bxs-trash' style="font-size: 1.7em;" ></i></button></li>
                <li v-if="cart[2] != null" class="cart-item"><label class="my-label">Proyecto: {{ cart[2] }}</label> <button class="up2 btn btn-primary" v-if="cart[2]" @click="up(cart[2])"><i class='bx bxs-up-arrow-circle bx-tada' style="font-size: 2em;" ></i></button><button class="del1 btn btn-danger" @click="delItem(form.proyecto3, cart[2])" v-if="cart[2]"><i class='bx bxs-trash' style="font-size: 1.7em;" ></i></button></li>

            </div>
          </ul>
          </div>
        </div>

        <div style="text-align:center;" v-else>
        <h2>Proyectos Seleccionados</h2><hr><br>
          <p><strong>No hay proyectos seleccionados</strong></p>
        </div>
        <button v-if="cart.length" class="add btn btn-warning" @click="guardar">Postularme</button><button class="close-button btn btn-danger" @click="showCart = false">Cerrar</button>
      </div>
   </body>
 </main>
 <div class="pie">
            <hr><br><br>
            <p class="footer">© Todos los derechos Reservados. Hecho con <i class='bx bxs-heart bx-flashing' style="color:#f30909" ></i> por el <a id="linktec" target="blank" href="https://cenidet.tecnm.mx/">TecNM/Cenidet</a></p><br><br>
    </div>
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
    import Alumno from '@/Jetstream/Alumno.vue';
    import { Inertia } from "@inertiajs/inertia";
    import { useForm } from "@inertiajs/inertia-vue3";
    import Swal from 'sweetalert2';
    import { computed, onMounted, reactive, toRefs, watch, ref } from "vue";
    import draggable from 'vuedraggable';
    import Pagination from "@/Shared/Pagination.vue";

    export default {
        name: "Create",
        data() {
            return {
                cart: [],
                proyectos: [],
                showCart: false,
                notify: false,
                proyectoSeleccionado: null,
                mostrarDetalle: false,
            }
        },
        props: {
            title: { type: String, required: true },
            routeName: { type: String, required: true },
            proyectoss: { type: Object, required: true },
            tematicas: { type: Object, required: true },
            loadingResults: { type: Boolean, required: true, default: true },
            tematica: { type: String, required: true },
            search: { type: String, required: true },
            status: { type: Boolean, required: true, default: true },
            ready: { type: String, required: true },
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
            Alumno,
            draggable,
            Pagination,
       },

        setup(props) {
            const form = useForm({
                proyecto1: '',
                proyecto2: '',
                proyecto3: ''
            });

            const thereAreResults = computed(() => props.proyectoss.total > 0);
            const state = reactive({
                filters: {
                    page: props.proyectoss.current_page,
                    search: props.search,
                    tematica: props.tematica,
                    status: props.status ?? 1,
                },
            });

            const search = () => {
                props.loadingResults = true;
                Inertia.replace(route(`proyectospro.index`, state.filters));
            };



            return {
                ...toRefs(state),
                search,
                thereAreResults,
                form,

            };
        },

        methods: {
            guardar(){
                this.showCart=false;
                let texto1 = '';
                let texto2 = '';
                let texto3 = '';
                this.cart[0] ? texto1 = '<h4>MAYOR PRIORIDAD</h4><p>' + this.cart[0] : texto1 = '';
                this.cart[1] ? texto2 = '<h4>MEDIA PRIORIDAD</h4><p>' + this.cart[1] : texto2 = '';
                this.cart[2] ? texto3 = '<h4>MENOR PRIORIDAD</h4><p>' + this.cart[2] : texto3 = '';

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: 'Los proyectos quedan de la siguiente forma ¿Estas seguro?',
                    html: '<div>'+ texto1+'</p></div><div>'+ texto2+'</p></div><div>'+ texto3+'</p></div>',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Si' ,
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.form.post(route("envio"));
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                        'Se ha cancelado el envío de tus solicitudes.',
                        '',
                        'error'
                        )
                    }
                })
            },

mostrarInfo(proyId) {
    if (!this.proyectoss) {
        console.error("proyectoss no está inicializado");
        return;
    }
    const proyecto = this.proyectoss && this.proyectoss.find(p => p.id === proyId);
    this.proyectoSeleccionado = proyecto;
    this.mostrarDetalle = true;
    console.log(this.mostrarDetalle);
},



mostrarLista() {
  this.mostrarDetalle = false;
},


            addItem(id, title) {

                if (this.cart.length < 3) {
                    this.notify = true;
                    this.cart.push(title);

                    if(this.form.proyecto1 == ''){
                        this.form.proyecto1 = id;
                    }else if(this.form.proyecto2 == ''){
                        this.form.proyecto2 = id;
                    }else if(this.form.proyecto3 ==''){
                        this.form.proyecto3 = id;
                    }
                    Swal.fire({
                    icon: 'success',
                    title: 'Se ha seleccionado: ' + title,
                    timer: 900,
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('I was closed by the timer')
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Solo puedes elegir 3 Proyectos!',
                    })

                }

            },

            delItem(id, title) {
                var indice = this.cart.indexOf(title);
                if(indice == 0){
                    this.form.proyecto1 = this.form.proyecto2;
                    this.form.proyecto2 = this.form.proyecto3;
                    this.form.proyecto3 = '';
                    this.cart.splice(indice, 1);
                }else if(indice == 1){
                    this.form.proyecto2 = this.form.proyecto3;
                    this.form.proyecto3 = '';
                    this.cart.splice(indice, 1);
                }else if(indice == 2){
                    this.form.proyecto3 = ''
                    this.cart.splice(indice, 1);
                }
                    Swal.fire({
                    icon: 'warning',
                    title: 'Se ha eliminado: ' + title,
                    timer: 900,
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('I was closed by the timer')
                        }
                    })

            },

            up(proy) {
                let aux = '';
                if(this.cart[1] == proy){
                    aux = this.cart[0];
                    this.cart[0] = this.cart[1];
                    this.cart [1] = aux;
                    aux = this.form.proyecto1;
                    this.form.proyecto1 = this.form.proyecto2;
                    this.form.proyecto2 = aux;
                }
                if(this.cart[2] == proy){
                    aux = this.cart[1];
                    this.cart[1] = this.cart[2];
                    this.cart [2] = aux;
                    aux = this.form.proyecto2;
                    this.form.proyecto2 = this.form.proyecto3;
                    this.form.proyecto3 = aux;
                }
            },

            down(proy) {
              let aux = '';
              if(this.cart[0] == proy){
                aux = this.cart[1];
                this.cart[1] = this.cart[0];
                this.cart [0] = aux;
              }

              if(this.cart[1] == proy){
                aux = this.cart[2];
                this.cart[2] = this.cart[1];
                this.cart [1] = aux;
              }
            }

        }


     };
 </script>

 <style scoped>
.busqueda{
  float: right;
  margin-right: 12px;
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

.swal2-container {
  z-index: 9999;
}

.carrito{
    position: absolute;
    height: 45px;
    width: 50px;
    top: -360%;
    border-radius: 5px;
    text-align: center;
    color: white;
    border: none;
    background-color:rgb(8, 8, 102);
}
.cart-container{
    position: fixed;
}
.cont-carrito{
     position: fixed;
     top: 1.5%;
     right: 25%;
     z-index: 2;
}
.punto-rojo {
  display: inline-block;
  width: 15px;
  height: 15px;
  border-radius: 50%;
  background-color: red;
  margin-right: -12px;
  position: relative;
  top: -7px;
  float: right;
  transform: translate(-50%, -50%);
  animation: notificacion 0.4s ease-out, notificacion2 1s infinite ease-in-out;
}


 .volver{
    margin-top: -5%;
    margin-right: -4%;
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

.pagination{
    position: relative;
    left: 50px;
   }

.pagination-wrapper {
  display: flex;
  justify-content: center;
}

.my-label {
  background-color: #f5f5f5;
  padding: 5px;
  border-radius: 5px;
  font-size: 15px;
  font-weight: bold;
  width: 430px;
}

   h3{
    font-size: 18px;
    text-align: center;
   }

.up1{
    position: absolute;
    height: 35px;
    width: 55px;

    border-radius: 5px;
    right:120px;
}
.up2{
    position: absolute;
    height: 35px;
    width: 55px;

    border-radius: 5px;
    right:120px;
}

.del1{
    position: absolute;
    height: 35px;
    width: 55px;

    border-radius: 5px;
    right:40px;
}

.del2{
    position: absolute;
    height: 35px;
    width: 55px;

    border-radius: 5px;
    right:80px;
}

i{
  font-size: 15px;
}

.close-button{
    position: absolute;
    height: 42px;
    width: 45px;
    border-radius: 5px;
    right:20px;
}

.add{
    height: 42px;
    width: 85px;
    border-radius: 5px;
    margin-right: 15%;
}

.alerta{
  font-size: 13px;
}

.botones{
  margin-left: 28%;
  margin-top: 10%;
}

.eliminar{
   margin-right: 30px;
}

strong, p{
  color: #252440;
 }

.info{
    margin-left: 30px;
    width: 357px;
    margin-top: -380px;
   }

  p{
    text-align:center;
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
   background-color: #0fb3ff;
 }

 .footer{
  color:white;
 }

   .cart-container{
  position: absolute;
  top: 40%;
  right: 28%;
  width: 50%;
  background-color: white;
  border-radius: 10px;
  padding: 19px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  z-index: 9999;
 }



 ul{

  width: 75%;
 }

 li{
    margin-bottom: 20px;

 }

 h2{
  font-size: 30px;
  text-align: center;
  font-weight: bolder;
  margin-top: -22px;
  padding: 20px;
}

   .pie{
    text-align: center;
    margin-top: 1 %;
    color: white;
    background-color: #04023f;
  }

  a[id="linktec"]{
    color: white;
    background-color: #252440;
  }

 .ind{
  height: 70px;
 }
@keyframes notificacion {
  0% {
    transform: translate(-50%, -50%) scale(0);
    opacity: 0;
  }
  50% {
    transform: translate(-50%, -50%) scale(1.2);
    opacity: 1;
  }
  100% {
    transform: translate(-50%, -50%) scale(1);
    opacity: 0;
  }
}

@keyframes notificacion2 {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.2);
  }
  100% {
    transform: scale(1);
  }
}
 </style>
