/**
 * Start JSON.org JSON methods
 */

/*
    http://www.JSON.org/json2.js
    2010-03-20

    Public Domain.

    NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.

    See http://www.JSON.org/js.html


    This code should be minified before deployment.
    See http://javascript.crockford.com/jsmin.html

    USE YOUR OWN COPY. IT IS EXTREMELY UNWISE TO LOAD CODE FROM SERVERS YOU DO
    NOT CONTROL.


    This file creates a global JSON object containing two methods: stringify
    and parse.

	JSON.stringify(value, replacer, space)
	    value       any JavaScript value, usually an object or array.

	    replacer    an optional parameter that determines how object
			values are stringified for objects. It can be a
			function or an array of strings.

	    space       an optional parameter that specifies the indentation
			of nested structures. If it is omitted, the text will
			be packed without extra whitespace. If it is a number,
			it will specify the number of spaces to indent at each
			level. If it is a string (such as '\t' or '&nbsp;'),
			it contains the characters used to indent at each level.

	    This method produces a JSON text from a JavaScript value.

	    When an object value is found, if the object contains a toJSON
	    method, its toJSON method will be called and the result will be
	    stringified. A toJSON method does not serialize: it returns the
	    value represented by the name/value pair that should be serialized,
	    or undefined if nothing should be serialized. The toJSON method
	    will be passed the key associated with the value, and this will be
	    bound to the value

	    For example, this would serialize Dates as ISO strings.

		Date.prototype.toJSON = function (key) {
		    function f(n) {
			// Format integers to have at least two digits.
			return n < 10 ? '0' + n : n;
		    }

		    return this.getUTCFullYear()   + '-' +
			 f(this.getUTCMonth() + 1) + '-' +
			 f(this.getUTCDate())      + 'T' +
			 f(this.getUTCHours())     + ':' +
			 f(this.getUTCMinutes())   + ':' +
			 f(this.getUTCSeconds())   + 'Z';
		};

	    You can provide an optional replacer method. It will be passed the
	    key and value of each member, with this bound to the containing
	    object. The value that is returned from your method will be
	    serialized. If your method returns undefined, then the member will
	    be excluded from the serialization.

	    If the replacer parameter is an array of strings, then it will be
	    used to select the members to be serialized. It filters the results
	    such that only members with keys listed in the replacer array are
	    stringified.

	    Values that do not have JSON representations, such as undefined or
	    functions, will not be serialized. Such values in objects will be
	    dropped; in arrays they will be replaced with null. You can use
	    a replacer function to replace those with JSON values.
	    JSON.stringify(undefined) returns undefined.

	    The optional space parameter produces a stringification of the
	    value that is filled with line breaks and indentation to make it
	    easier to read.

	    If the space parameter is a non-empty string, then that string will
	    be used for indentation. If the space parameter is a number, then
	    the indentation will be that many spaces.

	    Example:

	    text = JSON.stringify(['e', {pluribus: 'unum'}]);
	    // text is '["e",{"pluribus":"unum"}]'


	    text = JSON.stringify(['e', {pluribus: 'unum'}], null, '\t');
	    // text is '[\n\t"e",\n\t{\n\t\t"pluribus": "unum"\n\t}\n]'

	    text = JSON.stringify([new Date()], function (key, value) {
		return this[key] instanceof Date ?
		    'Date(' + this[key] + ')' : value;
	    });
	    // text is '["Date(---current time---)"]'


	JSON.parse(text, reviver)
	    This method parses a JSON text to produce an object or array.
	    It can throw a SyntaxError exception.

	    The optional reviver parameter is a function that can filter and
	    transform the results. It receives each of the keys and values,
	    and its return value is used instead of the original value.
	    If it returns what it received, then the structure is not modified.
	    If it returns undefined then the member is deleted.

	    Example:

	    // Parse the text. Values that look like ISO date strings will
	    // be converted to Date objects.

	    myData = JSON.parse(text, function (key, value) {
		var a;
		if (typeof value === 'string') {
		    a =
/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2}(?:\.\d*)?)Z$/.exec(value);
		    if (a) {
			return new Date(Date.UTC(+a[1], +a[2] - 1, +a[3], +a[4],
			    +a[5], +a[6]));
		    }
		}
		return value;
	    });

	    myData = JSON.parse('["Date(09/09/2001)"]', function (key, value) {
		var d;
		if (typeof value === 'string' &&
			value.slice(0, 5) === 'Date(' &&
			value.slice(-1) === ')') {
		    d = new Date(value.slice(5, -1));
		    if (d) {
			return d;
		    }
		}
		return value;
	    });


    This is a reference implementation. You are free to copy, modify, or
    redistribute.
*/

