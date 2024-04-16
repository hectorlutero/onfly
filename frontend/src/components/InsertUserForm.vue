<template>
  <q-card class="max-w-[500px] w-full py-5 px-2">
    <q-card-section class="flex justify-between">
      <h2 class="font-bold text-2xl">Insert User</h2>
      <q-btn flat icon="close" color="primary" v-close-popup />
    </q-card-section>
    <hr />
    <q-card-section>
      <q-input v-model="name" type="text" hint="User name" label="Full Name" />
      <q-input v-model="email" type="email" hint="User email" label="Email" />
      <q-toggle v-model="isAdmin" label="Is Admin?" value="1" />
      <q-input
        v-model="password"
        type="password"
        label="Password"
        hint="User password, greater then 6 characters"
      />
      <q-input
        v-model="confirmPassword"
        type="password"
        label="Confirm Password"
        hint="Confirm the user password"
      />
    </q-card-section>
    <q-card-actions class="flex justify-end">
      <q-btn label="Insert" color="indigo" @click="insertUser()" />
    </q-card-actions>
  </q-card>
</template>

<script>
import { Notify } from 'quasar';
import { api } from 'src/boot/axios';
import { ref } from 'vue';
export default {
  setup() {
    const name = ref('');
    const email = ref('');
    const is_admin = ref(0);
    const password = ref('');
    const confirmPassword = ref('');
    async function insertUser() {
      try {
        if (password.value !== confirmPassword.value)
          return Notify.create({
            message: 'Password is not the same',
            color: 'negative',
            position: 'top',
            timeout: 2000,
          });

        if (password.value.length < 6)
          return Notify.create({
            message: 'Password is too short',
            color: 'negative',
            position: 'top',
            timeout: 2000,
          });

        const payload = {
          name: name.value,
          email: email.value,
          is_admin: is_admin.value,
          password: password.value,
          confirmPassword: password.value,
        };

        const response = await api.post('/api/insert-user', {
          ...payload,
        });

        if (response.status === 201) {
          Notify.create({
            message: 'User inserted successfully',
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
      name,
      email,
      is_admin,
      password,
      confirmPassword,
      insertUser,
    };
  },
};
</script>

<style lang="scss" scoped></style>
