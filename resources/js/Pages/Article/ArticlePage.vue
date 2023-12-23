<script setup>
import {Head} from '@inertiajs/vue3';
import MainWrapper from "@/Components/MainWrapper.vue";
import AppHeader from "@/Components/AppHeader/AppHeader.vue";
import AdvertWrapper from "@/Components/Advert/AdvertWrapper.vue";
import NotificationWrapper from "@/Components/NotificationWrapper.vue";
import ArticleInfo from "@/Components/Article/ArticleInfo.vue";
import ArticleTopics from "@/Components/Article/ArticleTopics.vue";
import TopicsList from "@/Pages/Article/Partials/TopicsList.vue";
import TagsList from "@/Pages/Article/Partials/TagsList.vue";
import ArticleAuthor from "@/Components/Article/ArticleAuthor.vue";
import ArticleFooter from "@/Pages/Article/Partials/ArticleFooter.vue";
import ArticleReaction from "@/Components/Article/ArticleReaction.vue";
import Comment from "@/Components/Comment/Comment.vue";

defineProps({
  article: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <Head :title="article.title"/>

  <AppHeader/>

  <NotificationWrapper>
    <MainWrapper>
      <AdvertWrapper>
        <div class="bg-white">
          <div class="p-4">
            <ArticleAuthor
              class="mb-4"
              :article-id="article.id"
              :status="article.status"
              :author="article.author"
              :publish-date="article.publish_date"
            />

            <h2 class="mb-1 text-lg sm:text-xl text-gray-700 font-black">
              {{ article.title }}
            </h2>

            <ArticleInfo
              class="mb-1"
              :views-count="article.views ?? 4352"
              :duration="20"
              :difficulty="article.difficulty"
            />

            <ArticleTopics
              class="mb-4"
              :topics="article.topics"
            />

            <div
              class="mb-4 text-sm sm:text-base text-gray-800 break-words"
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
              :is-liked="article.is_liked"
              :likes-count="article.likes_count"
              :is-bookmarked="article.is_bookmarked"
              :comments-count="article.comments_count"
            />
          </ArticleFooter>
        </div>

        <div class="mt-4 bg-white">
          <div>
            <h3 class="p-4 text-lg text-gray-700 font-bold">
              Comments

              <span class="ml-2 text-sky-600">
                {{ article.total_comments }}
              </span>
            </h3>
          </div>

          <Comment
            class="mb-2"
            v-for="comment in article.comments"
            :key="comment.id"
            :comment="comment"
            :article-id="article.id"
          />
        </div>
      </AdvertWrapper>
    </MainWrapper>
  </NotificationWrapper>
</template>
