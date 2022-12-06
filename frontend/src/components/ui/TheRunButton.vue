<template>
  <span id="runButton" v-if="!$store.state.sandbox.isLoading" @click="this.initPage" title="Shortcut key: Ctrl+Enter or Command+Enter "><i></i>&nbsp;run </span>
  <span v-else> <i class="spinner"></i>&nbsp;&nbsp;run</span>
</template>

<script>
import {mapActions} from 'vuex'

export default {
  name: 'TheRunButton',
  mounted() {
    document.addEventListener('keydown', function(event)  {
      if (document.getElementById('runButton') !== null && (event.ctrlKey || event.metaKey) && (event.keyCode === 13 || event.keyCode === 10) ) {
        document.getElementById('runButton').click();
      }
    });
  },
  methods: {
    ...mapActions({
      'initPage': 'sandbox/initPage'
    }),
  }
}
</script>

<style scoped>

header p.select span i.spinner {
  width: 10px;
  height: 10px;
  position: relative;
  top: 2px;
}

.spinner {
  --spinner_border: #000000;
  --border-top-color: #000000;
  --border-bottom-color: #80ffdb;
  --border-right-color: transparent;
  --border-left-color: transparent;
}

.dark .spinner {
  --spinner_border: #dddf00;
  --border-top-color: #fcab41;
  --border-bottom-color: #80ffdb;
  --border-right-color: transparent;
  --border-left-color: transparent;
}

.spinner {
  width: 1.5rem;
  height: 1.5rem;
  display: inline-block;
  border: 3px solid var(--spinner_border);
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
    border-bottom-color: var(--border-bottom-color);
    border-right-color: var(--border-right-color);
    border-left-color: var(--border-left-color);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
