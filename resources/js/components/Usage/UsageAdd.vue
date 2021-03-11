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
                                    <span class="font-weight-bold">Usage Class Add</span>
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
                                    <button class="btn btn-secondary btn-lg btn-sm" type="button" @click.prevent="addUsage(0)">Save & List</button>
                                    <button class="btn btn-secondary btn-lg btn-sm" type="button" @click.prevent="addUsage(1)">Save & Edit</button>
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

export default {
    name: 'usage_add',
    components: {
        ClipLoader,
    },
    data: function() {
        return {
            usage: {
                name:'',
                description:'',
                image:'',
            },
            getUsages: [],
            isLoading: false,
            errors:[],
        };
    },
    methods: {
        addUsage( edit ) {
            this.isLoading = true;
            let url = ROOT_URL+"usages";
            var formData = new FormData();
            formData.append("name", this.usage.name);
            formData.append("description", this.usage.description);
            
            axios.post(url, formData, {
                headers: {
                  "Content-Type": "multipart/form-data"
                }
            }).then((response) => {
                if( edit == 1 ){
                    this.$router.push({name: 'usage_edit', params: { usageId: response.data.data.id}});
                } else {
                    this.$router.push({name: 'usage_list'});
                }
                this.$swal({
                    position: 'top',
                    title: 'usage Added',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'success',
                });
                console.log(response.data)
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

