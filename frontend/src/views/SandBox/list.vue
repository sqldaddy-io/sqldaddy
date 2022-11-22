<template>
  <div class="box" >
    <div class="info-line loading-page-line"  v-if="$store.state.sandbox.isLoadingContent" style="margin-bottom: 20px;">
      <i class="spinner"></i>&nbsp;&nbsp; <p>Loading io . . .</p>
    </div>
    <div class="error-line" v-if="$store.state.error" style="margin-bottom: 20px">
      <p>{{ $store.state.error }}</p>
    </div>
    <transition-group name="plot-list">
      <SandBoxItem
       v-for="(script, index) in $store.state.sandbox.page.scripts"
       :script="script"
       :index="index"
       v-bind:key="index"
      />
    </transition-group>
    <div class="button-box">
      <button @click="$store.commit('sandbox/addScriptRow')"><img src="@/assets/img/add.png" alt="img"><span>input</span></button>
      <button  @click="resetPage" ><span>reset</span></button>
    </div>
  </div>
</template>

<script>
import {mapActions} from 'vuex'
import SandBoxItem from "@/views/SandBox/item";
export default {
  name: 'SandBoxList',
  components: {SandBoxItem},
  created() {
    if( this.$store.state.sandbox.page.scripts.length === 0){
      this.$store.commit('sandbox/addScriptRow');
    }
  },
  methods: {
    ...mapActions({
      'resetPage': 'sandbox/resetPage'
    })
  },
}
</script>

<style scoped>
.plot-list-item {
  display: inline-block;
  margin-right: 10px;
}
.plot-list-enter-active,
.plot-list-leave-active {
  transition: all 0.4s ease;
}
.plot-list-enter-from,
.plot-list-leave-to {
  opacity: 0;
  transform: translateY(130px);
}
.plot-list-move {
  transition: transform 0.4s ease;
}
.loading-page-line{
  display: flex;
  align-items: center;
}




.spinner{
  --spinner_border: #000000;
  --border-top-color: #000000;
  --border-bottom-color: #80ffdb;
  --border-right-color: transparent;
  --border-left-color: transparent;
}
.dark .spinner{
  --spinner_border: #dddf00;
  --border-top-color: #fcab41;
  --border-bottom-color: #80ffdb;
  --border-right-color: transparent;
  --border-left-color: transparent;
}
.spinner {
  width: 1rem;
  height: 1rem;
  display: inline-block;
  border:  3px solid var(--spinner_border);
  border-top-color: transparent;
  border-bottom-color: transparent;
  border-radius: 50%;
  animation: spin 1s infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0);
  }
  50% {
    transform: rotate(180deg);
    border-top-color: var(--border-top-color);
    border-bottom-color:var(--border-bottom-color);
    border-right-color: var(--border-right-color);
    border-left-color:var(--border-left-color);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
