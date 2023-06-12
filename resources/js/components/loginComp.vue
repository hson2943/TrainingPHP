<template>
    <div class="modal fade" id="loginForm" tabindex="-1" data-bs-backdrop="static" :data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginFormLabel">Đăng Nhập</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        @click="cancelLoginModal()"></button>
                </div>
                <spinner :active="activeSpinner" />
                <div class="modal-body">
                    <form>
                        <div class="mb-1">
                            <label for="email" class="col-form-label" style="width: 100%;">Email người dùng
                                <span class="text-danger"> *</span>
                            </label>
                            <input type="text" class="form-control" name="email" id="email" v-model="user.email">
                            <span class="text-danger error">{{ errors?.email?.at(0) }}</span>
                        </div>
                        <div class="mb-1">
                            <label for="password" class="col-form-label">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" v-model="user.password"
                                autocomplete="on">
                            <span class="text-danger error">{{ errors?.password?.at(0) }}</span>
                            <span class="text-danger error" style="height: 20px; margin-bottom: 0">
                                {{ errorNotFound }}
                            </span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-evenly">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        @click="cancelLoginModal()">Huỷ</button>
                    <button type="button" class="btn btn-primary" @click="login">Đăng Nhập</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Auth from '../Auth.js';
export default {
    data() {
        return {
            user: {
                email: '',
                password: '',
            },
            errors: [],
            errorNotFound: '',
            activeSpinner: false,
        }
    },
    methods: {
        login() {
            this.activeSpinner = true
            axios.post('http://127.0.0.1:8000/api/login', this.user)
                .then(({ data }) => {
                    if (data.status) {
                        Auth.login(data.status.token, data.status.name);
                        $('#loginForm').modal('hide')
                        this.$emit('login', data.status.name)
                        this.errorNotFound = '';
                        this.errors = ''
                        this.$toast.success('Đăng nhập thành công!', {
                            position: "bottom-right",
                            duration: 3000,
                        });
                    } else {
                        this.errorNotFound = data.message;
                        this.errors = ''
                    }
                    this.activeSpinner = false

                }).catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors
                        console.log(error.response.data.errors)
                        this.activeSpinner = false
                        this.errorNotFound = ''
                    } else {
                        this.activeSpinner = false
                        console.log(error.response.data.message)
                        this.errorNotFound = error.response.data.message
                        this.errors = []
                    }

                });
        },
        cancelLoginModal() {
            if (this.$route.name != 'all-products' && this.$route.name != 'home') {
                window.location.reload()
            }
        }
    }
}
</script>