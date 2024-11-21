WorkflowManager = (function () {

function WorkflowManager (argsDict) {
    argsDict = typeof argsDict === 'undefined' ? {} : argsDict;

    var defaultArgs = {
        modelId: null,
        modelName: '',
    };
    auxlib.applyArgs (this, defaultArgs, argsDict);
    WorkflowManagerBase.call (this, argsDict);

    this._init ();
}

WorkflowManager.REQUIRE_ALL = 1;

WorkflowManager.prototype = auxlib.create (WorkflowManagerBase.prototype);

/*
Public static methods
*/

/*
Private static methods
*/

/*
Public instance methods
*/

/**
 * JS equivalent of Workflow::checkStageRequirement ()
 * @param number stageNumber
 * @param array workflowStatus
 * @return bool
 */
WorkflowManager.prototype.checkStageRequirement = function (stageNumber, workflowStatus) {
    var requirementMet = true;

    // check if all stages before this one are complete
    if(parseInt (workflowStatus['stages'][stageNumber]['requirePrevious'], 10) ===
       WorkflowManager.REQUIRE_ALL) {

        for(var i=1; i<stageNumber; i++) {
            if(!workflowStatus['stages'][i]['complete']) {
                requirementMet = false;
                break;
            }
        }
    } else if(parseInt (workflowStatus['stages'][stageNumber]['requirePrevious'], 10) < 0) {
        // or just check if the specified stage is complete

        if(!workflowStatus['stages']
            [ -1 * parseInt (workflowStatus['stages'][stageNumber]['requirePrevious'], 10) ]
            ['complete']) {

            requirementMet = false;
        }
    }
    return requirementMet;
};

WorkflowManager.prototype.startWorkflowStage = function (workflowId,stageNumber,callback) {
    var that = this;
    $.ajax({
        url: that.startStageUrl,
        dataType: 'json',
        type: "GET",
        data: "workflowId="+workflowId+"&stageNumber="+stageNumber+"&modelId="+
            that.modelId + '&type=' + that.modelName + '&renderFlag=0',
        success: function(response) {
            callback (response['workflowStatus'], response['flashes']);
            Notifs.updateHistory();
        }
    });
};

WorkflowManager.prototype.completeWorkflowStage = function (workflowId,stageNumber,callback) {
    var that = this;
    $.ajax({
        url: that.completeStageUrl,
        type: 'GET',
        dataType: 'json',
        data: "workflowId="+workflowId+"&stageNumber="+stageNumber+"&modelId="+
            that.modelId + '&type=' + that.modelName + '&renderFlag=0',
        success: function(response) {
            callback (response['workflowStatus'], response['flashes']);
            Notifs.updateHistory();
        }
    });
};

WorkflowManager.prototype.workflowCommentDialog = function (workflowId,stageNumber,callback) {
    var that = this;

    $('#workflowCommentDialog').dialog(
        'option','title',that.translations['Comment Required']);

    $('#workflowCommentWorkflowId').val(workflowId);
    $('#workflowCommentStageNumber').val(stageNumber);

    $('#workflowComment').css('border','1px solid black');
    $('#workflowComment').val('')
    $('#workflowCommentDialog').dialog('open');
    $('#workflowCommentDialog').data ('callback', callback);
};

WorkflowManager.prototype.completeWorkflowStageComment = function (callback) {
    var that = this;
    var comment = $.trim($('#workflowComment').val());
    if(comment.length < 1) {
        $('#workflowComment').css('border','1px solid red');
    } else {
        $.ajax({
            url: that.completeStageUrl,
            type: 'GET',
            dataType: 'json',
            data: 'workflowId='+$('#workflowCommentWorkflowId').val()+'&stageNumber='+
                $('#workflowCommentStageNumber').val()+
                '&modelId='+that.modelId+"&type="+that.modelName+'&comment='+
                encodeURI(comment) + '&renderFlag=0',
            success: function(response) {
                callback (response['workflowStatus'], response['flashes']);
                Notifs.updateHistory();
            }
        });
        $('#workflowCommentDialog').dialog('close');
    }
};

WorkflowManager.prototype.revertWorkflowStage = function (workflowId,stageNumber,callback) {
    var that = this;
    $.ajax({
        url: that.revertStageUrl,
        type: 'GET',
        dataType: 'json',
        data: 'workflowId='+workflowId+'&stageNumber='+stageNumber+
            '&modelId='+that.modelId+"&type="+that.modelName + '&renderFlag=0',
        success: function(response) {
            callback (response['workflowStatus'], response['flashes']);
            Notifs.updateHistory();
        }
    });
};


/*
Private instance methods
*/

WorkflowManager.prototype._setUpCommentDialog = function () {
    var that = this;
    $("#workflowCommentDialog").dialog({
        autoOpen:false,
        resizable: false,
        modal: true,
        show: "fade",
        hide: "fade",
        width:400,
        buttons:[
            {
                click: function() {
                    that.completeWorkflowStageComment(
                        $('#workflowCommentDialog').data ('callback'));
                    return false;
                },
                text: that.translations['Submit'],
                "class": "highlight"
            },
            {
                text: that.translations['Cancel'],
                click: function() {
                    $(this).dialog("close");
                }
            }
        ]
    });
};

/**
 * Forces a UI refresh
 */
WorkflowManager.prototype._afterSaveStageDetails = function () {
    $("#workflowSelector").change();
};

WorkflowManager.prototype._init = function () {
    var that = this;

    this._setUpStageDetailsDialog ();
    this._setUpCommentDialog ();
};

return WorkflowManager;

}) ();
