<template>
  <vue-progress-bar>Loading...</vue-progress-bar>
  <div
    class="d-flex justify-content-center mt-2 text-secondary"
    :class="loading ? '' : 'd-none'"
  >
    <div class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <a-skeleton active :loading="loading" />
</template>
<script>
export default {
  props: ["loading"],
};
</script>