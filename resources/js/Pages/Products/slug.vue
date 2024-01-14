<template>
    <AppLayout title="Product Management">
        <template #header>
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body row">
                        <div class="col-lg-8 align-items-center py-4">
                            <h6 class="h2 text-dark d-inline-block mb-0">Product Management</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-block ">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item">
                                        <Link href="/">
                                        <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                        </Link>
                                    </li>
                                    <li class="breadcrumb-item active breadcrumb-text" aria-current="page">
                                        Product Management
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-4 text-right py-4" v-if="can('create_products')">
                            <a href="javascript:void(0)" @click.prevent="newProduct"
                            class="btn btn-sm btn-neutral float-end">
                                <font-awesome-icon icon="fa-solid fa-circle-plus" /> ADD NEW
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #content>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="row my-3 mx-2">
                            <div class="col-md-2 column__right___padding">
                                <div for="purchase_uom" class="col-form-label">
                                    CODE
                                </div>
                                <input type="text" class="form-control form-control-sm" name="code" id="code"
                                    v-model="search_product.code" placeholder="Code" @keyup="getSearch" />
                            </div>
                            <div class="col-md-2 column__right___padding column__left___padding">
                                <div for="purchase_uom" class="col-form-label">
                                    BARCODE
                                </div>
                                <input type="text" class="form-control form-control-sm" name="barcode" id="barcode"
                                    v-model="search_product.barcode" placeholder="Barcode" @keyup="getSearch" />
                            </div>
                            <div class="col-md-3 column__right___padding column__left___padding">
                                <div for="purchase_uom" class="col-form-label">
                                    PRODUCT NAME
                                </div>
                                <input type="text" class="form-control form-control-sm" name="name" id="name"
                                    v-model="search_product.name" placeholder="product Name" @keyup="getSearch" />
                            </div>
                            <div class="col-md-3 column__left___padding">
                                <div for="purchase_uom" class="col-form-label">
                                    CATEGORY
                                </div>
                                <Multiselect v-model="this.select_search_category" :options="all_cat" class="z__index"
                                    :showLabels="false" :close-on-select="true" :clear-on-select="false" @change="getSearch"
                                    :searchable="true" placeholder="Select Category" label="full_name" track-by="id" />
                            </div>
                            <div class="col-md-1 mt-4 column__left___padding">
                                <a href="javascript:void(0)" @click.prevent="clearFilters"
                                    class="btn btn-sm btn-ash float-end mt-2 pt-2">
                                    CLEAR
                                </a>
                            </div>

                            <div class="text-muted ml-auto mx-4 mt-4">
                                <div class="inline-block">
                                    <select class="form-control form-control-sm per-page-entry mt-2 " :value="100"
                                        v-model="pageCount" @change="perPageChange">
                                        <option v-for="perPageCount in perPage" :key="perPageCount" :value="perPageCount"
                                            v-text="perPageCount" />
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mx-4">
                            <div class="table-responsive">
                                <div class="d-flex flex-row mb-3 rounded">
                                    <div class="left d-flex">
                                        <div class="p-2 border icon_item">
                                            <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-clone"
                                                color="#505050" />
                                        </div>
                                        <div class="p-2 border icon_item">
                                            <font-awesome-icon class="icon_item-icon"
                                                icon="fa-solid fa-arrow-up-from-bracket" color="#505050" />
                                        </div>
                                        <div class="p-2 border icon_item">
                                            <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-cloud-arrow-down"
                                                color="#505050" />
                                        </div>
                                        <div class="p-2 border icon_item">
                                            <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-wrench"
                                                rotation="{270}" color="#505050" />
                                        </div>
                                        <div class="p-2 border icon_item" v-if="can('active_products')">
                                            <a @click.prevent="
                                                activeSelectedItems(
                                                    checkMatirialTypeItems
                                                )
                                                ">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-check"
                                                    color="#0bd018" />
                                            </a>
                                        </div>
                                        <div class="p-2 border icon_item" v-if="can('inactive_products')">
                                            <a @click.prevent="
                                                inactiveSelectedItems(
                                                    checkMatirialTypeItems
                                                )
                                                ">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-minus"
                                                    color="#eb0505" />
                                            </a>
                                        </div>
                                        <div class="p-2 border icon_item" v-if="this.checkMatiItems.length > 0 && can('create_products')">
                                            <a href="javascript:void(0)" @click.prevent="
                                                deleteSelectedItems(
                                                    checkMatiItems
                                                )
                                                ">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-trash"
                                                    color="#eb0505" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="right d-flex ml-auto">
                                        <div class="p-2 border icon_item">
                                            <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-print"
                                                color="#505050" />
                                        </div>
                                        <!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#newProductModal">
                                            <div class="p-2 border icon_item">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-square-plus"
                                                    color="#306ed9" />
                                            </div>
                                        </a> -->
                                    </div>
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input" type="checkbox" @click="selectAll"
                                                    v-if="this.products.length > 0"  :checked="this.checkMatiItems.length>0" v-model="checkAllItems" />
                                                </div>
                                            </th>
                                            <th :class="iconClassHead" class="pl-0">STATUS</th>
                                            <th :class="textClassHead">Code</th>
                                            <th :class="textClassHead">Name</th>
                                            <th :class="textClassHead">Barcode</th>
                                            <th :class="valueClassHead" class="text_align_end">Cost</th>
                                            <th :class="valueClassHead" class="text_align_end">Selling Price</th>
                                            <th :class="textClassHead">Purchase UOP</th>
                                            <th :class="textClassHead">Stock UOP</th>
                                            <th :class="textClassHead">Size</th>
                                            <th :class="textClassHead">Category</th>
                                            <th :class="textClassHead">Type</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="product in products" :key="product.id" :class="rowClass">
                                            <td class="pt-2">
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input" type="checkbox" v-model="checkMatiItems"
                                                        v-bind:value="product" v-bind:id="product.id" />
                                                </div>
                                            </td>
                                            <td :class="iconClassBody" class="pt-2 pl-0">
                                                <label v-if="product.status == 1"
                                                    class="badge bg-success text-white fw-bold">Active</label>
                                                <label v-if="product.status == 0"
                                                    class="badge bg-warning text-white fw-bold">Deactive</label>
                                            </td>
                                            <td :class="textClassBody" class="pt-2">
                                                {{ product.code }}
                                                <span class="ml-1" v-if="product.stock_qty <=
                                                product.rol
                                                    ">
                                                    <font-awesome-icon color="#FF5733" icon="fa-solid fa-flag" />
                                                </span>
                                            </td>
                                            <td :class="textClassBody" class="pt-2">
                                                {{ product.name }}
                                            </td>
                                            <td :class="textClassBody" class="pt-2">
                                                {{ product.barcode }}
                                            </td>
                                            <td :class="valueClassBody" class="pt-2 text_align_end">
                                                {{ formatPrice(product.cost) }}
                                            </td>
                                            <td :class="valueClassBody" class="pt-2 text_align_end">
                                                {{
                                                    formatPrice(
                                                        product.selling_price
                                                    )
                                                }}
                                            </td>
                                            <td :class="textClassBody" class="pt-2">
                                                {{ product.purchase_uom_name }}
                                            </td>
                                            <td :class="textClassBody" class="pt-2">
                                                {{ product.stock_uom_name }}
                                            </td>
                                            <td :class="textClassBody" class="pt-2">
                                                {{ product.size }}
                                            </td>
                                            <td :class="textClassBody" class="pt-2">
                                                {{ product.category_name }}
                                            </td>
                                            <td :class="textClassBody" class="pt-2">
                                                {{ product.type_name }}
                                            </td>

                                            <td :class="textClassBody">
                                                <a href="javascript:void(0)" @click.prevent="
                                                    editProducts(
                                                        product.id
                                                    )
                                                    ">
                                                    <font-awesome-icon icon="fa-solid fa-pen" class="text-ash" />
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="flex mt-1 card-footer table-footer px-3 mx-1 align-items-center">
                            <div class="col-sm-12 col-md-6 p-0">
                                <div class="dataTables_info column__left___padding" id="DataTables_Table_0_info"
                                    role="status" aria-live="polite">
                                    Showing {{ pagination.from }} to
                                    {{ pagination.to }} of
                                    {{ pagination.total }} entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 p-0">
                                <div class="dataTables_paginate paging_simple_numbers  column__right___padding"
                                    id="DataTables_Table_0_paginate">
                                    <nav aria-label="Page navigation" style="float: right">
                                        <ul class="pagination">
                                            <li class="page-item" :class="pagination.current_page == 1 ? 'disabled' : ''">
                                                <a class="page-link" href="javascript:void(0)"
                                                    @click="setPage(pagination.current_page - 1)">
                                                    <i class="fa-solid fa-angles-left"></i>
                                                </a>
                                            </li>
                                            <template v-for="(page, index) in pagination.last_page">
                                                <template
                                                    v-if="page == 1 || page == pagination.last_page || Math.abs(page - pagination.current_page) < 5">
                                                    <li class="page-item " :key="index"
                                                        :class="pagination.current_page == page ? 'active' : ''">
                                                        <a class="page-link" @click="setPage(page)">{{ page }}</a>
                                                    </li>
                                                </template>
                                            </template>
                                            <li class="page-item"
                                                :class="pagination.current_page == pagination.last_page ? 'disabled' : ''">
                                                <a class="page-link" href="javascript:void(0)"
                                                    @click="setPage(pagination.current_page + 1)">
                                                    <i class="fa-solid fa-angles-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #modals>
            <div class="modal fade" id="newProductModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="newProductModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder text-info text-gradient" id="add_brandLabel">
                                New Product
                            </h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <font-awesome-icon icon="fa-solid fa-xmark" />
                                </span>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="card-plain">
                                <div class="card-body m-3">
                                    <form role="form text-left" @submit.prevent="createProduct"
                                        enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="code" class="col-md-2 col-form-label">
                                                CODE
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control form-control-sm" name="code"
                                                    id="code" v-model="product.code" placeholder="Code" required />
                                                <small v-if="validationErrors.code" id="msg_code"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.code
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-2 col-form-label">
                                                NAME
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="product.name" placeholder="Name" required />
                                                <small v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.name
                                                    }}</small>
                                            </div>
                                        </div>
                                        <!-- <div class="row mb-1">
                                            <div for="barcode" class="col-md-2 col-form-label">BARCODE</div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control form-control-sm" name="barcode"
                                                    id="barcode" v-model="product.barcode" placeholder="Barcode">
                                                <small v-if="validationErrors.barcode" id="msg_barcode"
                                                    class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.barcode }}</small>
                                            </div>
                                        </div> -->
                                        <div class="row mb-1">
                                            <div for="description" class="col-md-2 col-form-label">
                                                DESCRIPTION
                                            </div>
                                            <div class="col-md-10">
                                                <textarea type="text" class="form-control form-control-sm"
                                                    name="description" id="description" v-model="product.description
                                                            " placeholder="Description"></textarea>
                                                <small v-if="validationErrors.description
                                                    " id="msg_description"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.description
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="cost" class="col-md-2 col-form-label">
                                                COST
                                            </div>
                                            <div class="col-md-10">
                                                <input type="number" step="any" class="form-control form-control-sm"
                                                    name="cost" id="cost" v-model="product.cost" placeholder="Cost" />
                                                <small v-if="validationErrors.cost" id="msg_cost"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.cost
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="selling_price" class="col-md-2 col-form-label">
                                                SELLING PRICE
                                            </div>
                                            <div class="col-md-10">
                                                <input type="number" step="any" class="form-control form-control-sm"
                                                    name="selling_price" id="selling_price" v-model="product.selling_price
                                                            " placeholder="Selling Price" />
                                                <small v-if="validationErrors.selling_price
                                                    " id="selling_price"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.selling_price
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="purchase_uom" class="col-md-2 col-form-label">
                                                PURCHASE UOM
                                            </div>
                                            <div class="col-md-10">
                                                <Multiselect v-model="this.select_purchase_uom
                                                        " :options="units" :showLabels="false" :close-on-select="true"
                                                    :clear-on-select="false" :searchable="true" placeholder="Select Unit"
                                                    label="name" track-by="id" />
                                                <small v-if="validationErrors.purchase_uom
                                                    " id="msg_purchase_uom"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.purchase_uom
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="stock_uom" class="col-md-2 col-form-label">
                                                STOCK UOM
                                            </div>
                                            <div class="col-md-10">
                                                <Multiselect v-model="this.select_stock_uom
                                                        " :options="units" :showLabels="false" :close-on-select="true"
                                                    :clear-on-select="false" :searchable="true" placeholder="Select Unit"
                                                    label="name" track-by="id" />
                                                <small v-if="validationErrors.stock_uom
                                                    " id="msg_stock_uom"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.stock_uom
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="type" class="col-md-2 col-form-label">
                                                TYPE
                                            </div>
                                            <div class="col-md-10">
                                                <Multiselect v-model="this.select_type" :options="productTypes"
                                                    :showLabels="false" :close-on-select="true" :clear-on-select="false"
                                                    :searchable="true" placeholder="Select Type" label="name"
                                                    track-by="id" />
                                                <small v-if="validationErrors.type" id="msg_type"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.type
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="category_id" class="col-md-2 col-form-label">
                                                CATEGORY
                                            </div>
                                            <div class="col-md-10">
                                                <Multiselect v-model="this
                                                            .select_category_level_1
                                                        " :options="categories" :showLabels="false"
                                                    :close-on-select="true" :clear-on-select="false" :searchable="true"
                                                    placeholder="Select Category" label="name" track-by="id" />
                                                <small v-if="validationErrors.category
                                                    " class="mt-1 text-sm text-danger form-text text-error-msg error">
                                                    {{
                                                        validationErrors.category
                                                    }}</small>
                                            </div>
                                        </div>

                                        <div class="text-end mt-2" v-if="can('create_products')">
                                            <button type="submit"
                                                class="btn btn-outline--info btn-sm btn-round mb-3 float-right mt-2">
                                                <font-awesome-icon icon="fa-solid fa-floppy-disk" />
                                                CREATE
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { library } from '@fortawesome/fontawesome-svg-core';
import {
    faHouse,
    faFloppyDisk,
    faCirclePlus,
    faClone,
    faCloudArrowDown,
    faSquarePlus,
    faPrint,
    faWrench,
    faCircleCheck,
    faCircleMinus,
    faTrash,
    faArrowUpFromBracket,
    faXmark,
    faPenToSquare,
    faPen,
} from "@fortawesome/free-solid-svg-icons";

