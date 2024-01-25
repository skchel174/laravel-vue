import {reactive} from "vue";

function useNotification() {
  const notice = reactive({
    type: 'info',
    message: null,
    visible: false,
  });

  const showNotification = (type, message) => {
    notice.type = type;
    notice.message = message;
    notice.visible = true;
  };

  const showInfo = (message) => showNotification('info', message);

  const showError = (message) => showNotification('error', message);

  const showSuccess = (message) => showNotification('success', message);

  const showWarning = (message) => showNotification('warning', message);

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
