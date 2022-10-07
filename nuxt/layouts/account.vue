<template>
  <div class="wrapper">
    <section class="hero is-custom-size is-main-color" id="hero-account-image">
      <Navigation />

      <div class="hero-body">
        <div class="container">
          <div class="columns">
            <div class="column is-8">
              <p class="title is-1 has-text-main-color is-spaced">
                {{ hero.title }}
              </p>
              <p class="subtitle has-text-second-color is-4">
                {{ hero.content }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="site__content">
      <div class="container">
        <div class="box" id="section2" style="min-height: 500px">
          <div class="columns">
            <div class="column is-4">
              <aside>
                <ul class="menu-list">
                  <li v-for="(item, key) of items" :key="key">
                    <NuxtLink :to="item.to" exact-active-class="is-active">
                      {{ item.title }}
                    </NuxtLink>
                  </li>
                </ul>
              </aside>
            </div>
            <div class="column is-8">
              <Nuxt />
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer">
      <div class="content has-text-centered is-vcentered">
        <p>
          &copy; Munes 2022 - Développer avec beaucoup d'amour par
          <a href="#">Valentin D.</a>
        </p>
      </div>
    </footer>
  </div>

  <!-- <div>
    <div class="container">
      <Navigation />

      <section class="main-content columns">
        <aside class="column is-4 section">
          <ul class="menu-list">
            <li v-for="(item, key) of items" :key="key">
              <NuxtLink :to="item.to" exact-active-class="is-active">
                {{ item.title }}
              </NuxtLink>
            </li>
          </ul>
        </aside>

        <div class="column is-8">
          <Nuxt />
        </div>
      </section>
    </div>
  </div> -->
</template>

<script>
import Navigation from "../components/Navigation.vue";

export default {
  name: "account",

  data() {
    return {
      items: [
        {
          title: "Mon compte",
          to: { name: "account" },
        },
        {
          title: "Mon mot de passe",
          to: { name: "account-password" },
        },
        {
          title: "Mon abonnement",
          to: { name: "account-subscription" },
        },
        {
          title: "Mes factures",
          to: { name: "account-invoices" },
        },
      ],
    };
  },
  components: { Navigation },

  computed: {
    hero() {
      switch (this.$route.name) {
        case "account":
          return {
            title: "Mon compte",
            content: "lorem ipsum",
          };
        case "account-password":
          return {
            title: "Mot de passe",
            content: "lorem ipsum",
          };
        case "account-subscription":
          return {
            title: "Mon abonnement",
            content: "lorem ipsum",
          };
        case "account-invoices":
          return {
            title: "Mes factures",
            content: "lorem ipsum",
          };
      }
    },
  },
};
</script>
