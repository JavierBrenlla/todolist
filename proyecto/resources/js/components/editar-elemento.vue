<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      max-width="600px"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
          @click="eliminarTarea()"
        >
          <span class="material-icons-outlined"> edit </span>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Editar</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-text-field
                  label="Nombre"
                  v-model="nombre"
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-textarea
                  label="Descripcion"
                  v-model="descripcion"
                ></v-textarea>
              </v-col>

            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Cerrar
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="editarElemento()"
          >
            Modificar
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
      nombre: "",
      descripcion: ""
  }),
  methods: {
    eliminarTarea: function () {
      let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

      let init = {
        method: "POST",
        headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
          "X-CSRF-TOKEN": laravelToken,
        },
        body: `proyectoid=${this.proyectoid}`,
      };

      if(this.opcion == 0){

      fetch("/editar_proyecto", init)
        .then((res) => res.json())
        .then((res) => {
          console.log(res.resultados);
          this.nombre = res.resultados[0].nombre;
          this.descripcion = res.resultados[0].descripcion;
        })
        .catch(function (error) {
          console.log(error);
        });

      }else {
          fetch("/editar_lista", init)
        .then((res) => res.json())
        .then((res) => {
          console.log(res.resultados);
          this.nombre = res.resultados[0].nombre;
          this.descripcion = res.resultados[0].descripcion;
        })
        .catch(function (error) {
          console.log(error);
        });
      }
    },

    editarElemento: function(){

        let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

      let init = {
        method: "POST",
        headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
          "X-CSRF-TOKEN": laravelToken,
        },
        body: `proyectoid=${this.proyectoid}&nombre=${this.nombre}&descripcion=${this.descripcion}`,
      };

        if(this.opcion == 0){

      fetch("/modificar_proyecto", init)
        .then((res) => {
          this.$root.$children[1].listarProyectos();
        })
        .catch(function (error) {
          console.log(error);
        });

      }else {
          fetch("/modificar_lista", init)
        .then((res) => {
          this.$root.$children[1].listarProyectos();
        })
        .catch(function (error) {
          console.log(error);
        });
      }

      this.dialog = false;
    },
  },
  props: ["proyectoid", "opcion"],
};
</script>