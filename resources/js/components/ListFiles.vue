<template>
    <ul class="collection">
        <li class="collection-item" @click="onClick('atualizar')">  <i class="material-icons align-center">sync</i>
            Atualizar</li>
        <li class="collection-item" v-for="file in files" @click="onClick(file)">{{ file }}</li>
    </ul>
</template>

<script>
    export default {
        props: {
            onClick: Function,
        },
        mounted() {

        },
        data() {
            return {
                files: window.files
            };
        },
       methods: {
           click(file){
               this.activeItemList(file);
           }
       }
    }
</script>

<style scoped>

</style>
