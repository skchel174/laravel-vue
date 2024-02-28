<script setup>
import {ref} from "vue";
import {router, Head} from "@inertiajs/vue3";
import ArticlesList from "@/Components/ArticlesList/ArticlesList.vue";
import MenuSelect from "@/Pages/User/Partials/MenuSelect.vue";
import PageLayout from "@/Pages/User/Partials/PageLayout.vue";

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
  articles: 'user.bookmarks.articles',
  comments: 'user.bookmarks.comments',
};

const selectLink = (value) => {
  router.get(route(navigation[value], {
    user: props.user.login,
  }));
};
</script>

<template>
  <PageLayout
    current-tab="bookmarks"
    :user="user"
  >
    <Head :title="$ucfirst($trans('articles'))"/>

    <MenuSelect
      :items="Object.keys(navigation)"
      :selected-item="currentLink"
      @select="selectLink"
    />

    <ArticlesList
      class="mt-4"
      :articles="articles"
    />
  </PageLayout>
</template>
