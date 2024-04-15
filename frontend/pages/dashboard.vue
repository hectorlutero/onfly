<template>
  <h1>Dashboard</h1>
</template>
<script>
import { getUser } from "@/composables/useAuth";

export default {
  data() {
    return {
      user: getUser(),
    };
  },
  created() {
    this.user = getUser();
    console.log(this.user);
  },
};
</script>
