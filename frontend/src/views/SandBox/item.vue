<template>
  <div class="row-box">
    <div class="sql-box">
      <div class="tools">
        <div class="item">
          <i class="drag_handle">☰</i>
        </div>
      </div>
      <prism-editor class="my-editor" v-model="updateScriptRequest"  :highlight="highlighter" line-numbers></prism-editor>
    </div>
    <div class="response-box table-responsive" v-html="response">
    </div>
  </div>
</template>


<script>
import { PrismEditor } from "vue-prism-editor";
import 'vue-prism-editor/dist/prismeditor.min.css';

import {mapGetters} from 'vuex'
const marked = require('marked');
export default {
  name: 'SandBoxItem',
  components: {
    PrismEditor,
  },
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
  data: () => ({ code: 'console.log("Hello World")' }),
  methods: {
    highlighter(code) {
      return code;
    },
  },

}
</script>

<style >
.tools .item{
  cursor: default;
}
.tools i{
  color: black;
  font-style: normal;
}
.tools i.drag_handle{
  cursor: grab;
}
.dark .tools i{
  color: white;
}

.error-badge {
  color: #f08080;
  padding-left: 0.3rem;
  border-left: 3px solid #f08080;
}

.my-editor {
  background: white;
  color: #2c3e50;
  font-family: monospace;
  line-height: 1.4;
}

.dark .my-editor{
  background: #2e2e2e;
  color: white;
}


.prism-editor-wrapper .prism-editor__line-number{
  text-align: center;
}
.prism-editor-wrapper .prism-editor__line-numbers{
  background-color: whitesmoke !important;
  color: #6c6c6c;
}

.dark .prism-editor-wrapper .prism-editor__line-numbers{
  background-color: #3a3a3a!important;
}


/* optional class for removing the outline */
.prism-editor__textarea:focus {
  outline: none;
}
</style>
