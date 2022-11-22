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
  <div class="response-box table-responsive">
    <Markdown :source="response"/>
  </div>
  </div>
</template>


<script>

import { mapGetters} from 'vuex'
const json2md = require("json2md")
import { EditorView, basicSetup} from "codemirror";
import { Codemirror } from 'vue-codemirror'
import Markdown from 'vue3-markdown-it';
export default {
  name: 'SandBoxItem',
  components: {Markdown,Codemirror},

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
    }),
    updateScriptRequest: {
      get() { return this.getScriptRequest(this.index) },
      set(value) { this.$store.commit('sandbox/updateScriptRequest', {id:this.index, value: value } ) }
    },
    response: {
      get() { return this.getResponseMarkdown() }
    }
  },
  methods:{
    getResponseMarkdown(){
      let responses = [];
      Object.values(this.script.response).forEach(value=> {
        if(typeof value === 'object' || value instanceof Object){

          let without_result = false;
          Object.values(value).forEach(value_row => {
            if(Object.values(value_row).length === 0){
               without_result = true;
            }
          });
          if( Object.values(value).length === 0 || without_result === true){
            responses.push({ blockquote: "completed " + ((Object.keys(value).length>0)?Object.keys(value).length:'') });
          }else {
            let header = [];
            Object.values(value).forEach(value_row => {
              header = Object.keys(value_row);
            });
            responses.push({ table: { headers: header, rows: JSON.parse((JSON.stringify(value)).toString().replaceAll('null','"null"')) }, hr:'' });
          }

        }else if( typeof value === 'string' || value instanceof String){
          responses.push({ h5: value});
        }
      });
      if(responses.length>0){
        return json2md(responses);
      }
      return '';
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
    const extensions = [basicSetup, darkTheme]
    return {
      extensions,
    }
  }
}
</script>

<style scoped>
.error-badge{
  color: #f08080;padding-left: 0.3rem;
  border-left: 3px solid #f08080;
}

</style>
