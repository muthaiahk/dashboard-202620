/**
 * Form Picker
 */

'use strict';

(function () {
  // Flat Picker
  // --------------------------------------------------------------------

  const agree_stdt = $('#agree_stdt'),
  agree_eddt = $('#agree_eddt'),
  open_dt = $('#open_dt'),
  cllt_cl_dt = $('#cllt_cl_dt'),
  cllt_cl_dt_edit = $('#cllt_cl_dt_edit'),
  reg_cl_dt = $('#reg_cl_dt'),
  re_app_date = $('#re_app_date'),
  re_app_time = $('#re_app_time'),
  lead_apt_sch = $('#lead_apt_sch'),
  apt_time = document.querySelector('#apt_time'),
  again_lead_apt_sch = $('#again_lead_apt_sch'),
  again_apt_time = document.querySelector('#again_apt_time'),
  apt_dt = $('#apt_dt'),
  whatsapp_temp_st_dt = $('#whatsapp_temp_st_dt'),
  whatsapp_temp_end_dt = $('#whatsapp_temp_end_dt'), 
  whatsapp_temp_st_dt_edit = $('#whatsapp_temp_st_dt_edit'),
  whatsapp_temp_end_dt_edit = $('#whatsapp_temp_end_dt_edit'), 
  holiday_dt = $('#holiday_dt'),
  holiday_dt_edit = $('#holiday_dt_edit'),
  ovr_month_fill = $('#ovr_month_fill'),
  ovr_year_fill = $('#ovr_year_fill'),
  

  quotation_validity = $('#quotation_validity'),
  quotation_validity_edit = $('#quotation_validity_edit'),
  quotation_date_edit = $('#quotation_date_edit'),
  lead_lfd = $('#lead_lfd'),
  lead_lfd_up = $('#lead_lfd_up'),
  lead_create_up = $('#lead_create_up'),
  lead_dob_up = $('#lead_dob_up'),
  meeting_apt_date = $('#meeting_apt_date'),
  meeting_start_time = document.querySelector('#meeting_start_time'),
  meeting_end_time = document.querySelector('#meeting_end_time'),
  staff_doj = $('#staff_doj'),
  staff_create = $('#staff_create'),
  slot_base_tm = document.querySelector('#slot_base_tm'),
  slot_base_end = document.querySelector('#slot_base_end'),
  slot_base_tm_up = document.querySelector('#slot_base_tm_up'),
  slot_base_end_up = document.querySelector('#slot_base_end_up'),
  staff_dob = $('#staff_dob'),  
  staff_att_date_edit = $('#staff_att_date_edit'), 
  service_star_date = $('#service_star_date'),  
  service_end_date = $('#service_end_date'),
  batch_create = $('#batch_create'),
  payment_chk_entry_dt = $('#payment_chk_entry_dt'),
  payment_chk_exp_dt = $('#payment_chk_exp_dt'),
  published_date = $('#published_date'),
  editor_published_date = $('#editor_published_date'),
  published_date_edit = $('#published_date_edit'),

  // Branch Management
  share_st_dt = $('#share_st_dt'),
  share_end_dt = $('#share_end_dt'), 
  branch_op_date = $('#branch_op_date'), 
  share_st_dt_updt = $('#share_st_dt_updt'),
  share_end_dt_updt= $('#share_end_dt_updt'), 
  branch_op_date_updt= $('#branch_op_date_updt'),
  // Assign CRE
  journal_due_date = $('#journal_due_date'),



  //Assign Project
  starting_date = $('#starting_date'),
  ending_date = $('#ending_date'),
  deadline_date = $('#deadline_date'),
  add_on_deadline_date = $('#add_on_deadline_date'),
  rework_deadline_date= $('#rework_deadline_date'),
  // Login DOB Start
  log_dob = $('#log_dob'),
  // Login DOB End

  // General Settings Start
  sl_col_cls_dt = $('#sl_col_cls_dt'),
  sl_reg_cls_dt = $('#sl_reg_cls_dt'),
  // General Settings End

  // Lead Filter Start
  lead_this_month_dt_fill = $('#lead_this_month_dt_fill'),
  lead_custom_from_dt_fill = $('#lead_custom_from_dt_fill'),
  lead_custom_to_dt_fill = $('#lead_custom_to_dt_fill'),
  // Lead Filter End

  // Client Filter Start
  cus_this_month_dt_fill = $('#cus_this_month_dt_fill'),
  cus_custom_from_dt_fill = $('#cus_custom_from_dt_fill'),
  cus_custom_to_dt_fill = $('#cus_custom_to_dt_fill'),
  // Client Filter End

  // Client Payment Date Picker Start
  cus_dob = $('#cus_dob'),
  cus_doj = $('#cus_doj'),
  cus_first_pymt_dt = $('#cus_first_pymt_dt'),
  cus_second_pymt_dt = $('#cus_second_pymt_dt'),
  cus_third_pymt_dt = $('#cus_third_pymt_dt'),
  cus_fourth_pymt_dt = $('#cus_fourth_pymt_dt'),
  cus_fifth_pymt_dt = $('#cus_fifth_pymt_dt'),
  cus_nxt_cash_pymt_dt = $('#cus_nxt_cash_pymt_dt'),
  cus_nxt_cheque_pymt_dt = $('#cus_nxt_cheque_pymt_dt'),
  cus_nxt_gpay_pymt_dt = $('#cus_nxt_gpay_pymt_dt'),
  // Client Payment Date Picker End


  // Course Filter Start
  course_month_dt_fill = $('#course_month_dt_fill'),
  course_from_dt_fill = $('#course_from_dt_fill'),
  course_to_dt_fill = $('#course_to_dt_fill'),
  // Course Filter End


  // Exam Filter Start
  exam_month_dt_fill = $('#exam_month_dt_fill'),
  exam_from_dt_fill = $('#exam_from_dt_fill'),
  exam_to_dt_fill = $('#exam_to_dt_fill'),
  // Exam Filter End


  // Question Bank Filter Start
  qb_month_dt_fill = $('#qb_month_dt_fill'),
  qb_from_dt_fill = $('#qb_from_dt_fill'),
  qb_to_dt_fill = $('#qb_to_dt_fill'),
  // Question Bank Filter End


  // Batch Filter Start
  batch_month_dt_fill = $('#batch_month_dt_fill'),
  batch_from_dt_fill = $('#batch_from_dt_fill'),
  batch_to_dt_fill = $('#batch_to_dt_fill'),
  // Batch Filter End


  // Daily Accounts Filter Start
  acc_daily_acc_month_dt_fill = $('#acc_daily_acc_month_dt_fill'),
  acc_daily_from_dt_fill = $('#acc_daily_from_dt_fill'),
  acc_daily_to_dt_fill = $('#acc_daily_to_dt_fill'),
  // Daily Accounts Filter End

  // Profit & Loss Accounts Filter Start
  acc_pf_ls_acc_month_dt_fill = $('#acc_pf_ls_acc_month_dt_fill'),
  acc_pf_ls_from_dt_fill = $('#acc_pf_ls_from_dt_fill'),
  acc_pf_ls_to_dt_fill = $('#acc_pf_ls_to_dt_fill'),
  // Profit & Loss Accounts Filter End

    // Announcement Settings
    ann_str_date = $('#ann_str_date'),
    ann_end_date = $('#ann_end_date'),
  
  // Trial Balance Accounts Filter Start
  acc_tri_bal_acc_month_dt_fill = $('#acc_tri_bal_acc_month_dt_fill'),
  acc_tri_bal_from_dt_fill = $('#acc_tri_bal_from_dt_fill'),
  acc_tri_bal_to_dt_fill = $('#acc_tri_bal_to_dt_fill'),
  // Trial Balance Accounts Filter End

  // Trial Balance Accounts Filter Start
  task_st_dt_tm = $('#task_st_dt_tm'),
  task_st_dt_tm_edit = $('#task_st_dt_tm_edit');
  // Trial Balance Accounts Filter End

// Date Start
    //Branch 
    if (agree_stdt.length) {
      agree_stdt.datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'd-M-yyyy',
        orientation: isRtl ? 'auto right' : 'auto left'
      });
    }
    
    if (agree_eddt.length) {
      agree_eddt.datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'd-M-yyyy',
        orientation: isRtl ? 'auto right' : 'auto left'
      });
    }

    if (open_dt.length) {
      open_dt.datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'd-M-yyyy',
        orientation: isRtl ? 'auto right' : 'auto left'
      });
    }

    if (cllt_cl_dt.length) {
      cllt_cl_dt.datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'd-M-yyyy',
        orientation: isRtl ? 'auto right' : 'auto left'
      });
    }
    if (cllt_cl_dt_edit.length) {
      cllt_cl_dt_edit.datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'd-M-yyyy',
        orientation: isRtl ? 'auto right' : 'auto left'
      });
    }

    if (reg_cl_dt.length) {
      reg_cl_dt.datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'd-M-yyyy',
        orientation: isRtl ? 'auto right' : 'auto left'
      });
    }



    // Lead
    if (re_app_date.length) {
      re_app_date.datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'd-M-yyyy',
        orientation: isRtl ? 'auto right' : 'auto left'
      });
    }
    
    if (lead_apt_sch.length) {
      lead_apt_sch.datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'd-M-yyyy',
        orientation: isRtl ? 'auto right' : 'auto left'
      });
    }
    if (again_lead_apt_sch.length) {
      again_lead_apt_sch.datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'd-M-yyyy',
        orientation: isRtl ? 'auto right' : 'auto left'
      });
    }
    if(apt_dt){
      apt_dt.flatpickr({
        enableTime: true,
        dateFormat: "d-m-Y H:i"
      });
    }
    if(whatsapp_temp_st_dt){
      whatsapp_temp_st_dt.flatpickr({
        enableTime: true,
        dateFormat: "d-m-Y H:i"
      });
    }

    if(whatsapp_temp_end_dt){
      whatsapp_temp_end_dt.flatpickr({
        enableTime: true,
        dateFormat: "d-m-Y H:i"
      });
    }
    
    if(whatsapp_temp_st_dt_edit){
      whatsapp_temp_st_dt_edit.flatpickr({
        enableTime: true,
        dateFormat: "d-m-Y H:i"
      });
    }

    if(whatsapp_temp_end_dt_edit){
      whatsapp_temp_end_dt_edit.flatpickr({
        enableTime: true,
        dateFormat: "d-m-Y H:i"
      });
    }

    if(task_st_dt_tm){
      task_st_dt_tm.flatpickr({
        enableTime: true,
        dateFormat: "d-M-Y h:i K"
      });
    }
    if(task_st_dt_tm_edit){
      task_st_dt_tm_edit.flatpickr({
        enableTime: true,
        dateFormat: "d-M-Y h:i K"
      });
    }

    if (holiday_dt.length) {
      holiday_dt.datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'd-M-yyyy',
        orientation: isRtl ? 'auto right' : 'auto left'
      });
    }
    if (holiday_dt_edit.length) {
      holiday_dt_edit.datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'd-M-yyyy',
        orientation: isRtl ? 'auto right' : 'auto left'
      });
    }
    if (ovr_month_fill.length) {
      ovr_month_fill.datepicker({
        format: 'M-yyyy',
        showButtonPanel: true,
        viewMode: "months",
        minViewMode: "months",
        todayHighlight: true,
        autoclose: true,
        orientation: isRtl ? 'left' : 'right',
        endDate: new Date()
      });
    }
    
    if (ovr_year_fill.length) {
      ovr_year_fill.datepicker({
        format: 'yyyy',
        showButtonPanel: true,
        viewMode: "years",
        minViewMode: "years",
        todayHighlight: true,
        autoclose: true,
        orientation: isRtl ? 'left' : 'right',
        endDate: new Date()
      });
    }