/*jslint evil: true, strict: false */

/*members "", "\b", "\t", "\n", "\f", "\r", "\"", JSON, "\\", apply,
    call, charCodeAt, getUTCDate, getUTCFullYear, getUTCHours,
    getUTCMinutes, getUTCMonth, getUTCSeconds, hasOwnProperty, join,
    lastIndex, length, parse, prototype, push, replace, slice, stringify,
    test, toJSON, toString, valueOf
*/


// Create a JSON object only if one does not already exist. We create the
// methods in a closure to avoid creating global variables.

if (!this.JSON) {
    this.JSON = {};
}

(function () {

    function f(n) {
	// Format integers to have at least two digits.
	return n < 10 ? '0' + n : n;
    }

    if (typeof Date.prototype.toJSON !== 'function') {

	Date.prototype.toJSON = function (key) {

	    return isFinite(this.valueOf()) ?
		   this.getUTCFullYear()   + '-' +
		 f(this.getUTCMonth() + 1) + '-' +
		 f(this.getUTCDate())      + 'T' +
		 f(this.getUTCHours())     + ':' +
		 f(this.getUTCMinutes())   + ':' +
		 f(this.getUTCSeconds())   + 'Z' : null;
	};

	String.prototype.toJSON =
	Number.prototype.toJSON =
	Boolean.prototype.toJSON = function (key) {
	    return this.valueOf();
	};
    }

    var cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
	escapable = /[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
	gap,
	indent,
	meta = {    // table of character substitutions
	    '\b': '\\b',
	    '\t': '\\t',
	    '\n': '\\n',
	    '\f': '\\f',
	    '\r': '\\r',
	    '"' : '\\"',
	    '\\': '\\\\'
	},
	rep;


    function quote(string) {

// If the string contains no control characters, no quote characters, and no
// backslash characters, then we can safely slap some quotes around it.
// Otherwise we must also replace the offending characters with safe escape
// sequences.

	escapable.lastIndex = 0;
	return escapable.test(string) ?
	    '"' + string.replace(escapable, function (a) {
		var c = meta[a];
		return typeof c === 'string' ? c :
		    '\\u' + ('0000' + a.charCodeAt(0).toString(16)).slice(-4);
	    }) + '"' :
	    '"' + string + '"';
    }


    function str(key, holder) {

// Produce a string from holder[key].

	var i,          // The loop counter.
	    k,          // The member key.
	    v,          // The member value.
	    length,
	    mind = gap,
	    partial,
	    value = holder[key];

// If the value has a toJSON method, call it to obtain a replacement value.

	if (value && typeof value === 'object' &&
		typeof value.toJSON === 'function') {
	    value = value.toJSON(key);
	}

// If we were called with a replacer function, then call the replacer to
// obtain a replacement value.

	if (typeof rep === 'function') {
	    value = rep.call(holder, key, value);
	}

// What happens next depends on the value's type.

	switch (typeof value) {
	case 'string':
	    return quote(value);

	case 'number':

// JSON numbers must be finite. Encode non-finite numbers as null.

	    return isFinite(value) ? String(value) : 'null';

	case 'boolean':
	case 'null':

// If the value is a boolean or null, convert it to a string. Note:
// typeof null does not produce 'null'. The case is included here in
// the remote chance that this gets fixed someday.

	    return String(value);

// If the type is 'object', we might be dealing with an object or an array or
// null.

	case 'object':

// Due to a specification blunder in ECMAScript, typeof null is 'object',
// so watch out for that case.

	    if (!value) {
		return 'null';
	    }

// Make an array to hold the partial results of stringifying this object value.

	    gap += indent;
	    partial = [];

// Is the value an array?

	    if (Object.prototype.toString.apply(value) === '[object Array]') {

// The value is an array. Stringify every element. Use null as a placeholder
// for non-JSON values.

		length = value.length;
		for (i = 0; i < length; i += 1) {
		    partial[i] = str(i, value) || 'null';
		}

// Join all of the elements together, separated with commas, and wrap them in
// brackets.

		v = partial.length === 0 ? '[]' :
		    gap ? '[\n' + gap +
			    partial.join(',\n' + gap) + '\n' +
				mind + ']' :
			  '[' + partial.join(',') + ']';
		gap = mind;
		return v;
	    }

// If the replacer is an array, use it to select the members to be stringified.

	    if (rep && typeof rep === 'object') {
		length = rep.length;
		for (i = 0; i < length; i += 1) {
		    k = rep[i];
		    if (typeof k === 'string') {
			v = str(k, value);
			if (v) {
			    partial.push(quote(k) + (gap ? ': ' : ':') + v);
			}
		    }
		}
	    } else {

// Otherwise, iterate through all of the keys in the object.

		for (k in value) {
		    if (Object.hasOwnProperty.call(value, k)) {
			v = str(k, value);
			if (v) {
			    partial.push(quote(k) + (gap ? ': ' : ':') + v);
			}
		    }
		}
	    }

// Join all of the member texts together, separated with commas,
// and wrap them in braces.

	    v = partial.length === 0 ? '{}' :
		gap ? '{\n' + gap + partial.join(',\n' + gap) + '\n' +
			mind + '}' : '{' + partial.join(',') + '}';
	    gap = mind;
	    return v;
	}
    }

// If the JSON object does not yet have a stringify method, give it one.

    if (typeof JSON.stringify !== 'function') {
	JSON.stringify = function (value, replacer, space) {

// The stringify method takes a value and an optional replacer, and an optional
// space parameter, and returns a JSON text. The replacer can be a function
// that can replace values, or an array of strings that will select the keys.
// A default replacer method can be provided. Use of the space parameter can
// produce text that is more easily readable.

	    var i;
	    gap = '';
	    indent = '';

// If the space parameter is a number, make an indent string containing that
// many spaces.

	    if (typeof space === 'number') {
		for (i = 0; i < space; i += 1) {
		    indent += ' ';
		}

// If the space parameter is a string, it will be used as the indent string.

	    } else if (typeof space === 'string') {
		indent = space;
	    }

// If there is a replacer, it must be a function or an array.
// Otherwise, throw an error.

	    rep = replacer;
	    if (replacer && typeof replacer !== 'function' &&
		    (typeof replacer !== 'object' ||
		     typeof replacer.length !== 'number')) {
		throw new Error('JSON.stringify');
	    }

// Make a fake root object containing our value under the key of ''.
// Return the result of stringifying the value.

	    return str('', {'': value});
	};
    }


// If the JSON object does not yet have a parse method, give it one.

    if (typeof JSON.parse !== 'function') {
	JSON.parse = function (text, reviver) {

// The parse method takes a text and an optional reviver function, and returns
// a JavaScript value if the text is a valid JSON text.

	    var j;

	    function walk(holder, key) {

// The walk method is used to recursively walk the resulting structure so
// that modifications can be made.

		var k, v, value = holder[key];
		if (value && typeof value === 'object') {
		    for (k in value) {
			if (Object.hasOwnProperty.call(value, k)) {
			    v = walk(value, k);
			    if (v !== undefined) {
				value[k] = v;
			    } else {
				delete value[k];
			    }
			}
		    }
		}
		return reviver.call(holder, key, value);
	    }


// Parsing happens in four stages. In the first stage, we replace certain
// Unicode characters with escape sequences. JavaScript handles many characters
// incorrectly, either silently deleting them, or treating them as line endings.

	    text = String(text);
	    cx.lastIndex = 0;
	    if (cx.test(text)) {
		text = text.replace(cx, function (a) {
		    return '\\u' +
			('0000' + a.charCodeAt(0).toString(16)).slice(-4);
		});
	    }

// In the second stage, we run the text against regular expressions that look
// for non-JSON patterns. We are especially concerned with '()' and 'new'
// because they can cause invocation, and '=' because it can cause mutation.
// But just to be safe, we want to reject all unexpected forms.

// We split the second stage into 4 regexp operations in order to work around
// crippling inefficiencies in IE's and Safari's regexp engines. First we
// replace the JSON backslash pairs with '@' (a non-JSON character). Second, we
// replace all simple value tokens with ']' characters. Third, we delete all
// open brackets that follow a colon or comma or that begin the text. Finally,
// we look to see that the remaining characters are only whitespace or ']' or
// ',' or ':' or '{' or '}'. If that is so, then the text is safe for eval.

	    if (/^[\],:{}\s]*$/.
test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, '@').
replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

// In the third stage we use the eval function to compile the text into a
// JavaScript structure. The '{' operator is subject to a syntactic ambiguity
// in JavaScript: it can begin a block or an object literal. We wrap the text
// in parens to eliminate the ambiguity.

		j = eval('(' + text + ')');

// In the optional fourth stage, we recursively walk the new structure, passing
// each name/value pair to a reviver function for possible transformation.

		return typeof reviver === 'function' ?
		    walk({'': j}, '') : j;
	    }

// If the text is not JSON parseable, then a SyntaxError is thrown.

	    throw new SyntaxError('JSON.parse');
	};
    }
}());

