import Dashboard from '../components/Dashboard/DashboardComponent.vue';

// import CategoryList from '../components/Category/CategoryList.vue';
// import CategoryAdd from '../components/Category/CategoryAdd.vue';
// import CategoryEdit from '../components/Category/CategoryEdit.vue';

// import ManufacturerList from '../components/Manufacturer/ManufacturerList.vue';
// import ManufacturerAdd from '../components/Manufacturer/ManufacturerAdd.vue';
// import ManufacturerEdit from '../components/Manufacturer/ManufacturerEdit.vue';

// import ColorList from '../components/Color/ColorList.vue';
// import ColorAdd from '../components/Color/ColorAdd.vue';
// import ColorEdit from '../components/Color/ColorEdit.vue';

// import MaterialList from '../components/Material/MaterialList.vue';
// import MaterialAdd from '../components/Material/MaterialAdd.vue';
// import MaterialEdit from '../components/Material/MaterialEdit.vue';

// import TechnicalConsultantList from '../components/TechnicalConsultant/TechnicalConsultantList.vue';
// import TechnicalConsultantAdd from '../components/TechnicalConsultant/TechnicalConsultantAdd.vue';
// import TechnicalConsultantEdit from '../components/TechnicalConsultant/TechnicalConsultantEdit.vue';

// import TagList from '../components/Tag/TagList.vue';
// import TagAdd from '../components/Tag/TagAdd.vue';
// import TagEdit from '../components/Tag/TagEdit.vue';

// import ProductList from '../components/Product/ProductList.vue';
// import ProductAdd from '../components/Product/ProductAdd.vue';
// import ProductDetails from '../components/Product/ProductDetails.vue';
// import ProductEdit from '../components/Product/ProductEdit.vue';
// import ProductInventory from '../components/Product/ProductInventory.vue';

// import InventoryList from '../components/Inventory/InventoryList.vue';
// import InventoryAdd from '../components/Inventory/InventoryAdd.vue';
// import InventoryLog from '../components/Inventory/InventoryLog.vue';

// import AdministrationList from '../components/Administration/AdministrationList.vue';
// import AdministrationAdd from '../components/Administration/AdministrationAdd.vue';
// import AdministrationEdit from '../components/Administration/AdministrationEdit.vue';

// import CustomerList from '../components/Customer/CustomerList.vue';
// import CustomerAdd from '../components/Customer/CustomerAdd.vue';
// import CustomerEdit from '../components/Customer/CustomerEdit.vue';

// import DiscountList from '../components/Discount/DiscountList.vue';
// import DiscountAdd from '../components/Discount/DiscountAdd.vue';
// import DiscountEdit from '../components/Discount/DiscountEdit.vue';

// import SliderImageList from '../components/SliderImage/SliderImageList.vue';
// import SliderImageAdd from '../components/SliderImage/SliderImageAdd.vue';
// import SliderImageEdit from '../components/SliderImage/SliderImageEdit.vue';
// import SliderSetting from '../components/SliderImage/SliderSetting.vue';

// import SettingUpdate from '../components/Setting/SettingUpdate.vue';

// import OrderList from '../components/Order/OrderList.vue';
// import OrderEdit from '../components/Order/OrderEdit.vue';
// import OrderDetail from '../components/Order/OrderDetail.vue';

// import ClosingManifest from '../components/ClosingManifest/ClosingManifest.vue';

// import StockNotificationSubscriberList from '../components/StockNotification/StockNotificationSubscriberList.vue';
// import ROOT_URL from '../config';

// let prefix = ROOT_URL + 'api';

