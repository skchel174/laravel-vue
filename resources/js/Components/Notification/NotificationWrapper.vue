<script setup>
import {usePage} from "@inertiajs/vue3";
import {onMounted, provide, watch} from "vue";
import useNotification from "@/Hooks/useNotification.js";
import Notification from "@/Components/Notification/Notification.vue";

const page = usePage();

const {notice, showNotification} = useNotification();

provide('notify', showNotification);

onMounted(() => {
  if (page.props.notification) {
    showNotification(page.props.notification.type, page.props.notification.message);
  }
});

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
