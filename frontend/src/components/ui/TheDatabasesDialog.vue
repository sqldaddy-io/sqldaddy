<template>
  <TheDialog v-model:show="dialogDatabase">

  </TheDialog>
</template>

<script>
import TheDialog from "@/components/ui/TheDialog";
export default {
  name: 'TheDatabasesDialog',
  components: {TheDialog},
  data() {
    return {
      dialogDatabase: false
    }
  },
  props: {
    dialogVisible: {
      type: Boolean,
      default: false
    }
  },
  methods:{
    showDialogDatabase(){
      this.dialogDatabase = this.dialogVisible;
    }
  }
}
</script>

<style scoped>

</style>
