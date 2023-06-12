<template>
  <div class="content-product">
    <div
      class="col-12 col-sm-6 col-lg-4 each-car"
      v-for="product in products"
      :key="product.id"
    >
      <product :product="products" :admin_role="admin_role" />
    </div>
  </div>
</template>
<script>
export default {
  props: ["products", "admin_role"],
};
</script>
<style scoped>
.content-product {
  background-color: #fff;
  border-radius: 10px;
  margin-top: 30px;
  justify-content: space-around;
}
</style>