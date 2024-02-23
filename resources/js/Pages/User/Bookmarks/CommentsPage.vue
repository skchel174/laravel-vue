<script setup>
import {ref} from "vue";
import {router, Head} from "@inertiajs/vue3";
import MenuSelect from "@/Pages/User/Partials/MenuSelect.vue";
import CommentsList from "@/Components/Comment/List/CommentsList.vue";
import PageLayout from "@/Pages/User/Partials/PageLayout.vue";

const props = defineProps({
  comments: {
    type: Object,
    required: true,
  },

  user: {
    type: Object,
    required: true,
  },
});

const currentLink = ref('comments');

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
    <Head :title="$ucfirst($trans('comments'))"/>

    <MenuSelect
      :items="Object.keys(navigation)"
      :selected-item="currentLink"
      @select="selectLink"
    />

    <CommentsList
      class="mt-4"
      :comments="comments"
    />
  </PageLayout>
</template>
