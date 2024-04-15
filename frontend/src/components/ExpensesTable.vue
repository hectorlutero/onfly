<template>
  <div class="mt-20">
    <div class="flex w-full justify-end my-5">
      <q-btn
        label="Insert Expense"
        icon="add"
        class="text-white bg-black"
        @click="openInsertExpenseDialog(true)"
      ></q-btn>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            #
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Title
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Total Amount
          </th>

          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Date
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            User
          </th>
          <th scope="col" class="relative px-6 py-3">
            <span class="sr-only">Actions</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="(expense, index) in expenses" :key="index">
          <td
            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
          >
            {{ expense.id }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ expense.title }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ expense.total_amount }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ expense.date }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ expense.user.name }}
          </td>
          <td
            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
          >
            <q-btn
              href="#"
              class="bg-indigo-600 hover:bg-indigo-900 text-white mr-4"
              @click="openDialog(expense.id)"
              >Show</q-btn
            >
            <q-btn
              href="#"
              class="text-white bg-red-600 hover:bg-red-900 mr-4"
              @click="confirmDelete(expense.id)"
              >Delete</q-btn
            >
          </td>
        </tr>
      </tbody>
    </table>

    <q-dialog
      v-model="expenseDialog"
      :content="content"
      :backdrop-filter="backdropFilter"
    >
      <q-card class="max-w-[300px] w-full">
        <q-card-section class="row items-center q-pb-none text-h6">
          #{{ content.id }} - {{ content.title }}
        </q-card-section>
        <hr />
        <q-card-section>
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36"
                >
                  Field
                </th>
                <th
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Value
                </th>
              </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
              <tr>
                <td class="p-2 py-5">Description:</td>
                <td>
                  <q-item-label label="Description">{{
                    content.description
                  }}</q-item-label>
                </td>
              </tr>
              <tr>
                <td class="p-2 py-5">Total Amount:</td>
                <td>
                  <q-item-label label="Total Amount">
                    {{ content.total_amount }}
                  </q-item-label>
                </td>
              </tr>
              <tr>
                <td class="p-2 py-5">User:</td>
                <td class="py-5">
                  <q-item-label label="User" class="flex flex-col gap-3">
                    <p>Name: {{ content.user.name }}</p>
                    <p>Email: {{ content.user.email }}</p>
                  </q-item-label>
                </td>
              </tr>
            </tbody>
          </table>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn label="Edit" color="indigo" @click="editExpense(content)" />
          <q-btn flat label="Close" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
    <q-dialog v-model="insertExpenseDialog" :backdrop-filter="backdropFilter">
      <insert-expense-form />
    </q-dialog>
    <q-dialog v-model="editExpenseDialog" :backdrop-filter="backdropFilter">
      <edit-expense-form :expense="content" />
    </q-dialog>
  </div>
</template>

<script>
import { date, Notify, useQuasar } from 'quasar';
import { ref } from 'vue';
import { api } from 'src/boot/axios';
import InsertExpenseForm from './InsertExpenseForm.vue';
import EditExpenseForm from './EditExpenseForm.vue';

export default {
  components: { InsertExpenseForm, EditExpenseForm },
  setup() {
    try {
      const $q = useQuasar();
      const expenseDialog = ref(false);
      const confirmDeleteDialog = ref(false);
      const expenseEditDialog = ref(false);
      const insertExpenseDialog = ref(false);
      const editExpenseDialog = ref(false);
      const backdropFilter = ref('blur(4px) saturate(150%)');
      const expenses = ref([]);
      const content = ref({
        id: '',
        title: '',
        description: '',
        totalAmount: '',
        user: '',
      });

      function confirmDelete(expenseId) {
        const id = expenseId;
        this.confirmDeleteDialog = true;
        $q.dialog({
          title: 'Confirm Delete Expense: #' + id,
          message: 'Would you like to delete this expense?',
          cancel: true,
          persistent: true,
        }).onOk(() => {
          // console.log(`api/expenses/${id}`);
          api.delete(`api/expenses/${id}`).then((response) => {
            console.log(response);
            $q.dialog({
              title: 'Expense Deleted',
              message: 'The expense #' + id + ' was deleted.',
              persistent: true,
            }).onOk(() => window.location.reload());
          });
        });
      }

      function editExpense(expense) {
        this.content = expense;
        this.editExpenseDialog = true;
        // window.location.href = `/edit-expense/${expenseId}`;
      }

      function openInsertExpenseDialog() {
        this.insertExpenseDialog = true;
      }

      return {
        expenses,
        expenseDialog,
        confirmDelete,
        confirmDeleteDialog,
        expenseEditDialog,
        editExpense,
        backdropFilter,
        openInsertExpenseDialog,
        insertExpenseDialog,
        editExpenseDialog,
        content,
      };
    } catch (error) {
      console.log(error);
    }
  },
  methods: {
    openDialog(expenseId) {
      this.content = this.expenses.find((expense) => expense.id === expenseId);
      this.expenseDialog = true;
    },
  },
  async mounted() {
    try {
      const response = await api.get('/api/expenses');
      this.expenses = await response.data.expenses;
      this.expenses.map(
        (expense) =>
          (expense.date = date.formatDate(expense.date, 'DD/MM/YYYY'))
      );
    } catch (error) {
      console.log(error);
      Notify.create({
        message: error.response.message,
        color: 'negative',
        textColor: 'white',
        position: 'top',
        timeout: 4000,
      });
    }
  },
};
</script>

<style scoped></style>
