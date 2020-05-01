!function(e){function t(l){if(r[l])return r[l].exports;var n=r[l]={i:l,l:!1,exports:{}};return e[l].call(n.exports,n,n.exports,t),n.l=!0,n.exports}var r={};t.m=e,t.c=r,t.d=function(e,r,l){t.o(e,r)||Object.defineProperty(e,r,{configurable:!1,enumerable:!0,get:l})},t.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(r,"a",r),r},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=0)}([function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});r(1)},function(e,t,r){"use strict";var l=r(2),n=(r.n(l),r(3)),__=(r.n(n),wp.i18n.__),c=wp.blocks.registerBlockType,a=wp.blockEditor.InspectorControls,s=wp.components.PanelBody,p=wp.components,o=(p.CheckboxControl,p.RadioControl,p.TextControl,p.ToggleControl,p.SelectControl,wp.data.withSelect),u=5,i="date";(0,wp.data.dispatch)("core").addEntities([{name:"taxquery",kind:"curriculum/v2",baseURL:"/curriculum/v2/taxquery"}]),c("cgb/block-curriculum-block",{title:__("Curriculum Block"),icon:"shield",category:"common",keywords:[__("curriculum-block"),__("CGB Example"),__("create-guten-block")],attributes:{blockid:{type:"string"},curriculums:{type:"object"},categories:{type:"object"},selectedCategory:{type:"string"},postsPerPage:{type:"string"},sortBy:{type:"string"}},edit:o(function(e,t){return{}})(function(e){function t(){var e="";e="title"==i?"asc":"desc",""!=o?wp.apiFetch({url:"/wp-json/curriculum/v2/taxquery?perpage="+u+"&terms="+o+"&orderby="+i+"&order="+e}).then(function(e){p({curriculums:e})}):wp.apiFetch({url:"/wp-json/curriculum/v2/taxquery?terms=0"}).then(function(e){p({curriculums:e})})}function r(e,r){if(e.target.checked)o.push(e.target.getAttribute("data"));else{var l=o.indexOf(parseInt(e.target.getAttribute("data")));l>-1&&o.splice(l,1)}p({selectedCategory:o.toString()}),t()}function l(e){p({postsPerPage:e.target.value}),u=e.target.value,t()}function n(e){p({sortBy:e.target.value}),i=e.target.value,t()}var c=(e.posts,e.tags,e.classname,e.attributes),p=e.setAttributes;if(wp.data.select("core/block-editor").getBlocks().map(function(e){if("cgb/block-curriculum-block"==e.name){var t="cb"+(new Date).getTime(),r=e.clientId;wp.data.select("core/editor").getBlockAttributes(r).blockid||wp.data.dispatch("core/editor").updateBlockAttributes(r,{blockid:t,postsPerPage:5,sortBy:"date"})}}),!c.blockid&&!c.postsPerPage&&!c.sortBy)return"Setting up blocks...";var o=[];if("undefined"!=typeof c.selectedCategory){var m=c.selectedCategory.split(","),d=m.indexOf("");d>-1&&m.splice(d,1),m.map(function(e){o.push(parseInt(e))})}if(c.postsPerPage?u=c.postsPerPage:p({postsPerPage:u}),c.sortBy?i=c.sortBy:p({sortBy:i}),c.categories||wp.apiFetch({url:"/wp-json/curriculum/v2/catquery"}).then(function(e){p({categories:e})}),!c.categories)return"Loading categories...";if(c.categories&&0===c.categories.length)return"No categories found, please add some!";var g=[];if(c.categories.map(function(e,t){g.push({id:e.term_id,name:e.name,level:e.level,parent:e.parent})}),!c.curriculums){var b="";b="title"==i?"asc":"desc",""!=o?wp.apiFetch({url:"/wp-json/curriculum/v2/taxquery?perpage="+u+"&terms="+o+"&orderby="+i+"&order="+b}).then(function(e){p({curriculums:e})}):wp.apiFetch({url:"/wp-json/curriculum/v2/taxquery?terms=0"}).then(function(e){p({curriculums:e})})}if(!c.curriculums&&""!=c.selectedCategory)return"Loading curriculums...";var w=[];c.curriculums&&c.selectedCategory&&c.selectedCategory.length>0&&c.curriculums.map(function(e,t){var r=[];r.title=e.id,r.title=e.title,r.link=e.link,r.content=e.content,r.featured_image_url=e.featured_image_url,r.oer_lp_grades=e.oer_lp_grades,r["resource-subject-area"]=e["resource-subject-area"],r.tags=e.tags,w.push(r)});var f=[5,10,15,20,25,30],_={date:"Date Added",modified:"Date Updated",title:"Title a-z"},v="undefined"==typeof c.curriculums.length?0:c.curriculums.length;return wp.element.createElement("div",null,wp.element.createElement(a,null,wp.element.createElement(s,{title:__("Curriculum Block settings"),initialOpen:!0},wp.element.createElement("div",{class:"lp_inspector_wrapper"},wp.element.createElement("label",{class:"components-base-control__label",for:"lp_inspector_subject"},"Subjects:"),wp.element.createElement("div",{class:"lp_inspector_subject"},g.map(function(e,t){return wp.element.createElement("label",{class:"components-base-control__label ls_inspector_subject_label "+e.level},wp.element.createElement("input",{checked:"undefined"!=typeof o&&-1!=o.indexOf(e.id)?"checked":"",id:"inspector-checkbox-control-"+t,class:"ls_inspector_subject_checkbox "+e.level,type:"checkbox",data:e.id,parent:e.parent,onClick:r}),e.name)}))),wp.element.createElement("div",{class:"lp_inspector_wrapper lp_inspector_Postperpage"},wp.element.createElement("label",{class:"components-base-control__label",for:"lp_inspector_postperpage_select"},"Posts Per Page:"),wp.element.createElement("select",{id:"lp_inspector_postperpage_select",onChange:l,value:u},f.map(function(e,t){return u==e?wp.element.createElement("option",{selected:!0,value:e},e):wp.element.createElement("option",{value:e},e)}))),wp.element.createElement("div",{class:"lp_inspector_wrapper lp_inspector_Postperpage"},wp.element.createElement("label",{class:"components-base-control__label",for:"lp_inspector_postperpage_select"},"Sort By:"),wp.element.createElement("select",{id:"lp_inspector_sortby_select",onChange:n,value:i},Object.keys(_).map(function(e){return i==e?wp.element.createElement("option",{value:e,checked:!0},_[e]):wp.element.createElement("option",{value:e},_[e])}))))),wp.element.createElement("div",{class:"lp-cur-blk-main editor"},wp.element.createElement("div",{class:"lp-cur-blk-topbar"},wp.element.createElement("div",{class:"lp-cur-blk-topbar-left"},wp.element.createElement("span",null,"Browse All ",v," Curriculums")),wp.element.createElement("div",{class:"lp-cur-blk-topbar-right"},wp.element.createElement("div",{class:"lp-cur-blk-topbar-display-box"},wp.element.createElement("div",{class:"lp-cur-blk-topbar-display-text"},wp.element.createElement("span",null,"Show ",u),wp.element.createElement("a",{href:"#"},wp.element.createElement("i",{class:"fa fa-th-list","aria-hidden":"true"}))),wp.element.createElement("ul",{class:"lp-cur-blk-topbar-display-option lp-cur-blk-topbar-option"},f.map(function(e,t){return u==e?wp.element.createElement("li",{class:"selected"},wp.element.createElement("a",{href:"#",ret:e},e)):wp.element.createElement("li",null,wp.element.createElement("a",{href:"#",ret:e},e))}))),wp.element.createElement("div",{class:"lp-cur-blk-topbar-sort-box"},wp.element.createElement("div",{class:"lp-cur-blk-topbar-sort-text"},wp.element.createElement("span",null,"Sort by: ",i),wp.element.createElement("a",{href:"#"},wp.element.createElement("i",{class:"fa fa-sort","aria-hidden":"true"}))),wp.element.createElement("ul",{class:"lp-cur-blk-topbar-sort-option lp-cur-blk-topbar-option"},Object.keys(_).map(function(e){return i==e?wp.element.createElement("li",{class:"selected"},wp.element.createElement("a",{href:"#",ret:e},_[e])):wp.element.createElement("li",null,wp.element.createElement("a",{href:"#",ret:e},_[e]))}))))),wp.element.createElement("div",{id:"lp_cur_blk_content_wrapper",class:"lp-cur-blk-wrapper"},wp.element.createElement("div",{id:"lp-cur-blk-content_drop"},w.map(function(e,t){if(c.curriculums.length>0){var r=e.content.replace(/<[^>]+>/g,"");r.length<=180?r+="....":r=r.substr(1,180)+"...";var l=0,n="";return""!=e.oer_lp_grades?e.oer_lp_grades.length>1?(n="Grades: ",l=e.oer_lp_grades[0]+"-"+e.oer_lp_grades[e.oer_lp_grades.length-1]):(n="Grade: ",l=e.oer_lp_grades):(n="",l=""),wp.element.createElement("div",{class:"lp-cur-blk-row"},wp.element.createElement("a",{href:e.link,class:"lp-cur-blk-left",target:"_new"},wp.element.createElement("img",{src:e.featured_image_url,alt:""})),wp.element.createElement("div",{class:"lp-cur-blk-right"},wp.element.createElement("div",{class:"ttl"},wp.element.createElement("a",{href:e.link,target:"_new"},e.title)),wp.element.createElement("div",{class:"lp-cur-postmeta"},wp.element.createElement("span",{class:"lp-cur-postmeta-grades"},wp.element.createElement("strong",null,n),l)),wp.element.createElement("div",{class:"desc"},r),wp.element.createElement("div",{class:"lp-cur-tags tagcloud"},Object.values(e.tags).map(function(e,t){return wp.element.createElement("span",null,wp.element.createElement("a",{href:cgbGlobal.base_url+"/tag/"+e.slug,alt:"",class:"button",target:"_new"},e.name))}))))}})))))}),save:function(e){return null}})},function(e,t){},function(e,t){}]);