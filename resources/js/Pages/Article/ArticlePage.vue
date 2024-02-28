<script setup>
import {Head} from "@inertiajs/vue3";
import ArticleInfo from "@/Components/Article/ArticleInfo.vue";
import ArticleTopics from "@/Components/Article/ArticleTopics.vue";
import TopicsList from "@/Pages/Article/Partials/TopicsList.vue";
import TagsList from "@/Pages/Article/Partials/TagsList.vue";
import ArticleFooter from "@/Pages/Article/Partials/ArticleFooter.vue";
import ArticleReaction from "@/Components/Article/ArticleReaction.vue";
import CommentsButton from "@/Pages/Article/Partials/CommentsButton.vue";
import ArticleHeader from "@/Components/Article/ArticleHeader.vue";
import MainLayout from "@/Components/Layouts/MainLayout.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";
import ArticleAuthor from "@/Components/Article/ArticleAuthor.vue";
import AuthorWidget from "@/Pages/Article/Partials/AuthorWidget.vue";

const props = defineProps({
  article: {
    type: Object,
    required: true,
  },

  authorSubscription: {
    type: Boolean,
    required: true,
  },
});
</script>

<template>
  <MainLayout>
    <Head :title="article.title"/>

    <div class="bg-white">
      <div class="p-4">
        <ArticleHeader class="mb-2">
          <ArticleAuthor
            :author="article.author"
            :publish-date="article.publish_date"
          />
        </ArticleHeader>

        <h2 class="mb-1 text-lg sm:text-xl text-gray-700 font-black">
          {{ article.title }}
        </h2>

        <ArticleInfo
          class="mb-1"
          :views-count="article.views"
          :duration="20"
          :difficulty="article.difficulty"
        />

        <ArticleTopics
          class="mb-6"
          :topics="article.topics"
        />

        <div
          class="mb-4 text-sm sm:text-base text-gray-700 break-words"
          v-html="article.text"
        />

        <TopicsList
          class="mb-2"
          :topics="article.topics"
        />

        <TagsList
          v-if="article.tags.length > 0"
          :tags="article.tags"
        />
      </div>

      <ArticleFooter>
        <ArticleReaction
          :article-id="article.id"
          :is-bookmarked="article.is_bookmarked"
          :comments-count="article.comments_count"
        />
      </ArticleFooter>
    </div>

    <AuthorWidget
      class="mt-4"
      :author="article.author"
      :subscription="authorSubscription"
    />

    <CommentsButton
      class="mt-4"
      v-if="article.comments_count > 0"
      :article-id="article.id"
      :comments-count="article.comments_count"
    />

    <template v-slot:sidebar>
      <AdvertPlaceholder/>
    </template>
  </MainLayout>
</template>
