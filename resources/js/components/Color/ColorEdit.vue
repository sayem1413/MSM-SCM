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
                                    <span class="font-weight-bold">Color Edit</span>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <ul class="nav nav-tabs float-right">
                                        <li class="nav-item">
                                            <router-link :to="{name:'color_list'}" class="nav-link text-light bg-info font-weight-bold">Back to List</router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <form class="form-horizontal" method="post">
                                    <div class="form-group row">
                                        <div class="col-md-12 col-sm-12">
                                            <label class="font-weight-bold">Name</label>
                                            <input class="form-control" v-model="color.name" type="text" name="name"/>
                                            <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-8 col-sm-8 mb-2">
                                            <label class="font-weight-bold">Hexa Code</label>
                                            <input class="form-control" v-model="color.hex_code" type="text" name="hex_code"/>
                                            <span class="text-danger" v-if="errors.hex_code">{{ errors.hex_code[0] }}</span>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <div v-bind:style="'background-color: ' + color.hex_code + ' !important'" class="p-5 border border-dark">
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12 col-sm-12">
                                            <router-link :to="{name:'color_list'}" class="btn btn-secondary btn-lg btn-sm">Cancle</router-link>
                                            <button class="btn btn-secondary btn-lg btn-sm" type="button" @click.prevent="updateColor(0)">Update & List</button>
                                            <button class="btn btn-secondary btn-lg btn-sm" type="button" @click.prevent="updateColor(1)">Update & Edit</button>
                                        </div>
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
    name: 'color_edit',
    components: {
        ClipLoader,
    },
    data: function() {
        return {
            colorId:this.$route.params.colorId,
            color: {
                name:'',
                hex_code:'',
            },
            getColors: [],
            isLoading: true,
            errors:[],
        };
    },
    mounted(){
        this.getColorInfo();
    },
    methods: {
        getColorInfo(){
            let url = ROOT_URL+"colors/";
            axios.get(url + this.$route.params.colorId )
                .then((response)=>{
                    this.color = response.data.color;
                    this.isLoading = false
                }).catch((e) => {
                    this.errorHandler(e.response.status, e.response.data.errors, e.response.statusText );
                }).finally(() => {
                    this.isLoading = false;
                });
        },
        updateColor( edit ) {
            this.isLoading = true;
            let url = ROOT_URL+"colors/";
            var updatedColor = {
                id: this.$route.params.colorId,
                name:  this.color.name,
                hex_code: this.color.hex_code,
                _method: 'PATCH',
            };
            
            axios.post(url + this.$route.params.colorId, updatedColor).then((response) => {
                if( edit == 0 ) {
                    this.$router.push({ name: "color_list" });
                }
                this.$swal({
                    position: 'top',
                    title: 'Color Updated',
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

