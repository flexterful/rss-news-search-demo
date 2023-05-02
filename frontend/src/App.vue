<template>
  <div id="app">
    <SearchForm @searched="updateItems" @clearResults="clearResults" />
    <NewsTable :items="items" />
  </div>
</template>

<script>
import SearchForm from './components/SearchForm.vue' // corrected this line
import NewsTable from './components/NewsList.vue' // corrected this line

export default {
  name: 'app',
  components: {
    NewsTable,
    SearchForm,
  },
  data() {
    return {
      items: [],
    }
  },
  methods: {
    updateItems(newItems) {
      this.items = newItems
    },
    clearResults() {
      this.items = []
    },
  },
}
</script>

<style lang="scss">
@import '@/styles/app.scss';
</style>
