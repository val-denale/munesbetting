<template>
  <b-navbar wrapper-class="container">
    <template #brand>
      <b-navbar-item
        tag="router-link"
        :class="{ 'custom-navbar-item': page }"
        :to="{ name: 'index' }"
      >
        Munes
      </b-navbar-item>
    </template>
    <template #start>
      <b-navbar-item
        tag="router-link"
        :class="{ 'custom-navbar-item': page }"
        :to="{ name: 'index' }"
        >Accueil</b-navbar-item
      >

      <b-navbar-item
        tag="router-link"
        :class="{ 'custom-navbar-item': page }"
        :to="{ name: 'prediction' }"
        >Prédictions</b-navbar-item
      >
      <b-navbar-item
        tag="router-link"
        :class="{ 'custom-navbar-item': page }"
        :to="{ name: 'reports' }"
        >Bilans</b-navbar-item
      >
      <b-navbar-item
        tag="router-link"
        :class="{ 'custom-navbar-item': page }"
        :to="{ name: 'contact' }"
        >Contact</b-navbar-item
      >
    </template>

    <template #end>
      <template v-if="$auth.loggedIn">

        <b-navbar-dropdown  :label=fullname>
          <b-navbar-item tag="router-link" :to="{ name: 'account' }">
            Mon compte
          </b-navbar-item>
          <b-navbar-item tag="router-link" :to="{ name: 'admin' }" v-if="$auth.user.data.admin">
            Admin
          </b-navbar-item>

          <b-navbar-item @click="logout">
            Déconnexion
          </b-navbar-item>
        </b-navbar-dropdown>

      </template>

      <template v-if="!$auth.loggedIn">
        <nuxt-link
          :to="{ name: 'login' }"
          :class="{ 'custom-navbar-item': page }"
          class="navbar-item"
          >Connexion</nuxt-link
        >
        <nuxt-link
          :to="{ name: 'register' }"
          :class="{ 'custom-navbar-item': page }"
          class="navbar-item"
        >
          Créer un compte
        </nuxt-link>
      </template>

      <div class="navbar-item">
        <div class="buttons">
          <nuxt-link
            :to="{ name: 'checkout' }"
            class="button is-rounded is-main-color"
            v-if="!$auth.loggedIn || !$auth.user.data.subscribed"
            >S'abonner</nuxt-link
          >
        </div>
      </div>
    </template>
  </b-navbar>
</template>

<script>
export default {
  props: {
    page: {
      type: String,
    },
  },

  computed: {
    fullname() {
      return this.$auth.user.data.firstname + ' ' + this.$auth.user.data.lastname
    }
  },

  methods: {
    async logout() {
      await this.$router.replace({ name: "index" }).catch(() => {});
      await this.$auth.logout();
    },
  },
};
</script>
