import moment from "moment";

export default {
  install: (app, options) => {
    app.config.globalProperties.$formatDate = (date, format = 'DD MMM YYYY [at] HH:mm') => {
      const formattedDate = moment(date, 'DD-MM-YYYY HH:mm:ss');

      const dayStart = moment({
        hour: 0,
        minute: 0,
        seconds: 0,
        milliseconds: 0,
      });

      if (dayStart > formattedDate) {
        return formattedDate.format(format);
      } else {
        return formattedDate.fromNow();
      }
    };
  },
};