// Date End


// Time Start
    // Lead
    if (re_app_time) {
      re_app_time.flatpickr({
        enableTime: true,
        noCalendar: true
      });
    }
    if (apt_time) {
      apt_time.flatpickr({
        enableTime: true,
        noCalendar: true
      });
    }
    if (again_apt_time) {
      again_apt_time.flatpickr({
        enableTime: true,
        noCalendar: true
      });
    }
// Time End









  // Booklet Published Date and Time
  var publishedDateTime = document.querySelector("#published-datetime");
  if(publishedDateTime){
    publishedDateTime.flatpickr({
      enableTime: true,
      dateFormat: "d-m-Y H:i"
    });
  }

  // Time
  if (slot_base_end) {
    slot_base_end.flatpickr({
      enableTime: true,
      noCalendar: true
    });
  }
  if (slot_base_end_up) {
    slot_base_end_up.flatpickr({
      enableTime: true,
      noCalendar: true
    });
  }
  if (slot_base_tm) {
    slot_base_tm.flatpickr({
      enableTime: true,
      noCalendar: true
    });
  }
  if (slot_base_tm_up) {
    slot_base_tm_up.flatpickr({
      enableTime: true,
      noCalendar: true
    });
  }
  
  if (meeting_start_time) {
    meeting_start_time.flatpickr({
      enableTime: true,
      noCalendar: true
    });
  }
  if (meeting_end_time) {
    meeting_end_time.flatpickr({
      enableTime: true,
      noCalendar: true
    });
  }

  if (quotation_validity.length) {
    quotation_validity.datepicker({
      todayHighlight: true,
      autoclose: true,
      locale: {
        dateFormat: "d-M-Y"
      },
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }


  if (quotation_validity_edit.length) {
    quotation_validity_edit.datepicker({
      todayHighlight: true,
      autoclose: true,
      locale: {
        dateFormat: "d-M-Y"
      },
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }

  if (service_star_date.length) {
    service_star_date.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }

  if (service_end_date.length) {
    service_end_date.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  
  if (batch_create.length) {
    batch_create.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (quotation_date_edit.length) {
    quotation_date_edit.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (staff_doj.length) {
    staff_doj.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (starting_date.length) {
    starting_date.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (ending_date.length) {
    ending_date.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (deadline_date.length) {
    deadline_date.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (add_on_deadline_date.length) { 
    add_on_deadline_date.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (rework_deadline_date.length) { 
    rework_deadline_date.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (staff_dob.length) {
    staff_dob.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  // if (journal_due_date.length) {
  //   journal_due_date.datepicker({
  //     todayHighlight: true,
  //     autoclose: true,
  //     format: 'd-M-yyyy',
  //     orientation: isRtl ? 'auto right' : 'auto left'
  //   });
  // }
  if (editor_published_date.length) {
    editor_published_date.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  // if (edit_editor_published_date.length) {
  //   edit_editor_published_date.datepicker({
  //     todayHighlight: true,
  //     autoclose: true,
  //     format: 'd-M-yyyy',
  //     orientation: isRtl ? 'auto right' : 'auto left'
  //   });
  // }
  if (published_date.length) {
    published_date.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (published_date_edit.length) {
    published_date_edit.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (staff_create.length) {
    staff_create.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (lead_lfd.length) {
    lead_lfd.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (lead_create_up.length) {
    lead_create_up.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (lead_dob_up.length) {
    lead_dob_up.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  if (lead_lfd_up.length) {
    lead_lfd_up.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
  // if (meeting_apt_date.length) {
  //   meeting_apt_date.datepicker({
  //     todayHighlight: true,
  //     autoclose: true,
  //     format: 'd-M-yyyy',
  //     orientation: isRtl ? 'auto right' : 'auto left'
  //   });
  // }
// Login DOB Start
  if (log_dob.length) {
    log_dob.datepicker({
      todayHighlight: true,
      autoclose: true,
      format: 'd-M-yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
// Login DOB End

// General Settings Start
if (sl_col_cls_dt.length) {
  sl_col_cls_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'
  });
}
if (sl_reg_cls_dt.length) {
  sl_reg_cls_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'
  });
}
// General Settings End

if (payment_chk_entry_dt.length) {
  payment_chk_entry_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (payment_chk_exp_dt.length) {
  payment_chk_exp_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
// Client Date Picker End


// Lead Filter Date Picker Start
if (lead_this_month_dt_fill.length) {
  lead_this_month_dt_fill.datepicker({
    format: 'M-yyyy',
    showButtonPanel: true,
    viewMode: "months",
    minViewMode: "months",
    todayHighlight: true,
    autoclose: true,
    orientation: isRtl ? 'auto right' : 'auto left'
  });
}

if (lead_custom_from_dt_fill.length) {
  lead_custom_from_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (lead_custom_to_dt_fill.length) {
  lead_custom_to_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
// Lead Filter Date Picker End


// Client Filter Date Picker Start
if (cus_this_month_dt_fill.length) {
  cus_this_month_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (cus_custom_from_dt_fill.length) {
  cus_custom_from_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (cus_custom_to_dt_fill.length) {
  cus_custom_to_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}

// Client Filter Date Picker End

// Client Payment Date Picker Start
if (cus_dob.length) {
  cus_dob.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'dd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}

if (cus_doj.length) {
  cus_doj.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'dd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}

if (cus_first_pymt_dt.length) {
  cus_first_pymt_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'dd-M-yyyy',
    startDate : new Date('2024-07-06'),
    endDate : new Date('2024-07-13'),
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}

if (cus_second_pymt_dt.length) {
  cus_second_pymt_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'dd-M-yyyy',
    endDate : new Date('2024-07-23'),
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}

if (cus_third_pymt_dt.length) {
  cus_third_pymt_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'dd-M-yyyy',
    endDate : new Date('2024-08-08'),
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}

if (cus_fourth_pymt_dt.length) {
  cus_fourth_pymt_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'dd-M-yyyy',
    endDate : new Date('2024-08-24'),
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}

if (cus_fifth_pymt_dt.length) {
  cus_fifth_pymt_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'dd-M-yyyy',
    endDate : new Date('2024-09-08'),
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}

if (cus_nxt_cash_pymt_dt.length) {
  cus_nxt_cash_pymt_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'dd-M-yyyy',
    startDate : new Date('2024-07-06'),
    endDate : new Date('2024-07-13'),
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}

if (cus_nxt_cheque_pymt_dt.length) {
  cus_nxt_cheque_pymt_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'dd-M-yyyy',
    startDate : new Date('2024-07-06'),
    endDate : new Date('2024-07-13'),
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}

if (cus_nxt_gpay_pymt_dt.length) {
  cus_nxt_gpay_pymt_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'dd-M-yyyy',
    startDate : new Date('2024-07-06'),
    endDate : new Date('2024-07-13'),
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
// Client Payment Date Picker End



// Course Filter Date Picker Start
if (course_month_dt_fill.length) {
  course_month_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (course_from_dt_fill.length) {
  course_from_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (course_to_dt_fill.length) {
  course_to_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
// Course Filter Date Picker End


// Exam Filter Date Picker Start
if (exam_month_dt_fill.length) {
  exam_month_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (exam_from_dt_fill.length) {
  exam_from_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (exam_to_dt_fill.length) {
  exam_to_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
// Exam Filter Date Picker End



// Question Bank Filter Date Picker Start
if (qb_month_dt_fill.length) {
  qb_month_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (qb_from_dt_fill.length) {
  qb_from_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (qb_to_dt_fill.length) {
  qb_to_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
// Question Bank Filter Date Picker End



// Batch Filter Date Picker Start
if (batch_month_dt_fill.length) {
  batch_month_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (batch_from_dt_fill.length) {
  batch_from_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (batch_to_dt_fill.length) {
  batch_to_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
// Batch Filter Date Picker End



// Daily Accounts Filter Date Picker Start
if (acc_daily_acc_month_dt_fill.length) {
  acc_daily_acc_month_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (acc_daily_from_dt_fill.length) {
  acc_daily_from_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (acc_daily_to_dt_fill.length) {
  acc_daily_to_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
// Daily Accounts Filter Date Picker End

// Profit & Loss Accounts Filter Date Picker Start
if (acc_pf_ls_acc_month_dt_fill.length) {
  acc_pf_ls_acc_month_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (acc_pf_ls_from_dt_fill.length) {
  acc_pf_ls_from_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (acc_pf_ls_to_dt_fill.length) {
  acc_pf_ls_to_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
// Profit & Loss Accounts Filter Date Picker End

// Trial Balance Accounts Filter Date Picker Start
if (acc_tri_bal_acc_month_dt_fill.length) {
  acc_tri_bal_acc_month_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (acc_tri_bal_from_dt_fill.length) {
  acc_tri_bal_from_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
if (acc_tri_bal_to_dt_fill.length) {
  acc_tri_bal_to_dt_fill.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}
// Trial Balance Accounts Filter Date Picker End


if (ann_str_date.length) {
  ann_str_date.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}

if (ann_end_date.length) {
  ann_end_date.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'   
  });
}

// Branch Management
if (share_st_dt.length) {
  share_st_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'
  });
}
if (share_end_dt.length) {
  share_end_dt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'
  });
}
if (branch_op_date.length) {   
  branch_op_date.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'
  });
}
if (share_st_dt_updt.length) {    
  share_st_dt_updt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'
  });
}
if (share_end_dt_updt.length) {    
  share_end_dt_updt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'
  });
}  
if (branch_op_date_updt.length) {    
  branch_op_date_updt.datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'd-M-yyyy',
    orientation: isRtl ? 'auto right' : 'auto left'
  });
}  
})();
