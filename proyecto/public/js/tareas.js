let laravelToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

if(document.getElementById("listaId") != null){

let init = {
  method: "POST",
  headers: {
    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
    "X-CSRF-TOKEN": laravelToken,
  },
  body: `listaid=${document.getElementById("listaId").value}`,
};

fetch("/cantidad_tareas", init)
  .then((res) => res.json())
  .then((res)=>{
    // console.log(res.resultados[0].id);
    for(let i=0; i<res.resultados.length;i++){
      document.getElementById("completar"+res.resultados[i].id).addEventListener("click", completarTarea, false)
      document.getElementById("borrar"+res.resultados[i].id).addEventListener("click", borrarTarea, false)
    }
  })
  .catch(function (error) {
    console.log(error);
});

}

function completarTarea() {

  let regex = /(\d)/g;

  let id = this.id;

  let init2 = {
    method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      "X-CSRF-TOKEN": laravelToken,
    },
    body: `id=${id.match(regex)[0]}`,
  };

  fetch("/completar_tarea", init2)
  .then((res)=>{
    console.log(res);
  })
  .catch(function (error) {
    console.log(error);
  });
}

function borrarTarea() {
  let regex = /(\d)/g;

  let id = this.id;

  let init2 = {
    method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      "X-CSRF-TOKEN": laravelToken,
    },
    body: `id=${id.match(regex)[0]}`,
  };

  fetch("/borrar_tarea", init2)
  .then((res)=>{
    console.log(res);
  })
  .catch(function (error) {
    console.log(error);
  });
}