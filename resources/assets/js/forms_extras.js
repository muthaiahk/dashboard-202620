/**
 * Form Extras
 */

'use strict';

(function () {
  const exam_live_txt_area_auto_1 = document.querySelector('#exam_live_txt_area_auto_1'),
  exam_live_txt_area_auto_2 = document.querySelector('#exam_live_txt_area_auto_2'),
  exam_live_txt_area_auto_3 = document.querySelector('#exam_live_txt_area_auto_3');

  // Autosize
  // --------------------------------------------------------------------
  if (exam_live_txt_area_auto_1) {
    autosize(exam_live_txt_area_auto_1);
  }
  if (exam_live_txt_area_auto_2) {
    autosize(exam_live_txt_area_auto_2);
  }
  if (exam_live_txt_area_auto_3) {
    autosize(exam_live_txt_area_auto_3);
  }

})();
