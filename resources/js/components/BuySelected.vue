<template>
    <div>
        <div class="form-group">
            <table class="table hover border-0">
                <thead>
                    <tr>
                        <td>Sản phẩm</td>
                        <td>Đơn giá</td>
                        <td>Số lượng</td>
                        <td>Thành tiền</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(buy, index) in buy_selecteds" :key="index">
                        <td v-if="buy.product_id"> {{ buy.product.name }} </td>
                        <td v-if="buy.product_id"> {{ buy.product.price }} </td>
                        <td> {{ buy.quantity }} </td>
                        <td> {{ buy.total_price }} </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Tổng số tiền ({{ buy_selecteds.length }} sản phẩm):
                            <span class="text-danger"> {{ total_price }} đ </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="form-group text-right">
            <button class="btn btn-warning py-2 px-4">Đặt hàng</button>
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