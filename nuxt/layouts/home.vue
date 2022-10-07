<template>
  <div>
    <section class="hero is-medium is-main-color" id="hero-image">
      <Navigation page="homepage" />

      <div class="hero-body">
        <div class="container">
          <div class="columns is-centered">
            <div class="column is-8 has-text-centered">
              <p class="title is-1 has-text-main-color is-spaced">
                Bienvenue sur munesbetting.com
              </p>
              <p class="subtitle is-4 has-text-second-color">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio
                tempore, nostrum beatae modi odio aliqua
              </p>

              <!-- <img src="../assets/sport.png" alt="" /> -->

              <div class="block mt-5">
                <a href="#">
                  <b-icon
                    icon="instagram"
                    size="is-medium"
                    type="is-danger"
                    class="mr-3"
                  >
                  </b-icon>
                </a>
                <a href="https://twitter.com/Munesyn" target="_blank"
                  ><b-icon icon="twitter" size="is-medium" type="is-link">
                    >
                  </b-icon></a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <Nuxt />

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
  name: "HomeLayout",
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
