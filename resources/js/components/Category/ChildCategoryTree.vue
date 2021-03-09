<template>
    <draggable :element="'ul'" :list="categories_data" class="list-group border-0" :options="draggableOptions" v-on:change="updateChildCategory">
        <li v-for="item in allCategories" :key="item.id" class="list-group-item m-1 border-0 text-dark">
            <i v-if="itemIds.indexOf( item.id ) !== -1" @click="hideCategory(item.id)" class="fa fa-chevron-down mr-2"></i>
            <i v-else @click="expandCategory(item.id)" class="fa fa-chevron-right mr-2"></i>
            {{ item.label }}
            <router-link :to="{ name: 'category_edit', params: { categoryId: item.id}}" class="text-info ml-3 mr-3">
                <i class="fa fa-edit"></i>
            </router-link>
            <category-delete :item_id="item.id" :item_url="'categories'" :item_list="'allCategoryList'" ></category-delete>
            <child-category-tree v-if="item.children && itemIds.indexOf( item.id ) !== -1" :allCategories="item.children" :categories_data="item.children" :parent_id="item.id" ></child-category-tree>
        </li>
    </draggable>
</template>
<script>
import ROOT_URL from '../../config';
import CategoryDelete from './CategoryDelete';
import draggable from 'vuedraggable';
export default {
    name: "child-category-tree",
    components: {
        'child-category-tree': this,
        CategoryDelete,
        draggable,
    },
    props: ['categories_data', 'allCategories', 'parent_id',],
    data: function() {
        return {
            draggableOptions:{
                group:{ name:'g1'},
                animation:200,
            },
            requestHandler: false,
            itemIds:[],
        };
    },
    methods:{
        expandCategory(itemId) {
            this.itemIds.push(itemId);
        },
        hideCategory(itemId) {
            const index = this.itemIds.indexOf(itemId);
            if (index > -1) {
                this.itemIds.splice(index, 1);
            }
        },
        updateChildCategory(e){
            let url = ROOT_URL+"update-child-category/";
            /* this.categories_data.map((category, index) => {
                category.position = index + 1;
            }); */
            if( this.requestHandler === true ) {
                return;
            }
            this.requestHandler = true;

            let childCategories = {
                childCategories: this.categories_data,
            }
            
            axios.post(url + this.parent_id, childCategories).then((response) => {
                this.requestHandler = false;
                this.$swal({
                    title: 'Updated',
                    text: 'Category position Updated Successfully!!',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'success',
                });
            })

        },
    }
}
</script>