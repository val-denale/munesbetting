<template>
  <div class="box">
    {{ user }}

    <form @submit.prevent="onSubmit" v-if="!user.subscribed">
      <b-field label="Date de fin">
        <b-datetimepicker
          v-model="form.endDate"
          placeholder="Tape ou séléctionne une date"
          icon="calendar-today"
          :locale="locale"
          editable>
        </b-datetimepicker>
      </b-field>
      <b-button
        type="is-link"
        native-type="submit"
        :disabled="loading"
        :loading="loading"
      >Créer un abonnement</b-button
      >
    </form>
  </div>
</template>

<script>
import Form from "../../../../helpers/Form";

export default {
  middleware: "admin",
  layout: "admin",

  data () {
    return {
      loading: false,
      locale: undefined,
      form: new Form({
        endDate: undefined
      })
    }
  },

  methods: {
    async onSubmit() {
      this.loading = true;

      try {
        await this.$axios.post(`/api/admin/user/${this.$route.params.id}/createSubscription`, this.form)


        this.loading = false;
      } catch (e) {
        this.loading = false;
      }
    },

    async fetchUser({ $axios, error, params }) {
      return await this.$axios
        .get(`/api/admin/user/${this.$route.params.id}`)
        .then((res) => {
          return { user: res.data.data };
        })
        .catch((e) => {
          error({ statusCode: e.response.status });
        });
    }
  },

  async asyncData({ $axios, error, params }) {
    return await $axios
      .get(`/api/admin/user/${params.id}`)
      .then((res) => {
        return { user: res.data.data };
      })
      .catch((e) => {
        error({ statusCode: e.response.status });
      });
  },
};
</script>
