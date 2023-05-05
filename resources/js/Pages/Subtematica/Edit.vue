<template>
    <Head>   </Head>
  
    <Admin v-if="$page.props.user.rol == 1"> </Admin>
    
        <div class="contenido">
            <div class="forma1">
              <h2 class="h4 font-weight-bold text-center">
                <br><i class="bi bi-bricks"></i> {{ titulo }}
              </h2>
              <div class="card-body border-right border-bottom p-3 h-100">
                  <form class="row g-3 needs-validation" @submit.prevent="guardar">
                    <div class="col-md-8">
                      <jet-label for="nombre" value="*Nombre de la Subtemática:" /><br>
                      <jet-input id="nombre"
                        type="text" 
                        v-model="form.name" 
                        :class="{ 'is-invalid': form.errors.name  }" 
                        required />
                      <jet-input-error :message="form.errors.name " />
                    </div>
                    <div class="col-md-8">
                    <jet-label id="titulo" for="nombre" value="*Temática a la que pertenece:" /><br>
                    <div class="">
                      <select id="areaconoci" :class="{'is-invalid':form.errors.thematic_id}" v-model="form.thematic_id">
                      <option  v-for="tema in tematica" disabled  value="">{{ tema.name }}</option>
                      <option v-for="tema in tematicas"  v-bind:value="tema.id" v-bind:key="tema.id">{{ tema.name }}</option>
                      </select>
                    </div>
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
    import AppLayout from "@/Layouts/AppLayout.vue";
    import { Link } from "@inertiajs/inertia-vue3";
    import JetLabel from "@/Jetstream/Label.vue";
    import JetInput from "@/Jetstream/Input.vue";
    import JetInputError from "@/Jetstream/InputError.vue";
    import JetButton from "@/Jetstream/Button.vue";
    import { useForm } from "@inertiajs/inertia-vue3";
    import 'sweetalert2/dist/sweetalert2.min.css';
    import { defineComponent } from 'vue'
    import Swal from 'sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';
    import Admin from "@/Jetstream/Admin.vue";
    import Head from '@/Jetstream/Head.vue';
    
    export default {
      name: "Edit",
      props: {
        titulo: { type: String, required: true },
        subtematicas: { type: Object, required: true },
        routeName: { type: String, required: true },
        tematicas: { type: Object, required: true },
        tematica: { type: Object, required: true },
      },
      components: {
        AppLayout,
        Link,
        JetLabel,
        JetInput,
        JetInputError,
        JetButton,
        Head,
        Admin,
      },
      setup(props) {
        const form = useForm({ ...props.subtematicas });
        const guardar = () => {
          form.put(route("subtematicas.update", props.subtematicas.id));
        };
        return { form, guardar};
      },
    };
    </script>
    
    
    <style scoped>    
        
          /* FORMULARIO */
        
          .btncancelar{
            background-color: #920707;
            color: #ffffff;
            margin-left: 18px;
          }
  
          h2{
            font-size: 30px;
            text-align: center;
            font-weight: bolder;
            color: rgb(5, 5, 107);
            margin-top: -22px;
          }
        
          .btnguardar{
            background-color: #092252;
            color: #ffffff;
          }
  
        form input[id=]{
          display: inline;
          border-color: rgba(3, 3, 3, 0.466);
          background-color:#2b4f7400  ;
          color: #000000;
          width: 42rem;
          padding: 11px;
          margin: 17px;
          border-radius: 7px;
        }
    
        form label[for="nombre"]{
          padding: 0px;
          width: 50%;
          margin-left: 20px;
          margin-right: 150px;
          font-weight:bold;
          color: #092252;
          font-size: 16px;
        }

        form select{
        display: inline;
        border-color: rgba(3, 3, 3, 0.466);
        background-color:#2b4f7400  ;
        color: #000000;
        width: 25rem;
        padding: 11px;
        margin: 17px;
        border-radius: 6px;
      }
          .forma1{
          width: 55%;
          border-radius: 20px;
          box-sizing: border-box;
          background-color: #ffffff;
          margin-top: 10%;
          margin-left: 22%;
          box-shadow: 15px 14px 14px 12px #cbced1, -10px -10px 15px rgba(216, 213, 213, 0.041);
          }
        
          .contenido{
            background-color: #ffffff;
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
        
          [id="guardar"]:hover{
            background-color: rgba(6, 42, 107, 0.986);
            color: rgb(255, 255, 255);
            font-style: bold;
          }
  
          @media(max-width: 590px) and (orientation: landscape){
            form input[id=]{
            display: inline;
            border-color: rgba(3, 3, 3, 0.466);
            background-color:#2b4f7400  ;
            color: #000000;
            width: 15rem;
            padding: 11px;
            margin: 17px;
            border-radius: 7px;
        }
          }
  
  
          
          
        
        </style>