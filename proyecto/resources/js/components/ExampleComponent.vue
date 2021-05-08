<template>
  <!-- template que genera el boton de nuevo y todas sus funcuionalidades -->
  <v-row justify="space-around" class="d-flex flex-row-reverse mt-2 mr-3">
    <!-- boton del menu desplegable, tiene una animacion de slide y -->
    <v-menu transition="slide-y-transition" bottom>
      <template v-slot:activator="{ on, attrs }">
        <v-btn class="purple" color="primary" dark v-bind="attrs" v-on="on">
          Nuevo
        </v-btn>
      </template>
      <!-- lista de botones que se despliegan al pulsar en el boton NUEVO -->
      <!-- los botones tienen un evento click de nombre selectBtn asociado, docho evento  recibe un parametro que hace referencia al index del array que se recorre para generar los botones-->
      <!-- IMPORTANTE: el atributo :retain-focus evita que los botones se queden con el foco guardado una vez realizan el evento, esto causa el desbordamiento de la pila de llamadas de javascript -->
      <v-list>
        <v-list-item v-for="(item, i) in items" :key="i">
          <v-dialog v-model="dialog" max-width="600px" :retain-focus="false">
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                block
                color="primary"
                dark
                v-bind="attrs"
                v-on="on"
                @click="selectBtn(i)"
              >
                {{ item.title }}
              </v-btn>
            </template>
            <!-- parte que crea el dialogo -->
            <v-card>
              <v-card-title>
                <span class="headline">Crear</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field
                        label="Titulo*"
                        name="titulo"
                        :id="item.title"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="12">
                      <v-textarea
                        :id="item.nombre"
                        name="descripcion"
                        label="Descripcion"
                      ></v-textarea>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <!-- botones del dialogo, el boton de crear lanza el evento btnCrear -->
                <v-btn color="blue darken-1" text @click="dialog = false">
                  Cerrar
                </v-btn>
                <v-btn color="blue darken-1" text @click="btnCrear()">
                  Crear
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-row>
</template>

<script>
export default {
  data: () => ({
    items: [
      { title: "Proyecto", nombre: "proyectoArea" },
      { title: "Lista", nombre: "listaArea" },
    ],

    // variable que controla la apertura y cierre del dialogo
    dialog: false,

    // variable para controlar si se crea un proyecto o una tarea
    opcion: 10,
  }),
  methods: {

    // modifica la variable opcion en funcion del boton que pulse el usuario, como imput recibe el index del array que crea los botones (1 o 2) 
    selectBtn: function (selector) {

      // si selector es igual a 0 opcion pasa a valer 0
      if (selector == 0) {
        this.opcion = 0;

        // en caso contrario opcion vale 1
      } else {
        this.opcion = 1;
      }
    },

    btnCrear: function () {
      let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

      let init = {
        method: "POST",
        headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
          "X-CSRF-TOKEN": laravelToken,
        },
        body: `titulo=${document.getElementById("Lista").value}&descripcion=${
          document.getElementById("listaArea").value
        }`,
      };

      if (this.opcion == 0) {
        fetch("/crear_proyecto", init)
          .then((result) => {
            console.log(result);
          })
          .catch(function (error) {
            console.log(error);
          });
      }else{
        fetch("/crear_lista", init)
          .then((result) => {
            console.log(result);
          })
          .catch(function (error) {
            console.log(error);
          });
      }

      document.getElementById("Lista").value = "";
      document.getElementById("listaArea").value = "";

      this.dialog = false;
    },
  },
};
</script>