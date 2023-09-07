<template>
    <div>
       <div class="row">
        <div class="col-lg-4">
            <div class="form-group" v-for="(image,index) in product_details.images" :key="index" >
                <img :src="image.path" />
            </div>
        </div>
        <div class="col-lg-8">
            kim
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
            product_details: [],
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