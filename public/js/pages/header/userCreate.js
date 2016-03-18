/*!
* @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
* @version 2.6.0
* bootstrap-fileinput
* For more JQuery Plugins visit http://plugins.krajee.com
*/!function(e){var i='style="width:{width};height:{height};"',t='   <div class="text-center"><small>{caption}</small></div>\n',n='      <param name="controller" value="true" />\n      <param name="allowFullScreen" value="true" />\n      <param name="allowScriptAccess" value="always" />\n      <param name="autoPlay" value="false" />\n      <param name="autoStart" value="false" />\n      <param name="quality" value="high" />\n',a='<div class="file-preview-other" '+i+'>\n       <h2><i class="glyphicon glyphicon-file"></i></h2>\n   </div>',r={main1:'{preview}\n<div class="input-group {class}">\n   {caption}\n   <div class="input-group-btn">\n       {remove}\n       {upload}\n       {browse}\n   </div>\n</div>',main2:"{preview}\n{remove}\n{upload}\n{browse}\n",preview:'<div class="file-preview {class}">\n   <div class="close fileinput-remove text-right">&times;</div>\n   <div class="file-preview-thumbnails"></div>\n   <div class="clearfix"></div>   <div class="file-preview-status text-center text-success"></div>\n   <div class="kv-fileinput-error"></div>\n</div>',caption:'<div tabindex="-1" class="form-control file-caption {class}">\n   <span class="glyphicon glyphicon-file kv-caption-icon"></span><div class="file-caption-name"></div>\n</div>',modal:'<div id="{id}" class="modal fade">\n  <div class="modal-dialog modal-lg">\n    <div class="modal-content">\n      <div class="modal-header">\n        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\n        <h3 class="modal-title">Detailed Preview <small>{title}</small></h3>\n      </div>\n      <div class="modal-body">\n        <textarea class="form-control" style="font-family:Monaco,Consolas,monospace; height: {height}px;" readonly>{body}</textarea>\n      </div>\n    </div>\n  </div>\n</div>\n'},l=["image","html","text","video","audio","flash","object"],o={generic:'<div class="file-preview-frame" id="{previewId}">\n   {content}\n</div>\n',html:'<div class="file-preview-frame" id="{previewId}">\n    <object data="{data}" type="{type}" width="{width}" height="{height}">\n       '+a+"\n    </object>\n"+t+"</div>",image:'<div class="file-preview-frame" id="{previewId}">\n   <img src="{data}" class="file-preview-image" title="{caption}" alt="{caption}" '+i+">\n</div>\n",text:'<div class="file-preview-frame" id="{previewId}">\n   <div class="file-preview-text" title="{caption}" '+i+">\n       {data}\n   </div>\n</div>\n",video:'<div class="file-preview-frame" id="{previewId}" title="{caption}" '+i+'>\n   <video width="{width}" height="{height}" controls>\n       <source src="{data}" type="{type}">\n       '+a+"\n   </video>\n"+t+"</div>\n",audio:'<div class="file-preview-frame" id="{previewId}" title="{caption}" '+i+'>\n   <audio controls>\n       <source src="{data}" type="{type}">\n       '+a+"\n   </audio>\n"+t+"</div>\n",flash:'<div class="file-preview-frame" id="{previewId}" title="{caption}" '+i+'>\n   <object type="application/x-shockwave-flash" width="{width}" height="{height}" data="{data}">\n'+n+"       "+a+"\n   </object>\n"+t+"</div>\n",object:'<div class="file-preview-frame" id="{previewId}" title="{caption}" '+i+'>\n    <object data="{data}" type="{type}" width="{width}" height="{height}">\n      <param name="movie" value="{caption}" />\n'+n+"           "+a+"\n   </object>\n"+t+"</div>",other:'<div class="file-preview-frame" id="{previewId}" title="{caption}" '+i+">\n   "+a+"\n"+t+"</div>"},s={image:{width:"auto",height:"160px"},html:{width:"320px",height:"180px"},text:{width:"160px",height:"160px"},video:{width:"320px",height:"240px"},audio:{width:"320px",height:"80px"},flash:{width:"320px",height:"240px"},object:{width:"320px",height:"100%"},other:{width:"160px",height:"120px"}},p={image:function(e,i){return"undefined"!=typeof e?e.match("image.*"):i.match(/\.(gif|png|jpe?g)$/i)},html:function(e,i){return"undefined"!=typeof e?"text/html"==e:i.match(/\.(htm|html)$/i)},text:function(e,i){return"undefined"!=typeof e&&e.match("text.*")||i.match(/\.(txt|md|csv|nfo|php|ini)$/i)},video:function(e,i){return"undefined"!=typeof e&&e.match(/\.video\/(ogg|mp4|webm)$/i)||i.match(/\.(og?|mp4|webm)$/i)},audio:function(e,i){return"undefined"!=typeof e&&e.match(/\.audio\/(ogg|mp3|wav)$/i)||i.match(/\.(ogg|mp3|wav)$/i)},flash:function(e,i){return"undefined"!=typeof e&&"application/x-shockwave-flash"==e||i.match(/\.(swf)$/i)},object:function(){return!0},other:function(){return!0}},d=function(i,t){return null===i||void 0===i||i==[]||""===i||t&&""===e.trim(i)},c=function(e){return Array.isArray(e)||"[object Array]"===Object.prototype.toString.call(e)},v=function(e,i){return"object"==typeof i&&e in i},m=function(i,t,n){return d(i)||d(i[t])?n:e(i[t])},g=function(){return Math.round((new Date).getTime()+100*Math.random())},u=function(){return window.File&&window.FileReader&&window.FileList&&window.Blob},w=function(e){return String(e).replace(/&/g,"&amp;").replace(/"/g,"&quot;").replace(/'/g,"&#39;").replace(/</g,"&lt;").replace(/>/g,"&gt;")},f=window.URL||window.webkitURL,h=function(i,t){this.$element=e(i),u()?(this.init(t),this.listen()):this.$element.removeClass("file-loading")};h.prototype={constructor:h,init:function(e){var i=this;i.reader=null,i.showCaption=e.showCaption,i.showPreview=e.showPreview,i.maxFileSize=e.maxFileSize,i.maxFileCount=e.maxFileCount,i.msgSizeTooLarge=e.msgSizeTooLarge,i.msgFilesTooMany=e.msgFilesTooMany,i.msgFileNotFound=e.msgFileNotFound,i.msgFileNotReadable=e.msgFileNotReadable,i.msgFilePreviewAborted=e.msgFilePreviewAborted,i.msgFilePreviewError=e.msgFilePreviewError,i.msgValidationError=e.msgValidationError,i.msgErrorClass=e.msgErrorClass,i.initialDelimiter=e.initialDelimiter,i.initialPreview=e.initialPreview,i.initialCaption=e.initialCaption,i.initialPreviewCount=e.initialPreviewCount,i.initialPreviewContent=e.initialPreviewContent,i.overwriteInitial=e.overwriteInitial,i.layoutTemplates=e.layoutTemplates,i.previewTemplates=e.previewTemplates,i.allowedPreviewTypes=d(e.allowedPreviewTypes)?l:e.allowedPreviewTypes,i.allowedPreviewMimeTypes=e.allowedPreviewMimeTypes,i.allowedFileTypes=e.allowedFileTypes,i.allowedFileExtensions=e.allowedFileExtensions,i.previewSettings=e.previewSettings,i.fileTypeSettings=e.fileTypeSettings,i.showRemove=e.showRemove,i.showUpload=e.showUpload,i.captionClass=e.captionClass,i.previewClass=e.previewClass,i.mainClass=e.mainClass,i.mainTemplate=i.getLayoutTemplate(i.showCaption?"main1":"main2"),i.captionTemplate=i.getLayoutTemplate("caption"),i.previewGenericTemplate=i.getPreviewTemplate("generic"),i.browseLabel=e.browseLabel,i.browseIcon=e.browseIcon,i.browseClass=e.browseClass,i.removeLabel=e.removeLabel,i.removeIcon=e.removeIcon,i.removeClass=e.removeClass,i.uploadLabel=e.uploadLabel,i.uploadIcon=e.uploadIcon,i.uploadClass=e.uploadClass,i.uploadUrl=e.uploadUrl,i.msgLoading=e.msgLoading,i.msgProgress=e.msgProgress,i.msgSelected=e.msgSelected,i.msgInvalidFileType=e.msgInvalidFileType,i.msgInvalidFileExtension=e.msgInvalidFileExtension,i.previewFileType=e.previewFileType,i.wrapTextLength=e.wrapTextLength,i.wrapIndicator=e.wrapIndicator,i.isError=!1,i.isDisabled=i.$element.attr("disabled")||i.$element.attr("readonly"),d(i.$element.attr("id"))&&i.$element.attr("id",g()),"undefined"==typeof i.$container?i.$container=i.createContainer():i.refreshContainer(),i.$captionContainer=m(e,"elCaptionContainer",i.$container.find(".file-caption")),i.$caption=m(e,"elCaptionText",i.$container.find(".file-caption-name")),i.$previewContainer=m(e,"elPreviewContainer",i.$container.find(".file-preview")),i.$preview=m(e,"elPreviewImage",i.$container.find(".file-preview-thumbnails")),i.$previewStatus=m(e,"elPreviewStatus",i.$container.find(".file-preview-status")),i.$errorContainer=m(e,"elErrorContainer",i.$previewContainer.find(".kv-fileinput-error")),d(i.msgErrorClass)||i.$errorContainer.removeClass(i.msgErrorClass).addClass(i.msgErrorClass),i.$errorContainer.hide();var t=i.initialPreview;i.initialPreviewCount=c(t)?t.length:t.length>0?t.split(i.initialDelimiter).length:0,i.initPreview(),i.original={preview:i.$preview.html(),caption:i.$caption.html()},i.options=e,i.$element.removeClass("file-loading")},getLayoutTemplate:function(e){var i=this;return v(e,i.layoutTemplates)?i.layoutTemplates[e]:r[e]},getPreviewTemplate:function(e){var i=this;return v(e,i.previewTemplates)?i.previewTemplates[e]:o[e]},listen:function(){var i=this,t=i.$element,n=i.$captionContainer,a=i.$btnFile;t.on("change",e.proxy(i.change,i)),a.on("click",function(){i.clear(!1),n.focus()}),t.closest("form").on("reset",e.proxy(i.reset,i)),i.$container.on("click",".fileinput-remove:not([disabled])",e.proxy(i.clear,i))},refresh:function(i){var t=this,n=arguments.length?e.extend(t.options,i):t.options;t.init(n)},initPreview:function(){var i=this,t="",n=i.initialPreview,a=i.initialPreviewCount,r=i.initialCaption.length,l="preview-"+g(),o=r>0?i.initialCaption:i.msgSelected.replace(/\{n\}/g,a),s=e(o).text();if(c(n)&&a>0){for(var p=0;a>p;p++)l+="-"+p,t+=i.previewGenericTemplate.replace(/\{previewId\}/g,l).replace(/\{content\}/g,n[p]);a>1&&0==r&&(o=i.msgSelected.replace(/\{n\}/g,a))}else{if(!(a>0))return r>0?(i.$caption.html(o),void i.$captionContainer.attr("title",s)):void 0;for(var d=n.split(i.initialDelimiter),p=0;a>p;p++)l+="-"+p,t+=i.previewGenericTemplate.replace(/\{previewId\}/g,l).replace(/\{content\}/g,d[p]);a>1&&0==r&&(o=i.msgSelected.replace(/\{n\}/g,a))}i.initialPreviewContent=t,i.$preview.html(t),i.$caption.html(o),i.$captionContainer.attr("title",s),i.$container.removeClass("file-input-new")},clearObjects:function(){var i=this,t=i.$preview;t.find("video audio").each(function(){this.pause(),delete this,e(this).remove()}),t.find("img object div").each(function(){delete this,e(this).remove()})},clearFileInput:function(){var e=this,i=e.$element;/MSIE/.test(navigator.userAgent)?(i.wrap("<form>").closest("form").trigger("reset"),i.unwrap()):i.val("")},clear:function(){var e=this,i=arguments.length&&arguments[0];if(i&&i.preventDefault(),e.reader instanceof FileReader&&e.reader.abort(),e.clearFileInput(),e.resetErrors(!0),i!==!1&&(e.$element.trigger("change"),e.$element.trigger("fileclear")),e.overwriteInitial&&(e.initialPreviewCount=0),e.overwriteInitial||d(e.initialPreviewContent)){e.clearObjects(),e.$preview.html("");var t=!e.overwriteInitial&&e.initialCaption.length>0?e.original.caption:"";e.$caption.html(t),e.$captionContainer.attr("title",""),e.$container.removeClass("file-input-new").addClass("file-input-new")}else e.showFileIcon(),e.$preview.html(e.original.preview),e.$caption.html(e.original.caption),e.$container.removeClass("file-input-new");e.hideFileIcon(),e.$element.trigger("filecleared"),e.$captionContainer.focus()},reset:function(){var e=this;e.clear(!1),e.$preview.html(e.original.preview),e.$caption.html(e.original.caption),e.$container.find(".fileinput-filename").text(""),e.$element.trigger("filereset"),e.initialPreview.length>0&&e.$container.removeClass("file-input-new")},disable:function(){var e=this;e.isDisabled=!0,e.$element.attr("disabled","disabled"),e.$container.find(".kv-fileinput-caption").addClass("file-caption-disabled"),e.$container.find(".btn-file, .fileinput-remove, .kv-fileinput-upload").attr("disabled",!0)},enable:function(){var e=this;e.isDisabled=!1,e.$element.removeAttr("disabled"),e.$container.find(".kv-fileinput-caption").removeClass("file-caption-disabled"),e.$container.find(".btn-file, .fileinput-remove, .kv-fileinput-upload").removeAttr("disabled")},hideFileIcon:function(){this.overwriteInitial&&this.$captionContainer.find(".kv-caption-icon").hide()},showFileIcon:function(){this.$captionContainer.find(".kv-caption-icon").show()},resetErrors:function(e){var i=this,t=i.$errorContainer;i.isError=!1,i.$container.removeClass("has-error"),e?t.fadeOut("slow"):t.hide()},showError:function(e,i,t,n){var a=this,r=a.$errorContainer,l=a.$element;return r.html(e),r.fadeIn(800),l.trigger("fileerror",[i,t,n]),a.clearFileInput(),a.$container.removeClass("has-error").addClass("has-error"),!0},errorHandler:function(e,i){var t=this;switch(e.target.error.code){case e.target.error.NOT_FOUND_ERR:t.addError(t.msgFileNotFound.replace(/\{name\}/g,i));break;case e.target.error.NOT_READABLE_ERR:t.addError(t.msgFileNotReadable.replace(/\{name\}/g,i));break;case e.target.error.ABORT_ERR:t.addError(t.msgFilePreviewAborted.replace(/\{name\}/g,i));break;default:t.addError(t.msgFilePreviewError.replace(/\{name\}/g,i))}},parseFileType:function(e){for(var i,t,n=0;n<l.length;n++)if(cat=l[n],i=v(cat,self.fileTypeSettings)?self.fileTypeSettings[cat]:p[cat],t=i(e.type,e.name)?cat:"",""!=t)return t;return"other"},previewDefault:function(i,t){var n=this,a=f.createObjectURL(i),r=e("#"+t),l=v("other",n.previewTemplates)?n.previewTemplates.other:o.other;n.$preview.append("\n"+l.replace(/\{previewId\}/g,t).replace(/\{caption\}/g,n.slug(i.name)).replace(/\{type\}/g,i.type).replace(/\{data\}/g,a)),r.on("load",function(){f.revokeObjectURL(r.attr("data"))})},previewFile:function(e,i,t,n){var n,a,r=this,l=r.parseFileType(e),p=r.slug(e.name),c=r.allowedPreviewTypes,m=r.allowedPreviewMimeTypes,u=(e.type,v(l,r.previewTemplates)?r.previewTemplates[l]:o[l]),h=v(l,r.previewSettings)?r.previewSettings[l]:s[l],b=parseInt(r.wrapTextLength),y=r.wrapIndicator,C=r.$preview,$=c.indexOf(l)>=0,x=d(m)||!d(m)&&v(e.type,m);if($&&x){if("text"==l){var F=w(i.target.result);if(f.revokeObjectURL(n),F.length>b){var T="text-"+g(),I=.75*window.innerHeight,P=r.getLayoutTemplate("modal").replace(/\{id\}/g,T).replace(/\{title\}/g,p).replace(/\{height\}/g,I).replace(/\{body\}/g,F);y=y.replace(/\{title\}/g,p).replace(/\{dialog\}/g,"$('#"+T+"').modal('show')"),F=F.substring(0,b-1)+y}a=u.replace(/\{previewId\}/g,t).replace(/\{caption\}/g,p).replace(/\{type\}/g,e.type).replace(/\{width\}/g,h.width).replace(/\{height\}/g,h.height).replace(/\{data\}/g,F)+P}else a=u.replace(/\{previewId\}/g,t).replace(/\{caption\}/g,p).replace(/\{type\}/g,e.type).replace(/\{data\}/g,n).replace(/\{width\}/g,h.width).replace(/\{height\}/g,h.height);C.append("\n"+a)}else r.previewDefault(e,t)},readFiles:function(e){function i(p){if(p>=w)return l.removeClass("loading"),void o.html("");var v,g,y,C,$,x=u+"-"+p,F=e[p],T=t.slug(F.name),I=(F.size?F.size:0)/1e3,P=f.createObjectURL(F),E=0,L=t.allowedFileTypes,S=d(L)?"":L.join(", "),R=t.allowedFileExtensions,j=d(R)?"":R.join(", "),k=d(R)?"":new RegExp("\\.("+R.join("|")+")$","i");if(I=I.toFixed(2),t.maxFileSize>0&&I>t.maxFileSize)return y=t.msgSizeTooLarge.replace(/\{name\}/g,T).replace(/\{size\}/g,I).replace(/\{maxSize\}/g,t.maxFileSize),void(t.isError=t.showError(y,F,x,p));if(!d(L)&&c(L)){for(g=0;g<L.length;g++)C=L[g],v=h[C],$=void 0!==v&&v(F.type,T),E+=d($)?0:$.length;if(0==E)return y=t.msgInvalidFileType.replace(/\{name\}/g,T).replace(/\{types\}/g,S),void(t.isError=t.showError(y,F,x,p))}return 0!=E||d(R)||!c(R)||d(k)||($=T.match(k),E+=d($)?0:$.length,0!=E)?t.showPreview?void(a.length>0&&"undefined"!=typeof FileReader?(o.html(s.replace(/\{index\}/g,p+1).replace(/\{files\}/g,w)),l.addClass("loading"),r.onerror=function(e){t.errorHandler(e,T)},r.onload=function(e){t.previewFile(F,e,x,P)},r.onloadend=function(){var e=m.replace(/\{index\}/g,p+1).replace(/\{files\}/g,w).replace(/\{percent\}/g,100).replace(/\{name\}/g,T);setTimeout(function(){o.html(e),f.revokeObjectURL(P)},1e3),setTimeout(function(){i(p+1)},1500),n.trigger("fileloaded",[F,x,p])},r.onprogress=function(e){if(e.lengthComputable){var i=parseInt(e.loaded/e.total*100,10),t=m.replace(/\{index\}/g,p+1).replace(/\{files\}/g,w).replace(/\{percent\}/g,i).replace(/\{name\}/g,T);setTimeout(function(){o.html(t)},1e3)}},b(F.type,T)?r.readAsText(F):r.readAsArrayBuffer(F)):(t.previewDefault(F,x),n.trigger("fileloaded",[F,x,p]),setTimeout(i(p+1),1e3))):void setTimeout(i(p+1),1e3):(y=t.msgInvalidFileExtension.replace(/\{name\}/g,T).replace(/\{extensions\}/g,j),void(t.isError=t.showError(y,F,x,p)))}this.reader=new FileReader;var t=this,n=t.$element,a=t.$preview,r=t.reader,l=t.$previewContainer,o=t.$previewStatus,s=t.msgLoading,m=t.msgProgress,u=(t.msgSelected,t.previewFileType,parseInt(t.wrapTextLength),t.wrapIndicator,"preview-"+g()),w=e.length,h=t.fileTypeSettings,b=v("text",h)?h.text:p.text;i(0)},slug:function(e){return d(e)?"":e.split(/(\\|\/)/g).pop().replace(/[^\w-.\\\/ ]+/g,"")},change:function(i){var t,n=this,a=n.$element,r=n.slug(a.val()),l=0,o=n.$preview,s=a.get(0).files,p=n.msgSelected,c=d(s)?1:s.length+n.initialPreviewCount;if(n.hideFileIcon(),t=void 0===i.target.files?i.target&&i.target.value?[{name:i.target.value.replace(/^.+\\/,"")}]:[]:i.target.files,0!==t.length){n.resetErrors(),o.html(""),n.overwriteInitial||o.html(n.initialPreviewContent);var l=t.length;if(n.maxFileCount>0&&l>n.maxFileCount){var v=n.msgFilesTooMany.replace(/\{m\}/g,n.maxFileCount).replace(/\{n\}/g,l);return n.isError=n.showError(v,null,null,null),n.$captionContainer.find(".kv-caption-icon").hide(),n.$caption.html(n.msgValidationError),void n.$container.removeClass("file-input-new")}n.readFiles(s),n.reader=null;var m=c>1?p.replace(/\{n\}/g,c):r;n.isError?(n.$captionContainer.find(".kv-caption-icon").hide(),m=n.msgValidationError):n.showFileIcon(),n.$caption.html(m),n.$captionContainer.attr("title",e(m).text()),n.$container.removeClass("file-input-new"),a.trigger("fileselect",[c,r])}},initBrowse:function(e){var i=this;i.$btnFile=e.find(".btn-file"),i.$btnFile.append(i.$element)},createContainer:function(){var i=this,t=e(document.createElement("span")).attr({"class":"file-input file-input-new"}).html(i.renderMain());return i.$element.before(t),i.initBrowse(t),t},refreshContainer:function(){var e=this,i=e.$container;i.before(e.$element),i.html(e.renderMain()),e.initBrowse(i)},renderMain:function(){var e=this,i=e.showPreview?e.getLayoutTemplate("preview").replace(/\{class\}/g,e.previewClass):"",t=e.isDisabled?e.captionClass+" file-caption-disabled":e.captionClass,n=e.captionTemplate.replace(/\{class\}/g,t+" kv-fileinput-caption");return e.mainTemplate.replace(/\{class\}/g,e.mainClass).replace(/\{preview\}/g,i).replace(/\{caption\}/g,n).replace(/\{upload\}/g,e.renderUpload()).replace(/\{remove\}/g,e.renderRemove()).replace(/\{browse\}/g,e.renderBrowse())},renderBrowse:function(){var e=this,i=e.browseClass+" btn-file",t="";return e.isDisabled&&(t=" disabled "),'<div class="'+i+'"'+t+"> "+e.browseIcon+e.browseLabel+" </div>"},renderRemove:function(){var e=this,i=e.removeClass+" fileinput-remove fileinput-remove-button",t="";return e.showRemove?(e.isDisabled&&(t=" disabled "),'<button type="button" class="'+i+'"'+t+">"+e.removeIcon+e.removeLabel+"</button>"):""},renderUpload:function(){var e=this,i=e.uploadClass+" kv-fileinput-upload",t="",n="";return e.showUpload?(e.isDisabled&&(n=" disabled "),t=d(e.uploadUrl)?'<button type="submit" class="'+i+'"'+n+">"+e.uploadIcon+e.uploadLabel+"</button>":'<a href="'+e.uploadUrl+'" class="'+e.uploadClass+'"'+n+">"+e.uploadIcon+e.uploadLabel+"</a>"):""}},e.fn.fileinput=function(i){if(u()){var t=Array.apply(null,arguments);return t.shift(),this.each(function(){var n=e(this),a=n.data("fileinput"),r="object"==typeof i&&i;a||n.data("fileinput",a=new h(this,e.extend({},e.fn.fileinput.defaults,r,e(this).data()))),"string"==typeof i&&a[i].apply(a,t)})}},e.fn.fileinput.defaults={showCaption:!0,showPreview:!0,showRemove:!0,showUpload:!0,mainClass:"",previewClass:"",captionClass:"",mainTemplate:null,initialDelimiter:"*$$*",initialPreview:"",initialCaption:"",initialPreviewCount:0,initialPreviewContent:"",overwriteInitial:!0,layoutTemplates:r,previewTemplates:o,allowedPreviewTypes:l,allowedPreviewMimeTypes:null,allowedFileTypes:null,allowedFileExtensions:null,previewSettings:s,fileTypeSettings:p,browseLabel:"Browse &hellip;",browseIcon:'<i class="glyphicon glyphicon-folder-open"></i> &nbsp;',browseClass:"btn btn-primary",removeLabel:"Remove",removeIcon:'<i class="glyphicon glyphicon-ban-circle"></i> ',removeClass:"btn btn-default",uploadLabel:"Upload",uploadIcon:'<i class="glyphicon glyphicon-upload"></i> ',uploadClass:"btn btn-default",uploadUrl:null,maxFileSize:0,maxFileCount:0,msgSizeTooLarge:'File "{name}" (<b>{size} KB</b>) exceeds maximum allowed upload size of <b>{maxSize} KB</b>. Please retry your upload!',msgFilesTooMany:"Number of files selected for upload <b>({n})</b> exceeds maximum allowed limit of <b>{m}</b>. Please retry your upload!",msgFileNotFound:'File "{name}" not found!',msgFileNotReadable:'File "{name}" is not readable.',msgFilePreviewAborted:'File preview aborted for "{name}".',msgFilePreviewError:'An error occurred while reading the file "{name}".',msgInvalidFileType:'Invalid type for file "{name}". Only "{types}" files are supported.',msgInvalidFileExtension:'Invalid extension for file "{name}". Only "{extensions}" files are supported.',msgValidationError:'<span class="text-danger"><i class="glyphicon glyphicon-exclamation-sign"></i> File Upload Error</span>',msgErrorClass:"file-error-message",msgLoading:"Loading  file {index} of {files} &hellip;",msgProgress:"Loading file {index} of {files} - {name} - {percent}% completed.",msgSelected:"{n} files selected",previewFileType:"image",wrapTextLength:250,wrapIndicator:' <span class="wrap-indicator" title="{title}" onclick="{dialog}">[&hellip;]</span>',elCaptionContainer:null,elCaptionText:null,elPreviewContainer:null,elPreviewImage:null,elPreviewStatus:null,elErrorContainer:null},e(document).ready(function(){var i=e("input.file[type=file]"),t=null!=i.attr("type")?i.length:0;t>0&&i.fileinput()})}(window.jQuery);
/* ------------------------------------------------------------------------------
*
*  # Bootstrap multiple file uploader
*
*  Specific JS code additions for uploader_bootstrap.html page
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {

    // Basic example
    $('.file-input').fileinput({
        browseLabel: '',
        browseClass: 'btn btn-primary btn-icon',
        removeLabel: '',
        uploadLabel: '',
        uploadClass: 'btn btn-default btn-icon',
        browseIcon: '<i class="icon-plus22"></i> ',
        uploadIcon: '<i class="icon-file-upload"></i> ',
        removeClass: 'btn btn-danger btn-icon',
        removeIcon: '<i class="icon-cancel-square"></i> ',
        layoutTemplates: {
            caption: '<div tabindex="-1" class="form-control file-caption {class}">\n' + '<span class="icon-file-plus kv-caption-icon"></span><div class="file-caption-name"></div>\n' + '</div>'
        },
        initialCaption: "No file selected"
    });


    // With preview
    $(".file-input-preview").fileinput({
        browseLabel: '',
        browseClass: 'btn btn-primary btn-icon',
        removeLabel: '',
        uploadLabel: '',
        uploadClass: 'btn btn-default btn-icon',
        browseIcon: '<i class="icon-plus22"></i> ',
        uploadIcon: '<i class="icon-file-upload"></i> ',
        removeClass: 'btn btn-danger btn-icon',
        removeIcon: '<i class="icon-cancel-square"></i> ',
        layoutTemplates: {
            caption: '<div tabindex="-1" class="form-control file-caption {class}">\n' + '<span class="icon-file-plus kv-caption-icon"></span><div class="file-caption-name"></div>\n' + '</div>'
        },
        initialPreview: [
            "<img src='assets/images/demo/images/1.png' class='file-preview-image' alt=''>",
            "<img src='assets/images/demo/images/2.png' class='file-preview-image' alt=''>",
        ],
        overwriteInitial: false,
        maxFileSize: 100
    });


    // Display preview on load
    $(".file-input-overwrite").fileinput({
        browseLabel: '',
        browseClass: 'btn btn-primary btn-icon',
        removeLabel: '',
        uploadLabel: '',
        uploadClass: 'btn btn-default btn-icon',
        browseIcon: '<i class="icon-plus22"></i> ',
        uploadIcon: '<i class="icon-file-upload"></i> ',
        removeClass: 'btn btn-danger btn-icon',
        removeIcon: '<i class="icon-cancel-square"></i> ',
        layoutTemplates: {
            caption: '<div tabindex="-1" class="form-control file-caption {class}">\n' + '<span class="icon-file-plus kv-caption-icon"></span><div class="file-caption-name"></div>\n' + '</div>'
        },
        initialPreview: [
            "<img src='assets/images/demo/images/1.png' class='file-preview-image' alt=''>",
            "<img src='assets/images/demo/images/2.png' class='file-preview-image' alt=''>",
        ],
        overwriteInitial: true
    });


    // Custom layout
    $('.file-input-custom').fileinput({
        previewFileType: 'image',
        browseLabel: 'Select',
        browseClass: 'btn bg-slate-700',
        browseIcon: '<i class="icon-image2 position-left"></i> ',
        removeLabel: 'Remove',
        removeClass: 'btn btn-danger',
        removeIcon: '<i class="icon-cancel-square position-left"></i> ',
        uploadClass: 'btn bg-teal-400',
        uploadIcon: '<i class="icon-file-upload position-left"></i> ',
        layoutTemplates: {
            caption: '<div tabindex="-1" class="form-control file-caption {class}">\n' + '<span class="icon-file-plus kv-caption-icon"></span><div class="file-caption-name"></div>\n' + '</div>'
        },
        initialCaption: "No file selected"
    });


    // Advanced example
    $('.file-input-advanced').fileinput({
        browseLabel: 'Browse',
        browseClass: 'btn btn-default',
        removeLabel: '',
        uploadLabel: '',
        browseIcon: '<i class="icon-plus22 position-left"></i> ',
        uploadClass: 'btn btn-primary btn-icon',
        uploadIcon: '<i class="icon-file-upload"></i> ',
        removeClass: 'btn btn-danger btn-icon',
        removeIcon: '<i class="icon-cancel-square"></i> ',
        initialCaption: "No file selected",
        layoutTemplates: {
            caption: '<div tabindex="-1" class="form-control file-caption {class}">\n' + '<span class="icon-file-plus kv-caption-icon"></span><div class="file-caption-name"></div>\n' + '</div>',
            main1: "{preview}\n" +
            "<div class='input-group {class}'>\n" +
            "   <div class='input-group-btn'>\n" +
            "       {browse}\n" +
            "   </div>\n" +
            "   {caption}\n" +
            "   <div class='input-group-btn'>\n" +
            "       {upload}\n" +
            "       {remove}\n" +
            "   </div>\n" +
            "</div>"
        }
    });


    // Disable/enable button
    $("#btn-modify").on("click", function() {
        $btn = $(this);
        if ($btn.text() == "Disable file input") {
            $("#file-input-methods").fileinput("disable");
            $btn.html("Enable file input");
            alert("Hurray! I have disabled the input and hidden the upload button.");
        }
        else {
            $("#file-input-methods").fileinput("enable");
            $btn.html("Disable file input");
            alert("Hurray! I have reverted back the input to enabled with the upload button.");
        }
    });


    // Custom file extensions
    $(".file-input-extensions").fileinput({
        browseLabel: 'Browse',
        browseClass: 'btn btn-primary',
        removeLabel: '',
        browseIcon: '<i class="icon-plus22 position-left"></i> ',
        uploadIcon: '<i class="icon-file-upload position-left"></i> ',
        removeClass: 'btn btn-danger btn-icon',
        removeIcon: '<i class="icon-cancel-square"></i> ',
        layoutTemplates: {
            caption: '<div tabindex="-1" class="form-control file-caption {class}">\n' + '<span class="icon-file-plus kv-caption-icon"></span><div class="file-caption-name"></div>\n' + '</div>'
        },
        initialCaption: "No file selected",
        maxFilesNum: 10,
        allowedFileExtensions: ["jpg", "gif", "png", "txt"]
    });
    
});

//# sourceMappingURL=userCreate.js.map