<template>
    <div>
        <div v-if="isLoading">
            <div class="overlay">
                <clip-loader :size="'50px'" class="overlay-content"></clip-loader>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card bg-light">
                        <div class="card-header bg-transparent">
                            <display-pagination-and-order-component
                                :item_list_type="'usageList'"
                                :list_route="'usage_list'"
                                :add_route="'usage_add'"
                            >
                            </display-pagination-and-order-component>
                        </div>
                        <div v-if="usages && usages.length > 0" class="card-body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <usage-item :usages_data="getUsages" :usages="usages" ></usage-item>
                            </table>
                            <pagination-component :pagination="pagination" :item_list_type="'usageList'" ></pagination-component>
                        </div>
                        <div v-else class="card-body">
                            <div class="row" >
                                <div class="col-md-12 col-sm-12 text-center">
                                    <h5>No usage found. Please Add New!</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import ROOT_URL from '../../config';
import UsageItem from './UsageItem.vue';
import Vue from 'vue';
import VeeValidateLaravel from 'vee-validate-laravel';
Vue.use(VeeValidateLaravel);

import PaginationComponent from "../PaginationComponent";
import ClipLoader from 'vue-spinner/src/ClipLoader.vue';
import DisplayPaginationAndOrderComponent from "../DisplayPaginationAndOrderComponent";

export default {
    name: 'usage_list',
    components: {
        UsageItem,
        PaginationComponent,
        ClipLoader,
        DisplayPaginationAndOrderComponent,
    },
    data: function() {
        return {
            getUsages: [],
            pagination: [],
            isLoading: true,
        };
    },
    mounted(){
        this.getusageList();
    },
    computed:{
        usages(){
            this.getUsages = this.$store.getters.getUsages.data;
            this.pagination = this.$store.getters.getUsages.pagination;
            return this.$store.getters.getUsages.data;
        }
    },
    methods: {
        getusageList(pageNo = 1) {
            this.$store.dispatch("usageList", pageNo)
            .then(() =>{
                this.isLoading = false;
            })
        }
    }

}
</script>

