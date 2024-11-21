jQuery(document).ready(function() {
	myApp.init(KTAppSettings);
	if($('[data-toggle="tooltip"]').length>0){
		$('[data-toggle="tooltip"]').tooltip();
	}
	if($('[data-toggle="popover"]').length>0){
		$('[data-toggle="popover"]').popover();
	}
	if($(".pastdtpicker").length>0){
		$(".pastdtpicker").datepicker({
			format: "yyyy-mm-dd",
			todayHighlight: true,
			endDate:"+0d",
		}).on("changeDate", function(e){
			$(this).datepicker("hide");
		});
	}
	if($(".futuredtpicker").length>0){
		$(".futuredtpicker").datepicker({
			format: "yyyy-mm-dd",
			todayHighlight: true,
			startDate:"0d",
		}).on("changeDate", function(e){
			$(this).datepicker("hide");
		});
	}

	$("body").on("click", ".load-modal", function () {
		modalId="general-modal";
		if($(this).filter('[data-mid]').length!==0) {
			modalId=$(this).data("mid");
		}
		url=$(this).data("url");
		heading=$(this).data("heading");
		$.ajax({
			url: url,
			dataType: "html",
			success: function(data) {
				$("#"+modalId).find("h5.modal-title").html(heading);
				$("#"+modalId).find(".modalContent").html(data);
				$("#"+modalId).modal();
			},
			error: bbAlert
		});
	});
	$("body").on("change", ".custom-file-input", function () {
		readImageURL(this,$(this));
	});
	$("body").on("change", ".icon-file-input", function () {
		readImageURLIcon(this,$(this));
	});
	$("body").on("click", ".remove-ii-img", function () {
		defImg = $(this).data('defimg');
		$(this).parents(".image-input").addClass("image-input-empty").removeClass("image-input-changed").css("background-image","url('" + defImg + "')")
	});
	$(".select-on-check-all").click(function(){
		if(this.checked===true){
			$('input[name="selection[]"]:checkbox').prop('checked', true);
		}else{
			$('input[name="selection[]"]:checkbox').prop('checked', false);
		}
	});
});
function bbAlert(xhr, ajaxOptions, thrownError){
	swal({title: thrownError, html: xhr.statusText + "\n" + xhr.responseText, type: "error"});
	$(".blockUI").remove();
}
window.closeModal = function()
{
	$('.modal').modal('hide');
};
function nl2br (str, is_xhtml) {
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
	return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}
