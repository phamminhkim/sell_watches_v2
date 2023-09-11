<template>
  <div>
    <div class="form-group container">
      <b-table :items="cards" :fields="fields" responsive hover>
        <template #cell(selected)="data">
          <div class="b-table">
            <input type="checkbox" v-model="selecteds" :value="data.item" style="transform:scale(2.1)" />
          </div>
        </template>
        <template #head(product_id)="label">
          <div class="b-table" style="height: auto;">
            <span class="text-secondary"> {{ label.label }} </span>
          </div>
        </template>
        <template #head(index)="label">
          <div class="b-table" style="height: auto;">
            <span class="text-secondary"> {{ label.label }} </span>
          </div>
        </template>
        <template #head(price)="label">
          <div class="b-table" style="height: auto;">
            <span class="text-secondary"> {{ label.label }} </span>
          </div>
        </template>
        <template #cell(price)="data">
          <div class="b-table">
            <span v-if="data.item.product_id">
              đ {{ data.item.product.price }}
            </span>
          </div>
        </template>
        <template #cell(quantity)="data">
          <div class="b-table">
            <span v-if="data.item.product_id">
              <button @click="reduceQuantityShoppingCart(data.item.id)" type="button" class="btn btn-sm btn-outline-info">
                <i class="fa fa-minus"></i>
              </button>
              {{ data.item.quantity }}
              <button @click="increasingQuantityShoppingCart(data.item.id)" type="button"
                class="btn btn-sm btn-outline-info">
                <i class="fa fa-plus"></i>
              </button>
            </span>
          </div>
        </template>
        <template #head(quantity)="label">
          <div class="b-table" style="height: auto;">
            <span class="text-secondary"> {{ label.label }} </span>
          </div>
        </template>

        <template #cell(total_price)="data">
          <div class="b-table">
            <span v-if="data.item.product_id">
              đ {{ data.item.total_price }}
            </span>
          </div>
        </template>
        <template #head(total_price)="label">
          <div class="b-table" style="height: auto;">
            <span class="text-secondary"> {{ label.label }} </span>
          </div>
        </template>

        <template #cell(product_id)="data">
          <div class="d-flex flex-column align-items-center justify-content-center" style="height: 150px;"
            v-if="data.item.product_id">
            <div class="float-left mr-2 thumbnail-image" v-if="data.item.product.images.length > 0 && index === 0"
              v-for="(image, index) in data.item.product.images" :key="index">
              <img :src="image.path" width="100%" height="100%" />
            </div>
            <span class="mt-2" style="font-size: 1rem; font-weight: 400;">{{ data.item.product.name }}</span>
          </div>
        </template>
        <template #cell(action)="data">
          <div class="b-table">
            <button class="btn btn-sm btn-danger" @click="deleteCard(data.item.id)"><i
                class="fa fa-trash mr-2"></i>Xóa</button>
          </div>
        </template>
      </b-table>
    </div>
    <div class="form-group footer">
      <div class="float-left">
        <button class="btn btn-sm btn-danger" @click="deleteSelecteds()"><i class="fa fa-trash mr-2"></i>Xóa</button>
      </div>
      <div class="float-right buy-txt">
        <label class="text-secondary text-uppercase">Tổng thanh toán ({{ selecteds.length }} sản phẩm): {{ total_price }}
          đ</label>
        <button class="btn btn-sm btn-primary" @click="buySelecteds()"
          :disabled="selecteds.length === 0 ? true : false"><i class="fa fa-shopping-cart mr-2"></i>Mua</button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      token: '',
      cards: [],
      selecteds: [],
      fields: [
        {
          key: 'selected',
          label: 'Chọn',
          class: 'text-center text-nowrap',
        },
        {
          key: 'product_id',
          label: 'Sản phẩm',
          class: 'text-center text-nowrap',

        },
        {
          key: 'price',
          label: 'Đơn giá',
          class: 'text-center text-nowrap',

        },
        {
          key: 'quantity',
          label: 'Số lượng',
          class: 'text-center text-nowrap',

        },
        {
          key: 'total_price',
          label: 'Tổng tiền',
          class: 'text-center text-nowrap',

        },
        {
          key: 'action',
          label: '',
          class: 'text-center text-nowrap',

        },
      ],

      page_url_card: '/api/list-card',
      page_url_delete_card: '/api/delete-card',
      page_url_increasing_quantity_shopping_cart: '/api/increasing-quantity-shopping',
      page_url_reduce_quantity_shopping_cart: '/api/reduce-quantity-shopping',

    }
  },
  created() {
    this.token = "Bearer " + window.Laravel.access_token;
    this.fetchCard();
  },
  methods: {
    fetchCard() {
      var page_url = this.page_url_card;
      fetch(page_url, {
        headers: {
          'Content-Type': 'application/json',
          Authorization: this.token
        }
      })
        .then(res => res.json())
        .then(data => {
          this.cards = data.data;
        })
        .catch(err => {
          console.log(err);

        });
    },
    buySelecteds() {
      const formData = new FormData();
      formData.append('selecteds', JSON.stringify(this.selecteds));
      var params = new URLSearchParams(formData);
      window.location.href = '/card/buy-selecteds' + '?' + params.toString();
    },
    deleteSelecteds() {
      this.selecteds = [];
    },
    deleteCard(id) {
      var page_url = this.page_url_delete_card + '/' + id;
      fetch(page_url, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          Authorization: this.token
        }
      })
        .then(res => res.json())
        .then(data => {
          console.log(data);
          if (data.data.success == 1) {
            // this.$bvToast.toast(`Xóa thành công`, {
            //   title: 'Thông báo',
            //   variant: 'success',
            //   solid: true
            // })
            this.fetchCard();
          } else {
            // this.$bvToast.toast(`Xóa thất bại`, {
            //   title: 'Thông báo',
            //   variant: 'danger',
            //   solid: true
            // })
          }
        })
        .catch(err => {
          console.log(err);
        });
    },
    increasingQuantityShoppingCart(id) {
      var page_url = this.page_url_increasing_quantity_shopping_cart + '/' + id;
      fetch(page_url, {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          Authorization: this.token
        }
      })
        .then(res => res.json())
        .then(data => {
          if (data.data.success == 1) {
            // this.$bvToast.toast(`Cập nhật thành công`, {
            //   title: 'Thông báo',
            //   variant: 'success',
            //   solid: true
            // })
            this.fetchCard();
            this.selecteds = [];

          } else {
            // this.$bvToast.toast(`Cập nhật thất bại`, {
            //   title: 'Thông báo',
            //   variant: 'danger',
            //   solid: true
            // })
            this.selecteds = [];

          }
        })
        .catch(err => {
          console.log(err);
        });
    },
    reduceQuantityShoppingCart(id) {
      var page_url = this.page_url_reduce_quantity_shopping_cart + '/' + id;
      fetch(page_url, {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          Authorization: this.token
        }
      })
        .then(res => res.json())
        .then(data => {
          if (data.data.success == 1) {
            // this.$bvToast.toast(`Cập nhật thành công`, {
            //   title: 'Thông báo',
            //   variant: 'success',
            //   solid: true
            // })
            this.fetchCard();
            this.selecteds = [];
          } else {
            // this.$bvToast.toast(`Cập nhật thất bại`, {
            //   title: 'Thông báo',
            //   variant: 'danger',
            //   solid: true
            // })
            this.selecteds = [];

          }
        })
        .catch(err => {
          console.log(err);
        });
    },
  },
  computed: {
    total_price() {
      var total_price = 0;
      this.selecteds.forEach(item => {
        total_price += item.total_price;
      });
      return total_price;
    },

  }
}

</script>
<style lang="scss" scoped>
.thumbnail-image {
  width: 200px;
  max-height: 150px;
  object-fit: contain;
  /* Đảm bảo tỷ lệ khung hình được duy trì */
}

.b-table {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 150px;
}

.footer {
  position: fixed;
  bottom: 0;
  width: 98%;
  padding: 10px;
  background-color: #fff;

  @media screen and (max-width: 1023px) {
    float: left;

    .buy-txt {
      label {
        display: block;
        font-size: .75rem;
        font-style: italic;
      }

      button {
        float: right;
      }
    }
  }
}
</style>
