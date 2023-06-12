  <template>
  <div
    class="input-group search-box"
    style="background: white; border-radius: 5px"
  >
    <button>
      <font-awesome-icon icon="magnifying-glass" class="search-icon" />
    </button>
    <input
      @keypress="validateKey"
      v-model="keyword"
      name="search"
      type="text"
      placeholder="Search..."
      class="form-control search-bar"
      style="border: none"
    />
  </div>
</template>
  <script>
export default {
  props: ["roleAdmin","save_keyword"],
  data() {
    return {
      routeName: "",
      keyword: "",
    };
  },
  created() {
    this.keyword = this.save_keyword;
    this.$emit("fill-search-event", {
        message: '',
      });
  },
  watch: {
    keyword: function (keyword) {
      this.$emit("fill-search-event", {
        message: keyword,
      });
    },
  },
  methods: {
    validateKey(event) {
      var regex = new RegExp("^[0-9a-zA-Z \b]+$");
      var key = String.fromCharCode(
        !event.charCode ? event.which : event.charCode
      );
      if (!regex.test(key)) {
        event.preventDefault();
      }
    },
  },
};
</script>
  <style>
.search-box button {
  border: none;
  background: transparent;
  margin-left: 20px;
  padding: 1px;
}

.search-box{
  max-width: 500px;
}

.search-bar:focus {
  box-shadow: none;
}

.search-icon {
  font-size: 20px;
}
</style>