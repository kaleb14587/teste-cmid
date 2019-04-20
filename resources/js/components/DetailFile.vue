<template>
    <div class="row">
        <div class="col m5">
            <div class="card white-grey darken-1">
                <div class="card-content">
                    <span class="card-title">Total Clientes</span>
                    <p>{{ obj.obj.client.count }}</p>
                </div>
            </div>
        </div>
        <div class="col m7">
            <div class="card white-grey darken-1">
                <div class="card-content">
                    <span class="card-title">Total Vendedores</span>
                    <p>{{ obj.obj.salesman.count }}</p>
                </div>
            </div>
        </div>
        <div class="col m12">
            <div class="card white-grey darken-1">
                <div class="card-content">
                    <p class="expressive-sales-title">melhor venda</p>
                    <p>{{ obj.obj.sale.moreexpresive.name }} - Valor da venda: {{obj.obj.moreAmount}}</p>
                </div>
            </div>
        </div>
        <div class="col m12">
            <div class="card white-grey darken-1">
                <div class="card-content">
                    <p class="expressive-sales-title">Pior venda</p>
                    <p>{{ obj.obj.sale.lessexpresive.name }} - Valor da venda: {{obj.obj.amountLess}}</p>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    // Globally
    export default {
        data() {
          return {
            amountLess: 0,
            moreAmount:0
          };
        },
        props: {
            obj : Object
        },
        created () {
          console.log('created');
        },
        mounted() {

        }
    }
</script>
