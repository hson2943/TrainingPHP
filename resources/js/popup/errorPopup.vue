<template>
    <div class="modal" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="errorModal" :aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-end">
                            <button class="d-flex justify-content-center p-0 border-0 rounded-circle close-pupup"
                                style="width:fit-content">
                                <img src="/image_svg/iconClose.svg" data-bs-dismiss="modal" alt="">
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center">
                                <img :src="'https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/logos%2FiconDelete.png?alt=media&token=ee7473a9-185c-4613-8b51-f930201e528b'" alt="" width="200"
                  height="200">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p v-if="this.message.text" class="text-center fw-bold message-popup">{{ this.message.text }} !!!</p>
                                <p v-else class="text-center fw-bold message-popup">Có lỗi xảy ra !!!</p>
                            </div>
                            <button class="btn btn-primary" @click="exitModal">Hủy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['message'],
    
    methods:{
       exitModal(){
            $("#errorModal").modal("hide");
    },
    }
}
</script>
<style scoped>
.modal{
    z-index: 9999;
}
</style>