<template>
  <div
    class="modal confirmModal"
    :id="'confirmDelete' + id"
    tabindex="-1"
    :aria-labelledby="id"
    :aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content custom-modal-content">
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row mb-4">
              <div class="col-md-12 d-flex justify-content-center">
                <img src="https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/logos%2FiconDelete.png?alt=media&token=ee7473a9-185c-4613-8b51-f930201e528b" alt="" width="100"
                  height="100"/>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-12">
                <p class="text-center">
                  Bạn có chắc muốn xóa sản phẩm
                  <span class="text-danger">{{ name }}</span>?
                  <span class="text-center d-block">Sản phẩm sẽ bị
                    <span class="text-danger">xóa vĩnh viễn</span>.
                  </span>
                </p>
              </div>
            </div>
            <div class="modal-footer" style="justify-content: center">
            <button class="btn btn-outline-primary " data-bs-dismiss="modal">
              Huỷ
            </button>
            <button
              class="btn btn-danger btn-cycle"
              :data-bs-target="'#confirmDelete' + id"
              data-bs-toggle="modal"
              data-bs-dismiss="modal"
              @click="deletedProduct()"
            >
              Xoá
            </button>
          </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  <message-modal :message="message" :action="'delete1'" />
  <error-modal :message="message" />
</template>
<script>
import { removeFile } from "../firebase/firebaseComp";
export default {
  name: "confirm popup",
  props: ["id", "name", "pagination"],
  emits: ["loadProducts"],
  created() {},
  data() {
    return {
      message: {
        icon: "",
        text: "",
      },
      img: [],
      status: false,
    };
  },
  methods: {
    deletedProduct: function () {
      if (!this.$cookies.get('user')) {
          $('#loginForm').modal('show')
          return
      }
      this.status = false;
      let x = this;
      axios
        .get("/api/details/" + this.id)
        .then((response) => {
          removeFile(response.data.data.thumbnail);
          console.log(response.data.data.thumbnail)
          let gallery = response.data.data.gallery;
          for (var i in gallery) {
            removeFile(gallery[i].url_image);
          }
        })
        .catch((error) => {
        });
      axios
        .delete(`api/product/delete/${this.id}`)
        .then(function (response) {
          $("#messageModal").modal("show");
          x.status = true;

        })
        .catch((errors) => {
          this.message.text="Xóa sản phẩm không thành công";
          $("#errorModal").modal("show");
          x.status = true;
        });
      setTimeout(() => {
        $("#messageModal").modal("hide");
        $("#errorModal").modal("hide");
        if (this.status) {
          this.$emit(
            "loadProducts",
          );
        }
      }, 1500);
      x.status = false;

    },
  },
};
</script>

<style scoped>

#overlay{
  z-index: 9999;
}
.btn{
  width: 30%;
  border-radius: 90px;
}
.btn.btn-outline-primary {
  border-color: black; 
  background-color: white; 
  color: black; 
}
.btn.btn-outline-primary:hover {
  border-color: black; 
  background-color: black; 
  color: white; 
}
</style>