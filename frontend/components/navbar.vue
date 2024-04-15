<template>
  <div class="w-full h-30 p-4 shadow-md">
    <div class="container mx-auto flex justify-between">
      <div class="lgoo">LOGO</div>
      <nav>
        <ul class="flex items-center gap-4">
          <li>
            <nuxt-link to="/">Home</nuxt-link>
          </li>

          <li v-if="!token">
            <nuxt-link to="/login">Login</nuxt-link>
          </li>
          <li v-else @click="logout">logout</li>
          <li>
            <nuxt-link to="/register">Register</nuxt-link>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>
<script>
// const tokenString = localStorage.getItem("token");
export default {
  data() {
    return {
      // token: tokenString,
    };
  },
  methods: {
    logout() {
      // localStorage.removeItem("token");
      // this.token = null;
    },
  },
};
</script>
