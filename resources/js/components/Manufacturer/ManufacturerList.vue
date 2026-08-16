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
                                :item_list_type="'manufacturerList'"
                                :list_route="'manufacturer_list'"
                                :add_route="'manufacturer_add'"
                            >
                            </display-pagination-and-order-component>
                        </div>
                        <div v-if="manufacturers && manufacturers.length > 0" class="card-body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Logo</th>
                                        <th scope="col" class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <manufacturer-item :manufacturers_data="getManufacturers" :manufacturers="manufacturers" ></manufacturer-item>
                                
                            </table>
                            <pagination-component :pagination="pagination" :item_list_type="'manufacturerList'" ></pagination-component>
                        </div>
                        <div v-else class="card-body">
                            <div class="row" >
                                <div class="col-md-12 col-sm-12 text-center">
                                    <h5>No manufacturer found. Please Add New!</h5>
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
import ManufacturerItem from './ManufacturerItem.vue';
import Vue from 'vue';
import VeeValidateLaravel from 'vee-validate-laravel';
Vue.use(VeeValidateLaravel);

import PaginationComponent from "../PaginationComponent";
import DisplayPaginationAndOrderComponent from "../DisplayPaginationAndOrderComponent";
import ClipLoader from 'vue-spinner/src/ClipLoader.vue';

export default {
    name: 'manufacturer_list',
    components: {
        ManufacturerItem,
        PaginationComponent,
        DisplayPaginationAndOrderComponent,
        ClipLoader,
    },
    data: function() {
        return {
            getManufacturers: [],
            pagination: [],
            isLoading: true,
        };
    },
    mounted(){
        this.getManufacturerList();
    },
    computed:{
        manufacturers(){
            this.getManufacturers = this.$store.getters.getManufacturers.data;
            this.pagination = this.$store.getters.getManufacturers.pagination;
            return this.$store.getters.getManufacturers.data;
        }
    },
    methods: {
        getManufacturerList(pageNo = 1) {
            this.$store.dispatch("manufacturerList", pageNo).then(() =>{
                this.isLoading = false;
            })
        }
    }

}
</script>

