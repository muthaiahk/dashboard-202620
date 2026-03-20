'use strict';

(function () {
  // Full Toolbar Configuration
  // --------------------------------------------------------------------
  const fullToolbarConfig = [
    [
      { font: [] },
      { size: ['small', 'medium', 'large', 'huge'] }
      // { size: ['8px', '9px', '10px', '11px', '12px', '14px', '16px', '18px', '20px', '22px', '24px', '26px', '28px', '36px', '48px', '72px'] }
    ],
    ['bold', 'italic', 'underline', 'strike'],
    [
      { color: [] },
      { background: [] }
    ],
    [
      { script: 'super' },
      { script: 'sub' }
    ],
    [
      { header: '1' },
      { header: '2' },
      'blockquote',
      'code-block'
    ],
    [
      { list: 'ordered' },
      { list: 'bullet' },
      { indent: '-1' },
      { indent: '+1' }
    ],
    [{ direction: 'rtl' }],
    ['link', 'image', 'video', 'formula'],
    ['clean']
  ];

  const createQuillEditor = (selector) => {
    return new Quill(selector, {
      bounds: selector,
      modules: {
        formula: true,
        toolbar: fullToolbarConfig
      },
      theme: 'snow'
    });
  };

  // Initialize Quill Editors
  const editorAdd = createQuillEditor('#email_template_add');
  const editorEdit = createQuillEditor('#email_template_edit');

  const thankswindowAdd = createQuillEditor('#thanks_window_add');
  const thankswindowEdit = createQuillEditor('#thanks_window_edit');
  
})();
