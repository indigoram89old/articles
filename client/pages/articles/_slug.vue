<template>
    <section>
        <div class="container">
            A single article page
        </div>
    </section>
</template>

<script>
    export default {
        async asyncData({ app, params }) {
            const response = await app.$axios.$get(`/articles/${params.slug}`, {
                params: { with: 'categories,media,contents' },
            })
            
            return {
                article: response.data,
            }
        },
    }
</script>