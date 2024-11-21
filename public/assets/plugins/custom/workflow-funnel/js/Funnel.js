Funnel = (function () {

var Point = geometry.Point;

/**
 * Funnel used on the workflow funnel view page
 */
function Funnel (argsDict) {
    argsDict = typeof argsDict === 'undefined' ? {} : argsDict;

    var defaultArgs = {
        stageValues: null, // array of projected deal values for each stage
        totalValue: null, // formatted sum of stageValues
        recordsPerStage: null, // array of record counts per stage
        stageNameLinks: null, // array of links which open stage details
    };
    auxlib.applyArgs (this, defaultArgs, argsDict);
    BaseFunnel.call (this, argsDict);

    this._stageHeight = 70; // temporary. replace when stage heights are depend on status

    this._init ();
}

Funnel.prototype = auxlib.create (BaseFunnel.prototype);


/*
Public static methods
*/

/*
Private static methods
*/

/*
Public instance methods
*/

/*
Private instance methods
*/

/**
 * Place stage counts on top of funnel
 */
Funnel.prototype._addStageCounts = function () {
    var that = this;
    /*var canvasTopLeft = new Point ({
        x: $(this.containerSelector).position ().left,
        y: $(this.containerSelector).position ().top,
    });*/

    for (var i = 0; i < this.stageCount; i++) {

        // create a container element for the stage count and position it near the centroid of the
        // stage trapezoid.
        var stageCountContainer = $('<span>', {
            'class': 'funnel-stage-count',
            html: '<b>' + this.recordsPerStage[i] + '</b>',
            css: {
                position: 'absolute',
                width: '100px',
                'text-align': 'center',
                left: this._stageCentroids[i].x - 20,
                top: this._stageCentroids[i].y - 15,
                'font-size': '25px',
                'margin-top': '-8px',
                'color': '#fff',
                'text-shadow': 'rgba(250,250,250,0.5) 0px 2px 0px'
            }
        });

        $(this.containerSelector).append (stageCountContainer);

        // click the stage name link when the corresponding stage count is clicked
        $(stageCountContainer).click ((function () {
            var j = i;
            return function () {
                $('.stage-name-link-' + j).click ();
                return false;
            };
        }) ());
    }
};

/**
 * Place stage name links to the left of the funnel with y coordinate aligned with stage centroid
 */
Funnel.prototype._addStageNameLinks = function () {
    var that = this;
    for (var i = 0; i < this.stageCount; i++) {
        var link = $(this.stageNameLinks[i]);
        $(link).addClass ('stage-name-link-' + i);
        $(link).addClass ('stage-name-link');
        $(link).css ({
            top: this._stageCentroids[i].y - 5
        });
        $(this.containerNameSelector).append (link);
    }

    // retrieve max width of stage name links and shift all links over by that amount
    var maxWidth = Math.max.apply (null, auxlib.map (function (a) {
        return $(a).width ();
    }, $.makeArray ($(this.containerNameSelector).find ('.stage-name-link'))));

    // var extraSpace = 20;
    // $(this.containerNameSelector).find ('.stage-name-link').each (function (i, elem) {
    //     $(elem).css ('left', -maxWidth - extraSpace);
    // });

    // var extraMargin = 18;
    // $(this.containerNameSelector).css (
    //     'margin-left', maxWidth + extraSpace + extraMargin);

};

/**
 * Place stage values in a column to the right of the funnel with y coordinate aligned with stage
 * centroid
 */
Funnel.prototype._addStageValues = function () {
    var that = this;
    for (var i = 0; i < this.stageCount; i++) {
        var stageValueContainer = $('<span>', {
            'class': 'funnel-stage-value',
            html: '<b>' + this.stageValues[i] + '</b>',
            css: {
                position: 'absolute',
                // right: -(this._funnelW1 / 2) - 15,
                top: this._stageCentroids[i].y - 10,
            }
        });
        $(this.containerAmountSelector).append (stageValueContainer);
    }
};

/**
 * Add totals row below the funnel
 */
Funnel.prototype._addTotals = function () {
    var that = this;
    var totalRecordsContainer = $('<span>', {
        'class': 'funnel-total-records',
        html: this.translations['Total Records'] + ': <b>' +
            auxlib.reduce (function (a, b) { return a + b; },
            auxlib.map (function (a) { return parseInt (a, 10); }, this.recordsPerStage)) + '</b>',
        // css: {
        //     position: 'absolute',
        //     left: $(this.containerSelector).find ('.stage-name-link').last ().css ('left'),
        //     top: this._funnelHeight + 10,
        // }
    });
    $(this.containerSummarySelector).append (totalRecordsContainer);

};


/**
 * Populate _stageHeights property with heights of individual stages
 */
Funnel.prototype._calculateStageHeights = function () {
    var that = this;
    // calculate stage heights
    this._stageHeights = [];

    // each stage is given the same height
    for (var i = 0; i < this.stageCount; i++) {
        this._stageHeights.push (this._stageHeight);
    }
};

Funnel.prototype._calculateFunnelHeight = function () {
    this._funnelHeight = this._stageHeight * this.stageCount;
};

/**
 * Overrides parent method. Adds stage height calculation
 */
Funnel.prototype._calculatePreliminaryData = function () {
    var that = this;
    this._calculateStageHeights ();
    this._calculateFunnelHeight ();
    BaseFunnel.prototype._calculatePreliminaryData.call (this);
};

Funnel.prototype._init = function () {
    var that = this;

    BaseFunnel.prototype._init.call (this);
    that._addStageCounts ();
    that._addStageNameLinks ();
    that._addStageValues ();
    that._addTotals ();
};

return Funnel;

}) ();
