<template>
  <section class="section" id="section2" style="padding: 0">
    <div class="container">
      <div class="box" id="custom-box">
        <b-message
          class="has-text-centered"
          type="is-info"
          v-if="
            (!$auth.loggedIn && premiumCount > 0) ||
            (premiumCount > 0 && !$auth.user.data.subscribed)
          "
        >
          Hey
          <span v-if="$auth.loggedIn">
            {{ $auth.user.data.firstname }} {{ $auth.user.data.lastname }}
          </span>
          , il y a actuellement {{ premiumCount }}
          {{ "pronostique" | pluralize(premiumCount) }} premium en cours !
          Abonne toi vite pour en profiter !
        </b-message>
        <div class="columns is-centered has-text-centered">
          <div class="column is-5">
            <template v-if="inProgress.length > 0">
              <div v-for="prediction in inProgress" class="mt-5">
                <b-collapse
                  class="card"
                  animation="slide"
                  aria-id="contentIdForA11y3"
                  :open="false"
                >
                  <template #trigger="props">
                    <div
                      class="card-header"
                      role="button"
                      aria-controls="contentIdForA11y3"
                      :aria-expanded="props.open"
                    >
                      <p class="card-header-title">
                        {{ prediction.name }} [{{ prediction.total_odd }}]

                        <b-tag rounded class="ml-2">{{
                          prediction.current_state | currentState
                        }}</b-tag>
                      </p>
                      <a class="card-header-icon">

                        <small class="mr-4">{{ prediction.created_at }}</small>
                        <b-tag rounded>{{ prediction.free | isFree }}</b-tag>
                        <b-icon :icon="props.open ? 'menu-down' : 'menu-up'">
                        </b-icon>
                      </a>
                    </div>
                  </template>

                  <div class="card-content">
                    <div class="content">
                      <div v-for="bet in prediction.bets">
                        <div class="box mt-2">
                          <div class="block">
                            <div class="columns">
                              <div class="column">
                                {{ bet.name
                                }}<b-tag
                                  rounded
                                  class="ml-2"
                                  style="display: inline"
                                  :class="{
                                    'is-success is-light': bet.state === 'win',
                                  }"
                                  >{{ bet.state | currentState }}</b-tag
                                >
                              </div>
                              <div class="column" style="text-align: right">
                                @{{ bet.odd }}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>


                    </div>
                  </div>
                  <footer class="card-footer">
                    <a class="card-footer-item" @click="alert(prediction.analyse)">Voir l'analyse complète</a>
                  </footer>
                </b-collapse>
              </div>
            </template>
            <template v-else>
              <p class="mt-5">
                Aucune prédictions en cours pour le moment. Revenez un peu plus
                tard !
              </p>
            </template>
          </div>

          <div class="column is-5">
            <template v-if="terminated.length > 0">
              <div v-for="prediction in terminated" class="mt-5">
                <b-collapse
                  class="card"
                  animation="slide"
                  aria-id="contentIdForA11y3"
                  :open="false"
                >
                  <template #trigger="props">
                    <div
                      class="card-header"
                      role="button"
                      aria-controls="contentIdForA11y3"
                      :aria-expanded="props.open"
                    >
                      <p class="card-header-title">
                        {{ prediction.name }}

                        <b-tag
                          rounded
                          class="ml-2"
                          :class="{
                            'is-success is-light':
                              prediction.current_state === 'win',
                            'is-danger is-light':
                              prediction.current_state === 'lose',
                          }"
                          >{{ prediction.current_state | currentState }}</b-tag
                        >
                      </p>
                      <a class="card-header-icon">
                        <small class="mr-4">{{ prediction.created_at }}</small>

                        <b-tag rounded>{{ prediction.free | isFree }}</b-tag>
                        <b-icon :icon="props.open ? 'menu-down' : 'menu-up'">
                        </b-icon>
                      </a>
                    </div>
                  </template>

                  <div class="card-content">
                    <div class="content">
                      <div v-for="bet in prediction.bets">
                        <div class="box mt-2">
                          <div class="block">
                            <div class="columns">
                              <div class="column">
                                {{ bet.name
                                }}<b-tag
                                  rounded
                                  class="ml-2"
                                  style="display: inline"
                                  :class="{
                                    'is-success is-light': bet.state === 'win',
                                    'is-danger is-light': bet.state === 'lose',
                                  }"
                                  >{{ bet.state | currentState }}</b-tag
                                >
                              </div>
                              <div class="column" style="text-align: right">
                                @{{ bet.odd }}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <footer class="card-footer">
                    <a class="card-footer-item" @click="alert(prediction.analyse)">Voir l'analyse complète</a>


                  </footer>
                </b-collapse>
              </div>
            </template>
            <template v-else>
              <p class="mt-5">Aucune prédictions terminés pour le moment</p>
            </template>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Modal from '../components/Modal'

export default {
  components: {
    Modal
  },

  data() {
    return {
    }
  },

  computed: {


    inProgress() {
      return this.predictions.filter((p) => p.current_state === "progress");
    },

    terminated() {
      return this.predictions.filter((p) => p.current_state !== "progress");
    },
  },

  methods: {
    alert(prediction) {
      this.$buefy.dialog.alert({
        type: 'is-link',
        message: "<div style='white-space: pre-wrap;'>" + prediction + "</div>",
        size: 'is-large'
      })
    },
  },

  async asyncData(context) {
    let { data } = await context.app.$axios.get("/api/predictions");
    return {
      predictions: data.data,
      premiumCount: data.premium_in_progress,
    };
  },
};
</script>
