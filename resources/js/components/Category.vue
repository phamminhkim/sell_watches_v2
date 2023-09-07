<template>
    <div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group d-flex justify-content-between">
                        <h5 class="font-weight-bold text-uppercase"><i class="fa fa-th-list mr-2"></i> Danh mục sản phẩm
                        </h5>
                        <button @click="showCategory()" class="btn btn-sm btn-info"><i class="fa fa-plus mr-2"></i>Tạo
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
                        <b-table striped hover small :bordered="true" :items="categories" :fields="fields" :filter="filter"
                            :current-page="current_page" :per-page="per_page">
                            <template #cell(index)="data">
                                {{ data.index + 1 }}
                            </template>
                            <template #cell(action)="data">
                                <button @click="editCategory(data.item)" class="btn btn-sm btn-info"><i
                                        class="fa fa-edit mr-1 mt-1"></i>Sửa</button>
                                <button @click="deleteCategory(data.item.id)" class="btn btn-sm btn-danger"><i class="fa fa-minus mr-1 mt-1"></i>Xóa</button>
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
                                        <b-pagination v-model="current_page" :total-rows="rows" :per-page="per_page"
                                            align="fill" size="sm" class="my-0"></b-pagination>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="form-group">
                <div class="modal fade" id="category" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form @submit.prevent="addCategory()">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold text-uppercase">
                                        <span v-if="!edit">Thêm danh mục sản phẩm</span>
                                        <span v-else>Sửa danh mục sản phẩm</span>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row align-items-baseline">
                                        <div class="col-lg-4">
                                            <label class="font-weight-bold" for="code">Mã danh mục</label><small
                                                class="text-danger">*</small>
                                        </div>
                                        <div class="col-lg-8">
                                            <input placeholder="Nhập mã" type="text" class="form-control" id="code"
                                                v-model="category.code" name="code"
                                                v-bind:class="hasError('code') ? 'is-invalid' : ''" />
                                                <span v-if="hasError('code')" class="invalid-feedback" role="alert">
                                                    <strong>{{ getError('code') }}</strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-baseline">
                                        <div class="col-lg-4">
                                            <label class="font-weight-bold" for="name">Tên danh mục</label><small
                                                class="text-danger">*</small>
                                        </div>
                                        <div class="col-lg-8">
                                            <input placeholder="Nhập tên sản phẩm" type="text" class="form-control"
                                                id="name" v-model="category.name" name="name"
                                                v-bind:class="hasError('name') ? 'is-invalid' : ''" />
                                                <span v-if="hasError('name')" class="invalid-feedback" role="alert">
                                                    <strong>{{ getError('name') }}</strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-baseline">
                                        <div class="col-lg-4">
                                            <label class="font-weight-bold" for="note">Ghi chú</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <textarea placeholder="Nhập ghi chú" class="form-control" id="note"
                                                v-model="category.note"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-dismiss="modal">Đóng</button>
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
                    label: 'Mã danh mục',
                    class: "text-nowrap",
                    sortable: true,
                },
                {
                    key: 'name',
                    label: 'Tên danh mục',
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
            categories: [],
            category: {
                id: "",
                code: "",
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
            page_url_category: "/api/list-category",
            page_url_category_store: "/api/list-category-store",
            page_url_category_update: "/api/list-category-update",
            page_url_category_delete: "/api/list-category-delete",

        }
    },
    created() {
        this.token = "Bearer " + window.Laravel.access_token;
        this.fetchCategory();
    },
    methods: {
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
        addCategory() {
            if (this.edit == false) {
                var page_url = this.page_url_category_store;
                fetch(page_url, {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: this.token
                    },
                    body: JSON.stringify(this.category)
                })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        if (data.data.success == 1) {
                            this.fetchCategory();
                            this.$bvToast.toast(`Thêm thành công`, {
                                title: 'Thông báo',
                                variant: 'success',
                                solid: true
                            })
                            $("#category").modal("hide");
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
                var page_url = this.page_url_category_update + "/" + this.category.id;
                fetch(page_url, {
                    method: "PUT",
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: this.token
                    },
                    body: JSON.stringify(this.category)
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.data.success == 1) {
                            this.fetchCategory();
                            this.$bvToast.toast(`Cập nhật thành công`, {
                                title: 'Thông báo',
                                variant: 'success',
                                solid: true
                            })
                            $("#category").modal("hide");
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
        editCategory(category) {
            this.edit = true;
            this.category.id = category.id;
            this.category.code = category.code;
            this.category.name = category.name;
            this.category.note = category.note;

            $("#category").modal("show");
        },
        showCategory() {
            this.edit = false;
            this.reset();
            $("#category").modal("show");
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
        reset(){
            this.category.id = "";
            this.category.code = "";
            this.category.name = "";
            this.category.note = "";
            this.errors = {};
        },
        deleteCategory(id) {
            var page_url = this.page_url_category_delete + "/" + id;
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
                        this.fetchCategory();
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
            return this.categories.length;
        }
    }
}
</script>