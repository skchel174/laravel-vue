import moment from "moment";
import 'moment/dist/locale/ru';

export default {
  install: (app, options) => {
    app.config.globalProperties.$formatDate = (date, format = 'DD MMM YYYY, HH:mm') => {
      const locale = app.config.globalProperties.$page.props.app.locale;

      const formattedDate = moment(date, 'DD-MM-YYYY HH:mm:ss', locale);

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
