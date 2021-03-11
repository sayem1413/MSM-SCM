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
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <span class="font-weight-bold">Category Edit</span>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <ul class="nav nav-tabs float-right">
                                        <li class="nav-item">
                                            <router-link :to="{name:'category_list'}" class="nav-link text-light bg-info font-weight-bold">Back to List</router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <form class="form-horizontal" method="post">
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label class="font-weight-bold mr-3">Active</label>
                                        <input v-model="category.active" class="mt-1" type="checkbox" name="active"/>
                                    </div>
                                    
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label class="font-weight-bold">Name</label>
                                        <input class="form-control" v-model="category.name" type="text" name="name"/>
                                        <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12">
                                        <label class="font-weight-bold">Parent Category</label>
                                        <treeselect
                                            v-model="category.parent_id"
                                            :options="getCategories"
                                            placeholder="Select Parent Category"
                                            search-nested
                                        />
                                        <span class="text-danger" v-if="errors.parent_id">{{ errors.parent_id[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12">
                                        <label class="font-weight-bold">Description</label>
                                        <textarea class="form-control" v-model="category.description" type="text" name="description"></textarea>
                                        <span class="text-danger" v-if="errors.description">{{ errors.description[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12">
                                        <label class="font-weight-bold">Image</label>
                                        <label>(Image optional)</label>
                                        <input class="form-control" type="file" ref="image" name="image" @change="changeImage($event)" />
                                        <span class="text-danger" v-if="errors.image_path">{{ errors.image_path[0] }}</span>
                                        <span v-if="category.image != null && category.image != ''">
                                            <img :src="updateImage()" class="m-2" width="200" height="200">
                                            <br/>
                                            <button class="btn btn-danger m-2" @click="removeImage()" type="button" >remove</button>
                                        </span>
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12">
                                        <router-link :to="{name:'category_list'}" class="btn btn-secondary btn-lg btn-sm">Cancle</router-link>
                                        <button class="btn btn-secondary btn-lg btn-sm" type="button" @click.prevent="updateCategory(0)">Update</button>
                                        <button class="btn btn-secondary btn-lg btn-sm" type="button" @click.prevent="updateCategory(1)">Update & Edit</button>
                                    </div>
                                </form>
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
import Vue from 'vue';
import VeeValidateLaravel from 'vee-validate-laravel';
Vue.use(VeeValidateLaravel);
import ClipLoader from 'vue-spinner/src/ClipLoader.vue';
import Treeselect from '@riophae/vue-treeselect';
import '@riophae/vue-treeselect/dist/vue-treeselect.css';

export default {
    name: 'category_edit',
    components: {
        ClipLoader,
        Treeselect,
    },
    data: function() {
        return {
            categoryId:this.$route.params.categoryId,
            language:'lt',
            category: {
                active:0,
                name:'',
                parent_id:0,
                description:'',
                image:'',
            },
            getAllCategories: [],
            isLoading: true,
            errors:[],
            translatedErrors:[],
        };
    },
    mounted(){
        this.categoryInfo();
        this.allCategories();
    },
    computed:{
        getCategories(){
            this.getAllCategories = this.$store.getters.getAllCategories;
            return this.$store.getters.getAllCategories;
        }
    },
    methods: {
        allCategories(){
            let request = '?id=' + this.$route.params.categoryId;
            this.$store.dispatch("allCategoryList", request ).then(() =>{
                this.isLoading = false;
            })
        },
        categoryInfo(){
            let url = ROOT_URL+"categories/";
            axios.get(url + this.$route.params.categoryId).then((response)=>{
                this.category = response.data.category;
                this.category.image = response.data.category.image_path? ROOT_URL + response.data.category.image_path : '';
                this.category.parent_id = response.data.category.parent_id ? response.data.category.parent_id : 0;
                this.isLoading = false;
            }).catch((e) => {
                this.errorHandler(e.response.status, e.response.data.errors, e.response.statusText );
            }).finally(() => {
                this.isLoading = false;
            });
        },
        changeImage(event) {
            let file = event.target.files[0];
            if (file.size > 9*1024*1024*5) {
                this.$swal({
                    title: "Oops...",
                    text: "Something went wrong!",
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'error',
                });
            } else {
                let reader = new FileReader();
                reader.onload = event => {
                    this.category.image = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        removeImage(){
            this.category.image = '';
            this.$refs.image.value = '';
        },
        updateImage() {
            let img = this.category.image;
            if (img && img.length > 10000) {
                return this.category.image;
            } else {
                return `${this.category.image}`;
            }
        },
        updateCategory( edit ) {
            this.isLoading = true;
            this.category.active ? this.category.active = 1 : this.category.active = 0;
            let url = ROOT_URL+"categories/";
            var formData = new FormData();
            formData.append("id", this.$route.params.categoryId);
            formData.append("name", this.category.name);
            formData.append("parent_id", this.category.parent_id == null || this.category.parent_id == undefined ? 0 : this.category.parent_id );
            formData.append("description", this.category.description?? '');
            formData.append("image_path", this.$refs.image.files[0] == undefined ? '' : this.$refs.image.files[0]);
            formData.append("active", this.category.active);
            formData.append("_method", 'PATCH');
            axios.post(url + this.$route.params.categoryId, formData, {
                headers: {
                  "Content-Type": "multipart/form-data"
                }
            }).then((response) => {
                if( edit == 0 ) {
                    this.$router.push({name:'category_list'});
                }
                this.$swal({
                    position: 'top',
                    title: 'Category Updated',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'success',
                });
                this.isLoading = false;
            }).catch((e) => {
                this.errorHandler(e.response.status, e.response.data.errors, e.response.statusText );
            }).finally(() => {
                this.isLoading = false;
            });
        },
        errorHandler(errorStatus, errorData, statusText = '' ){
            this.isLoading = false;
            if( errorStatus === 422 ) {
                this.errors = errorData;
            }
            if( errorStatus === 500 || errorStatus === 404 ){
                this.$swal({
                    position: 'top',
                    title: statusText,
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'error',
                });
            }
            if( errorStatus === 401 ){
                window.location.href = "{{ route('login') }}";
            }
        }
    }

}
</script>

