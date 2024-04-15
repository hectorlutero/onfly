<template>
  <div>
    <edit-expense-form />
  </div>
</template>

<script>
import EditExpenseForm from 'src/components/EditExpenseForm.vue';
import { api } from 'src/boot/axios';
import { Notify } from 'quasar';

export default {
  data() {
    return {
      expense: {},
    };
  },

  async mounted() {
    const expenseId = this.$route.params.id;
    try {
      const response = await api.get(`/api/expenses/${expenseId}`);
      if (response.status === 401) window.location.href = '/';
      this.expense = response.data;
      this.$refs.editExpenseForm.expense = this.expense;
      console.log(this.expense);
    } catch (error) {
      if (error.response.status !== 200)
        Notify.create({
          message: error.response.data.message,
          color: 'negative',
          position: 'top',
        });
    }
  },

  components: {
    EditExpenseForm,
  },
};
</script>

<style lang="scss" scoped></style>
