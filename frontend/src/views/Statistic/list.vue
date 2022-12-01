<template>
 <div>
   <h1 class="title">Database Environments</h1>
   <div class="statistic_list">
     <StatisticItem
         v-for="(statistic, index) in $store.getters['statistics/getStatistics']"
         :statistic="statistic"
         v-bind:key="index"
     />
   </div>
 </div>
</template>

<script>
import StatisticItem from "@/views/Statistic/item";
export default {
  name: 'StatisticList',
  components: {StatisticItem},

}
</script>

<style scoped>
.plot-list-item {
  display: inline-block;
  margin-right: 10px;
}
.plot-list-enter-active,
.plot-list-leave-active {
  transition: all 0.4s ease;
}
.plot-list-enter-from,
.plot-list-leave-to {
  opacity: 0;
  transform: translateY(130px);
}
.plot-list-move {
  transition: transform 0.4s ease;
}
.loading-page-line{
  display: flex;
  align-items: center;
}

.statistic_list{
  display: flex;
  gap: 31px;
  justify-content: center;
  flex-wrap: wrap;
}
.title{
  margin-bottom: 25px;
}
@media (max-width: 800px) {
  .title{
    text-align: center;
  }
}
</style>
