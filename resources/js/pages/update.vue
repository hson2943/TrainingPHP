<template>
  <div class="content content-product">
    <progress-bar :loading="loadProduct" />
    <form v-on:submit.prevent="saveProduct" class="form-content">
      <div class="row">
        <div class="col-6">
          <h4>Thông tin sản phẩm</h4>
          <div class="mb-1">
            <input-tag :disable="this.disable_input" v-model.trim="product.name" label="Tên sản phẩm" />
          </div>
          <div class="mb-1">
            <select-tag :disable="this.disable_input" v-model="product.category_id" :data="categories" label="Danh mục sản phẩm" :disable_brand="this.disable_input"/>
          </div>
          <div class="mb-1">
            <select-tag v-model="product.brand_id" :data="brands" label="Hãng sản xuất" :disable_brand='disable_brand'/>
          </div>
          <div class="mb-1">
            <input-tag :disable="this.disable_input" v-model="product.prices" :data="prices" label="Giá" />
          </div>
          <div class="mb-1">
            <textarea-tag :disable="this.disable_input" v-model="product.description" :data="description" label="Mô Tả"/>
          </div>
          <div class="mb-1" style=" display: flex; justify-content: space-evenly; margin-top: 48px !important;">
            <a @click="backRoute()" class="btn btn-outline-primary d-flex justify-content-center align-items-center">Huỷ</a >
            <button type="submit" class="btn btn-primary">Lưu</button>
          </div>
        </div>
        <div class="col-6">
          <p>Ảnh minh hoạ<span class="text-danger">*</span></p>
          <div class="mb-4" :class="['fade', isActive ? 'active' : '']">
            <img :src="this.product.thumbnail" class="thumbnail" alt="" />
          </div>
          <p>Ảnh Slide</p>
          <vue-progress-bar style="position: relative"></vue-progress-bar>
          <p class="text-danger error">{{ errorsImage }}</p>
          <div class="row img-slide">
            <div class="col-6" v-for="index in 4" :key="index">
              <p>Ảnh {{ index }}</p>
              <div id="image_div">
                <div class="img_wrapper" v-if="galleries[index - 1].url_image">
                  <img :src="getImage(index)" :id="'image' + index" class="img-fluid"/>
                  <div class="action">
                    <div>
                      <label :for="'updateSlide' + index">Chỉnh sửa</label>
                      <label @click="deleteImage(index)">Xoá</label>
                    </div>
                  </div>
                  <input v-bind:disabled="this.disable_input" type="file"  name="urlImage"  style="display: none"  :id="'updateSlide' + index"  @change="createOrUpdateSlide($event, index)"  accept="image/*"  />
                </div>
                <label :for="'addSlide' + index" v-else>
                  <img  src="https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/logos%2FScreenshot%202023-04-30%20221623.png?alt=media&token=7c01b4b0-59e1-4008-b505-63eeb59a8546" alt="" class="icon-plus" />
                </label>
                <input  type="file"  name="url_image"  style="display: none"  :id="'addSlide' + index"  @change="createOrUpdateSlide($event, index)"  accept="image/*"/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <message-modal :message="message" :action="'edit'" />
  <error-modal :message="message" />
