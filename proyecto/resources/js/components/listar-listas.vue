<template>
  <body>
    <buscar-componente opcion="1"></buscar-componente>
    <h3 class="titulo">Tus listas</h3>
    <div v-for="(proyecto, i) in proyectos" :key="i">
      <a :href="enlace(proyecto.lista_id)">
        <div class="proyectos">
          <p class="texto">{{ proyecto.nombre }}</p>
          <hr />
          <p class="texto">{{ proyecto.descripcion }}</p>
        </div>
      </a>
      <div class="acciones">
      <span v-if="proyecto.admin == 1"><compartir-elemento :listaid="proyecto.lista_id" opcion="1" class="share"></compartir-elemento></span>
      <span v-if="proyecto.admin == 1"><editar-elemento :proyectoid="proyecto.lista_id" opcion="1" class="share"></editar-elemento></span>
      <span v-if="proyecto.admin == 1"><borrar-componente class="delete" :proyectoid="proyecto.lista_id" opcion="1"></borrar-componente></span>
      </div>
    </div>
  </body>
</template>

<script>
import editarElemento from './editar-elemento.vue';
export default {
  components: { editarElemento },
  data: () => ({
    proyectos: [],
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

      fetch("/obtener_listas", init)
        .then((res) => res.json())
        .then((res) => {
          // console.log(res.resultados);
          this.proyectos = res.resultados;
          console.log(this.proyectos);
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    enlace: function ($id) {
      return "/lista/" + $id;
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

      fetch("/buscar_lista", init2)
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