<template>
  <div class="container-fuild text-uppercase" style="overflow: hidden">
    <div
      class="row text-white"
      style="background-color: #00ade8; height: 64px; align-items: center"
    >
      <div
        class="col-2 d-flex align-items-center justify-content-center justify-content-center"
      >
      <router-link :to="{ path: '/' }">
  <img
    width="110"
    class="img-fluid"
    src="https://firebasestorage.googleapis.com/v0/b/database-image-8cf4e.appspot.com/o/logos%2F1573728209486-imgpsh_fullsize_anim.png?alt=media&token=0bc22e3f-fd1a-417b-b86b-f8c471578616"
  />
</router-link>
      </div>
      <div
        class="col-1 d-sm-flex justify-content-end justify-content-center align-items-center"
        style="text-decoration: none"
      >
        <a class= "item-header" @click="changeRole(false) " :class="{ 'active': isActive }">
          Sản Phẩm
        </a>
      </div>
      <div v-if="user" class="col-2 d-sm-flex">
        <a  class=" item-header" @click="changeRole(true)" :class="{ 'active': isActiveAdmin }">Quản lý sản phẩm</a>
      </div>

      <div
        class="col-2 d-sm-flex justify-content-end justify-content-center align-items-center"
        style="position: absolute; right: 0"
      >
        <div class="dropdown" v-if="user">
          <a
            class="item-header dropdown-toggle"
            href="#"
            role="button"
            data-bs-toggle="dropdown"
            style="background: none; border: none"
            aria-expanded="false"
          >
            {{ user }}
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" @click="logout">Đăng xuất</a></li>
          </ul>
        </div>
        <a class="item-header" data-bs-toggle="modal" data-bs-target="#loginForm" v-else>Đăng nhập</a
        >
      </div>
    </div>
  </div>
  <login-form @login="user = $event" />
</template>

<script>
import Auth from "../Auth.js"
export default {
  props: ["roleAdmin"],
  emits: ["changeRole"],
  data() {
    return {
      user: '',
      token: '',
      isActive:true,
      isActiveAdmin:false,
    };
  },
  mounted() {
    if(this.$cookies.get("user")=='undefined'){
      this.user =false
    }else{
      this.user =this.$cookies.get("user")
    }
  },
  methods: {
    changeRole(roleAmin) {
      this.user = this.$cookies.get('user');
      if (roleAmin && !this.user) {
                $('#loginForm').modal('show')
            }else{
              this.isActive=true;
              this.isActiveAdmin=false
              this.$router.push({
        name: 'all-products',
      });
      if(!roleAmin){
        this.isActive=true;
              this.isActiveAdmin=false
      }else{
        this.isActive=false;
              this.isActiveAdmin=true
      }
      this.$emit('changeRole', roleAmin)
            }
    
    },
    logout() {
      axios
        .post("http://127.0.0.1:8000/api/logout", Auth)
        .then(({ data }) => {
          Auth.logout();
          this.$router.push({
            path: "/",
            query: {
              category: this.$route.query.category,
              brand: this.$route.query.brand,
              key: this.$route.query.key,
            },
          });
          this.user = null;
          this.$toast.error("Đăng xuất thành công!", {
            position: "bottom-right",
            duration: 3000,
          });
        })
        .catch((error) => {
          window.location.reload();
        });
    },
    
  },
};
</script>

<style scoped>
.activeLink {
  font-weight: 700;
  opacity: 1 !important;
}

a.item-header {
  color: white;
  opacity: 0.75;
  text-decoration: none;
}
a.item-header:hover,
.item-header.active {
  color: white;
  font-weight: 700;
  font-size: large;
}
a.item-header:active {
  color: black;
  font-weight: 700;
  font-size: large;
}
.dropdown-item{
  text-align: center;
}
</style>