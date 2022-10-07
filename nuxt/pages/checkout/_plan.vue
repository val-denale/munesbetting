<template>
  <section class="section" id="section2" style="padding: 0">
    <div class="columns is-flex is-vcentered is-centered">
      <div class="column is-two-thirds-mobile is-half-tablet">
        <div class="box">
          <div class="has-text-centered">
            <h2 class="title is-4">{{ plan.description }}</h2>
            <p>{{ parseInt(plan.price, 10) / 100 }} € / {{ plan.cycle }}</p>
          </div>
          <template v-if="StripeError" >
            <b-message type="is-danger" class="mt-2">
              {{ StripeError }}
            </b-message>
          </template>
          <form @submit.prevent="onSubmit" class="mt-5">
            <b-field
              label="Nom complet"
              label-for="name"
              :type="{ 'is-danger': form.errors.has('name') }"
              :message="[
                form.errors.has('name') ? form.errors.get('name') : '',
              ]"
            >
              <b-input
                type="text"
                placeholder="Nom complet inscrit sur la carte"
                v-model="form.name"
                id="name"
              ></b-input>
            </b-field>

            <div class="field">
              <label for="card" class="label">Détail de la carte</label>
              <div id="card" ref="card"></div>
            </div>

            <b-button
              class="mt-5"
              type="is-link"
              native-type="submit"
              :disabled="form.errors.any() || loading"
              :loading="loading"
              >Payer</b-button
            >
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Form from "../../helpers/Form";

export default {
  middleware: ["auth", "notSubscribed"],

  data() {
    return {
      loading: false,
      StripeError: null,
      plan: this.$store.state.plan.plan,

      intent: {
        client_secret: this.$store.state.stripe.client_secret,
      },

      card: {},

      form: new Form({
        name: "",
      }),
    };
  },

  methods: {
    async onSubmit() {
      this.loading = true;

      const { setupIntent, error } = await this.$stripe.confirmCardSetup(
        this.intent.client_secret,
        {
          payment_method: {
            card: this.card,
            billing_details: { name: this.form.name },
          },
        }
      );

      if (error) {
        this.loading = false;
        if (error) {
          this.StripeError = "Il y a eu un problème lors du paiement. Vérifier votre carte et réessayer."
        }
      } else {
        this.StripeError = null
        await this.createSubscription(setupIntent.payment_method);
        this.loading = false;
      }
    },

    async createSubscription(token) {
      await this.$axios.$post("api/subscriptions", {
        plan: this.plan.slug,
        token,
      });
      await this.$auth.fetchUser();

      await this.$router.push({name: "account"});
    },
  },

  async mounted() {
    if (this.$stripe) {
      const elements = this.$stripe.elements();
      this.card = elements.create("card");
      this.card.mount(this.$refs.card);
    }
  },

  async asyncData({ params, $axios, store, error }) {
    try {
      const res = await $axios.get(`/api/plan/${params.plan}`);
      const data = await $axios.get("/api/subscriptions/intent");
      store.commit("stripe/setClientSecret", data.data.data.client_secret);
      store.commit("plan/setPlan", res.data.data);
    } catch (e) {
      return error({ statusCode: e.response.status });
    }
  },
};
</script>
