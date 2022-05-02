<template>
    <Head title="Create">
        <meta name="description" content="My test app" />
    </Head>
    <base-layout>
        <div class="card mt-3 shadow">
            <div class="card-body">
                <div
                    class="my-3 d-flex justify-content-between align-items-center"
                >
                    <h3>Create User</h3>
                    <Link href="/user" class="btn btn-primary">User List</Link>
                </div>

                <div>
                    <form @submit.prevent="save">
                        <div class="mb-3">
                            <label for="" class="form-label">Username</label>
                            <input
                                v-model="form.name"
                                type="text"
                                name=""
                                id=""
                                :class="[
                                    'form-control',
                                    { 'is-invalid': errors.name },
                                ]"
                            />
                            <small
                                class="invalid-feedback"
                                v-if="errors.name"
                                >{{ errors.name }}</small
                            >
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input
                                v-model="form.email"
                                type="email"
                                name=""
                                id=""
                                :class="[
                                    'form-control',
                                    { 'is-invalid': errors.email },
                                ]"
                            />
                            <small
                                class="invalid-feedback"
                                v-if="errors.email"
                                >{{ errors.email }}</small
                            >
                        </div>
                        <div class="mb-3">
                            <input
                                type="file"
                                name=""
                                class="form-control"
                                accept="image/jpeg,image/png"
                                @input="form.photo = $event.target.files[0]"
                                id=""
                            />
                            <div class="progress mt-3" v-if="form.progress">
                                <div
                                    class="progress-bar progress-bar-striped"
                                    role="progressbar"
                                    :style="`width: ${form.progress.percentage}%`"
                                ></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button
                                class="btn btn-primary"
                                :disabled="form.processing"
                            >
                                <span
                                    v-if="form.processing"
                                    class="spinner-grow spinner-grow-sm"
                                    role="status"
                                    aria-hidden="true"
                                ></span>
                                Create Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </base-layout>
</template>

<script>
// import { Inertia } from "@inertiajs/inertia";
// import { ref } from "vue";
import { showToast } from "../../Composables/ShowToast";
import { useForm, usePage } from "@inertiajs/inertia-vue3";

export default {
    props: ["errors", "status"],
    setup(props) {
        // let page = usePage();
        // console.log(page.url.effect);
        let form = useForm({
            name: null,
            email: null,
            photo: null,
        });
        let save = () => {
            // return console.log(form.photo);
            form.post("/user", {
                preserveScroll: true,
                onProgress: () => {
                    console.log(form.progress.percentage);
                },
                onSuccess: () => {
                    form.reset();
                    showToast(props.status);
                },
            });
        };
        return { form, save };
    },
};
</script>

<style lang="scss" scoped></style>
