<template>
    <Head> </Head>
    <Admin v-if="$page.props.user.id_rol == 1"></Admin>
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
                  <a v-if="$page.props.user.id_rol == 1" :href="route('reportes.index')" class="list-group-item list-group-item-action d-flex align-items-center active">
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
            <div class="col-md-8 offset-lg-1 pb-5 mb-2 mb-lg-4 pt-md-5 mt-n3 mt-md-0">
              <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                <h1 class="h2 pt-xl-1 pb-1" style='color:#11044a'><i class='bx bxs-report' style='color:#07179a'></i> Reportes en PDF</h1>
              </div>
                <div class="canv">
                    <canvas class="chart-canvas" ref="myChart"></canvas>
                    <button @click="downloadPDF" class="button ml-4 text-xl"><i class="bi bi-arrow-down-circle"></i>
                    Descargar PDF</button>
                 </div>
          </div>
        </div>
  </section>
  </main>
  </body>
  </template>

  <script>
import Chart from 'chart.js/auto';
import jsPDF from 'jspdf';
import 'pdfjs-dist/build/pdf.worker.min.js';
  import Main from "../Main.vue";
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

export default {
  props: {
    proyectos: Array,
    user:{type: Object, required: true},
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
  mounted() {
    const canvas = this.$refs.myChart;
    if (!canvas) {
      console.error('No se encontró el elemento canvas');
      return;
    }


    const institution = this.proyectos.map(project => project.institution);
    const counts = this.proyectos.map(project => project.total);

    const ctx = canvas.getContext('2d');

    const myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: institution,
        datasets: [{
          label: 'Proyectos por institución',
          data: counts,
          backgroundColor: [
            'rgba(5, 242, 205, 0.8)',
            'rgba(220, 34, 121, 0.8)',
            'rgba(11, 241, 14, 0.8)',
            'rgba(245, 183, 8, 0.8)',
            'rgba(154, 8, 245, 0.8)',
            'rgba(245, 25, 8, 0.8)',
            'rgba(2, 4, 188, 0.8)'
          ],

          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            type: 'linear',
            ticks: {
            stepSize: 1
            }
          },
          x: {
            ticks: {
            autoSkip: false,
            maxRotation: 90,
            minRotation: 90
            }
          }
        },
      }
    });
  },
methods: {
  downloadPDF() {
    // Obtener el canvas y crear la imagen en base64
    const canvas = this.$refs.myChart;
    const dataURL = canvas.toDataURL('image/png');

    // Crear un objeto jsPDF
    const pdf = new jsPDF({
        orientation: 'landscape'
    });

    // Agregar imagen como encabezado
    const img = new Image();
    img.src = '/storage/institucion.png';
    const imgWidth = 210; // Ancho de la imagen
    const imgHeight = 60; // Alto de la imagen
    const pdfWidth = pdf.internal.pageSize.getWidth(); // Ancho de la página
    const pdfHeight = pdf.internal.pageSize.getHeight(); // Alto de la página

    img.onload = function() {
        pdf.addImage(this, 'PNG', 20, 10, 260, 38);

        // Agregar el gráfico centrado debajo de la imagen
        const chartWidth = 230; // Ancho del gráfico
        const chartHeight = 120; // Alto del gráfico
        const xPos = (pdfWidth - chartWidth) / 2; // Calcular posición horizontal centrada
        const yPos = (pdfHeight - chartHeight + 40) / 2; // Calcular posición vertical centrada
        pdf.addImage(dataURL, 'PNG', xPos, yPos, chartWidth, chartHeight);

        // Guardar el documento PDF
        pdf.save('ProyectosInstitucion.pdf');
    };

}
}
}
</script>
<style>
.canv{
  width: 700px;
  height: 800px;
}
</style>


