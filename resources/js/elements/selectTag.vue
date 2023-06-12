<template>
  <label class="form-label"
    >{{ label }} <span class="text-danger">*</span></label
  >
  <select
    :value="modelValue"
    class="form-select categories-select text-capitalize"
    :disabled="disable_brand"
    @change="$emit('update:modelValue', $event.target.value)"
  >
    <option value="" selected>Chọn {{ label }}</option>
    <option :value="item.id" v-for="item in data" :key="item.id">{{ item.name }}</option>
  </select>
  <span class="text-danger error">{{ !modelValue ? error : "" }}</span>
</template>
<script>
export default {
  props: ["modelValue", "label", "error", "data", "disable_brand"],
};
</script>