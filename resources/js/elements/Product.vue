<template>
  <div class="card product custom-card">
    <img
      @click="detailProduct(product.id)"
      :src="product.thumbnail"
      alt="Example Image"
      class="img-fluid "
      v-if="product.thumbnail"
    />
    <!-- <img
    @click="detailProduct(product.id)"
      src="https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/logos%2F485x325.png?alt=media&token=a8ec51e1-774b-44b1-8657-9e9e5a47af9f"
      alt="Example Image"
      class="img-fluid "
      v-else
    /> -->
    <div class="card-body ">
      <h5 class="card-title text-capitalize custom-card-body">{{ product.name }}</h5>
      <div class="card-action custom-card-body" v-if="admin_role">
        <button class="btn-action btn-success" @click="editProduct(product.id)">
          Cập Nhật
        </button>
        <button
          class="btn-action btn-delete"
          data-bs-toggle="modal"
          :data-bs-target="'#confirmDelete' + product.id"
        >
          Xoá
        </button>
      </div>
      <p v-else class="card-text custom-card-body">${{ formatCurrency(product.prices) }}</p>
    </div>
  </div>
  <confirm-popup
        :id="product.id"
        :name="product.name"
        :pagination="pagination"
        v-on:loadProducts="$emit('loadProducts')"
      />
</template>

<script>

var numeral = require("numeral");
export default {

  emits: ["loadProducts"],
  props: ["product", "pagination", "admin_role", "reloadProduct"],

  methods: {
 
    formatCurrency(currency) {
      return numeral(currency).format("0,0[.]00");
    },

    editProduct(id) {
            if (this.$cookies.get('token')) {
              this.$router.push({ name: "product-update", params: { id: id } });
            } else {
                $('#loginForm').modal('show')
            }
    },

    detailProduct(id) {
      this.$router.push({ name: "product-detail", params: { id: id } });
    },

  },
};

</script>

<style scoped>
.card-action {
  display: flex;
  justify-content: space-between;
}
.card{
  transition: transform 0.5s;
}
.btn-action {
  width: 47%;
  height: fit-content;
  color: white;
  padding: 5px;
  text-align: center;
  border-radius: 4px;
  border: 1px solid;
}

.btn-success {
  background-color: #6ecb63;
}

.btn-success:hover {
  background-color: white;
  border-color: #6ecb63;
  color: #6ecb63;
}

.btn-delete {
  background-color: #ff4d4d;
  color: white;
}

.btn-delete:hover {
  background-color: white;
  border-color: #ff4d4d;
  color: #ff4d4d;
}
.fixed-image {
  width: 100%; 
  height: 100%; 
}
.product {
  border-radius: 10px;
  padding-top: 10px;
  margin-left: 12%;
  margin-top: 13%;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}
.card:hover{
  transform: scale(1.1);
}

.custom-card {
  min-width: 200px;
  min-height: 80%;
}
.custom-card-body {
  white-space: nowrap; /* Prevent text from wrapping */
  overflow: hidden; /* Hide any overflowed content */
  text-overflow: ellipsis;
}
</style>