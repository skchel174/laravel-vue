<script setup>
import {provide, ref, watch} from "vue";
import {Head, Link, usePage} from '@inertiajs/vue3';
import ArticleInfo from "@/Components/Article/ArticleInfo.vue";
import ArticleTopics from "@/Components/Article/ArticleTopics.vue";
import ArticleReaction from "@/Components/Article/ArticleReaction.vue";
import Comment from "@/Components/Comment/Comment.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import ArticleHeader from "@/Components/Article/ArticleHeader.vue";
import MainLayout from "@/Components/Layouts/MainLayout.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";
import ArticleAuthor from "@/Components/Article/ArticleAuthor.vue";
import CommentForm from "@/Components/Comment/CommentForm.vue";

const props = defineProps({
  article: {
    type: Object,
    required: true,
  },

  comments: {
    type: Object,
    required: true,
  },

  bookmarkedComments: {
    type: Array,
    required: true,
  },
});

const user = usePage().props.auth.user;

provide('bookmarks', props.bookmarkedComments);

const commentable = ref(`article_${props.article.id}`);

provide('commentable', {
  commentable,
  setCommentable: value => commentable.value = value,
});

watch(commentable, () => {
  if (!commentable.value) {
    commentable.value = `article_${props.article.id}`;
  }
});
</script>

<template>
  <MainLayout>
    <Head :title="article.title"/>

    <div class="p-4 pb-2 bg-white">
      <ArticleHeader class="mb-4">
        <ArticleAuthor
          :author="article.author"
          :publish-date="article.publish_date"
        />
      </ArticleHeader>

      <Link
        class="mb-2 text-lg sm:text-xl text-gray-700 font-black hover:text-sky-775 transition duration-200"
        :href="route('article', {article: article.id})"
      >
        {{ article.title }}
      </Link>

      <ArticleInfo
        class="mb-2"
        :views-count="article.views"
        :duration="20"
        :difficulty="article.difficulty"
      />

      <ArticleTopics
        class="mb-4"
        :topics="article.topics"
      />

      <ArticleReaction
        :article-id="article.id"
        :is-liked="article.is_liked"
        :likes-count="article.likes_count"
        :is-bookmarked="article.is_bookmarked"
        :comments-count="article.comments_count"
      />
    </div>

    <div id="comments" class="mt-4 bg-white">
      <h3 class="p-4 pb-0 text-lg text-gray-700 font-bold capitalize">
        {{ $trans('comments') }}

        <span class="ml-2 text-sky-675">
          {{ article.comments_count }}
        </span>
      </h3>

      <Comment
        v-for="comment in comments.items"
        :key="comment.id"
        :comment="comment"
      />

      <CommentForm
        v-if="user && commentable === `article_${article.id}`"
        :article-id="article.id"
      />
    </div>

    <Pagination :items="comments"/>

    <template v-slot:sidebar>
      <AdvertPlaceholder/>
    </template>
  </MainLayout>
</template>
