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
                                :item_list_type="'materialList'"
                                :list_route="'material_list'"
                                :add_route="'material_add'"
                            >
                            </display-pagination-and-order-component>
                        </div>
                        <div v-if="materials && materials.length > 0" class="card-body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <material-item :materials_data="getMaterials" :materials="materials" ></material-item>
                            </table>
                            <pagination-component :pagination="pagination" :item_list_type="'materialList'" ></pagination-component>
                        </div>
                        <div v-else class="card-body">
                            <div class="row" >
                                <div class="col-md-12 col-sm-12 text-center">
                                    <h5>No material found. Please Add New!</h5>
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
import MaterialItem from './MaterialItem.vue';
import Vue from 'vue';
import VeeValidateLaravel from 'vee-validate-laravel';
Vue.use(VeeValidateLaravel);

import PaginationComponent from "../PaginationComponent";
import ClipLoader from 'vue-spinner/src/ClipLoader.vue';
import DisplayPaginationAndOrderComponent from "../DisplayPaginationAndOrderComponent";

export default {
    name: 'material_list',
    components: {
        MaterialItem,
        PaginationComponent,
        ClipLoader,
        DisplayPaginationAndOrderComponent,
    },
    data: function() {
        return {
            getMaterials: [],
            pagination: [],
            isLoading: true,
        };
    },
    mounted(){
        this.getMaterialList();
    },
    computed:{
        materials(){
            this.getMaterials = this.$store.getters.getMaterials.data;
            this.pagination = this.$store.getters.getMaterials.pagination;
            return this.$store.getters.getMaterials.data;
        }
    },
    methods: {
        getMaterialList(pageNo = 1) {
            this.$store.dispatch("materialList", pageNo)
            .then(() =>{
                this.isLoading = false;
            })
        }
    }

}
</script>

