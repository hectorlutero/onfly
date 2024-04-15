<template>
  <div class="mt-20">
    <div class="flex w-full justify-end my-5">
      <q-btn
        label="Add User"
        icon="add"
        class="text-white bg-black"
        @click="openInsertUserDialog(true)"
      ></q-btn>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            #ID
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Name
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Email
          </th>

          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Admin
          </th>
          <th
            scope="col"
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Member Since
          </th>
          <th scope="col" class="relative px-6 py-3">
            <span class="sr-only">Actions</span>
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="(user, index) in users" :key="index">
          <td
            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
          >
            {{ user.id }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ user.name }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ user.email }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ user.isAdmin ? 'Admin' : '' }}
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ user.created_at }}
          </td>
          <td
            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
          >
            <q-btn
              href="#"
              class="bg-indigo-600 hover:bg-indigo-900 text-white mr-4"
              @click="openEditUserDialog(user)"
              >Edit</q-btn
            >
            <q-btn
              href="#"
              class="text-white bg-red-600 hover:bg-red-900 mr-4"
              @click="confirmDelete(user.id)"
              >Delete</q-btn
            >
          </td>
        </tr>
      </tbody>
    </table>

    <q-dialog v-model="insertUserDialog" :backdrop-filter="backdropFilter">
      <insert-user-form />
    </q-dialog>
    <q-dialog v-model="editUserDialog" :backdrop-filter="backdropFilter">
      <edit-user-form :user="content" />
    </q-dialog>
  </div>
</template>

<script>
import { date, Notify, useQuasar } from 'quasar';
import { ref } from 'vue';
import { api } from 'src/boot/axios';
import InsertUserForm from './InsertUserForm.vue';
import EditUserForm from './EditUserForm.vue';

export default {
  components: { InsertUserForm, EditUserForm },
  setup() {
    try {
      const $q = useQuasar();
      const insertUserDialog = ref(false);
      const editUserDialog = ref(false);
      const confirmDeleteDialog = ref(false);
      const backdropFilter = ref('blur(4px) saturate(150%)');
      const users = ref([]);
      const content = ref({
        id: '',
        title: '',
        description: '',
        totalAmount: '',
        user: '',
      });

      function confirmDelete(userId) {
        const id = userId;
        this.confirmDeleteDialog = true;
        $q.dialog({
          title: 'Confirm Delete User: #' + id,
          message: 'Would you like to delete this User?',
          cancel: true,
          persistent: true,
        }).onOk(() => {
          api.delete(`api/user/${id}`).then((response) => {
            console.log(response);
            $q.dialog({
              title: 'User Deleted',
              message: 'The user #' + id + ' was deleted.',
              persistent: true,
            }).onOk(() => window.location.reload());
          });
        });
      }

      function openInsertUserDialog() {
        this.insertUserDialog = true;
      }
      function openEditUserDialog(user) {
        this.content = user;
        this.editUserDialog = true;
      }

      return {
        users,
        backdropFilter,
        editUser,
        editUserDialog,
        insertUserDialog,
        openInsertUserDialog,
        openEditUserDialog,
        confirmDelete,
        confirmDeleteDialog,
        content,
      };
    } catch (error) {
      console.log(error);
    }
  },
  async mounted() {
    try {
      const response = await api.get('/api/users');
      this.users = await response.data.users;
      this.users.map(
        (user) => (user.created_at = date.formatDate(user.date, 'DD/MM/YYYY'))
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
