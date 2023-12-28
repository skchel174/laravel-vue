<script setup>
import {Head, Link, usePage} from '@inertiajs/vue3';
import {provide, ref, watch} from "vue";
import MainWrapper from "@/Components/MainWrapper.vue";
import AppHeader from "@/Components/AppHeader/AppHeader.vue";
import AdvertWrapper from "@/Components/Advert/AdvertWrapper.vue";
import NotificationWrapper from "@/Components/NotificationWrapper.vue";
import ArticleInfo from "@/Components/Article/ArticleInfo.vue";
import ArticleTopics from "@/Components/Article/ArticleTopics.vue";
import ArticleAuthor from "@/Components/Article/ArticleAuthor.vue";
import ArticleReaction from "@/Components/Article/ArticleReaction.vue";
import Comment from "@/Components/Comment/Comment.vue";
import CommentForm from "@/Components/Comment/CommentForm.vue";

const props = defineProps({
  article: {
    type: Object,
    required: true,
  },

  bookmarkedComments: {
    type: Array,
    required: true,
  },
});

const user = usePage().props.auth.user;

const commentable = ref(`article_${props.article.id}`);

const setCommentable = (value) => {
  commentable.value = value;
};

provide('commentable', {
  commentable,
  setCommentable,
});

watch(commentable, () => {
  if (!commentable.value) {
    commentable.value = `article_${props.article.id}`;
  }
});
</script>

<template>
  <Head :title="article.title"/>

  <AppHeader/>

  <NotificationWrapper>
    <MainWrapper>
      <AdvertWrapper>
        <div class="p-4 bg-white">
          <ArticleAuthor
            class="mb-4"
            :article-id="article.id"
            :status="article.status"
            :author="article.author"
            :publish-date="article.publish_date"
          />

          <Link
            class="text-lg sm:text-xl text-gray-700 font-black hover:text-sky-600 transition duration-300"
            :href="route('article', {article: article.id})"
          >
            {{ article.title }}
          </Link>

          <ArticleInfo
            class="my-1"
            :views-count="article.views ?? 4352"
            :duration="20"
            :difficulty="article.difficulty"
          />

          <ArticleTopics :topics="article.topics"/>

          <footer class="px-4 h-[3rem] flex items-center bg-white stickyPanel">
            <ArticleReaction
              :article-id="article.id"
              :is-liked="article.is_liked"
              :likes-count="article.likes_count"
              :is-bookmarked="article.is_bookmarked"
              :comments-count="article.comments_count"
            />
          </footer>
        </div>

        <div
          id="comments"
          class="mt-4 bg-white"
        >
          <h3 class="p-4 text-lg text-gray-700 font-bold">
            Comments
            <span class="ml-2 text-sky-600">
              {{ article.comments_count }}
            </span>
          </h3>

          <Comment
            class="mb-2"
            v-for="comment in article.comments"
            :key="comment.id"
            :comment="comment"
            :article-id="article.id"
            :bookmarked-ids="bookmarkedComments"
          />

          <CommentForm
            v-if="user && commentable === `article_${article.id}`"
            :article-id="article.id"
          />
        </div>
      </AdvertWrapper>
    </MainWrapper>
  </NotificationWrapper>
</template>
