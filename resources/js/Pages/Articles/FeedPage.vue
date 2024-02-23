<script setup>
import {Head} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import ArticlesList from "@/Components/Article/ArticlesList.vue";
import AdvertPlaceholder from "@/Components/Advert/AdvertPlaceholder.vue";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";

defineProps({
  articles: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <MainLayout>
    <Head :title="$trans('My feed')"/>

    <div class="space-y-4">
      <header class="w-full p-4 bg-white flex justify-between items-center">
        <h1 class="text-xl text-gray-700 font-semibold">
          {{ $trans('My feed') }}
        </h1>

<!--         TODO: add link to topics subscriptions-->
        <OutlineButton
          color="success"
          class="!py-0.5 space-x-2"
        >
          <MaterialIcon class="material-icons !text-xl !text-inherit">
            settings
          </MaterialIcon>

          <span>Subscriptions</span>
        </OutlineButton>
      </header>

      <ArticlesList :articles="articles"/>
    </div>

    <template v-slot:sidebar>
      <AdvertPlaceholder/>
    </template>
  </MainLayout>
</template>