export default {
    components: {
        AppLayout,
        Link,
        library,
        Multiselect,
    },
    props: {
        slug: Object,
    },
    data() {
        return {
            textClassHead: "text-start text-uppercase",
            textClassBody: "text-start",
            valueClassBody: "text-right",
            valueClassHead: "text-right",
            iconClassHead: "text-center",
            iconClassBody: "text-center",
            rowClass: "cursor-pointer",

            search: null,
            page: 1,
            perPage: [25, 50, 100],
            pageCount: 25,
            pagination: {},

            product: {},
            select_purchase_uom: null,
            select_stock_uom: null,
            units: [],
            select_type: null,
            categories: [],
            categoriesL2: [],
            categoriesL3: [],
            categoriesL4: [],
            select_category_level_1: null,
            select_category_level_2: null,
            select_category_level_3: null,
            select_category_level_4: null,
            productTypes: [],

            all_cat: [],
            select_search_category: null,
            search_product: {},

            select_search_vendor: null,
            vendors: [],

            products: [],
            checkMatiItems: [],
            checkAllItems: false,
        };
    },
    beforeMount() {
        library.add(faHouse);
        library.add(faFloppyDisk);
        library.add(faCirclePlus);
        library.add(faClone);
        library.add(faCloudArrowDown);
        library.add(faSquarePlus);
        library.add(faPrint);
        library.add(faArrowUpFromBracket);
        library.add(faWrench);
        library.add(faCircleCheck);
        library.add(faCircleMinus);
        library.add(faTrash);
        library.add(faXmark);
        library.add(faPenToSquare);
        library.add(faPen);
        //this.getProductTypes();
        this.getCategoriesLevel1();
        this.getUOPs();
        this.getProducts();
        this.getCategories();
    },
    watch: {

        checkAllItems(value) {
            this.products.forEach((item, index) => {
                if (index !== 0) {
                    item.selected = value;
                }
            });
            if (this.checkMatiItems.length == this.products.length) {
                this.checkMatiItems = [];
            } else {
                this.checkMatiItems = this.products;
            }
        },
        checkMatiItems(value) {
            if (this.checkMatiItems.length != this.products.length) {
                this.checkAllItems = false;
            }
        },

        select_category_level_1: function (val) {
            val ? this.getCategoriesLevel2(val) : '';
        },
        select_category_level_2: function (val) {
            val ? this.getCategoriesLevel3(val) : '';
        },
        select_category_level_3: function (val) {
            val ? this.getCategoriesLevel4(val) : '';
        },
        select_search_category: function () {
            this.select_search_category ? this.search_product.category = this.select_search_category.id : this.search_product.category = null;
            this.getSearch();
        }
    },
    methods: {
        // onSearchVendor(search, loading) {
        //     if (search.length) {
        //         loading = true;
        //         this.searchVendor(loading, search, this);
        //     }
        // },
        // searchVendor: _.debounce((loading, search, vm) => {
        //     axios.get(route("vendors.all"), {
        //         params: {
        //             "filter[search]": search,
        //         },
        //     }).then(res => {
        //         // console.log(res.data.data)
        //         vm.vendors = res.data.data;
        //         loading = false;
        //     });
        // }, 250),

        formatPrice(value) {
            let val = (value / 1).toFixed(2).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },

        async setPage(page) {
            this.page = page;
            this.reload();
        },
        async getSearch() {
            this.page = 1;
            this.reload();
        },
        async perPageChange() {
            this.reload();
        },
        async reload() {
            this.$root.loader.start();
            const tableData = (
                await axios.get(route("product.all"), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                        search_product_code: this.search_product.code,
                        search_product_barcode: this.search_product.barcode,
                        search_product_name: this.search_product.name,
                        search_product_category: this.search_product.category,
                    },
                })
            ).data;

            this.products = tableData.data;
            this.pagination = tableData.meta;
            this.$root.loader.finish();
        },

        async getUOMs() {
            const units = (await axios.get(route("units.all"))).data;
            this.units = units.data;
        },
        async getProductTypes() {
            const productTypes = (await axios.get(route("productType.all"))).data;
            this.productTypes = productTypes.data;
        },
        async getCategories() {
            const all_cat = (await axios.get(route('productCategory.all.list'))).data
            this.all_cat = all_cat;
        },
        // async getCategoriesLevel2(id) {
        //     const categoriesL2 = (await axios.get(route('productCategory.level2.all', id))).data
        //     this.categoriesL2 = categoriesL2;
        // },
        // async getCategoriesLevel3(id) {
        //     const categoriesL3 = (await axios.get(route('productCategory.level3.all', id))).data
        //     this.categoriesL3 = categoriesL3;
        // },
        // async getCategoriesLevel4(id) {
        //     const categoriesL4 = (await axios.get(route('productCategory.level4.all', id))).data
        //     this.categoriesL4 = categoriesL4;
        //},
        async getCategoriesLevel1() {
            const categories = (await axios.get(route('productCategory.level1.all'))).data
            this.categories = categories;
        },
        async getProducts() {
            this.$nextTick(() => {
                this.$root.loader.start();
            });
            const tableData = (await axios.get(route("product.all.slug", this.slug))).data;
            this.products = tableData.data;
            this.pagination = tableData.meta;
            this.$nextTick(() => {
                this.$root.loader.finish();
            });
        },
        async createProduct() {
            this.resetValidationErrors();
            try {
                if (this.select_purchase_uop) {
                    this.product.purchase_uop = this.select_purchase_uom.id;
                }
                if (this.select_stock_uop) {
                    this.product.stock_uop = this.select_stock_uom.id;
                }
                if (this.select_type) {
                    this.product.type = this.select_type.id;
                }
                if (this.select_category_level_1) {
                    this.product.category = this.select_category_level_1.id;
                }
                if (this.select_category_level_1) {
                    this.product.category_l1_id =this.select_category_level_1.id;
                }
                if (this.select_search_vendor) {
                    this.product.vendor = this.select_search_vendor.name;
                    this.product.vendor_id = this.select_search_vendor.id;
                }
                if (!this.product.barcode) {
                    this.product.barcode = this.product.code;
                }
                const product = (
                    await axios.post(route("product.store"), this.product)
                ).data;
                // console.log(product.id);
                $("#newProductModal").modal("hide");
                window.location.href = route("product.edit", product.id);
                this.reload();
                this.product = {};
                this.select_category_level_4 = null;
                this.select_category_level_3 = null;
                this.select_category_level_2 = null;
                this.select_category_level_1 = null;
                this.select_purchase_uom = null;
                this.select_stock_uom = null;
                this.select_type = null;
                this.$root.notify.success({
                    title: "Success",
                    message: "Product created successfully",
                });
            } catch (error) {
                this.convertValidationNotification(error);
                this.convertValidationError(error);
            }
        },
        async editProducts(productId) {
            // this.$inertia.visit(route('product.edit', productId));
            window.location.href = route('product.edit', productId);
        },
        async clearFilters() {
            console.log("first");
            this.search_product = {};
            this.select_search_category = null;
            this.reload();
        },
        async newProduct(){
            this.$root.loader.start();
            this.product = {};
            this.validationErrors = {};
            $("#newProductModal").modal("show");
            this.$root.loader.finish();
        },


        async deleteSelectedItems(checkMatiItems) {
            this.$root.loader.start();
            try {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#C00202", // Green
                    cancelButtonColor: "#6CA925", // Secondary Color
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        const ids = this.checkMatiItems.map(
                            (product) => product.id
                        );
                        axios
                            .post(route("products.delete.selected"), { ids })
                            .then((response) => {
                                this.reload();
                            });
                        Swal.fire(
                            "Deleted!",
                            `Product has been deleted.`,
                            "success"
                        );
                    }
                });
                this.$root.loader.finish();
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async activeSelectedItems(checkMatiItems) {
            this.$nextTick(() => {
                this.$root.loader.start();
            });
            const ids = this.checkMatiItems.map((product) => product.id);
            axios
                .post(route("products.active.selected"), { ids })
                .then((response) => {
                    this.checkMatiItems = [];
                    this.getProducts();
                });
            this.$nextTick(() => {
                this.$root.loader.finish();
            });
        },

        async inactiveSelectedItems(checkMatiItems) {
            this.$nextTick(() => {
                this.$root.loader.start();
            });
            const ids = this.checkMatiItems.map((product) => product.id);
            axios
                .post(route("products.inactive.selected"), { ids })
                .then((response) => {
                    this.checkMatiItems = [];
                    this.getProducts();
                });
            this.$nextTick(() => {
                this.$root.loader.finish();
            });
        },
    },
}
</script>

<style lang="scss" scoped>
.breadcrumb-text {
    color: #6343e9 !important;
}
</style>
