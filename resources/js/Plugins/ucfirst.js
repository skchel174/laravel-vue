export default {
  install: (app, options) => {
    app.config.globalProperties.$ucfirst = (value) => {
      return value.charAt(0).toUpperCase() + value.slice(1);
    };
  },
};
