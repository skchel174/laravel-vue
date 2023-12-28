<script setup>
import {router} from "@inertiajs/vue3";
import PrimaryOutlineButton from "@/Components/Buttons/PrimaryOutlineButton.vue";
import ArticleReaction from "@/Components/Article/ArticleReaction.vue";
import ArticleAuthor from "@/Components/Article/ArticleAuthor.vue";
import ArticleInfo from "@/Components/Article/ArticleInfo.vue";
import ArticleTopics from "@/Components/Article/ArticleTopics.vue";

const props = defineProps({
  article: {
    type: Object,
    required: true,
  },

  readable: {
    type: Boolean,
    default: true,
  },
});

const openArticle = () => {
  if (props.readable) {
    router.get(route('article', {article: props.article.id}));
  }
};
</script>

<template>
  <article class="p-4 sm:p-6 bg-white flex flex-col items-start">
    <ArticleAuthor
      class="mb-2"
      :article-id="article.id"
      :status="article.status"
      :author="article.author"
      :publish-date="article.publish_date"
    />

    <h2
      class="mb-1 text-lg sm:text-xl text-gray-700 font-black"
      :class="{'hover:text-sky-600 transition duration-200 cursor-pointer': readable}"
      @click="openArticle"
    >
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

    <img
      class="mb-2 w-full max-w-full max-h-[28rem] aspect-square object-cover rounded-sm cursor-pointer"
      :src="article.image?.md ?? 'https://tailwindui.com/img/ecommerce-images/home-page-02-edition-01.jpg'"
      alt="img"
    />

    <p
      v-if="article.summary"
      class="mb-4 text-sm sm:text-base text-gray-800  break-words"
    >
      {{ article.summary }}
    </p>

    <PrimaryOutlineButton
      class="mb-6 inline-block"
      v-if="readable"
      @click="openArticle"
    >
      <span>Read more</span>
      <span class="material-icons ml-2">
        arrow_right_alt
      </span>
    </PrimaryOutlineButton>

    <footer class="w-full w-full flex text-gray-400 justify-between sm:justify-start sm:space-x-8">
      <ArticleReaction
        :article-id="article.id"
        :is-liked="article.is_liked"
        :likes-count="article.likes_count"
        :is-bookmarked="article.is_bookmarked"
        :comments-count="article.comments_count"
      />
    </footer>
  </article>
</template>
