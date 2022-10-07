<template>
  <div>

    <template v-if="invoices.length">
      <div v-for="invoice in invoices">
        <div class="box mt-4">
          {{ invoice.created }}
          <span class="is-pulled-center"
          >{{ parseInt(invoice.total, 10) / 100 }} €</span
          >
          <span class="is-pulled-right"
          ><a target="_blank" :href="invoice.download_url">Télécharger</a></span
          >
        </div>
      </div>
    </template>
    <template v-else><div><p>
      Aucune facture
    </p></div></template>
  </div>
</template>

<script>
export default {
  middleware: "auth",
  layout: "account",

  methods: {
    onSubmit() {
      try {
      } catch (e) {}
    },
  },

  async asyncData({ $axios }) {
    try {
      const { data } = await $axios.get("/api/subscription/invoices");

      return { invoices: data.data };
    } catch (e) {}
  },
};
</script>
