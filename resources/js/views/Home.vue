<template>
    <div>
        <div class="container">
            <h2>Arquivos</h2>
        </div>
        <div class="container">
            <GeneralCount/>
        </div>
        <div class="container">

            <div class="row">
                <div class="col m4">
                    <ListItem  v-bind:onClick="activeItemList" />
                </div>
                <div class="col m8">
                    <div v-if="file">

                        <div class="row">
                            <h5>{{ fileName }}</h5>
                        </div>
                        <DatailFile :obj="file"/>
                    </div>
                    <div v-else>Nenhum arquivo selecionado</div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    import ListItem from './../components/ListFiles';
    import DatailFile from "./../components/DetailFile";
    import GeneralCount from "./../components/GeneralCount";
    export default {
        data() {
          return {
              open : false,
              file :false,
              fileName: false
          }
        },
        components : {
            ListItem,
            DatailFile,
            GeneralCount
        },
        methods: {
            activeItemList(file) {
                if (file !== 'atualizar') {
                    this.fileName = file;
                    window.axios.get('/get-out-file',{
                        params:  {fileName : file }})
                        .then(({data}) => {
                            data.obj.moreAmount = 0;
                            data.obj.amountLess = 0;
                            data.obj.sale.moreexpresive.items.map((item) => {
                                if(item.qtd && item.valor)
                                    data.obj.moreAmount += (item.qtd.replace(" ","") * item.valor.replace(" ",""));
                            });
                            data.obj.sale.lessexpresive.items.map((item) => {
                                if(item.qtd && item.valor)
                                    data.obj.amountLess += (item.qtd.replace(" ","") * item.valor.replace(" ",""));
                            });
                            data.obj.amountLess = (data.obj.amountLess + "").replace(".",",");
                            data.obj.moreAmount = (data.obj.moreAmount + "").replace(".",",");
                            this.file = data;
                        })  .catch(error => {
                        if (error.response) {
                            console.log(error.response);
                        }
                    });
                }
            }
        }
    }
</script>
