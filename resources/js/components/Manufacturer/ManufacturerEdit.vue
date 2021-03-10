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
                                    <span class="font-weight-bold">Manufacturer Edit</span>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <ul class="nav nav-tabs float-right">
                                        <li class="nav-item">
                                            <router-link :to="{name:'manufacturer_list'}" class="nav-link text-light bg-info font-weight-bold">Back to List</router-link>
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
                                        <input v-model="manufacturer.active" class="mt-1" type="checkbox" name="active"/>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label class="font-weight-bold">Name</label>
                                        <input class="form-control" v-model="manufacturer.name" type="text" name="name"/>
                                        <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12">
                                        <label class="font-weight-bold">Logo</label>
                                        <input class="form-control" type="file" ref="logo" name="logo" @change="changeImage($event)" />
                                        <span class="text-danger" v-if="errors.logo_path">{{ errors.logo_path[0] }}</span>
                                        <span v-if="manufacturer.logo != null && manufacturer.logo != ''">
                                            <img :src="updateImage()" class="m-2" width="200" height="200">
                                            <br/>
                                            <button class="btn btn-danger m-2" @click="removeImage()" type="button" >remove</button>
                                        </span>
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12">
                                        <label class="font-weight-bold">Description</label>
                                        <textarea class="form-control" v-model="manufacturer.description" type="text" name="description"></textarea>
                                        <span class="text-danger" v-if="errors.description">{{ errors.description[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12">
                                        <router-link :to="{name:'manufacturer_list'}" class="btn btn-secondary btn-lg btn-sm">Cancle</router-link>
                                        <button class="btn btn-secondary btn-lg btn-sm" type="button" @click.prevent="updateManufacturer(0)">Update</button>
                                        <button class="btn btn-secondary btn-lg btn-sm" type="button" @click.prevent="updateManufacturer(1)">Update & Edit</button>
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

export default {
    name: 'manufacturer_edit',
    components: {
        ClipLoader,
    },
    data: function() {
        return {
            manufacturerId:this.$route.params.manufacturerId,
            language:'lt',
            manufacturer: {
                active:0,
                name:'',
                description:'',
                logo:'',
            },
            translatedManufacturer: {
                translatedName:'',
                translatedDescription:'',
            },
            getManufacturers: [],
            isLoading: true,
            errors:[],
            translatedErrors:[],
        };
    },
    mounted(){
        this.manufacturerInfo('lt');
    },
    methods: {
        manufacturerInfo(lang){
            let url = ROOT_URL+"manufacturers/";
            let langParam = '?lang='+lang;
            this.language = lang;
            axios.get(url + this.$route.params.manufacturerId + langParam).then((response)=>{
                this.manufacturer = response.data.manufacturer;
                this.manufacturer.logo = response.data.manufacturer.logo_path? ROOT_URL+response.data.manufacturer.logo_path :'';
                this.isLoading = false
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
                    this.manufacturer.logo = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        removeImage(){
            this.manufacturer.logo = '';
            this.$refs.logo.value = '';
        },
        updateImage() {
            let img = this.manufacturer.logo;
            if (img && img.length > 10000) {
                return this.manufacturer.logo;
            } else {
                return `${this.manufacturer.logo}`;
            }
        },
        updateManufacturer( edit ) {
            this.isLoading = true;
            this.manufacturer.active ? this.manufacturer.active = 1 : this.manufacturer.active = 0;
            let url = ROOT_URL+"manufacturers/";
            var formData = new FormData();
            formData.append("id", this.$route.params.manufacturerId);
            formData.append("name", this.manufacturer.name);
            formData.append("logo_path", this.$refs.logo.files[0] == undefined ? '' : this.$refs.logo.files[0]);
            formData.append("description", this.manufacturer.description?? '');
            formData.append("active", this.manufacturer.active);
            formData.append("_method", 'PATCH');
            axios.post(url + this.$route.params.manufacturerId, formData, {
                headers: {
                  "Content-Type": "multipart/form-data"
                }
            }).then((response) => {
                if( edit == 0 ) {
                    this.$router.push({ name:"manufacturer_list"});
                }
                this.$swal({
                    position: 'top',
                    title: 'Manufacturer Updated',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'success',
                });
                this.isLoading = false;
            })
            .catch((e) => {
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
                window.location.href = "{{ route('admin.login') }}";
            }
        }
    }

}
</script>

