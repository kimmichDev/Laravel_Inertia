<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <Link class="navbar-brand" href="/">Home</Link>
            {{ $page.component }}
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <Link
                            :class="[
                                'nav-link',
                                { active: $page.component === 'Index' },
                            ]"
                            href="/"
                            >Home</Link
                        >
                    </li>
                    <li class="nav-item">
                        <Link
                            :class="[
                                'nav-link',
                                { active: $page.component === 'About' },
                            ]"
                            href="/about"
                            >About</Link
                        >
                    </li>
                    <li class="nav-item">
                        <Link
                            :class="[
                                'nav-link',
                                {
                                    active:
                                        $page.component === 'user/Index' ||
                                        $page.component === 'user/Create',
                                },
                            ]"
                            href="/user"
                            >User</Link
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="m-5">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
export default {
    components: { Head },
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
