<template>
  <select v-model="localModelValue" @change="changeOption">
    <option
      v-for="option in options"
      :key="option.id"
      :value="option.id"
    >
      {{ option.name }}
    </option>
  </select>
</template>

<script>
export default {
  name: 'TheSelect',
  props: {
    computed: {
      localModelValue: {
        get() {
          return this.modelValue
        },
        set(newValue) {
          this.$emit('update:modelValue', newValue)
        },
      },
    },
    modelValue: {
      type: String
    },
    options: {
      type: Array,
      default: () => []
    }
  },
  methods: {
    changeOption(event) {
      this.$emit('update:modelValue', event.target.value);
    }
  }
}
</script>

<style scoped>
</style>
