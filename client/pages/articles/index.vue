<template>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" v-model="filter.search" @input="onFilter" class="form-control" placeholder="Search">
                    </div>

                    <div class="form-group">
                        <select v-model="filter.category_id" @input="onFilter" class="form-control">
                            <option :value="null">All categories</option>
                            <option :value="_category.id" v-for="_category in categories">
                                {{ _category.title }}
                            </option>
                        </select>
                    </div>

                    <button @click="clearFilter" class="btn btn-light btn-block">Clear Filter</button>
                </div>

                <div class="col-md-8">
                    <template v-if="articles.length">
                        <div class="row">
                            <div class="col-xl-6" v-for="_article in articles_computed" :key="_article.slug">
                                <div class="card mb-3">
                                    <img src="https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80." class="card-img-top" alt="">

                                    <div class="card-body">
                                        <div class="d-flex flex-wrap mb-3">
                                            <a href="" @click.prevent="setFilter({ category_id: _category.id })" class="d-inline-block mr-1 text-muted" v-for="(_category, index) in _article.categories">
                                                {{ _category.title }}<span v-if="index < (_article.categories.length-1)">,</span>
                                            </a>
                                        </div>

                                        <a :href="_article.link" class="h5 card-title">
                                            {{ _article.title }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template v-else>
                        No articles found.
                    </template>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import _ from 'lodash'

    export default {
        async asyncData({ app }) {
            const response = await app.$axios.$get('/articles', {
                params: { with: 'categories,media' },
            })
            
            return {
                articles: response.data,
            }
        },

        data() {
            return {
                filter: {
                    search: '',
                    category_id: null,
                }
            }
        },

        methods: {
            async getArticles() {
                let response = await this.$axios.$get('articles', {
                    params: { with: 'categories,media', ...this.filter },
                })

                this.articles = response.data
            },

            setFilter(filter) {
                this.filter = _.assign(this.filter, filter)
                this.onFilter()
            },

            onFilter: _.debounce(function () {
                this.getArticles()
            }, 300),

            clearFilter() {
                this.filter = {
                    search: '',
                    category_id: null,
                }

                this.onFilter()
            }
        },

        computed: {
            articles_computed() {
                return _.map(this.articles, article => {
                    const media = _.find(article.media, { type: 'featured' })

                    return {
                        slug: article.slug,
                        title: article.title,
                        image: media ? media.link : '//via.placeholder.com/350x150',
                        categories: article.categories,
                        link: `/articles/${article.slug}`,
                    }
                })
            },

            categories() {
                return this.$store.state.categories
            },
        }
    }
</script>