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
                                    <span class="font-weight-bold">Usage Class Edit</span>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <ul class="nav nav-tabs float-right">
                                        <li class="nav-item">
                                            <router-link :to="{name:'usage_list'}" class="nav-link text-light bg-info font-weight-bold"> Back to List</router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <form class="form-horizontal" method="post" >
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label class="font-weight-bold">Name</label>
                                        <input class="form-control" v-model="usage.name" type="text" name="name"/>
                                        <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12">
                                        <label class="font-weight-bold">Description</label>
                                        <textarea type="classic" class="form-control" v-model="usage.description" name="description" id="description"></textarea>
                                        <span class="text-danger" v-if="errors.description">{{ errors.description[0] }}</span>
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12">
                                        <router-link :to="{name:'usage_list'}" class="btn btn-secondary btn-lg btn-sm">Cancle</router-link>
                                        <button class="btn btn-secondary btn-lg btn-sm" type="button" @click.prevent="updateUsage(0)">Update & List</button>
                                        <button class="btn btn-secondary btn-lg btn-sm" type="button" @click.prevent="updateUsage(1)">Update</button>
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
    name: 'usage_edit',
    components: {
        ClipLoader,
    },
    data: function() {
        return {
            usageId:this.$route.params.usageId,
            language:'lt',
            usage: {
                name:'',
                description:'',
            },
            getUsages: [],
            isLoading: true,
            errors:[],
        };
    },
    mounted(){
        this.usageInfo();
    },
    methods: {
        usageInfo(){
            let url = ROOT_URL+"usages/";
            axios.get(url + this.$route.params.usageId ).then((response)=>{
                this.usage = response.data.usage;
                this.isLoading = false
            }).catch((e) => {
                this.errorHandler(e.response.status, e.response.data.errors, e.response.statusText );
            }).finally(() => {
                this.isLoading = false;
            });
        },
        updateUsage( edit ) {
            this.isLoading = true;
            let url = ROOT_URL+"usages/";
            var formData = new FormData();
            formData.append("id", this.$route.params.usageId);
            formData.append("name", this.usage.name);
            formData.append("description", this.usage.description);
            formData.append("_method", 'PATCH');
            axios.post(url + this.$route.params.usageId, formData, {
                headers: {
                  "Content-Type": "multipart/form-data"
                }
            }).then((response) => {
                if( edit == 0 ) {
                    this.$router.push({name: 'usage_list'});
                }
                this.$swal({
                    position: 'top',
                    title: 'Usage updated',
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
                window.location.href = "{{ route('login') }}";
            }
        }
    }

}
</script>

