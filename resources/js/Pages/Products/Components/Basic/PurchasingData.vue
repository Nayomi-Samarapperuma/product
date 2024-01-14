<template>
    <div id="basic-info">
        <div class="card-header">
            <h5>Purchasing Data</h5>
        </div>
        <div class="card-body pt-2 mt-3">
            <form role="form text-left" @submit.prevent="updatePurchasingData" enctype="multipart/form-data">

                <div class="row mb-1">

                    <div for="uom" class="col-md-2 col-form-label">
                        BASE UOM
                    </div>
                    <div class="col-md-7">
                        <Multiselect v-model="this.select_uom" :options="unit_of_measures" :showLabels="false"
                            :close-on-select="true" :clear-on-select="false" :searchable="true" placeholder="Select UOM"
                            label="name" track-by="id" />
                    </div>
                    <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                        {{ validationErrors.unit_of_measure_id }}
                    </small>

                </div>
                <div class="row mb-1">
                    <div for="unit" class="col-md-2 col-form-label">
                        DIMENSION
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-lg-4 column__right___padding">
                                <label>Waste (%)</label>
                                <input class="form-control form-control-sm" type="number" name="wastage" step="any"
                                    id="inp_wastage" placeholder="%" min="0" v-model="purchasing_data.wastage" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.wastage }}
                                </small>
                            </div>
                            <div class="col-lg-4 column__right___padding">
                                <label>UNDER DELIVERY (%)</label>
                                <input class="form-control form-control-sm" type="number" name="under_delivery" step="any"
                                    id="inp_under_delivery" placeholder="%" min="0"
                                    v-model="purchasing_data.under_delivery" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.under_delivery }}
                                </small>
                            </div>
                            <div class="col-lg-4">
                                <label>OVER DELIVERY (%)</label>
                                <input class="form-control form-control-sm" type="number" name="over_delivery" step="any"
                                    id="inp_over_delivery" placeholder="%" min="0"
                                    v-model="purchasing_data.over_delivery" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.over_delivery }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="row mb-1">
                    <div for="unit" class="col-md-2 col-form-label">
                        ORDER BY
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-lg-4 column__right___padding">
                                <label>Size</label>
                                <select class="form-control form-control-sm" name="is_size" id="is_size"
                                    v-model="purchasing_data.is_size">
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
                                </select>
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error"></small>
                            </div>
                            <div class="col-lg-4 column__right___padding">
                                <label>Color</label>
                                <select class="form-control form-control-sm" name="is_color" id="is_color"
                                    v-model="purchasing_data.is_color">
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
                                </select>
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error"></small>
                            </div>
                            <div class="col-lg-4">
                                <label>Schedule</label>
                                <select class="form-control form-control-sm" name="is_schedule" id="is_schedule"
                                    v-model="purchasing_data.is_schedule">
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
                                </select>
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error"></small>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="row mb-1">
                    <div for="unit" class="col-md-2 col-form-label">
                        REMINDERS
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-lg-4 column__right___padding">
                                <label>REMINDER IN DAYS</label>
                                <input class="form-control form-control-sm" type="number" name="reminder_1" step="any"
                                    id="inp_reminder1" placeholder="Enter number of days" min="0"
                                    v-model="purchasing_data.reminder_1" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error"></small>
                            </div>
                            <!-- <div class="col-lg-4 column__right___padding">
                                <label>2ND REMINDER IN DAYS</label>
                                <input class="form-control form-control-sm" type="number" name="reminder_2" step="any"
                                    id="inp_reminder2" placeholder="Enter number of days" min="0"
                                    v-model="purchasing_data.reminder_2" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error"></small>
                            </div>
                            <div class="col-lg-4">
                                <label>3RD REMINDER IN DAYS</label>
                                <input class="form-control form-control-sm" type="number" name="reminder_3" step="any"
                                    id="inp_reminder3" placeholder="Enter number of days" min="0"
                                    v-model="purchasing_data.reminder_3" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error"></small>
                            </div> -->
                        </div>
                    </div>
                </div>


                <div class="text-end float-right">
                    <button type="submit" class="btn btn-sm btn-round btn-outline--info mb-0 ">
                        <font-awesome-icon icon="fa-solid fa-floppy-disk" />
                        SAVE
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import Multiselect from "vue-multiselect";
import Swal from "sweetalert2";
import { library } from '@fortawesome/fontawesome-svg-core';
import { faHouse, faFloppyDisk, faXmark, faPlusCircle, faTrash } from '@fortawesome/free-solid-svg-icons';

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
            unit_of_measures: [],
            select_uom: null,
            purchasing_data: {},
        };
    },
    beforeMount() {
        library.add(faFloppyDisk);
        library.add(faPlusCircle);
        library.add(faXmark);
        library.add(faTrash);
        this.getUnitOfMeasures();
        this.getPurchasingData();
    },
    watch: {
    },
    methods: {

        async getUnitOfMeasures() {
            const unit_of_measures = (await axios.get(route("units.all"))).data;
            this.unit_of_measures = unit_of_measures.data;
        },

        async getPurchasingData() {
            const purchasing_data = (await axios.get(route("product.purchasing_data.get", this.productId))).data;
            if (purchasing_data) {
                this.purchasing_data = purchasing_data;
            }

            if (this.purchasing_data.uom != null) {
                const select_uom = (
                    await axios.get(
                        route("units.get", this.purchasing_data.uom)
                    )
                ).data;
                this.select_uom = select_uom.data;
            }

            if (this.purchasing_data.is_color == 1) {
                this.purchasing_data.color = 1;
            } else {
                this.purchasing_data.color = 2;
            }

            if (this.purchasing_data.is_schedule == 1) {
                this.purchasing_data.schedule = 1;
            } else {
                this.purchasing_data.schedule = 2;
            }

            if (this.purchasing_data.is_size == 1) {
                this.purchasing_data.size = 1;
            } else {
                this.purchasing_data.size = 2;
            }
        },

        async updatePurchasingData() {
            this.resetValidationErrors();
            try {
                if (this.select_uom) {
                    this.purchasing_data.unit_of_measure_id = this.select_uom.id;
                }
                await axios.post(
                    route("product.purchasing_data.update", this.productId),
                    this.purchasing_data,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );
                this.$root.notify.success({
                    title: "Success",
                    message: "Product Purchasing Data updated successfully",
                });
                this.getPurchasingData();
            } catch (error) {
                this.convertValidationError(error);
                this.convertValidationNotification(error);
            }
        },

    },
};
</script>

<style lang="scss" scoped></style>
