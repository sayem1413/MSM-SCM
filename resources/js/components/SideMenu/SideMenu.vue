<template>
    <ul class="app-menu">
        <li>
            <router-link :to="{ name: 'dashboard'}" class="app-menu__item" v-bind:class="{ active: isDashboardActive }" ><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'category_list'}" class="app-menu__item" v-bind:class="{ active: isCategoryActive }" ><i class="app-menu__icon fa fa-th-list"></i><i class="fas fa-layer-group"></i><span class="app-menu__label">Category</span></router-link>
        </li>
        <!-- <li>
            <router-link :to="{ name: 'manufacturer_list'}" class="app-menu__item" v-bind:class="{ active: isManufacturerActive }" ><i class="app-menu__icon fa fa-industry"></i><span class="app-menu__label">Manufacturer</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'color_list'}" class="app-menu__item" v-bind:class="{ active: isColorActive }" ><i class="app-menu__icon fa fa-tint"></i><span class="app-menu__label">Color</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'material_list'}" class="app-menu__item" v-bind:class="{ active: isMaterialActive }" ><i class="app-menu__icon fa fa-medium"></i><span class="app-menu__label">Material</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'technical_consultant_list'}" class="app-menu__item" v-bind:class="{ active: isTechnicalConsultantActive }" ><i class="app-menu__icon fa fa-assistive-listening-systems"></i><span class="app-menu__label">Sales Manager</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'tag_list'}" class="app-menu__item" v-bind:class="{ active: isTagActive }" ><i class="app-menu__icon fa fa-hashtag"></i><span class="app-menu__label">Tag</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'product_list'}" class="app-menu__item" v-bind:class="{ active: isProductActive }" ><i class="app-menu__icon fa fa-product-hunt"></i><span class="app-menu__label">Product</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'inventory_list'}" class="app-menu__item" v-bind:class="{ active: isInventoryActive }" ><i class="app-menu__icon fa fa-file-o"></i><span class="app-menu__label">Inventory</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'administration_list'}" class="app-menu__item" v-bind:class="{ active: isAdministrationActive }" ><i class="app-menu__icon fa fa-user-secret"></i><span class="app-menu__label">Administration</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'customer_list'}" class="app-menu__item" v-bind:class="{ active: isCustomerActive }" ><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Customers</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'discount_list'}" class="app-menu__item" v-bind:class="{ active: isDiscountActive }" ><i class="app-menu__icon fa fa-cut"></i><span class="app-menu__label">Discount</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'order_list'}" class="app-menu__item" v-bind:class="{ active: isOrderActive }" ><i class="app-menu__icon fa fa-first-order"></i><span class="app-menu__label">Order</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'closing_manifest'}" class="app-menu__item" v-bind:class="{ active: isClosingManifest }" ><i class="app-menu__icon fa fa-sticky-note"></i><span class="app-menu__label">Create Shipping Label</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'stock_notification_subscribers'}" class="app-menu__item" v-bind:class="{ active: isStockNotificationSubscribers }" ><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Stock Notification Subscribers</span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'slider_image_list'}" class="app-menu__item" v-bind:class="{ active: isSliderImageActive }" ><i class="app-menu__icon fa fa-sliders"></i><span class="app-menu__label">Home Slider Image </span></router-link>
        </li>
        <li>
            <router-link :to="{ name: 'setting_update'}" class="app-menu__item" v-bind:class="{ active: isSettingsActive }" ><i class="app-menu__icon fa fa-sliders"></i><span class="app-menu__label">Settings </span></router-link>
        </li> -->
    </ul>
</template>
<script>

export default {
    name: 'SideMenu',
    computed: {
        isDashboardActive(){
            let route = this.$route.name;
            return route === 'dashboard';
        },
        isCategoryActive(){
            let route = this.$route.name;
            return route === 'category_list' || route === 'category_add' || route === 'category_edit';
        },
        // isManufacturerActive(){
        //     let route = this.$route.name;
        //     return route === 'manufacturer_add' || route === 'manufacturer_edit' || route === 'manufacturer_list';
        // },
        // isColorActive(){
        //     let route = this.$route.name;
        //     return route === 'color_list' || route === 'color_add' || route === 'color_edit';
        // },
        // isMaterialActive(){
        //     let route = this.$route.name;
        //     return route === 'material_list' || route === 'material_add' || route === 'material_edit';
        // },
        // isTechnicalConsultantActive(){
        //     let route = this.$route.name;
        //     return route === 'technical_consultant_list' || route === 'technical_consultant_add' || route === 'technical_consultant_edit';
        // },
        // isTagActive(){
        //     let route = this.$route.name;
        //     return route === 'tag_list' || route === 'tag_add' || route === 'tag_edit';
        // },
        // isProductActive(){
        //     let route = this.$route.name;
        //     return route === 'product_list' || route === 'product_add' || route === 'product_edit' || route === 'product_inventory';
        // },
        // isInventoryActive(){
        //     let route = this.$route.name;
        //     return route === 'inventory_list' || route === 'inventory_add' || route === 'inventory_log';
        // },
        // isAdministrationActive(){
        //     let route = this.$route.name;
        //     return route === 'administration_list' || route === 'administration_add' || route === 'administration_edit';
        // },
        // isCustomerActive(){
        //     let route = this.$route.name;
        //     return route === 'customer_list' || route === 'customer_add' || route === 'customer_edit';
        // },
        // isDiscountActive(){
        //     let route = this.$route.name;
        //     return route === 'discount_list' || route === 'discount_add' || route === 'discount_edit';
        // },
        // isSliderImageActive(){
        //     let route = this.$route.name;
        //     return route === 'slider_image_list' || route === 'slider_image_add' || route === 'slider_image_edit';
        // },
        // isSettingsActive(){
        //     let route = this.$route.name;
        //     return route === 'setting_update';
        // },
        // isOrderActive(){
        //     let route = this.$route.name;
        //     return route === 'order_list' || route === 'order_detail' || route === 'order_edit';
        // },
        // isClosingManifest(){
        //     let route = this.$route.name;
        //     return route === 'closing_manifest';
        // },
        // isStockNotificationSubscribers(){
        //     let route = this.$route.name;
        //     return route === 'stock_notification_subscribers';
        // }
    },
    
}
</script>
