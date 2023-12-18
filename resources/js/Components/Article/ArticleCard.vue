<script setup>
import axios from "axios";
import {inject} from "vue";
import {Link, usePage} from "@inertiajs/vue3";
import Avatar from "@/Components/Avatar.vue";
import ViewsIcon from "@/Components/Icons/ViewsIcon.vue";
import PrimaryOutlineButton from "@/Components/Buttons/PrimaryOutlineButton.vue";
import DifficultyIcon from "@/Components/Icons/DifficultyIcon.vue";
import DurationIcon from "@/Components/Icons/DurationIcon.vue";
import EditIcon from "@/Components/Icons/EditIcon.vue";
import RestoreIcon from "@/Components/Icons/RestoreIcon.vue";
import DeleteIcon from "@/Components/Icons/DeleteIcon.vue";
import LikesIcon from "@/Components/Icons/LikesIcon.vue";
import CommentsIcon from "@/Components/Icons/CommentsIcon.vue";
import BookmarkIcon from "@/Components/Icons/BookmarkIcon.vue";
import ShareIcon from "@/Components/Icons/ShareIcon.vue";

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

const notify = inject('notify');

const user = usePage().props.auth.user;

const toggleBookmark = (value) => {
  if (!user) {
    notify('error', 'Log in to bookmark this article');
    return;
  }

  axios({
    method: value ? 'post' : 'delete',
    url: route('api.articles.bookmark', {article: props.article}),
  });
};
</script>

<template>
  <article class="p-4 sm:p-6 bg-white flex flex-col items-start">
    <header class="mb-2 w-full flex flex-wrap items-center justify-between">
      <div class="order-2 sm:order-1 flex items-center space-x-2">
        <Avatar :value="article.author.avatar"/>

        <div class="flex flex-wrap items-center">
          <p class="text-sm text-gray-600 font-semibold !leading-4 mr-2">
            {{ article.author.name }}
          </p>

          <p class="text-xs text-gray-400 font-bold">
            {{ article.publish_date ? $formatDate(article.publish_date, 'MMM D YYYY [at] kk:mm') : article.status }}
          </p>
        </div>
      </div>

      <div
        class="order-1 sm:order-2 w-full sm:w-auto space-x-2 flex justify-end"
        v-if="user?.id === article.author.id"
      >
        <EditIcon v-if="article.status !== 'deleted'"/>
        <RestoreIcon v-else/>
        <DeleteIcon @click="$emit('delete', article)"/>
      </div>
    </header>

    <h2
      class="mb-1 text-lg sm:text-xl text-gray-700 font-black"
      :class="{'hover:text-sky-600 transition duration-200 cursor-pointer': readable}"
    >
      {{ article.title }}
    </h2>

    <div class="mb-1 flex items-center space-x-4">
      <DifficultyIcon
        v-if="article.difficulty"
        :value="article.difficulty"
      />
      <DurationIcon value="20"/>
      <ViewsIcon :count="article.views ?? 4352"/>
    </div>

    <div
      class="mb-4 flex flex-wrap"
      v-if="article.topics.length > 0"
    >
      <Link
        class="mr-2 text-sm text-gray-500 font-medium hover:text-sky-600 transition after:content-[','] after:last:content-['']"
        v-for="topic in article.topics"
        :key="topic.id"
        href="#"
      >
        {{ topic.name }}
      </Link>
    </div>

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
      @click="$emit('open', article)"
    >
      <span>Read more</span>
      <span class="material-icons ml-2">
        arrow_right_alt
      </span>
    </PrimaryOutlineButton>

    <footer class="w-full w-full flex text-gray-400 justify-between sm:justify-start sm:space-x-8">
      <LikesIcon
        :disabled="!readable"
        :is-liked="article.is_liked ?? false"
        :count="article.likes ?? 898"
      />

      <CommentsIcon :count="article.comments ?? 345"/>

      <BookmarkIcon
        :disabled="!readable"
        :is-bookmarked="article.is_bookmarked"
        @bookmark="toggleBookmark"
      />

      <ShareIcon v-if="readable"/>
    </footer>
  </article>
</template>
