<template>
    <div>
        <h1>Edit Product</h1>
        <form @submit.prevent="submitForm">
            <label>Name:</label>
            <input v-model="form.name" required>
            <br>
            <label>Description:</label>
            <textarea v-model="form.description"></textarea>
            <br>
            <label>Price:</label>
            <input type="number" step="0.01" v-model="form.price" required>
            <br>
            <button type="submit">Save</button>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        product: Object,
    },
    data() {
        return {
            form: { ...this.product },
        };
    },
    methods: {
        submitForm() {
            this.$inertia.put(`/products/${this.product.id}`, this.form);
        },
    },
};
</script>
