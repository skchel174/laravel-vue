<script setup>
import {computed} from "vue";
import {Link, usePage} from "@inertiajs/vue3";
import VIcon from "@/Components/VIcon.vue";

const page = usePage();

const locale = computed(() => {
  return Object
    .keys(page.props.localization.langs)
    .find(locale => locale !== page.props.localization.locale);
});

const lang = computed(() => {
  return page.props.localization.langs[locale.value];
});
</script>

<template>
  <div class="flex-1 flex-center flex-col bg-white sm:bg-gray-100">
    <div class="flex-1"/>

    <div class="w-full flex-2 flex-center flex-col space-y-4">
      <slot/>
    </div>

    <div class="flex-1 flex items-center">
      <Link
        class="flex-center text-sm text-gray-500 space-x-1.5"
        as="button"
        :href="route('appearance', {locale})"
        method="put"
      >
        <VIcon
          class="!text-xl"
          name="language"
        />

        <span>
          {{ $trans(lang) }}
        </span>
      </Link>
    </div>
  </div>
</template>
