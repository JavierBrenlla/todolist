<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn color="primary" dark v-bind="attrs" v-on="on">
          <span class="material-icons-outlined"> share </span>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Compartir</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6">
                <v-select
                  id="email"
                  v-model="seleccionado"
                  :items="this.emails"
                  label="Email"
                ></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="6">
                <input type="checkbox" name="checkbox" id="admin"> <label for="checkbox">Permitir editar</label>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">
            Cerrar
          </v-btn>
          <v-btn color="blue darken-1" text @click="compartir()">
            Compartir
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
    emails: [],
    seleccionado: "",
    admin: "0",
  }),
  methods: {
    convertirArray: function (res) {
      for (let index = 0; index < res.length; index++) {
        this.emails.push(res[index].email);
      }
    },

    obtenerEmails: function () {
      let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
      let init = {
        method: "POST",
        headers: {
          "Content-type": "application/json",
          "X-CSRF-TOKEN": laravelToken,
        },
      };

      fetch("/obtener_emails", init)
        .then((res) => res.json())
        .then((res) => {
          // console.log(res.resultados);
          this.convertirArray(res.resultados);
          console.log(this.emails);
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    compartir: function () {
      console.log(this.seleccionado);
      console.log(this.listaid);

      let admin = 0;

      if (document.getElementById("admin").checked) {
        admin = 1;
      }

      console.log(admin);

      let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

      let init = {
        method: "POST",
        headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
          "X-CSRF-TOKEN": laravelToken,
        },
        body: `email=${this.seleccionado}&admin=${
          admin
        }&listaID=${this.listaid}&opcion=${this.opcion}`,
      };

      fetch("/compartir", init)
          .then((result) => {
            console.log(result);
          })
          .catch(function (error) {
            console.log(error);
          });

      this.seleccionado = "";
      document.getElementById("admin").checked = false;
      this.dialog = false;
    },
  },
  created() {
    this.obtenerEmails();
    console.log(this.opcion);
    console.log(this.listaid);
  },
  props: ["listaid", "opcion"],
};
</script>