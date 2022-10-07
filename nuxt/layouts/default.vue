<template>
  <div class="wrapper">
    <section class="hero is-custom-size is-main-color" id="hero-other-image">
      <Navigation />

      <div class="hero-body">
        <div class="container">
          <div class="columns">
            <div class="column is-8">
              <p class="title is-1 has-text-main-color is-spaced">
                <span v-if="hero">
                  {{ hero.title }}
                </span>
              </p>
              <p class="subtitle has-text-second-color is-4">
                <span v-if="hero">{{ hero.content }}</span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="site__content">
      <Nuxt />
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
</template>

<script>
import Navigation from "../components/Navigation.vue";

export default {
  name: "DefaultLayout",
  computed: {
    hero() {
      switch (this.$route.name) {
        case "login":
          return {
            title: "Connexion",
            content: "Tu as déjà un compte ?",
          };
        case "prediction":
          return {
            title: "Prédictions",
            content: "Tu es prêt à gagner de l'argent ?",
          };
        case "reports":
          return {
            title: "Bilans",
            content: "Retrouve toutes mes statistiques",
          };
        case "register":
          return {
            title: "Créer un compte",
            content: "Nous avons hâte de t'acceuillir",
          };
        case "checkout":
          return {
            title: "S'abonner",
            content: "C'est ta décision",
          };
        case "checkout-plan":
          return {
            title: "S'abonner",
            content: "Plus qu'une étape",
          };
        case "contact":
          return {
            title: "Contact",
            content: "Besoin de me contacter ?",
          };
      }
    },
  },
  data() {
    return {
      // items: [
      //   {
      //     title: 'Home',
      //     icon: 'home',
      //     to: { name: 'index' }
      //   },
      //   {
      //     title: 'Inspire',
      //     icon: 'lightbulb',
      //     to: { name: 'inspire' }
      //   }
      // ]
    };
  },
  components: { Navigation },
};
</script>
