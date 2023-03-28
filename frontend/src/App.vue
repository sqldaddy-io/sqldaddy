<template>

  <Teleport to="head">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400;500;600;700&family=Rokkitt:wght@100;200;300;400;500;600;700;800;900&display=swap"  rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="manifest" href="/favicons/site.webmanifest">
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="title" :content="$store.state.meta.title">
    <meta name="description" :content="$store.state.meta.description">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://sqldaddy.io/">
    <meta property="og:title" :content="$store.state.meta.title">
    <meta property="og:description" :content="$store.state.meta.description">
    <meta property="og:image" content="https://sqldaddy.io/images/ogimage.png">
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://sqldaddy.io/">
    <meta property="twitter:title" :content="$store.state.meta.title">
    <meta property="twitter:description" :content="$store.state.meta.description">
    <meta property="twitter:image" content="https://sqldaddy.io/images/ogimage.png">
  </Teleport>
  <TheHeader/>
  <main>
    <div class="wrapper">
      <router-view/>
    </div>
  </main>
  <TheFooter/>
</template>

<script>
import TheHeader from "@/components/ui/TheHeader";
import TheFooter from "@/components/ui/TheFooter";
import {mapGetters} from "vuex";

export default {
  name: 'App',
  components: {TheFooter, TheHeader},
  watch: {
    '$store.state.meta.title': function () {
      this.$store.dispatch('updateMeta');
    },
  },
  computed: {
    ...mapGetters({
      'getScriptRequest': 'sandbox/getScriptRequest',
    }),
  },
  mounted() {
    this.$store.dispatch('updateMeta');
    this.setMode();
  },
  methods: {
    setMode() {
      const isDark = JSON.parse(localStorage.getItem('isDark')) ?? window.matchMedia('(prefers-color-scheme: dark)').matches;
      if (isDark === true) {
        document.getElementById("switch").checked = true;
        document.getElementById('switch').classList.add('dark');
        document.querySelector('body').classList.add('dark');
      }
    }
  },
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
