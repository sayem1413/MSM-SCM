<template>
    <div class="row">
        <div class="col-md-4 col-sm-4 mt-2">
            <v-select
                v-model="order_by"
                :options="sortings"
                :reduce="sort => sort.id"
                placeholder="Sorting"
                @input="getItemList"
            ></v-select>
        </div>
        <div class="col-md-4 col-sm-4 mt-2">
            <v-select
                v-model="page_length"
                :options="paginations"
                :reduce="pagination => pagination.id"
                placeholder="Per Page Display"
                @input="getItemList"
            ></v-select>
        </div>
        <div class="col-md-4 col-sm-4 mt-2">
            <ul class="nav nav-tabs float-right">
                <li class="nav-item">
                    <router-link :to="{name:add_route}" class="nav-link text-light bg-info font-weight-bold">Add New +</router-link>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
import ROOT_URL from '../config';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

export default {
    name: "display-pagination-and-order-component",
    props: ['item_list_type', 'list_route', 'add_route'],
    components: {
        vSelect,
    },
    data: function() {
        return {
            order_by:0,
            page_length:0,
            sortings:[
                {
                    id:1,
                    label:'Name (A-Z)'
                },
                {
                    id:2,
                    label:'Name (Z-A)'
                },
                {
                    id:3,
                    label:'Created by (Z-A)'
                },
            ],
            paginations:[
                {
                    id:10,
                    label:'10'
                },
                {
                    id:20,
                    label:'20'
                },
                {
                    id:50,
                    label:'50'
                },
                {
                    id:100,
                    label:'100'
                },
            ],
            isLoading: false,
            errors:[],
        };
    },
    methods:{
        getItemList(){
            let pageNo = "1";
            if( this.order_by != 0 && this.order_by != null ){
                pageNo = pageNo + "&order_by="+this.order_by;
            }
            if( this.page_length != 0 && this.page_length != null ){
                pageNo = pageNo + "&page_length="+this.page_length;
                this.$store.commit('setPageLength', this.page_length);
            }
            // console.log(pageNo);
            this.$store.dispatch(this.item_list_type, pageNo)
            .then(() =>{
                this.isLoading = false;
            })
        },
    },
    // mounted(){
    //     console.log(this.pagination);
    // },
}
</script>