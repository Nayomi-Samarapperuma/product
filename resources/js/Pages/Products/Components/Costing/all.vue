<template>
    <div id="basic-info">
        <div class="card-header">
            <h5>Costing Data</h5>
        </div>
        <div class="pt-0 mt-3 card-body">
            <form role="form text-left pb-3" @submit.prevent="updateCostingData" enctype="multipart/form-data"
                id="purchasing-form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row ">
                            <div class="col-md-4 column__right___padding">
                                <label>PRODUCTS</label>
                                <Multiselect v-model="this.select_item" :options="items" :close-on-select="true"
                                    :showLabels="false" :clear-on-select="false" :searchable="true"
                                    placeholder="Select Product" label="name" track-by="id" />
                                <small v-if="validationErrors.item_id" id="msg_product_id"
                                    class="text-danger form-text text-error-msg error">{{ validationErrors.item_id
                                    }}</small>
                            </div>
                            <div class="col-md-3 column__right___padding column__left___padding">
                                <label>CONSUMPTION</label>
                                <input class="form-control form-control-sm" type="number" name="consumption"
                                    id="consumption" v-model="product.consumption" placeholder="Consumption" min="0" />
                                <small v-if="validationErrors.consumption" id="msg_consumption"
                                    class="text-danger form-text text-error-msg error">
                                    {{ validationErrors.consumption }}
                                </small>
                            </div>
                            <div class="col-md-4 column__right___padding column__left___padding">
                                <label>REMARK</label>
                                <input class="form-control form-control-sm" type="text" name="remark" id="remark"
                                    v-model="product.remark" placeholder="Remark" min="0" />
                                <small v-if="validationErrors.remark" id="msg_remark"
                                    class="text-danger form-text text-error-msg error">
                                    {{ validationErrors.remark }}
                                </small>
                            </div>
                            <div class="col-md-1 column__left___padding">
                                <div class="">
                                    <button type="submit" class="mt-4 btn btn-sm btn-round btn-outline-primary">
                                        <font-awesome-icon icon="fa-solid fa-circle-plus" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="mt-3 row">
                <div class="col-lg-12">
                    <div class="">
                        <div class="py-3 text-sm card-body">
                            <div class="flex">
                                <div class="flex items-center text-muted">
                                    Search:
                                    <div class="inline-block ml-2">
                                        <input type="text" class="form-control form-control-sm" v-model="search"
                                            @keyup="getSearch" />
                                    </div>
                                </div>
                                <div class="ml-auto text-muted">
                                    Show
                                    <div class="inline-block mx-2">
                                        <select class="form-control form-control-sm per-page-entry" :value="100"
                                            v-model="pageCount" @change="perPageChange">
                                            <option v-for="perPageCount in perPage" :key="perPageCount"
                                                :value="perPageCount" v-text="perPageCount" />
                                        </select>
                                    </div>
                                    entries
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th :class="textClassHead">Product</th>
                                        <th :class="valueClassHead">Consumption</th>
                                        <th :class="textClassHead">Remark</th>
                                        <th :class="textClassHead"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="costing in costings" :key="costing.id" :class="rowClass"
                                        @click.prevent="editcostings(costing.id)">
                                        <td :class="textClassBody">
                                            {{ costing.item_name }}
                                        </td>
                                        <td :class="valueClassBody">
                                            {{ costing.formate_consumption }}
                                        </td>
                                        <td :class="textClassBody">
                                            {{ costing.remark }}
                                        </td>
                                        <td :class="iconClassBody">
                                            <a href="javascript:void(0)" @click.prevent="deleteCostingData(costing.id)"
                                                class="p-2 float-end">
                                                <font-awesome-icon icon="fa-solid fa-trash" class="text-right text-ash" />
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="flex mt-1 card-footer table-footer align-items-center">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                                    Showing {{ pagination.from }} to
                                    {{ pagination.to }} of
                                    {{ pagination.total }} entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
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
                                                    <li class="page-item" :key="index"
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
                <div class="col-md-12 text-end">
                    <a href="javascript:void(0)" @click.prevent="printCosting"
                        class="mb-0 btn btn-sm btn-round btn-outline-info btn-md">
                        <font-awesome-icon icon="fa-solid fa-print" />
                        PRINT
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
import { Link } from "@inertiajs/vue3";
import Multiselect from "vue-multiselect";
import Swal from "sweetalert2";
import { library } from '@fortawesome/fontawesome-svg-core';
import { faPlusCircle, faTrash, faPrint } from '@fortawesome/free-solid-svg-icons';

export default {
    components: {
        Link,
        Multiselect,
        library,
    },
    props: {
        productId: {
            type: Number,
            required: true,
        },
    },
    setup() { },
    data() {
        return {
            textClassHead: "text-start text-uppercase",
            textClassBody: "text-start",
            valueClassBody: "text-end",
            valueClassHead: "text-end",
            iconClassHead: "text-end",
            iconClassBody: "text-end",
            rowClass: "cursor-pointer",

            search: null,
            page: 1,
            perPage: [100, 250, 500],
            pageCount: 100,
            pagination: {},

            product: {},
            select_item: null,
            items: [],
            costings: [],
        };
    },
    beforeMount() {
        library.add(faPlusCircle);
        library.add(faTrash);
        library.add(faPrint);
        this.getItems();
        this.getCostings();
    },
    watch: {
    },
    methods: {
        async setPage(page) {
            this.page = page;
            this.reload();
        },
        async getSearch() {
            this.reload();
        },
        async perPageChange() {
            this.reload();
        },
        async reload() {
            const tableData = (
                await axios.get(route("product.costing.all", this.productId), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                    },
                })
            ).data;

            this.costings = tableData.data;
            this.pagination = tableData.meta;
        },

        async getItems() {
            const items = (await axios.get(route("product.costing.getProducts", this.productId))).data;
            this.items = items;
        },
        async getCostings() {
            const tableData = (await axios.get(route("product.costing.all", this.productId))).data;
            this.costings = tableData.data;
            this.pagination = tableData.meta;
        },
        async updateCostingData() {
            this.resetValidationErrors();
            try {
                if (this.select_item) {
                    this.product.item_id = this.select_item.id;
                }
                await axios.post(route("product.costing.update", this.productId), this.product);
                this.reload();
                this.product = {};
                this.select_item = null;
                this.$root.notify.success({
                    title: "Success",
                    message: "Product costing created successfully",
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async deleteCostingData(id) {
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
                        axios.delete(route("product.costing.delete", id)).then((response) => {
                            this.reload();
                        });
                        Swal.fire(
                            "Deleted!",
                            `Product costing has been deleted.`,
                            "success"
                        );
                    }
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },

        async printCosting() {
            try {
                const print = await axios.get(route("product.costing.print", this.productId), {
                    responseType: 'blob'
                });
                const url = window.URL.createObjectURL(print.data);
                window.open(url, '_blank');
                // const blob = new Blob([print.data]);
                // const url = window.URL.createObjectURL(blob);
                // const link = document.createElement('a');
                // link.href = url;
                // link.download = 'costing.pdf';
                // link.click();

            } catch (error) {
                this.convertValidationNotification(error);
            }
        }
    },
};
</script>

<style lang="scss" scoped></style>
