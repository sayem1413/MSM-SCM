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
                                :item_list_type="'colorList'"
                                :list_route="'color_list'"
                                :add_route="'color_add'"
                            >
                            </display-pagination-and-order-component>
                        </div>
                        <div v-if="colors && colors.length > 0" class="card-body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Hexa Code</th>
                                        <th scope="col">Color View</th>
                                        <th scope="col" class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <color-item :colors_data="getColors" :colors="colors" ></color-item>
                            </table>
                            <pagination-component :pagination="pagination" :item_list_type="'colorList'" ></pagination-component>
                        </div>
                        <div v-else class="card-body">
                            <div class="row" >
                                <div class="col-md-12 col-sm-12 text-center">
                                    <h5>No color found. Please Add New!</h5>
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
import ColorItem from './ColorItem.vue';
import Vue from 'vue';
import VeeValidateLaravel from 'vee-validate-laravel';
Vue.use(VeeValidateLaravel);

import PaginationComponent from "../PaginationComponent";
import ClipLoader from 'vue-spinner/src/ClipLoader.vue';
import DisplayPaginationAndOrderComponent from "../DisplayPaginationAndOrderComponent";

export default {
    name: 'color_list',
    components: {
        ColorItem,
        PaginationComponent,
        ClipLoader,
        DisplayPaginationAndOrderComponent,
    },
    data: function() {
        return {
            getColors: [],
            pagination: [],
            isLoading: true,
        };
    },
    mounted(){
        this.getColorList();
    },
    computed:{
        colors(){
            this.getColors = this.$store.getters.getColors.data;
            this.pagination = this.$store.getters.getColors.pagination;
            return this.$store.getters.getColors.data;
        }
    },
    methods: {
        getColorList(pageNo = 1) {
            this.$store.dispatch("colorList", pageNo)
            .then(() =>{
                this.isLoading = false;
            })
        }
    }

}
</script>

