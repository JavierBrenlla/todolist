<template>
  <v-row justify="center" class="d-flex flex-row-reverse mt-2 mr-3">
    <v-dialog v-model="dialog" max-width="600px" :retain-focus="false">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" fab dark v-bind="attrs" v-on="on">
          <span style="font-size: 22px">+</span>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Nueva Tarea</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  v-model="tarea"
                  label="Nombre"
                  required
                  id="nombre"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">
            Cerrar
          </v-btn>
          <v-btn color="blue darken-1" text @click="crearTarea()">
            Crear
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  data: () => ({
    dialog: false,
    tarea: "",
  }),
  methods: {
    crearTarea: function () {
      let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

      let init = {
        method: "POST",
        headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
          "X-CSRF-TOKEN": laravelToken,
        },
        body: `titulo=${this.tarea}&listaID=${
          this.listaid
        }`,
      };

      this.dialog = false;

      fetch("/crear_tarea", init)
        .then((result) => {
          console.log(result);
          this.$root.$children[1].listarProyectos();
        })
        .catch(function (error) {
          console.log(error);
        });

      this.tarea = "";
    },
  },
  props: ["listaid"],
};
</script>