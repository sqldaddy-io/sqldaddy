<template>
  <div class="row-box">
    <div class="sql-box">
      <!--    <code-mirror :swcMinify="false" :wrap="true" v-model="updateScriptRequest" :basic="true" :extensions="[myTheme]"/>-->
      <codemirror
          v-model="updateScriptRequest"
          placeholder="your sql code goes here..."
          :indent-with-tab="true"
          :tab-size="2"
          :extensions="extensions"

      />
    </div>
    <div class="response-box table-responsive" v-html="response">
    </div>
  </div>
</template>


<script>
import {mapGetters} from 'vuex'
import {EditorView} from "codemirror";
import {Codemirror} from 'vue-codemirror'
const marked = require('marked');
export default {
  name: 'SandBoxItem',
  components: {Codemirror},
  props: {
    script: {
      type: Object,
      required: true,
    },
    index: {
      type: Number,
      required: true,
      default: 0
    }
  },
  computed: {
    ...mapGetters({
      'getScriptRequest': 'sandbox/getScriptRequest',
      'getScriptResponse': 'sandbox/getScriptResponse',
    }),
    updateScriptRequest: {
      get() {
        return this.getScriptRequest(this.index)
      },
      set(value) {
        this.$store.commit('sandbox/updateScriptRequest', {id: this.index, value: value})
      }
    },
    response: {
      get() {
        return marked.parse(this.getScriptResponse(this.script.response));
      }
    }
  },
  setup() {
    const darkTheme = EditorView.theme({
      ".dark &": {
        color: "white",
        backgroundColor: "#2E2E2E"
      },
      ".dark .cm-content": {
        caretColor: "#0e9"
      },
      ".dark &.cm-focused .cm-cursor": {
        borderLeftColor: "#0e9"
      },
      ".dark &.cm-focused .cm-selectionBackground, ::selection": {
        backgroundColor: "#074"
      },
      ".dark & .cm-gutters": {
        backgroundColor: "rgba(62,62,62,0.74)",
        border: "none"
      },
      ".dark & .cm-activeLineGutter": {
        backgroundColor: "#cceeff44",
        color: '#fff',
        border: "none"
      }
    })
    const extensions = [darkTheme]
    return {
      extensions,
    }
  },


}
</script>

<style scoped>
.error-badge {
  color: #f08080;
  padding-left: 0.3rem;
  border-left: 3px solid #f08080;
}
</style>
