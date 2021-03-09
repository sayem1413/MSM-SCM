<template>
    <div>
        <div v-if="isLoading">
            <div class="overlay">
                <clip-loader :size="'50px'" class="overlay-content"></clip-loader>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 offset-1">
                    <div class="card bg-light">
                        <div class="card-header bg-transparent">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5 class="float-left">Category List</h5>
                                </div>
                                <div class="col-md-8">
                                    <ul class="nav nav-tabs float-right">
                                        <li class="nav-item">
                                            <router-link :to="{name:'category_list'}" class="nav-link text-light bg-info active font-weight-bold">List</router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link :to="{name:'category_add'}" class="nav-link text-light bg-info font-weight-bold">Add New</router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div v-if="allCategories && allCategories.length > 0" class="card-body">
                            <parent-category-tree :categories_data="getAllCategories" :allCategories="allCategories" ></parent-category-tree>
                            <!-- <template>
                                <vue-drag-tree
                                    :data='allCategories'
                                    v-bind:class="'p-2'"
                                    :allowDrag='allowDrag'
                                    :allowDrop='allowDrop'
                                    @current-node-clicked='curNodeClicked'
                                    @drag="dragHandler"
                                    @drag-enter="dragEnterHandler"
                                    @drag-leave="dragLeaveHandler"
                                    @drag-over="dragOverHandler"
                                    @drag-end="dragEndHandler"
                                    @drop="dropHandler"
                                ></vue-drag-tree>
                            </template> -->
                        </div>
                        <div v-else class="card-body">
                            <div class="row" >
                                <div class="col-md-12 col-sm-12 text-center">
                                    <h5>No category found. Please Add New!</h5>
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
import ParentCategoryTree from './ParentCategoryTree.vue';
import Vue from 'vue';
import VeeValidateLaravel from 'vee-validate-laravel';
Vue.use(VeeValidateLaravel);

import ClipLoader from 'vue-spinner/src/ClipLoader.vue';

// import VueDragTree from 'vue-drag-tree'
// import 'vue-drag-tree/dist/vue-drag-tree.min.css'
 
// Vue.use(VueDragTree);

export default {
    name: 'category_list',
    components: {
        ParentCategoryTree,
        ClipLoader,
    },
    data: function() {
        return {
            getAllCategories: [],
            isLoading: true,
        };
    },
    mounted(){
        this.getCategoryList();
    },
    computed:{
        allCategories(){
            this.getAllCategories = this.$store.getters.getAllCategories;
            return this.$store.getters.getAllCategories;
        }
    },
    methods: {
        getCategoryList() {
            this.$store.dispatch("allCategoryList").then(() =>{
                this.isLoading = false;
            })
            // let url = ROOT_URL+"all-categories";
            // axios.get(url).then((response)=>{
            //         this.getAllCategories = response.data.all_categories;
            //         this.isLoading = false;
            //     })
        },
        allowDrag(model, component) {
            if (model.name === 'Node 0-1') {
                // can't be dragged
                return false;
            }
            // can be dragged
            return true;
        },
        allowDrop(model, component) {
            if (model.name === 'Node 2-2') {
                // can't be placed
                return false;
            }
            // can be placed
            return true;
        },
        curNodeClicked(model, component) {
            console.log('curNodeClicked', model, component);
        },
        dragHandler(model, component, e) {
            console.log('dragHandler: ', model, component, e);
        },
        dragEnterHandler(model, component, e) {
            console.log('dragEnterHandler: ', model, component, e);
        },
        dragLeaveHandler(model, component, e) {
            console.log('dragLeaveHandler: ', model, component, e);
        },
        dragOverHandler(model, component, e) {
            console.log('dragOverHandler: ', model, component, e);
        },
        dragEndHandler(model, component, e) {
            console.log('dragEndHandler: ', model, component, e);
        },
        dropHandler(model, component, e) {
            console.log('dropHandler: ', model, component, e);
        }
    }

}
</script>

