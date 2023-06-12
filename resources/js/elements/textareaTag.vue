<template>
  <label for="description" class="form-label"
    >Mô tả ({{ countDescriptionLength }}/500)</label
  >
  <textarea
    :value="modelValue"
    class="form-control"
    cols="30"
    rows="5"
    maxlength="500"
    @input="$emit('update:modelValue', $event.target.value)"
    style="resize: none"
    placeholder="Nhập mô tả (500 ký tự)"
    v-bind:disabled="disable"
  ></textarea>
</template>
<script>
export default {
  props: ["modelValue", "label", "error", "disable"],
  computed: {
    countDescriptionLength() {
      if (this.modelValue) {
        var count = this.modelValue.length;
        return count;
      } else {
        return 0;
      }
    },
  },
};
</script>