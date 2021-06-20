<template>
  <body>
    <buscar-componente opcion="1"></buscar-componente>
    <div v-for="(proyecto, i) in proyectos" :key="i">
      <a :href="enlace(proyecto.lista_id)">
        <div class="proyectos">
          <p class="texto">{{ proyecto.nombre }}</p>
          <hr />
          <p class="texto">{{ proyecto.descripcion }}</p>
        </div>
      </a>
      <div class="acciones">
      <span v-if="admin == 1"><compartir-elemento :listaid="proyecto.lista_id" opcion="1" class="share"></compartir-elemento></span>
      <span v-if="admin == 1"><editar-elemento :proyectoid="proyecto.lista_id" opcion="1" class="share"></editar-elemento></span>
      <span v-if="admin == 1"><borrar-componente class="delete" :proyectoid="proyecto.lista_id" opcion="1"></borrar-componente></span>
      </div>
    </div>
  </body>
</template>

<script>
import editarElemento from './editar-elemento.vue';
export default {
  components: { editarElemento },
  data: () => ({
    proyectos: [],
    admin: 0,
  }),
  methods: {
    listarProyectos: function () {
        console.log(this.listaid);
      let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
      let init = {
        method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      "X-CSRF-TOKEN": laravelToken,
    },
    body: `id=${this.listaid}`,
      };

      fetch("/obtener_listas_proyetos", init)
        .then((res) => res.json())
        .then((res) => {
          this.proyectos = res.resultados;
          console.log(this.proyectos);
          this.comprobarAdmin(this.proyectos[0].proyecto_id);
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    enlace: function ($id) {
      return "/lista/" + $id;
    },

    buscarProyecto: function(string){
    //  console.log(string);
     let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

      let init2 = {
        method: "POST",
        headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
          "X-CSRF-TOKEN": laravelToken,
        },
        body: `string=${string}&nombre=${this.nombre}&descripcion=${this.descripcion}`,
      };

      fetch("/buscar_listaProyecto", init2)
        .then((res) => res.json())
        .then((res) => {
          this.proyectos = res.resultados;
          // console.log(res.resultados);
          console.log(this.proyectos);
        })
        .catch(function (error) {
          console.log(error);
        });
   },

   comprobarAdmin: function(id){
     let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
      let init = {
        method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      "X-CSRF-TOKEN": laravelToken,
    },
    body: `id=${id}`,
      };

      fetch("/obtener_admin_proyecto", init)
        .then((res) => res.json())
        .then((res) => {
          this.admin = res.resultados[0]['admin'];
          if (!this.admin) {
            document.getElementById("btn-lista").classList += " ocultar-elemento"
          }
        })
        .catch(function (error) {
          console.log(error);
        });
   }
  },
  created() {
    this.listarProyectos();
  },
  props: ["listaid"],
};
</script>