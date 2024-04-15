<template>
  <q-page class="container mx-auto">
    <users-table />
  </q-page>
</template>

<script>
import UsersTable from 'src/components/UsersTable.vue';

export default {
  components: {
    UsersTable,
  },
};
</script>
