<template>
  <section class="section" id="section2" style="padding: 0">
    <div class="columns is-flex is-vcentered is-centered">
      <div class="column is-two-thirds-mobile is-half-tablet">
        <div class="box">
          <h2 class="title is-size-4">Créer un compte</h2>
          <form
            @submit.prevent="onSubmit"
            @keydown="form.errors.clear($event.target.id)"
          >
            <div class="field">
              <div class="field-body">
                <b-field
                  label="Prénom"
                  label-for="firstname"
                  :type="{ 'is-danger': form.errors.has('firstname') }"
                  :message="[
                    form.errors.has('firstname')
                      ? form.errors.get('firstname')
                      : '',
                  ]"
                >
                  <b-input
                    type="text"
                    placeholder="Prénom"
                    v-model="form.firstname"
                    id="firstname"
                  ></b-input>
                </b-field>

                <b-field
                  label="Nom"
                  label-for="lastname"
                  :type="{ 'is-danger': form.errors.has('lastname') }"
                  :message="[
                    form.errors.has('lastname')
                      ? form.errors.get('lastname')
                      : '',
                  ]"
                >
                  <b-input
                    type="text"
                    placeholder="Nom"
                    v-model="form.lastname"
                    id="lastname"
                  ></b-input>
                </b-field>
              </div>
            </div>

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
              ></b-input>
            </b-field>

            <b-field
              label="Confirmation du mot de passe"
              label-for="password_confirmation"
            >
              <b-input
                type="password"
                placeholder="Confirmation du mot de passe"
                v-model="form.password_confirmation"
                id="password_confirmation"
              ></b-input>
            </b-field>

            <b-button
              type="is-link"
              native-type="submit"
              :disabled="form.errors.any() || loading"
              :loading="loading"
              >Créer un compte</b-button
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
        firstname: "",
        lastname: "",
        email: "",
        password: "",
        password_confirmation: "",
      }),
    };
  },

  methods: {
    async onSubmit() {
      this.loading = true;
      try {
        await this.$axios.get("sanctum/csrf-cookie");
        await this.$axios.post("register", this.form);

        await this.$auth.loginWith("laravelSanctum", {
          data: { email: this.form.email, password: this.form.password },
        });
      } catch (error) {
        this.loading = false;

        this.form.errors.record(error.response.data.errors);
      }
    },
  },

};
</script>
