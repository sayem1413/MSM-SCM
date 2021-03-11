<template>
    <tbody>
          <tr v-for="(item, index) in usages" :key="item.id">
            <td scope="row"> {{ index+1 }} </td>
            <td>{{ item.name }}</td>
            <td>
                <master-delete-component :item_id="item.id" :item_url="'usages'" :item_list="'usageList'" ></master-delete-component>
                <router-link :to="{ name: 'usage_edit', params: { usageId: item.id}}" class="float-right mr-3"><i class="fa fa-edit"></i></router-link>
            </td>
        </tr>
    </tbody>
</template>
<script>
import ROOT_URL from '../../config';
import MasterDeleteComponent from '../MasterDeleteComponent';
export default {
    name: "usage-item",
    components: {
        MasterDeleteComponent
    },
    data: function() {
        return {
            ROOT_URL: ROOT_URL,
        };
    },
    props: ['usages_data', 'usages'],
}
</script>