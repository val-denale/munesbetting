<template>
  <form
    @submit.prevent="onSubmit"
    @keydown="form.errors.clear($event.target.id)"
  >
    <div class="field">
      <div class="field-body">
        <b-field label="Prénom" label-for="firstname">
          <b-input
            type="text"
            placeholder="Prénom"
            v-model="form.firstname"
            id="firstname"
            disabled
          ></b-input>
        </b-field>

        <b-field label="Nom" label-for="lastname">
          <b-input
            type="text"
            placeholder="Nom"
            v-model="form.lastname"
            id="lastname"
            disabled
          ></b-input>
        </b-field>
      </div>
    </div>

    <b-field
      label="Email"
      label-for="email"
      :type="{ 'is-danger': form.errors.has('email') }"
      :message="[form.errors.has('email') ? form.errors.get('email') : '']"
    >
      <b-input
        type="email"
        placeholder="Adresse email"
        v-model="form.email"
        id="email"
      ></b-input>
    </b-field>

    <b-button
      type="is-link"
      native-type="submit"
      :disabled="form.errors.any() || loading"
      :loading="loading"
    >Modifier
    </b-button>
  </form>
</template>

<script>
import Form from "../../helpers/Form";

export default {
  middleware: 'auth',
  layout: "account",

  data() {
    return {
      loading: false,
      form: new Form({
        firstname: this.$auth.user.data.firstname,
        lastname: this.$auth.user.data.lastname,
        email: this.$auth.user.data.email,
      }),
    };
  },
//
  methods: {
    async onSubmit() {
      this.loading = true;
      try {
        await this.$axios.get("sanctum/csrf-cookie");
        await this.$axios.put("user/profile-information", {
          email: this.form.email,
        });
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