</template>
<script>
import Category from "../Axios/CategoryAxios";
import Brand from "../Axios/BrandAxios";
import { uploadFile,removeFile } from "../firebase/firebaseComp";
export default {
  props:["products","pagination","lenghtProducts","loadingProducts"],
  emits: ["loadProducts", "changePagination"],
  data() {
    return {old_img:"", list_img: [],isActive: false,errorsImage: "",errors: [], brands: [],brandsTemp: [], categories: [], categoriesTemp: [],
 product: { name: "", prices: "", category_id: "", brand_id: "", description: "", thumbnail: "",},
      disable_input: false,
      disable_brand: true,
      productTemp: {},
      galleries: [{ id: "", index: 1, url_image: "" }, { id: "", index: 2, url_image: "" }, { id: "", index: 3, url_image: "" },{ id: "", index: 4, url_image: "" }, ],
      slideExists: [],
      loadProduct: true,
      message: { text: "",icon: "", },
      disable_brand: false,
    };
  },
  mounted() {
    setTimeout(() => {
      this.isActive = true;
    }, 1000); // Delay the fade-in effect for 1000 milliseconds (1 second)
  },
  async created() {
    const { brands, getBrands } = Brand();
    await getBrands();
    this.brands = brands;
    this.brandsTemp = [...this.brands];
    const { categories, getCategories } = Category();
    await getCategories();
    this.categories = categories;
    this.categoriesTemp = [...this.categories];
    this.id = this.$route.params.id;
    this.getProduct(this.id);   
  },
  methods: {
    disableInput(disable){
      this.disable_input = disable;
      this.disable_brand = disable;
    },
    getProduct(id) {
      this.$Progress.start();
      axios
        .get("/api/details/" + id)
        .then((response) => {
          this.product = response.data.data;
          this.productTemp = { ...this.product };
          let gallery = response.data.data.gallery;
          for (var i in gallery) {
            this.galleries[gallery[i].index - 1].url_image =
              gallery[i].url_image;
            this.galleries[gallery[i].index - 1].id = gallery[i].id;
          }
          this.loadProduct = false;
          if (!this.loadProduct) {
            this.$Progress.finish();
          }
        })
        .catch((error) => {
          this.$Progress.fail();
          this.$router.push({ name: "notFound" });
        });
    },
    deleteImage(index) {
      removeFile(this.galleries[index - 1].url_image);
      this.galleries[index - 1].url_image = "";
      this.slideExists[index - 1] = true;
    },
    async createOrUpdateSlide(event, index) {
      let file = event.target.files[0];
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
      }
      this.slideExists[index - 1] = true;
      this.$Progress.start();
      try {
        removeFile(this.galleries[index - 1].url_image);
        this.galleries[index - 1].url_image = await uploadFile(file);
        this.old_img = 
        this.$Progress.finish();
      } catch (error) {
        this.$Progress.fail();
      }
    },
    getImage(index) {
      return this.galleries[index - 1].url_image;
    },
    saveProduct: function () {
     
      if ( this.product.name == "" || this.product.prices == "" || this.product.category_id == "" || this.product.brand_id == "" || this.product.thumbnail == "" || this.product.description == ""
      ) {
        this.$toast.error("Chưa nhập dữ liệu không thể thêm.", {
          position: "top-right",
          duration: 3000,
        });
        return;
      }
      if (
        JSON.stringify(this.productTemp) === JSON.stringify(this.product) &&
        this.slideExists.length == 0
      ) {
        this.$toast.error("Dữ liệu chưa thay đổi! Không thể lưu.", {
          position: "top-right",
          duration: 3000,
        });
        return;
      }
      this.disableInput(true);
      let form = new FormData();
      form.append("name", this.product.name);
      form.append("category_id", this.product.category_id);
      form.append("brand_id", this.product.brand_id);
      form.append("description", this.product.description);
      form.append("prices", this.product.prices);
      form.append("thumbnail", this.product.thumbnail);
      form.append("galleries", JSON.stringify(this.galleries));
      form.append("_method", "put");
      axios
        .post("/api/product/update/" + this.id, form, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          $("#messageModal").modal("show");
          this.setTimeout("product-detail");
        })
        .catch((errors) => {
          this.message.text = "Có lỗi xảy ra";
            $("#errorModal").modal("show");
            this.disableInput(false);
        });
    },
    setTimeout: function (namePath) {
      setTimeout(() => {
        $("#messageModal").modal("hide");
        this.$router.push({ name: namePath });
      }, 1500);
    },
    backRoute() {
      this.$router.go(-1);
    },
  },
  watch: {
    "product.category_id": {
     async handler() {
      let category_id = this.product.category_id;
        this.disable_brand = false;
        if (!category_id) {
          this.disable_brand = true;
          return;
        }
        if (category_id) {
          axios
            .get(`http://127.0.0.1:8000/api/brandByCategory/${category_id}`)
            .then((res) => {
              this.brands = res.data.data.map(item => item.brand);
            });
        }else 
        {
          this.brands = this.brandsTemp
        }
      },
    },
  },
  computed: {
    countDescriptionLength() {
      if (this.product.description) {
        var count = this.product.description.length;
        return count;
      } else {
        return 0;
      }
    },
  },
};
</script>
<style scoped>
.thumbnail {
  height: 250px;
  width: 100%;
}
.icon-plus {
  display: flex;
  padding: 10px;
  height: 74px;
  width: 74px;
  border-radius: 8px;
  border: 1px solid #0000000a;
  box-shadow: 0px 0px 4px 0px rgb(0 0 0 / 20%);
  color: #00ccff;
  cursor: pointer;
  transition: transform 0.3s;
}
.icon-plus:hover {
  transform: scale(1.1);
}
#image_div {
  width: 200px;
  height: 150px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.img_wrapper img {
  width: 200px;
  height: 150px;
}
#image_div .img_wrapper {
  position: relative;
  display: inline-block;
}
#image_div .img_wrapper img {
  width: 100%;
}
#image_div .img_wrapper .action {
  display: none;
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  background: rgba(0, 0, 0, 0.265);
  align-content: center;
  text-align: center;
  width: 100%;
  flex-wrap: wrap;
  justify-content: center;
}
#image_div .img_wrapper:hover .action {
  display: flex;
}
#image_div .img_wrapper label {
  width: 100px;
  padding: 10px;
  background-color: rgba(255, 255, 255, 0.5);
  color: white;
  margin-top: 5px;
  border-radius: 5px;
  display: block;
  cursor: pointer;
  border: 1px solid rgba(255, 255, 255, 0.5);
}
#image_div .img_wrapper label:hover {
  border: 1px solid black;
  color: black;
  background-color: rgba(255, 255, 255, 0.8);
}
.content-product {
  background-color: #fff;
  border-radius: 10px;
  margin-top: 30px;
  width: 100%;
}
.form-content {
  margin: 5%;
}
.btn {
  width: 37%;
}
.fade {
  opacity: 0;
  transition: opacity 1s;
}
.fade.active {
  opacity: 1;
}.btn-primary {
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