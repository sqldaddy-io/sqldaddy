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
    this.loadStatistics();
    this.loadDatabases();
  },
  methods: {
    ...mapActions({
      'loadDatabases': 'databases/loadDatabases',
      'loadStatistics': 'statistics/loadStatistics'
    }),
  },
}
</script>

<style scoped>

</style>
