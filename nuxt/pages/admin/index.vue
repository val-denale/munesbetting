<template>
  <div class="box">

    <div class="columns has-text-centered is-vcentered">
      <div class="column">
        <div class="box">
          <h3 class="subtitle is-5">Utilisateurs</h3>
          <p class="subtitle is-3">{{ stats.users }}</p>
        </div>
      </div>
      <div class="column">
        <div class="box">
          <h3 class="subtitle is-5">Abonnements</h3>
          <p class="subtitle is-3">{{ stats.subscriptions }}</p>
        </div>
      </div>
      <div class="column">
        <div class="box">
          <h3 class="subtitle is-5">Abonnements actifs</h3>
          <p class="subtitle is-3">{{ stats.active_subscriptions }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  middleware: "admin",
  layout: "admin",

  async asyncData({ $axios, error, store }) {
    return await $axios
      .get("/api/admin/stats")
      .then((res) => {
        return { stats: res.data };
      })
      .catch((e) => {
        error({ statusCode: e.response.status });
      });
  },
};
</script>
