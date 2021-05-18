<template>
  <body>
    <!-- <a :href="enlace(proyecto.proyectoID)" v-for="(proyecto, i) in proyectos"
          :key="i">
    <div class="proyectos" >
            <p class="texto">{{ proyecto.proyectoNombre }}</p>
            <hr>
            <p class="texto">{{ proyecto.proyectoDescripcion }}</p>
          </div>
          </a> -->
  </body>
</template>

<script>
export default {
  data: () => ({
    proyectos: [],
  }),
  methods: {},
  created() {
    this.proyectos = this.listas.split(',');
    console.log(this.proyectos);
  },
  props: ["listas"],
};
</script>