<template>
  <section class="section" id="section2" style="padding: 0; margin: 0;">
    <div class="columns is-centered">
      <div class="column is-6">
        <div v-for="plan in buyablePlans" :key="plan.slug">
          <nuxt-link
            :to="{ name: 'checkout-plan', params: { plan: plan.slug } }"
          >
            <plan :plan="plan" />
          </nuxt-link>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Plan from "../../components/Plan.vue";

export default {
  components: {
    Plan,
  },

  computed: {
    buyablePlans() {
      return this.plans.filter((p) => !p.free);
    },
  },

  async asyncData({ $axios }) {
    let { data } = await $axios.get("/api/plans");
    return { plans: data.data };
  },
};
</script>
