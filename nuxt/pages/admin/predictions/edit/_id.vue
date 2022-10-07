<template>
  <div class="box">
    {{ form }}
    <form
      @submit.prevent="onSubmit"
      @keydown="form.errors.clear($event.target.id)"
    >
      <b-field
        label="Nom"
        label-for="name"
        :type="{ 'is-danger': form.errors.has('name') }"
        :message="[form.errors.has('name') ? form.errors.get('name') : '']"
      >
        <b-input
          type="text"
          placeholder="Nom global du pronostique"
          v-model="form.name"
          id="name"
        ></b-input>
      </b-field>

      <b-field
        label="Analyse"
        label-for="analyse"
        :type="{ 'is-danger': form.errors.has('analyse') }"
        :message="[
          form.errors.has('analyse') ? form.errors.get('analyse') : '',
        ]"
      >
        <b-input
          type="textarea"
          placeholder="Analyse du pronostique"
          v-model="form.analyse"
          id="analyse"
        ></b-input>
      </b-field>

      <b-field>
        <b-checkbox v-model="form.free">Gratuit</b-checkbox>
      </b-field>

      <div v-for="(input, k) in form.bets" class="mt-4">
        <span @click="add(k)" v-show="k === form.bets.length - 1"
          ><b-icon icon="folder-plus"> </b-icon>
        </span>
        <span
          @click="
            remove(k, [
              uniqueInput(k, 'name'),
              uniqueInput(k, 'odd'),
              uniqueInput(k, 'sport'),
              uniqueInput(k, 'state'),
            ])
          "
          v-show="k || (!k && form.bets.length > 1)"
          ><b-icon icon="trash-can-outline"> </b-icon
        ></span>

        <b-field
          label="Nom du pari"
          :label-for="uniqueInput(k, 'name')"
          :type="{ 'is-danger': form.errors.has(uniqueInput(k, 'name')) }"
          :message="[
            form.errors.has(uniqueInput(k, 'name'))
              ? form.errors.get(uniqueInput(k, 'name'))
              : '',
          ]"
        >
          <b-input
            type="text"
            placeholder="Nom du pari"
            v-model="input.name"
            :id="uniqueInput(k, 'name')"
          ></b-input>
        </b-field>

        <b-field
          label="Cote"
          :label-for="uniqueInput(k, 'odd')"
          :type="{ 'is-danger': form.errors.has(uniqueInput(k, 'odd')) }"
          :message="[
            form.errors.has(uniqueInput(k, 'odd'))
              ? form.errors.get(uniqueInput(k, 'odd'))
              : '',
          ]"
        >
          <b-input
            type="text"
            placeholder="Cote du pari"
            v-model="input.odd"
            :id="uniqueInput(k, 'odd')"
          ></b-input>
        </b-field>

        <div class="field">
          <div class="field-body">
            <b-field
              :type="{ 'is-danger': form.errors.has(uniqueInput(k, 'sport')) }"
              :label-for="uniqueInput(k, 'sport')"
              label="Sport"
            >
              <b-select
                @change.native="form.errors.clear(uniqueInput(k, 'sport'))"
                :id="uniqueInput(k, 'sport')"
                v-model="input.sport.id"
              >
                <option value="">Sélectionner un sport</option>
                <option
                  v-for="sport in sports"
                  :value="sport.id"
                  :key="sport.id"
                  :selected="sport.id === input.sport.id"
                >
                  {{ sport.name }}
                </option>
              </b-select>
            </b-field>

            <b-field
              :type="{ 'is-danger': form.errors.has(uniqueInput(k, 'state')) }"
              :label-for="uniqueInput(k, 'state')"
              label="Etat"
            >
              <b-select
                @change.native="form.errors.clear(uniqueInput(k, 'state'))"
                :id="uniqueInput(k, 'state')"
                v-model="input.state"
              >
                <option value="">Sélectionner un état</option>
                <option
                  v-for="state in states"
                  :value="state.value"
                  :key="state.id"
                  :selected="state.id === input.state"
                >
                  {{ state.display }}
                </option>
              </b-select>
            </b-field>
          </div>
        </div>
      </div>

      <b-button
        class="mt-5"
        type="is-primary"
        native-type="submit"
        :disabled="form.errors.any() || loading"
        :loading="loading"
        >Créer un pronostique</b-button
      >
    </form>
  </div>
</template>

<script>
import Form from "../../../../helpers/Form";

export default {
  middleware: "admin",
  layout: "admin",

  computed: {},

  data() {
    return {
      loading: false,
      sports: [],
      states: [
        {
          id: 1,
          value: "progress",
          display: "En cours",
        },

        {
          id: 2,
          value: "win",
          display: "Gagné",
        },
        {
          id: 3,
          value: "lose",
          display: "Perdu",
        },
      ],
      form: new Form({}),
    };
  },

  methods: {
    uniqueInput(index, inputName) {
      return "bets." + index + "." + inputName;
    },
    add(index) {
      this.form.bets.push({ name: "", odd: "", sport: "", state: "" });
    },

    remove(index, inputs) {
      this.form.bets.splice(index, 1);

      console.log(inputs);

      inputs.forEach((input) => {
        this.form.errors.clear(input);
      });
    },

    async onSubmit() {
      this.loading = true;
      try {
        await this.$axios.$patch(
          `/api/admin/prediction/${this.$route.params.id}`,
          this.form
        );
        this.loading = false;
      } catch (error) {
        this.loading = false;
        this.form.errors.record(error.response.data.errors);
      }
    },
  },

  async mounted() {
    try {
      let result = await this.$axios.$get(
        `/api/admin/prediction/${this.$route.params.id}`
      );

      let sportResult = await this.$axios.$get(`/api/admin/sports`);

      this.sports = sportResult.data;

      this.form = new Form(result.data);
    } catch (error) {
      this.form.errors.record(error.response.data.data);
    }
  },
};
</script>
