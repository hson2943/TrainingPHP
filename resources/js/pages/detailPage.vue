<template>
  <div
    class="content form-control"
    style="border-radius: 25px; padding-bottom: 50px;"
  >
    <progressBar :loading="activeSpinner" />
    <div class="container" :class="[loadSuccess ? '' : 'd-none']">
      <div class="row">
        <p
          @click="this.$router.go(-1)"
          style="
            cursor: pointer;
            width: fit-content;
            display: block;
            color: #00ade8;
            margin: 30px 0 16px 0;
          "
        >
          <font-awesome-icon icon="arrow-left" style="margin-left: -1" />
          <span
            style="
              font-weight: 600;
              align-items: center;
              display: inline-flex;
              min-height: 100%;
              padding-left: 8px;
            "
          >
            Quay lại
          </span>
        </p>
      </div>
      <div class="row">
        <div class="col-sm-5 product-detail">
          <h5 style="margin-bottom: 21px">{{ this.product.name }}</h5>
          <p class="mb-2 text-capitalize">
            Danh mục: <span>{{ this.category }}</span>
          </p>
          <p class="mb-2 text-capitalize">
            Hãng sản xuất: <span>{{ this.brand }}</span>
          </p>
          <p>
            Giá sản phẩm:
            <span>$ {{ formatCurrency(this.product.prices) }}</span>
          </p>
          <p class="mb-2">Mô tả sản phẩm:</p>
          <p class="product-description">
            {{ this.product.description || "Sản phẩm không có mô tả." }}
          </p>
        </div>
        <div class="col-sm-7 slides">
          <div
            id="carouselExampleIndicators"
            class="carousel slide"
            data-bs-ride="true"
          >
            <div class="carousel-indicators" v-if="galleries.length > 1">
              <button
                v-for="(slide, index) in galleries"
                :key="slide.id"
                type="button"
                data-bs-target="#carouselExampleIndicators"
                :data-bs-slide-to="index"
                :class="index == 0 ? 'active' : ''"
                aria-current="true"
                class="doc"
                @click="clickToChangeImage"
              ></button>
            </div>
            <div class="carousel-inner">
              <div v-if="galleries.length > 0" :class="['fade', isActive ? 'active' : '']">
                <div
                  class="carousel-item "
                  :class="[index == 0 ? 'active' : '']"
                  v-for="(slide, index) in galleries"
                  :key="slide.id" >
                  <img :src="slide.url_image" class=" d-block w-100" />
                </div>
              </div>
              <div v-else :class="['fade', isActive ? 'active' : '']">
                <img :src="this.product.thumbnail" class=" d-block w-100" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row" v-if="relativeProducts.length > 0">
        <p class="mt-4 mb-3 fw-bold">Gợi ý cho bạn</p>
        <div
          class="col-12 col-sm-6 col-lg-4"
          v-for="product in relativeProducts"
          :key="product.id"
        >
          <product :product="product" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
var numeral = require("numeral");
export default {
  props: ["lenghtProducts", "products", "pagination", "loadingProducts"],
  emits: ["loadProducts", "changePagination"],
  data() {
    return {
      activeSpinner: true,
      loadSuccess: false,
      errorList: "",
      category: "",
      brand: "",
      id: "",
      product: [],
      galleries: [],
      relativeProducts: [],
      isActive: false,

    };
  }, 
  mounted() {
    setTimeout(() => {
      this.isActive = true;
    }, 1000); // Delay the fade-in effect for 1000 milliseconds (1 second)
  },
  created() {
    this.id = this.$route.params.id;
    this.getProduct(this.id);
  },
  methods: {
    clickToChangeImage(){
      this.isActive = false;
      setTimeout(() => {
      this.isActive = true;
    }, 1000);
    },
    getProduct(id) {
      this.$Progress.start();
      this.activeSpinner = true;
      this.loadSuccess = false;
      axios
        .get(`/api/details/${id}`)
        .then((res) => {
          let data = res.data.data;
          this.product = data;
          this.category = this.product.category.name;
          this.brand = this.product.brand.name;
          this.galleries = this.product.gallery;
          this.getRelativeProduct(id);
        })
        .catch((err) => {
          this.$Progress.fail();
          // this.$router.push({ name: "notFound" });
        });
    },
    getRelativeProduct(id) {
      axios
        .get(`/api/product/${id}/relativeProducts`)
        .then((response) => {
          this.relativeProducts = response.data.data;
          this.$Progress.finish();
          this.activeSpinner = false;
          this.loadSuccess = true;
        })
        .catch((err) => {
          this.$Progress.fail();
        });
    },

    formatCurrency(currency) {
      return numeral(currency).format("0,0[.]00");
    },
  },
  watch: {
    $route: {
      handler(newValue, oldValue) {
        if (this.$route.name == "product-detail") {
          this.getProduct(this.$route.params.id);
        }
      },
    },
  },
};
</script>
<style scoped>
.doc {
  background-color: gray;
  border-radius: 100%;
  height: 20px;
  width: 20px;
  opacity: 1 !important;
}

.active {
  background-color: #0094ff;
}

.slides {
  height: 316px;
}

.fade {
  opacity: 0;
  transition: opacity 1s;
}

.fade.active {
  opacity: 1;
}
</style>