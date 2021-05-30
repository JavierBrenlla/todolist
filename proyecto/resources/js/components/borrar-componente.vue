<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="500">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="red lighten-2" dark v-bind="attrs" v-on="on">
          <span class="material-icons-outlined"> delete_forever </span>
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="headline grey lighten-2">
          Esta acción es irreversible, desea continuar?
        </v-card-title>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">
            Cancelar
          </v-btn>
          <v-btn color="primary" text @click="borrarElemento()">
            Continuar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    borrarElemento: function () {
      let proyectoid = parseInt(this.proyectoid);
      console.log(proyectoid);
      let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
      let init = {
    method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      "X-CSRF-TOKEN": laravelToken,
    },
    body: `id=${proyectoid}&opcion=${this.opcion}`,
  };

      fetch("/borrar_elemento", init)
        .then((res) => {
          console.log(res.resultados);
          this.$root.$children[1].listarProyectos();
        })
        .catch(function (error) {
          console.log(error);
        });

      this.dialog = false;

    },
  },
  props: ["proyectoid", "opcion"],
};
</script>