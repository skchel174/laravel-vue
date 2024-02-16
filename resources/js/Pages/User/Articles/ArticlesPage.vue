<script setup>
import {computed, ref, watch} from "vue";
import {router, usePage} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination/Pagination.vue";
import ArticleCard from "@/Components/Article/ArticleCard.vue";
import UserLayout from "@/Layouts/User/UserLayout.vue";
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

  notice: {
    type: String,
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

        <Pagination :items="articles"/>
      </div>

      <div v-else class="mt-16 w-full flex flex-col items-center space-y-8 text-base text-gray-400 font-bold">
        {{ $trans('empty_articles') }}
      </div>
    </NavigationSelect>
  </UserLayout>
</template>
