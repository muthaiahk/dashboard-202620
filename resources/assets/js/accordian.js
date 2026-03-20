// 'use strict';

// $(function () {
//   var formRepeater = $('.form-repeater');

//   if (formRepeater.length) {
//     var row = 1;
//     var col = 1;
//     formRepeater.on('submit', function (e) {
//       e.preventDefault();
//     });
//     formRepeater.repeater({
//       show: function () {
//         var fromControl = $(this).find('.form-control, .form-select');
//         var formLabel = $(this).find('.form-label');

//         fromControl.each(function (i) {
//           var id = 'form-repeater-' + row + '-' + col;
//           $(fromControl[i]).attr('id', id);
//           $(formLabel[i]).attr('for', id);
//           col++;
//         });

//         row++;

//         $(this).slideDown();
//       },
//       hide: function (e) {
//         $(this).slideUp(e);
//       }
//     });
//   }

// });

'use strict';
// repeater functionality...
$('.chapter_butt_add').on('click', e => {
  var bt = parseFloat($('.form-repeater').length);
  let $clone = $('.form-repeater').first().clone().hide();
  $clone.insertBefore('.form-repeater:first').slideDown();
  if (bt==1) 
    {
      $('.chapter_butt_del').attr('style', 'display: block !important');
    }
  else
    {
      $('.chapter_butt_del').attr('style', 'display: block !important');
    }
  });

$(document).on('click', '.form-repeater .chapter_butt_del', e => 
{
  var bt = parseFloat($('.chapter_butt_del').length);
  // alert(bt);
  $(e.target).closest('.form-repeater').slideUp(400, function() { $(this).remove() });
  if (bt==2) 
    {
      $('.chapter_butt_del').attr('style', 'display: none !important');
    }
  else
  {}
});


$('.section_butt_add').on('click', e => {
  var bt = parseFloat($('.form-repeater_section').length);
  let $clone = $('.form-repeater_section').first().clone().hide();
  $clone.insertBefore('.form-repeater_section:first').slideDown();
  if (bt==1) 
    {
      $('.section_butt_del').attr('style', 'display: block !important');
    }
  else
    {
      $('.section_butt_del').attr('style', 'display: block !important');
    }
  });

$(document).on('click', '.form-repeater_section .section_butt_del', e => 
{
  var bt = parseFloat($('.section_butt_del').length);
  // alert(bt);
  $(e.target).closest('.form-repeater_section').slideUp(400, function() { $(this).remove() });
  if (bt==2) 
    {
      $('.section_butt_del').attr('style', 'display: none !important');
    }
  else
  {}
});


$('.topic_butt_add').on('click', e => {
  var bt = parseFloat($('.form-repeater_topic').length);
  let $clone = $('.form-repeater_topic').first().clone().hide();
  $clone.insertBefore('.form-repeater_topic:first').slideDown();
  if (bt==1) 
    {
      $('.topic_butt_del').attr('style', 'display: block !important');
    }
  else
    {
      $('.topic_butt_del').attr('style', 'display: block !important');
    }
  });

$(document).on('click', '.form-repeater_topic .topic_butt_del', e => 
{
  var bt = parseFloat($('.topic_butt_del').length);
  // alert(bt);
  $(e.target).closest('.form-repeater_topic').slideUp(400, function() { $(this).remove() });
  if (bt==2) 
    {
      $('.topic_butt_del').attr('style', 'display: none !important');
    }
  else
  {}
});

// $(document).ready(function() {
//   // Function to handle adding new sections
//   $('.section_butt_add').click(function() {
//     var sectionClone = $(this).closest('.form-repeater_sec').find('[data-repeater-item]:last').clone();
//     sectionClone.find('textarea').val(''); // Clear input values
//     $(this).closest('.form-repeater_sec').append(sectionClone);
//   });

//   // Function to handle adding new chapters
//   $('.chapter_butt_add').click(function() {
//     var chapterClone = $(this).closest('[data-repeater-list="group-a"]').find('[data-repeater-item]:last').clone();
//     chapterClone.find('textarea').val(''); // Clear input values
//     $(this).closest('[data-repeater-list="group-a"]').append(chapterClone);
//   });
// });
