<script setup>
import {ref} from "vue";
import {router, usePage, Head} from "@inertiajs/vue3";
import ArticlesList from "@/Components/ArticlesList/ArticlesList.vue";
import MenuSelect from "@/Pages/User/Partials/MenuSelect.vue";
import PageLayout from "@/Pages/User/Partials/PageLayout.vue";

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

const selectStatus = (status) => {
  router.get(route('user.articles', {
    user: props.user.username,
    status,
  }));
};
</script>

<template>
  <PageLayout
    current-tab="articles"
    :user="user"
  >
    <Head :title="$ucfirst($trans('articles'))"/>

    <MenuSelect
      v-if="auth.user?.id === user.id"
      :items="statuses"
      :selected-item="currentLink"
      @select="selectStatus"
    />

    <ArticlesList
      class="mt-4"
      :articles="articles"
    />
  </PageLayout>
</template>
