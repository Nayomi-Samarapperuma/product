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
                                            <Link  :href="route('product.index')" class="breadcrumb-text">
                                           Product Management
                                            </Link>
                                        </li>
                                        <li class="breadcrumb-item active breadcrumb-text" aria-current="page">
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
                                     Basic Data</a>
                            </li>
                            <li hidden></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-10 col-md-10">
                    <div class="shadow card">
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="basic-data" role="tabpanel">
                                    <EditForm :productId="this.product.id" />
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
import axios from "axios";
import Swal from "sweetalert2";

import EditForm from "@/Pages/Products/Basic/EditForm.vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faHouse,
    faCircleInfo,
    faCartPlus,
    faDiamond,
} from "@fortawesome/free-solid-svg-icons";

export default {
    components: {
        AppLayout,
        Link,
        EditForm,
        library,
        axios,
        Swal

    },
    props: {
        product: Object,
    },
    data() {
        return {};
    },
    beforeMount() {
        library.add(faCircleInfo);
        library.add(faCartPlus);
        library.add(faDiamond);
        library.add(faHouse);
    },

};
</script>

<style lang="scss">
.breadcrumb-text {
    color: #6343e9 !important;
}

.nav-link.active {
    background-color: #6343e9 !important;
    color: #fff !important;
}
</style>
