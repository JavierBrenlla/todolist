<template>
  <div>
    <v-text-field
      label="Buscar"
      hide-details="auto"
      v-model="nombre"
      @keyup="buscarElemento()"
      class="buscador"
    ></v-text-field>
  </div>
</template>

<script>
export default {
  data: () => ({
    nombre: "",
    value: null,
  }),
  methods: {
    buscarElemento: function () {
      this.$root.$children[1].buscarProyecto(this.nombre);
    },
  },
  created() {},
};
</script>