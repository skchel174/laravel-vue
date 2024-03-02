<script setup>
import {provide, watch} from "vue";
import {usePage} from "@inertiajs/vue3";
import useNotification from "@/Hooks/useNotification.js";
import Notification from "@/Components/Notification/Notification.vue";

const page = usePage();

const {notice, showNotification} = useNotification();

provide('notify', showNotification);

watch(() => page.props.notification, () => {
  if (page.props.notification) {
    showNotification(page.props.notification.type, page.props.notification.message);
  }
});
</script>

<template>
  <slot/>

  <Notification
    :type="notice.type"
    v-model:visible="notice.visible"
  >
    {{ $trans(notice.message) }}
  </Notification>
</template>
