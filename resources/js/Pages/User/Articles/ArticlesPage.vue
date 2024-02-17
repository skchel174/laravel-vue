<script setup>
import {computed, ref} from "vue";
import {router, usePage} from "@inertiajs/vue3";
import UserLayout from "@/Layouts/User/UserLayout.vue";
import NavigationSelect from "@/Pages/User/Partials/NavigationSelect.vue";
import ArticlesList from "@/Components/Article/ArticlesList.vue";

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
      <ArticlesList
        class="mt-4"
        :articles="articles"
      />
    </NavigationSelect>
  </UserLayout>
</template>
