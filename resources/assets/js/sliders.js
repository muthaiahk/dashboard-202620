'use strict';
(function () {
    const  lead_potential_type_add = document.getElementById('lead_potential_type_add'),
    lead_potential_type_edit = document.getElementById('lead_potential_type_edit'),
    practical_theory_add = document.getElementById('practical_theory_add'),
    practical_theory_edit = document.getElementById('practical_theory_edit'),
    syllabus_practical_theory_add = document.getElementById('syllabus_practical_theory_add'),
    syllabus_practical_theory_edit = document.getElementById('syllabus_practical_theory_edit'),
    course_feedback = document.getElementById('course_feedback'),
    colorOptions_add = {
      start: [0,1],
      connect: true,
      behaviour: 'tap-drag',
      step: 1,
      // tooltips: true,
      range: {
        min: 0,
        max: 10
      },
      pips: {
        mode: 'steps',
        stepped: true,
        density: 10
      },
      direction: isRtl ? 'rtl' : 'ltr'
    },
    colorOptions_edit = {
      start: [7,10],
      connect: true,
      behaviour: 'tap-drag',
      step: 1,
      // tooltips: true,
      range: {
        min: 0,
        max: 10
      },
      pips: {
        mode: 'steps',
        stepped: true,
        density: 10
      },
      direction: isRtl ? 'rtl' : 'ltr'
    },
    course_feedback_colorOpt = {
      start: [50],
      connect: true,
      behaviour: 'tap-drag',
      step: 10,
      tooltips: true,
      range: {
        min: 10,
        max: 100
      },
      pips: {
        mode: 'steps',
        stepped: true,
        density: 10
      },
      direction: isRtl ? 'rtl' : 'ltr'
    },
    practical_theory_add_colorOpt = {
      start: [12],
      connect: true,
      behaviour: 'tap-drag',
      step: 1,
      tooltips: true,
      range: {
        min: 1,
        max: 65
      },
      pips: {
        mode: 'steps',
        stepped: true,
        density: 10
      },
      direction: isRtl ? 'rtl' : 'ltr'
    },
    practical_theory_edit_colorOpt = {
      start: [12],
      connect: true,
      behaviour: 'tap-drag',
      step: 1,
      tooltips: true,
      range: {
        min: 1,
        max: 65
      },
      pips: {
        mode: 'steps',
        stepped: true,
        density: 10
      },
      direction: isRtl ? 'rtl' : 'ltr'
    },
    syllabus_practical_theory_add_colorOpt = {
      start: [1],
      connect: true,
      behaviour: 'tap-drag',
      step: 1,
      tooltips: true,
      range: {
        min: 0,
        max: 2
      },
      pips: {
        mode: 'steps',
        stepped: true,
        density: 10
      },
      direction: isRtl ? 'rtl' : 'ltr'
    },
    syllabus_practical_theory_edit_colorOpt = {
      start: [1],
      connect: true,
      behaviour: 'tap-drag',
      step: 1,
      tooltips: true,
      range: {
        min: 0,
        max: 2
      },
      pips: {
        mode: 'steps',
        stepped: true,
        density: 10
      },
      direction: isRtl ? 'rtl' : 'ltr'
    };
  if (lead_potential_type_add) {
    // lead_potential_type_add.style.height = '15px';
    noUiSlider.create(lead_potential_type_add, colorOptions_add);
  }
  if (lead_potential_type_edit) {
    // lead_potential_type_edit.style.height = '15px';
    noUiSlider.create(lead_potential_type_edit, colorOptions_edit);
  }
  if (practical_theory_add) {
    // practical_theory_add.style.height = '15px';
    noUiSlider.create(practical_theory_add, practical_theory_add_colorOpt);
  }
  if (practical_theory_edit) {
    // practical_theory_edit.style.height = '15px';
    noUiSlider.create(practical_theory_edit, practical_theory_edit_colorOpt);
  }
  if (course_feedback) {
    noUiSlider.create(course_feedback, course_feedback_colorOpt);
  }
  if (syllabus_practical_theory_add) {
    noUiSlider.create(syllabus_practical_theory_add, syllabus_practical_theory_add_colorOpt);
  }
  if (syllabus_practical_theory_edit) {
    noUiSlider.create(syllabus_practical_theory_edit, syllabus_practical_theory_edit_colorOpt);
  }

})();
