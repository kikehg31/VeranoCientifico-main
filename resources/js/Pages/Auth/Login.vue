<template>
  <Head> </Head>

  <Navbar> </Navbar>

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
   <div class="container2">
     <div class="row align-items-stretch">
       <div class="col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded">

       </div>

     <div class="col bg-white pd-5 rounded-end">
     <jet-validation-errors class="mb-3" />
        <div v-if="$page.props.flash.success" class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
                {{ $page.props.flash.success }}
            </div>
        </div>

        <div v-if="status" class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
                {{ status }}
            </div>
        </div>

       <div class="card-body">
         <h1>Bienvenidos</h1>



       <form @submit.prevent="submit">

        <div class="campos">
         <div class="mb-2">
           <jet-label id="correo" for="correo" value="Correo:" />
           <jet-input id="email" type="email" v-model="form.email" required autofocus placeholder="Introduzca su correo"/><br>
         </div>

         <div class="mb-2">
           <jet-label id="contraseña" for="password" value="Contraseña:" />
           <jet-input id="password" type="password" v-model="form.password" required autocomplete="current-password" placeholder="Introduzca su password" />
         </div><br>
        </div>

         <!----<div class="mb-4">
           <div class="custom-control custom-checkbox">
             <jet-checkbox id="remember_me" name="remember" v-model:checked="form.remember" />

             <label class="custom-control-label" for="remember_me">
               Recordar Contraseña
             </label>
           </div>
         </div>-->

         <div class="d-grid">
          <jet-button class="ms-4 btningreso" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
               <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                 <span class="visually-hidden">Loading...</span>
               </div>
               Ingresar
            </jet-button>

            <a id="registro" :href="route('registro.create')" class="ms-4 btn btn-secondary">
                REGISTRATE AQUI
            </a>
         </div>
          <div class="my-3">
           <div class="d-flex justify-content-end align-items-baseline ">
             <Link v-if="canResetPassword" :href="route('password.request')" class="olvidar">
               ¿Has olvidado tu contraseña?
             </Link>
           </div><br>
           <p class="pie">© Todos los derechos Reservados. Hecho con <i class='bx bxs-heart bx-flashing' style='color:#f30909' ></i> por el <a id="linktec" target="blank" href="https://cenidet.tecnm.mx/">TecNM/Cenidet</a></p>
         </div>
         </form>
         </div>
       </div>
     </div>
   </div>
  </body>
 </template>


 <script>
 import { defineComponent } from 'vue'
 import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
 import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
 import JetButton from '@/Jetstream/Button.vue'
 import JetInput from '@/Jetstream/Input.vue'
 import JetCheckbox from '@/Jetstream/Checkbox.vue'
 import JetLabel from '@/Jetstream/Label.vue'
 import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
 import { Link } from '@inertiajs/inertia-vue3';
 import Navbar from '@/Jetstream/Navbar.vue';
 import Head from '@/Jetstream/Head.vue';
 import Swal from 'sweetalert2';
 import 'sweetalert2/dist/sweetalert2.min.css';

 export default defineComponent({
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
     Navbar
   },
   props: {
     canResetPassword: Boolean,
     status: String
   },
   data() {
     return {
       form: this.$inertia.form({
         email: '',
         password: '',
         remember: false,
       })
     }
   },
   methods: {
     submit() {
       this.form
           .transform(data => ({
             ... data,
             remember: this.form.remember ? 'on' : ''
           }))
           .post(this.route('login'), {
             onFinish: () => this.form.reset('password'),
           })
     },
   }
 })
 </script>

 <style scoped>
   :root{
       --main-color: rgb(23, 33, 123);
       --second-color:rgba(29, 43, 172, 0.795);
       --black: #000000;
       --white: #ffffff;
     }

     /*Form inicio*/
   .bg{
       background-image: url(../../../../public/img/login.jpg);
       background-position: center center;
   }

   .olvidar{
    color: #010049;
    font-size: large;
    font-weight: bold;
    margin-left: -15rem;
   }

   .campos{
    margin-top: -7%;
   }

   .container2{
     width: 75%;
     margin-top: 7%;
     margin-left: 15%;
     box-shadow: 14px 14px 20px #cbced1, -14px -14px 20px rgba(216, 213, 213, 0.137);
   }

   h1{
     font-weight: bold;
     text-align: center;
     padding-top: 5px;
     margin-bottom: 5rem;
   }

   input[id="email"], [id="password"]{
     width: 95%;
     padding: 11px;
     margin-left: 15px;
     border-color: rgba(39, 38, 38, 0.363);
     background-color:#03203d00  ;
   }

  .btningreso{
    color: #5e8fe9;
  }

   label[id="contraseña"], [id="correo"]{
     margin-left: 15px;
     font-size: 17px;
      color: black;
   }

   h2{
     text-align: center;
     margin-top: -50px;
     font-size: 25px;
   }

   [id="btn"]:hover{
      background-color: rgba(6, 42, 107, 0.986);
      color: rgb(255, 255, 255);
      font-style: bold;
    }

    [id="registro"]:hover{
      background-color: rgba(124, 7, 7, 0.904);
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

    [id="registro"]{
      background-color: #7a1109;
      color: rgb(255, 255, 255);
      width: 96%;
      border-radius: 10px;
      padding: 12px;
      margin-left: 40px;
      margin-right: -8%;
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
      padding: 10px;
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
       height: 12px;
       top: 27px;
       border-radius: 5px;
       transition: all 0.3s;
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
       left:85%;
     }
     li[id="cont"]::before{
       transform: rotate(-45deg);
       left:89%;
     }
     li[id="cont"]:hover::after{
       transform: rotate(135deg);
     }
     li[id="cont"]:hover::before{
       transform: rotate(-135deg);
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
     .pie{
       font-size: 15px;
       color: #57585a;
     }

</style>
