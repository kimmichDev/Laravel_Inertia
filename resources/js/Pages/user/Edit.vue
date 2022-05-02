<template>
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
                    <div class="d-flex justify-content-center">
                        <img
                            :src="user.photo"
                            class="rounded-circle text-center edit-thumbnail"
                            alt=""
                        />
                    </div>
                    <form @submit.prevent="update">
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
                                @input="form.photo = $event.target.files[0]"
                                :key="Math.random()"
                                type="file"
                                name=""
                                class="form-control"
                                accept="image/jpeg,image/png"
                                id=""
                            />
                        </div>
                        <div class="mb-3" v-if="form.progress">
                            <div class="progress">
                                <div
                                    class="progress-bar progress-bar-striped progress-bar-animated"
                                    role="progressbar"
                                    :style="`width:${form.progress.percentage}%`"
                                ></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button
                                class="btn btn-primary"
                                :disabled="form.processing"
                            >
                                Update Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </base-layout>
</template>

<script>
import { showConfirm } from "../../Composables/ShowConfirm";
import { useForm } from "@inertiajs/inertia-vue3";
import { showToast } from "../../Composables/ShowToast";

export default {
    props: ["user", "query", "errors", "status"],
    setup(props) {
        let form = useForm({
            name: props.user.name,
            email: props.user.email,
            photo: null,
            _method: "put",
        });
        let update = () => {
            showConfirm(() => {
                form.post("/user/" + props.user.id, {
                    onSuccess: () => {
                        form.reset("photo");
                        showToast(props.status);
                    },
                    onProgress: () => console.log(form.progress.percentage),
                });
            });
        };
        return { form, update };
    },
};
</script>

<style lang="scss" scoped></style>
