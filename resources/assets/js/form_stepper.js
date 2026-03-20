/**
 *  Form Wizard
 */

'use strict';

(function () {
  // Vertical Wizard
  // --------------------------------------------------------------------
  const wizardVertical = document.querySelector('.wizard-vertical-own'),
    wizardVerticalBtnNextList = [].slice.call(wizardVertical.querySelectorAll('.btn-next')),
    wizardVerticalBtnPrevList = [].slice.call(wizardVertical.querySelectorAll('.btn-prev'));
    // wizardVerticalBtnSubmit = wizardVertical.querySelector('.btn-submit');

  if (typeof wizardVertical !== undefined && wizardVertical !== null) {
    const verticalStepper = new Stepper(wizardVertical, {
      linear: false
    });
    if (wizardVerticalBtnNextList) {
      wizardVerticalBtnNextList.forEach(wizardVerticalBtnNext => {
        wizardVerticalBtnNext.addEventListener('click', event => {
          verticalStepper.next();
        });
      });
    }
    if (wizardVerticalBtnPrevList) {
      wizardVerticalBtnPrevList.forEach(wizardVerticalBtnPrev => {
        wizardVerticalBtnPrev.addEventListener('click', event => {
          verticalStepper.previous();
        });
      });
    }

    // if (wizardVerticalBtnSubmit) {
    //   wizardVerticalBtnSubmit.addEventListener('click', event => {
    //     alert('Submitted..!!');
    //   });
    // }
  }


   const wizardVertical_update = document.querySelector('.wizard-vertical-own-update'),
    wizardVerticalBtnNextListUpdate = [].slice.call(wizardVertical_update.querySelectorAll('.btn-next')),
    wizardVerticalBtnPrevListUpdate = [].slice.call(wizardVertical_update.querySelectorAll('.btn-prev'));
    // wizardVerticalBtnSubmit = wizardVertical_update.querySelector('.btn-submit');

  if (typeof wizardVertical_update !== undefined && wizardVertical_update !== null) {
    const verticalStepperUpdate = new Stepper(wizardVertical_update, {
      linear: false
    });
    if (wizardVerticalBtnNextListUpdate) {
      wizardVerticalBtnNextListUpdate.forEach(wizardVerticalBtnNext => {
        wizardVerticalBtnNext.addEventListener('click', event => {
          verticalStepperUpdate.next();
        });
      });
    }
    if (wizardVerticalBtnPrevListUpdate) {
      wizardVerticalBtnPrevListUpdate.forEach(wizardVerticalBtnPrev => {
        wizardVerticalBtnPrev.addEventListener('click', event => {
          verticalStepperUpdate.previous();
        });
      });
    }

    // if (wizardVerticalBtnSubmitUpdate) {
    //   wizardVerticalBtnSubmitUpdate.addEventListener('click', event => {
    //     alert('Submitted..!!');
    //   });
    // }
  }

})();
