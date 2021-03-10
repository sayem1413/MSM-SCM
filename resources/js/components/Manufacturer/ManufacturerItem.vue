<template>
    <tbody>
        <tr v-for="(item, index) in manufacturers" :key="item.id">
            <td scope="row"> {{ index+1 }} </td>
            <td>{{ item.name }}</td>
            <td>
                <img :src="item.logo ? ROOT_URL+item.logo : '/site-default-data/demo.jpg'" alt width="50" height="50">
            </td>
            <td>
                <master-delete-component :item_id="item.id" :item_url="'manufacturers'" :item_list="'manufacturerList'" ></master-delete-component>
                <router-link :to="{ name: 'manufacturer_edit', params: { manufacturerId: item.id}}" class="float-right mr-3"><i class="fa fa-edit"></i></router-link>
            </td>
        </tr>
    </tbody>
</template>
<script>
import ROOT_URL from '../../config';
import MasterDeleteComponent from '../MasterDeleteComponent';
export default {
    name: "manufacturer-item",
    components: {
        MasterDeleteComponent
    },
    data: function() {
        return {
            ROOT_URL: ROOT_URL,
        };
    },
    props: ['manufacturers_data', 'manufacturers'],
}
</script>