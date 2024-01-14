<template>
        <div class="card-header">
            <h5>Test Report</h5>
        </div>

        <div class="card-body pt-2 mt-3">
            <form
                role="form text-left"
                @submit.prevent="updateTestReportData"
                enctype="multipart/form-data"
            >
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-lg-3 column__right___padding">
                                <label>NAME</label>
                            <div class="input-group">
                                <input
                                    type="text"
                                    id="inp_test_report_name"
                                    name="name"
                                    v-model="testReport.name"
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
                            <label>REQUIRED</label>
                            <select
                                class="form-control form-control-sm select2 select-required"
                                name="test_report_required"
                                id="inp_test_report_required"
                                v-model="testReport.required"
                                required
                            >
                                <option value="0">NO</option>
                                <option value="1">YES</option>
                            </select>
                            <small
                                v-if="validationErrors.required"
                                id="msg_required"
                                class="text-danger form-text text-error-msg error"
                                >{{ validationErrors.required }}</small
                            >
                        </div>

                        <div class="col-md-2 pt-1">
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

                <div class="row mx-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th :class="textClassHead">Name</th>
                                    <th :class="iconClassHead">Required</th>
                                    <th :class="textClassHead"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr  v-for="testReport in testReports" :key="testReport.id" :class="rowClass">
                                    <td :class="textClassBody">{{ testReport.name }}</td>
                                    <td :class="iconClassBody">
                                    <span v-if="testReport.required==0" class="badge badge-danger">No</span>
                                    <span v-if="testReport.required==1" class="badge badge-success">Yes</span>
                                    </td>
                                    <td :class="iconClassBody">
                                        <a href="javascript:void(0)" class="p-2" @click.prevent="deleteTestReport(testReport.id)">
                                            <i class="fas fa-trash text-ash text-center"></i>
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
                                                        pagination.current_page -
                                                            1
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
                                                    page ==
                                                        pagination.last_page ||
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
                                                        pagination.current_page +
                                                            1
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
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    components: {
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
            rowClass: 'cursor-pointer',

            search: null,
            page: 1,
            perPage: [100, 250, 500],
            pageCount: 100,
            pagination: {},

            testReport:{},
            testReports:[],
        };
    },
    beforeMount() {
        this.getTestReportData();
    },
    watch: {},
    methods: {
        async setPage(page) {
            this.page = page
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
                await axios.get(route('testreport.all',this.productId), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        'filter[search]': this.search,
                    }
                })
            ).data

            this.testReports = tableData.data
            this.pagination = tableData.meta
        },

        async getTestReportData() {
            const testReports = (
                await axios.get(route('testreport.all',this.productId))
            ).data
            this.testReports = testReports.data
            this.pagination = testReports.meta
        },
        async updateTestReportData() {
            this.resetValidationErrors();
            try {
                await axios.post(
                    route('testreport.update', this.productId),
                    this.testReport
                );
                this.testReport= {}
                this.reload()
                this.$root.notify.success({
                    title: "Success",
                    message: "Product updated successfully",
                });
            } catch (error) {
                this.convertValidationError(error.message);
            }
        },
        async deleteTestReport(id){
            try {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#C00202', // Green
                    cancelButtonColor: '#6CA925', // Secondary Color
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(route('testreport.delete',id));
                        this.reload();

                        // Swal.fire(
                        //     'Deleted!',
                        //     `Record has been deleted.`,
                        //     'success'
                        // )
                    }
                })
            } catch (error) {
                this.convertValidationNotification(error)
            }
        }
    },
};
</script>
