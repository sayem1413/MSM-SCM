<template>
    <div class="row">
        <div class="col-md-8">
            <nav v-if="pagination && pagination.total > pagination.per_page" aria-label="Page navigation example">
                <ul class="pagination">
                    <li v-if="pagination.current_page<=1" class="disabled page-item">
                        <a class="page-link" href="javascript: void(0);">
                            First Page
                        </a>
                    </li>
                    <li class="page-item" v-else>
                        <a class="page-link" @click.prevent="getItemList(1)">
                            First Page
                        </a>
                    </li>

                    <li v-if="pagination.current_page<=1" class="disabled page-item">
                        <a class="page-link" href="javascript: void(0);">
                            Previous
                        </a>
                    </li>
                    <li class="page-item" v-else>
                        <a class="page-link" @click.prevent="getItemList(pagination.current_page-1)">
                            Previous
                        </a>
                    </li>

                    <li v-for="n in pagination.last_page" :key="n" class="page-item" :class="{active: n== pagination.current_page}">
                        <a v-if="n<=pagination.current_page+3 && n>=pagination.current_page-3" class="page-link" @click.prevent="getItemList(n)" href="#">
                            {{ n }}
                        </a>
                    </li>
                    <li v-if="pagination.current_page>=pagination.last_page" class="disabled page-item">
                        <a class="page-link" href="javascript: void(0);">
                            Next
                        </a>
                    </li>
                    <li class="page-item" v-else>
                        <a class="page-link" @click.prevent="getItemList(pagination.current_page+1)">
                            Next
                        </a>
                    </li>
                    <li v-if="pagination.current_page>=pagination.last_page" class="disabled page-item">
                        <a class="page-link" href="javascript: void(0);">
                            Last Page
                        </a>
                    </li>
                    <li class="page-item" v-else>
                        <a class="page-link" @click.prevent="getItemList(pagination.last_page)">
                            Last Page
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-md-4">
            <h6 class="mt-2">Displaying {{ pagination.from }} - {{  pagination.to  }} out of {{ pagination.total }}</h6>
        </div>
    </div>
</template>
<script>
import ROOT_URL from '../config';

export default {
    name: "pagination-component",
    props: ['pagination', 'item_list_type'],
    methods:{
        getItemList(pageNo = 1){
            pageNo = pageNo + "&page_length="+this.$store.state.page_length;
            this.$store.dispatch(this.item_list_type, pageNo)
            .then(() =>{
                this.isLoading = false;
            })
        },
    },
    // mounted(){
    //     console.log(this.pagination);
    // },
    // watch:{
    //     pagination: function( newPaginationValue ){
    //         this.pagination = newPaginationValue;
    //     }
    // },
}
</script>