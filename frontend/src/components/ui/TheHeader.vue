<template>
  <header>
    <div class="top-line">
      <div class="left-box"
           v-bind:class="{'db_loaded' : $store.state.databases.databases && ['page:index'].includes($route.name)}">
        <router-link :to="{ name: 'home:index'}" class="logo">
          <div class="img"></div>
          <p><b>daddy.io</b></p>
        </router-link>
      </div>
      <div class="center-box">
        <TheDatabase v-if="$store.state.sandbox.isLoadingContent === false" @showDialogDatabase="showDialogDatabase"/>
      </div>
      <div class="right-box">
        <a target="_blank" href="https://twitter.com/sqldaddy" class="twitter">
          <img src="@/assets/img/twitter.png" alt="img">
        </a>
        <input type="checkbox" id="switch" /><label for="switch">Toggle</label>
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
    let switcher = document.getElementById('switch')
    let body = document.querySelector('body')
    switcher.addEventListener('click', () => {
      switcher.classList.toggle('dark');
      body.classList.toggle('dark');
      localStorage.setItem('isDark', body.classList.contains('dark'));
    });
  },
  methods: {
    showDialogDatabase() {
      if (this.$store.state.sandbox.isLoading === false) {
        this.dialogDatabaseVisible = true
      }
    }
  }

}


</script>


<style scoped>
input[type=checkbox] {
  height: 0;
  width: 0;
  visibility: hidden;
}
label {
  cursor: pointer;
  text-indent: -9999px;
  width: 50px;
  height: 26px;
  background: #dcd8d8;
  display: block;
  border-radius: 100px;
  position: relative;
}
label:after {
  content: '';
  position: absolute;
  top: 3px;
  left: 5px;
  width: 20px;
  height: 20px;
  background: #fff;
  border-radius: 90px;
  transition: 0.3s;
}
input:checked + label {
  background: #3f3e3e;
}
input:checked + label:after {
  left: calc(100% - 5px);
  transform: translateX(-100%);
}



</style>
