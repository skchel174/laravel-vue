<script setup>
import {ref} from "vue";
import TitleInput from "@/Pages/Editor/Partials/TitleInput.vue";
import TextInput from "@/Pages/Editor/Partials/TextInput.vue";
import OutlineButton from "@/Components/Buttons/OutlineButton.vue";
import Author from "@/Pages/Editor/Partials/Author.vue";

const props = defineProps({
  article: {
    type: [Object, null],
    required: true,
  },

  form: {
    type: Object,
    required: true,
  },
});

defineEmits(['openTab', 'updateForm']);

const focus = ref(false);
</script>

<template>
  <div class="flex-1 flex flex-col">
    <div class="p-4 flex-1 bg-white">
      <Author
        class="mb-4"
        :author="$page.props.auth.user"
        :status="article?.status"
        :publish-date="article?.publish_date"
      />

      <TitleInput
        :title="form.title"
        @update:content="value => $emit('updateForm', 'title', value)"
      />

      <TextInput
        toolbar="#toolbar"
        :text="form.text"
        @update:content="value => $emit('updateForm', 'text', value)"
        @focus="focus = true"
        @blur="focus = false"
      />
    </div>

    <div
      v-show="focus"
      class="sticky bottom-0 h-10 w-full overflow-x-auto border-t border-gray-200 bg-gray-50 z-20 toolbar-container"
    >
      <div class="w-full max-w-[64rem] px-2">
        <div id="toolbar" class="w-[26.5rem] !px-0 !border-0">
          <button class="ql-bold"/>
          <button class="ql-italic"/>
          <button class="ql-underline"/>
          <button class="ql-header" value="1"/>
          <button class="ql-header" value="2"/>
          <button class="ql-list" value="ordered"/>
          <button class="ql-list" value="bullet"/>
          <button class="ql-indent" value="-1"/>
          <button class="ql-indent" value="+1"/>
          <button class="ql-blockquote"/>
          <button class="ql-code-block"/>
          <button class="ql-link"/>
          <button class="ql-image"/>
          <button class="ql-video"/>
        </div>
      </div>
    </div>

    <div v-if="!focus" class="bg-white h-10"/>

    <div class="h-14 px-4 flex items-center justify-end bg-white border-t border-gray-200">
      <OutlineButton
        color="primary"
        :disabled="form.title.length === 0 || form.text.length < 10"
        @click="$emit('openTab', 'ArticleSettings')"
      >
        {{ $trans('Proceed to settings') }}
      </OutlineButton>
    </div>
  </div>
</template>

<style>
.toolbar-container::-webkit-scrollbar {
  width: 0;
  height: 0;
}
</style>
