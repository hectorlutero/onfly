<template>
  <div>
    <div class="flex flex-col mt-10 max-w-[400px] mx-auto">
      <h1 class="text-3xl font-bold mb-6">Login</h1>
      <form
        class="bg-white p-6 rounded-lg shadow-md container mx-auto flex flex-col gap-5"
        @submit.prevent="login"
      >
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
          Login
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
      email: 'hectorsimandev@gmail.com',
      password: 'password',
    };
  },
  setup() {
    return {
      login() {
        // router.push('/register');
        api
          .post('/api/login', {
            email: email.value,
            password: password.value,
          })
          .then((response) => {
            LocalStorage.set('token', response.data.token);
            LocalStorage.set('user', response.data.user);
            // LocalStorage.set('user', response.data.user)
            Notify.create({
              message: 'Login successful',
              color: 'positive',
              position: 'top',
            });
            window.location.href = '/dashboard';
          })
          .catch((error) => {
            console.log(error.response);
            if (error.response?.status !== 200)
              Notify.create({
                message: error.response.data.error,
                color: 'negative',
                position: 'top',
              });
          });
      },
    };
  },
};
</script>

<style lang="scss" scoped></style>
