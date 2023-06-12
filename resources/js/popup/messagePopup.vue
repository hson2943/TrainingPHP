<template>
  <div
    class="modal "
    id="messageModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="messageModal"
    :aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row d-flex justify-content-end">
              <button
                class="d-flex justify-content-center p-0 border-0 rounded-circle close-pupup"
                style="width: fit-content"
              >
                <img
                  src="/image_svg/iconClose.svg"
                  data-bs-dismiss="modal"
                  alt=""
                />
              </button>
            </div>
            <div class="row">
              <div class="col-md-12 d-flex justify-content-center">
                <img
                  :src="getMessage.icon"
                  alt=""
                  v-if="getMessage.icon"
                  width="200"
                  height="200"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <p class="text-center fw-bold message-popup">
                  {{ getMessage.content }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["message", "action"],
  data() {
    return {
      alert: {
        content: "",
        icon: "",
      },
    };
  },
  computed: {
    getMessage() {
      if (this.action == "edit") {
        this.alert.content = "Cập nhật sản phẩm thành công!";
        this.alert.icon =
          "https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/logos%2Fcreate_update.png?alt=media&token=564a7085-05f2-4e97-95df-514829d9271a";
      } else if (this.action == "delete1") {
        this.alert.content = "Xoá sản phẩm thành công!";
        this.alert.icon =
          "https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/logos%2FiconDelete.png?alt=media&token=ee7473a9-185c-4613-8b51-f930201e528b";
      }else {
        this.alert.content = "Thêm thành công!";
        this.alert.icon =
          "https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/logos%2Fcreate_update.png?alt=media&token=564a7085-05f2-4e97-95df-514829d9271a";
      }
      return this.alert;
    },
  },
};
</script>