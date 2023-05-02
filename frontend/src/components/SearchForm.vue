<template>
  <div class="search-form">
    <div class="search-container">
      <div class="search-header-container">
        <p class="search-header">News Search</p>
        <div
          class="language-selector"
          v-click-outside="outsideClick"
          @click="toggleDropdown"
          :class="{ 'dropdown-open': isDropdownOpen }"
        >
          {{ selectedLanguage.label }}
          <svg
            class="arrow-icon"
            focusable="false"
            aria-hidden="true"
            viewBox="0 0 24 24"
          >
            <path d="M7 10l5 5 5-5z"></path>
          </svg>
          <div v-if="isDropdownOpen" class="language-dropdown">
            <div class="language-dropdown-backdrop" aria-hidden="true"></div>
            <ul>
              <li
                v-for="language in languages"
                :key="language.value"
                :class="{ selected: language.value === selectedLanguage.value }"
                @click.stop="selectLanguage(language)"
              >
                {{ language.label }}
              </li>
            </ul>
          </div>
        </div>
      </div>
      <form class="search-controls-container" @submit.prevent="search">
        <div class="search-input-container">
          <input
            type="text"
            v-model="keywords"
            placeholder="Enter keywords"
            required
          />
          <p v-if="keywordsError" class="error-message">
            Enter at least one keyword
          </p>
        </div>
        <button class="search-button" type="submit">
          <h6>Search</h6>
        </button>
      </form>
    </div>

    <!--  Loader  -->
    <div v-if="isLoading" class="loader-container">
      <svg class="spinner" viewBox="0 0 50 50">
        <circle
          class="path"
          cx="25"
          cy="25"
          r="20"
          fill="none"
          stroke-width="5"
        ></circle>
      </svg>
    </div>

    <!-- "Nothing found" message -->
    <p class="nothing-found-message" v-if="nothingFound">Nothing found</p>
  </div>
</template>

<script>
import axios from 'axios'
import vClickOutside from 'v-click-outside'

export default {
  name: 'SearchForm',
  data() {
    return {
      keywords: '',
      selectedLanguage: { label: 'English', value: 'en' },
      languages: [
        { label: 'English', value: 'en' },
        { label: 'German', value: 'de' },
        { label: 'French', value: 'fr' },
      ],
      isDropdownOpen: false,
      isLoading: false,
      nothingFound: false,
    }
  },
  directives: {
    'click-outside': vClickOutside.directive,
  },
  methods: {
    outsideClick() {
      this.isDropdownOpen = false
    },
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen
    },
    selectLanguage(language) {
      this.selectedLanguage = language
      this.isDropdownOpen = false
    },
    async search() {
      if (this.keywords) {
        // Emit an event to clear previous search results
        this.$emit('clearResults')
        // Display the loader, hide "nothing found" message
        this.isLoading = true
        this.nothingFound = false
        // Fetch news articles
        try {
          const response = await axios.get(process.env.VUE_APP_BACKEND_URL, {
            params: {
              keywords: this.keywords,
              language: this.selectedLanguage.value,
            },
          })

          // Check if the response data is empty
          if (response.data.length === 0) {
            // If it is, set nothingFound to true
            this.nothingFound = true
          } else {
            // Emit an event to fill the list
            this.$emit('searched', response.data)
          }
        } catch (error) {
          console.error('Error fetching data:', error)
        } finally {
          // Hide the loader
          this.isLoading = false
        }
      }
    },
  },
}
</script>

<style lang="scss">
@import '@/styles/components/search_form/_search_form.scss';
@import '@/styles/components/search_form/_loader.scss';
@import '@/styles/components/search_form/_nothing_found.scss';
</style>
