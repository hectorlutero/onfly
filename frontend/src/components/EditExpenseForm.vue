<template>
  <q-card class="max-w-[500px] w-full py-5 px-2">
    <q-card-section class="flex justify-between">
      <h2 class="font-bold text-2xl">
        Update Expense #{{ expense.id }} - {{ expense.title }}
      </h2>
      <q-btn flat icon="close" color="primary" v-close-popup />
    </q-card-section>
    <hr />
    <q-card-section>
      <q-input v-model="title" type="text" hint="Expense title" label="Title" />
      <q-input
        v-model="description"
        type="textarea"
        hint="Expense description"
        label="Description"
        rows="3"
      >
      </q-input>
      <q-input
        v-model="total_amount"
        prefix="$"
        type="number"
        label="Total Amount"
        hint="Expense total amount"
      />
      <q-input
        v-model="expenseDate"
        type="date"
        label="Date"
        hint="Expense date"
      />
    </q-card-section>
    <q-card-actions class="flex justify-end">
      <q-btn label="Update" color="indigo" @click="insertExpense()" />
    </q-card-actions>
  </q-card>
</template>

<script>
import { date, Notify } from 'quasar';
import { api } from 'src/boot/axios';
import { ref } from 'vue';
export default {
  props: {
    expense: Object,
  },
  setup(props) {
    const id = ref(props.expense.id);
    const title = ref(props.expense.title);
    const description = ref(props.expense.description);
    const total_amount = ref(props.expense.total_amount);
    const formattedDate = date.formatDate(
      date.extractDate(props.expense.date, 'DD/MM/YYYY'),
      'YYYY-MM-DD'
    );
    const expenseDate = ref(formattedDate);
    const userId = ref(props.expense.user_id);

    async function insertExpense() {
      try {
        const payload = {
          title: title.value,
          description: description.value,
          total_amount: total_amount.value,
          date: expenseDate.value,
          user_id: userId.value,
        };

        console.log(payload);
        const response = await api.put(`/api/expenses/${id.value}`, {
          ...payload,
        });

        if (response.status === 200) {
          Notify.create({
            message: 'Expense inserted successfully',
            color: 'green',
            textColor: 'white',
            position: 'top-right',
            timeout: 2000,
          });
          window.location.reload();
        }
      } catch (error) {
        if (error.response.status === 500) {
          Notify.create({
            message: 'Server error',
            color: 'negative',
            textColor: 'white',
            position: 'top',
            timeout: 2000,
          });
        }
        console.log();
        if (error.response.data) {
          let errors = error.response.data.errors;
          Object.entries(errors).map((error) => {
            Notify.create({
              message: error[1],
              color: 'negative',
              textColor: 'white',
              position: 'top',
              timeout: 4000,
            });
          });
        }
      }
    }

    return {
      title,
      description,
      total_amount,
      expenseDate,
      insertExpense,
    };
  },
};
</script>

<style lang="scss" scoped></style>
