/**
 * Tagify
 */

'use strict';

(function () {
  // Basic
  //------------------------------------------------------
  const tagifyBasicEl = document.querySelector('#category_keyword');
  const category_keyword = new Tagify(tagifyBasicEl);


  const tagifyBasicE2 = document.querySelector('#category_keyword_edit');
  const category_keyword_edit = new Tagify(tagifyBasicE2);

  const relev_top = document.querySelector('#relevent_topics');
  const relevent_topics = new Tagify(relev_top);

  const KnowledgeTagEl = document.querySelector("#KnowledgeTag");

  const whitelist = [
    "Python - Data Mining",
    "Python - Image Processing",
    "Python - Networking",
    "Python - Cybersecurity",
    "Python - Big Data",
    "Python - Flask",
    "Python - Django",
    "Java - Data Mining",
    "Java - Image Processing",
    "Java - Networking",
    "Java - Cybersecurity",
    "Java - Big Data",
    "Java - Web Application",
  ];
  // Inline
  let KnowledgeTag = new Tagify(KnowledgeTagEl, {
    whitelist: whitelist,
    maxTags: 50, // allows to select max items
    dropdown: {
      maxItems: 1000, // display max items
      classname: "tags-inline", // Custom inline class
      enabled: 0,
      closeOnSelect: false
    }
  });



})();
