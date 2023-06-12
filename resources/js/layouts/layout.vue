<template>
  <Header :roleAdmin="roleAdmin" @changeRole="handleRoleAdmin"  />
  <div class="container-fuild" style="overflow: hidden; background: whitesmoke">
    <div class="row">
      <div
        class="col-sm-2"
        style="
          min-height: 100vh;
          width: fit-content;
          background: white;
          padding: 0;
        "
      >
        <a-list>
          <Menu
            @brand-emitted="handleBrand"
            @category-emitted="handleCategory"
          />
        </a-list>
      </div>
      <div class="col-sm-8" style="padding: 30px 0; margin: 0 auto">
        <div class="row" style="margin-bottom: 28px; padding: 0">
          <div class="col-3" style="padding-left: 0">
            <button v-if="this.received_admin_role && this.$route.name == 'all-products'" class="btn btn-outline-primary" @click="openModal()">
              Thêm sản phẩm
            </button>
          </div>
          <div
            class="col-9"
            style="display: flex; justify-content: flex-end; padding: 0"
          >
            <Search v-if=" this.$route.name == 'all-products'" @fill-search-event="Handle_Data_Search" :save_keyword="received_data_search" />
          </div>
          <router-view
            :received_brand="received_brand"
            :received_category="received_category"
            :selected_from_search="received_data_search"
            :received_admin_role="received_admin_role"
          >
          </router-view>
        </div>

        <b-modal v-model="openModal" title="My Modal">
          <FormAddProduct />
        </b-modal>
      </div>
    </div>
  </div>
</template>


<script>
import "mosha-vue-toastify/dist/style.css";
export default {
  components: {},
  methods: {
    handleBrand(data) {
      this.received_brand = data.message;
    },
    handleCategory(data) {
      console.log(data.message);
      this.received_category = data.message;
    },
    Handle_Data_Search(data) {
      if(data==""){
        return
      }else{
        this.received_data_search = data.message;
      }
    },
    handleRoleAdmin(data){
this.received_admin_role=data
    },
    openModal() {
            if (this.$cookies.get('token')) {
                $('#FormAddProduct').modal('show')
            } else {
                $('#loginForm').modal('show')
            }
        }
  },
  data() {
    return {
      received_brand: 0,
      received_category: 0,
      received_data_search: "",
      received_admin_role: false,
    };
  },
};
</script>