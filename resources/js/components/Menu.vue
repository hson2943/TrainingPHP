<template>
  <a-menu
    id="categories"
    style="width: 256px; font-weight: 500"
    mode="inline"
    :default-open-keys="['categories']"
    :selected-keys="selectedKeys"
  >
    <a-sub-menu    key="categories" >
      <template #title>
        <slot class="menu-title"
          >Danh mục <i class="fas-solid fas-caret-down"></i
        ></slot>
      </template>
      <a-menu-item key="0" @click="emitCategory(['0'])">
        <span>Tất Cả</span>
      </a-menu-item>
      <a-menu-item
        v-for="category in model.categories"
        :key="category.id"
        @click="emitCategory([category.id])"
      >
        <span class="text-capitalize">{{ category.name }}</span>
      </a-menu-item>
    </a-sub-menu>
  </a-menu>
  <!-- -----------------------------------------BRAND---------------------------------------------- -->
  <hr style="color: rgb(215 215 215); margin-bottom: 0" />
  <a-menu
    id="brands"
    style="width: 256px; font-weight: 500"
    mode="inline"
    :default-open-keys="['brands']"
    :selected-keys="selectedKeys2"
  >
    <a-sub-menu  key="brands">
      <template #title>
        <slot class="menu-title">Hãng sản xuất</slot>
      </template>
      <span>
        <a-menu-item key='0' style="list-unstyled" @click="emitBrand(['0'])">
          <span >Tất Cả</span>
        </a-menu-item>
        <!-- ----------------------------- -->
        <a-menu-item
          v-for="brand in model.brands"
          :key="brand.id"
          @click="emitBrand([brand.id])"
        >
          <!-- ------------------------------- -->
          <span class="text-capitalize d-flex">{{ brand.name }}</span>
        </a-menu-item>
      </span>
    </a-sub-menu>
  </a-menu>
</template>
<script>
import { defineComponent } from "vue";
import axios from "axios";
import Category from "../Axios/CategoryAxios";
import Brand from "../Axios/BrandAxios";
export default defineComponent({
  data() {
    return {
      model: {
        brands: [],
        categories: [],
      },
      openKeys: ['categories'], 
      selectedKeys: ['0'], 
      openKeys: ['brands'], 
      selectedKeys2: ['0'], 
    };
  },
  async created() {
    const { brands, getBrands } = Brand();
    await getBrands();
    this.model.brands = brands;
    const { categories, getCategories } = Category();
    await getCategories();
    this.model.categories = categories;


    this.emitCategory(['0']);
  },
  methods: {
    emitBrand(brand_id) {
      this.selectedKeys2 =brand_id
      this.$emit("brand-emitted", {
        message: brand_id,
      });
      
    },

    emitCategory(category_id) {
      this.selectedKeys =category_id
      this.selectedKeys2 =['0']
      this.$emit("category-emitted", {
        message: category_id,
      });
      this.$emit("brand-emitted", {
        message: '0',
      });
        if (!category_id) {
           this.model.brands = "";
          return;
        }
        if (category_id) {
          axios
            .get(`http://127.0.0.1:8000/api/brandByCategory/${category_id}`)
            .then((res) => {
              this.model.brands = res.data.data.map(item => item.brand);
              console.log( this.model.brands)
            });
        }
    },
  },
});
</script>

<style scoped>
.collapse.in {
  min-height: 50px;
  border: 1px solid blue;
}
</style>
