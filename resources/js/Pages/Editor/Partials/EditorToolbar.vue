<script setup>
const props = defineProps({
  id: {
    type: String,
    required: true,
  },

  visible: {
    type: Boolean,
    required: true,
  },
});
</script>

<template>
  <div
    v-show="visible"
    class="sticky bottom-0 h-10 w-full overflow-x-auto border-t border-gray-200 bg-gray-50 z-20 toolbar-container"
  >
    <div class="mx-auto w-full max-w-[64rem] px-2">
      <div
        :id="id"
        class="w-[26.5rem] !px-0 !border-0"
      >
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

  <div
    v-if="!visible"
    class="bg-white h-10"
  />
</template>

<style>
.toolbar-container::-webkit-scrollbar {
  width: 0;
  height: 0;
}
</style>
