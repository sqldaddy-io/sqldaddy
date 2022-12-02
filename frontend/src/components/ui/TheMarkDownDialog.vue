<template>
  <div class="modal open" v-if="show" @click.stop="hideDialog">
    <div class="wrappar-modal">
      <div class="background-modal"></div>
      <div @click.stop class="modal-box">
        <div class="cross" @click.stop="hideDialog"></div>
        <pre id="PreMarkdown" v-html="this.getMarkDown()"></pre>
        <div class="button-box">
          <button @click="copyToClipboard()">
            <span><i class="unicode">⎘</i>&nbsp;&nbsp;copy markdown</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {mapGetters} from 'vuex'
import toggleMixin from "@/mixins/toggleMixin";
import json2md from "json2md";
import config from "@/config";

export default {
  name: 'TheMarkDownDialog',
  mixins: [toggleMixin],
  computed: {
    ...mapGetters({
      'getScriptResponse': 'sandbox/getScriptResponse',
    }),
  },
  methods: {
    getMarkDown() {
      let data = '';
      Object.values(this.$store.state.sandbox.page.scripts).forEach(value => {
        data += json2md({
          code: {
            content: value.request
          }
        });
        data += this.getScriptResponse(value.response);

      });
      data +=
      json2md({
        p: 'Demo in [sqldaddy.io]('+ config.hostname + '/'+this.$store.state.sandbox.page.path +')'
      });
      return data;
    },
    copyToClipboard() {
      const copyText = document.getElementById('PreMarkdown').textContent
      const textArea = document.createElement('textarea')
      textArea.textContent = copyText
      document.body.append(textArea)
      textArea.select()
      document.execCommand('copy');
      textArea.remove();
    }
  }
}
</script>

<style scoped>
pre {
  color: #2E2E2E;
  max-height: 300px;
  overflow: auto;
  margin-bottom: 15px;
  border: 1px dashed black;
  border-radius: 5px;
  padding: 15px;
}

.dark pre {
  color: #fff;
  border: 1px dashed #626262;
}

.dark button {
  background: #222 !important;
}
button:active {
  background: #c4c4c4 !important;
}

.dark button:active {
  background: #3c3c3c !important;
}
</style>
