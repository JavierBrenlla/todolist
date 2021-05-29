<template>
  <body>
    <div v-for="(proyecto, i) in proyectos" :key="i">
      <a :href="enlace(proyecto.proyectoID)">
        <div class="proyectos">
          <p class="texto">{{ proyecto.proyectoNombre }}</p>
          <hr />
          <p class="texto">{{ proyecto.proyectoDescripcion }}</p>
        </div>
      </a>
      <compartir-elemento :listaid="proyecto.proyectoID" opcion="0"></compartir-elemento>
    </div>
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

    enlace: function ($id) {
      return "/proyecto/" + $id;
    },
  },
  created() {
    this.listarProyectos();
  },
};
</script>