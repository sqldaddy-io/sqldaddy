<template>
   <StatisticList/>
</template>

<script>

import StatisticList from "@/views/Statistic/list";
import {mapActions} from "vuex";
export default {
  'name': 'IndexView',
  components: {StatisticList},
  created() {
    this.setMetaTitle(null);
    this.setMetaDescription(null);
  },
  mounted() {

    this.loadDatabases();
    this.loadStatistics();
  },
  methods: {
    ...mapActions({
      'setMetaTitle': 'setMetaTitle',
      'setMetaDescription': 'setMetaDescription',
      'loadDatabases': 'databases/loadDatabases',
      'loadStatistics': 'statistics/loadStatistics'
    }),
  },
}
</script>

<style scoped>

</style>
