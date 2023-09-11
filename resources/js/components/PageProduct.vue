<template>
  <div>
    <div class="container-fluid">
      <div class="form-group row">
        <div class="col-lg-3 shadow">
          <div class="form-group ">
            <h5 class="text-center font-weight-bold p-3 text-uppercase">
              <i class="fa fa-filter mr-2"></i>Bộ lọc
            </h5>
          </div>
          <!-- <div class="form-group">
                        <p  class="text-secondary font-weight-bold border-bottom"><i class="fa fa-venus-double mr-2"></i>Giới tính</p>
                        <div class="form-group" v-for="(gender, index) in genders" :key="index">
                            <label>
                                <input @change="fetchProduct()" type="radio" v-model="filter.gender" :value="gender.value" /> {{ gender.name }}
                            </label>
                        </div>
                    </div> -->
          <p class="text-secondary font-weight-bold border-bottom"><i class="fa fa-dollar mr-2"></i>Giá tiền</p>
          <div class="form-group d-flex text-nowrap align-items-center">
            <label class="mr-2" for="">Giá bắt đầu:</label>
            <input type="number" placeholder="nhập giá tiền..." class="form-control" v-model="filter.start_price" />
          </div>
          <div class="form-group d-flex text-nowrap align-items-center">
            <label class="mr-2" for="">Giá kết thúc:</label>
            <input type="number" placeholder="nhập giá tiền..." class="form-control" v-model="filter.end_price" />
          </div>
          <div class="form-group d-flex justify-content-between">

            <button class="btn btn-sm px-4 py-2 bg-white border rounded-pill" @click="resetFilter()">
              <i class="fa fa-refresh mr-2"></i>Làm mới
            </button>
            <button class="btn btn-sm px-4 py-2 bg-white border rounded-pill" @click="fetchProduct()">
              <i class="fa fa-search mr-2"></i>Tìm kiếm
            </button>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="form-group">
            <img class="img-banner" src="images/banner_w.jpg" />
          </div>
          <label class="font-italic text-secondary">Hiển thị {{ products.length }} kết quả </label>
          <div class="form-group">
            <div class="row">
              <div class="col-lg-3 mb-3" v-for="product in products" :key="product.id">
                <div class="card bg-white shadown-lg w-100 h-100 shadow border-0 mt-1">
                  <div class="card-header bg-transparent border-0">
                    <div v-for="(image, index) in product.images" v-if="index === 0">
                      <img :src="image.path" class="thumbnail-image" />
                    </div>
                    <h5 class="font-weight-bold text-center mt-2" style="letter-spacing:1px;">{{ product.name }}
                    </h5>
                    <p class="text-warning text-center">
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                    </p>
                    <p class="p-0 text-center text-secondary mb-5">Giá tiền: {{ product.price }} đ </p>
                  </div>
                  <div class="card-footer w-100 bg-white border-0 text-center" style="position: absolute;bottom: 0;">
                    <button @click="detailProduct(product.id)" class="btn btn-sm btn-danger py-2 px-4 rounded-pill"><i
                        class="fa fa-cart-plus mr-2"></i>Mua ngay</button>
                  </div>
                </div>
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
  data() {
    return {
      token: "",
      current_user: window.Laravel.current_user,
      loading: false,
      genders: [
        {
          value: 'male',
          name: "Nam"
        },
        {
          value: 'female',
          name: "Nữ"
        },
        {
          value: 'male-female',
          name: "Cặp đôi"
        }
      ],
      filter: {
        start_price: '',
        end_price: '',
        gender: ''
      },

      products: [],
      page_url_product: "/api/list-product-no-user"
    }
  },
  created() {
    this.token = "Bearer " + window.Laravel.access_token;
    this.fetchProduct();
  },
  methods: {
    fetchProduct() {
      this.loading = true;
      const params = new URLSearchParams({
        start_price: this.filter.start_price,
        end_price: this.filter.end_price,
        gender: this.filter.gender
      });
      var page_url = this.page_url_product + '?' + params.toString();
      fetch(page_url, {
        headers: {
          'Content-Type': 'application/json',

        }
      })
        .then(res => res.json())
        .then(data => {
          this.products = data.data;

        })
        .catch(err => {
          console.log(err);

        });
    },
    detailProduct(id) {
      window.location.href = "/product-detail" + '/' + id;
    },
    resetFilter() {
      this.filter.start_price = '';
      this.filter.end_price = '';
      this.filter.gender = '';
      this.fetchProduct();
    }
  }
}
</script>
<style lang="scss" scoped>
.thumbnail-image {
  width: 100%;
  height: 150px;
  object-fit: contain;
  /* Đảm bảo tỷ lệ khung hình được duy trì */
}

.img-banner {
  width: 100%;
  object-fit: cover;
  border-radius: 4px;
}
</style>