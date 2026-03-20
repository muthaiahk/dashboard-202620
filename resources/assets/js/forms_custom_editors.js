/**
 * Form Editors
 */

'use strict';

(function () {
  // Quotation Notes
  // --------------------------------------------------------------------
  const CreatefullToolbar = [
    [
      {
        font: []
      },
      {
        size: []
      }
    ],
    ['bold', 'italic', 'underline', 'strike'],
    [
      {
        color: []
      },
      {
        background: []
      }
    ],
    [
      {
        script: 'super'
      },
      {
        script: 'sub'
      }
    ],
    [
      {
        header: '1'
      },
      {
        header: '2'
      },
      'blockquote',
      'code-block'
    ],
    [
      {
        list: 'ordered'
      },
      {
        list: 'bullet'
      },
      {
        indent: '-1'
      },
      {
        indent: '+1'
      }
    ],
    [{ direction: 'rtl' }],
    ['link', 'image', 'video', 'formula'],
    ['clean']
  ];
  const CreatefullEditor = new Quill('#create_proposal_notes', {
    bounds: '#create_proposal_notes',
    placeholder: 'Type Something...',
    modules: {
      formula: true,
      toolbar: CreatefullToolbar
    },
    theme: 'snow'
  });

    // Quotation Notes
  // --------------------------------------------------------------------
 
  const CreatefullEditor_1 = new Quill('#create_proposal_terms_condition', {
    bounds: '#create_proposal_terms_condition',
    placeholder: 'Type Something...',
    modules: {
      formula: true,
      toolbar: CreatefullToolbar
    },
    theme: 'snow'
  });

  const CreatefullEditor_2 = new Quill('#create_invoice_notes', {
    bounds: '#create_invoice_notes',
    placeholder: 'Type Something...',
    modules: {
      formula: true,
      toolbar: CreatefullToolbar
    },
    theme: 'snow'
  });

  const CreatefullEditor_3 = new Quill('#create_invoice_terms_condition', {
    bounds: '#create_invoice_terms_condition',
    placeholder: 'Type Something...',
    modules: {
      formula: true,
      toolbar: CreatefullToolbar
    },
    theme: 'snow'
  });

})();
