<template>
  <div class="section">
    <div class="container">
      <h1 v-if="error.statusCode === 404" class="title">Erreur 404</h1>
      <h1 v-else>Une erreur s'est produite.</h1>
    </div>
  </div>
</template>

<script>
export default {
  props: ["error"],
  layout: "error", // you can set a custom layout for the error page
};
</script>
