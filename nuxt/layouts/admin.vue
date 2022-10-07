<template>
  <div>
    <div class="container">
      <Navigation />

      <section class="main-content columns">
        <aside class="column is-4">
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
  </div>
</template>

<script>
import Navigation from "../components/Navigation.vue";

export default {
  name: "AccountLayout",

  data() {
    return {
      items: [
        {
          title: "Accueil",
          to: { name: "admin" },
        },
        {
          title: "Liste des pronostiques",
          to: { name: "admin-predictions" },
        },
        {
          title: "Créer un pronostique",
          to: { name: "admin-predictions-create" },
        },
        {
          title: "Liste des utilisateurs",
          to: { name: "admin-users" },
        },
      ],
    };
  },
  components: { Navigation },
};
</script>
