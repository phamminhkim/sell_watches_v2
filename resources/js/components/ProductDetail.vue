<template>
  <div class="main_detail">
    <div class="row">
      <div class="col-lg-4">
        <div class="form-group main_detail-img" v-for="(image, index) in product_details.images" :key="index">
          <img :src="'../' + image.path" width="100%" height="100%" />
        </div>
      </div>
      <div class="col-lg-8">
        <span class="main_detail-label">
          {{ product_details.name }}
        </span>
        <div class="main_detail-rating">
          <div class="rating">
            <span class="total-rate">
              5.0
            </span>
            <i class="fa fa-star text-warning mx-1" v-for="i in 5"></i>
          </div>
        </div>
        <div class="main_detail-price">
          <template>
            <span class="price-old">
              {{ `đ ${product_details.price}` }}
            </span>
          </template>
          <template>
            <span>
              {{ `đ ${product_details.price}` }}
            </span>
          </template>
        </div>
        <div class="main_detail-info">
          <div class="info-list">
            <!-- <div class="info-item row">
              <div class="info-label col-lg-2">
                Mã Giảm Giá Của Shop
              </div>
              <div class="info-content col-lg-10">
                <span>voucher-1</span>
                <span>voucher-2</span>
                <span>voucher-3</span>
              </div>
            </div> -->
            <div class="info-item row mb-4">
              <div class="info-label col-lg-2">
                Vận chuyển
              </div>
              <div class="info-content d-flex flex-column col-lg-10">
                <div class="d-flex">
                  <span class="mr-4"><i class="fa fa-truck mr-2"></i>Vận chuyển tới</span>
                  <span>Bình Tân</span>
                </div>
                <div class="d-flex">
                  <span class="mr-5">
                    Phí vận chuyển
                  </span>
                  <span>
                    Không hỗ trợ
                  </span>
                </div>
              </div>
            </div>
            <div class="info-item row mb-4">
              <div class="info-label col-lg-2">
                Màu sắc
              </div>
              <div class="info-content col-lg-10">
                <span class="mr-3 border py-2 px-4">Đỏ</span>
                <span class="mr-3 border py-2 px-4">Đen</span>
                <span class="mr-3 border py-2 px-4">Xám</span>
              </div>
            </div>
            <div class="info-item row mb-4">
              <div class="info-label col-lg-2">
                Số lượng
              </div>
              <div class="info-content col-lg-10">
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="btn border">-</button>
                  <input style="width: 50px; text-align: center;" class="border" />
                  <button type="button" class="btn border">+</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="main_detail-btn row">
          <div class="add-cart-btn mx-3">
            <button type="button" class="btn">Thêm vào giỏ hàng</button>
          </div>
          <div class="buy-now-btn">
            <button type="button" class="btn">Mua ngay</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    id: Number,
  },
  data() {
    return {

      page_url_product: "/api/product-detail",
      product_details: {},
    }
  },
  created() {
    this.fetchProductDetail();
  },
  methods: {
    fetchProductDetail() {
      var page_url = this.page_url_product + "/" + this.id;
      fetch(page_url, {
        headers: {
          'Content-Type': 'application/json',

        }
      })
        .then(res => res.json())
        .then(data => {
          this.product_details = data.data;

        })
        .catch(err => {
          console.log(err);

        });
    },
  },

}
</script>