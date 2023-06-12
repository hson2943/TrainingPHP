<template>
      <div class="modal fade" id="message-popup" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="message-popup" :aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-end">
                            <button class="d-flex justify-content-center p-0 border-0 rounded-circle close-pupup"
                                style="width:fit-content">
                                <img src="/image_svg/iconClose.svg" @click="dismissMessageModel" alt="">
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center">
                                <img :src="'https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/logos%2Fcreate_update.png?alt=media&token=564a7085-05f2-4e97-95df-514829d9271a' + message.icon" alt="" v-if="message.icon" width="200"
                  height="200">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-center fw-bold message-popup">Thêm thành công</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <!-- <message-modal :message="message" :action="'add'" /> -->
  <error-modal :message="message" @disable_input="disableInput"/>
  <div  class="modal fade bd-example-modal-lg "  id="FormAddProduct"  tabindex="-1"  data-bs-backdrop="static"  data-bs-keyboard="false"  aria-labelledby="exampleModalLabel">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-uppercase" id="exampleModalLabel">
            thêm sản phẩm
          </h5>
            <font-awesome-icon id="close" @click="dismissAddProductModal" type="button" icon="circle-xmark" style="font-size: 18px" />

        </div>
        <spinner />
        <div class="modal-body">
          <form @submit.prevent="addProduct">
            <div class="mb-1">
              <input-tag :disable="this.disable_input"  v-model="model.product.name" label="Tên Sản Phẩm" type="text" />
            </div>
            <div class="mb-1">
              <select-tag :disable_brand="this.disable_input"  v-model="model.product.category_id" :data="model.categories"  label="Danh mục sản phẩm" :disableBrands="false"/>
            </div>
            <div class="mb-1">
              <select-tag :disable_brand="disableBrands" v-model="model.product.brand_id" :data="model.brands" label="Hãng sản xuất"/>
            </div>
            <div class="mb-1">
              <input-tag :disable="this.disable_input"  v-model="model.product.prices" label="Giá" type="text" forName="prices"/>
            </div>
            <div class="mb-1">
              <textarea-tag :disable="this.disable_input" v-model="model.product.description" label="Mô Tả" />
            </div>
            <div>
              <label for="thumbnail" class="text-successs">Thêm ảnh minh hoạ <span class="text-danger">*</span></label>
              <vue-progress-bar style="position: relative"></vue-progress-bar>
              <label for="thumbnail" class="text-successs d-block">
                <img :src="model.product.thumbnail" v-if="model.product.thumbnail" alt="" style="display: block" class="img-fluid" />
                <img :src="unknow_img" v-else alt="" style="display: block" class="img-fluid" />
              
              </label>
              <input :disable="this.disable_input" name="thumbnail" id="thumbnail" type="file" ref="thumbnail" style="visibility: hidden; display: none" accept="image/*" @change="validateImage" />
              <span class="text-danger error"> </span>
            </div>
            <div class="modal-footer" style="justify-content: center">
              <button @click="dismissAddProductModal" type="button" class="btn btn-outline-primary" > Huỷ  </button>
              <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Category from "../Axios/CategoryAxios";
