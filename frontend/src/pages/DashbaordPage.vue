<template>
  <q-page class="container mx-auto"> <expenses-table /> </q-page>
</template>

<script>
import ExpensesTable from 'src/components/ExpensesTable.vue';

export default {
  components: {
    ExpensesTable,
  },
};
</script>
