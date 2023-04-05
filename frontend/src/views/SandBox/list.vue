<template>
  <div class="box">
    <div class="info-line loading-page-line"  v-if="$store.state.sandbox.isLoadingContent" style="margin-bottom: 20px;">
      <i class="spinner"></i>&nbsp;&nbsp; <p>Loading io . . .</p>
    </div>
    <div class="error-line" v-if="$store.state.error" style="margin-bottom: 20px">
      <p>{{ $store.state.error }}</p>
    </div>
    <draggable v-model="scriptsList"  item-key="sort"  handle=".drag_handle">
      <template #item="{element, index}">
        <SandBoxItem
            :script="element"
            :index="index"
            handle=".drag_handle"
            v-bind:key="index"
        />
      </template>
    </draggable>
    <div class="button-box">
      <button @click="$store.commit('sandbox/addScriptRow')"><span><i class="unicode">+</i>&nbsp;&nbsp;input</span></button>
      <button v-if="this.$store.state.sandbox.page?.path"  @click="showShareDialog" ><span><i class="unicode">⎘</i>&nbsp;&nbsp;share</span></button>
      <button  @click="resetPage" ><span><i class="unicode">⑃</i>&nbsp;&nbsp;reset</span></button>
    </div>
    <TheShareDialog v-model:show="shareDialogShow"/>
  </div>
</template>

<script>
import {mapActions} from 'vuex'
import SandBoxItem from "@/views/SandBox/item";
import draggable from 'vuedraggable'
import TheShareDialog from "@/components/ui/TheShareDialog.vue";

export default {
  name: 'SandBoxList',
  components: {TheShareDialog, SandBoxItem, draggable},
  data() {
    return {
      shareDialogShow: false
    }
  },
  created() {
    if( this.$store.state.sandbox.page.scripts.length === 0){
      this.$store.commit('sandbox/addScriptRow');
    }
  },
  methods: {
    ...mapActions({
      'resetPage': 'sandbox/resetPage'
    }),
    showShareDialog(){
     this.shareDialogShow = true;
    }
  },
  computed: {
    scriptsList: {
      get() {
        return this.$store.state.sandbox.page.scripts
      },
      set(scriptsList) {
        scriptsList.forEach((element, index) => {
          element.sort = index;
        });
        this.$store.commit('sandbox/updateScriptList', scriptsList)
      }
    }
  }
}
</script>

<style scoped>


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
