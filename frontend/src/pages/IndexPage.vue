<template>
  <q-page class="container mx-auto flex flex-col h-screen mt-20">
    <div class="text-center">
      <h1 class="text-6xl font-bold mb-8 leading-relaxed">
        Expense <br />Tracker App
      </h1>
      <div class="flex justify-center">
        <router-link to="/login">
          <q-btn class="mr-4" color="dark" label="Login" />
        </router-link>
        <router-link to="/register">
          <q-btn color="dark" label="Sign up" />
        </router-link>
      </div>
    </div>
  </q-page>
</template>

<script>
export default {
  components: {},
};
</script>

<style scoped></style>
