 <script setup>
import {computed} from "vue";
import {router} from "@inertiajs/vue3";
import ArticleReaction from "@/Components/Article/ArticleReaction.vue";
import ArticleInfo from "@/Components/Article/ArticleInfo.vue";
import ArticleTopics from "@/Components/Article/ArticleTopics.vue";
import ArticleHeader from "@/Components/Article/ArticleHeader.vue";
import ArticleAuthor from "@/Components/Article/ArticleAuthor.vue";
import ArticleActions from "@/Components/Article/ArticleActions.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";

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
    <ArticleHeader class="mb-4">
      <ArticleAuthor
        :author="article.author"
        :publish-date="article.publish_date"
      />

      <template v-slot:actions>
        <ArticleActions
          v-if="article.author.id === $page.props.auth.user?.id"
          :article-id="article.id"
          :article-status="article.status"
        />
      </template>
    </ArticleHeader>

    <h2
      class="mb-1 text-lg sm:text-xl text-gray-700 font-black"
      :class="{'hover:text-sky-775 transition duration-200 cursor-pointer': readable}"
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
      class="mb-4 w-full max-w-full max-h-[28rem] aspect-square object-cover rounded-sm cursor-pointer"
      :src="article.image ?? 'https://loremflickr.com/640/480/business?lock=' + article.id"
      alt="img"
      @click="openArticle"
    />

    <p
      v-if="article.summary"
      class="mb-10 text-sm sm:text-base text-gray-700 break-words"
    >
      {{ article.summary }}
    </p>

    <OutlineButton
      color="primary"
      class="mb-6 inline-block !py-1.5"
      @click="openArticle"
    >
      <div v-if="article.button_text">
        {{ article.button_text }}
      </div>

      <div v-else class="flex items-center">
        <span>{{ $trans('Read more') }}</span>
        <MaterialIcon class="ml-2">
          arrow_right_alt
        </MaterialIcon>
      </div>
    </OutlineButton>

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
