 <script setup>
import {computed} from "vue";
import {router} from "@inertiajs/vue3";
import PrimaryOutlineButton from "@/Components/Buttons/PrimaryOutlineButton.vue";
import ArticleReaction from "@/Components/Article/ArticleReaction.vue";
import ArticleInfo from "@/Components/Article/ArticleInfo.vue";
import ArticleTopics from "@/Components/Article/ArticleTopics.vue";
import ArticleHeader from "@/Components/Article/ArticleHeader.vue";

const props = defineProps({
  article: {
    type: Object,
    required: true,
  },
});

const readable = computed(() => props.article.status === 'published');

const openArticle = () => {
  if (readable.value) {
    router.get(route('article', {article: props.article.id}));
  }
};
</script>

<template>
  <article class="p-4 bg-white flex flex-col items-start">
    <ArticleHeader
      class="mb-2"
      :article="article"
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
      :src="article.image ?? 'https://tailwindui.com/img/ecommerce-images/home-page-02-edition-01.jpg'"
      alt="img"
    />

    <p
      v-if="article.summary"
      class="mb-4 text-sm sm:text-base text-gray-800 break-words"
    >
      {{ article.summary }}
    </p>

    <PrimaryOutlineButton
      class="mb-6 inline-block"
      @click="openArticle"
    >
      <div v-if="article.button_text">
        {{ article.button_text }}
      </div>

      <div v-else class="flex items-center">
        <span>{{ $trans('Read more') }}</span>
        <span class="material-icons ml-2">arrow_right_alt</span>
      </div>
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
