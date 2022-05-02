<template>
    <div class="card mt-3 animate__animated animate__fadeIn">
        <div class="card-body">
            <h3>Welcome to vue+inertia</h3>
            <Link href="/" class="btn btn-primary mx-3">Home</Link>
            <Link href="/user" class="btn btn-primary"> Go to users </Link>
            <Link href="/about" class="btn btn-primary mx-3">
                Go to about
            </Link>
        </div>
    </div>
</template>

<script>
// import Layout from "../Shared/Layout.vue";
export default {
    // layout: Layout,
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
