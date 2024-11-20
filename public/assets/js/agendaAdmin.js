import modals from "./modules/modals.js";
import search from "./modules/search.js";
import calendar from "./modules/calendar.js";


const managerModalFilters = new modals('#modalFilters','#btnOpenModalFilters','#btnCloseModalFilters');
managerModalFilters.init();

// const searchElements = new search('.row','#inputSearch');
// searchElements.init();

// const calendarSchedule = new calendar('#containerCalendar');
// calendarSchedule.init();

// document.addEventListener('DOMContentLoaded', function() {
//     const label = document.querySelector('label[for="inputMonthYear"]');
//     const input = document.getElementById('inputMonthYear');

//     label.addEventListener('click', function() {
//         input.showPicker();
//     });


// });

 