<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import SuccessOutlineButton from "@/Components/Buttons/SuccessOutlineButton.vue";
import ArticlesList from "@/Components/Article/ArticlesList.vue";

defineProps({
  articles: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <MainLayout>
    <div class="space-y-4">
      <header class="w-full p-4 sm:px-6 bg-white flex justify-between items-center">
        <h1 class="text-xl text-gray-700 font-semibold">
          {{ $trans('My feed') }}
        </h1>

        <!-- TODO: add link to topics subscriptions -->
        <SuccessOutlineButton class="!py-0.5 space-x-2">
          <MaterialIcon class="material-icons !text-xl !text-inherit">
            settings
          </MaterialIcon>

          <span>Subscriptions</span>
        </SuccessOutlineButton>
      </header>

      <ArticlesList :articles="articles"/>
    </div>


  </MainLayout>
</template>
