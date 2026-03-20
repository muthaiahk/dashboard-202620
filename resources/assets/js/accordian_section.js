// 'use strict';
// $(function () {
//   var formRepeater_sec = $('.sect'),
//   sec_add_butt = $(this).find('.section_butt_add'),
//   sec_del_butt = $(this).find('.section_butt_del');
//   if (formRepeater_sec.length) {
//     var row_sec = 2;
//     var col_sec = 2;
//     // formRepeater_sec.on('submit', function (e) {
//     //   e.preventDefault();
//     // });
//     formRepeater_sec.repeater({
//       show: function () {
//         var fromControl_sec = $(this).find('.form-control, .form-select');
//         var formLabel_sec = $(this).find('.form-label');

//         fromControl_sec.each(function (i_sec) {
//           var id_sec = 'sect-' + row_sec + '-' + col_sec;
//           $(fromControl_sec[i_sec]).attr('id', id_sec);
//           $(formLabel_sec[i_sec]).attr('for', id_sec);
//           col_sec++;
//         });

//         row_sec++;

//         $(this).slideDown();
//       },
//       hide: function (e) {
//         $(this).slideUp(e);
//       }
//     });
//   }
// });

'use strict';

$(function () {
  // Initialize section repeater inside chapter repeater
  $('[data-repeater-list="group-a_sec"]').repeater({
    show: function () {
      $(this).slideDown();
    },
    hide: function (e) {
      $(this).slideUp(e);
    }
  });
});
