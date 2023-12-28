<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination/Pagination.vue";
import ArticleCard from "@/Components/Article/ArticleCard.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import ArticlesPlaceholder from "@/Pages/User/Partials/ArticlesPlaceholder.vue";
import NavigationWrapper from "@/Pages/User/Partials/NavigationWrapper.vue";

const props = defineProps({
  articles: {
    type: Object,
    required: true,
  },

  user: {
    type: Object,
    required: true,
  },
});

const currentLink = ref('articles');

const navigation = {
  articles: route('user.bookmarks.articles', {user: props.user.login}),
  comments: route('user.bookmarks.comments', {user: props.user.login}),
};

const selectLink = (value) => {
  router.get(navigation[value]);
};
</script>

<template>
  <UserLayout
    current-tab="bookmarks"
    :user="user"
  >
    <NavigationWrapper
      :navigation="Object.keys(navigation)"
      :current-link="currentLink"
      @select="selectLink"
    >
      <div
        class="space-y-4"
        v-if="articles.items.length > 0"
      >
        <ArticleCard
          v-for="article in articles.items"
          :key="article.id"
          :article="article"
        />

        <Pagination
          v-if="articles.totalPages > 1"
          :query-params="articles.query"
          :total-pages="articles.totalPages"
          :current-page="articles.currentPage"
          route-name="user.bookmarks.articles"
          :queryParams="{user: user.login}"
        />
      </div>

      <ArticlesPlaceholder v-else class="mt-16"/>
    </NavigationWrapper>
  </UserLayout>
</template>
