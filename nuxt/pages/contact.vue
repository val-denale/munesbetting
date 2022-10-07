<template>
  <section class="section" id="section2" style="padding: 0">
    <div class="columns is-flex is-vcentered is-centered">
      <div class="column is-6">
        <div class="box">
          <form
            @submit.prevent="onSubmit"
            @keydown="form.errors.clear($event.target.id)"
          >
            <div class="field">
              <div class="field-body">
                <b-field label="Prénom" label-for="firstname" :type="{ 'is-danger': form.errors.has('firstname') }" :message="[form.errors.has('firstname') ? form.errors.get('email') : '']"

                >
                  <b-input
                    type="text"
                    placeholder="Prénom"
                    v-model="form.firstname"
                    id="firstname"
                  ></b-input>
                </b-field>

                <b-field label="Nom" label-for="nom" :type="{ 'is-danger': form.errors.has('lastname') }" :message="[form.errors.has('lastname') ? form.errors.get('lastname') : '']">
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
              :message="[form.errors.has('email') ? form.errors.get('email') : '']"
            >
              <b-input
                type="email"
                placeholder="Adresse email"
                v-model="form.email"
                id="email"
              ></b-input>
            </b-field>

            <b-field
              label="Message"
              label-for="message"
              :type="{ 'is-danger': form.errors.has('messages') }"
              :message="[form.errors.has('messages') ? form.errors.get('messages') : '']"
            >
              <b-input
                type="textarea"
                placeholder="Votre message"
                v-model="form.messages"
                id="messages"
              ></b-input>
            </b-field>

            <b-button
              type="is-link"
              native-type="submit"
              :disabled="form.errors.any() || loading"
              :loading="loading"
            >Envoyer
            </b-button>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>

import Form from "../helpers/Form";

export default {


  data() {
    return {
      loading: false,
      form: new Form({
        firstname: '',
        lastname: '',
        email: '',
        messages: '',
      }),
    }
  },

  methods: {
    async onSubmit() {
      this.loading = true
      try {
        this.loading = true
        await this.$axios.get("sanctum/csrf-cookie");
        await this.$axios.post('/api/contact', this.form)
        this.loading = false
      } catch (e) {
        this.loading = false
        this.form.errors.record(e.response.data.errors);
      }
    }
  },
};
</script>
