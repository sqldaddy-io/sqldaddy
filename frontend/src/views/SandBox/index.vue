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
    this.setMetaDescription(null);
  },
  mounted() {
    this.loadDatabases();
    if (this.$route?.params?.path) {
      this.setPathPage(this.$route.params.path);
    }
  },
  watch: {
    '$route.params.path': function () {
      if (this.$route.params?.path && this.$route.params.path !== this.$store.state.sandbox.page.path) {
        return  this.setPathPage(this.$route.params.path);
      }
    },
    '$store.state.error': function () {
      this.$store.state.sandbox.isLoading = false;
      this.$store.state.sandbox.isLoadingContent = false;
    },
    '$store.state.sandbox.page.databaseVersion': function () {
      this.setMetaTitle(this.$store.state.sandbox.page?.databaseVersion?.database?.name + ' ' +this.$store.state.sandbox.page?.databaseVersion?.name);
    }
  },
  methods: {
    ...mapActions({
      'setMetaTitle': 'setMetaTitle',
      'setMetaDescription': 'setMetaDescription',
      'loadDatabases': 'databases/loadDatabases',
      'setPathPage': 'sandbox/setPathPage',
    }),
  },
}
</script>

<style scoped>

</style>
