<script setup>
import useLocale from "@/Hooks/useLocale.js";
import Checkbox from "@/Components/Form/Checkbox.vue";
import RadioButton from "@/Components/Form/RadioButton.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";

const emit = defineEmits(['close']);

const {locale, langs, toggleLang, save} = useLocale();

const savePreferences = () => {
  save();

  emit('close');
};
</script>

<template>
  <div>
    <header class="px-4 py-6 flex justify-between items-center">
      <h3 class="text-lg text-gray-700 font-semibold">
        {{ $trans('Language settings') }}
      </h3>

      <MaterialIcon
        clickable
        @click="$emit('close')"
      >
        close
      </MaterialIcon>
    </header>

    <div class="px-4 py-2.5 bg-sky-50">
      <p class="text-gray-500 font-medium">
        {{ $trans('Interface') }}
      </p>
    </div>

    <div class="px-4 py-6">
      <RadioButton
        class="mb-6"
        label="English"
        :selected="locale === 'en'"
        @select="() => locale = 'en'"
      />

      <RadioButton
        label="Русский"
        :selected="locale === 'ru'"
        @select="() => locale = 'ru'"
      />
    </div>

    <div class="px-4 py-2.5 bg-sky-50">
      <p class="text-gray-500 font-medium">
        {{ $trans('Content') }}
      </p>
    </div>

    <div class="px-4 py-6">
      <Checkbox
        class="mb-6"
        label="English"
        :checked="langs.includes('en')"
        @toggle="() => toggleLang('en')"
      />

      <Checkbox
        label="Русский"
        :checked="langs.includes('ru')"
        @toggle="() => toggleLang('ru')"
      />

      <p
        class="mt-6 text-sm text-red-500"
        v-if="langs.length === 0"
      >
        {{ $trans('language_not_select') }}
      </p>
    </div>

    <div class="p-4">
      <FilledButton
        color="primary"
        class="w-full !py-2.5"
        @click="savePreferences"
      >
        {{ $trans('Save preferences') }}
      </FilledButton>
    </div>
  </div>
</template>
