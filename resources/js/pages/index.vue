<template>
  <div class="row-content content-product">
    <progress-bar :loading="loading" v-if="loading"/>
    <div class="container" v-else>
      <div class="justify-content-evently row" v-if="products.length>0">
        <div
          class="col-12 col-sm-6 col-lg-4 each-car"
          v-for="product in products"
          :key="product.id"
        >
          <product :product="product" v-on:loadProducts=" loadProduct(undefined, undefined,undefined, pagination.currentPage) " :admin_role="received_admin_role" />
        </div>
        <v-pagination class="my-pagination" v-model="store.page" :pages="last_page" :range-size="0" active-color="#DCEDFF" @update:modelValue=" loadProduct(received_category,received_brand,selected_from_search,store.page)"/>
      </div>
      <div v-else class="no_item col-12 text-center">
        <font-awesome-icon :icon="['fas', 'circle-exclamation']" size="2xl" style="color: #115ee4;" />
        <p class="text-center h3" >Không tìm thấy sản phẩm</p>
      </div>
    </div>
  </div>
</template>
<script>
import { defineComponent, ref, onMounted, watch } from "vue";
import axios from "axios"; // Import axios for making API calls
import { debounce } from "lodash";
import {store} from "../storeState/currentState";
export default defineComponent({
  emits: {
    loadProducts: null,
    changePagination: null,
  },
  props: {
    received_brand: {
      type: String,
      required: true,
    },
    received_category: {
      type: String,
      required: true,
    },
    selected_from_search: {
      type: String,
      required: true,
    },
    received_admin_role: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      store
    }
  },
  setup(props) {
    let products = ref([]);
    let loading = ref(false);
    let progress = ref(0); 
    let pagination = ref({
      currentPage: store.page,
    });
    let last_page = ref();
    const loadProduct = async (category_id, brand_id, key, page) => {
      if(page == undefined){
      }else{
        store.page = page
      }
      if (category_id == undefined || brand_id == undefined || key ==undefined) {
        category_id = props.received_category;
        brand_id = props.received_brand;
        key = props.selected_from_search;
      }
      loading.value = true;
      progress.value = 0;
      let form = new FormData();
      form.append("key", key);
      form.append("category_id", category_id);
      form.append("brand_id", brand_id);
      console.log(`http://127.0.0.1:8000/api/products?page=`+ store.page)
      return axios
        .post(
          `http://127.0.0.1:8000/api/products?page=`+ store.page ,form,{
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          setTimeout(() => {
            if(response.data.data.data.length == 0&& page>1){
              return loadProduct(props.received_category,props.received_brand,props.selected_from_search,store.page-1)
            }
            products.value = response.data.data.data;
            last_page.value = response.data.data.last_page;
            loading.value = false;
          }, 1000);
        })
        .catch((error) => {
        });
    };
    watch(
      () => props.received_brand,
      (newValue, oldValue) => {
        loadProduct(props.received_category, newValue,props.selected_from_search, props.selected_from_search, 1);
      }
    );
    watch(
      () => props.received_category,
      (newValue, oldValue) => {
        loadProduct(newValue, props.received_brand,props.selected_from_search , props.selected_from_search,1);
      }
    );
    watch(
      () => props.selected_from_search,
      (newValue) => {
        loadProduct(props.received_category, props.received_brand,newValue,store.page);
      }
    );
    watch(
      () => pagination.currentPage,
      (newValue) => {
        store.page = newValue;
      }
    );
    const debouncedLoadProducts = debounce(() => loadProduct(props.received_category, props.received_brand, props.selected_from_search, store.page), 500);
    onMounted(debouncedLoadProducts);
    return {
      products,
      pagination,
      progress,
      loading,
      last_page,
      loadProduct,
    };
  },
}
);
</script>
<style >
@import "@hennge/vue3-pagination/dist/vue3-pagination.css";
.my-pagination {
  display: flex;
  justify-content: center;
  margin-top: 60px;
}
.my-pagination li {
  margin: 0 5px;
}
.my-pagination li button {
  width: 40px;
  height: 40px;
  background-color: black;
  transition: transform 0.3s;
}
.my-pagination li button:hover {
  background-color: #f5f6f9;
  border: solid 1px #00ade8 ;
  transform: scale(1.1);
}
.my-pagination li button:focus {
  background-color: #f5f6f9;
  border: solid 1px #00ade8 ;
  transform: scale(1.1);
}
.content-product {
  background-color: #fff;
  border-radius: 10px;
  margin-top: 50px;
  width: 100%;
  padding-right: 5%;
  padding-bottom: 10%;
}
.no_item{
margin-top: 10%;
}
</style>
