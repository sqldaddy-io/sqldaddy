<template>

  <p  v-if="$store.state.databases.databases &&  ['page:index'].includes($route.name)"  class="select"><text  @click="$emit('showDialogDatabase')" >{{ databaseName }}</text>
  <TheRunButton/>
  </p>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import TheRunButton from "@/components/ui/TheRunButton";
export default {
  name: 'TheDatabase',
  components: {TheRunButton},
  methods:{
    ...mapActions({
      'initPage': 'sandbox/initPage'
    }),
  },
  computed: {
    ...mapGetters({
      'getScriptRequest': 'sandbox/getScriptRequest',
    }),
    databaseName: {
      get() { return this.$store.getters['sandbox/getDatabaseName'] },
    }
  },
}
</script>

<style scoped>

</style>
