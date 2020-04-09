export const state = () => ({
	categories: [],
})

export const mutations = {
	SET_CATEGORIES (state, categories) {
		state.categories = categories
	},
}

export const actions = {
	async nuxtServerInit ({ dispatch }) {
		await dispatch('getCategories')
	},

	async getCategories ({ commit }) {
		let response = await this.$axios.$get('article-categories')
		commit('SET_CATEGORIES', response.data)
	}
}