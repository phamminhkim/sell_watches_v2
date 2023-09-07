<template>
    <div>
        <h4> Phạm Minh Kim </h4>
        <div class="container-fluid">
            <div class="form-group mt-2">
                <div class="row">
                    <div class="col-lg-3" v-for="product in products" :key="product.id">
                        <div class="card bg-white shadown-lg w-100 h-100 shadow border-0 mt-2">
                            <div class="card-header bg-transparent border-0">
                                <div v-for="(image, index) in product.images">
                                    <img :src="image.path" class="img-thumb w-100" />
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
                            <div class="card-footer w-100" style="position: absolute;bottom: 0;">
                                <button @click="detailProduct(product.id)" class="btn btn-sm btn-danger"><i class="fa fa-cart-plus mr-2"></i>Mua</button>
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
            var page_url = this.page_url_product;
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
        detailProduct(id){
            window.location.href = "/product-detail" + '/' + id;
        }
    }
}
</script>