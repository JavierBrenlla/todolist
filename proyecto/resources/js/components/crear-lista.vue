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
          <span class="headline">Nueva Lista</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="12" md="12">
                <v-text-field label="Nombre" required id="nombre" v-model="nombre"></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea name="descripcion" label="Descripcion" id="descripcion" v-model="descripcion"></v-textarea>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">
            Cerrar
          </v-btn>
          <v-btn color="blue darken-1" text @click="crearLista()">
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
    nombre:"",
    descripcion:""
  }),
  methods: {
    crearLista: function () {
      let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

      let init = {
        method: "POST",
        headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
          "X-CSRF-TOKEN": laravelToken,
        },
        body: `titulo=${this.nombre}&descripcion=${
          this.descripcion
        }&proyectoID=${this.listaid}&userID=${this.userid}`,
      };

      fetch("/crear_listaProyecto", init)
          .then((result) => {
            console.log(this.$root);
          this.$root.$children[1].listarProyectos();
          })
          .catch(function (error) {
            console.log(error);
          });

      this.dialog = false;
      this.nombre = "";
      this.descripcion = "";
    },
  },
  props: ['listaid', 'userid'],
};
</script>