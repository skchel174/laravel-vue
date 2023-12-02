import {reactive} from "vue";

function useNotification() {
  const notice = reactive({
    type: 'info',
    message: null,
    visible: false,
  });

  const showNotification = (message, type) => {
    notice.type = type;
    notice.message = message;
    notice.visible = true;
  };

  const showInfo = (message) => {
    showNotification(message, 'info');
  };

  const showError = (message) => {
    showNotification(message, 'error');
  };

  const showSuccess = (message) => {
    showNotification(message, 'success');
  };

  const showWarning = (message) => {
    showNotification(message, 'warning');
  };

  return {
    notice,
    showInfo,
    showError,
    showSuccess,
    showWarning,
  };
}

export default useNotification;
