<template>
  <SandBoxList/>
</template>

<script>
import {mapActions} from 'vuex'
import SandBoxList from "@/views/SandBox/list";

export default {
  'name': 'SandBoxIndex',
  components: {SandBoxList},
  created() {
    this.loadDatabases();
    if (this.$route?.params?.path) {
      this.setPathPage(this.$route.params.path);
    }
  },
  watch: {
    '$store.state.error': function () {
      this.$store.state.sandbox.isLoading = false;
      this.$store.state.sandbox.isLoadingContent = false;
    }
  },
  methods: {
    ...mapActions({
      'loadDatabases': 'databases/loadDatabases',
      'setPathPage': 'sandbox/setPathPage',
    }),
  },
}
</script>

<style scoped>

</style>
