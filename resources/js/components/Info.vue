<template>
  <div class="info">
    <div class="details-info">
      <div class="product-namee" style="font-size: 20px">
        {{ product.name }}
      </div>
      <div class="product-typee">Danh mục: {{ product.typeName }}</div>
      <div class="product-producer">
        Hãng Sản Xuất: {{ product.producerName }}
      </div>
      <div class="product-price">
        Giá Sản Phẩm: {{ formatPrice(parseInt(product.price)) }}
      </div>
      <div class="product-des">
        Mô Tả Sản Phẩm:
        <div style="padding-right: 30px">{{ product.description }}</div>
      </div>
    </div>
    <div class="slide" style="z-index: 0">
      <div
        :style="{
          'background-image': product.image
            ? 'url(/images/des/' + product.image + ')'
            : 'url(/images/des/loading.jpg' + ')',
          height: '320px',
          width: '100%',
          'background-repeat': 'no-repeat',
          'background-size': '100% 100%',
        }"
        v-if="slide.length == 0"
      ></div>
      <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="3000" v-else>
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li
            data-target="#myCarousel"
            :data-slide-to="index"
            v-for="(item, index) in slide"
            :key="index"
            :class="{ active: index == 0 }"
          ></li>
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div
            class="item"
            v-for="(image, index) in slide"
            :key="image.id"
            :class="{ active: index == 0 }"
          >
            <div
              :style="{
                'background-image': image.image_url
                  ? 'url(/images/slide/' + image.image_url + ')'
                  : 'url(/images/des/loading.jpg' + ')',
                'background-repeat': 'no-repeat',
                'background-size': '100% 100%',
                width: '100%',
                height: '320px',
              }"
              :alt="'slide' + index"
            ></div>
          </div>

          <!-- Left and right controls -->
          <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a
            class="right carousel-control"
            href="#myCarousel"
            data-slide="next"
          >
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
      default: {},
    },
    slide: {
      type: Array,
      default: [],
    },
  },
  data: function () {
    return {};
  },
  methods: {
    formatPrice(price) {
      return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        maximumFractionDigits: 0,
      }).format(price);
    },
  },
};
</script>

<style>
.carousel-indicators {
  justify-content: space-evenly;
  left: 28%;
  width: 12%;
}
.carousel-indicators li {
  background-color: #fff;
  border: none;
}
.carousel-indicators .active {
  background-color: #0094ff;
}
</style>