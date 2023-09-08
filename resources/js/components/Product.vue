<template>
  <div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group d-flex justify-content-between">
            <h5 class="font-weight-bold text-uppercase"><i class="fa fa-th-list mr-2"></i> Danh sách sản phẩm
            </h5>
            <button @click="showProduct()" class="btn btn-sm btn-info"><i class="fa fa-plus mr-2"></i>Tạo
              mới</button>
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
            <b-table responsive="sm" striped hover small :bordered="true" :items="products" :fields="fields"
              :filter="filter" :current-page="current_page" :per-page="per_page">
              <template #cell(index)="data">
                {{ data.index + 1 }}
              </template>
              <template #cell(name)="data">
                <span v-if="data.item.images.length > 0">
                  <b-avatar :src="data.item.images[0].path" alt="Ảnh sản phẩm" loading="lazy"> </b-avatar>
                </span>
                <span>{{ data.item.name }} </span>
              </template>
              <template #cell(brand_id)="data">
                <span v-if="data.item.brand_id"> {{ data.item.brand.name }} </span>
              </template>
              <template #cell(color)="data">
                <span v-if="data.item.color_id"> {{ data.item.color.name }} </span>
              </template>
              <template #cell(category_id)="data">
                <span v-if="data.item.category_id"> {{ data.item.category.name }} </span>
              </template>
              <template #cell(action)="data">
                <button @click="editProduct(data.item)" class="btn btn-sm btn-info"><i
                    class="fa fa-edit mr-1 mt-1"></i>Sửa</button>
                <button @click="deleteProduct(data.item.id)" class="btn btn-sm btn-danger"><i
                    class="fa fa-minus mr-1 mt-1"></i>Xóa</button>
              </template>
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
      <div class="form-group">
        <div class="modal fade" id="product" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <form @submit.prevent="addProduct()">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-bold text-uppercase">
                    <span v-if="!edit">Thêm sản phẩm mới</span>
                    <span v-else>Sửa sản phẩm</span>
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="code">Mã sản phẩm</label><small class="text-danger">*</small>
                    </div>
                    <div class="col-lg-8">
                      <input placeholder="Nhập mã" type="text" class="form-control" id="code" v-model="product.code"
                        name="code" v-bind:class="hasError('code') ? 'is-invalid' : ''" />
                      <span v-if="hasError('code')" class="invalid-feedback" role="alert">
                        <strong>{{ getError('code') }}</strong></span>
                    </div>
                  </div>
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="name">Tên sản phẩm</label><small class="text-danger">*</small>
                    </div>
                    <div class="col-lg-8">
                      <input placeholder="Nhập tên sản phẩm" type="text" class="form-control" id="name"
                        v-model="product.name" name="name" v-bind:class="hasError('name') ? 'is-invalid' : ''" />
                      <span v-if="hasError('name')" class="invalid-feedback" role="alert">
                        <strong>{{ getError('name') }}</strong></span>
                    </div>
                  </div>
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="note">Số tiền</label><small class="text-danger">*</small>
                    </div>
                    <div class="col-lg-8">
                      <input v-model="product.price" class="form-control" placeholder="Nhập số tiền..." />
                    </div>
                  </div>
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="note">Số lượng</label><small class="text-danger">*</small>
                    </div>
                    <div class="col-lg-8">
                      <input v-model="product.quantity" class="form-control" placeholder="Nhập số lượng..." />
                    </div>
                  </div>
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="note">Thượng hiệu</label><small class="text-danger">*</small>
                    </div>
                    <div class="col-lg-8">
                      <select class="form-control" v-model="product.brand_id">
                        <option v-for="(brand, index) in brands" :key="index" :value="brand.id"> {{ brand.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="note">Màu</label><small class="text-danger">*</small>
                    </div>
                    <div class="col-lg-8">
                      <select class="form-control" v-model="product.color_id">
                        <option v-for="(color, index) in colors" :key="index" :value="color.id"> {{ color.name }} </option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="note">Danh mục</label><small class="text-danger">*</small>
                    </div>
                    <div class="col-lg-8">
                      <select class="form-control" v-model="product.category_id">
                        <option v-for="(category, index) in categories" :key="index" :value="category.id"> {{
                          category.name }} </option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="note">Giới tính</label><small class="text-danger">*</small>
                    </div>
                    <div class="col-lg-8">
                      <select class="form-control" v-model="product.gender">
                        <option value="male">Nam</option>
                        <option value="female">Nữ</option>
                        <option value="female-male">Cặp đôi</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="note">Xuất xứ</label>
                    </div>
                    <div class="col-lg-8">
                      <input v-model="product.origin" class="form-control" placeholder="Nhập xuất xứ...." />
                    </div>
                  </div>
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="note">Chức năng</label>
                    </div>
                    <div class="col-lg-8">
                      <input v-model="product.function" class="form-control" placeholder="Nhập chức năng...." />
                    </div>
                  </div>
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="note">Ghi chú</label>
                    </div>
                    <div class="col-lg-8">
                      <textarea placeholder="Nhập ghi chú" class="form-control" id="note"
                        v-model="product.note"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="font-weight-bold" for="note">Hình ảnh</label>
                    <input type="file" name="images[]" multiple class="form-control" accept="image/*"
                      @change="handleFileUploadImage" />
                    <div>
                      <label>Danh sách ảnh đã chọn:</label>
                      <div class="row">
                        <div class="col-md-6 mt-2 image" v-for="(image, index) in product.images" :key="index">
                          <div class="img-ralative">
                            <img :src="image.path" class="w-100 img-responsive mt-2" alt="Ảnh đã chọn" loading="lazy">
                            <button @click.prevent="deleteImage(index, image)" class="btn img-remove">
                              <i class="fa fa-times-circle icon-remove"
                                style="--fa-primary-color: #050505; --fa-secondary-color: #e6e6e6; --fa-secondary-opacity: 0.8;"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Đóng</button>
                  <button type="submit" class="btn btn-success btn-sm">Lưu lại</button>
                </div>
              </form>

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

      fields: [
        {
          key: 'index',
          label: 'STT',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'code',
          label: 'Mã sản phẩm',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'name',
          label: 'Tên sản phẩm',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'price',
          label: 'Đơn giá',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'quantity',
          label: 'Số lượng',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'brand_id',
          label: 'Thương hiệu',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'color_id',
          label: 'Màu sắc',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'category_id',
          label: 'Loại sản phẩm',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'gender',
          label: 'Giới tính',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'note',
          label: 'Ghi chú',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'action',
          label: 'Hành động',
          class: "text-nowrap text-center",
        },
      ],
      products: [],
      product: {
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
      page_url_product: "/api/list-product",
      page_url_product_store: "/api/list-product-store",
      page_url_product_update: "/api/list-product-update",
      page_url_product_delete: "/api/list-product-delete",
      page_url_brand: "/api/list-brand",
      page_url_category: "/api/list-category",
      page_url_color: "/api/list-color",



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
          this.products = data.data;
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
    addProduct() {
      if (this.edit == false) {
        var page_url = this.page_url_product_store;
        fetch(page_url, {
          method: "POST",
          headers: {
            'Content-Type': 'application/json',
            Authorization: this.token
          },
          body: JSON.stringify(this.product)
        })
          .then(res => res.json())
          .then(data => {
            console.log(data);
            if (data.data.success == 1) {
              this.fetchProduct();
              this.$bvToast.toast(`Thêm thành công`, {
                title: 'Thông báo',
                variant: 'success',
                solid: true
              })
              $("#product").modal("hide");
            } else {
              this.errors = data.data.errors;
              this.$bvToast.toast(`Thêm thất bại`, {
                title: 'Thông báo',
                variant: 'danger',
                solid: true
              })
            }

          })
          .catch(err => {
            console.log(err);

          });
      } else {
        var page_url = this.page_url_product_update + "/" + this.product.id;
        fetch(page_url, {
          method: "PUT",
          headers: {
            'Content-Type': 'application/json',
            Authorization: this.token
          },
          body: JSON.stringify(this.product)
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
              $("#product").modal("hide");
            } else {
              this.errors = data.data.errors;

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

      }

    },
    editProduct(product) {
      this.edit = true;
      this.product.id = product.id;
      this.product.code = product.code;
      this.product.name = product.name;
      this.product.price = product.price;
      this.product.quantity = product.quantity;
      this.product.brand_id = product.brand_id;
      this.product.color_id = product.color_id;
      this.product.category_id = product.category_id;
      this.product.gender = product.gender;
      this.product.origin = product.origin;
      this.product.function = product.function;
      this.product.note = product.note;
      this.product.images = product.images;

      $("#product").modal("show");
    },
    showProduct() {
      this.edit = false;
      this.reset();
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
      this.product.id = "";
      this.product.code = "";
      this.product.name = "";
      this.product.note = "";
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
      return this.products.length;
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