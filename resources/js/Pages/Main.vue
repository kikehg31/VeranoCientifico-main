<template>
  <div class="row justify-content-center my-5">
    <div class="col-md-12">
      <div class="card shadow bg-light">
        <div class="row g-0">
          

          <!-- Administración de Catálogos de convocatorias -->
          <div class="col-12 col-lg-6 pe-0">
            <div class="card-body border-right border-bottom p-3 h-100">
              <div class="d-flex flex-row bd-highlight mb-3">
                <div class="ps-3">
                  <div v-if="useCan('modulo.catalogos')">
                    <div class="card border-info mb-3">
                      <div class="card-header">
                        <h2><i class="bi bi-journal"></i>Administración de Catálogos</h2>
                      </div>
                      <div class="card-body">
                        <span v-for="(r, key) in catalogos" :key="key">
                          <Link v-if="useCan(`${r.name}`)" :href="route(r.name)" class="btn btn-outline-primary me-2">
                            <i class="bi" :class="r.icon"></i>&nbsp;{{r.description}}
                          </Link>
                        </span>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <!-- Administración de Permisos -->
          <div class="col-12 col-lg-6 pe-0">
            <div class="card-body border-right border-bottom p-3 h-100">
              <div class="d-flex flex-row bd-highlight mb-3">
                <div class="ps-3">
                  <div v-if="useCan('modulo.seguridad')">
                    <div class="card border-info mb-3">
                      <div class="card-header">
                        <h2><i class="bi bi-people-fill"></i>Seguridad</h2>
                      </div>
                      <div class="card-body">
                        <span v-for="(r, key) in authPermisos" :key="key">
                          <Link v-if="useCan(`${r.name}`)" :href="route(r.name)" class="btn btn-outline-primary me-2">
                            <i class="bi" :class="r.icon"></i>&nbsp;{{r.description}}
                          </Link>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <!-- Administración de Proyectos -->
          <div class="col-12 col-lg-6 pe-0">
            <div class="card-body border-right border-bottom p-3 h-100">
              <div class="d-flex flex-row bd-highlight mb-3">
                <div class="ps-3">
                  <div v-if="useCan('modulo.profesores')">
                    <div class="card border-info mb-3">
                      <div class="card-header">
                        <h2><i class="bi bi-people-fill"></i>Seguridad</h2>
                      </div>
                      <div class="card-body">
                        <span v-for="(p, key) in profesores" :key="key">
                          <Link v-if="useCan(`${p.name}`)" :href="route(p.name)" class="btn btn-outline-primary me-2">
                            <i class="bi" :class="p.icon"></i>&nbsp;{{p.description}}
                          </Link>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
</template>

<script>
import JetApplicationLogo from "@/Jetstream/ApplicationLogo.vue";
import { ref } from "@vue/reactivity";
import { Link } from "@inertiajs/inertia-vue3";
import {useCan} from '@/Hooks/usePermissions';

  export default{
    name:"Main",
    components: {
      JetApplicationLogo,
      Link
    },
    setup() {
      const authPermisos = ref([
        { name: "modulo.index", description: "Módulos", icon: "bi bi-bricks" },
        { name: "permissions.index", description: "Permisos", icon:"bi bi-check-circle-fill"},
        { name: "perfiles.index", description: "Roles", icon:"bi bi-person-lines-fill"},
        { name: "usuarios.index", description: "Usuarios", icon:"bi bi-people-fill"},
      ]);
      const catalogos = ref([
        { name: "convocatoria.index", description: "Convocatorias", icon: "bi bi-calendar" },
        { name: "evento.index", description: "Eventos", icon: "bi-calendar-event-fill" },
        { name: "calendario.index", description: "Calendario", icon: "bi bi-calendar-date" },
        { name: "documentos.index", description: "Documentos", icon: "bi bi-file-text-fill" },

      ]);

      const profesores = ref([
        { name: "proyectos.index", description: "Proyectos", icon: "bi bi-file-text-fill" },
      ]);
      return { authPermisos, profesores, catalogos, useCan};
    },
  }
</script>
