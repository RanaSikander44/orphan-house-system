geometry = {};

geometry.Point = (function () {

/**
 * Specify either cartesian xor polar coordinates
 *
 * @param number x
 * @param number y
 * @param number r
 * @param number theta (radians)
 * @param bool polar
 */
function Point (argsDict) {
    argsDict = typeof argsDict === 'undefined' ? {} : argsDict;

    var defaultArgs = {
        DEBUG: false,
        x: null,
        y: null,
        r: null,
        theta: null,
    };
    auxlib.applyArgs (this, defaultArgs, argsDict);
    var that = this;

    if (this.x !== null && this.y !== null) {
        this._cartToPolar ();
    } else if (this.r !== null && this.theta !== null) {
        this._polarToCart ();
    } else {
        throw new Error ('Precondition violated');
    }

    this._init ();
}



/*
Public static methods
*/

/**
 * @param Point pointa
 * @param Point pointb
 * @param Point pointc
 * @param Point pointd
 * @return Point the intersect of the lines (point1a, point1b) and (point2a, point2b)
 */
Point.getIntersect = function (point1a, point1b, point2a, point2b) {
    var intersect = new Point ({
        x: ((point1a.x * point1b.y - point1a.y * point1b.x) * (point2a.x - point2b.x) -
                (point1a.x - point1b.x) * (point2a.x * point2b.y - point2a.y * point2b.x)) /
            ((point1a.x - point1b.x) * (point2a.y - point2b.y) -
                (point1a.y - point1b.y) * (point2a.x - point2b.x)),
        y: ((point1a.x * point1b.y - point1a.y * point1b.x) * (point2a.y - point2b.y) -
                (point1a.y - point1b.y) * (point2a.x * point2b.y - point2a.y * point2b.x)) /
            ((point1a.x - point1b.x) * (point2a.y - point2b.y) -
                (point1a.y - point1b.y) * (point2a.x - point2b.x))
    });
    return intersect;
};

/*
Private static methods
*/

/*
Public instance methods
*/

/**
 * Treat points as vectors and add them
 * @param Point point
 */
Point.prototype.addAsVectors = function (point) {
    return new Point ({
        x: this.x + point.x,
        y: this.y + point.y
    });
};


/**
 * Overrides Object's to string method to produce a formatted version of the point
 */
Point.prototype.toString = function () {
    return '(' + this.x + ', ' + this.y + ')';
};

/*
Private instance methods
*/

/**
 * Calculates theta and r based on values of x and y
 */
Point.prototype._cartToPolar = function () {
    this.theta = Math.atan2 (this.y, this.x);
    this.r = Math.sqrt (this.x * this.x + this.y * this.y);
};


/**
 * Calculates x and y based on values of theta and r
 */
Point.prototype._polarToCart = function () {
    this.x = (Math.cos (this.theta) * this.r);
    this.y = (Math.sin (this.theta) * this.r);
};


Point.prototype._init = function () {
    var that = this;

};

return Point;

}) ();
