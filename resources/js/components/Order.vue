<template>
  <div>
    <div class="container">
      <div class="form-group">
        <label class="font-weight-bold text-uppercase">Đơn hàng</label>
      </div>
      <template v-if="orders.length === 0">
        <span class="d-flex justify-content-center">Không có dữ liệu</span>
      </template>
      <template v-else>
        <div class="form-group">
          <div class="form-group shadow p-4" v-for="(order, index) in orders" :key="index">
            <label class="font-weight-bold"> {{ index + 1 }}. </label>
            <div class="form-group row">
              <div class="col-lg-4">
                <div class="form-group" v-for="order_detail in order.order_details">
                  <div class="form-group d-flex align-items-center justify-content-around"
                    v-for="(image, index) in order_detail.product.images" v-if="index === 0">
                    <img class="mr-2" :src="'../' + image.path" width="100px" height="100px" style="object-fit:cover;" />
                    <div>
                      <p class="font-weight-bold">{{ order_detail.product.name }} </p>
                      <p class="text-muted mb-0">Đơn giá: {{ order_detail.price }} </p>
                      <p class="text-muted mb-0">Số lượng: {{ order_detail.quantity }} </p>
                      <p class="text-muted mb-0">Thành tiền: {{ order_detail.total_price }} </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-8">
                <p>Tên người đặt hàng: {{ current_user.name }} </p>
                <p>Email: {{ current_user.email }} </p>
                <p>Số điện thoại: {{ current_user.phone_number || '' }} </p>
                <p>Địa chỉ giao hàng: {{ order.shipping_address }} </p>
                <p>Phương thức thanh toán: {{ order.payment_method === 'cast' ? 'Tiền mặt' : 'Đã thanh toán' }} </p>
                <p><button class="btn btn-danger rounded-pill"> {{ order.status === 'pending' ? 'Đang xử lí' : 'Đã giao'
                }}
                  </button> </p>
              </div>
            </div>
            <div class="form-group text-right">
              <p class="font-weight-bold text-uppercase">Thanh toán:
                <span class="font-weight-bold text-danger"> {{ total_price(order) }} đ </span>
              </p>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      token: '',
      loading: false,
      errors: {},
      current_user: window.Laravel.current_user,
      check_order: false,
      orders: [],
      fields: [
        {
          key: 'index',
          label: 'STT',
          class: 'text-center text-nowrap',
        },
        {
          key: 'payment_method',
          label: 'Phương thức thanh toán',
          class: 'text-center text-nowrap',
        },
        {
          key: 'shipping_address',
          label: 'Địa chỉ giao hàng',
          class: 'text-nowrap',
        },
        {
          key: 'status',
          label: 'Trạng thái',
          class: 'text-center text-nowrap',
        },
        {
          key: 'action',
          label: '',
          class: 'text-center text-nowrap',
        }
      ],

      page_url_order: '/api/list-order',
    }
  },
  created() {
    this.token = "Bearer " + window.Laravel.access_token;
    this.fetchOrder();
  },
  methods: {
    fetchOrder() {
      var page_url = this.page_url_order;
      fetch(page_url, {
        method: "GET",
        headers: {
          'Content-Type': 'application/json',
          Authorization: this.token
        },
      })
        .then(res => res.json())
        .then(data => {
          this.orders = data.data;
        })
    },
    total_price(order) {
      var total_price = 0;
      order.order_details.forEach(order_detail => {
        total_price += parseFloat(order_detail.total_price);
      });
      return total_price.toFixed(2);
    },
  },
  computed: {

  },
}
</script>
<style lang="scss" scoped></style>