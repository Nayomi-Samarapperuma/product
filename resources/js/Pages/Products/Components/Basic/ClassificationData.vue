<template>
    <div id="basic-info">
        <div class="card-header">
            <h5>Classification Data</h5>
        </div>
        <div class="card-body pt-2 mt-3">
            <form role="form text-left" @submit.prevent="updateClassificationData" enctype="multipart/form-data">
                <div class="row mb-1">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-lg-5 column__right___padding">
                                <label>NAME</label>
                                <input class="form-control form-control-sm" type="text" name="name" step="any" id="inp_name"
                                    placeholder="Name" min="0" v-model="classification_data.name" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.name }}
                                </small>
                            </div>
                            <div class="col-lg-5 column__right___padding">
                                <label>VALUE</label>
                                <input class="form-control form-control-sm" type="text" name="value" step="any"
                                    id="inp_value" placeholder="Value" min="0" v-model="classification_data.value" />
                                <small class="mt-1 text-sm text-danger form-text text-error-msg error">
                                    {{ validationErrors.value }}
                                </small>
                            </div>
                            <div class="text-end col-lg-2 mt-lg-4">
                                <button type="submit" class="btn btn-sm btn-round btn-outline--info mb-0 mt-lg-1">
                                    <font-awesome-icon icon="fa-solid fa-circle-plus" />
                                    ADD
                                </button>
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
                                    <th :class="textClassHead" class="text_align_end">Value</th>
                                    <th :class="iconClassHead"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="classification in product_classifications" :key="classification.id"
                                    :class="rowClass">

                                    <td :class="textClassBody">
                                        {{ classification.name }}
                                    </td>
                                    <td :class="textClassBody" class="text_align_end">
                                        {{ classification.value }}
                                    </td>
                                    <td :class="iconClassBody" class="text_align_end">
                                        <a href="javascript:void(0)"
                                            @click.prevent="deleteClassificationItem(classification.id)" class="p-2 ">
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
            classification_data: {},
            product_classifications: [],
        };
    },
    beforeMount() {
        library.add(faFloppyDisk);
        library.add(faPlusCircle);
        library.add(faXmark);
        library.add(faTrash);
        this.getClassificationData();
    },
    watch: {
    },
    methods: {

        async getClassificationData() {
            const tableData = (await axios.get(route("products.classification_data.get", this.productId))).data;
            console.log(tableData)
            this.product_classifications = tableData.data;
            this.pagination = tableData.meta;
        },

        async updateClassificationData() {
            try {
                const response = await axios.post(
                    route("products.classification_data.update", this.productId),
                    this.classification_data
                );
                this.$root.notify.success({
                    title: "Success",
                    message: "Product Classification Data updated successfully",
                });
                this.classification_data = {},
                this.getClassificationData();
            } catch (error) {
                this.convertValidationError(error);
                this.convertValidationNotification(error);
            }
        },

        async deleteClassificationItem(id) {
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
                        axios.delete(route("products.classification_data.delete", id)).then((response) => {
                            this.getClassificationData();
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

<style lang="scss" scoped></style>
