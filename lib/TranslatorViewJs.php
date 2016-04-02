<?php
namespace Translator;

/**
 *  This handles the view for the Translator library and builds the basic shell of the page, parses the form.
 *
 *  Most of the heavy lifting will be done through JS, though
 *
 */
class TranslatorViewJs {

	function fetchJs(){
	?><script type="text/javascript">
		$(document).ready(function() {

			$("#contentFromUrl").on('mouseout',function(){
				cleanClass('admin-selected-temp');
			});

			$("#contentFromUrl").on('click', function (e) {
				e.preventDefault();

				var elem = $(e.target);
				if(elem.hasClass('container-fluid')) {return false;}
				if(elem.prop('id')=='contentFromUrl') return false;

				cleanClass('admin-selected-temp');

				//  if(elem.html().length==0) {return false;}

				// Be sure only one element is selected at a time
				if (!elem.hasClass('admin-selected')) {
					cleanClass('admin-selected');
					elem.addClass('admin-selected');
					insertAdminEditBox(elem);
				} else {
							cleanClass('admin-selected');
							// with Ctrl Key pressed, expand the selection to the parent, on single click, clear the selection
							if (e.ctrlKey) {/*ctrl is down*/
								elem.parent().click();
								setTimeout(function(){},500);
							}
				}
			});

			$('#contentFromUrl .form-group').on('mouseover', function () {
				updateSelection($(this));
			});

			// If div has an ID, then allow it to be selected, if ".admin-selected" exists inside #contentFromUrl, do not continue
			$('#contentFromUrl').on('mouseover', function (e) {

				if ($('.admin-selected').length!=0) { return false;}
				//  $("#adminSection").append("admin-selected count:"+$('.admin-selected').length);

				var elem = $(e.target);

				if(elem.hasClass('container-fluid')) {return false;}
				if (elem.prop('id')=='contentFromUrl') { return false;}

				// Check if item has an ID, a label, OR a value prop else IGNORE since it's not easily selected
				var thisId = elem.prop('id');
				if (thisId.length > 0) {
					updateSelection($(this));
					//  $("#adminSection").append("ID: "+   elem.prop('id') );
					return true;
				}

				return false;
			});

			function updateSelection(elem) {
				if ($('.admin-selected').length!=0) { return false;}
				cleanClass('admin-selected-temp');
				elem.addClass('admin-selected-temp');
			}

			function cleanClass(classIn) {
				$('.' + classIn).removeClass(classIn);
			}


			function insertAdminEditBox(elem){

				var elemBody=adminElementClass=id=rel=name=labelFor=contentText=tagRel='';
				var tagType=elem.prop('tagName');

				if(elem.prop('id')) {var id=elem.prop('id');}
				if(elem.prop('rel')) {var rel=elem.prop('rel');}
				if(elem.prop('name')) {var name=elem.prop('name');}

				// For labels, two ways, label's "for" attr OR
				if(elem.prop('for'))  {var labelFor=elem.prop('for');}
					else {
							if(elem.find('label')) {var labelForm=elem.find('label').prop('for');}
					}

				var contentText=elem.text();

				if(id.length>0){ elemBody='ID: '+id;}
				if(elemBody.length==0){
					if(name.length>0) { elemBody='Name: '+rel;}
				}
				if(elemBody.length==0){
					if(labelFor.length>0) { elemBody='Label For: '+labelFor;}
				}
				if(elemBody.length==0){
					if(rel.length>0) { elemBody='Rel: '+rel;}
				}

				// Mark the adminElement "invalid" if it has no selector defined
				if(elemBody.length==0) {

					$("#adminMapEditBox").append("<div class='adminElement' rel='TEXT MATCH ONLY' data-dom-path='"+getElementPath(elem)+"'>('"+tagType+"') TEXT MATCH ONLY:<br/>" + contentText + "</div>");
				}
					else {
							$("#adminMapEditBox").append("<div class='adminElement' rel='"+elemBody+"' data-dom-path='"+getElementPath(elem)+"'>Select ('"+tagType+"') By:<br/>" + elemBody + "</div>");
				}
			}

			$(".adminElement").on('mouseover',function(){

				var elem=$(this);
				var rel=elem.prop('rel');
				$('.adminBoxSelected').removeClass('adminBoxSelected');

				if( rel=='TEXT MATCH ONLY'){
					var selectedElem=$("#contentFromUrl").find("contains('"+elem.text()+"')");
					selectedElem.addClass('adminBoxSelected');
					return true;
				}

				if( rel.indexOf('ID:')>-1){
					var adminId=rel.replace('ID: ');
					$("#"+adminId).addClass('adminBoxSelected');
				}

				if( rel.indexOf('Rel:')>-1){
					var adminRel=rel.replace('Rel: ');
					$("[rel]").each(function() {
						var thisRel=$(this).prop('rel');

						if(thisRel==adminRel){		$(this).addClass('adminBoxSelected');
							return true;
						}
					});
				}

			});

			// CSS Path
			function getElementPathCss(elem){
				var path = [];
				do {
					path.unshift(elem.prop('tagName') + (elem.className ? ' class="' + elem.className + '"' : ''));
				} while ((elem.prop('tagName').toLowerCase() != 'html') && (elem = elem.parentNode));

				return path.join(" > ");
			}

			// Straight container traversal
			function getElementPath(element)
			{
				return "//" + $(element).parents().andSelf().map(function() {
						var $this = $(this);
						var tagName = this.nodeName;
						var tagAttrs=tagName;

						if ($this.siblings(tagName).length > 0) {
							tagName += "[" + $this.prevAll(tagName).length + "]";
							tagAttrs += "id='"+$this.attr('id')+"' class='" + $this.attr('class')+"' rel='"+$this.attr('rel')+"'"
						}
						return tagName+" ("+tagAttrs+") ";
					}).get().join("/").toUpperCase();
			}
		});
	</script><?php
	}

}