import Brand from "../Axios/BrandAxios";
import { uploadFile,removeFile } from "../firebase/firebaseComp";
export default {
  name: "Create New Product",
  props: ["category"],
  emits: {
    reloadProduct: null,
    loadProducts: null,
  },
  data() {
    return {
      loading: false,
      disable_input: false, unknow_img: "https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/logos%2F485x325.png?alt=media&token=a8ec51e1-774b-44b1-8657-9e9e5a47af9f",
      model: {
        brands: [],brandsTemp: [],categories: [],categoriesTemp: [],product: {name: "",prices: "",category_id: "",brand_id: "",description: "",thumbnail: "",},idProductNew: "",
      },
      disableBrands: true,
      message: {text: "",icon: "",},
      spinnerCreateProduct: false,
    };
  },
  async created() {
    const { brands, getBrands } = Brand();
    await getBrands();
    this.model.brands = brands;
    this.model.brandsTemp = [...this.model.brands];

    const { categories, getCategories } = Category();
    await getCategories();
    this.model.categories = categories;
    this.model.categoriesTemp = [...this.model.categories];
  },
  methods: {
    disableInput(disable){
        this.disable_input = disable;
      this.disable_brand = disable;
    },
    async uploadImageToCloud(file) {
      this.$Progress.start(0);
      try {
        removeFile(this.model.product.thumbnail);
        this.model.product.thumbnail = await uploadFile(file);
        this.$Progress.finish();
      } catch (error) {
        this.$Progress.fail();
        this.errorsImage = "Thêm ảnh không thành công!";
      }
    },
    async validateImage(e) {
      let file = e.target.files[0];
      if (file) {
        if (!["image/jpeg", "image/png", "image/gif", "image/webp"].includes(file.type)
        ) {
          this.$toast.error("Loại hình ảnh không hợp lệ.('image/jpeg', 'image/png', 'image/gif', 'image/webp')", {
          position: "top-right",
          duration: 3000,
        });
          return;
        }
        if (file.size > 2 * 1024 * 1024) {
          this.$toast.error("Độ phân giải quá lớn.(Dung lượng ảnh phải nhỏ hơn 2MB)", {
          position: "top-right",
          duration: 3000,
        });
          return;
        }
        this.uploadImageToCloud(file);
        this.errorsImage = "";
      }
    },
    async addProduct() {
      if (this.model.product.name == "" ||this.model.product.prices == "" ||this.model.product.category_id == "" ||this.model.product.brand_id == "" ||this.model.product.thumbnail == "") {
        this.$toast.error("Chưa nhập dữ liệu không thể thêm.", {
          position: "top-right",
          duration: 3000,
        });
        return;
      }
      const json_product = JSON.stringify({
        product: JSON.parse(JSON.stringify(this.model.product)),
      });
      this.spinnerCreateProduct = true;
      this.disableInput(true);
        fetch("/api/product/store", {
        method: "POST",
        headers: {"Content-Type": "application/json", "Authorization": `Bearer ${this.$cookies.get("token")}`},
        body: json_product,
      })
        .then((response) => {
          if (!response.ok) {
      throw new Error("Network response was not OK");
    }
          return response.json();
        })
        .then((data) => {
          if (data.error) {
      throw new Error(data.error.message); 
    }
          this.resetData();
          this.openPopup();
          this.$emit("loadProducts");
          this.spinnerCreateProduct = false;
          setTimeout(() => {
            this.dismissMessageModel();
          }, 2000);
          this.idProductNew = data.data.id;
        })
        .catch((error) => {
          this.spinnerCreateProduct = false;
          this.message.text = "Có lỗi xảy ra";
          $("#errorModal").modal("show");
          this.disableInput(false);
        });
    },
    openPopup: function () {
      this.message.icon ="https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/logos%2F485x325.png?alt=media&token=39bd7498-5cbd-46c1-88d2-81d558bf5da7";
      $("#message-popup").modal("show");
      this.dismissAddProductModal();
      if (!this.clickCloseMessageModal) {
        this.setTimeOutMessageModal();
      }
    },
    dismissAddProductModal: function () {
      $("#FormAddProduct").modal("hide");
      this.disableInput(false);
      this.resetData();
    },
    dismissMessageModel: function () {
      this.clickCloseMessageModal = true;
      $("#message-popup").modal("hide");
      try{
        this.$router.push({
        name: "product-detail",
        params: { id: this.idProductNew },
      });
      }catch(e){
        return;
      }
    },
    resetData() {
      this.model.product = {
        name: "",prices: "",category_id: "",brand_id: "",description: "",thumbnail: "",
      };
      this.errorsImage = "";
      this.loading = false;
      this.errors = [];
      this.fileSelected = "";    
    },
    setTimeOutMessageModal() {
      setTimeout(() => {
        this.dismissMessageModel();
      }, 2000);
    },
  },
  watch: {
    "model.product.category_id": {
     async handler() {
        let category_id = this.model.product.category_id;
        this.disableBrands = false;
        if (!category_id) {
          this.disableBrands = true;
          return;
        }
        if (category_id) {
          axios
            .get(`http://127.0.0.1:8000/api/brandByCategory/${category_id}`)
            .then((res) => {
              this.model.brands = res.data.data.map(item => item.brand);
            });
        }else 
        {
          this.model.brands = this.model.brandsTemp
        }},},},};
</script>
<style scoped>
.modal{
  z-index: 9998;
}
.btn {
  border-radius: 25px;
  width: 25%;
}
.btn-primary {
  background-color: #00ccff; 
  color: #ffffff; 
border: none;
}
.btn-outline-primary{
  background-color: #ffffff ; 
  color: #00ccff;
  border: 1px solid #00ccff;
}
.btn-primary:hover {
  background-color: #ffffff ; 
  color: #00ccff;
  border: 1px solid #00ccff;
}
.btn-outline-primary:hover {
  background-color: #00ccff;
  color: #ffffff; 
}
</style>