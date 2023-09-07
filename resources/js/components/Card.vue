<template>
  <div>
    <div class="form-group container">
      <b-table :items="cards" :fields="fields" responsive hover>
        <template #cell(selected)="data">
          <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
            <input type="checkbox" v-model="selecteds" :value="data.item.id" />
          </div>
        </template>
        <template #head(product_id)="label">
          <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
            <span class="text-secondary"> {{ label.label }} </span>
          </div>
        </template>
        <template #head(index)="label">
          <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
            <span class="text-secondary"> {{ label.label }} </span>
          </div>
        </template>
        <template #head(quantity)="label">
          <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
            <span class="text-secondary"> {{ label.label }} </span>
          </div>
        </template>
        <template #head(total_price)="label">
          <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
            <span class="text-secondary"> {{ label.label }} </span>
          </div>
        </template>
        <template #cell(product_id)="data">
          <div class="d-flex align-items-baseline justify-content-center" v-if="data.item.product_id">
            <div class="float-left mr-2" v-if="data.item.product.images.length > 0"
              v-for="image in data.item.product.images">
              <img :src="image.path" class="thumbnail-image " />
            </div>
            {{ data.item.product.name }}
          </div>
        </template>
        <template #cell(action)="data">
          <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
            <button class="btn btn-sm btn-danger" @click="deleteCard(data.item.id)"><i
                class="fa fa-trash mr-2"></i>Xóa</button>
          </div>
        </template>
      </b-table>
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
        },
        {
          key: 'product_id',
          label: 'Sản phẩm',
        },
        {
          key: 'quantity',
          label: 'Số lượng',
        },
        {
          key: 'total_price',
          label: 'Tổng tiền',
        },
        {
          key: 'action',
          label: '',
        },
      ],

      page_url_card: '/api/list-card',
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
</style>