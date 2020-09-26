let dayjs = require('dayjs');

export const FormatDate = (date) => {
    return dayjs(date).format('dddd, MMMM D, YYYY');
}