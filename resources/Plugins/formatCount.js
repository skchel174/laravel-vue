export default {
  install: (app, options) => {
    app.config.globalProperties.$formatCount = (num) => {
      if (num > 10000) {
        return (num / 1000).toFixed(0) + 'k';
      }

      if (num > 1000) {
        return (num / 1000).toFixed(1) + 'k';
      }

      return num.toString();
    };
  },
};
