// https://nuxt.com/docs/api/configuration/nuxt-config

export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: ["@nuxtjs/tailwindcss", "@nuxtjs/color-mode"],
  runtimeConfig: {
    public: {
      baseUrl: process.env.API_URL || "http/api",
    },
  },
});
