<template>
  <body>
    <table class="table table-striped table-dark">
      <tr>
        <th>Tarea</th>
        <th>Acciones</th>
      </tr>

      <tr v-for="(proyecto, i) in proyectos" :key="i">
        
        <td v-if="proyecto.fin == 1" class="tareas algo">{{ proyecto.nombre }}</td>
        <td v-else class="algo">{{ proyecto.nombre }}</td>
        <td>
          
            <completar-tarea :tareaid="proyecto.id"></completar-tarea>
            <eliminar-tarea :tareaid="proyecto.id"></eliminar-tarea>
          
        </td>
      </tr>

    </table>
  </body>
</template>

<script>
export default {
  data: () => ({
    proyectos: [],
  }),
  methods: {
    listarProyectos: function () {
      let id = this.listaid;

      let init = {
        method: "POST",
        headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
          "X-CSRF-TOKEN": laravelToken,
        },
        body: `listaid=${id}`,
      };

      console.log(id);

      fetch("/obtener_tareas", init)
        .then((res) => res.json())
        .then((res) => {
          console.log(res.resultados);
          this.proyectos = res.resultados;
          console.log(this.proyectos);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
  created() {
    this.listarProyectos();
  },
  props: ["listaid"],
};
</script>