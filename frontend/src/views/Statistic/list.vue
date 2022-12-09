<template>
 <div>
   <h1 class="title">Database Environments</h1>
   <div class="error-line" v-if="$store.state.error" style="margin-bottom: 20px">
     <p>{{ $store.state.error }}</p>
   </div>
   <div class="statistic_list">
     <transition-group name="list"  mode="out-in">
     <StatisticItem
         v-for="(statistic, index) in $store.getters['statistics/getStatistics']"
         :statistic="statistic"
         v-bind:key="index"
     />
     </transition-group>
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
.list-enter-active, .list-leave-active {
  transition: all 1s;
}
.list-enter, .list-leave-to {
  opacity: 0;
}
.statistic_list{
  display: flex;
  gap: 31px;
  justify-content: start;
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
