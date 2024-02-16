<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import UserLayout from "@/Layouts/User/UserLayout.vue";
import NavigationSelect from "@/Pages/User/Partials/NavigationSelect.vue";
import ArticlesList from "@/Components/Article/ArticlesList.vue";

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
    <NavigationSelect
      :navigation="Object.keys(navigation)"
      :current-link="currentLink"
      @select="selectLink"
    >
      <ArticlesList
        class="mt-4"
        :articles="articles"
      />
    </NavigationSelect>
  </UserLayout>
</template>
