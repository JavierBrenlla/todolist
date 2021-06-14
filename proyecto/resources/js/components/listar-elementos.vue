<template>
  <body>
    <buscar-componente opcion="0"></buscar-componente>
    <h3 class="titulo">Tus proyectos</h3>
    <div v-for="(proyecto, i) in proyectos" :key="i">
      <a :href="enlace(proyecto.proyecto_id)">
        <div class="proyectos">
          <p class="texto">{{ proyecto.nombre }}</p>
          <hr />
          <p class="texto">{{ proyecto.descripcion }}</p>
        </div>
      </a>
      <div class="acciones">
      <span v-if="proyecto.admin == 1"><compartir-elemento :listaid="proyecto.proyecto_id" opcion="0" class="share"></compartir-elemento></span>
      <span v-if="proyecto.admin == 1"><editar-elemento :proyectoid="proyecto.proyecto_id" opcion="0" class="share"></editar-elemento></span>
      <span v-if="proyecto.admin == 1"><borrar-componente class="delete" :proyectoid="proyecto.proyecto_id" opcion="0"></borrar-componente></span>
      </div>
    </div>
  </body>
</template>

<script>
import EditarElemento from './editar-elemento.vue';
export default {
  data: () => ({
    proyectos: [],
    EditarElemento,
    buscar: [],
  }),
  methods: {
    listarProyectos: function () {
      let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
      let init = {
        method: "POST",
        headers: {
          "Content-type": "application/json",
          "X-CSRF-TOKEN": laravelToken,
        },
      };

      fetch("/obtener_proyectos", init)
        .then((res) => res.json())
        .then((res) => {
          console.log(res.resultados);
          this.proyectos = res.resultados;
          console.log(this.proyectos.admin);
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    enlace: function ($id) {
      return "/proyecto/" + $id;
    },

   buscarProyecto: function(string){
    //  console.log(string);
     let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

      let init2 = {
        method: "POST",
        headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
          "X-CSRF-TOKEN": laravelToken,
        },
        body: `string=${string}&nombre=${this.nombre}&descripcion=${this.descripcion}`,
      };

      fetch("/buscar_elemento", init2)
        .then((res) => res.json())
        .then((res) => {
          this.proyectos = res.resultados;
          // console.log(res.resultados);
          console.log(this.proyectos);
        })
        .catch(function (error) {
          console.log(error);
        });
   }
  },
  created() {
    this.listarProyectos();
  },
};
</script>