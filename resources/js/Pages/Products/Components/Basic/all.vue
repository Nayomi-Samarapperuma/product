<template>
    <div id="basic-info">
        <div class="card-header">
            <h5>Basic Info</h5>
        </div>
        <div class="card-body pt-2 mt-3">
            <form role="form text-left" @submit.prevent="updateBasicData" enctype="multipart/form-data">
                <div class="row mb-1">
                    <div for="code" class="col-md-2 col-form-label">CODE</div>
                    <div class="col-md-10">
                        <input type="text" class="form-control form-control-sm" name="code" id="code"
                            v-model="product.code" required />
                        <small v-if="validationErrors.code"
                            class="mt-1 text-sm text-danger form-text text-error-msg error">
                            {{ validationErrors.code }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="name" class="col-md-2 col-form-label">NAME</div>
                    <div class="col-md-10">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Name"
                            v-model="product.name" required />
                        <small v-if="validationErrors.name"
                            class="mt-1 text-sm text-danger form-text text-error-msg error">
                            {{ validationErrors.name }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="category_id" class="col-md-2 col-form-label">
                        CATEGORY
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Name"
                            v-model="this.select_category" required disabled />
                        <!-- <Multiselect v-model="this.select_category" :options="categories" :close-on-select="true"
                            :clear-on-select="false" :searchable="true" placeholder="Select Category" label="full_name"
                            track-by="id" :showLabels="false" /> -->
                        <small v-if="validationErrors.category_id"
                            class="mt-1 text-sm text-danger form-text text-error-msg error">
                            {{ validationErrors.category_id }}</small>
                    </div>
                </div>

                <div class="row mb-1">
                    <div for="unit" class="col-md-2 col-form-label">

                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-lg-4 column__right___padding">
                                <label>TYPE</label>
                                <Multiselect v-model="this.select_type" :options="types" :close-on-select="true"
                                    :clear-on-select="false" :searchable="true" placeholder="Select Type" label="name"
                                    track-by="id" :showLabels="false" />
                                <small v-if="validationErrors.type"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.type }}</small>
                            </div>
                            <div class="col-lg-4 column__right___padding column__left___padding">
                                <label>SIZE</label>
                                <input type="text" class="form-control form-control-sm" name="size" id="size"
                                    v-model="product.size" placeholder="Size" />
                                <!-- <Multiselect v-model="this.select_size" :options="productSize" :close-on-select="true"
                                    :clear-on-select="false" :searchable="true" placeholder="Select Type" label="name"
                                    track-by="id" :showLabels="false" /> -->
                                <small v-if="validationErrors.size"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.size }}</small>
                            </div>
                            <div class="col-lg-4 column__left___padding">
                                <label>COLOR</label>
                                <input type="text" class="form-control form-control-sm" name="color" id="inp_color"
                                    v-model="product.color" placeholder="Color" />
                                <small v-if="validationErrors.color"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.color }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-1">
                    <div for="cost" class="col-md-2 col-form-label">COST</div>
                    <div class="col-md-10">
                        <input type="number" step="any" class="form-control form-control-sm" name="cost" id="cost"
                            placeholder="Cost" v-model="product.cost" />
                        <small v-if="validationErrors.cost"
                            class="mt-1 text-sm text-danger form-text text-error-msg error">
                            {{ validationErrors.cost }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="selling_price" class="col-md-2 col-form-label">SELLING PRICE</div>
                    <div class="col-md-10">
                        <input type="number" step="any" class="form-control form-control-sm" name="selling_price" id="selling_price"
                            placeholder="Selling Price" v-model="product.selling_price" />
                        <small v-if="validationErrors.selling_price"
                            class="mt-1 text-sm text-danger form-text text-error-msg error">
                            {{ validationErrors.selling_price }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="description" class="col-md-2 col-form-label">
                        DESCRIPTION
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control form-control-sm" name="Description" id="description"
                            v-model="product.description" rows="3"></textarea>
                        <small v-if="validationErrors.description"
                            class="mt-1 text-sm text-danger form-text text-error-msg error">
                            {{ validationErrors.description }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="unit" class="col-md-2 col-form-label">
                        DIMENSION
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-lg-4 column__right___padding">
                                <label>WIDTH (cm)</label>
                                <input class="form-control form-control-sm" type="number" name="size_width" step="any"
                                    id="inp_size_width" v-model="product.size_width" placeholder="Width" min="0" />
                                <small v-if="validationErrors.size_width"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.size_width }}</small>
                            </div>
                            <div class="col-lg-4 column__right___padding column__left___padding">
                                <label>LENGTH (cm)</label>
                                <input class="form-control form-control-sm" type="number" name="size_length" step="any"
                                    id="inp_size_length" v-model="product.size_length" placeholder="Length" min="0" />
                                <small v-if="validationErrors.size_length"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.size_length }}</small>
                            </div>
                            <div class="col-lg-4 column__left___padding">
                                <label>HEIGHT (cm)</label>
                                <input class="form-control form-control-sm" type="number" name="size_height" step="any"
                                    id="inp_size_height" v-model="product.size_height" placeholder="Height" min="0" />
                                <small v-if="validationErrors.size_height"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.size_height }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row mb-1">
                    <div for="unit" class="col-md-2 col-form-label">
                       PRODUCT UOM
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-lg-6 column__right___padding">
                                <label>PURCHASE</label>
                                <Multiselect v-model="this.select_purchase_uom" :options="units" :close-on-select="true"
                                    :clear-on-select="false" :searchable="true" placeholder="Select Unit" label="name"
                                    track-by="id" :showLabels="false" />
                                <small v-if="validationErrors.purchase_uom"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.purchase_uom }}</small>
                            </div>
                            <div class="col-lg-6 column__left___padding">
                                <label>STOCK</label>
                                <Multiselect v-model="this.select_stock_uom" :options="units" :close-on-select="true"
                                    :clear-on-select="false" :searchable="true" placeholder="Select Unit" label="name"
                                    track-by="id" :showLabels="false" />
                                <small v-if="validationErrors.stock_uom"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.stock_uom }}</small>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="row mb-1">
                    <div for="unit" class="col-md-2 col-form-label">

                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-lg-4 column__right___padding">
                                <label>BARCODE</label>
                                <input type="text" id="inp_barcode" name="barcode" class="form-control form-control-sm"
                                    v-model="product.code" placeholder="Barcode" aria-label="barcode"
                                    aria-describedby="barcode" />
                                <small v-if="validationErrors.barcode"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.barcode }}</small>
                            </div>
                            <div class="col-lg-4 column__right___padding column__left___padding">
                                <label>HS CODE</label>
                                <input type="text" id="inp_hs_code" name="hs_code" class="form-control form-control-sm"
                                    v-model="product.hs_code" placeholder="HS Code" aria-label="hs_code"
                                    aria-describedby="hs_code" />
                                <small v-if="validationErrors.hs_code"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.hs_code }}</small>
                            </div>
                            <div class="col-lg-4 column__left___padding">
                                <label>ROL</label>
                                <input type="text" id="inp_rol" name="rol" class="form-control form-control-sm"
                                    v-model="product.rol" placeholder="ROL" aria-label="rol" aria-describedby="rol" />
                                <small v-if="validationErrors.rol"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.rol }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="unit" class="col-md-2 col-form-label">WEIGHT</div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-lg-4 column__right___padding">
                                <label>GROSS</label>
                                <input step="any" class="form-control form-control-sm" type="number" name="gross_weight" min="0"
                                    id="inp_gross_weight" placeholder="Gross" v-model="product.gross_weight" />
                                <small v-if="validationErrors.gross_weight"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.gross_weight }}</small>
                            </div>
                            <div class="col-lg-4 column__right___padding column__left___padding">
                                <label>NET</label>
                                <input step="any" class="form-control form-control-sm" type="number" name="net_weight" min="0"
                                    id="inp_net_weight" v-model="product.net_weight" placeholder="Net" />
                                <small v-if="validationErrors.net_weight"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.net_weight }}</small>
                            </div>
                            <div class="col-lg-4 column__left___padding">
                                <label>UNIT</label>
                                <Multiselect v-model="this.select_uom_weight" :options="units" :close-on-select="true"
                                    :clear-on-select="false" :searchable="true" placeholder="Select Unit" label="name"
                                    track-by="id" :showLabels="false" />
                                <small v-if="validationErrors.uom_weight"
                                    class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.uom_weight }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="final_date" class="col-md-2 col-form-label">
                        IMAGE
                    </div>
                    <div class="col-md-10">
                        <div class="upload-img mb-3" v-if="product.images">
                            <img :src="product.images.name" alt="" width="300">
                        </div>
                        <input type="file" ref="file" class="form-control form-control-sm"
                            @input="product.photo = $event.target.files[0]" />
                        <div class="error">
                            <small v-if="validationErrors.photo"
                                class="mt-1 text-sm text-danger form-text text-error-msg error">
                                {{ validationErrors.photo }}</small>
                        </div>
                    </div>
                </div>

                <div class="text-end float-right">
                    <button v-if="can('update_products')" type="button" class="btn btn-sm btn-round btn-outline-danger mb-0 "
                        @click.prevent="deleteProduct">
                        <font-awesome-icon icon="fa-solid fa-trash" />
                        DELETE
                    </button>
                    <button v-if="can('delete_products')" type="submit" class="btn btn-sm btn-round btn-outline--info mb-0 ">
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
            product: {},
            select_category: null,
            select_stock_uom: null,
            select_purchase_uom: null,
            select_uom_weight: null,
            // select_size: null,
            select_type: null,
            categories: [],
            units: [],
            types: [],
            productSize: [],
            select_search_vendor:null,
            vendors: [],
        };
    },
    beforeMount() {
        library.add(faFloppyDisk);
        library.add(faPlusCircle);
        library.add(faXmark);
        library.add(faTrash);
        this.getProduct();
       // this.getProductTypes();
        this.getCategories();
        this.getUnits();
        this.getSizes();
    },
    watch: {
    },
    methods: {
        // onSearchVendor(search, loading) {
        //     if (search.length) {
        //         loading = true;
        //         this.searchVendor(loading, search, this);
        //     }
        // },
        // searchVendor: _.debounce((loading, search, vm) => {
        //     axios.get(route("vendors.all"), {
        //         params: {
        //             "filter[search]": search,
        //         },
        //     }).then(res => {
        //         // console.log(res.data.data)
        //         vm.vendors = res.data.data;
        //         loading = false;
        //     });
        // }),
        async getProduct() {
            const product = (
                await axios.get(route("product.get", this.productId))
            ).data;
            this.product = product.data;

            const select_category = (
                await axios.get(
                    route("productCategory.get", this.product.category)
                )
            ).data;
            this.select_category = select_category.data.full_name;

            if (this.product.consignment_item==1) {
                const select_search_vendor = (
                await axios.get(
                    route("vendors.get", this.product.vendor_id)
                )
                ).data;
                console.log(select_search_vendor.data)
                this.select_search_vendor = select_search_vendor.data;
            }

            const select_type = (
                await axios.get(
                    route("productType.get", this.product.type)
                )
            ).data;
            this.select_type = select_type.data;

            const select_stock_uom = (
                await axios.get(
                    route("units.all", this.product.stock_uom)
                )
            ).data;
            this.select_stock_uom = select_stock_uom.data;

            const select_purchase_uom = (
                await axios.get(route("units.all", this.product.purchase_uom))
            ).data;
            this.select_purchase_uom = select_purchase_uom.data;

            if (this.product.uom_weight) {
                const select_uom_weight = (
                    await axios.get(route("units.all", this.product.uom_weight))
                ).data;
                this.select_uom_weight = select_uom_weight.data;
            }
            // if (this.product.size) {
            //     const select_size = (
            //         await axios.get(route("product.size.get", this.product.size))
            //     ).data;
            //     this.select_size = select_size[0];
            //     console.log(this.select_size)
            // }
        },
        async getCategories() {
            const categories = (await axios.get(route("productCategory.all"))).data;
            this.categories = categories.data;
        },
        async getUnits() {
            const units = (await axios.get(route("units.all"))).data;
            this.units = units.data;
        },
        async getProductTypes() {
            const productTypes = (await axios.get(route("productType.all"))).data;
            this.types = productTypes.data;
        },
        async getSizes() {
            const productSize = (await axios.get(route("product.size.all"))).data;
            // console.log(productSize)
            this.productSize = productSize;
        },
        async updateBasicData() {
            this.resetValidationErrors();
            try {
                const file = this.$refs.file.files[0];
                if (file) {
                    if (file.size > 200000) {
                        this.$root.notify.error({
                            title: "Fail",
                            message: "Image size should be less than 200KB.",
                        });
                        return;
                    }
                }
                // if (this.select_purchase_uom) {
                //     this.product.purchase_uom = this.select_purchase_uom.id;
                // }
                // if (this.select_stock_uom) {
                //     this.product.stock_uom = this.select_stock_uom.id;
                // }
                if (this.select_type) {
                    this.product.type = this.select_type.id;
                }
                // if (this.select_size) {
                //     this.product.size = this.select_size.slug;
                // }
                if (this.select_uom_weight) {
                    this.product.uom_weight = this.select_uom_weight.id;
                }
                if (this.product.code) {
                    this.product.barcode = this.product.code;
                }
                if (this.select_search_vendor) {
                    this.product.vendor = this.select_search_vendor.name;
                    this.product.vendor_id = this.select_search_vendor.id;
                }
                await axios.post(
                    route("product.basic.update", this.productId),
                    this.product,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );
                this.$root.notify.success({
                    title: "Success",
                    message: "Product updated successfully",
                });
                this.getProduct();
            } catch (error) {
                this.convertValidationError(error);
                this.convertValidationNotification(error);
            }
        },
        async deleteProduct() {
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
                        axios.delete(route("product.delete", this.product.id))
                        .then((response) => {
                            this.$inertia.visit(route('product.index'));
                        });
                        // Swal.fire(
                        //     "Deleted!",
                        //     `Product has been deleted.`,
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

<style lang="scss" scoped>

</style>
