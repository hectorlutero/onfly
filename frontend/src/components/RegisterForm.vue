<template>
  <div>
    <div class="flex flex-col mt-10 max-w-[400px] mx-auto">
      <h1 class="text-3xl font-bold mb-6">Sign up</h1>
      <form
        class="bg-white p-6 rounded-lg shadow-md container mx-auto flex flex-col gap-5"
        @submit.prevent="login"
      >
        <div class="name-container">
          <label class="block text-gray-700 font-bold mb-2" for="name">
            Name
          </label>
          <input
            id="name"
            v-model="name"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            placeholder="Name"
          />
        </div>

        <div class="email-container">
          <label class="block text-gray-700 font-bold mb-2" for="email">
            Email
          </label>
          <input
            id="email"
            v-model="email"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="email"
            placeholder="Email"
          />
        </div>

        <div class="password-container">
          <label class="block text-gray-700 font-bold mb-2" for="password">
            Password
          </label>
          <input
            id="password"
            v-model="password"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="password"
            placeholder="Password"
          />
        </div>
        <button
          class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded w-full focus:outline-none focus:shadow-outline"
          type="submit"
        >
          Sign up
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import { LocalStorage, Notify } from 'quasar';
import { api } from 'src/boot/axios';

export default {
  data() {
    return {
      name: 'Christian',
      email: 'christian@email.com',
      password: 'password',
    };
  },
  methods: {
    async login() {
      const { name, email, password } = this;
      api
        .post('/api/register', {
          name: name,
          email: email,
          password: password,
        })
        .then((response) => {
          if (response.status === 200) {
            Notify.create({
              message: 'You have successfully registered!',
              color: 'positive',
              textColor: 'white',
              position: 'top',
            });
            LocalStorage.set('token', response.data.token);
            window.location.href = '/';
          }
        })
        .catch((error) => {
          Notify.create({
            message: error.response.data.message,
            color: 'negative',
            textColor: 'white',
            position: 'top',
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped></style>
