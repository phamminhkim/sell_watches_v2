<template>
  <div class="main-select">
    <div class="form-group container">
      <div class="order-input mb-5">
        <h4>Thông tin đặt hàng</h4>
        <div class="order-list px-3">
          <!-- <div class="order-item row">
            <span class="col-lg-3">
              Người đặt hàng:
            </span>
            <span class="col-lg-9">
              <input class="form-control" type="text" height="100%">
            </span>
          </div> -->
          <div class="order-item row">
            <span class="col-lg-3">
              Địa chỉ:
            </span>
            <span class="col-lg-9">
              <input class="form-control" type="text" height="100%" :value="address">
            </span>
          </div>
          <div class="order-item row">
            <span class="col-lg-3">
              Phương thức thanh toán
            </span>
            <span class="col-lg-9">
              <select class="form-control">
                <option>Thanh toán khi nhận hàng</option>
                <option>Thanh toán qua ZaloPay</option>
              </select>
            </span>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table hover border-0">
          <thead>
            <tr style="font-weight: 600; background: rgba(116, 155, 194, .15);">
              <td>Hình ảnh</td>
              <td>Sản phẩm</td>
              <td>Đơn giá</td>
              <td>Số lượng</td>
              <td>Thành tiền</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(buy, index) in buy_selecteds" :key="index"
              :style="{ background: index % 2 !== 0 ? 'rgba(238, 238, 238, .35)' : 'rgba(240, 240, 240, .75)' }">
              <td v-if="buy.product_id" class=" d-flex justify-content-center">
                <div class="thumbnail-image" v-if="buy.product.images.length > 0" v-for="image in buy.product.images">
                  <img :src="'../' + image.path" width="100%" height="100%" />
                </div>
              </td>
              <td v-if="buy.product_id"> {{ buy.product.name }} </td>
              <td v-if="buy.product_id"> {{ buy.product.price }} </td>
              <td> {{ buy.quantity }} </td>
              <td class="text-danger font-italic" style="font-size: 1rem;"> {{ buy.total_price }} đ</td>
            </tr>
            <!-- <tr style="background: rgba(116, 155, 194, .15);">
            <td></td>
            <td></td>
            <td></td>
            <td></td> 
            <td class="font-weight-light font-italic txt-total" style="color: gray; font-size: .9rem;">Tổng số
              tiền ({{
                buy_selecteds.length }} sản
              phẩm):
              <span class="text-danger font-weight-bold" style="font-size: 1rem;"> {{ total_price }} đ </span>
            </td>
          </tr> -->
          </tbody>
        </table>
      </div>
      <div class="form-group">
        <span class="font-weight-light font-italic txt-total" style="color: gray; font-size: .9rem;">Tổng số
          tiền ({{
            buy_selecteds.length }} sản
          phẩm):
          <span class="text-danger font-weight-bold" style="font-size: 1rem;"> {{ total_price }} đ </span>
        </span>
        <button class="btn btn-warning py-2 px-4 font-weight-bold float-right" style="color: white;">Đặt hàng</button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    buy_selecteds: Array
  },
  data() {
    return {
      address: 'Lô 6, 8, 10 ,12 KCN Tân Tạo A, Bình Tân, TP.Hồ Chí Minh'
    }
  },
  methods: {

  },
  computed: {
    total_price() {
      var total_price = 0;
      this.buy_selecteds.forEach(item => {
        total_price += item.total_price;
      });
      return total_price;
    }
  }
}
</script>

<style lang="scss" scoped>
.thumbnail-image {
  width: 200px;
  max-height: 150px;
  object-fit: contain;
}

td {
  text-align: center;
  border: 0px
}

.order-item {
  min-height: 40px;
  line-height: 40px;
  margin-bottom: 15px;
}

.main-select {
  padding: 25px 0px;
  background: rgba(221, 230, 237, .25);
  border-radius: 10px;
  box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
}

.txt-total {
  line-height: 45px;

  @media screen and (max-width: 767px) {
    font-size: .65rem !important;

    span {
      font-size: .85rem !important;
    }
  }
}
</style>