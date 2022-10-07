<template>
  <form
    @submit.prevent="onSubmit"
    @keydown="form.errors.clear($event.target.id)"
  >
    <b-field
      label="Mot de passe actuel"
      label-for="current_password"
      :type="{ 'is-danger': form.errors.has('current_password') }"
      :message="[
        form.errors.has('current_password')
          ? form.errors.get('current_password')
          : '',
      ]"
    >
      <b-input
        type="password"
        placeholder="Mot de passe actuel"
        v-model="form.current_password"
        id="current_password"
      ></b-input>
    </b-field>

    <b-field
      label="Nouveau mot de passe"
      label-for="password"
      :type="{ 'is-danger': form.errors.has('password') }"
      :message="[
        form.errors.has('password') ? form.errors.get('password') : '',
      ]"
    >
      <b-input
        type="password"
        placeholder="Nouveau mot de passe"
        v-model="form.password"
        id="password"
      ></b-input>
    </b-field>

    <b-field
      label="Confirmation du mot de passe"
      label-for="password_confirmation"
      :type="{ 'is-danger': form.errors.has('password_confirmation') }"
      :message="[
        form.errors.has('password_confirmation')
          ? form.errors.get('password_confirmation')
          : '',
      ]"
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
      :disabled="loading"
      :loading="loading"
      >Modifier
    </b-button>
  </form>
</template>

<script>
import Form from "../../helpers/Form";

export default {
  middleware: "auth",
  layout: "account",

  data() {
    return {
      loading: false,
      form: new Form({
        current_password: "",
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
        await this.$axios.put("user/password", this.form);

        this.form.reset();

        this.loading = false;

        await this.$auth.fetchUser();
      } catch (error) {
        this.loading = false;

        this.form.errors.record(error.response.data.errors);
      }
    },
  },
};
</script>
