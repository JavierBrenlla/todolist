<template>
  <body>
    <a :href="enlace(proyecto.proyectoID)" v-for="(proyecto, i) in proyectos"
          :key="i">
    <div class="proyectos" >
            <p class="texto">{{ proyecto.proyectoNombre }}</p>
            <hr>
            <p class="texto">{{ proyecto.proyectoDescripcion }}</p>
          </div>
          </a>
  </body>
</template>

<script>
export default {
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

      fetch("/obtener_proyectos", init)
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

    enlace: function($id){
      return "/proyecto/"+$id;
    }
  },
  created() {
    this.listarProyectos();
  },
};
</script>