<script setup>
import {computed} from "vue";
import {Link, usePage} from "@inertiajs/vue3";
import VIcon from "@/Components/VIcon.vue";
import ThemeWrapper from "@/Components/ThemeWrapper.vue";
import AppAlertWrapper from "@/Components/AppAlertWrapper.vue";

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
  <ThemeWrapper>
    <AppAlertWrapper>
      <div class="flex-1 flex flex-col flex-col items-center justify-between bg-color-base sm:bg-color-dark">
        <div/>

        <div class="w-full flex flex-col items-center space-y-4">
          <slot/>
        </div>

        <div class="flex items-center pb-4">
          <Link
            class="flex-center text-sm text-color-light space-x-1.5"
            :href="route('appearance', {locale})"
            method="put"
            as="button"
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
    </AppAlertWrapper>
  </ThemeWrapper>
</template>
