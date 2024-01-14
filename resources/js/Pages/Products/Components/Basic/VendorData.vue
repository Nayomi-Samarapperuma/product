<template>
    <div id="basic-info">
        <div class="card-header">
            <h5>Vendor Data</h5>
        </div>
        <div class="card-body pt-2 mt-3">
            <form role="form text-left" @submit.prevent="updateVendorData" enctype="multipart/form-data">
                <div class="row mb-1">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-lg-3 column__right___padding">
                                <label>NAME</label>
                                <input class="form-control form-control-sm" type="text" name="name" step="any" id="inp_name"
                                    placeholder="Name" min="0" v-model="vendor_data.name" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                </small>
                            </div>
                            <div class="col-lg-3 column__right___padding">
                                <label for="uom">PURCHASE UOM</label>
                                <Multiselect v-model="this.select_uom" :options="unit_of_measures" :showLabels="false"
                                    :close-on-select="true" :clear-on-select="false" :searchable="true"
                                    placeholder="Select Unit" label="name" track-by="id" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                </small>
                            </div>
                            <div class="col-lg-3 column__right___padding">
                                <label>UNIT COUNT</label>
                                <input class="form-control form-control-sm" type="number" name="unit_count" step="any"
                                    id="inp_unit_count" placeholder="Unit Count" min="0" v-model="vendor_data.unit_count" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                </small>
                            </div>
                            <div class="col-lg-3">
                                <label>Cost</label>
                                <input class="form-control form-control-sm" type="number" name="cost" step="any"
                                    id="inp_cost" placeholder="Cost" min="0" v-model="vendor_data.cost" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-lg-3 column__right___padding">
                                <label>PROJECTED PRICE</label>
                                <input class="form-control form-control-sm" type="number" name="projected_price" step="any"
                                    id="inp_projected_price" placeholder="Projected Price" min="0"
                                    v-model="vendor_data.projected_price" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                </small>
                            </div>
                            <div class="col-lg-3 column__right___padding">
                                <label>MIN QTY</label>
                                <input class="form-control form-control-sm" type="number" name="min_qty" step="any"
                                    id="inp_min_qty" placeholder="Min QTY" min="0" v-model="vendor_data.min_qty" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                </small>
                            </div>
                            <div class="col-lg-3 column__right___padding">
                                <label>REMARK</label>
                                <input class="form-control form-control-sm" type="text" name="remark" step="any"
                                    id="inp_remark" placeholder="Remark" min="0" v-model="vendor_data.remark" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                </small>
                            </div>
                            <div class="col-lg-3 column__right___padding">
                                <label>FILES</label>
                                <input type="file" ref="file" class="form-control form-control-sm" @input="
                                    vendor_data.photo =
                                    $event.target.files[0]
                                    " />
                                <div class="error">
                                    <small v-if="validationErrors.photo"
                                        class="mt-1 text-sm text-danger form-text text-error-msg error">
                                        {{ validationErrors.photo }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end d-flex justify-content-end">
                    <button type="submit" class="btn btn-sm btn-round btn-outline--info mb-2">
                        <font-awesome-icon icon="fa-solid fa-circle-plus" />
                        ADD
                    </button>
                </div>

                <div class="row mx-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th :class="textClassHead">Name</th>
                                    <th :class="textClassHead">UOM</th>
                                    <th :class="iconClassHead">File</th>
                                    <th :class="textClassHead" class="text_align_end">Unit Count</th>
                                    <th :class="textClassHead" class="text_align_end">Cost</th>
                                    <th :class="textClassHead" class="text_align_end">
                                        Projected Price
                                    </th>
                                    <th :class="textClassHead" class="text_align_end">Min QTY</th>
                                    <th :class="textClassHead">Remark</th>
                                    <th :class="iconClassHead"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="vendor in product_vendor" :key="vendor.id" :class="rowClass">
                                    <td :class="textClassBody">
                                        {{ vendor.name }}
                                    </td>
                                    <td :class="textClassBody">
                                        {{ vendor.uom_name }}
                                    </td>
                                    <td :class="iconClassBody">

                                        <label v-if="vendor.image == null" class="badge bg_info text-white fw-bold"
                                            type="button">No File</label>

                                        <a :href=vendor.img_url target="_blank"><button v-if="vendor.image !== null"
                                                class="badge bg_info text-white fw-bold view_btn" type="button">View</button></a>

                                    </td>
                                    <td :class="textClassBody" class="text_align_end">
                                        {{ vendor.unit_count }}
                                    </td>
                                    <td :class="textClassBody" class="text_align_end">
                                        {{ vendor.cost }}
                                    </td>
                                    <td :class="textClassBody" class="text_align_end">
                                        {{ vendor.projected_price }}
                                    </td>
                                    <td :class="textClassBody" class="text_align_end">
                                        {{ vendor.min_qty }}
                                    </td>
                                    <td :class="textClassBody">
                                        {{ vendor.remark }}
                                    </td>
                                    <td :class="iconClassBody" class="text-end">
                                        <a href="javascript:void(0)" @click.prevent="deleteVendorItem(vendor.id)"
                                            class="p-2 ">
                                            <font-awesome-icon icon="fa-solid fa-trash" class="text-ash" />
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import Multiselect from "vue-multiselect";
import Swal from "sweetalert2";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faHouse,
    faFloppyDisk,
    faXmark,
    faPlusCircle,
    faTrash,
} from "@fortawesome/free-solid-svg-icons";

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
            iconClassHead: "text-center",
            iconClassBody: "text-center",
            valueClassHead: "text-right",
            valueClassBody: "text-right",

            unit_of_measures: [],
            select_uom: null,
            vendor_data: {},
            product_vendor: [],
        };
    },
    beforeMount() {
        library.add(faFloppyDisk);
        library.add(faPlusCircle);
        library.add(faXmark);
        library.add(faTrash);
        this.getUnitOfMeasures();
        this.getVendorData();
    },
    watch: {},
    methods: {
        async getUnitOfMeasures() {
            const unit_of_measures = (await axios.get(route("units.all")))
                .data;
            this.unit_of_measures = unit_of_measures.data;
        },

        clearImageField() {
            this.$refs.file.value = ''; // Reset the value of the file input field
            this.vendor_data.photo = null; // Clear the selected photo in the data object
        },

        async getVendorData() {
            const vendor_data = (await axios.get(route("product.vendor_data.get", this.productId))).data;
            this.vendor_data = vendor_data.data;

            const select_uom = (
                await axios.get(
                    route("units.all", this.vendor_data.uom)
                )
            ).data;
            this.select_uom = select_uom.data;

            console.log(this.vendor_data);
        },

        async getVendorData() {

            if (this.vendor_data.uom != null) {
                const select_uom = (
                    await axios.get(route("units.all", this.vendor_data.uom))
                ).data;
                this.select_uom = select_uom.data;
            }

            const tableData = (
                await axios.get(
                    route("product.vendor_data.get", this.productId)
                )
            ).data;

            this.product_vendor = tableData.data;
            this.pagination = tableData.meta;
            console.log("vendor", this.product_vendor);
        },

        async reload() {
            const tableData = (
                await axios.get(route("product.vendor_data.get", this.productId), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                    },
                })
            ).data;

            this.product_vendor = tableData.data;
            this.pagination = tableData.meta;
        },

        async updateVendorData() {
            this.resetValidationErrors();
            try {
                if (this.select_uom) {
                    this.vendor_data.uom = this.select_uom.id;
                }
                await axios.post(
                    route("product.vendor_data.update", this.productId),
                    this.vendor_data,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );
                this.vendor_data = {};
                this.select_uom = null,
                    this.reload();
                this.clearImageField();
                this.$root.notify.success({
                    title: "Success",
                    message: "Product Vendor Data updated successfully",
                });
            } catch (error) {
                this.convertValidationError(error);
                this.convertValidationNotification(error);
            }
        },

        async deleteVendorItem(id) {
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
                        axios.delete(route("products.vendor_data.delete", id)).then((response) => {
                            this.getVendorData();
                        });
                        // Swal.fire("Deleted!", `Item has been deleted.`, "success");
                    }
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.view_btn {
    background-color: rgb(40, 168, 72) !important;
}

.bg_info {
    background-color: #5b61f7;
}
</style>
