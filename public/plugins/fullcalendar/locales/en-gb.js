FullCalendar.globalLocales.push(function () {
  'use strict';

  var enGb = {
    code: 'en-gb',
    week: {
      dow: 1, // Monday is the first day of the week.
      doy: 4, // The week that contains Jan 4th is the first week of the year.
    },
    buttonHints: {
      prev: 'Précédent $0',
      next: 'Suivant $0',
      today: 'This $0',
    },
    viewHint: '$0 view',
    navLinkHint: 'Go to $0',
    moreLinkHint(eventCnt) {
      return `Show ${eventCnt} more event${eventCnt === 1 ? '' : 's'}`
    },
  };

  return enGb;

}());
