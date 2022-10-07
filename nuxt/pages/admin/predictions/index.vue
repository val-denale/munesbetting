<template>
  <div class="box">
    <b-table :data="predictions">
      <b-table-column label="ID" width="40" numeric v-slot="props">
        {{ props.row.id }}
      </b-table-column>

      <b-table-column label="Nom" v-slot="props">
        {{ props.row.name }}
      </b-table-column>

      <b-table-column label="Gratuit" v-slot="props">
        {{ props.row.free }}
      </b-table-column>

      <b-table-column label="Cote total" v-slot="props">
        {{ props.row.total_odd }}
      </b-table-column>

      <b-table-column label="Publier" v-slot="props">
        {{ props.row.published }}
      </b-table-column>

      <b-table-column label="Mis à jour" v-slot="props">
        {{ props.row.updated_at }}
      </b-table-column>

      <b-table-column label="Création" v-slot="props">
        {{ props.row.created_at }}
      </b-table-column>

      <b-table-column label="Actions" v-slot="props">
        <nuxt-link
          :to="{
            name: 'admin-predictions-edit-id',
            params: { id: props.row.id },
          }"
        >
          <b-button type="is-light" icon-right="lead-pencil"
        /></nuxt-link>
        <b-button type="is-danger" icon-right="delete" />
      </b-table-column>
    </b-table>
  </div>
</template>

<script>
export default {
  middleware: "admin",
  layout: "admin",

  async asyncData({ $axios, error, store }) {
    return await $axios
      .get("/api/admin/predictions")
      .then((res) => {
        return { predictions: res.data.data };
      })
      .catch((e) => {
        error({ statusCode: e.response.status });
        store.$auth.logout();
      });
  },
};
</script>
