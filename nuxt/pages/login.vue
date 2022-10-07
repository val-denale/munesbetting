<template>
  <section class="section" id="section2" style="padding: 0">
    <div class="columns is-flex is-centered">
      <div class="column is-6">
        <div class="box">
          <h2 class="title is-size-4">Connexion</h2>
          <form
            @submit.prevent="onSubmit"
            @keydown="form.errors.clear($event.target.id)"
          >
            <b-field
              label="Email"
              label-for="email"
              :type="{ 'is-danger': form.errors.has('email') }"
              :message="[
                form.errors.has('email') ? form.errors.get('email') : '',
              ]"
            >
              <b-input
                type="text"
                placeholder="Adresse email"
                v-model="form.email"
                id="email"
                @keydown.native="clearErrorsIfInvalidCredentials"
              ></b-input>
            </b-field>

            <b-field
              label="Mot de passe"
              label-for="password"
              :type="{ 'is-danger': form.errors.has('password') }"
              :message="[
                form.errors.has('password') ? form.errors.get('password') : '',
              ]"
            >
              <b-input
                type="password"
                placeholder="Mot de passe"
                v-model="form.password"
                id="password"
                @keydown.native="clearErrorsIfInvalidCredentials"
              ></b-input>
            </b-field>

            <b-button
              type="is-link"
              native-type="submit"
              :disabled="form.errors.any() || loading"
              :loading="loading"
              >Connexion</b-button
            >
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Form from "../helpers/Form";

export default {
  middleware: "auth",
  auth: "guest",

  data() {
    return {
      loading: false,
      form: new Form({
        email: "",
        password: "",
      }),
    };
  },

  methods: {
    clearErrorsIfInvalidCredentials() {
      if (this.form.errors.has("invalidCredentials")) {
        this.form.errors.clear("email");
        this.form.errors.clear("invalidCredentials");
      } else {
        this.form.errors.clear("password");
      }
    },

    async onSubmit() {
      this.loading = true;

      try {
        await this.$auth.loginWith("laravelSanctum", {
          data: this.form,
        });
      } catch (error) {
        this.loading = false;

        this.form.errors.record(error.response.data.errors);
      }
    },
  },
};
</script>
