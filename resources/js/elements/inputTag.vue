<template>
  <label class="form-label text-capitalize"
    >{{ label }} <span class="text-danger">*</span></label
  >
  <input
    :type="type"
    :value="modelValue"
    @input="handleInputValue"
    class="form-control"
    @keypress="checkPriceInput"
    :maxlength="forName == 'price' ? 10 : 50"
    :placeholder="'Nhập ' + label"
    v-bind:disabled="disable"
  />
  <span class="text-danger error">
    <span v-if="showError">{{ error }}</span>
  </span>
</template>
<script>
export default {
  props: ["modelValue", "label", "error", "type", "forName","disable"],
  data() {
    return {
      showError: true,
      errorCustom: "",
    };
  },
  methods: {
    checkPriceInput(event) {
      if (this.forName == "price") {
        if (/\D/.test(event.key)) {
          event.preventDefault();
        }
      }
    },
    handleInputValue(event) {
      var value = event.target.value;
      value = value.replace(/\s+/g, " ");
      if (value.length == 0) {
        this.showError = true;
        this.errorCustom = this.label + " không được để trống";
      } else if (this.forName == "price") {
        value = parseInt(value);
        if (value < 10000 || value > 1000000000) {
          this.showError = true;
        } else {
          this.showError = false;
        }
      } else {
        this.showError = false;
      }

      this.$emit("update:modelValue", value);
    },
  },
  watch: {
    error() {
      this.showError = true;
      this.errorCustom = "";
    },
  },
};
</script>

<style>
.required {
  border-color: red;
}
</style>