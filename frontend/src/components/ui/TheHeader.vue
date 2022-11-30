<template>
  <header>
    <div class="top-line">
      <div class="left-box" v-bind:class="{'db_loaded' : $store.state.databases.databases && ['page:index'].includes($route.name)}" >
        <router-link v-if="$store.state.sandbox.page?.path" :to="{ name: 'page:index',  params: { path: $store.state.sandbox.page.path}}" class="logo">
          <div class="img"></div>
            <p>daddy.io</p>
        </router-link>
        <router-link v-else :to="{ name: 'home:index'}" class="logo">
          <div class="img"></div>
          <p>daddy.io</p>
        </router-link>
      </div>
      <div class="center-box" >
        <TheDatabase  v-if="$store.state.sandbox.isLoadingContent === false"   @showDialogDatabase="showDialogDatabase"/>
      </div>
      <div class="right-box">
        <div class="switcher">
        </div>
        <a target="_blank" href="https://twitter.com/sqldaddy" class="twitter">
          <img src="@/assets/img/twitter.png" alt="img">
        </a>
      </div>
    </div>
<!--    <TheDatabase  v-if="$store.state.sandbox.isLoadingContent === false"   @showDialogDatabase="showDialogDatabase" class="mobile"/>-->
  </header>
  <TheDialog v-model:show="dialogDatabaseVisible"></TheDialog>
</template>

<script>
import TheDatabase from "@/components/ui/TheDatabase";
import TheDialog from "@/components/ui/TheDialog";
export default {
  name: 'TheHeader',
  components: {TheDialog, TheDatabase},
  data() {
    return {
      dialogDatabaseVisible: false
    }
  },
  mounted: function () {
    let switcher = document.querySelector('.switcher')
    let body = document.querySelector('body')
    switcher.addEventListener('click', () => {
      switcher.classList.toggle('dark');
      body.classList.toggle('dark');
      localStorage.setItem('isDark', body.classList.contains('dark'));
    });
  },
  methods:{
    showDialogDatabase(){
      if(this.$store.state.sandbox.isLoading === false){
        this.dialogDatabaseVisible = true
      }

    }
  }

}


</script>


<style scoped>

</style>
