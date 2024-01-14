<template>
    <div id="basic-info">
        <div class="card-header">
            <h5>MRP Data</h5>
        </div>
        <div class="card-body pt-2 mt-3">
            <form role="form text-left" @submit.prevent="updateMrpData" enctype="multipart/form-data">
                <div class="row mb-1">

                    <div for="uom" class="col-md-2 col-form-label">
                        TYPE
                    </div>
                    <div class="col-md-8">
                        <Multiselect v-model="this.select_product_type" :options="product_types" :showLabels="false"
                            :close-on-select="true" :clear-on-select="false" :searchable="true" placeholder="Select Type"
                            label="name" track-by="id" />
                    </div>
                    <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                        {{ validationErrors.product_type }}
                    </small>

                </div>

                <div class="row mb-1">
                    <div for="unit" class="col-md-2 col-form-label">
                        LEVELS
                    </div>
                    <div class="col-md-10">
                        <div class="row level_input_width_area">
                            <div class="col-md-5 level_input_width column__right___padding">
                                <label>RE-ORDER LEVEL</label>
                                <input class="form-control form-control-sm Level_width" type="number" name="reorder_level" step="any"
                                    id="inp_reorder_level" placeholder="Qty" min="0" v-model="mrp_data.reorder_level" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.reorder_level }}
                                </small>
                            </div>
                            <div class="col-md-5 level_input_width column__right___padding">
                                <label>SAFETY LEVEL</label>
                                <input class="form-control form-control-sm Level_width" type="number" name="safety_level" step="any"
                                    id="inp_safety_level" placeholder="Qty" min="0" v-model="mrp_data.safety_level" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.safety_level }}
                                </small>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row mb-1">

                    <div for="uom" class="col-md-2 col-form-label">
                        IMPORTANT
                    </div>
                    <div class="col-md-8">
                        <Multiselect v-model="this.select_important" :options="important" :showLabels="false"
                            :close-on-select="true" :clear-on-select="false" :searchable="true"
                            placeholder="Select Important Level" label="name" track-by="id" />
                    </div>
                    <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                        {{ validationErrors.important }}
                    </small>

                </div>

                <div class="row mb-1">

                    <div for="uom" class="col-md-2 col-form-label">
                        PROCUREMENT TYPE
                    </div>
                    <div class="col-md-8">
                        <Multiselect v-model="this.select_procurement_type" :options="procurement_types" :showLabels="false"
                            :close-on-select="true" :clear-on-select="false" :searchable="true"
                            placeholder="Select Procurement Type" label="name" track-by="id" />
                    </div>
                    <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                        {{ validationErrors.procurement_type }}
                    </small>

                </div>

                <div class="row mb-1">

                    <div for="uom" class="col-md-2 col-form-label">
                        UNIT OF MEASURE
                    </div>
                    <div class="col-md-8">
                        <Multiselect v-model="this.select_uom" :options="unit_of_measures" :showLabels="false"
                            :close-on-select="true" :clear-on-select="false" :searchable="true" placeholder="Select UOM"
                            label="name" track-by="id" />
                    </div>
                    <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                        {{ validationErrors.uom }}
                    </small>

                </div>


                <div class="row mb-1">
                    <div for="unit" class="col-md-2 col-form-label">
                        PROCESS DAYS
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-lg-4 column__right___padding">
                                <label>PRODUCTION</label>
                                <input class="form-control form-control-sm" type="number" name="production_days" step="any"
                                    id="inp_production_days" placeholder="Days" min="0"
                                    v-model="mrp_data.production_days" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.production_days }}
                                </small>
                            </div>
                            <div class="col-lg-4 column__right___padding">
                                <label>GOODS RECEIVING</label>
                                <input class="form-control form-control-sm" type="number" name="good_receiving_days"
                                    step="any" id="inp_good_receiving_days" placeholder="Days" min="0"
                                    v-model="mrp_data.good_receiving_days" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.good_receiving_days }}
                                </small>
                            </div>
                            <div class="col-lg-4">
                                <label>DELIVERY</label>
                                <input class="form-control form-control-sm" type="number" name="delivery_days" step="any"
                                    id="inp_delivery_days" placeholder="Days" min="0" v-model="mrp_data.delivery_days" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.delivery_days }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-1">
                    <div for="unit" class="col-md-2 col-form-label">
                        PROCUREMENT REPEAT IN DAYS
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-10 input_width column__right___padding">
                                <input class="form-control form-control-sm" type="number" name="procurement_repeat_days"
                                    step="any" id="inp_procurement_repeat_days" placeholder="Days" min="0"
                                    v-model="mrp_data.procurement_repeat_days" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.procurement_repeat_days }}
                                </small>
                            </div>

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
        Swal,
        library,
        faHouse,
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
            product_types: [],
            unit_of_measures: [],
            important: [
                { id: 0, name: 'Low' },
                { id: 1, name: 'Medium' },
                { id: 2, name: 'High' },
            ],
            procurement_types: [
                { id: 0, name: 'Internal Production' },
                { id: 1, name: 'External Production' },
                { id: 2, name: 'Semi Production' },
            ],
            select_product_type: null,
            select_important: null,
            select_procurement_type: null,
            select_uom: null,

            mrp_data: {},

        };
    },
    beforeMount() {
        library.add(faFloppyDisk);
        library.add(faPlusCircle);
        library.add(faXmark);
        library.add(faTrash);
        //this.getProductTypes();
        this.getUnitOfMeasures();
        this.getMrpData();
    },
    watch: {
    },
    methods: {

        async getUnitOfMeasures() {
            const unit_of_measures = (await axios.get(route("units.all"))).data;
            this.unit_of_measures = unit_of_measures.data;
        },

        async getProductTypes() {
            const product_types = (await axios.get(route("productType.all"))).data;
            this.product_types = product_types.data;
        },

        async updateMrpData() {
            this.resetValidationErrors();
            try {
                if (this.select_uom) {
                    this.mrp_data.uom_id = this.select_uom.id;
                }

                if (this.select_product_type) {
                    this.mrp_data.product_type = this.select_product_type.id;
                }

                if (this.select_important) {
                    this.mrp_data.important = this.select_important.id;
                }

                if (this.select_procurement_type) {
                    this.mrp_data.procurement_type = this.select_procurement_type.id;
                }

                await axios.post(
                    route("product.mrp_data.update", this.productId),
                    this.mrp_data,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );
                this.$root.notify.success({
                    title: "Success",
                    message: "Product MRP Data updated successfully",
                });
                this.getMrpData();
            } catch (error) {
                this.convertValidationError(error);
                this.convertValidationNotification(error);
            }
        },

        async getMrpData() {
            const mrp_data = (await axios.get(route("product.mrp_data.get", this.productId))).data;

            if (mrp_data) {
                this.mrp_data = mrp_data;
            }


            if (this.mrp_data.uom_id != null) {
                const select_uop = (
                    await axios.get(
                        route("units.get", this.mrp_data.uom_id)
                    )
                ).data;
                this.select_uom = select_uop.data;
            }

            if (this.select_uom) {
                this.mrp_data.uop_id = this.select_uom.id;
            }

            this.select_product_type = this.product_types.find(product_type => product_type.id == this.mrp_data.product_type);
            this.select_important = this.important.find(important => important.id == this.mrp_data.important);
            this.select_procurement_type = this.procurement_types.find(procurement_type => procurement_type.id == this.mrp_data.procurement_type);
        },

    },
};
</script>

<style lang="scss" scoped></style>
