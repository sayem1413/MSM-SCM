<template>
    <tbody>
          <tr v-for="(item, index) in materials" :key="item.id">
            <td scope="row"> {{ index+1 }} </td>
            <td>{{ item.name }}</td>
            <td>
                <master-delete-component :item_id="item.id" :item_url="'materials'" :item_list="'materialList'" ></master-delete-component>
                <router-link :to="{ name: 'material_edit', params: { materialId: item.id}}" class="float-right mr-3"><i class="fa fa-edit"></i></router-link>
            </td>
        </tr>
    </tbody>
</template>
<script>
import ROOT_URL from '../../config';
import MasterDeleteComponent from '../MasterDeleteComponent';
export default {
    name: "material-item",
    components: {
        MasterDeleteComponent
    },
    data: function() {
        return {
            ROOT_URL: ROOT_URL,
        };
    },
    props: ['materials_data', 'materials'],
}
</script>