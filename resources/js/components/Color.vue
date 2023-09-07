<template>
  <div>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group d-flex justify-content-between">
            <h5 class="font-weight-bold text-uppercase"><i class="fa fa-th-list mr-2"></i> Màu sắc
            </h5>
            <button @click="showColor()" class="btn btn-sm btn-info"><i class="fa fa-plus mr-2"></i>Tạo
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
          <div class="bg-white">
            <b-table striped hover small :bordered="true" :items="colors" :fields="fields" :filter="filter"
              :current-page="current_page" :per-page="per_page">
              <template #cell(index)="data">
                {{ data.index + 1 }}
              </template>
              <template #cell(action)="data">
                <button @click="editColor(data.item)" class="btn btn-sm btn-info"><i
                    class="fa fa-edit mr-1 mt-1"></i>Sửa</button>
                <button @click="deleteCategory(data.item.id)" class="btn btn-sm btn-danger"><i
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
        <div class="modal fade" id="color" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <form @submit.prevent="addColor()">
                <div class="modal-header">
                  <h5 class="modal-title font-weight-bold text-uppercase">
                    <span v-if="!edit">Thêm màu sắc mới</span>
                    <span v-else>Sửa màu sắc</span>
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="hex_code">Mã màu</label><small class="text-danger">*</small>
                    </div>
                    <div class="col-lg-8">
                      <input placeholder="Nhập mã" type="color" class="form-control" id="hex_code"
                        v-model="color.hex_code" name="hex_code"
                        v-bind:class="hasError('hex_code') ? 'is-invalid' : ''" />
                      <span v-if="hasError('hex_code')" class="invalid-feedback" role="alert">
                        <strong>{{ getError('hex_code') }}</strong></span>
                    </div>
                  </div>
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="name">Tên màu sắc</label><small class="text-danger">*</small>
                    </div>
                    <div class="col-lg-8">
                      <input placeholder="Nhập tên sản phẩm" type="text" class="form-control" id="name"
                        v-model="color.name" name="name" v-bind:class="hasError('name') ? 'is-invalid' : ''" />
                      <span v-if="hasError('name')" class="invalid-feedback" role="alert">
                        <strong>{{ getError('name') }}</strong></span>
                    </div>
                  </div>
                  <div class="form-group row align-items-baseline">
                    <div class="col-lg-4">
                      <label class="font-weight-bold" for="note">Ghi chú</label>
                    </div>
                    <div class="col-lg-8">
                      <textarea placeholder="Nhập ghi chú" class="form-control" id="note" v-model="color.note"></textarea>
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
          key: 'hex_code',
          label: 'Mã màu',
          class: "text-nowrap",
          sortable: true,
        },
        {
          key: 'name',
          label: 'Tên màu sắc',
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
      colors: [],
      color: {
        id: "",
        hex_code: "",
        name: "",
        note: "",
      },
      filter: "",
      total: 0,
      per_page: 10,
      from: 1,
      to: 0,
      current_page: 1,

      pageOptions: [10, 50, 100, 500, { value: this.rows, text: "All" }],
      page_url_color: "/api/list-color",
      page_url_color_store: "/api/list-color-store",
      page_url_color_update: "/api/list-color-update",
      page_url_color_delete: "/api/list-color-delete",

    }
  },
  created() {
    this.token = "Bearer " + window.Laravel.access_token;
    this.fetchColor();
  },
  methods: {
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
    addColor() {
      if (this.edit == false) {
        var page_url = this.page_url_color_store;
        fetch(page_url, {
          method: "POST",
          headers: {
            'Content-Type': 'application/json',
            Authorization: this.token
          },
          body: JSON.stringify(this.color)
        })
          .then(res => res.json())
          .then(data => {
            console.log(data);
            if (data.data.success == 1) {
              this.fetchColor();
              this.$bvToast.toast(`Thêm thành công`, {
                title: 'Thông báo',
                variant: 'success',
                solid: true
              })
              $("#color").modal("hide");
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
        var page_url = this.page_url_color_update + "/" + this.color.id;
        fetch(page_url, {
          method: "PUT",
          headers: {
            'Content-Type': 'application/json',
            Authorization: this.token
          },
          body: JSON.stringify(this.color)
        })
          .then(res => res.json())
          .then(data => {
            if (data.data.success == 1) {
              this.fetchColor();
              this.$bvToast.toast(`Cập nhật thành công`, {
                title: 'Thông báo',
                variant: 'success',
                solid: true
              })
              $("#color").modal("hide");
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
    editColor(color) {
      this.edit = true;
      this.color.id = color.id;
      this.color.hex_code = color.hex_code;
      this.color.name = color.name;
      this.color.note = color.note;

      $("#color").modal("show");
    },
    showColor() {
      this.edit = false;
      this.reset();
      $("#color").modal("show");
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
      this.color.id = "";
      this.color.hex_code = "";
      this.color.name = "";
      this.color.note = "";
      this.errors = {};
    },
    deleteCategory(id) {
      var page_url = this.page_url_color_delete + "/" + id;
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
            this.fetchColor();
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
    }

  },
  computed: {
    rows() {
      return this.colors.length;
    }
  }
}
</script>