<script setup>
import {ref} from "vue";
import useMedia from "@/Hooks/useMedia.js";
import {router, usePage} from "@inertiajs/vue3";
import Popover from "@/Components/Popover.vue";
import UserLayout from "@/Layouts/User/UserLayout.vue";
import StatusSelect from "@/Pages/User/Articles/Partials/StatusSelect.vue";
import StatusSelectButton from "@/Pages/User/Articles/Partials/StatusSelectButton.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import ArticlesPlaceholder from "@/Pages/User/Articles/Partials/ArticlesPlaceholder.vue";
import ArticleCard from "@/Components/Article/ArticleCard.vue";

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

const statusesOpen = ref(false);

const status = ref(props.status);

const toggleStatuses = () => {
  statusesOpen.value = !statusesOpen.value;
};

const selectStatus = (value) => {
  status.value = value;
  statusesOpen.value = false;
  router.get(route('user.articles', {user: props.user.login, status: value}));
};

const isTablet = useMedia('(max-width: 1024px)');
</script>

<template>
  <UserLayout
    current-tab="articles"
    :user="user"
  >
    <div class="relative">
      <div
        v-if="user.id === auth.user?.id"
        class="relative p-4 bg-white z-10"
      >
        <StatusSelectButton
          :status="status"
          :open="statusesOpen"
          @click.stop="toggleStatuses"
        />

        <Popover
          v-if="!isTablet"
          class="top-9 left-3"
          v-model:open="statusesOpen"
        >
          <StatusSelect
            :statuses="statuses"
            :current-status="status"
            @select="selectStatus"
          />
        </Popover>
      </div>

      <TransitionGroup
        enter-from-class="translate-y-[-100%]"
        enter-to-class="translate-y-0"
        enter-active-class="transition-transform duration-500"
        leave-from-class="translate-y-0"
        leave-to-class="translate-y-[-100%]"
        leave-active-class="absolute transition-transform duration-500"
        move-class="transition-transform duration-500"
      >
        <StatusSelect
          class="w-full !bg-sky-50"
          v-if="isTablet && statusesOpen"
          :key="1"
          :statuses="statuses"
          :current-status="status"
          @select="selectStatus"
        />

        <div
          class="mt-4 transition-transform"
          :key="2"
        >
          <div
            class="space-y-4"
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

          <ArticlesPlaceholder
            v-else
            class="mt-16"
          />
        </div>
      </TransitionGroup>
    </div>
  </UserLayout>
</template>
