<template>
  <div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group d-flex justify-content-between">
            <h5 class="font-weight-bold text-uppercase"><i class="fa fa-th-list mr-2"></i> Quản lí đơn hàng
            </h5>
            <!-- <button @click="showProduct()" class="btn btn-sm btn-info"><i class="fa fa-plus mr-2"></i>Tạo
              mới</button> -->
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">

        </div>
        <div class="col-lg-6">
          <div class="input-group mb-1">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"> <i class="fa fa-search"></i> </span>
            </div>
            <input v-model="filter" type="text" class="form-control form-control-sm" placeholder="Tìm  kiếm...">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="bg-white p-3">
            <b-table responsive="sm" striped hover small :bordered="true" :items="orders" :fields="fields"
              :filter="filter" :current-page="current_page" :per-page="per_page">
              <template #cell(index)="data">
                {{ data.index + 1 }}
              </template>
              
              <template #cell(user_id)="data">
                <span v-if="data.item.user_id" > {{ data.item.user.name }} </span>
              </template>
              <template #cell(email)="data">
                <span v-if="data.item.user_id" > {{ data.item.user.email }} </span>
              </template>
              <template #cell(phone_number)="data">
                <span v-if="data.item.user_id" > {{ data.item.user.phone_number }} </span>
              </template>
              <template #cell(status)="data">
                <span v-if="data.item.status == 'pending'" class="badge badge-secondary" > Chờ xử lý </span>
                <span v-if="data.item.status == 'processing'" class="badge badge-info" > Đã xác nhận </span>
                <span class="badge badge-success" v-if="data.item.status == 'completed'"> Đã thanh toán</span>
                <button  v-if="data.item.status == 'pending'" @click="updateStatus(data.item.id)" class="btn btn-sm badge badge-warning"> Xác nhận </button>
              </template>
              <template #cell(payment_method)="data">
                <span v-if="data.item.payment_method == 'cast'" class="badge badge-secondary"> Tiền mặt</span>
              </template>
              <template #cell(product)="data">
                <button @click="showModalProdcut(data.item.order_details)" class="btn btn-sm btn-info">Xem sản phẩm đã đặt</button>
              </template>
              
              <!-- <template #cell(action)="data">
                <button @click="editProduct(data.item)" class="btn btn-sm btn-info"><i
                    class="fa fa-edit mr-1 mt-1"></i>Sửa</button>
                <button @click="deleteProduct(data.item.id)" class="btn btn-sm btn-danger"><i
                    class="fa fa-minus mr-1 mt-1"></i>Xóa</button>
              </template> -->
            </b-table>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-form-label-sm col-md-4" style="text-align: left" for="">Per
                    page:</label>
                  <div class="col-md-3">
                    <b-form-select size="sm" v-model="per_page" :options="pageOptions"></b-form-select>
                  </div>
                  <label class="col-form-label-sm col-md-1" style="text-align: left" for=""></label>
                  <div class="col-md-3">
                    <b-pagination v-model="current_page" :total-rows="rows" :per-page="per_page" align="fill" size="sm"
                      class="my-0"></b-pagination>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="product" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Xem chi tiết</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <b-table :items="order_details" :fields="field_orders" responsive small>
                  <template #cell(index)="data">
                    <span> {{ data.index + 1 }} </span>
                  </template>
                  <template #cell(name)="data">
                    <span v-if="data.item.product_id">
                      {{ data.item.product.name }}
                    </span>
                  </template>
                </b-table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
      edit: false,
      loading: false,
      errors: {},
      order_details: [],
      fields: [
        {
          key: 'index',
          label: 'STT',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'user_id',
          label: 'Người đặt hàng',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'email',
          label: 'Email',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'phone_number',
          label: 'Số điện thoại',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'order_date',
          label: 'Ngày đặt hàng',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'payment_method',
          label: 'Phương thức thanh toán',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'status',
          label: 'Trạng thái',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'product',
          label: 'Sản phẩm',
          class: "text-nowrap",
          sortable: true,
        },
         {
          key: 'shipping_address',
          label: 'Địa chỉ nhận hàng',
          class: "text-nowrap",
          sortable: true,
        },
       
      ],
      field_orders: [
        {
          key: 'index',
          label: 'STT',
        },
        {
          key: 'name',
          label: 'Tên sản phẩm',
        },
        {
          key: 'price',
          label: 'Giá',
        },
        {
          key: 'quantity',
          label: 'Số lượng',
        },
        {
          key: 'total_price',
          label: 'Tổng tiền',
        },
      ],
      orders: [],
      order: {
        id: "",
        code: "",
        name: "",
        price: "",
        quantity: "",
        category_id: "",
        color_id: "",
        brand_id: "",
        gender: "",
        origin: "",
        function: "",
        image_path: "",
        note: "",
        images: [],
        image_dels: [],
      },
      filter: "",
      total: 0,
      per_page: 10,
      from: 1,
      to: 0,
      current_page: 1,

      pageOptions: [10, 50, 100, 500, { value: this.rows, text: "All" }],
      brands: [],
      categories: [],
      colors: [],
      page_url_product: "/api/list-order",
      page_url_product_store: "/api/list-product-store",
      page_url_product_update: "/api/list-product-update",
      page_url_product_delete: "/api/list-product-delete",
      page_url_brand: "/api/list-brand",
      page_url_category: "/api/list-category",
      page_url_color: "/api/list-color",

      page_url_processing: "/api/processing",


    }
  },
  created() {
    this.token = "Bearer " + window.Laravel.access_token;
    this.fetchProduct();
    this.fetchBrand();
    this.fetchCategory();
    this.fetchColor();
  },
  methods: {
    fetchProduct() {
      var page_url = this.page_url_product;
      fetch(page_url, {
        headers: {
          'Content-Type': 'application/json',
          Authorization: this.token
        }
      })
        .then(res => res.json())
        .then(data => {
          this.orders = data.data;
        })
        .catch(err => {
          console.log(err);

        });
    },
    fetchBrand() {
      var page_url = this.page_url_brand;
      fetch(page_url, {
        headers: {
          'Content-Type': 'application/json',
          Authorization: this.token
        }
      })
        .then(res => res.json())
        .then(data => {
          this.brands = data.data;
        })
        .catch(err => {
          console.log(err);

        });
    },
    fetchCategory() {
      var page_url = this.page_url_category;
      fetch(page_url, {
        headers: {
          'Content-Type': 'application/json',
          Authorization: this.token
        }
      })
        .then(res => res.json())
        .then(data => {
          this.categories = data.data;
        })
        .catch(err => {
          console.log(err);

        });
    },
    fetchColor() {
      var page_url = this.page_url_color;
      fetch(page_url, {
        headers: {
          'Content-Type': 'application/json',
          Authorization: this.token
        }
      })
        .then(res => res.json())
        .then(data => {
          this.colors = data.data;
        })
        .catch(err => {
          console.log(err);

        });
    },
    updateStatus(id){
      var page_url = this.page_url_processing + "/" + id;
      fetch(page_url, {
        method: "PATCH",
        headers: {
          'Content-Type': 'application/json',
          Authorization: this.token
        },
      })
        .then(res => res.json())
        .then(data => {
          if (data.data.success == 1) {
            this.fetchProduct();
            this.$bvToast.toast(`Cập nhật thành công`, {
              title: 'Thông báo',
              variant: 'success',
              solid: true
            })
          } else {
            this.$bvToast.toast(`Cập nhật thất bại`, {
              title: 'Thông báo',
              variant: 'danger',
              solid: true
            })
          }
        })
        .catch(err => {
          console.log(err);

        });
    },
  
    showModalProdcut(item) {
      console.log(item);
      this.order_details = item;
      $("#product").modal("show");
    },
    hasError(fieldName) {
      return fieldName in this.errors;
    },
    getError(fieldName) {
      //console.log(fieldName+"="+ this.errors[fieldName][0]);
      return this.errors[fieldName][0];

    },
    clearError(event) {
      Vue.delete(this.errors, event.target.name);
      //  console.log(event.target.name);
    },
    reset() {
      this.order.id = "";
      this.order.code = "";
      this.order.name = "";
      this.order.note = "";
      this.errors = {};
    },
    deleteProduct(id) {
      var page_url = this.page_url_product_delete + "/" + id;
      fetch(page_url, {
        method: "DELETE",
        headers: {
          'Content-Type': 'application/json',
          Authorization: this.token
        },
      })
        .then(res => res.json())
        .then(data => {
          if (data.data.success == 1) {
            this.fetchProduct();
            this.$bvToast.toast(`Xóa thành công`, {
              title: 'Thông báo',
              variant: 'success',
              solid: true
            })
          } else {
            this.$bvToast.toast(`Xóa thất bại`, {
              title: 'Thông báo',
              variant: 'danger',
              solid: true
            })
          }
        })
        .catch(err => {
          console.log(err);

        });
    },
    handleFileUploadImage(event) {
      const files = event.target.files; // Lấy danh sách tệp đã chọn
      // Lặp qua từng tệp và thêm vào mảng images
      for (let i = 0; i < files.length; i++) {
        const file = files[i];

        let reader = new FileReader();
        reader.readAsDataURL(file);

        // Thêm tệp vào mảng images
        reader.onload = () => {
          const imageURL = reader.result; // Đường dẫn base64 của ảnh

          // Thêm tệp và đường dẫn vào mảng images
          this.product.images.push({
            file: file,
            name: file.name,
            path: imageURL
          });
        };
      }
    },
    deleteImage(index, item) {
      this.product.images.splice(index, 1);
      this.product.image_dels.push(item);
    },

  },
  computed: {
    rows() {
      return this.orders.length;
    }
  }
}
</script>
<style lang="scss" scoped>
.img-ralative {
  position: relative;
  width: 100%;
  height: 100%;

}

.img-remove {
  position: absolute;
  right: 0;
  z-index: 1;
  color: white;

}
</style>