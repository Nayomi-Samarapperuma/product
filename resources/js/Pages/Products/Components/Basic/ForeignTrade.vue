<template>
        <div class="card-header">
            <h5>Foreign Trade</h5>
        </div>

        <div class="card-body pt-2 mt-3">
            <form
                role="form text-left"
                @submit.prevent="saveForeignTradeData"
                enctype="multipart/form-data"
            >
                <div class="row mb-1">
                    <div class="col-md-12">
                        <div class="row">
                            <div
                                for="inp_uom"
                                class="col-md-2 col-form-label mt-2"
                            >
                                HS CODE
                            </div>
                            <div class="col-md-10 mt-3">
                                <div class="input-group">
                                    <input
                                        type="text" id="inp_hs_code"
                                        name="hs_code"
                                        v-model="foreignData.hs_code"
                                        class="form-control form-control-sm"
                                        placeholder="HS CODE"
                                        aria-label="hs_code"
                                        aria-describedby="hs_code"
                                    />
                                    <small
                                        v-if="validationErrors.hs_code"
                                        id="msg_hs_code"
                                        class="text-danger form-text text-error-msg error"
                                        >{{ validationErrors.hs_code }}</small
                                    >
                                </div>
                            </div>
                            <div
                                for="inp_uom"
                                class="col-md-2 col-form-label mt-2"
                            >
                                ORIGIN COUNTRY
                            </div>
                            <div class="col-md-10 mt-3">
                                <div class="input-group">
                                    <Multiselect
                                        v-model="select_country"
                                        :options="countries"
                                        :close-on-select="true"
                                        :clear-on-select="false"
                                        :searchable="true"
                                        placeholder="Select Country"
                                        label="name"
                                        track-by="id"
                                    />
                                    <small
                                        v-if="validationErrors.country_id"
                                        id="msg_country_id"
                                        class="text-danger form-text text-error-msg error"
                                        >{{ validationErrors.country_id }}</small
                                    >
                                </div>
                            </div>
                            <div
                                for="inp_uom"
                                class="col-md-2 col-form-label mt-2"
                            >
                                PACKAGING NOTE
                            </div>
                            <div class="col-md-10 mt-3">
                                <div class="input-group">
                                    <textarea
                                        class="form-control form-control-sm"
                                        id="inp_note"
                                        name="note"
                                        v-model="foreignData.note"
                                        rows="3"
                                        placeholder="Packaging Note"
                                    ></textarea>
                                    <small
                                        v-if="validationErrors.note"
                                        id="msg_note"
                                        class="text-danger form-text text-error-msg error"
                                        >{{ validationErrors.note }}</small
                                    >
                                </div>
                            </div>
                            <div class="col-lg-12 pt-1 float-right">
                                <div class="text-end">
                                    <label></label>
                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline--info my-3 float-right"
                                    >
                                    <i class="fas fa-save"></i>
                                    SAVE
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
</template>

<script>
import axios from 'axios';
import Multiselect from "vue-multiselect";

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
            countries: [],
            select_country: null,
            foreignData: {},
        };
    },
    beforeMount() {
        this.getCountries();
        this.getForeignTradeData();
    },
    watch: {},
    methods: {
        async getForeignTradeData() {
            const foreignData = (
                await axios.get(route("foreigntrade.get", this.productId))).data;
            // console.log("foreign Data - ",foreignData)
            if(foreignData){
                this.foreignData = foreignData;
                if (this.foreignData.country_id) {
                    const select_country = (
                        await axios.get(route("country.get", this.foreignData.country_id))
                    ).data;
                    this.select_country = select_country.data;
                }
            }

        },

        async getCountries() {
            const countries = (await axios.get(route("country.all"))).data;
            this.countries = countries.data;
        },
        async saveForeignTradeData() {
            this.resetValidationErrors();
            try {
                if (this.select_country) {
                    this.foreignData.country_id = this.select_country.id;
                }
                console.log(this.foreignData);
                await axios.post(route("foreigntrade.update",this.productId),this.foreignData);
                this.foreignData = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "foreign Trade updated successfully",
                });
                this.getForeignTradeData();
            } catch (error) {
                this.convertValidationError(error.message);
            }
        },
    },
};
</script>
