<template>
    <a href="#" class="ml-3 mr-3" @click.prevent="deleteItem(item_id)" ><i class="fa fa-trash-o"></i></a>
</template>
<script>
import ROOT_URL from '../../config';

export default {
    name: "category-delete",
    props: ['item_id', 'item_url', 'item_list'],
    methods:{
        deleteItem(id){
            this.$swal({
                title: 'Are you sure?',
                text: 'You can\'t revert your action',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes Delete it!',
                cancelButtonText: 'No, Keep it!',
                showCloseButton: true,
            }).then((result) => {
                if (result.value) {
                    let url = ROOT_URL+this.item_url+"/";
                    return  axios.delete(url + id).then((res) => {
                        this.$swal({
                            title: 'Deleted',
                            text: 'Your file has been deleted',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                        });
                        this.$store.dispatch( this.item_list );
                    })
                }
                else if ( result.dismiss === "cancel" ) {
                    this.$swal({
                        title: 'Cancelled',
                        text: 'Your file is safe :)',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'success',
                    })
                }
            })
            .catch((e) => {
                if( e.response.status === 422 || e.response.status === 500 || e.response.status === 404 ){
                    this.$swal({
                        position: 'top',
                        title: e.response.statusText,
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'error',
                    });
                }
                if( e.response.status === 401 ){
                    window.location.href = "{{ route('admin.login') }}";
                }
            });
            // this.$store.dispatch("deleteItem", "categories/", id, "categoryList" );

        },
    },
}
</script>