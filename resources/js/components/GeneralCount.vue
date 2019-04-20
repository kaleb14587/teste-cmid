<template>
    <div class="row">
        <h4>Totais gerais</h4>
        <div class="row">
            <div class="col m4">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Clientes</span>
                        <p>{{ clienteTotal }}</p>
                    </div>
                </div>
            </div>
            <div class="col m4">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Vendedores</span>
                        <p>{{ vendedorTotal }}</p>
                    </div>
                </div>
            </div>
            <div class="col m4">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Pior vendedor</span>
                        <p>{{ lessSel }}</p>
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
                clienteTotal: 0,
                vendedorTotal: 0,
                lessSel: "ninguem",
                salesmanLess: {}
            }
        },
        mounted() {
            window.files.map((file) => {
                window.axios.get('/get-out-file',{
                    params:  {fileName : file }})
                    .then(({data}) => {
                        this.clienteTotal += data.obj.client.count;
                        this.vendedorTotal += data.obj.salesman.count;
                        var total= 0;
                        data.obj.sale.lessexpresive.items.map((item) => {
                            total += (item.qtd.replace(" ","") * item.valor.replace(" ",""));
                        });
                        if (!this.salesmanLess.amount || total < this.salesmanLess.amount) {
                            this.salesmanLess = data.obj.sale.lessexpresive;
                            this.salesmanLess.amount = total;
                        }
                        this.lessSel =  this.salesmanLess.name;
                    })  .catch(error => {
                    if (error.response) {
                        console.log(error.response);
                    }
                });
            });


        }
    }
</script>

<style scoped>

</style>
