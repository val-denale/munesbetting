<template>
  <div class="box">
    <b-table :data="users">
      <b-table-column label="ID" width="40" numeric v-slot="props">
        {{ props.row.id }}
      </b-table-column>

      <b-table-column label="Prénom" v-slot="props">
        {{ props.row.firstname }}
      </b-table-column>

      <b-table-column label="Nom" v-slot="props">
        {{ props.row.lastname }}
      </b-table-column>

      <b-table-column label="Email" v-slot="props">
        {{ props.row.email }}
      </b-table-column>

      <b-table-column label="Admin" v-slot="props">
        {{ props.row.admin }}
      </b-table-column>

      <b-table-column label="Abonné" v-slot="props">
        {{ props.row.subscribed }}
      </b-table-column>

      <b-table-column label="Formule" v-slot="props">
        {{ props.row.plan.name }}
      </b-table-column>

      <b-table-column label="Inscription" v-slot="props">
        {{ props.row.created_at }}
      </b-table-column>

      <b-table-column label="Actions" v-slot="props">
        <nuxt-link
          :to="{
            name: 'admin-users-details-id',
            params: { id: props.row.id },
          }"
        >
          <b-button type="is-light" icon-right="eye"
          /></nuxt-link>
      </b-table-column>
    </b-table>
  </div>
</template>

<script>
export default {
  middleware: "admin",
  layout: "admin",

  data () {
    return {
    }
  },

  async asyncData({ $axios, error, store }) {
    return await $axios
      .get("/api/admin/users")
      .then((res) => {
        return { users: res.data.data };
      })
      .catch((e) => {
        error({ statusCode: e.response.status });
      });
  },
};
</script>
