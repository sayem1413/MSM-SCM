<style scoped>
.example {
  color: red;
}
</style>
<template>
    <tbody>
          <tr v-for="(item, index) in colors" :key="item.id">
            <td scope="row"> {{ index+1 }} </td>
            <td>{{ item.name }}</td>
            <td>{{ item.hex_code }}</td>
            <td>
                <div v-bind:style="'background-color: ' + item.hex_code + ' !important'" class="p-1 border border-dark">
                    {{ item.name }}
                </div>
            </td>
            <td>
                <master-delete-component :item_id="item.id" :item_url="'colors'" :item_list="'colorList'" ></master-delete-component>
                <router-link :to="{ name: 'color_edit', params: { colorId: item.id}}" class="float-right mr-3"><i class="fa fa-edit"></i></router-link>
            </td>
        </tr>
    </tbody>
</template>
<script>
import ROOT_URL from '../../config';
import MasterDeleteComponent from '../MasterDeleteComponent';

export default {
    name: "color-item",
    components: {
        MasterDeleteComponent
    },
    props: ['colors_data', 'colors'],
    data: function() {
        return {
            colorShow: [],
        };
    },
}
</script>