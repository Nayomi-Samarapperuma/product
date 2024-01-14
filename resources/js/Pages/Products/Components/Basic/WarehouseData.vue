<template>
    <div class="card-header">
        <h5>Warehouse Data</h5>
    </div>
    <div class="card-body pt-0">
        <form role="form text-left" enctype="multipart/form-data" @submit.prevent="updateWarehouseData">
            <div class="row mb-1 mt-2">
                <div for="inp_uom" class="col-md-3 col-form-label">
                    STOCK UOM
                </div>
                <div class="col-md-8">
                    <Multiselect v-model="this.select_unit" :options="this.units" :close-on-select="true"
                        :clear-on-select="false" :searchable="true" placeholder="Select Unit" label="name" track-by="id" />
                    <small v-if="validationErrors.uom" id="msg_uom" class="text-danger form-text text-error-msg error">{{
                        validationErrors.uom }}</small>
                </div>
            </div>
            <div class="row mb-1">
                <div for="inp_storage" class="col-md-3 col-form-label">
                    INIT STORAGE
                </div>
                <div class="col-md-8">
                    <select v-model="warehouseData.init_storage" class="form-control form-control-sm select-init-storage"
                        name="init_storage" id="inp_init_storage" >
                        <option value="0">Main Stock</option>
                        <option value="1">Damage</option>
                        <option value="2">Hold</option>
                    </select>
                    <small v-if="validationErrors.init_storage" id="msg_init_storage"
                        class="text-danger form-text text-error-msg error">{{ validationErrors.init_storage }}</small>
                </div>
            </div>
            <div class="row mb-1">
                <div for="inp_stock_removal" class="col-md-3 col-form-label">
                    STOCK REMOVAL
                </div>
                <div class="col-md-8">
                    <select v-model="warehouseData.stock_removal" class="form-control form-control-sm select-stock-removal"
                        name="stock_removal" id="inp_stock_removal">
                        <option value="0">FIFO</option>
                        <option value="1">FEFO</option>
                        <option value="2">LIFO</option>
                    </select>
                    <small v-if="validationErrors.stock_removal" id="msg_stock_removal"
                        class="text-danger form-text text-error-msg error">{{ validationErrors.stock_removal }}</small>
                </div>
            </div>
            <div class="row mb-1">
                <div for="restricted_batch_process" class="col-md-3 col-form-label">
                    RESTRICTED TO BATCH PROCESS
                </div>
                <div class="col-md-8">
                    <select v-model="warehouseData.restricted_batch_process"
                        class="form-control form-control-sm select-restricted-batch-process" name="restricted_batch_process"
                        id="inp_restricted_batch_process" >
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                    <small v-if="validationErrors.restricted_batch_process" id="msg_restricted_batch_process"
                        class="text-danger form-text text-error-msg error">{{ validationErrors.restricted_batch_process
                        }}</small>
                </div>
            </div>
            <div class="row mb-1">
                <div for="inp_production_date_check" class="col-md-3 col-form-label">
                    PRODUCTION DATE CHECK
                </div>
                <div class="col-md-8">
                    <select v-model="warehouseData.production_date_check"
                        class="form-control form-control-sm select-production-date-check" name="production_date_check"
                        id="inp_production_date_check" >
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                    <small v-if="validationErrors.production_date_check" id="msg_production_date_check"
                        class="text-danger form-text text-error-msg error">{{ validationErrors.production_date_check
                        }}</small>
                </div>
            </div>
            <div class="row mb-1">
                <div for="inp_expire_date_check" class="col-md-3 col-form-label">
                    EXPIRE DATE CHECK
                </div>
                <div class="col-md-8">
                    <select v-model="warehouseData.expire_date_check"
                        class="form-control form-control-sm select-expire-date-check" name="expire_date_check"
                        id="inp_expire_date_check" >
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                    <small v-if="validationErrors.expire_date_check" id="msg_expire_date_check"
                        class="text-danger form-text text-error-msg error">{{ validationErrors.expire_date_check }}</small>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-sm btn-round btn-outline--info btn-md mt-3 mb-2 float-right">
                    <i class="fas fa-save"></i>
                    Save
                </button>
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
        axios,
        Swal,
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
            warehouseData: {},
            units: [],
            select_unit: null,
        };
    },
    beforeMount() {
        this.getUnits();
        this.getWarehouseData();
    },
    watch: {},
    methods: {
        async getUnits() {
            const units = (await axios.get(route("units.list"))).data;
            this.units = units;
        },
        async getWarehouseData() {
            const warehouseData = (
                await axios.get(route("warehousedata.get", this.productId))).data;
                // console.log("warehouse data-",warehouseData);
            if(warehouseData){
                this.warehouseData = warehouseData;
                if (this.warehouseData.uom) {
                    const select_uom = (
                        await axios.get(route("units.all", this.warehouseData.uom))
                    ).data;
                    this.select_uom = select_uom.data;
                }
            }


            // const select_uom= (
            //         await axios.get(route("units.get", this.warehouseData.uom))
            //     ).data;
            //     this.select_unit = select_uom.data;
        },
        async updateWarehouseData() {
            this.resetValidationErrors();
            try {
                this.warehouseData.uom = this.select_unit.id;

                await axios.post(
                    route("warehousedata.update", this.productId),this.warehouseData);
                    console.log(this.warehouseData);
                this.warehouseData = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "Warehouse updated successfully",
                });
                this.getWarehouseData();
            } catch (error) {
                this.convertValidationError(error.message);
            }
        },
    },
};
</script>
