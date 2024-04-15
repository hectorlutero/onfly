<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title> Quasar App </q-toolbar-title>

        <div>Quasar v{{ $q.version }}</div>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" show-if-above bordered>
      <q-list>
        <q-item-label header> Navigation </q-item-label>

        <EssentialLink v-if="!token" title="Login" icon="login" link="/login" />

        <EssentialLink
          v-if="!token"
          title="Singup"
          icon="person_add"
          link="/register"
        />

        <EssentialLink
          v-if="token"
          title="Dashboard"
          icon="dashboard"
          link="/dashboard"
        />

        <EssentialLink
          v-if="token"
          title="Logout"
          icon="exit_to_app"
          link="/logout"
        />
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import EssentialLink from 'src/components/EssentialLink.vue';

defineOptions({
  name: 'MainLayout',
});

const token = localStorage.getItem('token');
const leftDrawerOpen = ref(false);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}
</script>
