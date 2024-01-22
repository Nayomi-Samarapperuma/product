<template>
    <div id="inventry-info">
        <div class="card-header">
            <h5>Inventry Info</h5>
        </div>
        <div class="card-body pt-0 mt-3">
            <form @submit.prevent="updateProductInventry">
                <div class="row mb-2">
                    <div class="col-md-2 column__right___padding">
                        <label>CODE</label>
                        <div class="input-group">
                          <input type="text" id="product_inventry_code" name="code" class="form-control form-control-sm"
                            v-model="inventry.code" placeholder="CODE" aria-label="code" aria-describedby="code" required />
                        </div>
                        <small v-if="validationErrors.code" id="msg_product_inventry_code"
                          class="text-danger form-text text-error-msg error">{{ validationErrors.code }}</small>
                      </div> 
                      <div class="col-md-2 column__right___padding column__left___padding">
                        <label>DATE</label>
                        <div class="input-group">
                          <input type="text" id="product_inventry_date" name="date" class="form-control form-control-sm"
                            v-model="inventry.date" placeholder="DATE" aria-label="date"
                            aria-describedby="date" required />
                        </div>
                        <small v-if="validationErrors.date" id="msg_product_inventry_date"
                          class="text-danger form-text text-error-msg error">{{ validationErrors.date }}</small>
                      </div>
                      <div class="col-md-3 column__right___padding column__left___padding">
                        <label>QUANTITY</label>
                        <div class="input-group">
                          <input type="number" id="product_inventry_quantity" name="quantity" class="form-control form-control-sm"
                            v-model="inventry.quantity" placeholder="QUANTITY" aria-label="quantity" aria-describedby="quantity" required />
                        </div>
                        <small v-if="validationErrors.quantity" id="msg_product_inventry_quantity"
                          class="text-danger form-text text-error-msg error">{{ validationErrors.quantity }}</small>
                      </div>
                      <div class="col-md-2 column__right___padding column__left___padding">
                        <label>REASON</label>
                        <div class="input-group">
                          <input type="text" id="product_inventry_reason" name="reason" class="form-control form-control-sm"
                            v-model="inventry.reason" placeholder="REASON." aria-label="reason" aria-describedby="reason"
                            required />
                        </div>
                        <small v-if="validationErrors.reason" id="msg_product_reason"
                          class="text-danger form-text text-error-msg error">{{ validationErrors.reason }}</small>
                      </div>
                      <div class="col-md-1 mt-2 pt-1 column__left___padding"> 
                        <div>
                          <button type="submit" class="btn btn-sm custom-button mt-2">
                            <font-awesome-icon icon="fa-solid fa-circle-plus" />
                            ADD NEW
                          </button>
                        </div>
                      </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th :class="textClassHead">Code</th>
                      <th :class="textClassHead">Date</th>
                      <th :class="textClassHead">Quantity</th>
                      <th :class="textClassHead">Reason</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="inventry in inventries" :key="inventry.id" :class="rowClass">
                      <td :class="textClassBody">
                        {{ inventry.code }}
                      </td>
                      <td :class="textClassBody">
                        {{ inventry.date }}
                      </td>
                      <td :class="textClassBody">
                        {{ inventry.quantity }}
                      </td>
                      <td :class="textClassBody">
                        {{ inventry.reason }}
                      </td>
                      <td :class="textClassBody">
                        <a href="javascript:void(0)" @click.prevent="deleteInventryInfo(inventry.id)" class="p-2 float-end">
                          <font-awesome-icon icon="fa-solid fa-trash" class="text-ash text-right" />
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
  faHouse,
  faPlusCircle,
  faTrash,
} from "@fortawesome/free-solid-svg-icons";

export default {
  components: {
    Link,
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
      iconClassHead: "text-right",
      iconClassBody: "text-right",
      rowClass: "cursor-pointer",

      search: null,
      page: 1,
      perPage: [25, 50, 100],
      pageCount: 25,
      pagination: {},

      inventry: {},
      inventries: [],
    };
  },
  beforeMount() {
    this.getInventries();
    library.add(faHouse);
    library.add(faPlusCircle);
    library.add(faTrash);
  },

  methods: {
    async setPage(page) {
      this.page = page;
      this.reload();
    },
    async getSearch() {
      this.page = 1;
      this.reload();
    },
    async perPageChange() {
      this.reload();
    },
    async reload() {
      this.$root.loader.start();
      const tableData = (
        await axios.get(route("product.inventry.all", this.productId), {
          params: {
            page: this.page,
            per_page: this.pageCount,
            "filter[search]": this.search,
          },
        })
      ).data;

      this.inventries = tableData.data;
      this.pagination = tableData.meta;
      this.$root.loader.finish();
    },
    async getInventries() {
      this.$nextTick(() => {
        this.$root.loader.start();
      });
      const inventries = (
        await axios.get(route("product.inventry.all", this.productId))
      ).data;

      console.log(inventries.data);
      this.inventries = inventries.data;
      this.pagination = inventries.meta;
      this.$nextTick(() => {
        this.$root.loader.finish();
      });
    },
    async updateProductInventry() {
      this.resetValidationErrors();
      try {
        await axios.post(
          route("product.inventry.update", this.productId),
          this.inventry
        );
        this.inventry = {};
        this.reload();
        this.$root.notify.success({
          title: "Success",
          message: "Inventry updated successfully",
        });
      } catch (error) {
        this.convertValidationError(error);
      }
    },
    async deleteInventryInfo(id) {
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
            axios
              .delete(route("product.inventry.delete", id))
              .then((response) => {
                this.reload();
              });
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
.custom-button {
    background-color: #ffffff;
    border-color: #6343e9;
    color: #6343e9 !important;
  }
  
  .custom-button:hover {
    background-color: #6343e9;
    color: #ffffff !important;
  }
</style>