export const routes = [
    {
        path: '/',
        component: Dashboard,
        name: 'dashboard',
    },
    {
        path: '/home',
        component: Dashboard,
        name: 'home',
    },
    // Multi level Category
    // {
    //     path: '/category/list',
    //     component: CategoryList,
    //     name: 'category_list',
    // },
    // {
    //     path: '/category/add',
    //     component: CategoryAdd,
    //     name: 'category_add',
    // },
    // {
    //     path: '/category/edit/:categoryId',
    //     component: CategoryEdit,
    //     name: 'category_edit',
    // },
    // // Manufacturer
    // {
    //     path: '/manufacturer/list',
    //     component: ManufacturerList,
    //     name: 'manufacturer_list',
    // },
    // {
    //     path: '/manufacturer/add',
    //     component: ManufacturerAdd,
    //     name: 'manufacturer_add',
    // },
    // {
    //     path: '/manufacturer/edit/:manufacturerId',
    //     component: ManufacturerEdit,
    //     name: 'manufacturer_edit',
    // },
    // // Color
    // {
    //     path: '/color/list',
    //     component: ColorList,
    //     name: 'color_list',
    // },
    // {
    //     path: '/color/add',
    //     component: ColorAdd,
    //     name: 'color_add',
    // },
    // {
    //     path: '/color/edit/:colorId',
    //     component: ColorEdit,
    //     name: 'color_edit',
    // },
    // // Materials
    // {
    //     path: '/material/list',
    //     component: MaterialList,
    //     name: 'material_list',
    // },
    // {
    //     path: '/material/add',
    //     component: MaterialAdd,
    //     name: 'material_add',
    // },
    // {
    //     path: '/material/edit/:materialId',
    //     component: MaterialEdit,
    //     name: 'material_edit',
    // },
    // // Technical Consultant
    // {
    //     path: '/technical-consultant/list',
    //     component: TechnicalConsultantList,
    //     name: 'technical_consultant_list',
    // },
    // {
    //     path: '/technical-consultant/add',
    //     component: TechnicalConsultantAdd,
    //     name: 'technical_consultant_add',
    // },
    // {
    //     path: '/technical-consultant/edit/:technicalConsultantId',
    //     component: TechnicalConsultantEdit,
    //     name: 'technical_consultant_edit',
    // },
    // // Tag
    // {
    //     path: '/tag/list',
    //     component: TagList,
    //     name: 'tag_list',
    // },
    // {
    //     path: '/tag/add',
    //     component: TagAdd,
    //     name: 'tag_add',
    // },
    // {
    //     path: '/tag/edit/:tagId',
    //     component: TagEdit,
    //     name: 'tag_edit',
    // },
    // // Tag
    // {
    //     path: '/product/list',
    //     component: ProductList,
    //     name: 'product_list',
    // },
    // {
    //     path: '/product/add',
    //     component: ProductAdd,
    //     name: 'product_add',
    // },
    // {
    //     path: '/product/edit/:productId/',
    //     component: ProductDetails,
    //     name: 'product_details',
    //     children: [
    //         {
    //             path: '/',
    //             component: ProductEdit,
    //             name: "product_edit"
    //         },
    //         {
    //             path: 'inventory',
    //             component: ProductInventory,
    //             name: 'product_inventory'
    //         }
    //     ]
    // },
    // // Inventory
    // {
    //     path: '/inventory/list',
    //     component: InventoryList,
    //     name: 'inventory_list',
    // },
    // {
    //     path: '/inventory/add',
    //     component: InventoryAdd,
    //     name: 'inventory_add',
    // },
    // {
    //     path: '/inventory/log',
    //     component: InventoryLog,
    //     name: 'inventory_log',
    // },
    // // Administration
    // {
    //     path: '/administration/list',
    //     component: AdministrationList,
    //     name: 'administration_list',
    // },
    // {
    //     path: '/administration/add',
    //     component: AdministrationAdd,
    //     name: 'administration_add',
    // },
    // {
    //     path: '/administration/edit/:administrationId',
    //     component: AdministrationEdit,
    //     name: 'administration_edit',
    // },
    // // Customer
    // {
    //     path: '/customer/list',
    //     component: CustomerList,
    //     name: 'customer_list',
    // },
    // {
    //     path: '/customer/add',
    //     component: CustomerAdd,
    //     name: 'customer_add',
    // },
    // {
    //     path: '/customer/edit/:customerId',
    //     component: CustomerEdit,
    //     name: 'customer_edit',
    // },
    // // Discount
    // {
    //     path: '/discount/list',
    //     component: DiscountList,
    //     name: 'discount_list',
    // },
    // {
    //     path: '/discount/add',
    //     component: DiscountAdd,
    //     name: 'discount_add',
    // },
    // {
    //     path: '/discount/edit/:discountId',
    //     component: DiscountEdit,
    //     name: 'discount_edit',
    // },
    // // Slider Image
    // {
    //     path: '/slider-image/list',
    //     component: SliderImageList,
    //     name: 'slider_image_list',
    // },
    // {
    //     path: '/slider-image/add',
    //     component: SliderImageAdd,
    //     name: 'slider_image_add',
    // },
    // {
    //     path: '/slider-image/edit/:sliderImageId',
    //     component: SliderImageEdit,
    //     name: 'slider_image_edit',
    // },
    // {
    //     path: '/slider-image/setting',
    //     component: SliderSetting,
    //     name: 'slider_setting',
    // },
    // // Settings
    // {
    //     path: '/settings-update',
    //     component: SettingUpdate,
    //     name: 'setting_update',
    // },
    // // Tag
    // {
    //     path: '/order/list',
    //     component: OrderList,
    //     name: 'order_list',
    // },
    // {
    //     path: '/order/detail/:orderId',
    //     component: OrderDetail,
    //     name: 'order_detail',
    // },
    // {
    //     path: '/order/edit/:orderId',
    //     component: OrderEdit,
    //     name: 'order_edit',
    // },
    // // Closing Manifest
    // {
    //     path: '/closing-manifest',
    //     component: ClosingManifest,
    //     name: 'closing_manifest',
    // },
    // // StockNotification
    // {
    //     path: '/stock-notification/subscribers',
    //     component: StockNotificationSubscriberList,
    //     name: 'stock_notification_subscribers'
    // }
];

// let routesWithPrefix = (prefix, routesWithoutPrefix) => {
//     return routesWithoutPrefix.map(route => {
//         route.path = `${prefix}${route.path}`
//         return route
//     })
// }

// export const routes = routesWithPrefix( prefix, routesWithoutPrefix );