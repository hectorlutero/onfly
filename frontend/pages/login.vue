<template>
  <div class="flex flex-col items-center justify-center h-screen">
    <h1 class="text-3xl font-bold mb-6">Login</h1>

    <form class="bg-white p-6 rounded-lg shadow-md" @submit.prevent="login">
      <div class="mb-4">
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

      <div class="mb-4">
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
      <div v-if="errorMessage" class="mb-4 text-red-500">
        {{ errorMessage }}
      </div>

      <button
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        type="submit"
      >
        Login
      </button>
    </form>
  </div>
</template>

<script>
import { loginUser } from "@/composables/useAuth";
export default {
  data() {
    return {
      formData: {
        email: "",
        password: "",
      },
      errorMessage: "",
    };
  },
  methods: {
    async login() {
      loginUser(email.value, password.value);
    },
  },
};
</script>
