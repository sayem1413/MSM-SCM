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
                                    <span class="font-weight-bold">Category Add</span>
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
                            <form class="form-horizontal" method="post" >
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
                                    <label>(Image Optional)</label>
                                    <input class="form-control" type="file" ref="image" name="image" @change="changeImage($event)" />
                                    <span class="text-danger" v-if="errors.image_path">{{ errors.image_path[0] }}</span>
                                    <span v-if="category.image != ''">
                                        <img :src="category.image" class="m-2" width="200" height="200">
                                        <br/>
                                        <button class="btn btn-danger m-2" @click="removeImage()" type="button" >remove</button>
                                    </span>
                                </div>

                                <div class="form-group col-md-12 col-sm-12">
                                    <router-link :to="{name:'category_list'}" class="btn btn-secondary btn-lg btn-sm">Cancle</router-link>
                                    <button class="btn btn-secondary btn-lg btn-sm" type="button" @click.prevent="addCategory(0)">Save & List</button>
                                    <button class="btn btn-secondary btn-lg btn-sm" type="button" @click.prevent="addCategory(1)">Save & Edit</button>
                                </div>
                            </form>
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
    name: 'category_add',
    components: {
        ClipLoader,
        Treeselect,
    },
    data: function() {
        return {
            category: {
                active:1,
                name:'',
                parent_id:null,
                description:'',
                image:'',
            },
            getAllCategories: [],
            isLoading: false,
            errors:[],
        };
    },
    mounted(){
        this.$store.dispatch("allCategoryList")
            .then(() =>{
                this.isLoading = false;
            })
    },
    computed:{
        getCategories(){
            this.getAllCategories = this.$store.getters.getAllCategories;
            return this.$store.getters.getAllCategories;
        }
    },
    methods: {
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
        addCategory( edit ) {
            // console.log( edit );
            this.isLoading = true;
            this.category.active ? this.category.active = 1 : this.category.active = 0;
            let url = ROOT_URL+"categories";
            var formData = new FormData();
            formData.append("name", this.category.name);
            formData.append("parent_id", this.category.parent_id === null ? '' : this.category.parent_id);
            formData.append("description", this.category.description);
            formData.append("image_path", this.category.image != '' ? this.$refs.image.files[0] : '');
            formData.append("active", this.category.active);
            
            axios.post(url, formData, {
                headers: {
                  "Content-Type": "multipart/form-data"
                }
            }).then((response) => {
                if( edit == 1 ){
                    this.$router.push({ name: "category_edit", params: { categoryId: response.data.category.id} })
                } else {
                    this.$router.push({ name: "category_list" });
                }
                this.$swal({
                    position: 'top',
                    title: 'Category Added',
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

