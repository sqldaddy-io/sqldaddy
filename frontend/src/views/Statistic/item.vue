<template>
  <div class="statistic_item" v-bind:class="{ 'loading' :  $store.state.statistics.isLoading }">
    <div class="name">{{ statistic.name }}</div>
    <div class="badge-wrap" style="margin-top: 10px; border-top: unset">
      <div class="badge">
        <span>all time&nbsp;&nbsp;:&nbsp;&nbsp;{{ statistic.all_time }}</span>
      </div>
      <div class="badge">
        <span>90 day&nbsp;&nbsp;:&nbsp;&nbsp;{{ statistic.last_90_days }}</span>
      </div>
      <div class="badge">
        <span>7 day&nbsp;&nbsp;:&nbsp;&nbsp;{{ statistic.last_7_days }}</span>
      </div>
      <div class="badge-wrap inline" v-if="statistic.versions ?? $store.state.databases.databases" >
        <div class="badge">
          <span>versions&nbsp;:</span>
        </div>
        <template v-for="version in statistic.versions ?? $store.getters['databases/getDatabase'](statistic.id)?.versions"  v-bind:key="version.id">
          <router-link @click="$store.commit('databases/setDatabaseToSandBox', [statistic.id, version.id])"  :to="{ name: 'page:index', query: { database: statistic.name, version: version.name }}" class="logo">
            <div class="badge">
              <span>{{ version.name }}</span>
            </div>
          </router-link>
        </template>
      </div>

        <router-link @click="$store.commit('databases/setDatabaseToSandBox', [statistic.id])"  :to="{ name: 'page:index', query: { database: statistic.name }}" class="logo">
          <div class="badge open_console">
              <span>▶&nbsp;&nbsp;&nbsp;&nbsp;open console</span>
          </div>
        </router-link>

    </div>
  </div>
</template>

<script>

export default {
  name: 'StatisticItem',
  props: {
    statistic: {
      type: Object,
      required: true,
    }
  }
}
</script>

<style scoped>
    .statistic_item{
      background-color: #F5F4F4;
      border-radius: 25px;
      padding: 20px;
      max-width: 350px;
      min-width: 300px;
      flex-grow: 1;
    }

    .statistic_item .name{
      font-family: 'Reem Kufi Fun',serif;
      font-size: 20px;
      color: #000000;
      font-style: normal;
      line-height: 38px;
    }
    .statistic_item .badge-wrap{
      display: flex;
      flex-direction: column;
      gap: 20px;
      align-items: flex-start;
      border-top: 1px solid #cac8c8;
      padding-top: 20px;
      width: 100%;
    }
    .statistic_item .badge-wrap.inline{
      flex-wrap: wrap;
      flex-direction: row;
      gap: 5px;
    }
    .statistic_item .badge{
      background-color: #EDEDED;
      border-radius: 15px;
      padding: 7px;
    }
    .statistic_item .badge span{
      font-family: 'Reem Kufi Fun',serif;
      padding-left: 15px;
      padding-right: 15px;
      font-weight: 400;
      font-size: 18px;
      color: #000000;
    }
    .statistic_item .badge.open_console{
      background-color: #E4E4E4;
      padding: 5px;
      width: 100%;
      text-align: start;
    }
    .statistic_item .badge.open_console span{
      font-family: 'Reem Kufi Fun',serif;
      font-weight: 400;
      font-size: 20px;
      line-height: 33px;
      color: #000000;
    }

    .dark .statistic_item .badge-wrap{
      border-top: 1px solid #4b4b4b;
    }
   .dark .statistic_item{
      background-color: #2E2E2E;
    }

    .dark .statistic_item .name{
      color: #FFFFFF;
    }
    .dark .statistic_item .badge{
      background-color: #272727;
    }
    .dark .statistic_item .badge span{
      color: #FFFFFF;
    }
    .dark .statistic_item .badge.open_console{
      background-color: #242424;
    }

    .statistic_item a{
      transition: all .2s ease-in-out;
    }
    .statistic_item a:hover{
      transform: scale(1.1);
    }


    @keyframes placeHolderShimmer{
      0%{
        background-position: -468px 0
      }
      100%{
        background-position: 468px 0
      }
    }

    .statistic_item.loading .badge{
      animation-duration: 1.25s;
      animation-fill-mode: forwards;
      animation-iteration-count: infinite;
      animation-name: placeHolderShimmer;
      animation-timing-function: linear;
      background: darkgray;
      background: linear-gradient(to right, #eeeeee 10%, #dddddd 18%, #eeeeee 33%);
      background-size: 800px 104px;
      position: relative;
    }
    .statistic_item.loading .badge span, .statistic_item.loading .name{
      visibility: hidden;
    }

    .dark .statistic_item.loading .badge{
      background: linear-gradient(to right, #272727 10%, #3c3c3c 18%, #272727 33%);
      background-size: 800px 104px;
    }


</style>
