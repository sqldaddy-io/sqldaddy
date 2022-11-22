<template>
  <p  v-if="$store.state.databases.databases &&  ['home:index','page:index'].includes($route.name)"  class="select"><text  @click="$emit('showDialogDatabase')" >{{ databaseName }}</text>
  <TheRunButton/>
  </p>
  <p  v-else-if="['about:index'].includes($route.name)"  class="select" >
    <router-link v-if="$store.state.sandbox.page.path"  :to="{ name: 'page:index',  params: { path: $store.state.sandbox.page.path}}">
      <span><i></i>&nbsp;go to console</span>
    </router-link>
    <router-link v-else :to="{ name: 'home:index'}">
      <span><i></i>&nbsp;go to console</span>
    </router-link>
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
