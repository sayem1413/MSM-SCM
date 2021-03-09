import ROOT_URL from '../config';

export default {
    state:{
        allCategories:[],
        categories:[],
        manufacturers:[],
        colors:[],
        materials:[],
        technicalConsultants:[],
        tags:[],
        products:[],
        inventorylogs:[],
        administrations:[],
        customers:[],
        discounts:[],
        sliderImages:[],
        sliderImages:[],
        stockNotificationSubscribers:[],
        page_length:10,
    },
    getters:{
        getAllCategories(state){
            return state.allCategories
        },
        getCategories(state){
            return state.categories
        },
        getManufacturers(state){
            return state.manufacturers
        },
        getColors(state){
            return state.colors
        },
        getMaterials(state){
            return state.materials
        },
        getTechnicalConsultants(state){
            return state.technicalConsultants
        },
        getTags(state){
            return state.tags
        },
        getProducts(state){
            return state.products
        },
        getInventorylogs(state){
            return state.inventorylogs
        },
        getAdministrations(state){
            return state.administrations
        },
        getCustomers(state){
            return state.customers
        },
        getDiscounts(state){
            return state.discounts
        },
        getSliderImages(state){
            return state.sliderImages
        },
        getStockNotificationSubscribers(state){
            return state.stockNotificationSubscribers
        },
    },
    actions:{
        allCategoryList(context, request = '?id=0' ){
            let url = ROOT_URL+"all-categories" + request;
            axios.get(url)
                .then((response)=>{
                    context.commit('setAllCategories',response.data.all_categories);
                })
        },
        categoryList(context, pageNo = 1){
            let url = ROOT_URL+"categories";
            axios.get(url)
                .then((response)=>{
                    context.commit('setCategories',response.data.categories.data);
                })
        },
        manufacturerList(context, pageNo = 1 ){
            let url = ROOT_URL+"manufacturers?page="+pageNo;
            axios.get(url)
                .then((response)=>{
                    context.commit('setManufacturers',response.data.all_manufacturers);
                })
        },
        colorList(context, pageNo = 1 ){
            let url = ROOT_URL+"colors?page="+pageNo;
            axios.get(url)
                .then((response)=>{
                    context.commit('setColors',response.data.colors);
                })
        },
        materialList(context, pageNo = 1 ){
            let url = ROOT_URL+"materials?page="+pageNo;
            axios.get(url)
                .then((response)=>{
                    context.commit('setMaterials',response.data.materials);
                })
        },
        technicalConsultantList(context, pageNo = 1 ){
            let url = ROOT_URL+"technical-consultants?page="+pageNo;
            axios.get(url)
                .then((response)=>{
                    context.commit('setTechnicalConsultants',response.data.technicalConsultants);
                })
        },
        tagList(context, pageNo = 1 ){
            let url = ROOT_URL+"tags?page="+pageNo;
            axios.get(url)
                .then((response)=>{
                    context.commit('setTags',response.data.tags);
                })
        },
        productList(context, pageNo = 1 ){
            let url = ROOT_URL+"products?page="+pageNo;
            axios.get(url)
                .then((response)=>{
                    context.commit('setProducts',response.data.products);
                })
        },
        inventoryLogList(context, pageNo = 1 ){
            let url = ROOT_URL+"inventorylogs?page="+pageNo;
            axios.get(url)
                .then((response)=>{
                    context.commit('setInventoryLogs',response.data.inventorylogs);
                })
        },
        administrationList(context, pageNo = 1 ){
            let url = ROOT_URL+"administrations?page="+pageNo;
            axios.get(url)
                .then((response)=>{
                    context.commit('setAdministrations',response.data.administrations);
                })
        },
        customerList(context, pageNo = 1 ){
            let url = ROOT_URL+"customers?page="+pageNo;
            axios.get(url)
                .then((response)=>{
                    context.commit('setCustomers',response.data.customers);
                })
        },
        discountList(context, pageNo = 1 ){
            let url = ROOT_URL+"discounts?page="+pageNo;
            axios.get(url)
                .then((response)=>{
                    context.commit('setDiscounts',response.data.discounts);
                })
        },
        sliderImageList(context, pageNo = 1 ){
            let url = ROOT_URL+"slider-images?page="+pageNo;
            axios.get(url)
                .then((response)=>{
                    context.commit('setSliderImages',response.data.sliderImages);
                })
        },
        stockNotificationSubscriberList( context, pageNo = 1 ) {
            let url = ROOT_URL+"get-stock-subscribers?page="+pageNo;
            axios.get(url)
                .then((response)=>{
                    context.commit('setStockNotificationSubscribers',response.data.stockNotifications);
                })
        }
    },
    mutations:{
        setAllCategories(state,data){
            return state.allCategories = data
        },
        setCategories(state,data){
            return state.categories = data
        },
        setManufacturers(state,data){
            return state.manufacturers = data
        },
        setColors(state,data){
            return state.colors = data
        },
        setMaterials(state,data){
            return state.materials = data
        },
        setTechnicalConsultants(state,data){
            return state.technicalConsultants = data
        },
        setTags(state,data){
            return state.tags = data
        },
        setProducts(state,data){
            return state.products = data
        },
        setInventoryLogs(state,data){
            return state.inventorylogs = data
        },
        setAdministrations(state,data){
            return state.administrations = data
        },
        setCustomers(state,data){
            return state.customers = data
        },
        setDiscounts(state,data){
            return state.discounts = data
        },
        setSliderImages(state,data){
            return state.sliderImages = data
        },
        setStockNotificationSubscribers( state,data ) {
            return state.stockNotificationSubscribers = data
        },
        setPageLength( state, data ){
            return state.page_length = data
        }
    }
}