<template>
  <div>
    <article class="panel is-link" v-if="$auth.user.data.subscribed && !$auth.user.data.admin">
      <div class="panel-block is-active">
        Pack : {{ $auth.user.data.plan.description }}
      </div>
      <div class="panel-block">
        Prix : {{ parseInt($auth.user.data.plan.price, 10) / 100 }} € /
        {{ $auth.user.data.plan.cycle }}
      </div>
      <div class="panel-block">
        <p v-if="!$auth.user.data.ends_at">
          Prochaine facturation :
          {{ $auth.user.data.next_billing_date }}
          <a v-if="$auth.user.data.subscribed" @click="onSubmit" class="is-link"
            >Annuler</a
          >
        </p>
        <p v-else>
          Ton abonnement prendra fin le {{ $auth.user.data.ends_at }}
        </p>
      </div>
    </article>
    <div v-else><p>Aucun abonnement</p></div>
  </div>
</template>

<script>
export default {
  middleware: "auth",
  layout: "account",

  data() {
    return {
      loading: false,
    };
  },

  methods: {
    async onSubmit() {
      try {
        await this.$axios.post("/api/subscription/cancel");
        await this.$auth.fetchUser();
      } catch (e) {}
    },
  },

  async asyncData() {},
};
</script>
