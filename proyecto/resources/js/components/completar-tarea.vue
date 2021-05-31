<template>
  <span>
    <v-btn class="mx-2" fab dark small color="primary" @click="completarTarea()">
      <span class="material-icons-outlined"> done </span>
    </v-btn>
  </span>
</template>

<script>
export default {
  data: () => ({

  }),
  methods: {
    completarTarea: function (){
        let id = this.tareaid;

  let init = {
    method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      "X-CSRF-TOKEN": laravelToken,
    },
    body: `tareaid=${id}`,
  };

      console.log(id);

      fetch("/completar_tarea", init)
        .then((res) => {
          console.log(res);
          this.$root.$children[1].listarProyectos();
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
  props: ["tareaid"],
};
</script>