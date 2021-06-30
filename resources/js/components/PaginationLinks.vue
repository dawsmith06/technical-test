<template>
    <div
        id="pagination-links"
        ref="container"
        class="fadeIn  animated custom-scrollbar"
        v-show="ready"
    >
        <button
            class="btn btn-xs"
            v-for="(page, key) in pagination.pages"
            :key="key"
            :class="page == pagination.selectedPage ? 'btn-primary' : ''"
            ref="link"
            @click="selectPage($event, page)"
        >
            {{ page }}
        </button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            ready: false
        };
    },

    methods: {
        selectPage(e, page) {
            this.scrollToPage(e, page);
            this.request.set("page", page);
            this.$emit("change", page);
        },

        scrollToPage(e, page) {
            let $container = this.$refs["container"];
            let $elem = this.$refs["link"][page - 1];
            let left = e.layerX - $container.clientWidth / 3 - 30;
            $container.scrollLeft = left;
        }
    },

    computed: {
        pagination() {
            let totalPages = Math.ceil(this.data.total / this.data.per_page);
            let pages = [];
            for (let i = 1; i <= totalPages; i++) {
                pages.push(i);
            }
            return {
                pages: pages,
                selectedPage: this.data.current_page
            };
        }
    },

    props: {
        data: Object
    },

    mounted() {
        this.ready = true;
        setTimeout(() => {
            if (this.pagination.pages.length >= this.pagination.selectedPage) {
                this.$refs.link[
                    this.pagination.selectedPage - 1
                ].scrollIntoView(false);
            }
        }, 500);
    }
};
</script>

<style>
#pagination-links {
    scroll-behavior: smooth;
    transition-duration: 800ms;
    max-width: 170px;
    display: flex;
    overflow-x: auto;
    max-height: 371px;
}
#pagination-links button {
    padding: 1px 5px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 0;
    border-right: 1px solid #eee;
}
</style>
