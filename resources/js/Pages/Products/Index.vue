<template>
    <div>
        <h1>Product List</h1>
        <ul>
            <li v-for="product in products" :key="product.id">
                {{ product.name }} - {{ product.price }}
                <router-link :to="{ name: 'products.edit', params: { id: product.id }}">Edit</router-link>
                <button @click="deleteProduct(product.id)">Delete</button>
            </li>
        </ul>
        <router-link to="products.create">Create Product</router-link>
    </div>
</template>

<script>
export default {
    props: {
        products: Array,
    },
    methods: {
        deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                this.$inertia.delete(`/products/${id}`);
            }
        },
    },
};
</script>
