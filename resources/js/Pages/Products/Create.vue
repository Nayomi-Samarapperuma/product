<template>
    <div>
        <h1>Create Product</h1>
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
    data() {
        return {
            form: {
                name: '',
                description: '',
                price: 0,
            },
        };
    },
    methods: {
        submitForm() {
            this.$inertia.post('/products', this.form);
        },
    },
};
</script>