function readImageURL(input,el) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			if(!$(el).parents(".form-group").hasClass("nichng")){
				if($(el).parents(".form-group").find(".input-group-text img").length>0){
					$(el).parents(".form-group").find(".input-group-text img").attr("src", e.target.result);
				}else{
					tmpImg='<img src="'+e.target.result+'" width="26" height="26" />'
					$(el).parents(".form-group").find(".input-group-text").addClass("img-icon").html(tmpImg);
				}
			}
		}
		reader.readAsDataURL(input.files[0]);
		$(el).parents(".form-group").find(".input-group label").html(input.files[0].name);
	}
}
function readImageURLIcon(input,el) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			console.log(e.target.result);
			$(el).parents(".image-input").removeClass("image-input-empty").addClass("image-input-changed").css("background-image","url('" + e.target.result + "')");
		}
		reader.readAsDataURL(input.files[0]);
	}
}
function startBackgrounTask(url,_targetContainer)
{
	$.ajax({
		url: url,
		type: "POST",
		success: function(response) {
			response = jQuery.parseJSON(response);
			if(response["error"]!=null && response["error"]!=''){
				myApp.unblock('#'+_targetContainer);
				if(response["error"]["closeWindow"]!=null && response["error"]["closeWindow"]!=''){
					window.closeModal();
				}
				swal({title: response["error"]["heading"], html: response["error"]["msg"], type: "error"});
			}
			if(response["success"]!=null && response["success"]!=''){
				myApp.unblock('#'+_targetContainer);
				if(response["success"]["reloadContainer"]!=null && response["success"]["reloadContainer"]!=''){
					$.pjax.reload({container: response["success"]["reloadContainer"], timeout: 2000});
				}
				if(response["success"]["msg"]!=null && response["success"]["msg"]!=''){
					swal({title: response["success"]["heading"], html: response["success"]["msg"], type: "error", timer: 5000});
				}
				if(response["success"]["closeWindow"]!=null && response["success"]["closeWindow"]!=''){
					window.closeModal();
				}
			}
			if(response["progress"]!=null && response["progress"]!=""){
				move(response["progress"]["percentage"]);
				startBackgrounTask(response["progress"]["url"],_targetContainer);
			}
		},
		error: bbAlert
	});
}
function move(width)
{
	if($("#myBar").length>0){
		var elem = document.getElementById("myBar");
		elem.style.width = width + '%';
		if(width>10){
			//elem.innerHTML = width * 1 + '%';
		}
	}
}
function moveProgressBar(width)
{
	var elem = document.getElementById("myBar");
	elem.style.width = width + '%';
}
function moveElProgressBar(elem,width)
{
	elem.css("width", width+'%');
}
function blockUI(gridId)
{
	html = '<div class="overlay-layer bg-dark-o-10">';
	html+= '  <div class="spinner spinner-primary"></div>';
	html+= '</div>';
	$("#"+gridId).addClass("overlay").addClass("overlay-block");
	$("#"+gridId).append(html);
}
function unBlockUI(gridId)
{
	$("#"+gridId).removeClass("overlay").removeClass("overlay-block")
	$("#"+gridId).find(".overlay-layer").remove();
}
var myApp = function() {
    var settings = {};

    return {
        init: function(settingsArray) {
            if (settingsArray) {
                settings = settingsArray;
            }
        },

        block: function(target, options) {
            var el = $(target);

            options = $.extend(true, {
                opacity: 0.05,
                overlayColor: '#000000',
                type: '',
                size: '',
                state: 'primary',
                centerX: true,
                centerY: true,
                message: '',
                shadow: true,
                width: 'auto'
            }, options);

            var html;
            var version = options.type ? 'spinner-' + options.type : '';
            var state = options.state ? 'spinner-' + options.state : '';
            var size = options.size ? 'spinner-' + options.size : '';
            var spinner = '<span class="spinner ' + version + ' ' + state + ' ' + size + '"></span';

            if (options.message && options.message.length > 0) {
                var classes = 'blockui ' + (options.shadow === false ? 'blockui' : '');

                html = '<div class="' + classes + '"><span>' + options.message + '</span>' + spinner + '</div>';

                var el = document.createElement('div');

                $('body').prepend(el);
                KTUtil.addClass(el, classes);
                el.innerHTML = html;
                options.width = KTUtil.actualWidth(el) + 10;
                KTUtil.remove(el);

                if (target == 'body') {
                    html = '<div class="' + classes + '" style="margin-left:-' + (options.width / 2) + 'px;"><span>' + options.message + '</span><span>' + spinner + '</span></div>';
                }
            } else {
                html = spinner;
            }

            var params = {
                message: html,
                centerY: options.centerY,
                centerX: options.centerX,
                css: {
                    top: '30%',
                    left: '50%',
                    border: '0',
                    padding: '0',
                    backgroundColor: 'none',
                    width: options.width
                },
                overlayCSS: {
                    backgroundColor: options.overlayColor,
                    opacity: options.opacity,
                    cursor: 'wait',
                    zIndex: (target == 'body' ? 1100 : 10)
                },
                onUnblock: function() {
                    if (el && el[0]) {
                        KTUtil.css(el[0], 'position', '');
                        KTUtil.css(el[0], 'zoom', '');
                    }
                }
            };

            if (target == 'body') {
                params.css.top = '50%';
                $.blockUI(params);
            } else {
                var el = $(target);
                el.block(params);
            }
        },
        blockUIProgress: function(target, options) {
            var el = $(target);

            options = $.extend(true, {
                opacity: 0.05,
                overlayColor: '#000000',
                type: '',
                size: '',
                state: 'primary',
                centerX: true,
                centerY: true,
                message: '',
                shadow: true,
                width: 'auto'
            }, options);

            var html;
            var version = options.type ? 'spinner-' + options.type : '';
            var state = options.state ? 'spinner-' + options.state : '';
            var size = options.size ? 'spinner-' + options.size : '';
            var spinner = '<span class="spinner ' + version + ' ' + state + ' ' + size + '"></span';

						spinner ='';
						spinner ='<div class="myProgress">';
						spinner+='	<div class="myBar myprogbar mpbel"></div>';
						spinner+='</div>';

            if (options.message && options.message.length > 0) {
                var classes = 'blockui ' + (options.shadow === false ? 'blockui' : '');

                html = '<div class="' + classes + ' no-citm"><span>' + options.message + '</span>' + spinner + '</div>';

                var el = document.createElement('div');

                $('body').prepend(el);
                KTUtil.addClass(el, classes);
                el.innerHTML = html;
                options.width = KTUtil.actualWidth(el) + 10;
                KTUtil.remove(el);

                if (target == 'body') {
                    html = '<div class="' + classes + '" style="margin-left:-' + (options.width / 2) + 'px;"><span>' + options.message + '</span><span>' + spinner + '</span></div>';
                }
            } else {
                html = spinner;
            }

            var params = {
                message: html,
                centerY: options.centerY,
                centerX: options.centerX,
                css: {
                    top: '30%',
                    left: '50%',
                    border: '0',
                    padding: '0',
                    backgroundColor: 'none',
                    width: options.width
                },
                overlayCSS: {
                    backgroundColor: options.overlayColor,
                    opacity: options.opacity,
                    cursor: 'wait',
                    zIndex: (target == 'body' ? 1100 : 10)
                },
                onUnblock: function() {
                    if (el && el[0]) {
                        KTUtil.css(el[0], 'position', '');
                        KTUtil.css(el[0], 'zoom', '');
                    }
                }
            };

            if (target == 'body') {
                params.css.top = '50%';
                $.blockUI(params);
            } else {
                var el = $(target);
                el.block(params);
            }
        },

        unblock: function(target) {
            if (target && target != 'body') {
                $(target).unblock();
            } else {
                $.unblockUI();
            }
        },

        blockPage: function(options) {
            return myApp.block('body', options);
        },

        unblockPage: function() {
            return myApp.unblock('body');
        },

        getSettings: function() {
            return settings;
        }
    };
}();

function validateEmail($email) {
 var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
 return emailReg.test( $email );
}
