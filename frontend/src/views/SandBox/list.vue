<template>
  <div class="box">
    <div class="info-line loading-page-line"  v-if="$store.state.sandbox.isLoadingContent" style="margin-bottom: 20px;">
      <i class="spinner"></i>&nbsp;&nbsp; <p>Loading io . . .</p>
    </div>
    <div class="error-line" v-if="$store.state.error" style="margin-bottom: 20px">
      <p>{{ $store.state.error }}</p>
    </div>
    <draggable v-model="scriptsList"  item-key="sort">
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
      <button v-if="this.$store.state.sandbox.page?.path"  @click="showMarkDownDialog" ><span><i class="unicode">⎘</i>&nbsp;&nbsp;markdown</span></button>
      <button  @click="resetPage" ><span><i class="unicode">⑃</i>&nbsp;&nbsp;reset</span></button>
    </div>
    <TheMarkDownDialog v-model:show="markDownDialogShow"/>
  </div>
</template>

<script>
import {mapActions} from 'vuex'
import SandBoxItem from "@/views/SandBox/item";
import TheMarkDownDialog from "@/components/ui/TheMarkDownDialog";
import draggable from 'vuedraggable'
export default {
  name: 'SandBoxList',
  components: {TheMarkDownDialog, SandBoxItem, draggable},
  data() {
    return {
      markDownDialogShow: false
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
    showMarkDownDialog(){
     this.markDownDialogShow = true;
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
