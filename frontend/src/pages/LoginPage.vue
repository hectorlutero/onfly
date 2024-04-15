<template>
  <q-page class="container mx-auto">
    <login-form />
  </q-page>
</template>

<script>
import LoginForm from 'src/components/LoginForm.vue';

export default {
  components: {
    LoginForm,
  },
};
</script>
