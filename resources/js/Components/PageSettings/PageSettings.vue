<script setup>
import usePageSettings from "@/Hooks/usePageSettings.js";
import Checkbox from "@/Components/Form/Checkbox.vue";
import RadioButton from "@/Components/Form/RadioButton.vue";
import MaterialIcon from "@/Components/Icons/MaterialIcon.vue";
import FilledButton from "@/Components/Buttons/FilledButton.vue";
import PageSettingsSection from "@/Components/PageSettings/PageSettingsSection.vue";

const emit = defineEmits(['close']);

const {view, locale, langs, toggleLang, save} = usePageSettings();

const savePreferences = () => {
  save();
  emit('close');
};
</script>

<template>
  <div>
    <header class="px-4 py-6 flex justify-between items-center">
      <h3 class="text-lg text-gray-700 font-semibold">
        {{ $trans('Page settings') }}
      </h3>

      <MaterialIcon
        class="cursor-pointer"
        @click="$emit('close')"
      >
        close
      </MaterialIcon>
    </header>

    <PageSettingsSection :title="$trans('Interface')">
      <RadioButton
        id="en_loc"
        label="English"
        :model-value="locale === 'en'"
        @update:model-value="locale = 'en'"
      />

      <RadioButton
        id="ru_loc"
        label="Русский"
        :model-value="locale === 'ru'"
        @update:model-value="locale = 'ru'"
      />
    </PageSettingsSection>

    <PageSettingsSection :title="$trans('Content')">
      <Checkbox
        id="en_cb"
        label="English"
        :model-value="langs.includes('en')"
        @update:model-value="toggleLang('en')"
      />

      <Checkbox
        id="ru_cb"
        label="Русский"
        :model-value="langs.includes('ru')"
        @update:model-value="toggleLang('ru')"
      />

      <p
        class="text-sm text-red-500"
        v-if="langs.length === 0"
      >
        {{ $trans('language_not_select') }}
      </p>
    </PageSettingsSection>

    <PageSettingsSection :title="$trans('Feed')">
      <RadioButton
        id="classic"
        :label="$trans('Classic')"
        :model-value="view === 'classic'"
        @update:model-value="view = 'classic'"
      />

      <RadioButton
        id="compact"
        :label="$trans('Compact')"
        :model-value="view === 'compact'"
        @update:model-value="view = 'compact'"
      />
    </PageSettingsSection>

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
