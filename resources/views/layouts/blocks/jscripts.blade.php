<script type="text/javascript">
var toBtm=false;
var tutils = (function () {
  return {
    escapeRegExChars: function (value) {
      return value.replace(/[|\\{}()[\]^$+*?.]/g, "\\$&");
    },
    createNode: function (containerClass) {
      var div = document.createElement('div');
      div.className = containerClass;
      div.style.position = 'absolute';
      div.style.display = 'none';
      return div;
    }
  };
}());

$(document).ready(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    }
  });
  
  $("body").on("click", ".poplink", function (e) {
    e.preventDefault();
    
    modalId="general-modal";
    if($(this).filter('[data-mid]').length!==0) {
      modalId=$(this).data("mid");
    }
    url=$(this).attr("href");
    heading=$(this).data("heading");
    
    popUpAjax(modalId,url,heading);
  });
  
  $('.ajax-form').submit(function (e) {
    e.preventDefault();
    frm = $(this);
    frmId = frm.attr("id");
    pjxContainer = '';
    if(frm.filter('[data-pjxcntr]').length!==0) {
      pjxContainer=$(this).data('pjxcntr');
    }
    
    frm.find('input[type=submit]').attr("disabled",true);
    
    myApp.block('#'+pjxContainer, {
      overlayColor: '#000000',
      state: 'danger',
      message: "{{__('common.please_wait')}}"
    });
    
    var action = this.action;
    var data = frm.serialize();
    $.ajax({
      url: action,
      type: 'POST',
      data: data,
      success: function (response) {
        if(response['success']){
          toastr.success(response["success"]["msg"], response["success"]["heading"]);
          document.getElementById(frmId).reset();
          if(pjxContainer!=''){
            $.pjax.reload({container: "#"+pjxContainer, async:false, timeout: 5000});
          }
        }else{
          swal({title: response["error"]["heading"], html: response["error"]["msg"], type: "error"});
        }
        myApp.unblock('#'+pjxContainer);
        frm.find('input[type=submit]').attr("disabled",false);
      },
      error: bbAlert
    });
  });
  $('.ajax-form-files').submit(function (e) {
    e.preventDefault();
    frm = $(this);
    frmId = frm.attr("id");
    pjxContainer = '';
    if(frm.filter('[data-pjxcntr]').length!==0) {
      pjxContainer=$(this).data('pjxcntr');
    }
    
    // frm.find('input[type=submit]').attr("disabled",true);
    
    myApp.block('#'+pjxContainer, {
      overlayColor: '#000000',
      state: 'danger',
      message: "{{__('common.please_wait')}}"
    });
    
    var formData = new FormData(frm[0]);
    $.ajax({
      url: frm.attr("action"),
      type: 'POST',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        myApp.unblock('#'+pjxContainer);
        frm.find('input[type=submit]').attr("disabled",false);
        if(response['success']){
          toastr.success(response["success"]["msg"], response["success"]["heading"]);
          document.getElementById(frmId).reset();
          if($(".file-input").length>0){
            $(".file-input").find(".input-group-text").html('<i class="flaticon-presentation"></i>');
            $(".file-input").find(".custom-file-label").html("{{ __('common.choose_image') }}");
          }
          if(pjxContainer!=''){
            $.pjax.reload({container: "#"+pjxContainer, async:false, timeout: 5000});
          }
        }else{
          swal({title: response["error"]["heading"], html: response["error"]["msg"], type: "error"});
        }
      },
      error: bbAlert
    });
  });
  $("body").on("submit", "form.simple-ajax-submit", function (e) {
    e.preventDefault();
    frm = $(this);
    frmId = frm.attr("id");
    pjxContainer = '';
    blockContainer = '';
    if(frm.filter('[data-pjxcntr]').length!==0) {
      pjxContainer=$(this).data('pjxcntr');
    }
    if(frm.filter('[data-blockcntr]').length!==0) {
      blockContainer = $(this).data('blockcntr');
    }else if(frmId!=""){
      blockContainer = frmId;
    }
    
    // frm.find('input[type=submit]').attr("disabled",true);
    if(blockContainer!=''){
      myApp.block('#'+blockContainer, {
        overlayColor: '#000000',
        state: 'danger',
        message: "{{__('common.please_wait')}}"
      });
    }
    
    var formData = new FormData(frm[0]);
    $.ajax({
      url: frm.attr("action"),
      type: 'POST',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        
        if(blockContainer!='')myApp.unblock('#'+blockContainer);
        frm.find('input[type=submit]').attr("disabled",false);
        if(response['success']){
          if(frm.parents(".mmcls").length>0){
            mid = frm.parents(".mmcls").attr("id");
            $("#"+mid).modal("hide");
            $("#"+mid).find(".modalContent").html('');
          }else{
            frm.trigger("reset");
          }
          toastr.success(response["success"]["msg"], response["success"]["heading"]);
          // document.getElementById(frmId).reset();
          if($(".file-input").length>0){
            $(".file-input").find(".input-group-text").html('<i class="flaticon-presentation"></i>');
            $(".file-input").find(".custom-file-label").html("{{ __('common.choose_image') }}");
          }
          if(frm.find(".select2").length>0){
            frm.find(".select2").trigger("change");
          }
          if(frm.find(".actionReminderInfo").length>0){
            frm.find(".actionReminderInfo").addClass("d-none");
          }
          if(frm.find(".calendarReminderInfo").length>0){
            frm.find(".calendarReminderInfo").addClass("d-none");
          }
          
          // $.pjax.reload({container: "#"+pjxContainer, async:false, timeout: 10000});
          // alert(pjxContainer);
          if(pjxContainer!='' && $("#"+pjxContainer).length>0){
            // $("#"+pjxContainer).html("");
            $.pjax.reload({container: "#"+pjxContainer, async:false, timeout: 10000});
          }else{
            alert("im here")
          }
          if (typeof loadCalendar !== 'undefined' && $.isFunction(loadCalendar)) {
            loadCalendar()
            $("#general-modal").modal('hide');
            $("#secondary-modal").modal('hide');
          }
          if (typeof initPageScripts !== 'undefined' && $.isFunction(initPageScripts)) {
            toBtm=true;
            initPageScripts()
          }
        }
        
        else{
          if(response['reload']){
            modalId = response['reload']['modalId'];
            url = response['reload']['url'];
            heading = response['reload']['heading'];
            popUpAjax(modalId,url,heading);
          }
          if(response['errors']){
            response['errors'].each(function(key,val) {
              toastr.success(val, "{{__('common.error')}}");
            });
          }else{
            mid = frm.parents(".mmcls").attr("id");
            $("#"+mid).find(".modalContent").html(response);
            //swal({title: "Error", html: "An error occured while performing the action, Please try again in a while.", type: "error"});
          }
        }
      },
      error: function(xhr, ajaxOptions, thrownError){
        var obj = xhr.responseJSON.errors;
        $.each(obj, function(key,value) {
          toastr.error(value, "{{__('common.error')}}");
        });
      }
    });
    
    return false;
  });
  
  $("body").on("click", ".act-confirmation", function (e) {
    e.preventDefault();
    confirmationMsg=$(this).data("confirmationmsg");
    pjxContainer = '';
    if($(this).filter('[data-pjxcntr]').length!==0) {
      pjxContainer=$(this).data('pjxcntr');
    }
    url = $(this).attr('href');
    
    swal({
      title: "{{__('common.confirmation')}}",
      html: confirmationMsg,
      type: "info",
      showCancelButton: true,
      confirmButtonColor: "#47a447",
      confirmButtonText: "{{__('common.confirm')}}",
      cancelButtonText: "{{__('common.cancel')}}",
    }).then((result) => {
      if (result.value) {
        if(pjxContainer!=''){
          makeAjaxRequest(url,pjxContainer);
        }else{
          window.location.href = $(this).attr('href');
        }
      }else{
        return false;
      }
    });
  });
  
  
  
  if($(".dtpicker").length>0){
    $('.dtpicker').datepicker({
      format: "yyyy-mm-dd",
      todayHighlight: true,
      orientation: "bottom left",
      autoclose: true
    });
  }
  if($(".select2").length>0){
    $( ".select2" ).select2({
      allowClear: true,
      width: "100%",
    });
  }
  if($(".dtrpicker").length>0){
    initDateRangePicker(".dtrpicker");
  }
  if($(".tagsInput").length>0){
    $(".tagsInput").tagsInput({
      "width":"100%",
      "defaultText":"{{__('common.add_tags')}}",
    });
  }
  if($(".selectpicker").length>0){
    $('.selectpicker').selectpicker();
  }
  // if($(".autocomplete").length>0){
    
    $("body").on("keypress", ".autocomplete", function () {
      _t=$(this);
      recipt = _t.data('recipt');
      $(this).autocomplete({
        serviceUrl: _t.data("ds"),
        noCache: true,
        onSelect: function(suggestion) {
          if($("#"+_t.data("fld")).val()!=suggestion.data){
            $("#"+_t.data("fld")).val(suggestion.data);
            if(recipt=='recipt'){
              $("#"+_t.data("fld")).trigger('change');
            }
          }
        },
        onSearchStart: function(params) {
          $("#"+_t.data("fld")).val("0");
        },
        onSearchError: function() {
          $("#"+_t.data("fld")).val("0");
        },
        formatResult: function(suggestion, currentValue){
          if (!currentValue) {
            return suggestion.value;
          }
          
          var pattern = '(' + tutils.escapeRegExChars(currentValue) + ')';
          return suggestion.full_value
          .replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>')
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/"/g, '&quot;')
          .replace(/&lt;(\/?strong)&gt;/g, '<$1>');
        }
      });
    });
    // }
    @stack('toasterinlinejs')
    @stack('jsScripts')
  });
  
  
  
  function makeAjaxRequest(url,grid){
    myApp.block('#'+grid, {
      overlayColor: '#000000',
      state: 'danger',
      message: "{{__('common.please_wait')}}"
    });
    $.ajax({
      url: url,
      type: 'POST',
      dataType: "json",
      success: function(response) {
        myApp.unblock('#'+grid);
        if(response['success']){
          toastr.success(response["success"]["msg"], response["success"]["heading"]);
          if(grid!=""){
            $.pjax.reload({container: "#"+grid, async:false, timeout: 10000});
            if (typeof initPageScripts !== 'undefined' && $.isFunction(initPageScripts)) {
              toBtm=true;
              initPageScripts()
            }
          }else{
            
            window.location.reload();
          }
        }else{
          swal({title: response["error"]["heading"], html: response["error"]["msg"], type: "error"});
        }
      },
      error: bbAlert
    });
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  function makeSilentAjaxRequest(url,grid){
    if(grid!=''){
      myApp.block('#'+grid, {
        overlayColor: '#000000',
        state: 'danger',
        message: "{{__('common.please_wait')}}"
      });
    }
    $.ajax({
      url: url,
      type: 'POST',
      dataType: "json",
      success: function(response) {
        if(grid!=''){
          myApp.unblock('#'+grid);
        }
        if(response['success']){
          toastr.success(response["success"]["msg"], response["success"]["heading"]);
        }
      },
    });
  }
  function makeSilentAjaxRequestWithData(url,data,grid){
    if(grid!=''){
      myApp.block('#'+grid, {
        overlayColor: '#000000',
        state: 'danger',
        message: "{{__('common.please_wait')}}"
      });
    }
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      dataType: "json",
      success: function(response) {
        if(grid!=''){
          myApp.unblock('#'+grid);
        }
        if(response['success']){
          toastr.success(response["success"]["msg"], response["success"]["heading"]);
        }
      },
    });
  }
  function sBCG(url,_targetContainer,cEl,contentHtml,callbackfunc)
  {
    $.ajax({
      url: url,
      type: "POST",
      dataType: "json",
      success: function(response) {
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
        if(response["append"]){
          contentHtml+=response["append"]["contentHtml"];
        }
        if(response["progress"]!=null && response["progress"]!=""){
          pbe = $('#'+_targetContainer).find(".mpbel")
          moveElProgressBar(pbe,response["progress"]["percentage"]);
          if(response["progress"]["url"] && response["progress"]["url"]!=''){
            sBCG(response["progress"]["url"],_targetContainer,cEl,contentHtml,callbackfunc);
          }else{
            $("#"+cEl).html(contentHtml);
            myApp.unblock('#'+_targetContainer);
            if($('[data-toggle="tooltip"]').lenght>0){
              $('[data-toggle="tooltip"]').tooltip();
            }
            if(callbackfunc!=null){
              callbackfunc(_targetContainer);
            }
          }
        }
      },
      error: bbAlert
    });
  }
  
  
  
  
  
  function popUpAjax(modalId,url,heading)
  {
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
  }
  
  
  
  
  
  function initDateRangePicker(el)
  {
    $(el).daterangepicker({
      timePicker: false,
      locale: {
        format: "YYYY-MM-DD",
      },
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      showCustomRangeLabel: true,
      alwaysShowCalendars:true
    }, function(start, end, label) {
      $(el+' .form-control').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    });
  }
  
  
  
  $("body").on("change", ".amount-to-pay", function(e) {
    amount = parseInt($(this).val());
    pending_fee = parseInt($("#pending_fee").val());
    
    if(pending_fee==0){
      swal({
        title: "No pending fee",
        html: "Your all fee is clered",
        type: "warning",
        timer: 5000
      });
      $(this).val('');
    }
    else{
      if (amount > pending_fee) {
        
        swal({
          title: "Pending fee is "+pending_fee,
          html: "please enter less then or equal to  "+pending_fee,
          type: "warning",
          timer: 5000
        });
        $(this).val(pending_fee);
      }
    }
  });
  
  
    $("body").on("click", ".sidebar-toggle-btn", function(e) {
        $.ajax({
          url: "{{url('/admin/update/sidebar')}}",
          type: 'POST',
          success: function (response) {
          },
          error: bbAlert
        });
    });
  
  @stack('jsFunc')
  </script>
  