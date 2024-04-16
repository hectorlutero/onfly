<template>
  <q-card class="max-w-[500px] w-full py-5 px-2">
    <q-card-section class="flex justify-between">
      <h2 class="font-bold text-2xl">
        Update User #{{ user.id }} - {{ user.name }}
      </h2>
      <q-btn flat icon="close" color="primary" v-close-popup />
    </q-card-section>
    <hr />
    <q-card-section>
      <q-input v-model="name" type="text" hint="User name" label="Full Name" />
      <q-input v-model="email" type="email" hint="User email" label="Email" />
      <q-toggle v-model="is_admin" label="Is Admin?" />
      <q-input
        v-model="userDate"
        type="date"
        label="Member Since"
        hint="User is member since"
      />
    </q-card-section>
    <q-card-actions class="flex justify-end">
      <q-btn label="Update" color="indigo" @click="editUser()" />
    </q-card-actions>
  </q-card>
</template>

<script>
import { date, Notify } from 'quasar';
import { api } from 'src/boot/axios';
import { ref } from 'vue';
export default {
  props: {
    user: Object,
  },
  setup(props) {
    const id = ref(props.user.id);
    const name = ref(props.user.name);
    const email = ref(props.user.email);
    const password = ref(props.user.password);
    const confirmPassword = ref(props.user.confirmPassword);
    const is_admin = ref(props.user.is_admin ? true : false);
    const formattedDate = date.formatDate(
      date.extractDate(props.user.created_at, 'DD/MM/YYYY'),
      'YYYY-MM-DD'
    );
    const userDate = ref(formattedDate);

    async function editUser() {
      try {
        const payload = {
          name: name.value,
          email: email.value,
          password: password.value,
          confirmPassword: confirmPassword.value,
          is_admin: is_admin.value ? 1 : 0,
        };

        console.log(payload);
        const response = await api.put(`/api/profile/${id.value}`, {
          ...payload,
        });

        if (response.status === 200) {
          Notify.create({
            message: 'User edited successfully',
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
      id,
      name,
      email,
      password,
      confirmPassword,
      is_admin,
      userDate,
      editUser,
    };
  },
};
</script>

<style lang="scss" scoped></style>
