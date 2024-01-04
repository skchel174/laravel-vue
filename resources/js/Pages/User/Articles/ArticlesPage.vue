<script setup>
import {computed, ref} from "vue";
import {router, usePage} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination/Pagination.vue";
import ArticleCard from "@/Components/Article/ArticleCard.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import NavigationSelect from "@/Pages/User/Partials/NavigationSelect.vue";

const props = defineProps({
  status: {
    type: String,
    required: true,
  },

  statuses: {
    type: Array,
    required: true,
  },

  articles: {
    type: Object,
    required: true,
  },

  user: {
    type: Object,
    required: true,
  },
});

const auth = usePage().props.auth;

const currentLink = ref(props.status);

const navigation = computed(() => props.statuses.filter(status => {
   return status === 'published' || props.user.id === auth.user?.id;
}));

const selectLink = (value) => {
  router.get(route('user.articles', {user: props.user.login, status: value}));
};
</script>

<template>
  <UserLayout
    current-tab="articles"
    :user="user"
  >
    <NavigationSelect
      :navigation="navigation"
      :current-link="currentLink"
      @select="selectLink"
    >
      <div
        class="mt-4 space-y-4"
        v-if="articles.items.length > 0"
      >
        <ArticleCard
          v-for="article in articles.items"
          :key="article.id"
          :article="article"
          :readable="status === 'published'"
        />

        <Pagination
          v-if="articles.totalPages > 1"
          :query-params="articles.query"
          :total-pages="articles.totalPages"
          :current-page="articles.currentPage"
          route-name="user.articles"
          :queryParams="{user: user.login, status}"
        />
      </div>

      <div v-else class="mt-16 w-full flex flex-col items-center space-y-8 text-base text-gray-400 font-bold">
        Unfortunately there are no articles here yet
      </div>
    </NavigationSelect>
  </UserLayout>
</template>
