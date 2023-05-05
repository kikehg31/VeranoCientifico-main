<template>
  <!--<app-layout title="Catálogo de Documentos Probatorios">
    <template #header>
      <h2 class="h4 font-weight-bold">
        <i class="bi bi-file-text-fill"></i> {{ titulo }}
      </h2>
    </template>
    <div class="card shadow-sm">
      <div class="row">
        <div class="col-md-12 pe-0">
          <div class="card-body border-right border-bottom p-3 h-100">
            <form class="row g-3 needs-validation" @submit.prevent="guardar">
              <div class="col-md-8">
                <jet-label for="Nombre del Documento" value="Nombre del Documento:" />
                <jet-input
                  v-model="form.descripcion"
                  :class="{ 'is-invalid': form.errors.descripcion}"
                  required
                  placeholder="Descripción del Documento"
                />
                <jet-input-error :message="form.errors.descripcion" />
              </div>
              
              <div class="px-6 py-4">
                <Link
                  :href="route(`${routeName}index`)"
                  class="btn btn-outline-secondary btn-sm me-2"
                >
                  <i class="bi bi-chevron-left"></i> Cancelar
                </Link>
                <jet-button
                  @click="guardar"
                  class="btn btn-outline-secondary btn-sm"
                  :class="{ 'text-white-50': form.processing }"
                  :disabled="form.processing"
                >
                  <i class="bi bi-save"></i> Guardar
                </jet-button>
              </div>
            </form>
          
          </div>
        </div>
      </div>
    </div>
  </app-layout>-->

  <div>
    <form>
      <input type="file" @change="onFileChange"/>
    </form>
    <pdf :src="pdfSrc" />
  </div>


</template>
<script>
import pdf from 'vue-pdf';

export default {
  components: {
    Pdf
  },
  data() {
    return {
      pdfSrc: null
    };
  },
  methods: {
    onFileChange(event) {
      const file = event.target.files[0];
      const reader = new FileReader();
      reader.onload = (e) => {
        this.pdfSrc = e.target.result;
      };
      reader.readAsArrayBuffer(file);
    }
  }
};


</script>

<style>
</style>