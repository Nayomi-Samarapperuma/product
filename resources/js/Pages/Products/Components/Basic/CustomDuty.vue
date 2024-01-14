<template>
    <div class="card-header">
        <h5>Custom Duty</h5>
    </div>

    <div class="card-body pt-2 mt-3">
        <form
            role="form text-left"
            @submit.prevent="updateCustomDutData"
            enctype="multipart/form-data"
        >
            <div class="row mb-1">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-3 column__right___padding">
                            <label>NAME</label>
                            <div class="input-group">
                                <input
                                    type="text"
                                    id="inp_custom_duty_name"
                                    name="name"
                                    v-model="customDuty.name"
                                    class="form-control form-control-sm"
                                    placeholder="Name"
                                    aria-label="from"
                                    aria-describedby="from"
                                    required
                                />
                            </div>
                            <small
                                v-if="validationErrors.name"
                                id="msg_name"
                                class="text-danger form-text text-error-msg error"
                                >{{ validationErrors.name }}</small
                            >
                        </div>
                        <div class="col-lg-3 column__right___padding">
                            <label>TYPE</label>
                            <select
                                class="form-control form-control-sm select2 select-type"
                                name="type"
                                v-model="customDuty.type"
                                id="inp_custom_duty_type"
                                required
                            >
                                <!-- <option value=""></option> -->
                                <option value="0">By Total</option>
                                <option value="1">By Qty</option>
                            </select>
                            <small
                                v-if="validationErrors.type"
                                id="msg_type"
                                class="text-danger form-text text-error-msg error"
                                >{{ validationErrors.type }}</small
                            >
                        </div>
                        <div class="col-lg-3">
                            <label>RATE</label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    id="inp_custom_duty_rate"
                                    name="rate"
                                    class="form-control form-control-sm"
                                    v-model="customDuty.rate"
                                    placeholder="Rate"
                                    aria-label="conversion"
                                    min="0"
                                    step="any"
                                    aria-describedby="conversion"
                                    required
                                />
                            </div>
                            <small
                                v-if="validationErrors.rate"
                                id="msg_rate"
                                class="text-danger form-text text-error-msg error"
                                >{{ validationErrors.rate }}</small
                            >
                        </div>
                        <div class="col-lg-3 pt-1">
                            <div class="text-end">
                                <label for=""></label>
                                <div class="input-group">
                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline--info mt-3"
                                    >
                                        <i class="fa-solid fa-circle-plus"></i>
                                        ADD
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mx-0 mt-3">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th :class="textClassHead">Name</th>
                                <th :class="iconClassHead">Type</th>
                                <th
                                    :class="textClassHead"
                                    class="text_align_end"
                                >
                                    Rate
                                </th>
                                <th :class="textClassHead"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="customDuty in allCustomDuty"
                                :key="customDuty.id"
                                :class="rowClass"
                            >
                                <td :class="textClassBody">
                                    {{ customDuty.name }}
                                </td>
                                <td :class="iconClassBody">
                                    <span
                                        v-if="customDuty.type == 0"
                                        class="badge badge-info"
                                        >By Total</span
                                    >
                                    <span
                                        v-if="customDuty.type == 1"
                                        class="badge badge-success"
                                        >By QTY</span
                                    >
                                </td>
                                <td
                                    :class="textClassBody"
                                    class="text_align_end"
                                >
                                    {{ customDuty.rate }}
                                </td>
                                <td :class="iconClassBody">
                                    <a
                                        href="javascript:void(0)"
                                        class="p-2"
                                        @click.prevent="
                                            deleteCustomDuty(customDuty.id)
                                        "
                                    >
                                        <i
                                            class="fas fa-trash text-ash text-center"
                                        ></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    class="flex mt-1 card-footer table-footer align-items-center w-100"
                >
                    <div class="col-md-6">
                        <div
                            class="dataTables_info"
                            id="DataTables_Table_0_info"
                            role="status"
                            aria-live="polite"
                        >
                            Showing {{ pagination.from }} to
                            {{ pagination.to }} of
                            {{ pagination.total }} entries
                        </div>
                    </div>
                    <div class="col-md-6 ml-auto">
                        <div
                            class="dataTables_paginate paging_simple_numbers"
                            id="DataTables_Table_0_paginate"
                        >
                            <nav
                                aria-label="Page navigation"
                                style="float: right"
                            >
                                <ul class="pagination">
                                    <li
                                        class="page-item"
                                        :class="
                                            pagination.current_page == 1
                                                ? 'disabled'
                                                : ''
                                        "
                                    >
                                        <a
                                            class="page-link"
                                            href="javascript:void(0)"
                                            @click="
                                                setPage(
                                                    pagination.current_page - 1
                                                )
                                            "
                                        >
                                            <i
                                                class="fa-solid fa-angles-left"
                                            ></i>
                                        </a>
                                    </li>
                                    <template
                                        v-for="(
                                            page, index
                                        ) in pagination.last_page"
                                    >
                                        <template
                                            v-if="
                                                page == 1 ||
                                                page == pagination.last_page ||
                                                Math.abs(
                                                    page -
                                                        pagination.current_page
                                                ) < 5
                                            "
                                        >
                                            <li
                                                class="page-item"
                                                :key="index"
                                                :class="
                                                    pagination.current_page ==
                                                    page
                                                        ? 'active'
                                                        : ''
                                                "
                                            >
                                                <a
                                                    class="page-link"
                                                    @click="setPage(page)"
                                                    >{{ page }}</a
                                                >
                                            </li>
                                        </template>
                                    </template>
                                    <li
                                        class="page-item"
                                        :class="
                                            pagination.current_page ==
                                            pagination.last_page
                                                ? 'disabled'
                                                : ''
                                        "
                                    >
                                        <a
                                            class="page-link"
                                            href="javascript:void(0)"
                                            @click="
                                                setPage(
                                                    pagination.current_page + 1
                                                )
                                            "
                                        >
                                            <i
                                                class="fa-solid fa-angles-right"
                                            ></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import axios from "axios";
