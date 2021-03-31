<template>
  <v-row justify="space-around" class="d-flex flex-row-reverse mt-2 mr-3">
    <v-menu transition="slide-y-transition" bottom>
      <template v-slot:activator="{ on, attrs }">
        <v-btn class="purple" color="primary" dark v-bind="attrs" v-on="on">
          Nuevo
        </v-btn>
      </template>
      <v-list>
        <v-list-item v-for="(item, i) in items" :key="i">
          <v-dialog v-model="dialog" max-width="600px" :retain-focus="false">
            <template v-slot:activator="{ on, attrs }">
              <v-btn block color="primary" dark v-bind="attrs" v-on="on">
                {{ item.title }}
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">Crear</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field label="Titulo*" name="titulo" :id="item.title" required></v-text-field>
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
    items: [{ title: "Proyecto",nombre:"proyectoArea" }, { title: "Lista",nombre:"listaArea" }],

    dialog: false,
  }),
  methods:{
    btnCrear: function (){
      // console.log("hola mundo");

      console.log(document.getElementById("Lista").value);
      console.log(document.getElementById("listaArea").value);


      document.getElementById("Lista").value="";
      document.getElementById("listaArea").value="";

      this.dialog=false;
    },
  },
};
</script>