<template>
  <div class="modal open" v-if="show" @click.stop="hideDialog">
    <div class="modal-content">
      <div class="background-modal"></div>
      <div @click.stop class="modal-box database_switcher">
        <span class="close" @click.stop="hideDialog">&times;</span>
        <p>SELECT DATABASE</p>
        <div class="select">
          <select v-model="selectedDatabase">
            <option v-for="database in $store.state.databases.databases" v-bind:value="database.id"
                    v-bind:key="database.id">{{ database.name }}
            </option>
          </select>
        </div>
        <div class="box-radio">
          <template v-for="version in $store.getters['databases/getDatabase']($store.state.sandbox.page.databaseVersion.database.id).versions"  v-bind:key="version.id">
            <input v-if="$store.state.databases.selectedVersion === version.id" checked v-model="selectedVersion"  type="radio" v-bind:value="version.id" :id="version.id">
            <input v-else v-model="selectedVersion"  type="radio" v-bind:value="version.id" :id="version.id">
            <label :for="version.id">{{ version.name }}</label>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import toggleMixin from "@/mixins/toggleMixin";
export default {
  name: 'TheDialog',
  mixins: [toggleMixin],

  computed: {
    selectedDatabase: {
      get() { return this.$store.state.sandbox.page.databaseVersion.database.id },
      set(value) { this.$store.commit('databases/setDatabaseToSandBox', [value])  }
    },
    selectedVersion: {
      get() { return this.$store.state.sandbox.page.databaseVersion.id },
      set(value) { this.$store.commit('databases/setDatabaseToSandBox', [this.selectedDatabase, value])  }
    }
  },
}
</script>

<style scoped>
</style>
