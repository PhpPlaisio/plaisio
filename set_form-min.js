function SET_Form(a){var b=this;this.$myFrom=a;this.$myFrom.submit(function(){b.$myFrom.find(":disabled").prop("disabled",false)})}SET_Form.ourForms=[];SET_Form.registerForm=function(a){$(a).each(function(){var b=$(this);if(b.is("form")){SET_Form.ourForms[SET_Form.ourForms.length]=new SET_Form(b)}else{b.find("form").each(function(){SET_Form.ourForms[SET_Form.ourForms.length]=new SET_Form($(this))})}})};function SET_CheckboxControlColumnTypeHandler(){SET_TextColumnTypeHandler.call(this)}SET_CheckboxControlColumnTypeHandler.prototype=Object.create(SET_TextColumnTypeHandler.prototype);SET_CheckboxControlColumnTypeHandler.constructor=SET_CheckboxControlColumnTypeHandler;SET_CheckboxControlColumnTypeHandler.prototype.extractForFilter=function(a){if($(a).find("input:checkbox").prop("checked")){return"1"}return"0"};SET_CheckboxControlColumnTypeHandler.prototype.getSortKey=function(a){if($(a).find("input:checkbox").prop("checked")){return"1"}return"0"};SET_OverviewTable.registerColumnTypeHandler("control-checkbox",SET_CheckboxControlColumnTypeHandler);function SET_TextControlColumnTypeHandler(){SET_TextColumnTypeHandler.call(this)}SET_TextControlColumnTypeHandler.prototype=Object.create(SET_TextColumnTypeHandler.prototype);SET_TextControlColumnTypeHandler.constructor=SET_TextControlColumnTypeHandler;SET_TextControlColumnTypeHandler.prototype.extractForFilter=function(a){return SET_OverviewTable.toLowerCaseNoAccents($(a).find("input").val())};SET_TextControlColumnTypeHandler.prototype.getSortKey=function(a){return SET_OverviewTable.toLowerCaseNoAccents($(a).find("input").val())};SET_OverviewTable.registerColumnTypeHandler("control-text",SET_TextControlColumnTypeHandler);SET_OverviewTable.registerColumnTypeHandler("control-button",SET_TextControlColumnTypeHandler);SET_OverviewTable.registerColumnTypeHandler("control-submit",SET_TextControlColumnTypeHandler);function SET_HtmlControlColumnTypeHandler(){SET_TextColumnTypeHandler.call(this)}SET_HtmlControlColumnTypeHandler.prototype=Object.create(SET_TextColumnTypeHandler.prototype);SET_HtmlControlColumnTypeHandler.constructor=SET_HtmlControlColumnTypeHandler;SET_HtmlControlColumnTypeHandler.prototype.extractForFilter=function(a){return SET_OverviewTable.toLowerCaseNoAccents($(a).children().text())};SET_HtmlControlColumnTypeHandler.prototype.getSortKey=function(a){return SET_OverviewTable.toLowerCaseNoAccents($(a).children().text())};SET_OverviewTable.registerColumnTypeHandler("control-div",SET_HtmlControlColumnTypeHandler);SET_OverviewTable.registerColumnTypeHandler("control-span",SET_HtmlControlColumnTypeHandler);SET_OverviewTable.registerColumnTypeHandler("control-link",SET_HtmlControlColumnTypeHandler);function SET_RadiosControlColumnTypeHandler(){SET_TextColumnTypeHandler.call(this)}SET_RadiosControlColumnTypeHandler.prototype=Object.create(SET_TextColumnTypeHandler.prototype);SET_RadiosControlColumnTypeHandler.constructor=SET_RadiosControlColumnTypeHandler;SET_RadiosControlColumnTypeHandler.prototype.extractForFilter=function(a){var b;b=$(a).find('input[type="radio"]:checked').prop("id");return SET_OverviewTable.toLowerCaseNoAccents(($("label[for="+b+"]").text()))};SET_RadiosControlColumnTypeHandler.prototype.getSortKey=function(a){var b;b=$(a).find('input[type="radio"]:checked').prop("id");return SET_OverviewTable.toLowerCaseNoAccents(($("label[for="+b+"]").text()))};SET_OverviewTable.registerColumnTypeHandler("control-radios",SET_RadiosControlColumnTypeHandler);function SET_SelectControlColumnTypeHandler(){SET_TextColumnTypeHandler.call(this)}SET_SelectControlColumnTypeHandler.prototype=Object.create(SET_TextColumnTypeHandler.prototype);SET_SelectControlColumnTypeHandler.constructor=SET_SelectControlColumnTypeHandler;SET_SelectControlColumnTypeHandler.prototype.extractForFilter=function(b){var a;a=$(b).find("select option:selected").text();return SET_OverviewTable.toLowerCaseNoAccents(a)};SET_SelectControlColumnTypeHandler.prototype.getSortKey=function(b){var a;a=$(b).find("select option:selected").text();return SET_OverviewTable.toLowerCaseNoAccents(a)};SET_OverviewTable.registerColumnTypeHandler("control-select",SET_SelectControlColumnTypeHandler);function SET_TextAreaControlColumnTypeHandler(){SET_TextColumnTypeHandler.call(this)}SET_TextAreaControlColumnTypeHandler.prototype=Object.create(SET_TextColumnTypeHandler.prototype);SET_TextAreaControlColumnTypeHandler.constructor=SET_TextAreaControlColumnTypeHandler;SET_TextAreaControlColumnTypeHandler.prototype.extractForFilter=function(a){return SET_OverviewTable.toLowerCaseNoAccents($(a).find("textarea").val())};SET_TextAreaControlColumnTypeHandler.prototype.getSortKey=function(a){return SET_OverviewTable.toLowerCaseNoAccents($(a).find("textarea").val())};SET_OverviewTable.registerColumnTypeHandler("control-text-area",SET_TextAreaControlColumnTypeHandler);