import Vue from 'vue'

Vue.filter('isFree', (boolean) => {
  return boolean ? "Gratuit" : "Premium"
})


Vue.filter('currentState', (state) => {
  switch (state) {
    case "progress":
      return "En cours"
    case "win":
      return "Gagner"
    case "lose":
      return "Perdu"
  }
})

Vue.filter('pluralize', (word, amount) => (amount > 1 || amount === 0) ? `${word}s` : word)
