import {reactive} from "vue";

function useNotification() {
  const notice = reactive({
    type: 'info',
    message: null,
    visible: false,
    duration: 5000,
  });

  const showNotification = (type, message, duration = 5000) => {
    notice.type = type;
    notice.message = message;
    notice.duration = duration;
    notice.visible = true;
  };

  const showInfo = (message, duration = 5000) => {
    showNotification('info', message, duration);
  };

  const showError = (message, duration = 5000) => {
    showNotification('error', message, duration);
  };

  const showSuccess = (message, duration = 5000) => {
    showNotification('success', message, duration);
  };

  const showWarning = (message, duration = 5000) => {
    showNotification('warning', message, duration);
  };

  return {
    notice,
    showInfo,
    showError,
    showSuccess,
    showWarning,
    showNotification,
  };
}

export default useNotification;