import Swal from "sweetalert2";

export default {
    components: {
        Multiselect,
    },
    props: {
        productId: {
            type: Number,
            required: true,
        },
    },
    setup() {},
    data() {
        return {
            textClassHead: "text-start text-uppercase",
            textClassBody: "text-start",
            iconClassHead: "text-center",
            iconClassBody: "text-center",
            valueClassHead: "text-right",
            valueClassBody: "text-right",
            rowClass: "cursor-pointer",

            search: null,
            page: 1,
            perPage: [100, 250, 500],
            pageCount: 100,
            pagination: {},

            allCustomDuty: [],
            customDuty: {},
        };
    },
    beforeMount() {
        this.getCustomDutyData();
    },
    watch: {},
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
                await axios.get(route("units.all", this.productId), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                    },
                })
            ).data;

            this.measurements = tableData.data;
            this.pagination = tableData.meta;
        },

        async getCustomDutyData() {
            const allCustomDuty = (
                await axios.get(route("customeduty.all", this.productId))
            ).data;
            this.allCustomDuty = allCustomDuty.data;
            this.pagination = allCustomDuty.meta;
        },
        async updateCustomDutData() {
            this.resetValidationErrors();
            try {
                await axios.post(
                    route("customeduty.update", this.productId),
                    this.customDuty
                );
                this.customDuty = {};
                this.reload();
                this.$root.notify.success({
                    title: "Success",
                    message: "Product Custom Duty updated successfully",
                });
                this.getCustomDutyData();
            } catch (error) {
                this.convertValidationError(error.message);
            }
        },
        async deleteCustomDuty(id) {
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
                        axios.delete(route("customeduty.delete", id)).then((result)=>{
                            this.getCustomDutyData();
                        })

                        // Swal.fire(
                        //     "Deleted!",
                        //     `Record has been deleted.`,
                        //     "success"
                        // );
                    }
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
    },
};
</script>
