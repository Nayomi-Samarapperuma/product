<template>
    <AppLayout title="Products-Edit">
        <template #header>
            <div class="pb-6 header">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="py-4 row align-items-center">
                            <div class="col-lg-6">
                                <h6 class="mb-0 h2 text-dark d-inline-block">
                                    Product Management
                                </h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-block">
                                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                        <li class="breadcrumb-item">
                                            <Link href="/">
                                            <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                            </Link>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <Link :href="`/products`" class="text-purple">
                                                Product Management
                                            </Link>
                                        </li>
                                        <li class="breadcrumb-item active text-info" aria-current="page">
                                            #{{ this.product.code }}
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #content>
            <div class="mt-4 row">
                <div class="col-lg-2 col-md-2">
                    <div class="nav-wrapper-loc">
                        <ul class="nav nav-pills nav-fill flex-column" id="tabs-icons-text" role="tablist">
                            <li class="mb-2 nav-item">
                                <a class="nav-link active" id="basic-data-tab" data-toggle="tab" href="#basic-data"
                                    role="tab" aria-controls="basic-data" aria-selected="true">
                                    Basic Info
                                </a>
                            </li>
                            <li class="mb-2 nav-item">
                                <a class="nav-link" id="purchasing-data-tab" data-toggle="tab" href="#purchasing-data"
                                    role="tab" aria-controls="purchasing-data" aria-selected="true">
                                    Purchasing Data</a>
                            </li>
                            <li class="mb-2 nav-item">
                                <a class="nav-link" id="contact-book-tab" data-toggle="tab" href="#vendor-data" role="tab"
                                    aria-controls="contact-book" aria-selected="true">
                                    Vendor Data</a>
                            </li>
                            <li class="mb-2 nav-item">
                                <a class="nav-link" id="contact-book-tab" data-toggle="tab" href="#mrp-data" role="tab"
                                    aria-controls="contact-book" aria-selected="true">
                                    MRP Data</a>
                            </li>
                            <li class="mb-2 nav-item">
                                <a class="nav-link" id="contact-book-tab" data-toggle="tab" href="#classification-data"
                                    role="tab" aria-controls="contact-book" aria-selected="true">
                                    Classification</a>
                            </li>
                            <li class="mb-2 nav-item">
                                <a class="nav-link" id="contact-book-tab" data-toggle="tab" href="#trade-data-tab"
                                    role="tab" aria-controls="contact-book" aria-selected="true">
                                    Foreign Trade</a>
                            </li>
                            <li class="mb-2 nav-item">
                                <a class="nav-link" id="contact-book-tab" data-toggle="tab" href="#custom-duty-tab"
                                    role="tab" aria-controls="contact-book" aria-selected="true">
                                    Custom Duty</a>
                            </li>
                            <li class="mb-2 nav-item">
                                <a class="nav-link" id="contact-book-tab" data-toggle="tab" href="#test-report-tab"
                                    role="tab" aria-controls="contact-book" aria-selected="true">
                                    Test Report</a>
                            </li>
                            <li class="mb-2 nav-item">
                                <a class="nav-link" id="contact-book-tab" data-toggle="tab" href="#warehouse-data-tab"
                                    role="tab" aria-controls="contact-book" aria-selected="true">
                                    Warehouse Data</a>
                            </li>
                            <li hidden></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-10 col-md-10">
                    <div class="shadow card">
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="active tab-pane fade show" id="basic-data" role="tabpanel">
                                    <BasicAll :productId="this.product.id" />
                                </div>
                                <div class="tab-pane fade show" id="purchasing-data" role="tabpanel">
                                    <PurchasingData :productId="this.product.id" />
                                </div>
                                <div class="tab-pane fade show" id="vendor-data" role="tabpanel">
                                    <VendorData :productId="this.product.id" />
                                </div>
                                <div class="tab-pane fade show" id="mrp-data" role="tabpanel">
                                    <MrpData :productId="this.product.id" />
                                </div>
                                <div class="tab-pane fade show" id="classification-data" role="tabpanel">
                                    <ClassificationData :productId="this.product.id" />
                                </div>
                                <div class="tab-pane" id="trade-data-tab">
                                    <ForeignTradeEditForm :productId="this.product.id" />
                                </div>
                                <div class="tab-pane" id="custom-duty-tab">
                                    <CustomDutyAll :productId="this.product.id" />
                                </div>
                                <div class="tab-pane" id="test-report-tab">
                                    <TestReportAll :productId="this.product.id" />
                                </div>
                                <div class="tab-pane" id="warehouse-data-tab">
                                    <WarehouseDataEditForm :productId="this.product.id" />
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
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import axios from "axios";
import Swal from "sweetalert2";

import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faHouse,
    faCircleInfo,
    faCartPlus,
    faDiamond,
} from "@fortawesome/free-solid-svg-icons";

import BasicAll from "@/Pages/Products/Components/Basic/all.vue";
import PurchasingData from "@/Pages/Products/Components/Basic/PurchasingData.vue";

import VendorData from "@/Pages/Products/Components/Basic/VendorData.vue";
import MrpData from "@/Pages/Products/Components/Basic/MrpData.vue";
import ClassificationData from "@/Pages/Products/Components/Basic/ClassificationData.vue";
import ForeignTradeEditForm from "@/Pages/Products/Components/Basic/ForeignTrade.vue";
import CustomDutyAll from "@/Pages/Products/Components/Basic/CustomDuty.vue";
import TestReportAll from "@/Pages/Products/Components/Basic/TestReport.vue";
import WarehouseDataEditForm from "@/Pages/Products/Components/Basic/WarehouseData.vue";

// import CostingAll from '@/Pages/Products/Components/Costing/all.vue';

export default {
    components: {
        AppLayout,
        Link,
        computed,
        usePage,
        axios,
        Swal,
        BasicAll,
        PurchasingData,
        VendorData,
        MrpData,
        ClassificationData,
        ForeignTradeEditForm,
        CustomDutyAll,
        TestReportAll,
        WarehouseDataEditForm,
        library,
    },
    props: {
        product: Object,
    },
    // setup() {
    //     const product = computed(() => usePage().props.value.product)
    //     return { product }
    // },
    data() {
        return {};
    },
    beforeMount() {
        library.add(faCircleInfo);
        library.add(faCartPlus);
        library.add(faDiamond);
        library.add(faHouse);
    },
    watch: {},
    methods: {},
};
</script>

<style lang="scss"></style>
