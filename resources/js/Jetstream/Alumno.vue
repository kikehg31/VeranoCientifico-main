<template >
  <Head> </Head>
     <header class="header navbar navbar-expand-lg navbar-light bg-light border-bottom border-light shadow-sm fixed-top">
       <div class="container">
         <a href="/dashboard" class="navbar-brand nav-link p-0" id="logo">
           <img src="../../../public/img/logo.png" width="47" alt="Silicon">
             TecNM/Cenidet
         </a>
         <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse5" aria-expanded="false">
             <span class="navbar-toggler-icon"></span>
         </button>
         <div class="dropdown order-lg-3 ms-4" id="cont">
           <a href="#" class="d-flex nav-link p-0" data-bs-toggle="dropdown" >
             <img :src="$page.props.user.photo" class="rounded-circle" width="47" alt="Silicon">
               <div class="d-none d-sm-block ps-2">
                   <div class="fs-xs lh-1 opacity-60">Bienvenido,</div>
                   <div class="fs-sm dropdown-toggle">{{ $page.props.user.name}} {{ $page.props.user.lastnamep}}</div>
               </div>
           </a>
           <ul class="dropdown-menu" id="menu">
             <form @submit.prevent="logout">
               <jet-dropdown-link as="button">
                  Salir del Sistema
               </jet-dropdown-link>
             </form>
           </ul>
         </div>
       <nav id="navbarCollapse5" class="collapse navbar-collapse order-lg-2">
         <hr class="d-lg-none mt-3 mb-2">
           <ul class="navbar-nav me-auto">
             <li class="dropdown drop" id="cont1">
                 <a href="#" class="nav-link" data-bs-toggle="dropdown">Proyectos</a>
                   <ul class="dropdown-menu">
                     <li><a id="lista" :href="route('proyectospro.index')" class="nav-link">Ver proyectos</a></li>
                     <li><a id="lista" :href="route('solicitudes')" class="nav-link">Solicitudes</a></li>
                   </ul>
             </li>
             <li class="dropdown drop" id="cont1">
                 <a href="#" class="nav-link" data-bs-toggle="dropdown">Expediente</a>
                   <ul class="dropdown-menu">
                     <li><a id="lista" :href="route('docuser.index')" class="nav-link">Expediente</a></li>
                   </ul>
             </li>
           </ul>
     </nav>
   </div>
 </header>
     </template>

     <script>
   import { Link } from '@inertiajs/inertia-vue3'
   import 'sweetalert2/dist/sweetalert2.min.css';
   import axios from 'axios';
   import AppLayout from "@/Layouts/AppLayout.vue";
   import JetLabel from "@/Jetstream/Label.vue";
   import JetInput from "@/Jetstream/Input.vue";
   import JetInputError from "@/Jetstream/InputError.vue";
   import JetButton from "@/Jetstream/Button.vue";
   import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
   import Head from '@/Jetstream/Head.vue';



     export default {
       name: "Create",
       props: {
         title: { type: String, required: true },
         routeName: { type: String, required: true },
         tem: {type:Object, required:true},
         subtem: {type:Object, required:true},
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
       },

       methods: {
           logout() {
           this.$inertia.post(route('logout'));
           }
         },

     };

     </script>
   <style scoped>
   /*Barra de navegacion */
   .header{
     position: fixed;
   }

   .navbar{
     width: 100%;
     z-index: 1;
   }

   .drop{
     font-size: 15px;
     margin-right: 20px;
   }

   .drop1{
     font-size: 15px;
     margin-left: -50px;

   }

   a[id="text"]{
     font-size: bold;
     padding-top: 10px;
     display: block;
   }

   li{
     padding: 2px;
   }

   a[id="logo"]{
     margin-left: 0%;
     height: 50px;
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

   li[id="cont1"]::after, li[id="cont1"]::before{
     content: '';
     position: absolute;
     background-color: rgb(22, 9, 82);
     width: 3px;
     height: 12px;
     top: 16px;
     border-radius: 5px;
     transition: all 0.3s;
   }

   li[id="cont1"]{
     min-height: 45px;
     position: relative;
     width: 170px;
     margin-left: 12px;
     text-align: center;
     cursor: pointer;
     color: #092252;
   }

   li[id="cont1"]::after{
     transform: rotate(45deg);
     left:75%;
   }

   li[id="cont1"]::before{
     transform: rotate(-45deg);
     left:79%;
   }

   li[id="cont1"]:hover::after{
     transform: rotate(135deg);
   }

   li[id="cont1"]:hover::before{
     transform: rotate(-135deg);
   }

   li[id="cont"]::after, li[id="cont"]::before{
     content: '';
     position: absolute;
     background-color: rgb(22, 9, 82);
     width: 3px;
     height: 11px;
     top: 16px;
     border-radius: 5px;
     transition: all 0.3s;
   }

   li[id="cont"]{
     min-height: 45px;
     position: relative;
     width: 150px;
     margin-left: 12px;
     text-align: center;
     cursor: pointer;
     color: #092252;
   }

   li[id="cont"]::after{
     transform: rotate(45deg);
     left:71%;
   }

   li[id="cont"]::before{
     transform: rotate(-45deg);
     left:75%;
   }

   li[id="cont"]:hover::after{
     transform: rotate(135deg);
   }

   li[id="cont"]:hover::before{
     transform: rotate(-135deg);
   }

 </style>

