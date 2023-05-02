<template>
  <div class="news-cards">
    <div v-for="item in items" :key="item.link" class="news-card">
      <div class="news-description" v-html="item.description"></div>
      <a :href="item.link" target="_blank" class="item-link">
        <img
          src="@/assets/images/fake-news-small.jpeg"
          alt="news image"
          class="news-image"
        />
      </a>
      <div class="news-footer">
        <p class="news-source">{{ item.source }}</p>
        <p class="news-date">{{ item.pubDate }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    items: Array,
  },
}
</script>

<style lang="scss">
@import '@/styles/components/news_list/_news_list.scss';
</style>
