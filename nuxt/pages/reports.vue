<template>
  <section class="section" id="section2" style="padding: 0">
    <div class="columns is-flex is-vcentered is-centered">
      <div class="column is-6">
        <div class="box">

          <div v-for="bilan in bilans">
            <a :href="bilan.url" target="_blank">
              <div class="box has-text-centered mt-4">
                <h2 class="title is-6">{{ bilan.name }}</h2>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>

export default {


  data() {
    return {
      bilans: [
        {
          name: "SUIVI BILAN PASS : BET ANALYTIX",
          url: "https://app.bet-analytix.com/bankroll/742179",
        },
        {
          name: "SUIVI BILAN TENNIS : BET ANALYTIX",
          url: "https://app.bet-analytix.com/bankroll/445928",
        },
        {
          name: "SUIVI BILAN ESPORT : BET ANALYTIX",
          url: "https://app.bet-analytix.com/bankroll/529279",
        },
        {
          name: "SUIVI BILAN TENNIS & ESPORT : BLOGABET",
          url: "https://munesbetting.blogabet.com/",
        }
      ]
    }
  },

  methods: {

  },
};
</script>
