<template>
    <div>
        <nav aria-label="..." class="shadow">
            <ul class="pagination">
                <li
                    :class="[
                        'page-item',
                        { active: link.active, disabled: link.url === null },
                    ]"
                    v-for="(link, ind) in links"
                    :key="ind"
                >
                    <Link
                        class="page-link"
                        :href="link.url"
                        v-if="link.url"
                        v-html="link.label"
                    ></Link>
                    <span class="page-link" v-else v-html="link.label"></span>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    props: ["links"],
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
