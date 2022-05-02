<template>
    <Head title="Users"></Head>
    <div class="card mt-3 shadow btn">
        <div class="card-body">
            <div class="my-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-nowrap">User List</h3>
                <div class="d-flex">
                    <form @submit.prevent="search" class="me-3">
                        <div class="input-group">
                            <input
                                type="text"
                                class="form-control-sm form-control"
                                v-model="keyword"
                            />
                            <button
                                class="btn btn-outline-primary"
                                type="button"
                                id="button-addon2"
                                @click="search"
                            >
                                <i class="bi bi-search-heart-fill"></i>
                            </button>
                        </div>
                    </form>
                    <Link href="/user/create" class="btn btn-primary"
                        >Create
                    </Link>
                </div>
            </div>
            <div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Info</th>
                            <th>Control</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="user in users.data"
                            :key="user.id"
                            class="align-middle user-list"
                        >
                            <td>{{ user.id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img
                                        :src="user.photo"
                                        class="rounded-circle profile-thumbnail me-3"
                                        alt=""
                                    />
                                    <span class="text-left">
                                        <p
                                            class="mb-0"
                                            style="text-align: left"
                                        >
                                            {{ user.name }}
                                        </p>
                                        <small class="small text-black-50">
                                            {{ user.email }}
                                        </small>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-outline-primary">
                                        <i class="bi bi-info-circle-fill"></i>
                                    </button>
                                    <Link
                                        :href="
                                            '/user/' +
                                            user.id +
                                            '/edit?page=' +
                                            query.page
                                        "
                                        class="btn btn-outline-success"
                                    >
                                        <i class="bi bi-pen"></i>
                                    </Link>
                                    <button
                                        @click="destroy(user.id)"
                                        class="btn btn-outline-danger"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <span>{{ user.created_at_date }}</span>
                                <br />
                                <span>{{ user.created_at_time }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center align-items-center">
                    <Pagination :links="users.meta.links"></Pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Pagination from "../components/Pagination";
import { Inertia } from "@inertiajs/inertia";
import { ref } from "@vue/reactivity";
import { onMounted, watch } from "@vue/runtime-core";
import _ from "lodash";
import ScrollReveal from "scrollreveal";
import { showToast } from "../../Composables/ShowToast";
import { showConfirm } from "../../Composables/ShowConfirm";

export default {
    components: { Pagination },
    props: ["users", "query", "status"],
    setup(props) {
        let keyword = ref(props.query.search);
        let destroy = (id) => {
            showConfirm(() => {
                Inertia.delete(`user/${id}`, {
                    preserveScroll: true,
                    onSuccess: () => showToast(props.status),
                });
            });
        };

        let search = () => {
            Inertia.get(
                "/user",
                { search: keyword.value },
                { preserveState: true }
            );
        };

        watch(keyword, _.debounce(search, 500));
        onMounted(() => {
            ScrollReveal().reveal(".user-list", {
                distance: "30px",
                origin: "top",
                duration: 400,
                interval: 200,
            });
        });
        return { destroy, keyword, search };
    },
};
</script>

<style lang="scss" scoped></style>
