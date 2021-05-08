<template></template>

<script>
export default {
  data: () => ({
    proyectos: [],
  }),
  methods: {},
  created() {
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

    fetch("/obtener_proyectos", init)
      .then((res) => 
        res.json()
      )
      .then((res) => {
        console.log(res.resultados);
      })
      .catch(function (error) {
        console.log(error);
      });
  },
};
</script>