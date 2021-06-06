<template>
  <body>
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
    EditarElemento
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

   /*  proba: function(){
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

      fetch("/probas", init)
        .then((res) => res.json())
        .then((res) => {
          console.log(res.resultados);
          for (let index = 0; index < res.resultados.length; index++) {
            this.proyectos[index].usuarioProyectosAdmin = res.resultados[index];
          }
          console.log(this.proyectos);
        })
        .catch(function (error) {
          console.log(error);
        });
    } */
  },
  created() {
    this.listarProyectos();
    // this.proba();
  },
};
</script>