/**
 * End JSON.org JSON methods
 */





var wufooWPadmin = (function(scope) {
	var addEvent = function( obj, type, fn ) {
		if (obj.addEventListener)
			obj.addEventListener(type, fn, false);
		else if (obj.attachEvent)
			obj.attachEvent('on' + type, function() { return fn.call(obj, window.event);});
	},

	clearEl = function( el ) {
		if ( el.hasChildNodes() ) {
			while ( el.childNodes.length >= 1 ) {
				el.removeChild( el.firstChild );       
			} 
		}
	},

	d = document,

	editorText = '',
	okText = '',

	/**
	 * Get the object that was the target of an event
	 * @param object e The event object (or null for ie)
	 * @return object The target object.
	 */
	getEventTarget = function(e) {
		e = e || window.event;
		return e.target || e.srcElement;
	},

	XHR = (function() { 
		var i, 
		fs = [
		function() { // for legacy eg. IE 5 
			return new scope.ActiveXObject("Microsoft.XMLHTTP"); 
		}, 
		function() { // for fully patched Win2k SP4 and up 
			return new scope.ActiveXObject("Msxml2.XMLHTTP.3.0"); 
		}, 
		function() { // IE 6 users that have updated their msxml dll files. 
			return new scope.ActiveXObject("Msxml2.XMLHTTP.6.0"); 
		}, 
		function() { // IE7, Safari, Mozilla, Opera, etc (NOTE: IE7 native version does not support overrideMimeType or local file requests)
			return new XMLHttpRequest();
		}]; 

		// Loop through the possible factories to try and find one that
		// can instantiate an XMLHttpRequest object that works.

		for ( i = fs.length; i--; ) { 
			try { 
				if ( fs[i]() ) { 
					return fs[i]; 
				} 
			} catch (e) {} 
		}
	})(),

	/**
	 * Post a xhr request
	 * @param url The url to which to post
	 * @data The associative array of data to post, or a string of already-encoded data
	 * @callback The method to call upon success
	 */
	postReq = function(url, data, callback) {
		url = url || location.href;
		data = data || {};
		var dataString, request = new XHR;
		dataString = serialize(data);
		try {
			if ( 'undefined' == typeof callback ) {
				callback = function() {};
			}
			request.open('POST', url, true);
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			request.onreadystatechange = function() {
				if ( 4 == request.readyState ) {
					request.onreadystatechange = function() {};
					if ( 200 <= request.status && 300 > request.status || ( 'undefined' == typeof request.status ) )
						callback(request.responseText);
				}
			}
			request.send(dataString);
		} catch(e) {};
	},
	
	/** 
	 * Whether the property is of this particular object's
	 * @param obj The object whose property we're interested in.
	 * @param property The property which we're interested in.
	 * @return true if The property does not originate higher in the prototype chain.
	 */
	isObjProp = function(obj, property) {
		var p = obj.constructor.prototype[property];
		return ( 'undefined' == typeof p || property !== obj[p] );
	},

	/**
	 * Serialize an associative array
	 * @param array a The associative array to serialize.
	 * @uses urlencode, isObjProp
	 * @return string The serialized string.
	 */
	serialize = function(a) {
		var i, j, s = [];
		for( i in a ) {
			if ( isObjProp(a, i) ) {
				// if the object is an array itself
				if ( '[]' == i.substr(i.length - 2, i.length) ) {
					for ( j = 0; j < a[i].length; j++ ) {
						s[s.length] = urlencode(i) + '=' + urlencode(a[i][j]);
					}
				} else {
					s[s.length] = urlencode(i) + '=' + urlencode(a[i]);
				}
			}
		}
		return s.join('&');
	},

	urlencode = (function() {
		var f = function(s) {
			return encodeURIComponent(s).replace(/%20/,'+').replace(/(.{0,3})(%0A)/g,
				function(m, a, b) {return a+(a=='%0D'?'':'%0D')+b;}).replace(/(%0D)(.{0,3})/g,
				function(m, a, b) {return a+(b=='%0A'?'':'%0A')+b;});
		};

		if (typeof encodeURIComponent != 'undefined' && String.prototype.replace && f('\n \r') == '%0D%0A+%0D%0A') {
			return f;
		}
	})(),


	/**
	 * Animation methods
	 */
	lerp = function(start, end, value) {
		return ( ( 1 - value ) * start ) + ( value * end );
	},

	hermite = function(start, end, value) {
		var i = lerp(start, end, value * value * ( 3 - 2 * value ));
		return i;
	},

	Animation = function(diff, callback) { 
		return {
			animate:function() {
				if ( this.inProgress )
					return;
				this.inProgress = true;
					
				callback = callback || function() {};

				var rate = 20,
				time = 500,
				steps = time / rate,
				i,
				last = false,
				state,
				that = this;
				

				for ( i = 0; i < steps; i++ ) {
					last = ( i + 1 ) < steps ? false : true;
					state = 0 < diff ? hermite(0, 1, (i / steps)) * diff : hermite(1, 0, (i / steps)) * diff;
					(function(cb) {
						var k = i,
						l = last,
						curDiff = state;
						setTimeout(function() {
							if ( l )
								that.inProgress = false;
							cb.apply(that, [curDiff, l]);
						}, k * rate);
					})(callback);
				}
			}
		}
	},

	fade = function(obj, dir, callback) {
		if ( ! obj )
			return;
		dir = dir || -1;
		callback = callback || function(){};
		if ( -1 === dir ) {
			obj.style.opacity = 1;
			obj.style.filter = 'alpha(opacity=100)';
		} else if ( 1 === dir ) {
			obj.style.opacity = 0;
			obj.style.filter = 'alpha(opacity=0)';
			obj.style.display = 'block';	
		}


		var fadeCallback = function(curDiff, isLast) {
			var o = 100 + curDiff * dir;
			obj.style.opacity = o / 100;
			obj.style.filter = 'alpha(opacity=' + o + ')';
			if ( isLast ) {
				callback.call(obj);
				if ( -1 === dir )
					obj.style.display = 'none';
				else	
					obj.style.display = 'block';
			}
		},
		animator;

		if ( obj ) {
			if ( -1 === dir ) {
				animator = new Animation(100, fadeCallback),
				animator.animate();
			} else {
				animator = new Animation(-100, fadeCallback);
				animator.animate();
			}
		}
	},

	/**
	 * End animation
	 */



	/**
	 * JSON methods
	 */

	apiEndpoint = 'admin-ajax.php?action=wufoo-integration-json',

	getUniqID = function() {
		var d = new Date(),
		utc = d.getTime(),
		id = Math.ceil( utc * Math.random() / 1000 );
		return id;
	},

	actOnResponse = function( JSONResp ) {
		var JSONobj,
		result = [];

		try {
			JSONobj = JSON.parse( JSONResp );
		} catch(e) {
			_showErrorMessage('The server made an invalid response.'); 
		}

		if ( JSONobj && JSONobj.id ) {
			if ( callbacks[ JSONobj.id ] ) {
				
				if ( JSONobj.error ) {
				/*
			//		error = [ JSONobj.error.code, JSONobj.error.message ];
			//	
					if ( JSONobj.error.data )
						 JSONobj.error.data;
					//	error[2] = JSONobj.error.data;
					*/

					if ( callbacks[ JSONobj.id ][1] )
						callbacks[ JSONobj.id ][1].call( scope, JSONobj.error );
				} else if ( 'undefined' != typeof JSONobj.result ) {
					result = [ JSONobj.result ];
					if ( callbacks[ JSONobj.id ][0] )
						callbacks[ JSONobj.id ][0].apply( scope, result );
				}

				delete callbacks[ JSONobj.id ];
			}
		} else {
			_showErrorMessage('The server made an invalid response.'); 
		}
	},

	_showErrorMessage = function() {},

	callbacks = {},
	
	makeRequest = function( method, params, successCallback, failureCallback ) {
		var id = getUniqID(),
		JSONstring = '',
		paramsString = JSON.stringify( params );

		if ( '' == method )
			return;
		params = params || {};

		callbacks[id] = [successCallback, failureCallback];

		JSONstring = '{"jsonrpc":"2.0","method":"' + method + '","params":' + paramsString + ',"id":' + id + '}';
		postReq(apiEndpoint, {'json-rpc-request':JSONstring}, actOnResponse );
	},

	/**
	 * End JSON methods
	 */

	/**
	 * Dialog methods
	 */
	Dialog = (function(scope) {
		var closeText = 'Close', 
		container = d.createElement('div'),
		wrap = d.createElement('div'),
		header = d.createElement('div'),
		closeLink = d.createElement('a'),
		body = d.createElement('form'),
		mainSection = d.createElement('div'),
		controls = d.createElement('div'),
		dataToSave = [
			'wufoo-integration-account',
			'wufoo-integration-api',
			'wufoo-integration-nonce'
		],

		showing = false,

		top = 0,
		previousTop = 0,
		left = 0,
		previousLeft = 0,

		mouseDown = false,

		attachInputListeners = function() {
			var accountField = d.getElementById('wufoo-integration-account');

			if ( accountField ) {
				addEvent( accountField, 'blur', eventBlur );
			}
		},

		warnAboutEmail = function() {
			var incorrectMsg = d.getElementById('wufoo-email-incorrect');

			if ( this && this.id && 'wufoo-integration-account' == this.id ) {
				// if it looks like someone is entering an email address:
				if ( this.value && -1 !== this.value.indexOf('@') && incorrectMsg ) {
					incorrectMsg.style.display = 'none';
					incorrectMsg.className = incorrectMsg.className.replace(/wufoo-email-incorrect-inactive/, '')
					fade( incorrectMsg, 1 );
					this.className = this.className + ' wufoo-integration-input-highlighted';
					return false;
				} else {
					incorrectMsg.style.display = 'none';
					this.className = this.className.replace(/wufoo-integration-input-highlighted/g, '');
				}
			}

			return true;
		},

		eventBlur = function(e) {
			if ( ! e )
				e = window.event;

			warnAboutEmail.call( this ); 
		},

		eventClick = function(e) {
			if ( ! e )
				e = window.event;

			var accountField = d.getElementById('wufoo-integration-account'),
			target = getEventTarget(e),
			identified = false;

			if ( target && target.className && 
				( 
					/\bclose-link\b/.exec( target.className ) ||
					/\bcancel\b/.exec( target.className ) ||
					/\bok\b/.exec( target.className )
				)
			) {
				identified = true;
				hide();
			} else if ( target && target.className && /\bsave-data\b/.exec( target.className ) ) {
				identified = true;
				if ( warnAboutEmail.call( accountField ) )
					saveData();
			} else if ( target && target.className && /\bedit-data\b/.exec( target.className ) ) {
				identified = true;
				makeRequest( 'wufoointegration.getAPIForm', {}, handleWufooResult, handleWufooError );
			} else if ( target && target.className && /\binsert-form\b/.exec( target.className ) ) {
				identified = true;
				insertSelectedForm();
			} else if ( target && target.className && /\bretreive-forms\b/.exec( target.className ) ) {
				identified = true;
				makeRequest( 'wufoointegration.getFormsList', {}, handleWufooResult, handleWufooError );
			}

			if ( identified ) {
				if ( e.preventDefault )
					e.preventDefault();

				if ( e.stopPropagation )
					e.stopPropagation();

				e.returnValue = false;
				e.cancelBubble = true;

				return false;
			}
		},
		
		eventKeyDown = function(e) {
			if ( ! e )
				e = window.event;
			var target = getEventTarget(e);
			
			// carriage return
			if ( e.keyCode && 13 == e.keyCode ) {
				if ( warnAboutEmail.call( target ) )
					saveData();
				
				if ( e.preventDefault )
					e.preventDefault();

				if ( e.stopPropagation )
					e.stopPropagation();

				e.returnValue = false;
				e.cancelBubble = true;

				return false;
			}
		},

		eventMouseDown = function(e) {
			if ( ! e )
				e = window.event;
			mouseDown = true;

			previousLeft = e.clientX;
			previousTop = e.clientY;
		},

		eventMouseMove = function(e) {
			if ( mouseDown ) {
				if ( ! e )
					e = window.event;

				left += parseInt( e.clientX - previousLeft, 10 );
				top += parseInt( e.clientY - previousTop, 10 );

				wrap.style.left = left + 'px';
				wrap.style.top = top + 'px';

				previousLeft = e.clientX;
				previousTop = e.clientY;

				if ( e.preventDefault )
					e.preventDefault();

				if ( e.stopPropagation )
					e.stopPropagation();

				e.returnValue = false;
				e.cancelBubble = true;

				return false;
			}
		}

		eventMouseUp = function(e) {
			mouseDown = false;
		},

		eventSubmit = function(e) {
			var accountField = d.getElementById('wufoo-integration-account');

			if ( warnAboutEmail.call( accountField ) )
				saveData();

			if ( e.preventDefault )
				e.preventDefault();

			if ( e.stopPropagation )
				e.stopPropagation();

			e.returnValue = false;
			e.cancelBubble = true;

			return false;
		},

		/**
		 * Look for fields of data to save and save if present.
		 */
		saveData = function() {
			var i = dataToSave.length,
			data = {};
			while( i-- ) {
				if ( body.elements && body.elements[ dataToSave[ i ] ] ) {
					data[ dataToSave[ i ] ] = body.elements[ dataToSave[ i ] ].value;
				}
			}
		
			indicateProcessing();
			makeRequest( 'wufoointegration.saveData', {"data":data}, handleWufooResult, handleWufooError );
		},
		
		insertSelectedForm = function() {
			// var value = control.options[control.selectedIndex].value;
			var formList = body.elements && body.elements['wufoo-integration-form-list'] ? 
				body.elements['wufoo-integration-form-list'] : null,
			hash = '',
			simple = d.getElementById('wufoo-integration-insert-simple'),
			advanced = d.getElementById('wufoo-integration-insert-advanced'),
			type = '';


			if ( formList.options[ formList.selectedIndex ] ) {
				hash = formList.options[ formList.selectedIndex ].value; 
			} else {
				hash = formList.value;
			}

			type = simple && simple.checked ? 'simple' : 'advanced';

			if ( hash ) {
				insertCode( '[wufoo-form id="' + hash + '" type="' + type + '"]' );
				hide();
			}
		},

		indicateProcessing = function() {
			body.className = '' + body.className + ' wufoo-integration-processing';
		},

		cancelProcessing = function() {
			body.className = body.className.replace(/wufoo-integration-processing/g, '');
		},

		show = function( callback ) {
			if ( true === showing )
				return;
			showing = true;
			fade( container, 1, function() {
				if ( callback )
					callback();
			});
		},

		hide = function( callback ) {
			if ( false === showing )
				return;
			showing = false;
			fade( container, -1, function() {
				if ( callback )
					callback();
			});
		},

		setButtons = function( buttons ) {
			if ( ! buttons ) {
				buttons = [];
			}

			var button,
			i, 
			j = controls.hasChildNodes() ? controls.childNodes.length : 0;

			while( j-- ) {
				fade( controls.childNodes[ j ], -1, function() {
					if ( this.parentNode )
						this.parentNode.removeChild( this );
				});
			}

			for( i = 0; i < buttons.length; i++ ) {
				button = d.createElement('button');
				button.className = buttons[i]['class'] ? buttons[i]['class'] : '';
				button.innerHTML = buttons[i].value ? buttons[i].value : '';
				button.style.display = 'none';
				controls.appendChild( button );
				fade( button, 1 );
			}
		},

		setMarkup = function( m ) {
			var i = mainSection.hasChildNodes() ? mainSection.childNodes.length : 0,
			newChild = d.createElement('div');
			newChild.className = 'content-wrap';
			newChild.innerHTML = m;
			newChild.style.display = 'none';
			
			cancelProcessing();

			while ( i-- ) {
				fade( mainSection.childNodes[ i ], -1 , function() {
					if ( this.parentNode )
						this.parentNode.removeChild( this );
				});
			}

			mainSection.appendChild( newChild );

			fade( newChild, 1 );	

			attachInputListeners();
		};

		addEvent( wrap, 'click', eventClick );
		addEvent( wrap, 'keydown', eventKeyDown );
		addEvent( header, 'mousedown', eventMouseDown );
		addEvent( d, 'mousemove', eventMouseMove );
		addEvent( d, 'mouseup', eventMouseUp );
		addEvent( body, 'submit', eventSubmit );

		return {
			build:function() {
				var root = d.getElementsByTagName('body');

				container.className = 'wufoo-integration-popup-container';
				wrap.className = 'wufoo-integration-popup-wrap';
				wrap.id = 'wufoo-integration-popup-wrap';
				header.className = 'popup-header';
				closeLink.className = 'close-link';
				closeLink.appendChild( d.createTextNode( closeText ) );
				header.appendChild( closeLink );
				wrap.appendChild( header );

				body.className = 'popup-body';
				body.method = 'post';
				body.setAttribute('action', '');
				mainSection.className = 'main-section';
				controls.className = 'controls';
				body.appendChild( mainSection );
				body.appendChild( controls );
				wrap.appendChild( body );

				container.className = 'wufoo-integration-popup-container';
				container.appendChild( wrap );

				if ( root[0] ) {
					container.style.display = 'none';
					hide();
					root[0].appendChild( container );
				}
			},

			hide:hide,
			show:show,
			
			setCloseText:function( t ) {
				closeText = t;
			},
			
			clear:function() {
				clearEl( mainSection );
			},

			setButtons:setButtons,
			setMarkup:setMarkup,

			setText:function( t ) {
				clearEl( mainSection );
				mainSection.appendChild( d.createTextNode( t ) );
			}
		}

	})(scope),

	/**
	 * Insert the shortcode into the post
	 */
	insertCode = function(code) {
		try {
			tinyMCE.execCommand('mceInsertContent', false, code);
		} catch(e) {}
		try {
			edInsertContent(edCanvas, code);
		} catch(e) {}
	},

	clickOpenDialogButton = function(e) {
		// Dialog.clear();
		Dialog.show();
		makeRequest( 'wufoointegration.getDialog', {}, handleWufooResult, handleWufooError );
	},

	eventClickDialogButton = function(e) {
		clickOpenDialogButton();		

		if ( e.stopPropagation )
			e.stopPropagation();
		if ( e.preventDefault )
			e.preventDefault();

		e.cancelBubble = true;
		e.returnValue = false;
		return false;
	},

	handleWufooResult = function( result ) {
		if ( result.message ) {
			Dialog.setMarkup( result.message );
		}

		if ( result.buttons ) {
			Dialog.setButtons( result.buttons );
		}
	},

	handleWufooError = function( error ) {
		Dialog.setMarkup( error.message );
		if ( error.data && error.data.buttons )
			Dialog.setButtons( error.data.buttons );
		else
			Dialog.setButtons( [ {'class':'ok', 'value':okText} ] );
		Dialog.show();
	},

	/**
	 * End dialog methods
	 */

	setupEditorButtons = function() {
		var button = d.createElement('button'),
		editorWrap = d.getElementById('ed_toolbar');

		if ( editorWrap ) {
			// button.type = 'button';
			button.className = 'ed_button';
			button.id = 'ed_wufoo_dialog';
			button.appendChild( d.createTextNode( editorText ) );
			addEvent(button, 'click', eventClickDialogButton);

			editorWrap.appendChild( button );
		}

	},

	initialized = false,
	init = function() {
		if ( initialized ) {
			return false;
		}
		initialized = true;

		setupEditorButtons();

		Dialog.build();
	
		_showErrorMessage = function( m ) {
			var error = {
				code:0,
				message:m
			}

			return handleWufooError( error );
		}
	}

	return {
		clickOpenDialogButton:clickOpenDialogButton,

		setCloseLinkText:Dialog.setCloseText,

		setEditorButtonText:function(t) {
			editorText = t;
		},

		setOKText:function(t) {
			okText = t;
		},

		setupInit: function() {
			addEvent(d, 'DOMContentLoaded', init);
			addEvent(window, 'load', init);
		}
	}
	
})(this);
