(function () {
    window.extole = window.extole || {};
    var n = {}, x = extole.env = "pr",
        sa = {
            lo: {
                MEDIA_SERVER: "//media-lo.extole.com",
                ALT_MEDIA_SERVER: "//tags-lo.extole.com",
                HTML_ASSEMBLER_ROOT: "//template-assembler-lo.app.extole.com:8096"
            },
            nt: {
                MEDIA_SERVER: "//media-nt.extole.com",
                ALT_MEDIA_SERVER: "//tags-nt.extole.com",
                HTML_ASSEMBLER_ROOT: "//template-assembler-nt.extole.com"
            },
            qa: {
                MEDIA_SERVER: "//media-qa.extole.com",
                ALT_MEDIA_SERVER: "//tags-qa.extole.com",
                HTML_ASSEMBLER_ROOT: "//template-assembler-qa.extole.com"
            },
            pr: {
                MEDIA_SERVER: "//media.extole.com",
                ALT_MEDIA_SERVER: "//tags.extole.com",
                HTML_ASSEMBLER_ROOT: "//template-assembler.extole.com"
            }
        }, ma = sa[x].MEDIA_SERVER,
        xa = sa[x].HTML_ASSEMBLER_ROOT;
    extole.DEBUG_MODE = void 0 !== extole.DEBUG_MODE ? extole.DEBUG_MODE : !0;
    DEBUG_MODE = extole.DEBUG_MODE = false;;
    void 0 === extole.suppressLog && (extole.suppressLog = !1 === extole.DEBUG_MODE && "pr" == extole.env);
    (function (h) {
        h = h || {};
        (function (b, a) {
            function c(l) {
                var a = Ja[l] = {};
                return g.each(l.split(ha), function (l, b) {
                    a[b] = !0
                }), a
            }

            function e(l,
                K, b) {
                if (b === a && 1 === l.nodeType)
                    if (b = "data-" + K.replace(ja, "-$1").toLowerCase(), b = l.getAttribute(b), "string" == typeof b) {
                        try {
                            b = "true" === b ? !0 : "false" === b ? !1 : "null" === b ? null : +b + "" === b ? +b : ka.test(b) ? g.parseJSON(b) : b
                        } catch (c) {}
                        g.data(l, K, b)
                    } else b = a;
                return b
            }

            function f(l) {
                for (var a in l)
                    if (("data" !== a || !g.isEmptyObject(l[a])) && "toJSON" !== a) return !1;
                return !0
            }

            function h() {
                return !1
            }

            function m() {
                return !0
            }

            function r(l) {
                return !l || !l.parentNode || 11 === l.parentNode.nodeType
            }

            function u(l, a) {
                do l = l[a]; while (l && 1 !==
                    l.nodeType);
                return l
            }

            function D(l, a, b) {
                a = a || 0;
                if (g.isFunction(a)) return g.grep(l, function (l, c) {
                    return !!a.call(l, c, l) === b
                });
                if (a.nodeType) return g.grep(l, function (l, c) {
                    return l === a === b
                });
                if ("string" == typeof a) {
                    var c = g.grep(l, function (l) {
                        return 1 === l.nodeType
                    });
                    if (Db.test(a)) return g.filter(a, c, !b);
                    a = g.filter(a, c)
                }
                return g.grep(l, function (l, c) {
                    return 0 <= g.inArray(l, a) === b
                })
            }

            function n(l) {
                var a = sa.split("|");
                l = l.createDocumentFragment();
                if (l.createElement)
                    for (; a.length;) l.createElement(a.pop());
                return l
            }

            function s(l, a) {
                if (1 === a.nodeType && g.hasData(l)) {
                    var b, c, d;
                    c = g._data(l);
                    var e = g._data(a, c),
                        f = c.events;
                    if (f)
                        for (b in delete e.handle, e.events = {}, f)
                            for (c = 0, d = f[b].length; c < d; c++) g.event.add(a, b, f[b][c]);
                    e.data && (e.data = g.extend({}, e.data))
                }
            }

            function q(l, a) {
                var b;
                1 === a.nodeType && (a.clearAttributes && a.clearAttributes(), a.mergeAttributes && a.mergeAttributes(l), b = a.nodeName.toLowerCase(), "object" === b ? (a.parentNode && (a.outerHTML = l.outerHTML), g.support.html5Clone && l.innerHTML && !g.trim(a.innerHTML) && (a.innerHTML =
                    l.innerHTML)) : "input" === b && hb.test(l.type) ? (a.defaultChecked = a.checked = l.checked, a.value !== l.value && (a.value = l.value)) : "option" === b ? a.selected = l.defaultSelected : "input" === b || "textarea" === b ? a.defaultValue = l.defaultValue : "script" === b && a.text !== l.text && (a.text = l.text), a.removeAttribute(g.expando))
            }

            function y(l) {
                return "undefined" != typeof l.getElementsByTagName ? l.getElementsByTagName("*") : "undefined" != typeof l.querySelectorAll ? l.querySelectorAll("*") : []
            }

            function A(l) {
                hb.test(l.type) && (l.defaultChecked =
                    l.checked)
            }

            function E(l, a) {
                if (a in l) return a;
                for (var b = a.charAt(0).toUpperCase() + a.slice(1), c = a, g = ib.length; g--;)
                    if (a = ib[g] + b, a in l) return a;
                return c
            }

            function V(l, a) {
                return l = a || l, "none" === g.css(l, "display") || !g.contains(l.ownerDocument, l)
            }

            function F(l, a) {
                for (var b, c, d = [], e = 0, f = l.length; e < f; e++) b = l[e], b.style && (d[e] = g._data(b, "olddisplay"), a ? (!d[e] && "none" === b.style.display && (b.style.display = ""), "" === b.style.display && V(b) && (d[e] = g._data(b, "olddisplay", t(b.nodeName)))) : (c = da(b, "display"), !d[e] &&
                    "none" !== c && g._data(b, "olddisplay", c)));
                for (e = 0; e < f; e++) b = l[e], !b.style || a && "none" !== b.style.display && "" !== b.style.display || (b.style.display = a ? d[e] || "" : "none");
                return l
            }

            function x(l, a, b) {
                return (l = Eb.exec(a)) ? Math.max(0, l[1] - (b || 0)) + (l[2] || "px") : a
            }

            function B(l, a, b, c) {
                a = b === (c ? "border" : "content") ? 4 : "width" === a ? 1 : 0;
                for (var d = 0; 4 > a; a += 2) "margin" === b && (d += g.css(l, b + ta[a], !0)), c ? ("content" === b && (d -= parseFloat(da(l, "padding" + ta[a])) || 0), "margin" !== b && (d -= parseFloat(da(l, "border" + ta[a] + "Width")) || 0)) : (d +=
                    parseFloat(da(l, "padding" + ta[a])) || 0, "padding" !== b && (d += parseFloat(da(l, "border" + ta[a] + "Width")) || 0));
                return d
            }

            function C(l, a, b) {
                var c = "width" === a ? l.offsetWidth : l.offsetHeight,
                    d = !0,
                    e = g.support.boxSizing && "border-box" === g.css(l, "boxSizing");
                if (0 >= c || null == c) {
                    c = da(l, a);
                    if (0 > c || null == c) c = l.style[a];
                    if (Ka.test(c)) return c;
                    d = e && (g.support.boxSizingReliable || c === l.style[a]);
                    c = parseFloat(c) || 0
                }
                return c + B(l, a, b || (e ? "border" : "content"), d) + "px"
            }

            function t(l) {
                if (Ua[l]) return Ua[l];
                var a = g("<" + l + ">").appendTo(z.body),
                    b = a.css("display");
                a.remove();
                if ("none" === b || "" === b) ya = z.body.appendChild(ya || g.extend(z.createElement("iframe"), {
                    frameBorder: 0,
                    width: 0,
                    height: 0
                })), za && ya.createElement || (za = (ya.contentWindow || ya.contentDocument).document, za.write("<!doctype html><html><body>"), za.close()), a = za.body.appendChild(za.createElement(l)), b = da(a, "display"), z.body.removeChild(ya);
                return Ua[l] = b, b
            }

            function I(l, a, b, c) {
                var d;
                if (g.isArray(a)) g.each(a, function (a, K) {
                    b || Fb.test(l) ? c(l, K) : I(l + "[" + ("object" == typeof K ? a : "") + "]", K,
                        b, c)
                });
                else if (b || "object" !== g.type(a)) c(l, a);
                else
                    for (d in a) I(l + "[" + d + "]", a[d], b, c)
            }

            function L(l) {
                return function (a, b) {
                    "string" != typeof a && (b = a, a = "*");
                    var c, d, e = a.toLowerCase().split(ha),
                        f = 0,
                        w = e.length;
                    if (g.isFunction(b))
                        for (; f < w; f++) c = e[f], (d = /^\+/.test(c)) && (c = c.substr(1) || "*"), c = l[c] = l[c] || [], c[d ? "unshift" : "push"](b)
                }
            }

            function P(l, b, c, g, d, e) {
                d = d || b.dataTypes[0];
                e = e || {};
                e[d] = !0;
                var f;
                d = l[d];
                for (var w = 0, p = d ? d.length : 0, h = l === Va; w < p && (h || !f); w++) f = d[w](b, c, g), "string" == typeof f && (!h || e[f] ? f = a : (b.dataTypes.unshift(f),
                    f = P(l, b, c, g, f, e)));
                return (h || !f) && !e["*"] && (f = P(l, b, c, g, "*", e)), f
            }

            function Z(l, b) {
                var c, d, e = g.ajaxSettings.flatOptions || {};
                for (c in b) b[c] !== a && ((e[c] ? l : d || (d = {}))[c] = b[c]);
                d && g.extend(!0, l, d)
            }

            function O() {
                try {
                    return new b.XMLHttpRequest
                } catch (l) {}
            }

            function S() {
                return setTimeout(function () {
                    Aa = a
                }, 0), Aa = g.now()
            }

            function w(l, a) {
                g.each(a, function (a, b) {
                    for (var c = (Fa[a] || []).concat(Fa["*"]), K = 0, g = c.length; K < g && !c[K].call(l, a, b); K++);
                })
            }

            function G(l, a, b) {
                var c = 0,
                    d = La.length,
                    e = g.Deferred().always(function () {
                        delete f.elem
                    }),
                    f = function () {
                        for (var a = Aa || S(), a = Math.max(0, p.startTime + p.duration - a), b = 1 - (a / p.duration || 0), c = 0, K = p.tweens.length; c < K; c++) p.tweens[c].run(b);
                        return e.notifyWith(l, [p, b, a]), 1 > b && K ? a : (e.resolveWith(l, [p]), !1)
                    }, p = e.promise({
                        elem: l,
                        props: g.extend({}, a),
                        opts: g.extend(!0, {
                            specialEasing: {}
                        }, b),
                        originalProperties: a,
                        originalOptions: b,
                        startTime: Aa || S(),
                        duration: b.duration,
                        tweens: [],
                        createTween: function (a, b, c) {
                            a = g.Tween(l, p.opts, a, b, p.opts.specialEasing[a] || p.opts.easing);
                            return p.tweens.push(a), a
                        },
                        stop: function (a) {
                            for (var b =
                                0, c = a ? p.tweens.length : 0; b < c; b++) p.tweens[b].run(1);
                            return a ? e.resolveWith(l, [p, a]) : e.rejectWith(l, [p, a]), this
                        }
                    });
                b = p.props;
                for (Q(b, p.opts.specialEasing); c < d; c++)
                    if (a = La[c].call(p, l, b, p.opts)) return a;
                return w(p, b), g.isFunction(p.opts.start) && p.opts.start.call(l, p), g.fx.timer(g.extend(f, {
                    anim: p,
                    queue: p.opts.queue,
                    elem: l
                })), p.progress(p.opts.progress).done(p.opts.done, p.opts.complete).fail(p.opts.fail).always(p.opts.always)
            }

            function Q(l, a) {
                var b, c, d, e, f;
                for (b in l)
                    if (c = g.camelCase(b), d = a[c], e = l[b],
                        g.isArray(e) && (d = e[1], e = l[b] = e[0]), b !== c && (l[c] = e, delete l[b]), (f = g.cssHooks[c]) && "expand" in f)
                        for (b in e = f.expand(e), delete l[c], e) b in l || (l[b] = e[b], a[b] = d);
                    else a[c] = d
            }

            function H(l, a, b, c, d) {
                return new H.prototype.init(l, a, b, c, d)
            }

            function J(l, a) {
                var b, c = {
                        height: l
                    }, d = 0;
                for (a = a ? 1 : 0; 4 > d; d += 2 - a) b = ta[d], c["margin" + b] = c["padding" + b] = l;
                return a && (c.opacity = c.width = l), c
            }

            function ba(l) {
                return g.isWindow(l) ? l : 9 === l.nodeType ? l.defaultView || l.parentWindow : !1
            }
            var qa, p, z = b.document,
                M = b.location,
                N = b.navigator,
                ra = b.jQuery,
                na = b.$,
                oa = Array.prototype.push,
                aa = Array.prototype.slice,
                jb = Array.prototype.indexOf,
                Gb = Object.prototype.toString,
                ga = Object.prototype.hasOwnProperty,
                R = String.prototype.trim,
                g = function (l, a) {
                    return new g.fn.init(l, a, qa)
                }, ua = /[\-+]?(?:\d*\.|)\d+(?:[eE][\-+]?\d+|)/.source,
                ma = /\S/,
                ha = /\s+/,
                Ba = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,
                Wa = /^(?:[^#<]*(<[\w\W]+>)[^>]*$|#([\w\-]*)$)/,
                Ma = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,
                Ga = /^[\],:{}\s]*$/,
                Xa = /(?:^|:|,)(?:\s*\[)+/g,
                Ya = /\\(?:["\\\/bfnrt]|u[\da-fA-F]{4})/g,
                Za =
                    /"[^"\\\r\n]*"|true|false|null|-?(?:\d\d*\.|)\d+(?:[eE][\-+]?\d+|)/g,
                Ca = /^-ms-/,
                Ha = /-([\da-z])/gi,
                $a = function (l, a) {
                    return (a + "").toUpperCase()
                }, Da = function () {
                    z.addEventListener ? (z.removeEventListener("DOMContentLoaded", Da, !1), g.ready()) : "complete" === z.readyState && (z.detachEvent("onreadystatechange", Da), g.ready())
                }, Na = {};
            g.fn = g.prototype = {
                constructor: g,
                init: function (l, b, c) {
                    var d, e;
                    if (!l) return this;
                    if (l.nodeType) return this.context = this[0] = l, this.length = 1, this;
                    if ("string" == typeof l) {
                        "<" === l.charAt(0) &&
                            ">" === l.charAt(l.length - 1) && 3 <= l.length ? d = [null, l, null] : d = Wa.exec(l);
                        if (d && (d[1] || !b)) {
                            if (d[1]) return b = b instanceof g ? b[0] : b, e = b && b.nodeType ? b.ownerDocument || b : z, l = g.parseHTML(d[1], e, !0), Ma.test(d[1]) && g.isPlainObject(b) && this.attr.call(l, b, !0), g.merge(this, l);
                            if ((b = z.getElementById(d[2])) && b.parentNode) {
                                if (b.id !== d[2]) return c.find(l);
                                this.length = 1;
                                this[0] = b
                            }
                            return this.context = z, this.selector = l, this
                        }
                        return !b || b.jquery ? (b || c).find(l) : this.constructor(b).find(l)
                    }
                    return g.isFunction(l) ? c.ready(l) :
                        (l.selector !== a && (this.selector = l.selector, this.context = l.context), g.makeArray(l, this))
                },
                selector: "",
                jquery: "1.8.3",
                length: 0,
                size: function () {
                    return this.length
                },
                toArray: function () {
                    return aa.call(this)
                },
                get: function (l) {
                    return null == l ? this.toArray() : 0 > l ? this[this.length + l] : this[l]
                },
                pushStack: function (l, a, b) {
                    l = g.merge(this.constructor(), l);
                    return l.prevObject = this, l.context = this.context, "find" === a ? l.selector = this.selector + (this.selector ? " " : "") + b : a && (l.selector = this.selector + "." + a + "(" + b + ")"), l
                },
                each: function (l,
                    a) {
                    return g.each(this, l, a)
                },
                ready: function (l) {
                    return g.ready.promise().done(l), this
                },
                eq: function (l) {
                    return l = +l, -1 === l ? this.slice(l) : this.slice(l, l + 1)
                },
                first: function () {
                    return this.eq(0)
                },
                last: function () {
                    return this.eq(-1)
                },
                slice: function () {
                    return this.pushStack(aa.apply(this, arguments), "slice", aa.call(arguments).join(","))
                },
                map: function (l) {
                    return this.pushStack(g.map(this, function (a, b) {
                        return l.call(a, b, a)
                    }))
                },
                end: function () {
                    return this.prevObject || this.constructor(null)
                },
                push: oa,
                sort: [].sort,
                splice: [].splice
            };
            g.fn.init.prototype = g.fn;
            g.extend = g.fn.extend = function () {
                var l, b, c, d, e, f, p = arguments[0] || {}, w = 1,
                    h = arguments.length,
                    m = !1;
                "boolean" == typeof p && (m = p, p = arguments[1] || {}, w = 2);
                "object" != typeof p && !g.isFunction(p) && (p = {});
                for (h === w && (p = this, --w); w < h; w++)
                    if (null != (l = arguments[w]))
                        for (b in l) c = p[b], d = l[b], p !== d && (m && d && (g.isPlainObject(d) || (e = g.isArray(d))) ? (e ? (e = !1, f = c && g.isArray(c) ? c : []) : f = c && g.isPlainObject(c) ? c : {}, p[b] = g.extend(m, f, d)) : d !== a && (p[b] = d));
                return p
            };
            g.extend({
                noConflict: function (l) {
                    return b.$ ===
                        g && (b.$ = na), l && b.jQuery === g && (b.jQuery = ra), g
                },
                isReady: !1,
                readyWait: 1,
                holdReady: function (l) {
                    l ? g.readyWait++ : g.ready(!0)
                },
                ready: function (l) {
                    if (!0 === l ? !--g.readyWait : !g.isReady) {
                        if (!z.body) return setTimeout(g.ready, 1);
                        g.isReady = !0;
                        !0 !== l && 0 < --g.readyWait || (p.resolveWith(z, [g]), g.fn.trigger && g(z).trigger("ready").off("ready"))
                    }
                },
                isFunction: function (l) {
                    return "function" === g.type(l)
                },
                isArray: Array.isArray || function (l) {
                    return "array" === g.type(l)
                },
                isWindow: function (l) {
                    return null != l && l == l.window
                },
                isNumeric: function (l) {
                    return !isNaN(parseFloat(l)) &&
                        isFinite(l)
                },
                type: function (l) {
                    return null == l ? String(l) : Na[Gb.call(l)] || "object"
                },
                isPlainObject: function (l) {
                    if (!l || "object" !== g.type(l) || l.nodeType || g.isWindow(l)) return !1;
                    try {
                        if (l.constructor && !ga.call(l, "constructor") && !ga.call(l.constructor.prototype, "isPrototypeOf")) return !1
                    } catch (b) {
                        return !1
                    }
                    for (var c in l);
                    return c === a || ga.call(l, c)
                },
                isEmptyObject: function (l) {
                    for (var a in l) return !1;
                    return !0
                },
                error: function (l) {
                    throw Error(l);
                },
                parseHTML: function (l, a, b) {
                    var c;
                    return l && "string" == typeof l ? ("boolean" ==
                        typeof a && (b = a, a = 0), a = a || z, (c = Ma.exec(l)) ? [a.createElement(c[1])] : (c = g.buildFragment([l], a, b ? null : []), g.merge([], (c.cacheable ? g.clone(c.fragment) : c.fragment).childNodes))) : null
                },
                parseJSON: function (l) {
                    if (!l || "string" != typeof l) return null;
                    l = g.trim(l);
                    if (b.JSON && b.JSON.parse) return b.JSON.parse(l);
                    if (Ga.test(l.replace(Ya, "@").replace(Za, "]").replace(Xa, ""))) return (new Function("return " + l))();
                    g.error("Invalid JSON: " + l)
                },
                parseXML: function (l) {
                    var c, d;
                    if (!l || "string" != typeof l) return null;
                    try {
                        b.DOMParser ?
                            (d = new DOMParser, c = d.parseFromString(l, "text/xml")) : (c = new ActiveXObject("Microsoft.XMLDOM"), c.async = "false", c.loadXML(l))
                    } catch (e) {
                        c = a
                    }
                    return (!c || !c.documentElement || c.getElementsByTagName("parsererror").length) && g.error("Invalid XML: " + l), c
                },
                noop: function () {},
                globalEval: function (l) {
                    l && ma.test(l) && (b.execScript || function (l) {
                        b.eval.call(b, l)
                    })(l)
                },
                camelCase: function (l) {
                    return l.replace(Ca, "ms-").replace(Ha, $a)
                },
                nodeName: function (l, a) {
                    return l.nodeName && l.nodeName.toLowerCase() === a.toLowerCase()
                },
                each: function (l, b, c) {
                    var d, e = 0,
                        f = l.length,
                        p = f === a || g.isFunction(l);
                    if (c)
                        if (p)
                            for (d in l) {
                                if (!1 === b.apply(l[d], c)) break
                            } else
                                for (; e < f && !1 !== b.apply(l[e++], c););
                        else if (p)
                        for (d in l) {
                            if (!1 === b.call(l[d], d, l[d])) break
                        } else
                            for (; e < f && !1 !== b.call(l[e], e, l[e++]););
                    return l
                },
                trim: R && !R.call("\ufeff\u00a0") ? function (l) {
                    return null == l ? "" : R.call(l)
                } : function (l) {
                    return null == l ? "" : (l + "").replace(Ba, "")
                },
                makeArray: function (l, a) {
                    var b, c = a || [];
                    return null != l && (b = g.type(l), null == l.length || "string" === b || "function" ===
                        b || "regexp" === b || g.isWindow(l) ? oa.call(c, l) : g.merge(c, l)), c
                },
                inArray: function (l, a, b) {
                    var c;
                    if (a) {
                        if (jb) return jb.call(a, l, b);
                        c = a.length;
                        for (b = b ? 0 > b ? Math.max(0, c + b) : b : 0; b < c; b++)
                            if (b in a && a[b] === l) return b
                    }
                    return -1
                },
                merge: function (l, b) {
                    var c = b.length,
                        d = l.length,
                        g = 0;
                    if ("number" == typeof c)
                        for (; g < c; g++) l[d++] = b[g];
                    else
                        for (; b[g] !== a;) l[d++] = b[g++];
                    return l.length = d, l
                },
                grep: function (l, a, b) {
                    var c, d = [],
                        g = 0,
                        e = l.length;
                    for (b = !! b; g < e; g++) c = !! a(l[g], g), b !== c && d.push(l[g]);
                    return d
                },
                map: function (l, b, c) {
                    var d,
                        e, f = [],
                        p = 0,
                        w = l.length;
                    if (l instanceof g || w !== a && "number" == typeof w && (0 < w && l[0] && l[w - 1] || 0 === w || g.isArray(l)))
                        for (; p < w; p++) d = b(l[p], p, c), null != d && (f[f.length] = d);
                    else
                        for (e in l) d = b(l[e], e, c), null != d && (f[f.length] = d);
                    return f.concat.apply([], f)
                },
                guid: 1,
                proxy: function (l, b) {
                    var c, d, e;
                    return "string" == typeof b && (c = l[b], b = l, l = c), g.isFunction(l) ? (d = aa.call(arguments, 2), e = function () {
                        return l.apply(b, d.concat(aa.call(arguments)))
                    }, e.guid = l.guid = l.guid || g.guid++, e) : a
                },
                access: function (l, b, c, d, e, f, p) {
                    var w, h =
                            null == c,
                        m = 0,
                        u = l.length;
                    if (c && "object" == typeof c) {
                        for (m in c) g.access(l, b, m, c[m], 1, f, d);
                        e = 1
                    } else if (d !== a) {
                        w = p === a && g.isFunction(d);
                        h && (w ? (w = b, b = function (l, a, b) {
                            return w.call(g(l), b)
                        }) : (b.call(l, d), b = null));
                        if (b)
                            for (; m < u; m++) b(l[m], c, w ? d.call(l[m], m, b(l[m], c)) : d, p);
                        e = 1
                    }
                    return e ? l : h ? b.call(l) : u ? b(l[0], c) : f
                },
                now: function () {
                    return (new Date).getTime()
                }
            });
            g.ready.promise = function (l) {
                if (!p)
                    if (p = g.Deferred(), "complete" === z.readyState) setTimeout(g.ready, 1);
                    else if (z.addEventListener) z.addEventListener("DOMContentLoaded",
                    Da, !1), b.addEventListener("load", g.ready, !1);
                else {
                    z.attachEvent("onreadystatechange", Da);
                    b.attachEvent("onload", g.ready);
                    var a = !1;
                    try {
                        a = null == b.frameElement && z.documentElement
                    } catch (c) {}
                    a && a.doScroll && function Cb() {
                        if (!g.isReady) {
                            try {
                                a.doScroll("left")
                            } catch (l) {
                                return setTimeout(Cb, 50)
                            }
                            g.ready()
                        }
                    }()
                }
                return p.promise(l)
            };
            g.each("Boolean Number String Function Array Date RegExp Object".split(" "), function (l, a) {
                Na["[object " + a + "]"] = a.toLowerCase()
            });
            qa = g(z);
            var Ja = {};
            g.Callbacks = function (l) {
                l = "string" ==
                    typeof l ? Ja[l] || c(l) : g.extend({}, l);
                var b, e, f, p, w, h, m = [],
                    u = !l.once && [],
                    r = function (a) {
                        b = l.memory && a;
                        e = !0;
                        h = p || 0;
                        p = 0;
                        w = m.length;
                        for (f = !0; m && h < w; h++)
                            if (!1 === m[h].apply(a[0], a[1]) && l.stopOnFalse) {
                                b = !1;
                                break
                            }
                        f = !1;
                        m && (u ? u.length && r(u.shift()) : b ? m = [] : z.disable())
                    }, z = {
                        add: function () {
                            if (m) {
                                var a = m.length;
                                (function Hb(a) {
                                    g.each(a, function (a, b) {
                                        var c = g.type(b);
                                        "function" === c ? (!l.unique || !z.has(b)) && m.push(b) : b && b.length && "string" !== c && Hb(b)
                                    })
                                })(arguments);
                                f ? w = m.length : b && (p = a, r(b))
                            }
                            return this
                        },
                        remove: function () {
                            return m &&
                                g.each(arguments, function (l, a) {
                                    for (var b; - 1 < (b = g.inArray(a, m, b));) m.splice(b, 1), f && (b <= w && w--, b <= h && h--)
                                }), this
                        },
                        has: function (l) {
                            return -1 < g.inArray(l, m)
                        },
                        empty: function () {
                            return m = [], this
                        },
                        disable: function () {
                            return m = u = b = a, this
                        },
                        disabled: function () {
                            return !m
                        },
                        lock: function () {
                            return u = a, b || z.disable(), this
                        },
                        locked: function () {
                            return !u
                        },
                        fireWith: function (l, a) {
                            return a = a || [], a = [l, a.slice ? a.slice() : a], m && (!e || u) && (f ? u.push(a) : r(a)), this
                        },
                        fire: function () {
                            return z.fireWith(this, arguments), this
                        },
                        fired: function () {
                            return !!e
                        }
                    };
                return z
            };
            g.extend({
                Deferred: function (l) {
                    var a = [
                        ["resolve", "done", g.Callbacks("once memory"), "resolved"],
                        ["reject", "fail", g.Callbacks("once memory"), "rejected"],
                        ["notify", "progress", g.Callbacks("memory")]
                    ],
                        b = "pending",
                        c = {
                            state: function () {
                                return b
                            },
                            always: function () {
                                return d.done(arguments).fail(arguments), this
                            },
                            then: function () {
                                var l = arguments;
                                return g.Deferred(function (b) {
                                    g.each(a, function (a, c) {
                                        var K = c[0],
                                            e = l[a];
                                        d[c[1]](g.isFunction(e) ? function () {
                                            var l = e.apply(this, arguments);
                                            l && g.isFunction(l.promise) ?
                                                l.promise().done(b.resolve).fail(b.reject).progress(b.notify) : b[K + "With"](this === d ? b : this, [l])
                                        } : b[K])
                                    });
                                    l = null
                                }).promise()
                            },
                            promise: function (l) {
                                return null != l ? g.extend(l, c) : c
                            }
                        }, d = {};
                    return c.pipe = c.then, g.each(a, function (l, g) {
                        var e = g[2],
                            f = g[3];
                        c[g[1]] = e.add;
                        f && e.add(function () {
                            b = f
                        }, a[l ^ 1][2].disable, a[2][2].lock);
                        d[g[0]] = e.fire;
                        d[g[0] + "With"] = e.fireWith
                    }), c.promise(d), l && l.call(d, d), d
                },
                when: function (l) {
                    var a = 0,
                        b = aa.call(arguments),
                        c = b.length,
                        d = 1 !== c || l && g.isFunction(l.promise) ? c : 0,
                        e = 1 === d ? l : g.Deferred(),
                        f = function (l, a, b) {
                            return function (c) {
                                a[l] = this;
                                b[l] = 1 < arguments.length ? aa.call(arguments) : c;
                                b === p ? e.notifyWith(a, b) : --d || e.resolveWith(a, b)
                            }
                        }, p, w, m;
                    if (1 < c)
                        for (p = Array(c), w = Array(c), m = Array(c); a < c; a++) b[a] && g.isFunction(b[a].promise) ? b[a].promise().done(f(a, m, b)).fail(e.reject).progress(f(a, w, p)) : --d;
                    return d || e.resolveWith(m, b), e.promise()
                }
            });
            g.support = function () {
                var l, a, c, d, e, f, p, w, m = z.createElement("div");
                m.setAttribute("className", "t");
                m.innerHTML = "\t<link/><table></table><a href='/a'>a</a><input type='checkbox'/>";
                a = m.getElementsByTagName("*");
                c = m.getElementsByTagName("a")[0];
                if (!a || !c || !a.length) return {};
                d = z.createElement("select");
                e = d.appendChild(z.createElement("option"));
                a = m.getElementsByTagName("input")[0];
                c.style.cssText = "top:1px;float:left;opacity:.5";
                l = {
                    leadingWhitespace: 3 === m.firstChild.nodeType,
                    tbody: !m.getElementsByTagName("tbody").length,
                    htmlSerialize: !! m.getElementsByTagName("link").length,
                    style: /top/.test(c.getAttribute("style")),
                    hrefNormalized: "/a" === c.getAttribute("href"),
                    opacity: /^0.5/.test(c.style.opacity),
                    cssFloat: !! c.style.cssFloat,
                    checkOn: "on" === a.value,
                    optSelected: e.selected,
                    getSetAttribute: "t" !== m.className,
                    enctype: !! z.createElement("form").enctype,
                    html5Clone: "<:nav></:nav>" !== z.createElement("nav").cloneNode(!0).outerHTML,
                    boxModel: "CSS1Compat" === z.compatMode,
                    submitBubbles: !0,
                    changeBubbles: !0,
                    focusinBubbles: !1,
                    deleteExpando: !0,
                    noCloneEvent: !0,
                    inlineBlockNeedsLayout: !1,
                    shrinkWrapBlocks: !1,
                    reliableMarginRight: !0,
                    boxSizingReliable: !0,
                    pixelPosition: !1
                };
                a.checked = !0;
                l.noCloneChecked = a.cloneNode(!0).checked;
                d.disabled = !0;
                l.optDisabled = !e.disabled;
                try {
                    delete m.test
                } catch (h) {
                    l.deleteExpando = !1
                }!m.addEventListener && m.attachEvent && m.fireEvent && (m.attachEvent("onclick", w = function () {
                    l.noCloneEvent = !1
                }), m.cloneNode(!0).fireEvent("onclick"), m.detachEvent("onclick", w));
                a = z.createElement("input");
                a.value = "t";
                a.setAttribute("type", "radio");
                l.radioValue = "t" === a.value;
                a.setAttribute("checked", "checked");
                a.setAttribute("name", "t");
                m.appendChild(a);
                c = z.createDocumentFragment();
                c.appendChild(m.lastChild);
                l.checkClone =
                    c.cloneNode(!0).cloneNode(!0).lastChild.checked;
                l.appendChecked = a.checked;
                c.removeChild(a);
                c.appendChild(m);
                if (m.attachEvent)
                    for (f in {
                        submit: !0,
                        change: !0,
                        focusin: !0
                    }) a = "on" + f, (p = a in m) || (m.setAttribute(a, "return;"), p = "function" == typeof m[a]), l[f + "Bubbles"] = p;
                return g(function () {
                    var a, c, d, g, e = z.getElementsByTagName("body")[0];
                    e && (a = z.createElement("div"), a.style.cssText = "visibility:hidden;border:0;width:0;height:0;position:static;top:0;margin-top:1px", e.insertBefore(a, e.firstChild), c = z.createElement("div"),
                        a.appendChild(c), c.innerHTML = "<table><tr><td></td><td>t</td></tr></table>", d = c.getElementsByTagName("td"), d[0].style.cssText = "padding:0;margin:0;border:0;display:none", p = 0 === d[0].offsetHeight, d[0].style.display = "", d[1].style.display = "none", l.reliableHiddenOffsets = p && 0 === d[0].offsetHeight, c.innerHTML = "", c.style.cssText = "box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding:1px;border:1px;display:block;width:4px;margin-top:1%;position:absolute;top:1%;", l.boxSizing = 4 ===
                        c.offsetWidth, l.doesNotIncludeMarginInBodyOffset = 1 !== e.offsetTop, b.getComputedStyle && (l.pixelPosition = "1%" !== (b.getComputedStyle(c, null) || {}).top, l.boxSizingReliable = "4px" === (b.getComputedStyle(c, null) || {
                            width: "4px"
                        }).width, g = z.createElement("div"), g.style.cssText = c.style.cssText = "padding:0;margin:0;border:0;display:block;overflow:hidden;", g.style.marginRight = g.style.width = "0", c.style.width = "1px", c.appendChild(g), l.reliableMarginRight = !parseFloat((b.getComputedStyle(g, null) || {}).marginRight)), "undefined" !=
                        typeof c.style.zoom && (c.innerHTML = "", c.style.cssText = "padding:0;margin:0;border:0;display:block;overflow:hidden;width:1px;padding:1px;display:inline;zoom:1", l.inlineBlockNeedsLayout = 3 === c.offsetWidth, c.style.display = "block", c.style.overflow = "visible", c.innerHTML = "<div></div>", c.firstChild.style.width = "5px", l.shrinkWrapBlocks = 3 !== c.offsetWidth, a.style.zoom = 1), e.removeChild(a))
                }), c.removeChild(m), a = c = d = e = a = c = m = null, l
            }();
            var ka = /(?:\{[\s\S]*\}|\[[\s\S]*\])$/,
                ja = /([A-Z])/g;
            g.extend({
                cache: {},
                deletedIds: [],
                uuid: 0,
                expando: "jQuery" + (g.fn.jquery + Math.random()).replace(/\D/g, ""),
                noData: {
                    embed: !0,
                    object: "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",
                    applet: !0
                },
                hasData: function (l) {
                    return l = l.nodeType ? g.cache[l[g.expando]] : l[g.expando], !! l && !f(l)
                },
                data: function (l, b, c, d) {
                    if (g.acceptData(l)) {
                        var e, f, p = g.expando,
                            m = "string" == typeof b,
                            w = l.nodeType,
                            h = w ? g.cache : l,
                            u = w ? l[p] : l[p] && p;
                        if (u && h[u] && (d || h[u].data) || !m || c !== a) {
                            u || (w ? l[p] = u = g.deletedIds.pop() || g.guid++ : u = p);
                            h[u] || (h[u] = {}, w || (h[u].toJSON = g.noop));
                            if ("object" ==
                                typeof b || "function" == typeof b) d ? h[u] = g.extend(h[u], b) : h[u].data = g.extend(h[u].data, b);
                            return e = h[u], d || (e.data || (e.data = {}), e = e.data), c !== a && (e[g.camelCase(b)] = c), m ? (f = e[b], null == f && (f = e[g.camelCase(b)])) : f = e, f
                        }
                    }
                },
                removeData: function (l, a, b) {
                    if (g.acceptData(l)) {
                        var c, d, e, p = l.nodeType,
                            w = p ? g.cache : l,
                            m = p ? l[g.expando] : g.expando;
                        if (w[m]) {
                            if (a && (c = b ? w[m] : w[m].data)) {
                                g.isArray(a) || (a in c ? a = [a] : (a = g.camelCase(a), a in c ? a = [a] : a = a.split(" ")));
                                d = 0;
                                for (e = a.length; d < e; d++) delete c[a[d]];
                                if (!(b ? f : g.isEmptyObject)(c)) return
                            }
                            if (!b &&
                                (delete w[m].data, !f(w[m]))) return;
                            p ? g.cleanData([l], !0) : g.support.deleteExpando || w != w.window ? delete w[m] : w[m] = null
                        }
                    }
                },
                _data: function (l, a, b) {
                    return g.data(l, a, b, !0)
                },
                acceptData: function (l) {
                    var a = l.nodeName && g.noData[l.nodeName.toLowerCase()];
                    return !a || !0 !== a && l.getAttribute("classid") === a
                }
            });
            g.fn.extend({
                data: function (l, b) {
                    var c, d, f, p, w, m = this[0],
                        h = 0,
                        u = null;
                    if (l === a) {
                        if (this.length && (u = g.data(m), 1 === m.nodeType && !g._data(m, "parsedAttrs"))) {
                            f = m.attributes;
                            for (w = f.length; h < w; h++) p = f[h].name, p.indexOf("data-") ||
                                (p = g.camelCase(p.substring(5)), e(m, p, u[p]));
                            g._data(m, "parsedAttrs", !0)
                        }
                        return u
                    }
                    return "object" == typeof l ? this.each(function () {
                        g.data(this, l)
                    }) : (c = l.split(".", 2), c[1] = c[1] ? "." + c[1] : "", d = c[1] + "!", g.access(this, function (b) {
                            if (b === a) return u = this.triggerHandler("getData" + d, [c[0]]), u === a && m && (u = g.data(m, l), u = e(m, l, u)), u === a && c[1] ? this.data(c[0]) : u;
                            c[1] = b;
                            this.each(function () {
                                var a = g(this);
                                a.triggerHandler("setData" + d, c);
                                g.data(this, l, b);
                                a.triggerHandler("changeData" + d, c)
                            })
                        }, null, b, 1 < arguments.length,
                        null, !1))
                },
                removeData: function (l) {
                    return this.each(function () {
                        g.removeData(this, l)
                    })
                }
            });
            g.extend({
                queue: function (l, a, b) {
                    var c;
                    if (l) return a = (a || "fx") + "queue", c = g._data(l, a), b && (!c || g.isArray(b) ? c = g._data(l, a, g.makeArray(b)) : c.push(b)), c || []
                },
                dequeue: function (l, a) {
                    a = a || "fx";
                    var b = g.queue(l, a),
                        c = b.length,
                        d = b.shift(),
                        e = g._queueHooks(l, a),
                        f = function () {
                            g.dequeue(l, a)
                        };
                    "inprogress" === d && (d = b.shift(), c--);
                    d && ("fx" === a && b.unshift("inprogress"), delete e.stop, d.call(l, f, e));
                    !c && e && e.empty.fire()
                },
                _queueHooks: function (l,
                    a) {
                    var b = a + "queueHooks";
                    return g._data(l, b) || g._data(l, b, {
                        empty: g.Callbacks("once memory").add(function () {
                            g.removeData(l, a + "queue", !0);
                            g.removeData(l, b, !0)
                        })
                    })
                }
            });
            g.fn.extend({
                queue: function (l, b) {
                    var c = 2;
                    return "string" != typeof l && (b = l, l = "fx", c--), arguments.length < c ? g.queue(this[0], l) : b === a ? this : this.each(function () {
                        var a = g.queue(this, l, b);
                        g._queueHooks(this, l);
                        "fx" === l && "inprogress" !== a[0] && g.dequeue(this, l)
                    })
                },
                dequeue: function (l) {
                    return this.each(function () {
                        g.dequeue(this, l)
                    })
                },
                delay: function (l,
                    a) {
                    return l = g.fx ? g.fx.speeds[l] || l : l, a = a || "fx", this.queue(a, function (a, b) {
                        var c = setTimeout(a, l);
                        b.stop = function () {
                            clearTimeout(c)
                        }
                    })
                },
                clearQueue: function (l) {
                    return this.queue(l || "fx", [])
                },
                promise: function (l, b) {
                    var c, d = 1,
                        e = g.Deferred(),
                        f = this,
                        p = this.length,
                        m = function () {
                            --d || e.resolveWith(f, [f])
                        };
                    "string" != typeof l && (b = l, l = a);
                    for (l = l || "fx"; p--;)(c = g._data(f[p], l + "queueHooks")) && c.empty && (d++, c.empty.add(m));
                    return m(), e.promise(b)
                }
            });
            var pa, T, W, $ = /[\t\r\n]/g,
                la = /\r/g,
                Oa = /^(?:button|input)$/i,
                ab = /^(?:button|input|object|select|textarea)$/i,
                Ia = /^a(?:rea|)$/i,
                Pa = /^(?:autofocus|autoplay|async|checked|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped|selected)$/i,
                Qa = g.support.getSetAttribute;
            g.fn.extend({
                attr: function (l, a) {
                    return g.access(this, g.attr, l, a, 1 < arguments.length)
                },
                removeAttr: function (l) {
                    return this.each(function () {
                        g.removeAttr(this, l)
                    })
                },
                prop: function (l, a) {
                    return g.access(this, g.prop, l, a, 1 < arguments.length)
                },
                removeProp: function (l) {
                    return l = g.propFix[l] || l, this.each(function () {
                        try {
                            this[l] = a, delete this[l]
                        } catch (b) {}
                    })
                },
                addClass: function (l) {
                    var a, b, c, d, e, f, p;
                    if (g.isFunction(l)) return this.each(function (a) {
                        g(this).addClass(l.call(this, a, this.className))
                    });
                    if (l && "string" == typeof l)
                        for (a = l.split(ha), b = 0, c = this.length; b < c; b++)
                            if (d = this[b], 1 === d.nodeType)
                                if (d.className || 1 !== a.length) {
                                    e = " " + d.className + " ";
                                    f = 0;
                                    for (p = a.length; f < p; f++) 0 > e.indexOf(" " + a[f] + " ") && (e += a[f] + " ");
                                    d.className = g.trim(e)
                                } else d.className = l;
                    return this
                },
                removeClass: function (l) {
                    var b, c, d, e, f, p, m;
                    if (g.isFunction(l)) return this.each(function (a) {
                        g(this).removeClass(l.call(this,
                            a, this.className))
                    });
                    if (l && "string" == typeof l || l === a)
                        for (b = (l || "").split(ha), p = 0, m = this.length; p < m; p++)
                            if (d = this[p], 1 === d.nodeType && d.className) {
                                c = (" " + d.className + " ").replace($, " ");
                                e = 0;
                                for (f = b.length; e < f; e++)
                                    for (; 0 <= c.indexOf(" " + b[e] + " ");) c = c.replace(" " + b[e] + " ", " ");
                                d.className = l ? g.trim(c) : ""
                            }
                    return this
                },
                toggleClass: function (l, a) {
                    var b = typeof l,
                        c = "boolean" == typeof a;
                    return g.isFunction(l) ? this.each(function (b) {
                        g(this).toggleClass(l.call(this, b, this.className, a), a)
                    }) : this.each(function () {
                        if ("string" ===
                            b)
                            for (var d, e = 0, f = g(this), p = a, m = l.split(ha); d = m[e++];) p = c ? p : !f.hasClass(d), f[p ? "addClass" : "removeClass"](d);
                        else if ("undefined" === b || "boolean" === b) this.className && g._data(this, "__className__", this.className), this.className = this.className || !1 === l ? "" : g._data(this, "__className__") || ""
                    })
                },
                hasClass: function (l) {
                    l = " " + l + " ";
                    for (var a = 0, b = this.length; a < b; a++)
                        if (1 === this[a].nodeType && 0 <= (" " + this[a].className + " ").replace($, " ").indexOf(l)) return !0;
                    return !1
                },
                val: function (l) {
                    var b, c, d, e = this[0];
                    if (arguments.length) return d =
                        g.isFunction(l), this.each(function (c) {
                            var e, f = g(this);
                            1 === this.nodeType && (d ? e = l.call(this, c, f.val()) : e = l, null == e ? e = "" : "number" == typeof e ? e += "" : g.isArray(e) && (e = g.map(e, function (l) {
                                return null == l ? "" : l + ""
                            })), b = g.valHooks[this.type] || g.valHooks[this.nodeName.toLowerCase()], b && "set" in b && b.set(this, e, "value") !== a || (this.value = e))
                        });
                    if (e) return b = g.valHooks[e.type] || g.valHooks[e.nodeName.toLowerCase()], b && "get" in b && (c = b.get(e, "value")) !== a ? c : (c = e.value, "string" == typeof c ? c.replace(la, "") : null == c ? "" : c)
                }
            });
            g.extend({
                valHooks: {
                    option: {
                        get: function (l) {
                            var a = l.attributes.value;
                            return !a || a.specified ? l.value : l.text
                        }
                    },
                    select: {
                        get: function (l) {
                            for (var a, b = l.options, c = l.selectedIndex, d = (l = "select-one" === l.type || 0 > c) ? null : [], e = l ? c + 1 : b.length, f = 0 > c ? e : l ? c : 0; f < e; f++)
                                if (a = b[f], !(!a.selected && f !== c || (g.support.optDisabled ? a.disabled : null !== a.getAttribute("disabled")) || a.parentNode.disabled && g.nodeName(a.parentNode, "optgroup"))) {
                                    a = g(a).val();
                                    if (l) return a;
                                    d.push(a)
                                }
                            return d
                        },
                        set: function (a, b) {
                            var c = g.makeArray(b);
                            return g(a).find("option").each(function () {
                                this.selected = 0 <= g.inArray(g(this).val(), c)
                            }), c.length || (a.selectedIndex = -1), c
                        }
                    }
                },
                attrFn: {},
                attr: function (l, b, c, d) {
                    var e, f, p = l.nodeType;
                    if (l && 3 !== p && 8 !== p && 2 !== p) {
                        if (d && g.isFunction(g.fn[b])) return g(l)[b](c);
                        if ("undefined" == typeof l.getAttribute) return g.prop(l, b, c);
                        (d = 1 !== p || !g.isXMLDoc(l)) && (b = b.toLowerCase(), f = g.attrHooks[b] || (Pa.test(b) ? T : pa));
                        if (c !== a) {
                            if (null === c) {
                                g.removeAttr(l, b);
                                return
                            }
                            return f && "set" in f && d && (e = f.set(l, c, b)) !== a ? e : (l.setAttribute(b,
                                c + ""), c)
                        }
                        return f && "get" in f && d && null !== (e = f.get(l, b)) ? e : (e = l.getAttribute(b), null === e ? a : e)
                    }
                },
                removeAttr: function (a, b) {
                    var c, d, e, f, p = 0;
                    if (b && 1 === a.nodeType)
                        for (d = b.split(ha); p < d.length; p++)(e = d[p]) && (c = g.propFix[e] || e, f = Pa.test(e), f || g.attr(a, e, ""), a.removeAttribute(Qa ? e : c), f && c in a && (a[c] = !1))
                },
                attrHooks: {
                    type: {
                        set: function (a, b) {
                            if (Oa.test(a.nodeName) && a.parentNode) g.error("type property can't be changed");
                            else if (!g.support.radioValue && "radio" === b && g.nodeName(a, "input")) {
                                var c = a.value;
                                return a.setAttribute("type",
                                    b), c && (a.value = c), b
                            }
                        }
                    },
                    value: {
                        get: function (a, b) {
                            return pa && g.nodeName(a, "button") ? pa.get(a, b) : b in a ? a.value : null
                        },
                        set: function (a, b, c) {
                            if (pa && g.nodeName(a, "button")) return pa.set(a, b, c);
                            a.value = b
                        }
                    }
                },
                propFix: {
                    tabindex: "tabIndex",
                    readonly: "readOnly",
                    "for": "htmlFor",
                    "class": "className",
                    maxlength: "maxLength",
                    cellspacing: "cellSpacing",
                    cellpadding: "cellPadding",
                    rowspan: "rowSpan",
                    colspan: "colSpan",
                    usemap: "useMap",
                    frameborder: "frameBorder",
                    contenteditable: "contentEditable"
                },
                prop: function (l, b, c) {
                    var d, e, f,
                        p = l.nodeType;
                    if (l && 3 !== p && 8 !== p && 2 !== p) return f = 1 !== p || !g.isXMLDoc(l), f && (b = g.propFix[b] || b, e = g.propHooks[b]), c !== a ? e && "set" in e && (d = e.set(l, c, b)) !== a ? d : l[b] = c : e && "get" in e && null !== (d = e.get(l, b)) ? d : l[b]
                },
                propHooks: {
                    tabIndex: {
                        get: function (l) {
                            var b = l.getAttributeNode("tabindex");
                            return b && b.specified ? parseInt(b.value, 10) : ab.test(l.nodeName) || Ia.test(l.nodeName) && l.href ? 0 : a
                        }
                    }
                }
            });
            T = {
                get: function (l, b) {
                    var c, d = g.prop(l, b);
                    return !0 === d || "boolean" != typeof d && (c = l.getAttributeNode(b)) && !1 !== c.nodeValue ? b.toLowerCase() :
                        a
                },
                set: function (a, b, c) {
                    var d;
                    return !1 === b ? g.removeAttr(a, c) : (d = g.propFix[c] || c, d in a && (a[d] = !0), a.setAttribute(c, c.toLowerCase())), c
                }
            };
            Qa || (W = {
                name: !0,
                id: !0,
                coords: !0
            }, pa = g.valHooks.button = {
                get: function (l, b) {
                    var c;
                    return c = l.getAttributeNode(b), c && (W[b] ? "" !== c.value : c.specified) ? c.value : a
                },
                set: function (a, b, c) {
                    var d = a.getAttributeNode(c);
                    return d || (d = z.createAttribute(c), a.setAttributeNode(d)), d.value = b + ""
                }
            }, g.each(["width", "height"], function (a, b) {
                g.attrHooks[b] = g.extend(g.attrHooks[b], {
                    set: function (a,
                        l) {
                        if ("" === l) return a.setAttribute(b, "auto"), l
                    }
                })
            }), g.attrHooks.contenteditable = {
                get: pa.get,
                set: function (a, b, c) {
                    "" === b && (b = "false");
                    pa.set(a, b, c)
                }
            });
            g.support.hrefNormalized || g.each(["href", "src", "width", "height"], function (l, b) {
                g.attrHooks[b] = g.extend(g.attrHooks[b], {
                    get: function (l) {
                        l = l.getAttribute(b, 2);
                        return null === l ? a : l
                    }
                })
            });
            g.support.style || (g.attrHooks.style = {
                get: function (l) {
                    return l.style.cssText.toLowerCase() || a
                },
                set: function (a, b) {
                    return a.style.cssText = b + ""
                }
            });
            g.support.optSelected || (g.propHooks.selected =
                g.extend(g.propHooks.selected, {
                    get: function (a) {
                        a = a.parentNode;
                        return a && (a.selectedIndex, a.parentNode && a.parentNode.selectedIndex), null
                    }
                }));
            g.support.enctype || (g.propFix.enctype = "encoding");
            g.support.checkOn || g.each(["radio", "checkbox"], function () {
                g.valHooks[this] = {
                    get: function (a) {
                        return null === a.getAttribute("value") ? "on" : a.value
                    }
                }
            });
            g.each(["radio", "checkbox"], function () {
                g.valHooks[this] = g.extend(g.valHooks[this], {
                    set: function (a, b) {
                        if (g.isArray(b)) return a.checked = 0 <= g.inArray(g(a).val(), b)
                    }
                })
            });
            var Ra = /^(?:textarea|input|select)$/i,
                ia = /^([^\.]*|)(?:\.(.+)|)$/,
                Ib = /(?:^|\s)hover(\.\S+|)\b/,
                bb = /^key/,
                Jb = /^(?:mouse|contextmenu)|click/,
                lb = /^(?:focusinfocus|focusoutblur)$/,
                mb = function (a) {
                    return g.event.special.hover ? a : a.replace(Ib, "mouseenter$1 mouseleave$1")
                };
            g.event = {
                add: function (l, b, c, d, e) {
                    var f, p, m, w, h, u, z, r, v;
                    if (3 !== l.nodeType && 8 !== l.nodeType && b && c && (f = g._data(l))) {
                        c.handler && (z = c, c = z.handler, e = z.selector);
                        c.guid || (c.guid = g.guid++);
                        (m = f.events) || (f.events = m = {});
                        (p = f.handle) || (f.handle = p =
                            function (l) {
                                return "undefined" == typeof g || l && g.event.triggered === l.type ? a : g.event.dispatch.apply(p.elem, arguments)
                            }, p.elem = l);
                        b = g.trim(mb(b)).split(" ");
                        for (f = 0; f < b.length; f++) w = ia.exec(b[f]) || [], h = w[1], u = (w[2] || "").split(".").sort(), v = g.event.special[h] || {}, h = (e ? v.delegateType : v.bindType) || h, v = g.event.special[h] || {}, w = g.extend({
                            type: h,
                            origType: w[1],
                            data: d,
                            handler: c,
                            guid: c.guid,
                            selector: e,
                            needsContext: e && g.expr.match.needsContext.test(e),
                            namespace: u.join(".")
                        }, z), r = m[h], r || (r = m[h] = [], r.delegateCount =
                            0, v.setup && !1 !== v.setup.call(l, d, u, p) || (l.addEventListener ? l.addEventListener(h, p, !1) : l.attachEvent && l.attachEvent("on" + h, p))), v.add && (v.add.call(l, w), w.handler.guid || (w.handler.guid = c.guid)), e ? r.splice(r.delegateCount++, 0, w) : r.push(w), g.event.global[h] = !0;
                        l = null
                    }
                },
                global: {},
                remove: function (a, b, c, d, e) {
                    var f, p, m, w, h, u, r, z, v, G, T = g.hasData(a) && g._data(a);
                    if (T && (r = T.events)) {
                        b = g.trim(mb(b || "")).split(" ");
                        for (f = 0; f < b.length; f++)
                            if (p = ia.exec(b[f]) || [], m = w = p[1], p = p[2], m) {
                                z = g.event.special[m] || {};
                                m = (d ? z.delegateType :
                                    z.bindType) || m;
                                v = r[m] || [];
                                h = v.length;
                                p = p ? RegExp("(^|\\.)" + p.split(".").sort().join("\\.(?:.*\\.|)") + "(\\.|$)") : null;
                                for (u = 0; u < v.length; u++) G = v[u], !e && w !== G.origType || c && c.guid !== G.guid || p && !p.test(G.namespace) || d && !(d === G.selector || "**" === d && G.selector) || (v.splice(u--, 1), G.selector && v.delegateCount--, !z.remove || z.remove.call(a, G));
                                0 === v.length && h !== v.length && ((!z.teardown || !1 === z.teardown.call(a, p, T.handle)) && g.removeEvent(a, m, T.handle), delete r[m])
                            } else
                                for (m in r) g.event.remove(a, m + b[f], c, d, !0);
                        g.isEmptyObject(r) && (delete T.handle, g.removeData(a, "events", !0))
                    }
                },
                customEvent: {
                    getData: !0,
                    setData: !0,
                    changeData: !0
                },
                trigger: function (l, c, d, e) {
                    if (!d || 3 !== d.nodeType && 8 !== d.nodeType) {
                        var f, p, m, w, h, u, r, v = l.type || l;
                        w = [];
                        if (!lb.test(v + g.event.triggered) && (0 <= v.indexOf("!") && (v = v.slice(0, -1), f = !0), 0 <= v.indexOf(".") && (w = v.split("."), v = w.shift(), w.sort()), d && !g.event.customEvent[v] || g.event.global[v]))
                            if (l = "object" == typeof l ? l[g.expando] ? l : new g.Event(v, l) : new g.Event(v), l.type = v, l.isTrigger = !0, l.exclusive =
                                f, l.namespace = w.join("."), l.namespace_re = l.namespace ? RegExp("(^|\\.)" + w.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, w = 0 > v.indexOf(":") ? "on" + v : "", d) {
                                if (l.result = a, l.target || (l.target = d), c = null != c ? g.makeArray(c) : [], c.unshift(l), h = g.event.special[v] || {}, !h.trigger || !1 !== h.trigger.apply(d, c)) {
                                    r = [
                                        [d, h.bindType || v]
                                    ];
                                    if (!e && !h.noBubble && !g.isWindow(d)) {
                                        p = h.delegateType || v;
                                        f = lb.test(p + v) ? d : d.parentNode;
                                        for (m = d; f; f = f.parentNode) r.push([f, p]), m = f;
                                        m === (d.ownerDocument || z) && r.push([m.defaultView || m.parentWindow || b,
                                            p
                                        ])
                                    }
                                    for (p = 0; p < r.length && !l.isPropagationStopped(); p++) f = r[p][0], l.type = r[p][1], (u = (g._data(f, "events") || {})[l.type] && g._data(f, "handle")) && u.apply(f, c), (u = w && f[w]) && g.acceptData(f) && u.apply && !1 === u.apply(f, c) && l.preventDefault();
                                    return l.type = v, !e && !l.isDefaultPrevented() && (!h._default || !1 === h._default.apply(d.ownerDocument, c)) && ("click" !== v || !g.nodeName(d, "a")) && g.acceptData(d) && w && d[v] && ("focus" !== v && "blur" !== v || 0 !== l.target.offsetWidth) && !g.isWindow(d) && (m = d[w], m && (d[w] = null), g.event.triggered =
                                        v, d[v](), g.event.triggered = a, m && (d[w] = m)), l.result
                                }
                            } else
                                for (p in d = g.cache, d) d[p].events && d[p].events[v] && g.event.trigger(l, c, d[p].handle.elem, !0)
                    }
                },
                dispatch: function (l) {
                    l = g.event.fix(l || b.event);
                    var c, d, e, f, p, m, w = (g._data(this, "events") || {})[l.type] || [],
                        h = w.delegateCount,
                        u = aa.call(arguments),
                        v = !l.exclusive && !l.namespace,
                        r = g.event.special[l.type] || {}, z = [];
                    u[0] = l;
                    l.delegateTarget = this;
                    if (!r.preDispatch || !1 !== r.preDispatch.call(this, l)) {
                        if (h && (!l.button || "click" !== l.type))
                            for (d = l.target; d != this; d =
                                d.parentNode || this)
                                if (!0 !== d.disabled || "click" !== l.type) {
                                    f = {};
                                    p = [];
                                    for (c = 0; c < h; c++) e = w[c], m = e.selector, f[m] === a && (f[m] = e.needsContext ? 0 <= g(m, this).index(d) : g.find(m, this, null, [d]).length), f[m] && p.push(e);
                                    p.length && z.push({
                                        elem: d,
                                        matches: p
                                    })
                                }
                        w.length > h && z.push({
                            elem: this,
                            matches: w.slice(h)
                        });
                        for (c = 0; c < z.length && !l.isPropagationStopped(); c++)
                            for (f = z[c], l.currentTarget = f.elem, d = 0; d < f.matches.length && !l.isImmediatePropagationStopped(); d++)
                                if (e = f.matches[d], v || !l.namespace && !e.namespace || l.namespace_re &&
                                    l.namespace_re.test(e.namespace)) l.data = e.data, l.handleObj = e, e = ((g.event.special[e.origType] || {}).handle || e.handler).apply(f.elem, u), e !== a && (l.result = e, !1 === e && (l.preventDefault(), l.stopPropagation()));
                        return r.postDispatch && r.postDispatch.call(this, l), l.result
                    }
                },
                props: "attrChange attrName relatedNode srcElement altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
                fixHooks: {},
                keyHooks: {
                    props: ["char", "charCode", "key", "keyCode"],
                    filter: function (a, b) {
                        return null == a.which && (a.which = null != b.charCode ? b.charCode : b.keyCode), a
                    }
                },
                mouseHooks: {
                    props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
                    filter: function (l, b) {
                        var c, d, g, e = b.button,
                            f = b.fromElement;
                        return null == l.pageX && null != b.clientX && (c = l.target.ownerDocument || z, d = c.documentElement, g = c.body, l.pageX = b.clientX + (d && d.scrollLeft || g && g.scrollLeft || 0) - (d && d.clientLeft || g && g.clientLeft || 0), l.pageY = b.clientY + (d && d.scrollTop ||
                            g && g.scrollTop || 0) - (d && d.clientTop || g && g.clientTop || 0)), !l.relatedTarget && f && (l.relatedTarget = f === l.target ? b.toElement : f), !l.which && e !== a && (l.which = e & 1 ? 1 : e & 2 ? 3 : e & 4 ? 2 : 0), l
                    }
                },
                fix: function (a) {
                    if (a[g.expando]) return a;
                    var b, c, d = a,
                        e = g.event.fixHooks[a.type] || {}, f = e.props ? this.props.concat(e.props) : this.props;
                    a = g.Event(d);
                    for (b = f.length; b;) c = f[--b], a[c] = d[c];
                    return a.target || (a.target = d.srcElement || z), 3 === a.target.nodeType && (a.target = a.target.parentNode), a.metaKey = !! a.metaKey, e.filter ? e.filter(a, d) : a
                },
                special: {
                    load: {
                        noBubble: !0
                    },
                    focus: {
                        delegateType: "focusin"
                    },
                    blur: {
                        delegateType: "focusout"
                    },
                    beforeunload: {
                        setup: function (a, b, c) {
                            g.isWindow(this) && (this.onbeforeunload = c)
                        },
                        teardown: function (a, b) {
                            this.onbeforeunload === b && (this.onbeforeunload = null)
                        }
                    }
                },
                simulate: function (a, b, c, d) {
                    a = g.extend(new g.Event, c, {
                        type: a,
                        isSimulated: !0,
                        originalEvent: {}
                    });
                    d ? g.event.trigger(a, null, b) : g.event.dispatch.call(b, a);
                    a.isDefaultPrevented() && c.preventDefault()
                }
            };
            g.event.handle = g.event.dispatch;
            g.removeEvent = z.removeEventListener ?
                function (a, b, c) {
                    a.removeEventListener && a.removeEventListener(b, c, !1)
            } : function (a, b, c) {
                b = "on" + b;
                a.detachEvent && ("undefined" == typeof a[b] && (a[b] = null), a.detachEvent(b, c))
            };
            g.Event = function (a, b) {
                if (!(this instanceof g.Event)) return new g.Event(a, b);
                a && a.type ? (this.originalEvent = a, this.type = a.type, this.isDefaultPrevented = a.defaultPrevented || !1 === a.returnValue || a.getPreventDefault && a.getPreventDefault() ? m : h) : this.type = a;
                b && g.extend(this, b);
                this.timeStamp = a && a.timeStamp || g.now();
                this[g.expando] = !0
            };
            g.Event.prototype = {
                preventDefault: function () {
                    this.isDefaultPrevented = m;
                    var a = this.originalEvent;
                    a && (a.preventDefault ? a.preventDefault() : a.returnValue = !1)
                },
                stopPropagation: function () {
                    this.isPropagationStopped = m;
                    var a = this.originalEvent;
                    a && (a.stopPropagation && a.stopPropagation(), a.cancelBubble = !0)
                },
                stopImmediatePropagation: function () {
                    this.isImmediatePropagationStopped = m;
                    this.stopPropagation()
                },
                isDefaultPrevented: h,
                isPropagationStopped: h,
                isImmediatePropagationStopped: h
            };
            g.each({
                    mouseenter: "mouseover",
                    mouseleave: "mouseout"
                },
                function (a, b) {
                    g.event.special[a] = {
                        delegateType: b,
                        bindType: b,
                        handle: function (a) {
                            var l, c = a.relatedTarget,
                                d = a.handleObj;
                            if (!c || c !== this && !g.contains(this, c)) a.type = d.origType, l = d.handler.apply(this, arguments), a.type = b;
                            return l
                        }
                    }
                });
            g.support.submitBubbles || (g.event.special.submit = {
                setup: function () {
                    if (g.nodeName(this, "form")) return !1;
                    g.event.add(this, "click._submit keypress._submit", function (b) {
                        b = b.target;
                        (b = g.nodeName(b, "input") || g.nodeName(b, "button") ? b.form : a) && !g._data(b, "_submit_attached") && (g.event.add(b,
                            "submit._submit", function (a) {
                                a._submit_bubble = !0
                            }), g._data(b, "_submit_attached", !0))
                    })
                },
                postDispatch: function (a) {
                    a._submit_bubble && (delete a._submit_bubble, this.parentNode && !a.isTrigger && g.event.simulate("submit", this.parentNode, a, !0))
                },
                teardown: function () {
                    if (g.nodeName(this, "form")) return !1;
                    g.event.remove(this, "._submit")
                }
            });
            g.support.changeBubbles || (g.event.special.change = {
                setup: function () {
                    if (Ra.test(this.nodeName)) {
                        if ("checkbox" === this.type || "radio" === this.type) g.event.add(this, "propertychange._change",
                            function (a) {
                                "checked" === a.originalEvent.propertyName && (this._just_changed = !0)
                            }), g.event.add(this, "click._change", function (a) {
                            this._just_changed && !a.isTrigger && (this._just_changed = !1);
                            g.event.simulate("change", this, a, !0)
                        });
                        return !1
                    }
                    g.event.add(this, "beforeactivate._change", function (a) {
                        a = a.target;
                        Ra.test(a.nodeName) && !g._data(a, "_change_attached") && (g.event.add(a, "change._change", function (a) {
                            this.parentNode && !a.isSimulated && !a.isTrigger && g.event.simulate("change", this.parentNode, a, !0)
                        }), g._data(a, "_change_attached", !0))
                    })
                },
                handle: function (a) {
                    var b = a.target;
                    if (this !== b || a.isSimulated || a.isTrigger || "radio" !== b.type && "checkbox" !== b.type) return a.handleObj.handler.apply(this, arguments)
                },
                teardown: function () {
                    return g.event.remove(this, "._change"), !Ra.test(this.nodeName)
                }
            });
            g.support.focusinBubbles || g.each({
                focus: "focusin",
                blur: "focusout"
            }, function (a, b) {
                var c = 0,
                    d = function (a) {
                        g.event.simulate(b, a.target, g.event.fix(a), !0)
                    };
                g.event.special[b] = {
                    setup: function () {
                        0 === c++ && z.addEventListener(a, d, !0)
                    },
                    teardown: function () {
                        0 ===
                        --c && z.removeEventListener(a, d, !0)
                    }
                }
            });
            g.fn.extend({
                on: function (b, c, d, e, f) {
                    var p, m;
                    if ("object" == typeof b) {
                        "string" != typeof c && (d = d || c, c = a);
                        for (m in b) this.on(m, c, d, b[m], f);
                        return this
                    }
                    null == d && null == e ? (e = c, d = c = a) : null == e && ("string" == typeof c ? (e = d, d = a) : (e = d, d = c, c = a));
                    if (!1 === e) e = h;
                    else if (!e) return this;
                    return 1 === f && (p = e, e = function (a) {
                        return g().off(a), p.apply(this, arguments)
                    }, e.guid = p.guid || (p.guid = g.guid++)), this.each(function () {
                        g.event.add(this, b, e, d, c)
                    })
                },
                one: function (a, b, c, d) {
                    return this.on(a,
                        b, c, d, 1)
                },
                off: function (b, c, d) {
                    var e, f;
                    if (b && b.preventDefault && b.handleObj) return e = b.handleObj, g(b.delegateTarget).off(e.namespace ? e.origType + "." + e.namespace : e.origType, e.selector, e.handler), this;
                    if ("object" == typeof b) {
                        for (f in b) this.off(f, c, b[f]);
                        return this
                    }
                    if (!1 === c || "function" == typeof c) d = c, c = a;
                    return !1 === d && (d = h), this.each(function () {
                        g.event.remove(this, b, d, c)
                    })
                },
                bind: function (a, b, c) {
                    return this.on(a, null, b, c)
                },
                unbind: function (a, b) {
                    return this.off(a, null, b)
                },
                live: function (a, b, c) {
                    return g(this.context).on(a,
                        this.selector, b, c), this
                },
                die: function (a, b) {
                    return g(this.context).off(a, this.selector || "**", b), this
                },
                delegate: function (a, b, c, d) {
                    return this.on(b, a, c, d)
                },
                undelegate: function (a, b, c) {
                    return 1 === arguments.length ? this.off(a, "**") : this.off(b, a || "**", c)
                },
                trigger: function (a, b) {
                    return this.each(function () {
                        g.event.trigger(a, b, this)
                    })
                },
                triggerHandler: function (a, b) {
                    if (this[0]) return g.event.trigger(a, b, this[0], !0)
                },
                toggle: function (a) {
                    var b = arguments,
                        c = a.guid || g.guid++,
                        d = 0,
                        e = function (c) {
                            var e = (g._data(this, "lastToggle" +
                                a.guid) || 0) % d;
                            return g._data(this, "lastToggle" + a.guid, e + 1), c.preventDefault(), b[e].apply(this, arguments) || !1
                        };
                    for (e.guid = c; d < b.length;) b[d++].guid = c;
                    return this.click(e)
                },
                hover: function (a, b) {
                    return this.mouseenter(a).mouseleave(b || a)
                }
            });
            g.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function (a, b) {
                g.fn[b] = function (a, c) {
                    return null ==
                        c && (c = a, a = null), 0 < arguments.length ? this.on(b, null, a, c) : this.trigger(b)
                };
                bb.test(b) && (g.event.fixHooks[b] = g.event.keyHooks);
                Jb.test(b) && (g.event.fixHooks[b] = g.event.mouseHooks)
            });
            (function (a, b) {
                function c(a, b, l, d) {
                    l = l || [];
                    b = b || H;
                    var e, g, f, p, m = b.nodeType;
                    if (!a || "string" != typeof a) return l;
                    if (1 !== m && 9 !== m) return [];
                    f = t(b);
                    if (!f && !d && (e = ab.exec(a)))
                        if (p = e[1])
                            if (9 === m) {
                                g = b.getElementById(p);
                                if (!g || !g.parentNode) return l;
                                if (g.id === p) return l.push(g), l
                            } else {
                                if (b.ownerDocument && (g = b.ownerDocument.getElementById(p)) &&
                                    s(b, g) && g.id === p) return l.push(g), l
                            } else {
                                if (e[2]) return la.apply(l, U.call(b.getElementsByTagName(a), 0)), l;
                                if ((p = e[3]) && C && b.getElementsByClassName) return la.apply(l, U.call(b.getElementsByClassName(p), 0)), l
                            }
                    return G(a.replace(na, "$1"), b, l, d, f)
                }

                function d(a) {
                    return function (b) {
                        return "input" === b.nodeName.toLowerCase() && b.type === a
                    }
                }

                function e(a) {
                    return function (b) {
                        var c = b.nodeName.toLowerCase();
                        return ("input" === c || "button" === c) && b.type === a
                    }
                }

                function f(a) {
                    return O(function (b) {
                        return b = +b, O(function (c,
                            l) {
                            for (var d, e = a([], c.length, b), g = e.length; g--;) c[d = e[g]] && (c[d] = !(l[d] = c[d]))
                        })
                    })
                }

                function p(a, b, c) {
                    if (a === b) return c;
                    for (a = a.nextSibling; a;) {
                        if (a === b) return -1;
                        a = a.nextSibling
                    }
                    return 1
                }

                function m(a, b) {
                    var l, d, e, g, f, p, w;
                    if (f = ra[y][a + " "]) return b ? 0 : f.slice(0);
                    f = a;
                    p = [];
                    for (w = n.preFilter; f;) {
                        if (!l || (d = S.exec(f))) d && (f = f.slice(d[0].length) || f), p.push(e = []);
                        l = !1;
                        if (d = B.exec(f)) e.push(l = new Y(d.shift())), f = f.slice(l.length), l.type = d[0].replace(na, " ");
                        for (g in n.filter)(d = oa[g].exec(f)) && (!w[g] || (d = w[g](d))) &&
                            (e.push(l = new Y(d.shift())), f = f.slice(l.length), l.type = g, l.matches = d);
                        if (!l) break
                    }
                    return b ? f.length : f ? c.error(a) : ra(a, p).slice(0)
                }

                function w(a, b, c) {
                    var l = b.dir,
                        d = c && "parentNode" === b.dir,
                        e = E++;
                    return b.first ? function (b, c, e) {
                        for (; b = b[l];)
                            if (d || 1 === b.nodeType) return a(b, c, e)
                    } : function (b, c, g) {
                        if (!g)
                            for (var f, p = N + " " + e + " ", m = p + D; b = b[l];) {
                                if (d || 1 === b.nodeType) {
                                    if ((f = b[y]) === m) return b.sizset;
                                    if ("string" == typeof f && 0 === f.indexOf(p)) {
                                        if (b.sizset) return b
                                    } else {
                                        b[y] = m;
                                        if (a(b, c, g)) return b.sizset = !0, b;
                                        b.sizset = !1
                                    }
                                }
                            } else
                                for (; b = b[l];)
                                    if ((d || 1 === b.nodeType) && a(b, c, g)) return b
                    }
                }

                function h(a) {
                    return 1 < a.length ? function (b, c, l) {
                        for (var d = a.length; d--;)
                            if (!a[d](b, c, l)) return !1;
                        return !0
                    } : a[0]
                }

                function u(a, b, c, l, d) {
                    for (var e, g = [], f = 0, p = a.length, m = null != b; f < p; f++)
                        if (e = a[f])
                            if (!c || c(e, l, d)) g.push(e), m && b.push(f);
                    return g
                }

                function v(a, b, l, d, e, g) {
                    return d && !d[y] && (d = v(d)), e && !e[y] && (e = v(e, g)), O(function (g, f, p, m) {
                        var w, h, v = [],
                            r = [],
                            z = f.length,
                            K;
                        if (!(K = g)) {
                            K = b || "*";
                            for (var G = p.nodeType ? [p] : p, T = [], n = 0, D = G.length; n < D; n++) c(K,
                                G[n], T);
                            K = T
                        }
                        K = !a || !g && b ? K : u(K, v, a, p, m);
                        G = l ? e || (g ? a : z || d) ? [] : f : K;
                        l && l(K, G, p, m);
                        if (d)
                            for (w = u(G, r), d(w, [], p, m), p = w.length; p--;)
                                if (h = w[p]) G[r[p]] = !(K[r[p]] = h);
                        if (g) {
                            if (e || a) {
                                if (e) {
                                    w = [];
                                    for (p = G.length; p--;)(h = G[p]) && w.push(K[p] = h);
                                    e(null, G = [], w, m)
                                }
                                for (p = G.length; p--;)(h = G[p]) && -1 < (w = e ? F.call(g, h) : v[p]) && (g[w] = !(f[w] = h))
                            }
                        } else G = u(G === f ? G.splice(z, G.length) : G), e ? e(null, f, G, m) : la.apply(f, G)
                    })
                }

                function r(a) {
                    var b, c, l, d = a.length,
                        e = n.relative[a[0].type];
                    c = e || n.relative[" "];
                    for (var g = e ? 1 : 0, f = w(function (a) {
                            return a ===
                                b
                        }, c, !0), p = w(function (a) {
                            return -1 < F.call(b, a)
                        }, c, !0), m = [
                            function (a, c, l) {
                                return !e && (l || c !== W) || ((b = c).nodeType ? f(a, c, l) : p(a, c, l))
                            }
                        ]; g < d; g++)
                        if (c = n.relative[a[g].type]) m = [w(h(m), c)];
                        else {
                            c = n.filter[a[g].type].apply(null, a[g].matches);
                            if (c[y]) {
                                for (l = ++g; l < d && !n.relative[a[l].type]; l++);
                                return v(1 < g && h(m), 1 < g && a.slice(0, g - 1).join("").replace(na, "$1"), c, g < l && r(a.slice(g, l)), l < d && r(a = a.slice(l)), l < d && a.join(""))
                            }
                            m.push(c)
                        }
                    return h(m)
                }

                function z(a, b) {
                    var l = 0 < b.length,
                        d = 0 < a.length,
                        e = function (g, f, p, m, w) {
                            var h,
                                v, r = [],
                                z = 0,
                                K = "0",
                                G = g && [],
                                T = null != w,
                                A = W,
                                Q = g || d && n.find.TAG("*", w && f.parentNode || f),
                                t = N += null == A ? 1 : Math.E;
                            for (T && (W = f !== H && f, D = e.el); null != (w = Q[K]); K++) {
                                if (d && w) {
                                    for (h = 0; v = a[h]; h++)
                                        if (v(w, f, p)) {
                                            m.push(w);
                                            break
                                        }
                                    T && (N = t, D = ++e.el)
                                }
                                l && ((w = !v && w) && z--, g && G.push(w))
                            }
                            z += K;
                            if (l && K !== z) {
                                for (h = 0; v = b[h]; h++) v(G, r, f, p);
                                if (g) {
                                    if (0 < z)
                                        for (; K--;) G[K] || r[K] || (r[K] = V.call(m));
                                    r = u(r)
                                }
                                la.apply(m, r);
                                T && !g && 0 < r.length && 1 < z + b.length && c.uniqueSort(m)
                            }
                            return T && (N = t, W = A), G
                        };
                    return e.el = 0, l ? O(e) : e
                }

                function G(a, b, c, l, d) {
                    var e,
                        g, f, p, w = m(a);
                    if (!l && 1 === w.length) {
                        g = w[0] = w[0].slice(0);
                        if (2 < g.length && "ID" === (f = g[0]).type && 9 === b.nodeType && !d && n.relative[g[1].type]) {
                            b = n.find.ID(f.matches[0].replace(ea, ""), b, d)[0];
                            if (!b) return c;
                            a = a.slice(g.shift().length)
                        }
                        for (e = oa.POS.test(a) ? -1 : g.length - 1; 0 <= e; e--) {
                            f = g[e];
                            if (n.relative[p = f.type]) break;
                            if (p = n.find[p])
                                if (l = p(f.matches[0].replace(ea, ""), X.test(g[0].type) && b.parentNode || b, d)) {
                                    g.splice(e, 1);
                                    a = l.length && g.join("");
                                    if (!a) return la.apply(c, U.call(l, 0)), c;
                                    break
                                }
                        }
                    }
                    return $(a, w)(l, b, d,
                        c, X.test(a)), c
                }

                function T() {}
                var D, A, n, Q, t, s, $, q, M, W, ca = !0,
                    y = ("sizcache" + Math.random()).replace(".", ""),
                    Y = String,
                    H = a.document,
                    J = H.documentElement,
                    N = 0,
                    E = 0,
                    V = [].pop,
                    la = [].push,
                    U = [].slice,
                    F = [].indexOf || function (a) {
                        for (var b = 0, c = this.length; b < c; b++)
                            if (this[b] === a) return b;
                        return -1
                    }, O = function (a, b) {
                        return a[y] = null == b || b, a
                    }, x = function () {
                        var a = {}, b = [];
                        return O(function (c, l) {
                            return b.push(c) > n.cacheLength && delete a[b.shift()], a[c + " "] = l
                        }, a)
                    }, Oa = x(),
                    ra = x(),
                    ba = x(),
                    x = "\\[[\\x20\\t\\r\\n\\f]*((?:\\\\.|[-\\w]|[^\\x00-\\xa0])+)[\\x20\\t\\r\\n\\f]*(?:([*^$|!~]?=)[\\x20\\t\\r\\n\\f]*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|(" +
                        "(?:\\\\.|[-\\w]|[^\\x00-\\xa0])+".replace("w", "w#") + ")|)|)[\\x20\\t\\r\\n\\f]*\\]",
                    Ia = ":((?:\\\\.|[-\\w]|[^\\x00-\\xa0])+)(?:\\((?:(['\"])((?:\\\\.|[^\\\\])*?)\\2|([^()[\\]]*|(?:(?:" + x + ")|[^:]|\\\\.)*|.*))\\)|)",
                    na = /^[\x20\t\r\n\f]+|((?:^|[^\\])(?:\\.)*)[\x20\t\r\n\f]+$/g,
                    S = /^[\x20\t\r\n\f]*,[\x20\t\r\n\f]*/,
                    B = /^[\x20\t\r\n\f]*([\x20\t\r\n\f>+~])[\x20\t\r\n\f]*/,
                    qa = RegExp(Ia),
                    ab = /^(?:#([\w\-]+)|(\w+)|\.([\w\-]+))$/,
                    X = /[\x20\t\r\n\f]*[+~]/,
                    Pa = /h\d/i,
                    Qa = /input|select|textarea|button/i,
                    ea = /\\(?!\\)/g,
                    oa = {
                        ID: /^#((?:\\.|[-\w]|[^\x00-\xa0])+)/,
                        CLASS: /^\.((?:\\.|[-\w]|[^\x00-\xa0])+)/,
                        NAME: /^\[name=['"]?((?:\\.|[-\w]|[^\x00-\xa0])+)['"]?\]/,
                        TAG: RegExp("^(" + "(?:\\\\.|[-\\w]|[^\\x00-\\xa0])+".replace("w", "w*") + ")"),
                        ATTR: RegExp("^" + x),
                        PSEUDO: RegExp("^" + Ia),
                        POS: /:(even|odd|eq|gt|lt|nth|first|last)(?:\([\x20\t\r\n\f]*((?:-\d)?\d*)[\x20\t\r\n\f]*\)|)(?=[^-]|$)/i,
                        CHILD: RegExp("^:(only|nth|first|last)-child(?:\\([\\x20\\t\\r\\n\\f]*(even|odd|(([+-]|)(\\d*)n|)[\\x20\\t\\r\\n\\f]*(?:([+-]|)[\\x20\\t\\r\\n\\f]*(\\d+)|))[\\x20\\t\\r\\n\\f]*\\)|)",
                            "i"),
                        needsContext: RegExp("^[\\x20\\t\\r\\n\\f]*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\([\\x20\\t\\r\\n\\f]*((?:-\\d)?\\d*)[\\x20\\t\\r\\n\\f]*\\)|)(?=[^-]|$)", "i")
                    }, ia = function (a) {
                        var b = H.createElement("div");
                        try {
                            return a(b)
                        } catch (c) {
                            return !1
                        } finally {}
                    }, x = ia(function (a) {
                        return a.appendChild(H.createComment("")), !a.getElementsByTagName("*").length
                    }),
                    I = ia(function (a) {
                        return a.innerHTML = "<a href='#'></a>", a.firstChild && "undefined" !== typeof a.firstChild.getAttribute && "#" === a.firstChild.getAttribute("href")
                    }),
                    aa = ia(function (a) {
                        a.innerHTML = "<select></select>";
                        a = typeof a.lastChild.getAttribute("multiple");
                        return "boolean" !== a && "string" !== a
                    }),
                    C = ia(function (a) {
                        return a.innerHTML = "<div class='hidden e'></div><div class='hidden'></div>", a.getElementsByClassName && a.getElementsByClassName("e").length ? (a.lastChild.className = "e", 2 === a.getElementsByClassName("e").length) : !1
                    }),
                    bb = ia(function (a) {
                        a.id = y + 0;
                        a.innerHTML = "<a name='" + y + "'></a><div name='" + y + "'></div>";
                        J.insertBefore(a, J.firstChild);
                        var b = H.getElementsByName &&
                            H.getElementsByName(y).length === 2 + H.getElementsByName(y + 0).length;
                        return A = !H.getElementById(y), J.removeChild(a), b
                    });
                try {
                    U.call(J.childNodes, 0)[0].nodeType
                } catch (Ra) {
                    U = function (a) {
                        for (var b, c = []; b = this[a]; a++) c.push(b);
                        return c
                    }
                }
                c.matches = function (a, b) {
                    return c(a, null, null, b)
                };
                c.matchesSelector = function (a, b) {
                    return 0 < c(b, null, null, [a]).length
                };
                Q = c.getText = function (a) {
                    var b, c = "",
                        l = 0;
                    if (b = a.nodeType)
                        if (1 === b || 9 === b || 11 === b) {
                            if ("string" == typeof a.textContent) return a.textContent;
                            for (a = a.firstChild; a; a =
                                a.nextSibling) c += Q(a)
                        } else {
                            if (3 === b || 4 === b) return a.nodeValue
                        } else
                            for (; b = a[l]; l++) c += Q(b);
                    return c
                };
                t = c.isXML = function (a) {
                    return (a = a && (a.ownerDocument || a).documentElement) ? "HTML" !== a.nodeName : !1
                };
                s = c.contains = J.contains ? function (a, b) {
                    var c = 9 === a.nodeType ? a.documentElement : a,
                        l = b && b.parentNode;
                    return a === l || !! (l && 1 === l.nodeType && c.contains && c.contains(l))
                } : J.compareDocumentPosition ? function (a, b) {
                    return b && !! (a.compareDocumentPosition(b) & 16)
                } : function (a, b) {
                    for (; b = b.parentNode;)
                        if (b === a) return !0;
                    return !1
                };
                c.attr = function (a, b) {
                    var c, l = t(a);
                    return l || (b = b.toLowerCase()), (c = n.attrHandle[b]) ? c(a) : l || aa ? a.getAttribute(b) : (c = a.getAttributeNode(b), c ? "boolean" == typeof a[b] ? a[b] ? b : null : c.specified ? c.value : null : null)
                };
                n = c.selectors = {
                    cacheLength: 50,
                    createPseudo: O,
                    match: oa,
                    attrHandle: I ? {} : {
                        href: function (a) {
                            return a.getAttribute("href", 2)
                        },
                        type: function (a) {
                            return a.getAttribute("type")
                        }
                    },
                    find: {
                        ID: A ? function (a, b, c) {
                            if ("undefined" !== typeof b.getElementById && !c) return (a = b.getElementById(a)) && a.parentNode ? [a] : []
                        } : function (a, c, l) {
                            if ("undefined" !== typeof c.getElementById && !l) return (c = c.getElementById(a)) ? c.id === a || "undefined" !== typeof c.getAttributeNode && c.getAttributeNode("id").value === a ? [c] : b : []
                        },
                        TAG: x ? function (a, b) {
                            if ("undefined" !== typeof b.getElementsByTagName) return b.getElementsByTagName(a)
                        } : function (a, b) {
                            var c = b.getElementsByTagName(a);
                            if ("*" === a) {
                                for (var l, d = [], e = 0; l = c[e]; e++) 1 === l.nodeType && d.push(l);
                                return d
                            }
                            return c
                        },
                        NAME: bb && function (a, b) {
                            if ("undefined" !== typeof b.getElementsByName) return b.getElementsByName(name)
                        },
                        CLASS: C && function (a, b, c) {
                            if ("undefined" !== typeof b.getElementsByClassName && !c) return b.getElementsByClassName(a)
                        }
                    },
                    relative: {
                        ">": {
                            dir: "parentNode",
                            first: !0
                        },
                        " ": {
                            dir: "parentNode"
                        },
                        "+": {
                            dir: "previousSibling",
                            first: !0
                        },
                        "~": {
                            dir: "previousSibling"
                        }
                    },
                    preFilter: {
                        ATTR: function (a) {
                            return a[1] = a[1].replace(ea, ""), a[3] = (a[4] || a[5] || "").replace(ea, ""), "~=" === a[2] && (a[3] = " " + a[3] + " "), a.slice(0, 4)
                        },
                        CHILD: function (a) {
                            return a[1] = a[1].toLowerCase(), "nth" === a[1] ? (a[2] || c.error(a[0]), a[3] = +(a[3] ? a[4] + (a[5] || 1) : 2 *
                                ("even" === a[2] || "odd" === a[2])), a[4] = +(a[6] + a[7] || "odd" === a[2])) : a[2] && c.error(a[0]), a
                        },
                        PSEUDO: function (a) {
                            var b, c;
                            if (oa.CHILD.test(a[0])) return null;
                            if (a[3]) a[2] = a[3];
                            else if (b = a[4]) qa.test(b) && (c = m(b, !0)) && (c = b.indexOf(")", b.length - c) - b.length) && (b = b.slice(0, c), a[0] = a[0].slice(0, c)), a[2] = b;
                            return a.slice(0, 3)
                        }
                    },
                    filter: {
                        ID: A ? function (a) {
                            return a = a.replace(ea, ""),
                            function (b) {
                                return b.getAttribute("id") === a
                            }
                        } : function (a) {
                            return a = a.replace(ea, ""),
                            function (b) {
                                return (b = "undefined" !== typeof b.getAttributeNode &&
                                    b.getAttributeNode("id")) && b.value === a
                            }
                        },
                        TAG: function (a) {
                            return "*" === a ? function () {
                                return !0
                            } : (a = a.replace(ea, "").toLowerCase(), function (b) {
                                return b.nodeName && b.nodeName.toLowerCase() === a
                            })
                        },
                        CLASS: function (a) {
                            var b = Oa[y][a + " "];
                            return b || (b = RegExp("(^|[\\x20\\t\\r\\n\\f])" + a + "([\\x20\\t\\r\\n\\f]|$)")) && Oa(a, function (a) {
                                return b.test(a.className || "undefined" !== typeof a.getAttribute && a.getAttribute("class") || "")
                            })
                        },
                        ATTR: function (a, b, l) {
                            return function (d, e) {
                                var g = c.attr(d, a);
                                return null == g ? "!=" === b : b ?
                                    (g += "", "=" === b ? g === l : "!=" === b ? g !== l : "^=" === b ? l && 0 === g.indexOf(l) : "*=" === b ? l && -1 < g.indexOf(l) : "$=" === b ? l && g.substr(g.length - l.length) === l : "~=" === b ? -1 < (" " + g + " ").indexOf(l) : "|=" === b ? g === l || g.substr(0, l.length + 1) === l + "-" : !1) : !0
                            }
                        },
                        CHILD: function (a, b, c, l) {
                            return "nth" === a ? function (a) {
                                var b, d;
                                b = a.parentNode;
                                if (1 === c && 0 === l) return !0;
                                if (b)
                                    for (d = 0, b = b.firstChild; b && (1 !== b.nodeType || (d++, a !== b)); b = b.nextSibling);
                                return d -= l, d === c || 0 === d % c && 0 <= d / c
                            } : function (b) {
                                var c = b;
                                switch (a) {
                                case "only":
                                case "first":
                                    for (; c =
                                        c.previousSibling;)
                                        if (1 === c.nodeType) return !1;
                                    if ("first" === a) return !0;
                                    c = b;
                                case "last":
                                    for (; c = c.nextSibling;)
                                        if (1 === c.nodeType) return !1;
                                    return !0
                                }
                            }
                        },
                        PSEUDO: function (a, b) {
                            var l, d = n.pseudos[a] || n.setFilters[a.toLowerCase()] || c.error("unsupported pseudo: " + a);
                            return d[y] ? d(b) : 1 < d.length ? (l = [a, a, "", b], n.setFilters.hasOwnProperty(a.toLowerCase()) ? O(function (a, c) {
                                for (var l, e = d(a, b), g = e.length; g--;) l = F.call(a, e[g]), a[l] = !(c[l] = e[g])
                            }) : function (a) {
                                return d(a, 0, l)
                            }) : d
                        }
                    },
                    pseudos: {
                        not: O(function (a) {
                            var b = [],
                                c = [],
                                l = $(a.replace(na, "$1"));
                            return l[y] ? O(function (a, b, c, d) {
                                d = l(a, null, d, []);
                                for (var e = a.length; e--;)
                                    if (c = d[e]) a[e] = !(b[e] = c)
                            }) : function (a, d, e) {
                                return b[0] = a, l(b, null, e, c), !c.pop()
                            }
                        }),
                        has: O(function (a) {
                            return function (b) {
                                return 0 < c(a, b).length
                            }
                        }),
                        contains: O(function (a) {
                            return function (b) {
                                return -1 < (b.textContent || b.innerText || Q(b)).indexOf(a)
                            }
                        }),
                        enabled: function (a) {
                            return !1 === a.disabled
                        },
                        disabled: function (a) {
                            return !0 === a.disabled
                        },
                        checked: function (a) {
                            var b = a.nodeName.toLowerCase();
                            return "input" === b && !! a.checked || "option" === b && !! a.selected
                        },
                        selected: function (a) {
                            return a.parentNode && a.parentNode.selectedIndex, !0 === a.selected
                        },
                        parent: function (a) {
                            return !n.pseudos.empty(a)
                        },
                        empty: function (a) {
                            var b;
                            for (a = a.firstChild; a;) {
                                if ("@" < a.nodeName || 3 === (b = a.nodeType) || 4 === b) return !1;
                                a = a.nextSibling
                            }
                            return !0
                        },
                        header: function (a) {
                            return Pa.test(a.nodeName)
                        },
                        text: function (a) {
                            var b, c;
                            return "input" === a.nodeName.toLowerCase() && "text" === (b = a.type) && (null == (c = a.getAttribute("type")) || c.toLowerCase() === b)
                        },
                        radio: d("radio"),
                        checkbox: d("checkbox"),
                        file: d("file"),
                        password: d("password"),
                        image: d("image"),
                        submit: e("submit"),
                        reset: e("reset"),
                        button: function (a) {
                            var b = a.nodeName.toLowerCase();
                            return "input" === b && "button" === a.type || "button" === b
                        },
                        input: function (a) {
                            return Qa.test(a.nodeName)
                        },
                        focus: function (a) {
                            var b = a.ownerDocument;
                            return a === b.activeElement && (!b.hasFocus || b.hasFocus()) && !! (a.type || a.href || ~a.tabIndex)
                        },
                        active: function (a) {
                            return a === a.ownerDocument.activeElement
                        },
                        first: f(function () {
                            return [0]
                        }),
                        last: f(function (a,
                            b) {
                            return [b - 1]
                        }),
                        eq: f(function (a, b, c) {
                            return [0 > c ? c + b : c]
                        }),
                        even: f(function (a, b) {
                            for (var c = 0; c < b; c += 2) a.push(c);
                            return a
                        }),
                        odd: f(function (a, b) {
                            for (var c = 1; c < b; c += 2) a.push(c);
                            return a
                        }),
                        lt: f(function (a, b, c) {
                            for (b = 0 > c ? c + b : c; 0 <= --b;) a.push(b);
                            return a
                        }),
                        gt: f(function (a, b, c) {
                            for (c = 0 > c ? c + b : c; ++c < b;) a.push(c);
                            return a
                        })
                    }
                };
                q = J.compareDocumentPosition ? function (a, b) {
                    return a === b ? (M = !0, 0) : (a.compareDocumentPosition && b.compareDocumentPosition ? a.compareDocumentPosition(b) & 4 : a.compareDocumentPosition) ? -1 : 1
                } : function (a,
                    b) {
                    if (a === b) return M = !0, 0;
                    if (a.sourceIndex && b.sourceIndex) return a.sourceIndex - b.sourceIndex;
                    var c, l, d = [],
                        e = [];
                    c = a.parentNode;
                    l = b.parentNode;
                    var g = c;
                    if (c === l) return p(a, b);
                    if (!c) return -1;
                    if (!l) return 1;
                    for (; g;) d.unshift(g), g = g.parentNode;
                    for (g = l; g;) e.unshift(g), g = g.parentNode;
                    c = d.length;
                    l = e.length;
                    for (g = 0; g < c && g < l; g++)
                        if (d[g] !== e[g]) return p(d[g], e[g]);
                    return g === c ? p(a, e[g], -1) : p(d[g], b, 1)
                };
                [0, 0].sort(q);
                ca = !M;
                c.uniqueSort = function (a) {
                    var b, c = [],
                        l = 1,
                        d = 0;
                    M = ca;
                    a.sort(q);
                    if (M) {
                        for (; b = a[l]; l++) b === a[l -
                            1] && (d = c.push(l));
                        for (; d--;) a.splice(c[d], 1)
                    }
                    return a
                };
                c.error = function (a) {
                    throw Error("Syntax error, unrecognized expression: " + a);
                };
                $ = c.compile = function (a, b) {
                    var c, l = [],
                        d = [],
                        g = ba[y][a + " "];
                    if (!g) {
                        b || (b = m(a));
                        for (c = b.length; c--;) g = r(b[c]), g[y] ? l.push(g) : d.push(g);
                        g = ba(a, z(d, l))
                    }
                    return g
                };
                H.querySelectorAll && function () {
                    var a, b = G,
                        l = /'|\\/g,
                        d = /\=[\x20\t\r\n\f]*([^'"\]]*)[\x20\t\r\n\f]*\]/g,
                        g = [":focus"],
                        e = [":active"],
                        f = J.matchesSelector || J.mozMatchesSelector || J.webkitMatchesSelector || J.oMatchesSelector ||
                            J.msMatchesSelector;
                    ia(function (a) {
                        a.innerHTML = "<select><option selected=''></option></select>";
                        a.querySelectorAll("[selected]").length || g.push("\\[[\\x20\\t\\r\\n\\f]*(?:checked|disabled|ismap|multiple|readonly|selected|value)");
                        a.querySelectorAll(":checked").length || g.push(":checked")
                    });
                    ia(function (a) {
                        a.innerHTML = "<p test=''></p>";
                        a.querySelectorAll("[test^='']").length && g.push("[*^$]=[\\x20\\t\\r\\n\\f]*(?:\"\"|'')");
                        a.innerHTML = "<input type='hidden'/>";
                        a.querySelectorAll(":enabled").length || g.push(":enabled",
                            ":disabled")
                    });
                    g = RegExp(g.join("|"));
                    G = function (a, c, d, e, f) {
                        if (!e && !f && !g.test(a)) {
                            var p, w, h = !0,
                                u = y;
                            w = c;
                            p = 9 === c.nodeType && a;
                            if (1 === c.nodeType && "object" !== c.nodeName.toLowerCase()) {
                                p = m(a);
                                (h = c.getAttribute("id")) ? u = h.replace(l, "\\$&") : c.setAttribute("id", u);
                                u = "[id='" + u + "'] ";
                                for (w = p.length; w--;) p[w] = u + p[w].join("");
                                w = X.test(a) && c.parentNode || c;
                                p = p.join(",")
                            }
                            if (p) try {
                                return la.apply(d, U.call(w.querySelectorAll(p), 0)), d
                            } catch (v) {} finally {
                                h || c.removeAttribute("id")
                            }
                        }
                        return b(a, c, d, e, f)
                    };
                    f && (ia(function (b) {
                        a =
                            f.call(b, "div");
                        try {
                            f.call(b, "[test!='']:sizzle"), e.push("!=", Ia)
                        } catch (c) {}
                    }), e = RegExp(e.join("|")), c.matchesSelector = function (b, l) {
                        l = l.replace(d, "='$1']");
                        if (!t(b) && !e.test(l) && !g.test(l)) try {
                            var p = f.call(b, l);
                            if (p || a || b.document && 11 !== b.document.nodeType) return p
                        } catch (m) {}
                        return 0 < c(l, null, null, [b]).length
                    })
                }();
                n.pseudos.nth = n.pseudos.eq;
                n.filters = T.prototype = n.pseudos;
                n.setFilters = new T;
                c.attr = g.attr;
                g.find = c;
                g.expr = c.selectors;
                g.expr[":"] = g.expr.pseudos;
                g.unique = c.uniqueSort;
                g.text = c.getText;
                g.isXMLDoc = c.isXML;
                g.contains = c.contains
            })(b);
            var Kb = /Until$/,
                Lb = /^(?:parents|prev(?:Until|All))/,
                Db = /^.[^:#\[\.,]*$/,
                nb = g.expr.match.needsContext,
                Mb = {
                    children: !0,
                    contents: !0,
                    next: !0,
                    prev: !0
                };
            g.fn.extend({
                find: function (a) {
                    var b, c, d, e, f, p, m = this;
                    if ("string" != typeof a) return g(a).filter(function () {
                        b = 0;
                        for (c = m.length; b < c; b++)
                            if (g.contains(m[b], this)) return !0
                    });
                    p = this.pushStack("", "find", a);
                    b = 0;
                    for (c = this.length; b < c; b++)
                        if (d = p.length, g.find(a, this[b], p), 0 < b)
                            for (e = d; e < p.length; e++)
                                for (f = 0; f < d; f++)
                                    if (p[f] ===
                                        p[e]) {
                                        p.splice(e--, 1);
                                        break
                                    }
                    return p
                },
                has: function (a) {
                    var b, c = g(a, this),
                        d = c.length;
                    return this.filter(function () {
                        for (b = 0; b < d; b++)
                            if (g.contains(this, c[b])) return !0
                    })
                },
                not: function (a) {
                    return this.pushStack(D(this, a, !1), "not", a)
                },
                filter: function (a) {
                    return this.pushStack(D(this, a, !0), "filter", a)
                },
                is: function (a) {
                    return !!a && ("string" == typeof a ? nb.test(a) ? 0 <= g(a, this.context).index(this[0]) : 0 < g.filter(a, this).length : 0 < this.filter(a).length)
                },
                closest: function (a, b) {
                    for (var c, d = 0, e = this.length, f = [], p = nb.test(a) ||
                            "string" != typeof a ? g(a, b || this.context) : 0; d < e; d++)
                        for (c = this[d]; c && c.ownerDocument && c !== b && 11 !== c.nodeType;) {
                            if (p ? -1 < p.index(c) : g.find.matchesSelector(c, a)) {
                                f.push(c);
                                break
                            }
                            c = c.parentNode
                        }
                    return f = 1 < f.length ? g.unique(f) : f, this.pushStack(f, "closest", a)
                },
                index: function (a) {
                    return a ? "string" == typeof a ? g.inArray(this[0], g(a)) : g.inArray(a.jquery ? a[0] : a, this) : this[0] && this[0].parentNode ? this.prevAll().length : -1
                },
                add: function (a, b) {
                    var c = "string" == typeof a ? g(a, b) : g.makeArray(a && a.nodeType ? [a] : a),
                        d = g.merge(this.get(),
                            c);
                    return this.pushStack(r(c[0]) || r(d[0]) ? d : g.unique(d))
                },
                addBack: function (a) {
                    return this.add(null == a ? this.prevObject : this.prevObject.filter(a))
                }
            });
            g.fn.andSelf = g.fn.addBack;
            g.each({
                parent: function (a) {
                    return (a = a.parentNode) && 11 !== a.nodeType ? a : null
                },
                parents: function (a) {
                    return g.dir(a, "parentNode")
                },
                parentsUntil: function (a, b, c) {
                    return g.dir(a, "parentNode", c)
                },
                next: function (a) {
                    return u(a, "nextSibling")
                },
                prev: function (a) {
                    return u(a, "previousSibling")
                },
                nextAll: function (a) {
                    return g.dir(a, "nextSibling")
                },
                prevAll: function (a) {
                    return g.dir(a, "previousSibling")
                },
                nextUntil: function (a, b, c) {
                    return g.dir(a, "nextSibling", c)
                },
                prevUntil: function (a, b, c) {
                    return g.dir(a, "previousSibling", c)
                },
                siblings: function (a) {
                    return g.sibling((a.parentNode || {}).firstChild, a)
                },
                children: function (a) {
                    return g.sibling(a.firstChild)
                },
                contents: function (a) {
                    return g.nodeName(a, "iframe") ? a.contentDocument || a.contentWindow.document : g.merge([], a.childNodes)
                }
            }, function (a, b) {
                g.fn[a] = function (c, d) {
                    var e = g.map(this, b, c);
                    return Kb.test(a) ||
                        (d = c), d && "string" == typeof d && (e = g.filter(d, e)), e = 1 < this.length && !Mb[a] ? g.unique(e) : e, 1 < this.length && Lb.test(a) && (e = e.reverse()), this.pushStack(e, a, aa.call(arguments).join(","))
                }
            });
            g.extend({
                filter: function (a, b, c) {
                    return c && (a = ":not(" + a + ")"), 1 === b.length ? g.find.matchesSelector(b[0], a) ? [b[0]] : [] : g.find.matches(a, b)
                },
                dir: function (b, c, d) {
                    var e = [];
                    for (b = b[c]; b && 9 !== b.nodeType && (d === a || 1 !== b.nodeType || !g(b).is(d));) 1 === b.nodeType && e.push(b), b = b[c];
                    return e
                },
                sibling: function (a, b) {
                    for (var c = []; a; a = a.nextSibling) 1 ===
                        a.nodeType && a !== b && c.push(a);
                    return c
                }
            });
            var sa = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",
                xa = / jQuery\d+="(?:null|\d+)"/g,
                cb = /^\s+/,
                ob = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,
                pb = /<([\w:]+)/,
                Nb = /<tbody/i,
                Ob = /<|&#?\w+;/,
                Pb = /<(?:script|style|link)/i,
                Qb = /<(?:script|object|embed|option|style)/i,
                db = RegExp("<(?:" + sa + ")[\\s/>]", "i"),
                hb = /^(?:checkbox|radio)$/,
                qb = /checked\s*(?:[^=]|=\s*.checked.)/i,
                Rb = /\/(java|ecma)script/i,
                Sb = /^\s*<!(?:\[CDATA\[|\-\-)|[\]\-]{2}>\s*$/g,
                fa = {
                    option: [1, "<select multiple='multiple'>", "</select>"],
                    legend: [1, "<fieldset>", "</fieldset>"],
                    thead: [1, "<table>", "</table>"],
                    tr: [2, "<table><tbody>", "</tbody></table>"],
                    td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
                    col: [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"],
                    area: [1, "<map>", "</map>"],
                    _default: [0, "", ""]
                }, rb = n(z),
                eb = rb.appendChild(z.createElement("div"));
            fa.optgroup =
                fa.option;
            fa.tbody = fa.tfoot = fa.colgroup = fa.caption = fa.thead;
            fa.th = fa.td;
            g.support.htmlSerialize || (fa._default = [1, "X<div>", "</div>"]);
            g.fn.extend({
                text: function (b) {
                    return g.access(this, function (b) {
                        return b === a ? g.text(this) : this.empty().append((this[0] && this[0].ownerDocument || z).createTextNode(b))
                    }, null, b, arguments.length)
                },
                wrapAll: function (a) {
                    if (g.isFunction(a)) return this.each(function (b) {
                        g(this).wrapAll(a.call(this, b))
                    });
                    if (this[0]) {
                        var b = g(a, this[0].ownerDocument).eq(0).clone(!0);
                        this[0].parentNode &&
                            b.insertBefore(this[0]);
                        b.map(function () {
                            for (var a = this; a.firstChild && 1 === a.firstChild.nodeType;) a = a.firstChild;
                            return a
                        }).append(this)
                    }
                    return this
                },
                wrapInner: function (a) {
                    return g.isFunction(a) ? this.each(function (b) {
                        g(this).wrapInner(a.call(this, b))
                    }) : this.each(function () {
                        var b = g(this),
                            c = b.contents();
                        c.length ? c.wrapAll(a) : b.append(a)
                    })
                },
                wrap: function (a) {
                    var b = g.isFunction(a);
                    return this.each(function (c) {
                        g(this).wrapAll(b ? a.call(this, c) : a)
                    })
                },
                unwrap: function () {
                    return this.parent().each(function () {
                        g.nodeName(this,
                            "body") || g(this).replaceWith(this.childNodes)
                    }).end()
                },
                append: function () {
                    return this.domManip(arguments, !0, function (a) {
                        1 !== this.nodeType && 11 !== this.nodeType || this.appendChild(a)
                    })
                },
                prepend: function () {
                    return this.domManip(arguments, !0, function (a) {
                        1 !== this.nodeType && 11 !== this.nodeType || this.insertBefore(a, this.firstChild)
                    })
                },
                before: function () {
                    if (!r(this[0])) return this.domManip(arguments, !1, function (a) {
                        this.parentNode.insertBefore(a, this)
                    });
                    if (arguments.length) {
                        var a = g.clean(arguments);
                        return this.pushStack(g.merge(a,
                            this), "before", this.selector)
                    }
                },
                after: function () {
                    if (!r(this[0])) return this.domManip(arguments, !1, function (a) {
                        this.parentNode.insertBefore(a, this.nextSibling)
                    });
                    if (arguments.length) {
                        var a = g.clean(arguments);
                        return this.pushStack(g.merge(this, a), "after", this.selector)
                    }
                },
                remove: function (a, b) {
                    for (var c, d = 0; null != (c = this[d]); d++)
                        if (!a || g.filter(a, [c]).length)!b && 1 === c.nodeType && (g.cleanData(c.getElementsByTagName("*")), g.cleanData([c])), c.parentNode && c.parentNode.removeChild(c);
                    return this
                },
                empty: function () {
                    for (var a,
                            b = 0; null != (a = this[b]); b++)
                        for (1 === a.nodeType && g.cleanData(a.getElementsByTagName("*")); a.firstChild;) a.removeChild(a.firstChild);
                    return this
                },
                clone: function (a, b) {
                    return a = null == a ? !1 : a, b = null == b ? a : b, this.map(function () {
                        return g.clone(this, a, b)
                    })
                },
                html: function (b) {
                    return g.access(this, function (b) {
                        var c = this[0] || {}, d = 0,
                            l = this.length;
                        if (b === a) return 1 === c.nodeType ? c.innerHTML.replace(xa, "") : a;
                        if ("string" == typeof b && !(Pb.test(b) || !g.support.htmlSerialize && db.test(b) || !g.support.leadingWhitespace && cb.test(b) ||
                            fa[(pb.exec(b) || ["", ""])[1].toLowerCase()])) {
                            b = b.replace(ob, "<$1></$2>");
                            try {
                                for (; d < l; d++) c = this[d] || {}, 1 === c.nodeType && (g.cleanData(c.getElementsByTagName("*")), c.innerHTML = b);
                                c = 0
                            } catch (e) {}
                        }
                        c && this.empty().append(b)
                    }, null, b, arguments.length)
                },
                replaceWith: function (a) {
                    return r(this[0]) ? this.length ? this.pushStack(g(g.isFunction(a) ? a() : a), "replaceWith", a) : this : g.isFunction(a) ? this.each(function (b) {
                        var c = g(this),
                            d = c.html();
                        c.replaceWith(a.call(this, b, d))
                    }) : ("string" != typeof a && (a = g(a).detach()), this.each(function () {
                        var b =
                            this.nextSibling,
                            c = this.parentNode;
                        g(this).remove();
                        b ? g(b).before(a) : g(c).append(a)
                    }))
                },
                detach: function (a) {
                    return this.remove(a, !0)
                },
                domManip: function (b, c, d) {
                    b = [].concat.apply([], b);
                    var e, f, p, m = 0,
                        w = b[0],
                        h = [],
                        u = this.length;
                    if (!g.support.checkClone && 1 < u && "string" == typeof w && qb.test(w)) return this.each(function () {
                        g(this).domManip(b, c, d)
                    });
                    if (g.isFunction(w)) return this.each(function (e) {
                        var f = g(this);
                        b[0] = w.call(this, e, c ? f.html() : a);
                        f.domManip(b, c, d)
                    });
                    if (this[0]) {
                        e = g.buildFragment(b, this, h);
                        p = e.fragment;
                        f = p.firstChild;
                        1 === p.childNodes.length && (p = f);
                        if (f)
                            for (c = c && g.nodeName(f, "tr"), e = e.cacheable || u - 1; m < u; m++) d.call(c && g.nodeName(this[m], "table") ? this[m].getElementsByTagName("tbody")[0] || this[m].appendChild(this[m].ownerDocument.createElement("tbody")) : this[m], m === e ? p : g.clone(p, !0, !0));
                        p = f = null;
                        h.length && g.each(h, function (a, b) {
                            b.src ? g.ajax ? g.ajax({
                                url: b.src,
                                type: "GET",
                                dataType: "script",
                                async: !1,
                                global: !1,
                                "throws": !0
                            }) : g.error("no ajax") : g.globalEval((b.text || b.textContent || b.innerHTML || "").replace(Sb,
                                ""));
                            b.parentNode && b.parentNode.removeChild(b)
                        })
                    }
                    return this
                }
            });
            g.buildFragment = function (b, c, d) {
                var e, f, p, m = b[0];
                return c = c || z, c = !c.nodeType && c[0] || c, c = c.ownerDocument || c, 1 === b.length && "string" == typeof m && 512 > m.length && c === z && "<" === m.charAt(0) && !Qb.test(m) && (g.support.checkClone || !qb.test(m)) && (g.support.html5Clone || !db.test(m)) && (f = !0, e = g.fragments[m], p = e !== a), e || (e = c.createDocumentFragment(), g.clean(b, c, e, d), f && (g.fragments[m] = p && e)), {
                    fragment: e,
                    cacheable: f
                }
            };
            g.fragments = {};
            g.each({
                appendTo: "append",
                prependTo: "prepend",
                insertBefore: "before",
                insertAfter: "after",
                replaceAll: "replaceWith"
            }, function (a, b) {
                g.fn[a] = function (c) {
                    var d, e = 0,
                        f = [];
                    c = g(c);
                    var p = c.length;
                    d = 1 === this.length && this[0].parentNode;
                    if ((null == d || d && 11 === d.nodeType && 1 === d.childNodes.length) && 1 === p) return c[b](this[0]), this;
                    for (; e < p; e++) d = (0 < e ? this.clone(!0) : this).get(), g(c[e])[b](d), f = f.concat(d);
                    return this.pushStack(f, a, c.selector)
                }
            });
            g.extend({
                clone: function (a, b, c) {
                    var d, e, f, p;
                    g.support.html5Clone || g.isXMLDoc(a) || !db.test("<" + a.nodeName +
                        ">") ? p = a.cloneNode(!0) : (eb.innerHTML = a.outerHTML, eb.removeChild(p = eb.firstChild));
                    if (!(g.support.noCloneEvent && g.support.noCloneChecked || 1 !== a.nodeType && 11 !== a.nodeType || g.isXMLDoc(a)))
                        for (q(a, p), d = y(a), e = y(p), f = 0; d[f]; ++f) e[f] && q(d[f], e[f]);
                    if (b && (s(a, p), c))
                        for (d = y(a), e = y(p), f = 0; d[f]; ++f) s(d[f], e[f]);
                    return p
                },
                clean: function (a, b, c, d) {
                    var e, f, p, m, w, h, u, v = b === z && rb,
                        r = [];
                    b && "undefined" != typeof b.createDocumentFragment || (b = z);
                    for (e = 0; null != (p = a[e]); e++)
                        if ("number" == typeof p && (p += ""), p) {
                            if ("string" ==
                                typeof p)
                                if (Ob.test(p)) {
                                    v = v || n(b);
                                    h = b.createElement("div");
                                    v.appendChild(h);
                                    p = p.replace(ob, "<$1></$2>");
                                    f = (pb.exec(p) || ["", ""])[1].toLowerCase();
                                    m = fa[f] || fa._default;
                                    w = m[0];
                                    for (h.innerHTML = m[1] + p + m[2]; w--;) h = h.lastChild;
                                    if (!g.support.tbody)
                                        for (w = Nb.test(p), m = "table" !== f || w ? "<table>" !== m[1] || w ? [] : h.childNodes : h.firstChild && h.firstChild.childNodes, f = m.length - 1; 0 <= f; --f) g.nodeName(m[f], "tbody") && !m[f].childNodes.length && m[f].parentNode.removeChild(m[f]);
                                    !g.support.leadingWhitespace && cb.test(p) && h.insertBefore(b.createTextNode(cb.exec(p)[0]),
                                        h.firstChild);
                                    p = h.childNodes;
                                    h.parentNode.removeChild(h)
                                } else p = b.createTextNode(p);
                            p.nodeType ? r.push(p) : g.merge(r, p)
                        }
                    h && (p = h = v = null);
                    if (!g.support.appendChecked)
                        for (e = 0; null != (p = r[e]); e++) g.nodeName(p, "input") ? A(p) : "undefined" != typeof p.getElementsByTagName && g.grep(p.getElementsByTagName("input"), A);
                    if (c)
                        for (a = function (a) {
                            if (!a.type || Rb.test(a.type)) return d ? d.push(a.parentNode ? a.parentNode.removeChild(a) : a) : c.appendChild(a)
                        }, e = 0; null != (p = r[e]); e++) g.nodeName(p, "script") && a(p) || (c.appendChild(p),
                            "undefined" != typeof p.getElementsByTagName && (u = g.grep(g.merge([], p.getElementsByTagName("script")), a), r.splice.apply(r, [e + 1, 0].concat(u)), e += u.length));
                    return r
                },
                cleanData: function (a, b) {
                    for (var c, d, e, f, p = 0, m = g.expando, w = g.cache, h = g.support.deleteExpando, u = g.event.special; null != (e = a[p]); p++)
                        if (b || g.acceptData(e))
                            if (c = (d = e[m]) && w[d]) {
                                if (c.events)
                                    for (f in c.events) u[f] ? g.event.remove(e, f) : g.removeEvent(e, f, c.handle);
                                w[d] && (delete w[d], h ? delete e[m] : e.removeAttribute ? e.removeAttribute(m) : e[m] = null, g.deletedIds.push(d))
                            }
                }
            });
            (function () {
                var a, b;
                g.uaMatch = function (a) {
                    a = a.toLowerCase();
                    a = /(chrome)[ \/]([\w.]+)/.exec(a) || /(webkit)[ \/]([\w.]+)/.exec(a) || /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(a) || /(msie) ([\w.]+)/.exec(a) || 0 > a.indexOf("compatible") && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(a) || [];
                    return {
                        browser: a[1] || "",
                        version: a[2] || "0"
                    }
                };
                a = g.uaMatch(N.userAgent);
                b = {};
                a.browser && (b[a.browser] = !0, b.version = a.version);
                b.chrome ? b.webkit = !0 : b.webkit && (b.safari = !0);
                g.browser = b;
                g.sub = function () {
                    function a(b, c) {
                        return new a.fn.init(b,
                            c)
                    }
                    g.extend(!0, a, this);
                    a.superclass = this;
                    a.fn = a.prototype = this();
                    a.fn.constructor = a;
                    a.sub = this.sub;
                    a.fn.init = function (c, d) {
                        return d && d instanceof g && !(d instanceof a) && (d = a(d)), g.fn.init.call(this, c, d, b)
                    };
                    a.fn.init.prototype = a.fn;
                    var b = a(z);
                    return a
                }
            })();
            var da, ya, za, fb = /alpha\([^)]*\)/i,
                Tb = /opacity=([^)]*)/,
                Ub = /^(top|right|bottom|left)$/,
                Vb = /^(none|table(?!-c[ea]).+)/,
                sb = /^margin/,
                Eb = RegExp("^(" + ua + ")(.*)$", "i"),
                Ka = RegExp("^(" + ua + ")(?!px)[a-z%]+$", "i"),
                Wb = RegExp("^([-+])=(" + ua + ")", "i"),
                Ua = {
                    BODY: "block"
                },
                Xb = {
                    position: "absolute",
                    visibility: "hidden",
                    display: "block"
                }, tb = {
                    letterSpacing: 0,
                    fontWeight: 400
                }, ta = ["Top", "Right", "Bottom", "Left"],
                ib = ["Webkit", "O", "Moz", "ms"],
                Yb = g.fn.toggle;
            g.fn.extend({
                css: function (b, c) {
                    return g.access(this, function (b, c, d) {
                        return d !== a ? g.style(b, c, d) : g.css(b, c)
                    }, b, c, 1 < arguments.length)
                },
                show: function () {
                    return F(this, !0)
                },
                hide: function () {
                    return F(this)
                },
                toggle: function (a, b) {
                    var c = "boolean" == typeof a;
                    return g.isFunction(a) && g.isFunction(b) ? Yb.apply(this, arguments) : this.each(function () {
                        (c ?
                            a : V(this)) ? g(this).show() : g(this).hide()
                    })
                }
            });
            g.extend({
                cssHooks: {
                    opacity: {
                        get: function (a, b) {
                            if (b) {
                                var c = da(a, "opacity");
                                return "" === c ? "1" : c
                            }
                        }
                    }
                },
                cssNumber: {
                    fillOpacity: !0,
                    fontWeight: !0,
                    lineHeight: !0,
                    opacity: !0,
                    orphans: !0,
                    widows: !0,
                    zIndex: !0,
                    zoom: !0
                },
                cssProps: {
                    "float": g.support.cssFloat ? "cssFloat" : "styleFloat"
                },
                style: function (b, c, d, e) {
                    if (b && 3 !== b.nodeType && 8 !== b.nodeType && b.style) {
                        var f, p, m, w = g.camelCase(c),
                            h = b.style;
                        c = g.cssProps[w] || (g.cssProps[w] = E(h, w));
                        m = g.cssHooks[c] || g.cssHooks[w];
                        if (d === a) return m &&
                            "get" in m && (f = m.get(b, !1, e)) !== a ? f : h[c];
                        p = typeof d;
                        "string" === p && (f = Wb.exec(d)) && (d = (f[1] + 1) * f[2] + parseFloat(g.css(b, c)), p = "number");
                        if (!(null == d || "number" === p && isNaN(d) || ("number" === p && !g.cssNumber[w] && (d += "px"), m && "set" in m && (d = m.set(b, d, e)) === a))) try {
                            h[c] = d
                        } catch (u) {}
                    }
                },
                css: function (b, c, d, e) {
                    var f, p, m, w = g.camelCase(c);
                    return c = g.cssProps[w] || (g.cssProps[w] = E(b.style, w)), m = g.cssHooks[c] || g.cssHooks[w], m && "get" in m && (f = m.get(b, !0, e)), f === a && (f = da(b, c)), "normal" === f && c in tb && (f = tb[c]), d || e !== a ? (p =
                        parseFloat(f), d || g.isNumeric(p) ? p || 0 : f) : f
                },
                swap: function (a, b, c) {
                    var d, e = {};
                    for (d in b) e[d] = a.style[d], a.style[d] = b[d];
                    c = c.call(a);
                    for (d in b) a.style[d] = e[d];
                    return c
                }
            });
            b.getComputedStyle ? da = function (a, c) {
                var d, e, f, p, m = b.getComputedStyle(a, null),
                    w = a.style;
                return m && (d = m.getPropertyValue(c) || m[c], "" === d && !g.contains(a.ownerDocument, a) && (d = g.style(a, c)), Ka.test(d) && sb.test(c) && (e = w.width, f = w.minWidth, p = w.maxWidth, w.minWidth = w.maxWidth = w.width = d, d = m.width, w.width = e, w.minWidth = f, w.maxWidth = p)), d
            } : z.documentElement.currentStyle &&
                (da = function (a, b) {
                var c, d, e = a.currentStyle && a.currentStyle[b],
                    g = a.style;
                return null == e && g && g[b] && (e = g[b]), Ka.test(e) && !Ub.test(b) && (c = g.left, d = a.runtimeStyle && a.runtimeStyle.left, d && (a.runtimeStyle.left = a.currentStyle.left), g.left = "fontSize" === b ? "1em" : e, e = g.pixelLeft + "px", g.left = c, d && (a.runtimeStyle.left = d)), "" === e ? "auto" : e
            });
            g.each(["height", "width"], function (a, b) {
                g.cssHooks[b] = {
                    get: function (a, c, d) {
                        if (c) return 0 === a.offsetWidth && Vb.test(da(a, "display")) ? g.swap(a, Xb, function () {
                            return C(a, b, d)
                        }) : C(a,
                            b, d)
                    },
                    set: function (a, c, d) {
                        return x(a, c, d ? B(a, b, d, g.support.boxSizing && "border-box" === g.css(a, "boxSizing")) : 0)
                    }
                }
            });
            g.support.opacity || (g.cssHooks.opacity = {
                get: function (a, b) {
                    return Tb.test((b && a.currentStyle ? a.currentStyle.filter : a.style.filter) || "") ? 0.01 * parseFloat(RegExp.$1) + "" : b ? "1" : ""
                },
                set: function (a, b) {
                    var c = a.style,
                        d = a.currentStyle,
                        e = g.isNumeric(b) ? "alpha(opacity=" + 100 * b + ")" : "",
                        f = d && d.filter || c.filter || "";
                    c.zoom = 1;
                    if (1 <= b && ("" === g.trim(f.replace(fb, "")) && c.removeAttribute) && (c.removeAttribute("filter"),
                        d && !d.filter)) return;
                    c.filter = fb.test(f) ? f.replace(fb, e) : f + " " + e
                }
            });
            g(function () {
                g.support.reliableMarginRight || (g.cssHooks.marginRight = {
                    get: function (a, b) {
                        return g.swap(a, {
                            display: "inline-block"
                        }, function () {
                            if (b) return da(a, "marginRight")
                        })
                    }
                });
                !g.support.pixelPosition && g.fn.position && g.each(["top", "left"], function (a, b) {
                    g.cssHooks[b] = {
                        get: function (a, c) {
                            if (c) {
                                var d = da(a, b);
                                return Ka.test(d) ? g(a).position()[b] + "px" : d
                            }
                        }
                    }
                })
            });
            g.expr && g.expr.filters && (g.expr.filters.hidden = function (a) {
                return 0 === a.offsetWidth &&
                    0 === a.offsetHeight || !g.support.reliableHiddenOffsets && "none" === (a.style && a.style.display || da(a, "display"))
            }, g.expr.filters.visible = function (a) {
                return !g.expr.filters.hidden(a)
            });
            g.each({
                margin: "",
                padding: "",
                border: "Width"
            }, function (a, b) {
                g.cssHooks[a + b] = {
                    expand: function (c) {
                        var d = "string" == typeof c ? c.split(" ") : [c],
                            e = {};
                        for (c = 0; 4 > c; c++) e[a + ta[c] + b] = d[c] || d[c - 2] || d[0];
                        return e
                    }
                };
                sb.test(a) || (g.cssHooks[a + b].set = x)
            });
            var Zb = /%20/g,
                Fb = /\[\]$/,
                ub = /\r?\n/g,
                $b = /^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i,
                ac = /^(?:select|textarea)/i;
            g.fn.extend({
                serialize: function () {
                    return g.param(this.serializeArray())
                },
                serializeArray: function () {
                    return this.map(function () {
                        return this.elements ? g.makeArray(this.elements) : this
                    }).filter(function () {
                        return this.name && !this.disabled && (this.checked || ac.test(this.nodeName) || $b.test(this.type))
                    }).map(function (a, b) {
                        var c = g(this).val();
                        return null == c ? null : g.isArray(c) ? g.map(c, function (a, c) {
                            return {
                                name: b.name,
                                value: a.replace(ub, "\r\n")
                            }
                        }) : {
                            name: b.name,
                            value: c.replace(ub, "\r\n")
                        }
                    }).get()
                }
            });
            g.param = function (b, c) {
                var d, e = [],
                    f = function (a, b) {
                        b = g.isFunction(b) ? b() : null == b ? "" : b;
                        e[e.length] = encodeURIComponent(a) + "=" + encodeURIComponent(b)
                    };
                c === a && (c = g.ajaxSettings && g.ajaxSettings.traditional);
                if (g.isArray(b) || b.jquery && !g.isPlainObject(b)) g.each(b, function () {
                    f(this.name, this.value)
                });
                else
                    for (d in b) I(d, b[d], c, f);
                return e.join("&").replace(Zb, "+")
            };
            var va, wa, bc = /#.*$/,
                cc = /^(.*?):[ \t]*([^\r\n]*)\r?$/mg,
                dc = /^(?:GET|HEAD)$/,
                ec = /^\/\//,
                vb = /\?/,
                fc = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,
                gc = /([?&])_=[^&]*/,
                wb = /^([\w\+\.\-]+:)(?:\/\/([^\/?#:]*)(?::(\d+)|)|)/,
                xb = g.fn.load,
                Va = {}, yb = {}, zb = ["*/"] + ["*"];
            try {
                wa = M.href
            } catch (nc) {
                wa = z.createElement("a"), wa.href = "", wa = wa.href
            }
            va = wb.exec(wa.toLowerCase()) || [];
            g.fn.load = function (b, c, d) {
                if ("string" != typeof b && xb) return xb.apply(this, arguments);
                if (!this.length) return this;
                var e, f, p, m = this,
                    w = b.indexOf(" ");
                return 0 <= w && (e = b.slice(w, b.length), b = b.slice(0, w)), g.isFunction(c) ? (d = c, c = a) : c && "object" == typeof c && (f = "POST"), g.ajax({
                    url: b,
                    type: f,
                    dataType: "html",
                    data: c,
                    complete: function (a, b) {
                        d && m.each(d, p || [a.responseText, b, a])
                    }
                }).done(function (a) {
                    p = arguments;
                    m.html(e ? g("<div>").append(a.replace(fc, "")).find(e) : a)
                }), this
            };
            g.each("ajaxStart ajaxStop ajaxComplete ajaxError ajaxSuccess ajaxSend".split(" "), function (a, b) {
                g.fn[b] = function (a) {
                    return this.on(b, a)
                }
            });
            g.each(["get", "post"], function (b, c) {
                g[c] = function (b, d, l, e) {
                    return g.isFunction(d) && (e = e || l, l = d, d = a), g.ajax({
                        type: c,
                        url: b,
                        data: d,
                        success: l,
                        dataType: e
                    })
                }
            });
            g.extend({
                getScript: function (b, c) {
                    return g.get(b,
                        a, c, "script")
                },
                getJSON: function (a, b, c) {
                    return g.get(a, b, c, "json")
                },
                ajaxSetup: function (a, b) {
                    return b ? Z(a, g.ajaxSettings) : (b = a, a = g.ajaxSettings), Z(a, b), a
                },
                ajaxSettings: {
                    url: wa,
                    isLocal: /^(?:about|app|app\-storage|.+\-extension|file|res|widget):$/.test(va[1]),
                    global: !0,
                    type: "GET",
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    processData: !0,
                    async: !0,
                    accepts: {
                        xml: "application/xml, text/xml",
                        html: "text/html",
                        text: "text/plain",
                        json: "application/json, text/javascript",
                        "*": zb
                    },
                    contents: {
                        xml: /xml/,
                        html: /html/,
                        json: /json/
                    },
                    responseFields: {
                        xml: "responseXML",
                        text: "responseText"
                    },
                    converters: {
                        "* text": b.String,
                        "text html": !0,
                        "text json": g.parseJSON,
                        "text xml": g.parseXML
                    },
                    flatOptions: {
                        context: !0,
                        url: !0
                    }
                },
                ajaxPrefilter: L(Va),
                ajaxTransport: L(yb),
                ajax: function (b, c) {
                    function d(b, c, l, p) {
                        var h, r, D, Q, $, q = c;
                        if (2 !== t) {
                            t = 2;
                            w && clearTimeout(w);
                            m = a;
                            f = p || "";
                            s.readyState = 0 < b ? 4 : 0;
                            if (l) {
                                Q = v;
                                p = s;
                                var M, W, y, ca, H = Q.contents,
                                    J = Q.dataTypes,
                                    Y = Q.responseFields;
                                for (W in Y) W in l && (p[Y[W]] = l[W]);
                                for (;
                                    "*" === J[0];) J.shift(),
                                M === a && (M = Q.mimeType || p.getResponseHeader("content-type"));
                                if (M)
                                    for (W in H)
                                        if (H[W] && H[W].test(M)) {
                                            J.unshift(W);
                                            break
                                        }
                                if (J[0] in l) y = J[0];
                                else {
                                    for (W in l) {
                                        if (!J[0] || Q.converters[W + " " + J[0]]) {
                                            y = W;
                                            break
                                        }
                                        ca || (ca = W)
                                    }
                                    y = y || ca
                                }
                                l = y ? (y !== J[0] && J.unshift(y), l[y]) : void 0;
                                Q = l
                            }
                            if (200 <= b && 300 > b || 304 === b)
                                if (v.ifModified && ($ = s.getResponseHeader("Last-Modified"), $ && (g.lastModified[e] = $), $ = s.getResponseHeader("Etag"), $ && (g.etag[e] = $)), 304 === b) q = "notmodified", h = !0;
                                else {
                                    var N;
                                    a: {
                                        h = v;
                                        r = Q;
                                        var E, q = h.dataTypes.slice();
                                        l = q[0];
                                        M = {};
                                        W = 0;
                                        h.dataFilter && (r = h.dataFilter(r, h.dataType));
                                        if (q[1])
                                            for (N in h.converters) M[N.toLowerCase()] = h.converters[N];
                                        for (; D = q[++W];)
                                            if ("*" !== D) {
                                                if ("*" !== l && l !== D) {
                                                    N = M[l + " " + D] || M["* " + D];
                                                    if (!N)
                                                        for (E in M)
                                                            if ($ = E.split(" "), $[1] === D && (N = M[l + " " + $[0]] || M["* " + $[0]])) {
                                                                !0 === N ? N = M[E] : !0 !== M[E] && (D = $[0], q.splice(W--, 0, D));
                                                                break
                                                            }
                                                    if (!0 !== N)
                                                        if (N && h["throws"]) r = N(r);
                                                        else try {
                                                            r = N(r)
                                                        } catch (la) {
                                                            N = {
                                                                state: "parsererror",
                                                                error: N ? la : "No conversion from " + l + " to " + D
                                                            };
                                                            break a
                                                        }
                                                }
                                                l = D
                                            }
                                        N = {
                                            state: "success",
                                            data: r
                                        }
                                    }
                                    h = N;
                                    q = h.state;
                                    r = h.data;
                                    D = h.error;
                                    h = !D
                                } else if (D = q, !q || b) q = "error", 0 > b && (b = 0);
                            s.status = b;
                            s.statusText = (c || q) + "";
                            h ? T.resolveWith(z, [r, q, s]) : T.rejectWith(z, [s, q, D]);
                            s.statusCode(A);
                            A = a;
                            u && G.trigger("ajax" + (h ? "Success" : "Error"), [s, v, h ? r : D]);
                            n.fireWith(z, [s, q]);
                            u && (G.trigger("ajaxComplete", [s, v]), --g.active || g.event.trigger("ajaxStop"))
                        }
                    }
                    "object" == typeof b && (c = b, b = a);
                    c = c || {};
                    var e, f, p, m, w, h, u, r, v = g.ajaxSetup({}, c),
                        z = v.context || v,
                        G = z !== v && (z.nodeType || z instanceof g) ? g(z) : g.event,
                        T = g.Deferred(),
                        n = g.Callbacks("once memory"),
                        A = v.statusCode || {}, D = {}, Q = {}, t = 0,
                        $ = "canceled",
                        s = {
                            readyState: 0,
                            setRequestHeader: function (a, b) {
                                if (!t) {
                                    var c = a.toLowerCase();
                                    a = Q[c] = Q[c] || a;
                                    D[a] = b
                                }
                                return this
                            },
                            getAllResponseHeaders: function () {
                                return 2 === t ? f : null
                            },
                            getResponseHeader: function (b) {
                                var c;
                                if (2 === t) {
                                    if (!p)
                                        for (p = {}; c = cc.exec(f);) p[c[1].toLowerCase()] = c[2];
                                    c = p[b.toLowerCase()]
                                }
                                return c === a ? null : c
                            },
                            overrideMimeType: function (a) {
                                return t || (v.mimeType = a), this
                            },
                            abort: function (a) {
                                return a = a || $, m && m.abort(a), d(0, a), this
                            }
                        };
                    T.promise(s);
                    s.success = s.done;
                    s.error = s.fail;
                    s.complete = n.add;
                    s.statusCode = function (a) {
                        if (a) {
                            var b;
                            if (2 > t)
                                for (b in a) A[b] = [A[b], a[b]];
                            else b = a[s.status], s.always(b)
                        }
                        return this
                    };
                    v.url = ((b || v.url) + "").replace(bc, "").replace(ec, va[1] + "//");
                    v.dataTypes = g.trim(v.dataType || "*").toLowerCase().split(ha);
                    null == v.crossDomain && (h = wb.exec(v.url.toLowerCase()), v.crossDomain = !(!h || h[1] === va[1] && h[2] === va[2] && (h[3] || ("http:" === h[1] ? 80 : 443)) == (va[3] || ("http:" === va[1] ? 80 : 443))));
                    v.data && v.processData && "string" != typeof v.data && (v.data = g.param(v.data,
                        v.traditional));
                    P(Va, v, c, s);
                    if (2 === t) return s;
                    u = v.global;
                    v.type = v.type.toUpperCase();
                    v.hasContent = !dc.test(v.type);
                    u && 0 === g.active++ && g.event.trigger("ajaxStart");
                    if (!v.hasContent && (v.data && (v.url += (vb.test(v.url) ? "&" : "?") + v.data, delete v.data), e = v.url, !1 === v.cache)) {
                        h = g.now();
                        var q = v.url.replace(gc, "$1_=" + h);
                        v.url = q + (q === v.url ? (vb.test(v.url) ? "&" : "?") + "_=" + h : "")
                    }(v.data && v.hasContent && !1 !== v.contentType || c.contentType) && s.setRequestHeader("Content-Type", v.contentType);
                    v.ifModified && (e = e || v.url, g.lastModified[e] &&
                        s.setRequestHeader("If-Modified-Since", g.lastModified[e]), g.etag[e] && s.setRequestHeader("If-None-Match", g.etag[e]));
                    s.setRequestHeader("Accept", v.dataTypes[0] && v.accepts[v.dataTypes[0]] ? v.accepts[v.dataTypes[0]] + ("*" !== v.dataTypes[0] ? ", " + zb + "; q=0.01" : "") : v.accepts["*"]);
                    for (r in v.headers) s.setRequestHeader(r, v.headers[r]);
                    if (!v.beforeSend || !1 !== v.beforeSend.call(z, s, v) && 2 !== t) {
                        $ = "abort";
                        for (r in {
                            success: 1,
                            error: 1,
                            complete: 1
                        }) s[r](v[r]);
                        if (m = P(yb, v, c, s)) {
                            s.readyState = 1;
                            u && G.trigger("ajaxSend", [s,
                                v
                            ]);
                            v.async && 0 < v.timeout && (w = setTimeout(function () {
                                s.abort("timeout")
                            }, v.timeout));
                            try {
                                t = 1, m.send(D, d)
                            } catch (M) {
                                if (!(2 > t)) throw M;
                                d(-1, M)
                            }
                        } else d(-1, "No Transport");
                        return s
                    }
                    return s.abort()
                },
                active: 0,
                lastModified: {},
                etag: {}
            });
            var Ab = [],
                hc = /\?/,
                Sa = /(=)\?(?=&|$)|\?\?/,
                ic = g.now();
            g.ajaxSetup({
                jsonp: "callback",
                jsonpCallback: function () {
                    var a = Ab.pop() || g.expando + "_" + ic++;
                    return this[a] = !0, a
                }
            });
            g.ajaxPrefilter("json jsonp", function (c, d, e) {
                var f, p, m, w = c.data,
                    h = c.url,
                    u = !1 !== c.jsonp,
                    v = u && Sa.test(h),
                    r = u && !v &&
                        "string" == typeof w && !(c.contentType || "").indexOf("application/x-www-form-urlencoded") && Sa.test(w);
                if ("jsonp" === c.dataTypes[0] || v || r) return f = c.jsonpCallback = g.isFunction(c.jsonpCallback) ? c.jsonpCallback() : c.jsonpCallback, p = b[f], v ? c.url = h.replace(Sa, "$1" + f) : r ? c.data = w.replace(Sa, "$1" + f) : u && (c.url += (hc.test(h) ? "&" : "?") + c.jsonp + "=" + f), c.converters["script json"] = function () {
                    return m || g.error(f + " was not called"), m[0]
                }, c.dataTypes[0] = "json", b[f] = function () {
                    m = arguments
                }, e.always(function () {
                    b[f] = p;
                    c[f] &&
                        (c.jsonpCallback = d.jsonpCallback, Ab.push(f));
                    m && g.isFunction(p) && p(m[0]);
                    m = p = a
                }), "script"
            });
            g.ajaxSetup({
                accepts: {
                    script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
                },
                contents: {
                    script: /javascript|ecmascript/
                },
                converters: {
                    "text script": function (a) {
                        return g.globalEval(a), a
                    }
                }
            });
            g.ajaxPrefilter("script", function (b) {
                b.cache === a && (b.cache = !1);
                b.crossDomain && (b.type = "GET", b.global = !1)
            });
            g.ajaxTransport("script", function (b) {
                if (b.crossDomain) {
                    var c, d = z.head ||
                            z.getElementsByTagName("head")[0] || z.documentElement;
                    return {
                        send: function (e, g) {
                            c = z.createElement("script");
                            c.async = "async";
                            b.scriptCharset && (c.charset = b.scriptCharset);
                            c.src = b.url;
                            c.onload = c.onreadystatechange = function (b, e) {
                                if (e || !c.readyState || /loaded|complete/.test(c.readyState)) c.onload = c.onreadystatechange = null, d && c.parentNode && d.removeChild(c), c = a, e || g(200, "success")
                            };
                            d.insertBefore(c, d.firstChild)
                        },
                        abort: function () {
                            c && c.onload(0, 1)
                        }
                    }
                }
            });
            var Ea, gb = b.ActiveXObject ? function () {
                    for (var a in Ea) Ea[a](0,
                        1)
                } : !1,
                jc = 0;
            g.ajaxSettings.xhr = b.ActiveXObject ? function () {
                var a;
                if (!(a = !this.isLocal && O())) a: {
                    try {
                        a = new b.ActiveXObject("Microsoft.XMLHTTP");
                        break a
                    } catch (c) {}
                    a = void 0
                }
                return a
            } : O;
            (function (a) {
                g.extend(g.support, {
                    ajax: !! a,
                    cors: !! a && "withCredentials" in a
                })
            })(g.ajaxSettings.xhr());
            g.support.ajax && g.ajaxTransport(function (c) {
                if (!c.crossDomain || g.support.cors) {
                    var d;
                    return {
                        send: function (e, f) {
                            var p, m, w = c.xhr();
                            c.username ? w.open(c.type, c.url, c.async, c.username, c.password) : w.open(c.type, c.url, c.async);
                            if (c.xhrFields)
                                for (m in c.xhrFields) w[m] =
                                    c.xhrFields[m];
                            c.mimeType && w.overrideMimeType && w.overrideMimeType(c.mimeType);
                            c.crossDomain || e["X-Requested-With"] || (e["X-Requested-With"] = "XMLHttpRequest");
                            try {
                                for (m in e) w.setRequestHeader(m, e[m])
                            } catch (h) {}
                            w.send(c.hasContent && c.data || null);
                            d = function (b, e) {
                                var m, h, u, v, r;
                                try {
                                    if (d && (e || 4 === w.readyState))
                                        if (d = a, p && (w.onreadystatechange = g.noop, gb && delete Ea[p]), e) 4 !== w.readyState && w.abort();
                                        else {
                                            m = w.status;
                                            u = w.getAllResponseHeaders();
                                            v = {};
                                            (r = w.responseXML) && r.documentElement && (v.xml = r);
                                            try {
                                                v.text =
                                                    w.responseText
                                            } catch (z) {}
                                            try {
                                                h = w.statusText
                                            } catch (G) {
                                                h = ""
                                            }
                                            m || !c.isLocal || c.crossDomain ? 1223 === m && (m = 204) : m = v.text ? 200 : 404
                                        }
                                } catch (T) {
                                    e || f(-1, T)
                                }
                                v && f(m, h, v, u)
                            };
                            c.async ? 4 === w.readyState ? setTimeout(d, 0) : (p = ++jc, gb && (Ea || (Ea = {}, g(b).unload(gb)), Ea[p] = d), w.onreadystatechange = d) : d()
                        },
                        abort: function () {
                            d && d(0, 1)
                        }
                    }
                }
            });
            var Aa, Ta, kc = /^(?:toggle|show|hide)$/,
                lc = RegExp("^(?:([-+])=|)(" + ua + ")([a-z%]*)$", "i"),
                mc = /queueHooks$/,
                La = [
                    function (a, b, c) {
                        var d, e, f, p, m, w, h = this,
                            u = a.style,
                            v = {}, r = [],
                            z = a.nodeType && V(a);
                        c.queue ||
                            (m = g._queueHooks(a, "fx"), null == m.unqueued && (m.unqueued = 0, w = m.empty.fire, m.empty.fire = function () {
                            m.unqueued || w()
                        }), m.unqueued++, h.always(function () {
                            h.always(function () {
                                m.unqueued--;
                                g.queue(a, "fx").length || m.empty.fire()
                            })
                        }));
                        1 === a.nodeType && ("height" in b || "width" in b) && (c.overflow = [u.overflow, u.overflowX, u.overflowY], "inline" === g.css(a, "display") && "none" === g.css(a, "float") && (g.support.inlineBlockNeedsLayout && "inline" !== t(a.nodeName) ? u.zoom = 1 : u.display = "inline-block"));
                        c.overflow && (u.overflow = "hidden",
                            g.support.shrinkWrapBlocks || h.done(function () {
                                u.overflow = c.overflow[0];
                                u.overflowX = c.overflow[1];
                                u.overflowY = c.overflow[2]
                            }));
                        for (d in b) f = b[d], kc.exec(f) && (delete b[d], e = e || "toggle" === f, f !== (z ? "hide" : "show") && r.push(d));
                        if (b = r.length)
                            for (f = g._data(a, "fxshow") || g._data(a, "fxshow", {}), ("hidden" in f) && (z = f.hidden), e && (f.hidden = !z), z ? g(a).show() : h.done(function () {
                                g(a).hide()
                            }), h.done(function () {
                                var b;
                                g.removeData(a, "fxshow", !0);
                                for (b in v) g.style(a, b, v[b])
                            }), d = 0; d < b; d++) e = r[d], p = h.createTween(e, z ? f[e] :
                                0), v[e] = f[e] || g.style(a, e), e in f || (f[e] = p.start, z && (p.end = p.start, p.start = "width" === e || "height" === e ? 1 : 0))
                    }
                ],
                Fa = {
                    "*": [
                        function (a, b) {
                            var c, d, e = this.createTween(a, b),
                                f = lc.exec(b),
                                p = e.cur(),
                                m = +p || 0,
                                w = 1,
                                h = 20;
                            if (f) {
                                c = +f[2];
                                d = f[3] || (g.cssNumber[a] ? "" : "px");
                                if ("px" !== d && m) {
                                    m = g.css(e.elem, a, !0) || c || 1;
                                    do w = w || ".5", m /= w, g.style(e.elem, a, m + d); while (w !== (w = e.cur() / p) && 1 !== w && --h)
                                }
                                e.unit = d;
                                e.start = m;
                                e.end = f[1] ? m + (f[1] + 1) * c : c
                            }
                            return e
                        }
                    ]
                };
            g.Animation = g.extend(G, {
                tweener: function (a, b) {
                    g.isFunction(a) ? (b = a, a = ["*"]) :
                        a = a.split(" ");
                    for (var c, d = 0, e = a.length; d < e; d++) c = a[d], Fa[c] = Fa[c] || [], Fa[c].unshift(b)
                },
                prefilter: function (a, b) {
                    b ? La.unshift(a) : La.push(a)
                }
            });
            g.Tween = H;
            H.prototype = {
                constructor: H,
                init: function (a, b, c, d, e, f) {
                    this.elem = a;
                    this.prop = c;
                    this.easing = e || "swing";
                    this.options = b;
                    this.start = this.now = this.cur();
                    this.end = d;
                    this.unit = f || (g.cssNumber[c] ? "" : "px")
                },
                cur: function () {
                    var a = H.propHooks[this.prop];
                    return a && a.get ? a.get(this) : H.propHooks._default.get(this)
                },
                run: function (a) {
                    var b, c = H.propHooks[this.prop];
                    return this.options.duration ? this.pos = b = g.easing[this.easing](a, this.options.duration * a, 0, 1, this.options.duration) : this.pos = b = a, this.now = (this.end - this.start) * b + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), c && c.set ? c.set(this) : H.propHooks._default.set(this), this
                }
            };
            H.prototype.init.prototype = H.prototype;
            H.propHooks = {
                _default: {
                    get: function (a) {
                        var b;
                        return null == a.elem[a.prop] || a.elem.style && null != a.elem.style[a.prop] ? (b = g.css(a.elem, a.prop, !1, ""), b && "auto" !== b ? b : 0) :
                            a.elem[a.prop]
                    },
                    set: function (a) {
                        g.fx.step[a.prop] ? g.fx.step[a.prop](a) : a.elem.style && (null != a.elem.style[g.cssProps[a.prop]] || g.cssHooks[a.prop]) ? g.style(a.elem, a.prop, a.now + a.unit) : a.elem[a.prop] = a.now
                    }
                }
            };
            H.propHooks.scrollTop = H.propHooks.scrollLeft = {
                set: function (a) {
                    a.elem.nodeType && a.elem.parentNode && (a.elem[a.prop] = a.now)
                }
            };
            g.each(["toggle", "show", "hide"], function (a, b) {
                var c = g.fn[b];
                g.fn[b] = function (d, e, f) {
                    return null == d || "boolean" == typeof d || !a && g.isFunction(d) && g.isFunction(e) ? c.apply(this, arguments) :
                        this.animate(J(b, !0), d, e, f)
                }
            });
            g.fn.extend({
                fadeTo: function (a, b, c, d) {
                    return this.filter(V).css("opacity", 0).show().end().animate({
                        opacity: b
                    }, a, c, d)
                },
                animate: function (a, b, c, d) {
                    var e = g.isEmptyObject(a),
                        f = g.speed(b, c, d);
                    b = function () {
                        var b = G(this, g.extend({}, a), f);
                        e && b.stop(!0)
                    };
                    return e || !1 === f.queue ? this.each(b) : this.queue(f.queue, b)
                },
                stop: function (b, c, d) {
                    var e = function (a) {
                        var b = a.stop;
                        delete a.stop;
                        b(d)
                    };
                    return "string" != typeof b && (d = c, c = b, b = a), c && !1 !== b && this.queue(b || "fx", []), this.each(function () {
                        var a = !0,
                            c = null != b && b + "queueHooks",
                            f = g.timers,
                            p = g._data(this);
                        if (c) p[c] && p[c].stop && e(p[c]);
                        else
                            for (c in p) p[c] && p[c].stop && mc.test(c) && e(p[c]);
                        for (c = f.length; c--;) f[c].elem !== this || null != b && f[c].queue !== b || (f[c].anim.stop(d), a = !1, f.splice(c, 1));
                        !a && d || g.dequeue(this, b)
                    })
                }
            });
            g.each({
                slideDown: J("show"),
                slideUp: J("hide"),
                slideToggle: J("toggle"),
                fadeIn: {
                    opacity: "show"
                },
                fadeOut: {
                    opacity: "hide"
                },
                fadeToggle: {
                    opacity: "toggle"
                }
            }, function (a, b) {
                g.fn[a] = function (a, c, d) {
                    return this.animate(b, a, c, d)
                }
            });
            g.speed = function (a,
                b, c) {
                var d = a && "object" == typeof a ? g.extend({}, a) : {
                    complete: c || !c && b || g.isFunction(a) && a,
                    duration: a,
                    easing: c && b || b && !g.isFunction(b) && b
                };
                d.duration = g.fx.off ? 0 : "number" == typeof d.duration ? d.duration : d.duration in g.fx.speeds ? g.fx.speeds[d.duration] : g.fx.speeds._default;
                if (null == d.queue || !0 === d.queue) d.queue = "fx";
                return d.old = d.complete, d.complete = function () {
                    g.isFunction(d.old) && d.old.call(this);
                    d.queue && g.dequeue(this, d.queue)
                }, d
            };
            g.easing = {
                linear: function (a) {
                    return a
                },
                swing: function (a) {
                    return 0.5 - Math.cos(a *
                        Math.PI) / 2
                }
            };
            g.timers = [];
            g.fx = H.prototype.init;
            g.fx.tick = function () {
                var b, c = g.timers,
                    d = 0;
                for (Aa = g.now(); d < c.length; d++) b = c[d], !b() && c[d] === b && c.splice(d--, 1);
                c.length || g.fx.stop();
                Aa = a
            };
            g.fx.timer = function (a) {
                a() && g.timers.push(a) && !Ta && (Ta = setInterval(g.fx.tick, g.fx.interval))
            };
            g.fx.interval = 13;
            g.fx.stop = function () {
                clearInterval(Ta);
                Ta = null
            };
            g.fx.speeds = {
                slow: 600,
                fast: 200,
                _default: 400
            };
            g.fx.step = {};
            g.expr && g.expr.filters && (g.expr.filters.animated = function (a) {
                return g.grep(g.timers, function (b) {
                    return a ===
                        b.elem
                }).length
            });
            var Bb = /^(?:body|html)$/i;
            g.fn.offset = function (b) {
                if (arguments.length) return b === a ? this : this.each(function (a) {
                    g.offset.setOffset(this, b, a)
                });
                var c, d, e, f, p, m, w, h = {
                        top: 0,
                        left: 0
                    }, u = this[0],
                    v = u && u.ownerDocument;
                if (v) return (d = v.body) === u ? g.offset.bodyOffset(u) : (c = v.documentElement, g.contains(c, u) ? ("undefined" != typeof u.getBoundingClientRect && (h = u.getBoundingClientRect()), e = ba(v), f = c.clientTop || d.clientTop || 0, p = c.clientLeft || d.clientLeft || 0, m = e.pageYOffset || c.scrollTop, w = e.pageXOffset ||
                    c.scrollLeft, {
                        top: h.top + m - f,
                        left: h.left + w - p
                    }) : h)
            };
            g.offset = {
                bodyOffset: function (a) {
                    var b = a.offsetTop,
                        c = a.offsetLeft;
                    return g.support.doesNotIncludeMarginInBodyOffset && (b += parseFloat(g.css(a, "marginTop")) || 0, c += parseFloat(g.css(a, "marginLeft")) || 0), {
                        top: b,
                        left: c
                    }
                },
                setOffset: function (a, b, c) {
                    var d = g.css(a, "position");
                    "static" === d && (a.style.position = "relative");
                    var e = g(a),
                        f = e.offset(),
                        p = g.css(a, "top"),
                        m = g.css(a, "left"),
                        w = {}, h = {}, u, v;
                    ("absolute" === d || "fixed" === d) && -1 < g.inArray("auto", [p, m]) ? (h = e.position(),
                            u = h.top, v = h.left) : (u = parseFloat(p) || 0, v = parseFloat(m) || 0);
                    g.isFunction(b) && (b = b.call(a, c, f));
                    null != b.top && (w.top = b.top - f.top + u);
                    null != b.left && (w.left = b.left - f.left + v);
                    "using" in b ? b.using.call(a, w) : e.css(w)
                }
            };
            g.fn.extend({
                position: function () {
                    if (this[0]) {
                        var a = this[0],
                            b = this.offsetParent(),
                            c = this.offset(),
                            d = Bb.test(b[0].nodeName) ? {
                                top: 0,
                                left: 0
                            } : b.offset();
                        return c.top -= parseFloat(g.css(a, "marginTop")) || 0, c.left -= parseFloat(g.css(a, "marginLeft")) || 0, d.top += parseFloat(g.css(b[0], "borderTopWidth")) || 0,
                        d.left += parseFloat(g.css(b[0], "borderLeftWidth")) || 0, {
                            top: c.top - d.top,
                            left: c.left - d.left
                        }
                    }
                },
                offsetParent: function () {
                    return this.map(function () {
                        for (var a = this.offsetParent || z.body; a && !Bb.test(a.nodeName) && "static" === g.css(a, "position");) a = a.offsetParent;
                        return a || z.body
                    })
                }
            });
            g.each({
                scrollLeft: "pageXOffset",
                scrollTop: "pageYOffset"
            }, function (b, c) {
                var d = /Y/.test(c);
                g.fn[b] = function (e) {
                    return g.access(this, function (b, e, f) {
                        var l = ba(b);
                        if (f === a) return l ? c in l ? l[c] : l.document.documentElement[e] : b[e];
                        l ?
                            l.scrollTo(d ? g(l).scrollLeft() : f, d ? f : g(l).scrollTop()) : b[e] = f
                    }, b, e, arguments.length, null)
                }
            });
            g.each({
                Height: "height",
                Width: "width"
            }, function (b, c) {
                g.each({
                    padding: "inner" + b,
                    content: c,
                    "": "outer" + b
                }, function (d, e) {
                    g.fn[e] = function (e, f) {
                        var p = arguments.length && (d || "boolean" != typeof e),
                            m = d || (!0 === e || !0 === f ? "margin" : "border");
                        return g.access(this, function (c, d, e) {
                            var f;
                            return g.isWindow(c) ? c.document.documentElement["client" + b] : 9 === c.nodeType ? (f = c.documentElement, Math.max(c.body["scroll" + b], f["scroll" + b],
                                c.body["offset" + b], f["offset" + b], f["client" + b])) : e === a ? g.css(c, d, e, m) : g.style(c, d, e, m)
                        }, c, p ? e : a, p, null)
                    }
                })
            });
            b.jQuery = b.$ = g;
            "function" == typeof define && define.amd && define.amd.jQuery && define("jquery", [], function () {
                return g
            })
        })(window);
        var n = h.jQuery = h.$ = window.$.noConflict(!0),
            s = n;
        n.msieVersion = function () {
            var b = -1;
            "Microsoft Internet Explorer" == navigator.appName && null != /MSIE ([0-9]{1,}[.0-9]{0,})/.exec(navigator.userAgent) && (b = parseFloat(RegExp.$1));
            return b
        };
        window.XDomainRequest && s.ajaxTransport(function (b) {
            if (b.crossDomain &&
                b.async) {
                b.timeout && (b.xdrTimeout = b.timeout, delete b.timeout);
                var a;
                return {
                    send: function (c, e) {
                        function f(b, c, d, f) {
                            a.onload = a.onerror = a.ontimeout = s.noop;
                            clearTimeout(a.timeoutPointer);
                            a = void 0;
                            e(b, c, d, f)
                        }
                        a = new XDomainRequest;
                        a.onload = function () {
                            f(200, "OK", {
                                text: a.responseText
                            }, "Content-Type: " + a.contentType)
                        };
                        a.onerror = function () {
                            f(404, "Not Found")
                        };
                        a.onprogress = s.noop;
                        a.ontimeout = function () {
                            f(0, "timeout")
                        };
                        a.timeoutPointer = setTimeout(function () {
                            a.ontimeout()
                        }, b.xdrTimeout || 5E3);
                        a.timeout = b.xdrTimeout ||
                            Number.MAX_VALUE;
                        a.open(b.type, b.url);
                        a.send(b.hasContent && b.data || null)
                    },
                    abort: function () {
                        a && (a.onerror = s.noop, a.abort())
                    }
                }
            }
        });
        (function (b) {
            b.extend(b.fn, {
                validate: function (a) {
                    if (this.length) {
                        var c = b.data(this[0], "validator");
                        return c ? c : (this.attr("novalidate", "novalidate"), c = new b.validator(a, this[0]), b.data(this[0], "validator", c), c.settings.onsubmit && (this.validateDelegate(":submit", "click", function (a) {
                            c.settings.submitHandler && (c.submitButton = a.target);
                            b(a.target).hasClass("cancel") && (c.cancelSubmit = !0)
                        }), this.submit(function (a) {
                            function f() {
                                var f;
                                return c.settings.submitHandler ? (c.submitButton && (f = b("<input type='hidden'/>").attr("name", c.submitButton.name).val(c.submitButton.value).appendTo(c.currentForm)), c.settings.submitHandler.call(c, c.currentForm, a), c.submitButton && f.remove(), !1) : !0
                            }
                            return c.settings.debug && a.preventDefault(), c.cancelSubmit ? (c.cancelSubmit = !1, f()) : c.form() ? c.pendingRequest ? (c.formSubmitted = !0, !1) : f() : (c.focusInvalid(), !1)
                        })), c)
                    }
                    a && a.debug && window.console && console.warn("Nothing selected, can't validate, returning nothing.")
                },
                valid: function () {
                    if (b(this[0]).is("form")) return this.validate().form();
                    var a = !0,
                        c = b(this[0].form).validate();
                    return this.each(function () {
                        a &= c.element(this)
                    }), a
                },
                removeAttrs: function (a) {
                    var c = {}, e = this;
                    return b.each(a.split(/\s/), function (a, b) {
                        c[b] = e.attr(b);
                        e.removeAttr(b)
                    }), c
                },
                rules: function (a, c) {
                    var e = this[0];
                    if (a) {
                        var f = b.data(e.form, "validator").settings,
                            h = f.rules,
                            m = b.validator.staticRules(e);
                        switch (a) {
                        case "add":
                            b.extend(m, b.validator.normalizeRule(c));
                            h[e.name] = m;
                            c.messages && (f.messages[e.name] =
                                b.extend(f.messages[e.name], c.messages));
                            break;
                        case "remove":
                            if (!c) return delete h[e.name], m;
                            var r = {};
                            return b.each(c.split(/\s/), function (a, b) {
                                r[b] = m[b];
                                delete m[b]
                            }), r
                        }
                    }
                    e = b.validator.normalizeRules(b.extend({}, b.validator.classRules(e), b.validator.attributeRules(e), b.validator.dataRules(e), b.validator.staticRules(e)), e);
                    e.required && (f = e.required, delete e.required, e = b.extend({
                        required: f
                    }, e));
                    return e
                }
            });
            b.extend(b.expr[":"], {
                blank: function (a) {
                    return !b.trim("" + a.value)
                },
                filled: function (a) {
                    return !!b.trim("" +
                        a.value)
                },
                unchecked: function (a) {
                    return !a.checked
                }
            });
            b.validator = function (a, c) {
                this.settings = b.extend(!0, {}, b.validator.defaults, a);
                this.currentForm = c;
                this.init()
            };
            b.validator.format = function (a, c) {
                return 1 === arguments.length ? function () {
                    var c = b.makeArray(arguments);
                    return c.unshift(a), b.validator.format.apply(this, c)
                } : (2 < arguments.length && c.constructor !== Array && (c = b.makeArray(arguments).slice(1)), c.constructor !== Array && (c = [c]), b.each(c, function (b, c) {
                        a = a.replace(RegExp("\\{" + b + "\\}", "g"), function () {
                            return c
                        })
                    }),
                    a)
            };
            b.extend(b.validator, {
                defaults: {
                    messages: {},
                    groups: {},
                    rules: {},
                    errorClass: "error",
                    validClass: "valid",
                    errorElement: "label",
                    focusInvalid: !0,
                    errorContainer: b([]),
                    errorLabelContainer: b([]),
                    onsubmit: !0,
                    ignore: ":hidden",
                    ignoreTitle: !1,
                    onfocusin: function (a, b) {
                        this.lastActive = a;
                        this.settings.focusCleanup && !this.blockFocusCleanup && (this.settings.unhighlight && this.settings.unhighlight.call(this, a, this.settings.errorClass, this.settings.validClass), this.addWrapper(this.errorsFor(a)).hide())
                    },
                    onfocusout: function (a,
                        b) {
                        !this.checkable(a) && (a.name in this.submitted || !this.optional(a)) && this.element(a)
                    },
                    onkeyup: function (a, b) {
                        (9 !== b.which || "" !== this.elementValue(a)) && (a.name in this.submitted || a === this.lastElement) && this.element(a)
                    },
                    onclick: function (a, b) {
                        a.name in this.submitted ? this.element(a) : a.parentNode.name in this.submitted && this.element(a.parentNode)
                    },
                    highlight: function (a, c, e) {
                        "radio" === a.type ? this.findByName(a.name).addClass(c).removeClass(e) : b(a).addClass(c).removeClass(e)
                    },
                    unhighlight: function (a, c, e) {
                        "radio" ===
                            a.type ? this.findByName(a.name).removeClass(c).addClass(e) : b(a).removeClass(c).addClass(e)
                    }
                },
                setDefaults: function (a) {
                    b.extend(b.validator.defaults, a)
                },
                messages: {
                    required: "This field is required.",
                    remote: "Please fix this field.",
                    email: "Please enter a valid email address.",
                    url: "Please enter a valid URL.",
                    date: "Please enter a valid date.",
                    dateISO: "Please enter a valid date (ISO).",
                    number: "Please enter a valid number.",
                    digits: "Please enter only digits.",
                    creditcard: "Please enter a valid credit card number.",
                    equalTo: "Please enter the same value again.",
                    maxlength: b.validator.format("Please enter no more than {0} characters."),
                    minlength: b.validator.format("Please enter at least {0} characters."),
                    rangelength: b.validator.format("Please enter a value between {0} and {1} characters long."),
                    range: b.validator.format("Please enter a value between {0} and {1}."),
                    max: b.validator.format("Please enter a value less than or equal to {0}."),
                    min: b.validator.format("Please enter a value greater than or equal to {0}.")
                },
                autoCreateRanges: !1,
                prototype: {
                    init: function () {
                        function a(a) {
                            var c = b.data(this[0].form, "validator"),
                                d = "on" + a.type.replace(/^validate/, "");
                            c.settings[d] && c.settings[d].call(c, this[0], a)
                        }
                        this.labelContainer = b(this.settings.errorLabelContainer);
                        this.errorContext = this.labelContainer.length && this.labelContainer || b(this.currentForm);
                        this.containers = b(this.settings.errorContainer).add(this.settings.errorLabelContainer);
                        this.submitted = {};
                        this.valueCache = {};
                        this.pendingRequest = 0;
                        this.pending = {};
                        this.invalid = {};
                        this.reset();
                        var c = this.groups = {};
                        b.each(this.settings.groups, function (a, e) {
                            "string" == typeof e && (e = e.split(/\s/));
                            b.each(e, function (b, e) {
                                c[e] = a
                            })
                        });
                        var e = this.settings.rules;
                        b.each(e, function (a, c) {
                            e[a] = b.validator.normalizeRule(c)
                        });
                        b(this.currentForm).validateDelegate(":text, [type='password'], [type='file'], select, textarea, [type='number'], [type='search'] ,[type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'] ",
                            "focusin focusout keyup", a).validateDelegate("[type='radio'], [type='checkbox'], select, option", "click", a);
                        this.settings.invalidHandler && b(this.currentForm).bind("invalid-form.validate", this.settings.invalidHandler)
                    },
                    form: function () {
                        return this.checkForm(), b.extend(this.submitted, this.errorMap), this.invalid = b.extend({}, this.errorMap), this.valid() || b(this.currentForm).triggerHandler("invalid-form", [this]), this.showErrors(), this.valid()
                    },
                    checkForm: function () {
                        this.prepareForm();
                        for (var a = 0, b = this.currentElements =
                                this.elements(); b[a]; a++) this.check(b[a]);
                        return this.valid()
                    },
                    element: function (a) {
                        this.lastElement = a = this.validationTargetFor(this.clean(a));
                        this.prepareElement(a);
                        this.currentElements = b(a);
                        var c = !1 !== this.check(a);
                        return c ? delete this.invalid[a.name] : this.invalid[a.name] = !0, this.numberOfInvalids() || (this.toHide = this.toHide.add(this.containers)), this.showErrors(), c
                    },
                    showErrors: function (a) {
                        if (a) {
                            b.extend(this.errorMap, a);
                            this.errorList = [];
                            for (var c in a) this.errorList.push({
                                message: a[c],
                                element: this.findByName(c)[0]
                            });
                            this.successList = b.grep(this.successList, function (b) {
                                return !(b.name in a)
                            })
                        }
                        this.settings.showErrors ? this.settings.showErrors.call(this, this.errorMap, this.errorList) : this.defaultShowErrors()
                    },
                    resetForm: function () {
                        b.fn.resetForm && b(this.currentForm).resetForm();
                        this.submitted = {};
                        this.lastElement = null;
                        this.prepareForm();
                        this.hideErrors();
                        this.elements().removeClass(this.settings.errorClass).removeData("previousValue")
                    },
                    numberOfInvalids: function () {
                        return this.objectLength(this.invalid)
                    },
                    objectLength: function (a) {
                        var b =
                            0,
                            c;
                        for (c in a) b++;
                        return b
                    },
                    hideErrors: function () {
                        this.addWrapper(this.toHide).hide()
                    },
                    valid: function () {
                        return 0 === this.size()
                    },
                    size: function () {
                        return this.errorList.length
                    },
                    focusInvalid: function () {
                        if (this.settings.focusInvalid) try {
                            b(this.findLastActive() || this.errorList.length && this.errorList[0].element || []).filter(":visible").focus().trigger("focusin")
                        } catch (a) {}
                    },
                    findLastActive: function () {
                        var a = this.lastActive;
                        return a && 1 === b.grep(this.errorList, function (b) {
                            return b.element.name === a.name
                        }).length &&
                            a
                    },
                    elements: function () {
                        var a = this,
                            c = {};
                        return b(this.currentForm).find("input, select, textarea").not(":submit, :reset, :image, [disabled]").not(this.settings.ignore).filter(function () {
                            return !this.name && a.settings.debug && window.console && console.error("%o has no name assigned", this), this.name in c || !a.objectLength(b(this).rules()) ? !1 : (c[this.name] = !0, !0)
                        })
                    },
                    clean: function (a) {
                        return b(a)[0]
                    },
                    errors: function () {
                        var a = this.settings.errorClass.replace(" ", ".");
                        return b(this.settings.errorElement + "." + a,
                            this.errorContext)
                    },
                    reset: function () {
                        this.successList = [];
                        this.errorList = [];
                        this.errorMap = {};
                        this.toShow = b([]);
                        this.toHide = b([]);
                        this.currentElements = b([])
                    },
                    prepareForm: function () {
                        this.reset();
                        this.toHide = this.errors().add(this.containers)
                    },
                    prepareElement: function (a) {
                        this.reset();
                        this.toHide = this.errorsFor(a)
                    },
                    elementValue: function (a) {
                        var c = b(a).attr("type"),
                            e = b(a).val();
                        return "radio" === c || "checkbox" === c ? b("input[name='" + b(a).attr("name") + "']:checked").val() : "string" == typeof e ? e.replace(/\r/g, "") :
                            e
                    },
                    check: function (a) {
                        a = this.validationTargetFor(this.clean(a));
                        var c = b(a).rules(),
                            e = !1,
                            f = this.elementValue(a),
                            h, m;
                        for (m in c) {
                            var r = {
                                method: m,
                                parameters: c[m]
                            };
                            try {
                                if (h = b.validator.methods[m].call(this, f, a, r.parameters), "dependency-mismatch" === h) e = !0;
                                else {
                                    e = !1;
                                    if ("pending" === h) {
                                        this.toHide = this.toHide.not(this.errorsFor(a));
                                        return
                                    }
                                    if (!h) return this.formatAndAdd(a, r), !1
                                }
                            } catch (u) {
                                throw this.settings.debug && window.console && console.log("Exception occured when checking element " + a.id + ", check the '" + r.method +
                                    "' method.", u), u;
                            }
                        }
                        if (!e) return this.objectLength(c) && this.successList.push(a), !0
                    },
                    customDataMessage: function (a, c) {
                        return b(a).data("msg-" + c.toLowerCase()) || a.attributes && b(a).attr("data-msg-" + c.toLowerCase())
                    },
                    customMessage: function (a, b) {
                        var c = this.settings.messages[a];
                        return c && (c.constructor === String ? c : c[b])
                    },
                    findDefined: function () {
                        for (var a = 0; a < arguments.length; a++)
                            if (void 0 !== arguments[a]) return arguments[a]
                    },
                    defaultMessage: function (a, c) {
                        return this.findDefined(this.customMessage(a.name, c), this.customDataMessage(a,
                            c), !this.settings.ignoreTitle && a.title || void 0, b.validator.messages[c], "<strong>Warning: No message defined for " + a.name + "</strong>")
                    },
                    formatAndAdd: function (a, c) {
                        var e = this.defaultMessage(a, c.method),
                            f = /\$?\{(\d+)\}/g;
                        "function" == typeof e ? e = e.call(this, c.parameters, a) : f.test(e) && (e = b.validator.format(e.replace(f, "{$1}"), c.parameters));
                        this.errorList.push({
                            message: e,
                            element: a
                        });
                        this.errorMap[a.name] = e;
                        this.submitted[a.name] = e
                    },
                    addWrapper: function (a) {
                        return this.settings.wrapper && (a = a.add(a.parent(this.settings.wrapper))),
                        a
                    },
                    defaultShowErrors: function () {
                        var a, b;
                        for (a = 0; this.errorList[a]; a++) b = this.errorList[a], this.settings.highlight && this.settings.highlight.call(this, b.element, this.settings.errorClass, this.settings.validClass), this.showLabel(b.element, b.message);
                        this.errorList.length && (this.toShow = this.toShow.add(this.containers));
                        if (this.settings.success)
                            for (a = 0; this.successList[a]; a++) this.showLabel(this.successList[a]);
                        if (this.settings.unhighlight)
                            for (a = 0, b = this.validElements(); b[a]; a++) this.settings.unhighlight.call(this,
                                b[a], this.settings.errorClass, this.settings.validClass);
                        this.toHide = this.toHide.not(this.toShow);
                        this.hideErrors();
                        this.addWrapper(this.toShow).show()
                    },
                    validElements: function () {
                        return this.currentElements.not(this.invalidElements())
                    },
                    invalidElements: function () {
                        return b(this.errorList).map(function () {
                            return this.element
                        })
                    },
                    showLabel: function (a, c) {
                        var e = this.errorsFor(a);
                        e.length ? (e.removeClass(this.settings.validClass).addClass(this.settings.errorClass), e.html(c)) : (e = b("<" + this.settings.errorElement +
                            ">").attr("for", this.idOrName(a)).addClass(this.settings.errorClass).html(c || ""), this.settings.wrapper && (e = e.hide().show().wrap("<" + this.settings.wrapper + "/>").parent()), this.labelContainer.append(e).length || (this.settings.errorPlacement ? this.settings.errorPlacement(e, b(a)) : e.insertAfter(a)));
                        !c && this.settings.success && (e.text(""), "string" == typeof this.settings.success ? e.addClass(this.settings.success) : this.settings.success(e, a));
                        this.toShow = this.toShow.add(e)
                    },
                    errorsFor: function (a) {
                        var c = this.idOrName(a);
                        return this.errors().filter(function () {
                            return b(this).attr("for") === c
                        })
                    },
                    idOrName: function (a) {
                        return this.groups[a.name] || (this.checkable(a) ? a.name : a.id || a.name)
                    },
                    validationTargetFor: function (a) {
                        return this.checkable(a) && (a = this.findByName(a.name).not(this.settings.ignore)[0]), a
                    },
                    checkable: function (a) {
                        return /radio|checkbox/i.test(a.type)
                    },
                    findByName: function (a) {
                        return b(this.currentForm).find("[name='" + a + "']")
                    },
                    getLength: function (a, c) {
                        switch (c.nodeName.toLowerCase()) {
                        case "select":
                            return b("option:selected",
                                c).length;
                        case "input":
                            if (this.checkable(c)) return this.findByName(c.name).filter(":checked").length
                        }
                        return a.length
                    },
                    depend: function (a, b) {
                        return this.dependTypes[typeof a] ? this.dependTypes[typeof a](a, b) : !0
                    },
                    dependTypes: {
                        "boolean": function (a, b) {
                            return a
                        },
                        string: function (a, c) {
                            return !!b(a, c.form).length
                        },
                        "function": function (a, b) {
                            return a(b)
                        }
                    },
                    optional: function (a) {
                        var c = this.elementValue(a);
                        return !b.validator.methods.required.call(this, c, a) && "dependency-mismatch"
                    },
                    startRequest: function (a) {
                        this.pending[a.name] ||
                            (this.pendingRequest++, this.pending[a.name] = !0)
                    },
                    stopRequest: function (a, c) {
                        this.pendingRequest--;
                        0 > this.pendingRequest && (this.pendingRequest = 0);
                        delete this.pending[a.name];
                        c && 0 === this.pendingRequest && this.formSubmitted && this.form() ? (b(this.currentForm).submit(), this.formSubmitted = !1) : !c && 0 === this.pendingRequest && this.formSubmitted && (b(this.currentForm).triggerHandler("invalid-form", [this]), this.formSubmitted = !1)
                    },
                    previousValue: function (a) {
                        return b.data(a, "previousValue") || b.data(a, "previousValue", {
                            old: null,
                            valid: !0,
                            message: this.defaultMessage(a, "remote")
                        })
                    }
                },
                classRuleSettings: {
                    required: {
                        required: !0
                    },
                    email: {
                        email: !0
                    },
                    url: {
                        url: !0
                    },
                    date: {
                        date: !0
                    },
                    dateISO: {
                        dateISO: !0
                    },
                    number: {
                        number: !0
                    },
                    digits: {
                        digits: !0
                    },
                    creditcard: {
                        creditcard: !0
                    }
                },
                addClassRules: function (a, c) {
                    a.constructor === String ? this.classRuleSettings[a] = c : b.extend(this.classRuleSettings, a)
                },
                classRules: function (a) {
                    var c = {};
                    a = b(a).attr("class");
                    return a && b.each(a.split(" "), function () {
                        this in b.validator.classRuleSettings && b.extend(c, b.validator.classRuleSettings[this])
                    }),
                    c
                },
                attributeRules: function (a) {
                    var c = {};
                    a = b(a);
                    for (var e in b.validator.methods) {
                        var f;
                        "required" === e ? (f = a.get(0).getAttribute(e), "" === f && (f = !0), f = !! f) : f = a.attr(e);
                        f ? c[e] = f : a[0].getAttribute("type") === e && (c[e] = !0)
                    }
                    return c.maxlength && /-1|2147483647|524288/.test(c.maxlength) && delete c.maxlength, c
                },
                dataRules: function (a) {
                    var c, e = {}, f = b(a);
                    for (c in b.validator.methods) a = f.data("rule-" + c.toLowerCase()), void 0 !== a && (e[c] = a);
                    return e
                },
                staticRules: function (a) {
                    var c = {}, e = b.data(a.form, "validator");
                    return e.settings.rules &&
                        (c = b.validator.normalizeRule(e.settings.rules[a.name]) || {}), c
                },
                normalizeRules: function (a, c) {
                    return b.each(a, function (e, f) {
                        if (!1 === f) delete a[e];
                        else if (f.param || f.depends) {
                            var h = !0;
                            switch (typeof f.depends) {
                            case "string":
                                h = !! b(f.depends, c.form).length;
                                break;
                            case "function":
                                h = f.depends.call(c, c)
                            }
                            h ? a[e] = void 0 !== f.param ? f.param : !0 : delete a[e]
                        }
                    }), b.each(a, function (e, f) {
                        a[e] = b.isFunction(f) ? f(c) : f
                    }), b.each(["minlength", "maxlength"], function () {
                        a[this] && (a[this] = Number(a[this]))
                    }), b.each(["rangelength"],
                        function () {
                            var c;
                            a[this] && (b.isArray(a[this]) ? a[this] = [Number(a[this][0]), Number(a[this][1])] : "string" == typeof a[this] && (c = a[this].split(/[\s,]+/), a[this] = [Number(c[0]), Number(c[1])]))
                        }), b.validator.autoCreateRanges && (a.min && a.max && (a.range = [a.min, a.max], delete a.min, delete a.max), a.minlength && a.maxlength && (a.rangelength = [a.minlength, a.maxlength], delete a.minlength, delete a.maxlength)), a
                },
                normalizeRule: function (a) {
                    if ("string" == typeof a) {
                        var c = {};
                        b.each(a.split(/\s/), function () {
                            c[this] = !0
                        });
                        a = c
                    }
                    return a
                },
                addMethod: function (a, c, e) {
                    b.validator.methods[a] = c;
                    b.validator.messages[a] = void 0 !== e ? e : b.validator.messages[a];
                    3 > c.length && b.validator.addClassRules(a, b.validator.normalizeRule(a))
                },
                methods: {
                    required: function (a, c, e) {
                        return this.depend(e, c) ? "select" === c.nodeName.toLowerCase() ? (a = b(c).val()) && 0 < a.length : this.checkable(c) ? 0 < this.getLength(a, c) : 0 < b.trim(a).length : "dependency-mismatch"
                    },
                    remote: function (a, c, e) {
                        if (this.optional(c)) return "dependency-mismatch";
                        var f = this.previousValue(c);
                        this.settings.messages[c.name] ||
                            (this.settings.messages[c.name] = {});
                        f.originalMessage = this.settings.messages[c.name].remote;
                        this.settings.messages[c.name].remote = f.message;
                        e = "string" == typeof e && {
                            url: e
                        } || e;
                        if (f.old === a) return f.valid;
                        f.old = a;
                        var h = this;
                        this.startRequest(c);
                        var m = {};
                        return m[c.name] = a, b.ajax(b.extend(!0, {
                            url: e,
                            mode: "abort",
                            port: "validate" + c.name,
                            dataType: "json",
                            data: m,
                            success: function (e) {
                                h.settings.messages[c.name].remote = f.originalMessage;
                                var m = !0 === e || "true" === e;
                                if (m) {
                                    var D = h.formSubmitted;
                                    h.prepareElement(c);
                                    h.formSubmitted =
                                        D;
                                    h.successList.push(c);
                                    delete h.invalid[c.name];
                                    h.showErrors()
                                } else D = {}, e = e || h.defaultMessage(c, "remote"), D[c.name] = f.message = b.isFunction(e) ? e(a) : e, h.invalid[c.name] = !0, h.showErrors(D);
                                f.valid = m;
                                h.stopRequest(c, m)
                            }
                        }, e)), "pending"
                    },
                    minlength: function (a, c, e) {
                        a = b.isArray(a) ? a.length : this.getLength(b.trim(a), c);
                        return this.optional(c) || a >= e
                    },
                    maxlength: function (a, c, e) {
                        a = b.isArray(a) ? a.length : this.getLength(b.trim(a), c);
                        return this.optional(c) || a <= e
                    },
                    rangelength: function (a, c, e) {
                        a = b.isArray(a) ? a.length :
                            this.getLength(b.trim(a), c);
                        return this.optional(c) || a >= e[0] && a <= e[1]
                    },
                    min: function (a, b, c) {
                        return this.optional(b) || a >= c
                    },
                    max: function (a, b, c) {
                        return this.optional(b) || a <= c
                    },
                    range: function (a, b, c) {
                        return this.optional(b) || a >= c[0] && a <= c[1]
                    },
                    email: function (a, b) {
                        return this.optional(b) || /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(a)
                    },
                    url: function (a, b) {
                        return this.optional(b) || /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(a)
                    },
                    date: function (a, b) {
                        return this.optional(b) || !/Invalid|NaN/.test((new Date(a)).toString())
                    },
                    dateISO: function (a, b) {
                        return this.optional(b) || /^\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}$/.test(a)
                    },
                    number: function (a, b) {
                        return this.optional(b) || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(a)
                    },
                    digits: function (a, b) {
                        return this.optional(b) || /^\d+$/.test(a)
                    },
                    creditcard: function (a, b) {
                        if (this.optional(b)) return "dependency-mismatch";
                        if (/[^0-9 \-]+/.test(a)) return !1;
                        var c = 0,
                            f = 0,
                            h = !1;
                        a = a.replace(/\D/g, "");
                        for (var m = a.length -
                            1; 0 <= m; m--) f = a.charAt(m), f = parseInt(f, 10), h && 9 < (f *= 2) && (f -= 9), c += f, h = !h;
                        return 0 === c % 10
                    },
                    equalTo: function (a, c, e) {
                        e = b(e);
                        return this.settings.onfocusout && e.unbind(".validate-equalTo").bind("blur.validate-equalTo", function () {
                            b(c).valid()
                        }), a === e.val()
                    }
                }
            });
            b.format = b.validator.format
        })(s);
        (function (b) {
            var a = {};
            if (b.ajaxPrefilter) b.ajaxPrefilter(function (b, c, d) {
                c = b.port;
                "abort" === b.mode && (a[c] && a[c].abort(), a[c] = d)
            });
            else {
                var c = b.ajax;
                b.ajax = function (e) {
                    var f = ("port" in e ? e : b.ajaxSettings).port;
                    return "abort" ===
                        ("mode" in e ? e : b.ajaxSettings).mode ? (a[f] && a[f].abort(), a[f] = c.apply(this, arguments)) : c.apply(this, arguments)
                }
            }
        })(s);
        (function (b) {
            b.extend(b.fn, {
                validateDelegate: function (a, c, e) {
                    return this.bind(c, function (c) {
                        var d = b(c.target);
                        if (d.is(a)) return e.apply(d, arguments)
                    })
                }
            })
        })(s);
        var q, c;
        q = c = h.JSON = {};
        (function (b) {
            function a(a) {
                if ("bug-string-char-index" == a) return "a" != "a" [0];
                var b, e = "json" == a;
                if (e || "json-stringify" == a || "json-parse" == a) {
                    if ("json-stringify" == a || e) {
                        var f = q.stringify,
                            u = "function" == typeof f &&
                                m;
                        if (u) {
                            (b = function () {
                                return 1
                            }).toJSON = b;
                            try {
                                u = "0" === f(0) && "0" === f(new Number) && '""' == f(new String) && f(c) === h && f(h) === h && f() === h && "1" === f(b) && "[1]" == f([b]) && "[null]" == f([h]) && "null" == f(null) && "[null,null,null]" == f([h, c, null]) && '{"a":[1,true,false,null,"\\u0000\\b\\n\\f\\r\\t"]}' == f({
                                    a: [b, !0, !1, null, "\x00\b\n\f\r\t"]
                                }) && "1" === f(null, b) && "[\n 1,\n 2\n]" == f([1, 2], null, 1) && '"-271821-04-20T00:00:00.000Z"' == f(new Date(-864E13)) && '"+275760-09-13T00:00:00.000Z"' == f(new Date(864E13)) && '"-000001-01-01T00:00:00.000Z"' ==
                                    f(new Date(-621987552E5)) && '"1969-12-31T23:59:59.999Z"' == f(new Date(-1))
                            } catch (r) {
                                u = !1
                            }
                        }
                        if (!e) return u
                    }
                    if ("json-parse" == a || e) {
                        a = q.parse;
                        if ("function" == typeof a) try {
                            if (0 === a("0") && !a(!1)) {
                                b = a('{"a":[1,true,false,null,"\\u0000\\b\\n\\f\\r\\t"]}');
                                var D = 5 == b.a.length && 1 === b.a[0];
                                if (D) {
                                    try {
                                        D = !a('"\t"')
                                    } catch (n) {}
                                    if (D) try {
                                        D = 1 !== a("01")
                                    } catch (A) {}
                                }
                            }
                        } catch (p) {
                            D = !1
                        }
                        if (!e) return D
                    }
                    return u && D
                }
            }
            var c = {}.toString,
                e, f, h, m = new Date(-0xc782b5b800cec);
            try {
                m = -109252 == m.getUTCFullYear() && 0 === m.getUTCMonth() && 1 ===
                    m.getUTCDate() && 10 == m.getUTCHours() && 37 == m.getUTCMinutes() && 6 == m.getUTCSeconds() && 708 == m.getUTCMilliseconds()
            } catch (r) {}
            if (!a("json")) {
                var u = a("bug-string-char-index");
                if (!m) var D = Math.floor,
                n = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334], s = function (a, b) {
                    return n[b] + 365 * (a - 1970) + D((a - 1969 + (b = +(1 < b))) / 4) - D((a - 1901 + b) / 100) + D((a - 1601 + b) / 400)
                };
                (e = {}.hasOwnProperty) || (e = function (a) {
                    var b = {}, f;
                    (b.__proto__ = null, b.__proto__ = {
                        toString: 1
                    }, b).toString != c ? e = function (a) {
                        var b = this.__proto__;
                        a = a in (this.__proto__ =
                            null, this);
                        this.__proto__ = b;
                        return a
                    } : (f = b.constructor, e = function (a) {
                        var b = (this.constructor || f).prototype;
                        return a in this && !(a in b && this[a] === b[a])
                    });
                    b = null;
                    return e.call(this, a)
                });
                var y = {
                    "boolean": 1,
                    number: 1,
                    string: 1,
                    undefined: 1
                };
                f = function (a, b) {
                    var f = 0,
                        m, h, u;
                    (m = function () {
                        this.valueOf = 0
                    }).prototype.valueOf = 0;
                    h = new m;
                    for (u in h) e.call(h, u) && f++;
                    m = h = null;
                    f ? f = 2 == f ? function (a, b) {
                        var f = {}, p = "[object Function]" == c.call(a),
                            m;
                        for (m in a) p && "prototype" == m || (e.call(f, m) || !(f[m] = 1) || !e.call(a, m)) || b(m)
                    } :
                        function (a, b) {
                            var f = "[object Function]" == c.call(a),
                                p, m;
                            for (p in a) f && "prototype" == p || (!e.call(a, p) || (m = "constructor" === p)) || b(p);
                            (m || e.call(a, p = "constructor")) && b(p)
                    } : (h = "valueOf toString toLocaleString propertyIsEnumerable isPrototypeOf hasOwnProperty constructor".split(" "), f = function (a, b) {
                        var f = "[object Function]" == c.call(a),
                            p, m;
                        if (m = !f)
                            if (m = "function" != typeof a.constructor) m = typeof a.hasOwnProperty, m = "object" == m ? !! a.hasOwnProperty : !y[m];
                        m = m ? a.hasOwnProperty : e;
                        for (p in a) f && "prototype" == p || !m.call(a,
                            p) || b(p);
                        for (f = h.length; p = h[--f]; m.call(a, p) && b(p));
                    });
                    return f(a, b)
                };
                if (!a("json-stringify")) {
                    var x = {
                        92: "\\\\",
                        34: '\\"',
                        8: "\\b",
                        12: "\\f",
                        10: "\\n",
                        13: "\\r",
                        9: "\\t"
                    }, A = function (a, b) {
                            return ("000000" + (b || 0)).slice(-a)
                        }, E = function (a) {
                            var b = '"',
                                c = 0,
                                d = a.length,
                                e = 10 < d && u,
                                f;
                            for (e && (f = a.split("")); c < d; c++) {
                                var m = a.charCodeAt(c);
                                switch (m) {
                                case 8:
                                case 9:
                                case 10:
                                case 12:
                                case 13:
                                case 34:
                                case 92:
                                    b += x[m];
                                    break;
                                default:
                                    if (32 > m) {
                                        b += "\\u00" + A(2, m.toString(16));
                                        break
                                    }
                                    b += e ? f[c] : u ? a.charAt(c) : a[c]
                                }
                            }
                            return b + '"'
                        }, V = function (a,
                            b, m, u, r, n, t) {
                            var q = b[a],
                                y, p, z, M, ca, U, x, F, B;
                            try {
                                q = b[a]
                            } catch (ea) {}
                            if ("object" == typeof q && q)
                                if (y = c.call(q), "[object Date]" != y || e.call(q, "toJSON")) "function" == typeof q.toJSON && ("[object Number]" != y && "[object String]" != y && "[object Array]" != y || e.call(q, "toJSON")) && (q = q.toJSON(a));
                                else if (q > -1 / 0 && q < 1 / 0) {
                                if (s) {
                                    z = D(q / 864E5);
                                    for (y = D(z / 365.2425) + 1970 - 1; s(y + 1, 0) <= z; y++);
                                    for (p = D((z - s(y, 0)) / 30.42); s(y, p + 1) <= z; p++);
                                    z = 1 + z - s(y, p);
                                    M = (q % 864E5 + 864E5) % 864E5;
                                    ca = D(M / 36E5) % 24;
                                    U = D(M / 6E4) % 60;
                                    x = D(M / 1E3) % 60;
                                    M %= 1E3
                                } else y = q.getUTCFullYear(),
                                p = q.getUTCMonth(), z = q.getUTCDate(), ca = q.getUTCHours(), U = q.getUTCMinutes(), x = q.getUTCSeconds(), M = q.getUTCMilliseconds();
                                q = (0 >= y || 1E4 <= y ? (0 > y ? "-" : "+") + A(6, 0 > y ? -y : y) : A(4, y)) + "-" + A(2, p + 1) + "-" + A(2, z) + "T" + A(2, ca) + ":" + A(2, U) + ":" + A(2, x) + "." + A(3, M) + "Z"
                            } else q = null;
                            m && (q = m.call(b, a, q));
                            if (null === q) return "null";
                            y = c.call(q);
                            if ("[object Boolean]" == y) return "" + q;
                            if ("[object Number]" == y) return q > -1 / 0 && q < 1 / 0 ? "" + q : "null";
                            if ("[object String]" == y) return E("" + q);
                            if ("object" == typeof q) {
                                for (a = t.length; a--;)
                                    if (t[a] === q) throw TypeError();
                                t.push(q);
                                F = [];
                                b = n;
                                n += r;
                                if ("[object Array]" == y) {
                                    p = 0;
                                    for (a = q.length; p < a; B || (B = !0), p++) y = V(p, q, m, u, r, n, t), F.push(y === h ? "null" : y);
                                    a = B ? r ? "[\n" + n + F.join(",\n" + n) + "\n" + b + "]" : "[" + F.join(",") + "]" : "[]"
                                } else f(u || q, function (a) {
                                    var b = V(a, q, m, u, r, n, t);
                                    b !== h && F.push(E(a) + ":" + (r ? " " : "") + b);
                                    B || (B = !0)
                                }), a = B ? r ? "{\n" + n + F.join(",\n" + n) + "\n" + b + "}" : "{" + F.join(",") + "}" : "{}";
                                t.pop();
                                return a
                            }
                        };
                    q.stringify = function (a, b, e) {
                        var f, m, h;
                        if ("function" == typeof b || "object" == typeof b && b)
                            if ("[object Function]" == c.call(b)) m = b;
                            else if ("[object Array]" ==
                            c.call(b)) {
                            h = {};
                            for (var u = 0, v = b.length, r; u < v; r = b[u++], ("[object String]" == c.call(r) || "[object Number]" == c.call(r)) && (h[r] = 1));
                        }
                        if (e)
                            if ("[object Number]" == c.call(e)) {
                                if (0 < (e -= e % 1))
                                    for (f = "", 10 < e && (e = 10); f.length < e; f += " ");
                            } else "[object String]" == c.call(e) && (f = 10 >= e.length ? e : e.slice(0, 10));
                        return V("", (r = {}, r[""] = a, r), m, h, f, "", [])
                    }
                }
                if (!a("json-parse")) {
                    var F = String.fromCharCode,
                        X = {
                            92: "\\",
                            34: '"',
                            47: "/",
                            98: "\b",
                            116: "\t",
                            110: "\n",
                            102: "\f",
                            114: "\r"
                        }, B, C, t = function () {
                            B = C = null;
                            throw SyntaxError();
                        }, I = function () {
                            for (var a =
                                C, b = a.length, c, d, e, f, m; B < b;) switch (m = a.charCodeAt(B), m) {
                            case 9:
                            case 10:
                            case 13:
                            case 32:
                                B++;
                                break;
                            case 123:
                            case 125:
                            case 91:
                            case 93:
                            case 58:
                            case 44:
                                return c = u ? a.charAt(B) : a[B], B++, c;
                            case 34:
                                c = "@";
                                for (B++; B < b;)
                                    if (m = a.charCodeAt(B), 32 > m) t();
                                    else if (92 == m) switch (m = a.charCodeAt(++B), m) {
                                case 92:
                                case 34:
                                case 47:
                                case 98:
                                case 116:
                                case 110:
                                case 102:
                                case 114:
                                    c += X[m];
                                    B++;
                                    break;
                                case 117:
                                    d = ++B;
                                    for (e = B + 4; B < e; B++) m = a.charCodeAt(B), 48 <= m && 57 >= m || (97 <= m && 102 >= m || 65 <= m && 70 >= m) || t();
                                    c += F("0x" + a.slice(d, B));
                                    break;
                                default:
                                    t()
                                } else {
                                    if (34 ==
                                        m) break;
                                    m = a.charCodeAt(B);
                                    for (d = B; 32 <= m && 92 != m && 34 != m;) m = a.charCodeAt(++B);
                                    c += a.slice(d, B)
                                } if (34 == a.charCodeAt(B)) return B++, c;
                                t();
                            default:
                                d = B;
                                45 == m && (f = !0, m = a.charCodeAt(++B));
                                if (48 <= m && 57 >= m) {
                                    for (48 == m && (m = a.charCodeAt(B + 1), 48 <= m && 57 >= m) && t(); B < b && (m = a.charCodeAt(B), 48 <= m && 57 >= m); B++);
                                    if (46 == a.charCodeAt(B)) {
                                        for (e = ++B; e < b && (m = a.charCodeAt(e), 48 <= m && 57 >= m); e++);
                                        e == B && t();
                                        B = e
                                    }
                                    m = a.charCodeAt(B);
                                    if (101 == m || 69 == m) {
                                        m = a.charCodeAt(++B);
                                        43 != m && 45 != m || B++;
                                        for (e = B; e < b && (m = a.charCodeAt(e), 48 <= m && 57 >= m); e++);
                                        e == B && t();
                                        B = e
                                    }
                                    return +a.slice(d, B)
                                }
                                f && t();
                                if ("true" == a.slice(B, B + 4)) return B += 4, !0;
                                if ("false" == a.slice(B, B + 5)) return B += 5, !1;
                                if ("null" == a.slice(B, B + 4)) return B += 4, null;
                                t()
                            }
                            return "$"
                        }, L = function (a) {
                            var b, c;
                            "$" == a && t();
                            if ("string" == typeof a) {
                                if ("@" == (u ? a.charAt(0) : a[0])) return a.slice(1);
                                if ("[" == a) {
                                    for (b = [];; c || (c = !0)) {
                                        a = I();
                                        if ("]" == a) break;
                                        c && ("," == a ? (a = I(), "]" == a && t()) : t());
                                        "," == a && t();
                                        b.push(L(a))
                                    }
                                    return b
                                }
                                if ("{" == a) {
                                    for (b = {};; c || (c = !0)) {
                                        a = I();
                                        if ("}" == a) break;
                                        c && ("," == a ? (a = I(), "}" == a && t()) : t());
                                        "," !=
                                            a && "string" == typeof a && "@" == (u ? a.charAt(0) : a[0]) && ":" == I() || t();
                                        b[a.slice(1)] = L(I())
                                    }
                                    return b
                                }
                                t()
                            }
                            return a
                        }, P = function (a, b, c) {
                            c = Z(a, b, c);
                            c === h ? delete a[b] : a[b] = c
                        }, Z = function (a, b, e) {
                            var m = a[b],
                                h;
                            if ("object" == typeof m && m)
                                if ("[object Array]" == c.call(m))
                                    for (h = m.length; h--;) P(m, h, e);
                                else f(m, function (a) {
                                    P(m, a, e)
                                });
                            return e.call(a, b, m)
                        };
                    q.parse = function (a, b) {
                        var e, f;
                        B = 0;
                        C = "" + a;
                        e = L(I());
                        "$" != I() && t();
                        B = C = null;
                        return b && "[object Function]" == c.call(b) ? Z((f = {}, f[""] = e, f), "", b) : e
                    }
                }
            }
        })(this);
        (function () {
            var b =
                this,
                a = b._,
                c = {}, e = Array.prototype,
                f = Object.prototype,
                v = e.push,
                m = e.slice,
                r = e.concat,
                u = f.toString,
                n = f.hasOwnProperty,
                q = e.forEach,
                s = e.map,
                y = e.reduce,
                x = e.reduceRight,
                A = e.filter,
                E = e.every,
                V = e.some,
                F = e.indexOf,
                X = e.lastIndexOf,
                f = Array.isArray,
                B = Object.keys,
                C = Function.prototype.bind,
                t = function (a) {
                    return a instanceof t ? a : this instanceof t ? (this._wrapped = a, void 0) : new t(a)
                };
            "undefined" != typeof h ? ("undefined" != typeof module && module.exports && (h = module.exports = t), h._ = t) : b._ = t;
            t.VERSION = "1.4.3";
            var I = t.each = t.forEach =
                function (a, b, e) {
                    if (null != a)
                        if (q && a.forEach === q) a.forEach(b, e);
                        else if (a.length === +a.length)
                        for (var f = 0, m = a.length; m > f && b.call(e, a[f], f, a) !== c; f++);
                    else
                        for (f in a)
                            if (t.has(a, f) && b.call(e, a[f], f, a) === c) break
            };
            t.map = t.collect = function (a, b, c) {
                var d = [];
                return null == a ? d : s && a.map === s ? a.map(b, c) : (I(a, function (a, e, f) {
                    d[d.length] = b.call(c, a, e, f)
                }), d)
            };
            t.reduce = t.foldl = t.inject = function (a, b, c, d) {
                var e = 2 < arguments.length;
                if (null == a && (a = []), y && a.reduce === y) return d && (b = t.bind(b, d)), e ? a.reduce(b, c) : a.reduce(b);
                if (I(a, function (a, f, m) {
                    e ? c = b.call(d, c, a, f, m) : (c = a, e = !0)
                }), !e) throw new TypeError("Reduce of empty array with no initial value");
                return c
            };
            t.reduceRight = t.foldr = function (a, b, c, d) {
                var e = 2 < arguments.length;
                if (null == a && (a = []), x && a.reduceRight === x) return d && (b = t.bind(b, d)), e ? a.reduceRight(b, c) : a.reduceRight(b);
                var f = a.length;
                if (f !== +f) var m = t.keys(a),
                f = m.length;
                if (I(a, function (h, w, u) {
                    w = m ? m[--f] : --f;
                    e ? c = b.call(d, c, a[w], w, u) : (c = a[w], e = !0)
                }), !e) throw new TypeError("Reduce of empty array with no initial value");
                return c
            };
            t.find = t.detect = function (a, b, c) {
                var d;
                return L(a, function (a, e, f) {
                    return b.call(c, a, e, f) ? (d = a, !0) : void 0
                }), d
            };
            t.filter = t.select = function (a, b, c) {
                var d = [];
                return null == a ? d : A && a.filter === A ? a.filter(b, c) : (I(a, function (a, e, f) {
                    b.call(c, a, e, f) && (d[d.length] = a)
                }), d)
            };
            t.reject = function (a, b, c) {
                return t.filter(a, function (a, d, e) {
                    return !b.call(c, a, d, e)
                }, c)
            };
            t.every = t.all = function (a, b, e) {
                b || (b = t.identity);
                var f = !0;
                return null == a ? f : E && a.every === E ? a.every(b, e) : (I(a, function (a, m, p) {
                    return (f = f && b.call(e, a,
                        m, p)) ? void 0 : c
                }), !! f)
            };
            var L = t.some = t.any = function (a, b, e) {
                b || (b = t.identity);
                var f = !1;
                return null == a ? f : V && a.some === V ? a.some(b, e) : (I(a, function (a, m, p) {
                    return f || (f = b.call(e, a, m, p)) ? c : void 0
                }), !! f)
            };
            t.contains = t.include = function (a, b) {
                return null == a ? !1 : F && a.indexOf === F ? -1 != a.indexOf(b) : L(a, function (a) {
                    return a === b
                })
            };
            t.invoke = function (a, b) {
                var c = m.call(arguments, 2);
                return t.map(a, function (a) {
                    return (t.isFunction(b) ? b : a[b]).apply(a, c)
                })
            };
            t.pluck = function (a, b) {
                return t.map(a, function (a) {
                    return a[b]
                })
            };
            t.where =
                function (a, b) {
                    return t.isEmpty(b) ? [] : t.filter(a, function (a) {
                        for (var c in b)
                            if (b[c] !== a[c]) return !1;
                        return !0
                    })
            };
            t.max = function (a, b, c) {
                if (!b && t.isArray(a) && a[0] === +a[0] && 65535 > a.length) return Math.max.apply(Math, a);
                if (!b && t.isEmpty(a)) return -1 / 0;
                var d = {
                    computed: -1 / 0,
                    value: -1 / 0
                };
                return I(a, function (a, e, f) {
                    e = b ? b.call(c, a, e, f) : a;
                    e >= d.computed && (d = {
                        value: a,
                        computed: e
                    })
                }), d.value
            };
            t.min = function (a, b, c) {
                if (!b && t.isArray(a) && a[0] === +a[0] && 65535 > a.length) return Math.min.apply(Math, a);
                if (!b && t.isEmpty(a)) return 1 /
                    0;
                var d = {
                    computed: 1 / 0,
                    value: 1 / 0
                };
                return I(a, function (a, e, f) {
                    e = b ? b.call(c, a, e, f) : a;
                    d.computed > e && (d = {
                        value: a,
                        computed: e
                    })
                }), d.value
            };
            t.shuffle = function (a) {
                var b, c = 0,
                    d = [];
                return I(a, function (a) {
                    b = t.random(c++);
                    d[c - 1] = d[b];
                    d[b] = a
                }), d
            };
            var P = function (a) {
                return t.isFunction(a) ? a : function (b) {
                    return b[a]
                }
            };
            t.sortBy = function (a, b, c) {
                var d = P(b);
                return t.pluck(t.map(a, function (a, b, e) {
                    return {
                        value: a,
                        index: b,
                        criteria: d.call(c, a, b, e)
                    }
                }).sort(function (a, b) {
                    var c = a.criteria,
                        d = b.criteria;
                    if (c !== d) {
                        if (c > d || void 0 ===
                            c) return 1;
                        if (d > c || void 0 === d) return -1
                    }
                    return a.index < b.index ? -1 : 1
                }), "value")
            };
            var Z = function (a, b, c, d) {
                var e = {}, f = P(b || t.identity);
                return I(a, function (b, m) {
                    var h = f.call(c, b, m, a);
                    d(e, h, b)
                }), e
            };
            t.groupBy = function (a, b, c) {
                return Z(a, b, c, function (a, b, c) {
                    (t.has(a, b) ? a[b] : a[b] = []).push(c)
                })
            };
            t.countBy = function (a, b, c) {
                return Z(a, b, c, function (a, b) {
                    t.has(a, b) || (a[b] = 0);
                    a[b]++
                })
            };
            t.sortedIndex = function (a, b, c, d) {
                c = null == c ? t.identity : P(c);
                b = c.call(d, b);
                for (var e = 0, f = a.length; f > e;) {
                    var m = e + f >>> 1;
                    b > c.call(d, a[m]) ?
                        e = m + 1 : f = m
                }
                return e
            };
            t.toArray = function (a) {
                return a ? t.isArray(a) ? m.call(a) : a.length === +a.length ? t.map(a, t.identity) : t.values(a) : []
            };
            t.size = function (a) {
                return null == a ? 0 : a.length === +a.length ? a.length : t.keys(a).length
            };
            t.first = t.head = t.take = function (a, b, c) {
                return null == a ? void 0 : null == b || c ? a[0] : m.call(a, 0, b)
            };
            t.initial = function (a, b, c) {
                return m.call(a, 0, a.length - (null == b || c ? 1 : b))
            };
            t.last = function (a, b, c) {
                return null == a ? void 0 : null == b || c ? a[a.length - 1] : m.call(a, Math.max(a.length - b, 0))
            };
            t.rest = t.tail = t.drop =
                function (a, b, c) {
                    return m.call(a, null == b || c ? 1 : b)
            };
            t.compact = function (a) {
                return t.filter(a, t.identity)
            };
            var O = function (a, b, c) {
                return I(a, function (a) {
                    t.isArray(a) ? b ? v.apply(c, a) : O(a, b, c) : c.push(a)
                }), c
            };
            t.flatten = function (a, b) {
                return O(a, b, [])
            };
            t.without = function (a) {
                return t.difference(a, m.call(arguments, 1))
            };
            t.uniq = t.unique = function (a, b, c, d) {
                t.isFunction(b) && (d = c, c = b, b = !1);
                c = c ? t.map(a, c, d) : a;
                var e = [],
                    f = [];
                return I(c, function (c, d) {
                    (b ? d && f[f.length - 1] === c : t.contains(f, c)) || (f.push(c), e.push(a[d]))
                }), e
            };
            t.union = function () {
                return t.uniq(r.apply(e, arguments))
            };
            t.intersection = function (a) {
                var b = m.call(arguments, 1);
                return t.filter(t.uniq(a), function (a) {
                    return t.every(b, function (b) {
                        return 0 <= t.indexOf(b, a)
                    })
                })
            };
            t.difference = function (a) {
                var b = r.apply(e, m.call(arguments, 1));
                return t.filter(a, function (a) {
                    return !t.contains(b, a)
                })
            };
            t.zip = function () {
                for (var a = m.call(arguments), b = t.max(t.pluck(a, "length")), c = Array(b), d = 0; b > d; d++) c[d] = t.pluck(a, "" + d);
                return c
            };
            t.object = function (a, b) {
                if (null == a) return {};
                for (var c = {}, d = 0, e = a.length; e > d; d++) b ? c[a[d]] = b[d] : c[a[d][0]] = a[d][1];
                return c
            };
            t.indexOf = function (a, b, c) {
                if (null == a) return -1;
                var d = 0,
                    e = a.length;
                if (c) {
                    if ("number" != typeof c) return d = t.sortedIndex(a, b), a[d] === b ? d : -1;
                    d = 0 > c ? Math.max(0, e + c) : c
                }
                if (F && a.indexOf === F) return a.indexOf(b, c);
                for (; e > d; d++)
                    if (a[d] === b) return d;
                return -1
            };
            t.lastIndexOf = function (a, b, c) {
                if (null == a) return -1;
                var d = null != c;
                if (X && a.lastIndexOf === X) return d ? a.lastIndexOf(b, c) : a.lastIndexOf(b);
                for (c = d ? c : a.length; c--;)
                    if (a[c] === b) return c;
                return -1
            };
            t.range = function (a, b, c) {
                1 >= arguments.length && (b = a || 0, a = 0);
                c = arguments[2] || 1;
                for (var d = Math.max(Math.ceil((b - a) / c), 0), e = 0, f = Array(d); d > e;) f[e++] = a, a += c;
                return f
            };
            var S = function () {};
            t.bind = function (a, b) {
                var c, d;
                if (a.bind === C && C) return C.apply(a, m.call(arguments, 1));
                if (!t.isFunction(a)) throw new TypeError;
                return c = m.call(arguments, 2), d = function () {
                    if (!(this instanceof d)) return a.apply(b, c.concat(m.call(arguments)));
                    S.prototype = a.prototype;
                    var e = new S;
                    S.prototype = null;
                    var f = a.apply(e, c.concat(m.call(arguments)));
                    return Object(f) === f ? f : e
                }
            };
            t.bindAll = function (a) {
                var b = m.call(arguments, 1);
                return 0 == b.length && (b = t.functions(a)), I(b, function (b) {
                    a[b] = t.bind(a[b], a)
                }), a
            };
            t.memoize = function (a, b) {
                var c = {};
                return b || (b = t.identity),
                function () {
                    var d = b.apply(this, arguments);
                    return t.has(c, d) ? c[d] : c[d] = a.apply(this, arguments)
                }
            };
            t.delay = function (a, b) {
                var c = m.call(arguments, 2);
                return setTimeout(function () {
                    return a.apply(null, c)
                }, b)
            };
            t.defer = function (a) {
                return t.delay.apply(t, [a, 1].concat(m.call(arguments, 1)))
            };
            t.throttle =
                function (a, b) {
                    var c, d, e, f, m = 0,
                        h = function () {
                            m = new Date;
                            e = null;
                            f = a.apply(c, d)
                        };
                    return function () {
                        var w = new Date,
                            u = b - (w - m);
                        return c = this, d = arguments, 0 >= u ? (clearTimeout(e), e = null, m = w, f = a.apply(c, d)) : e || (e = setTimeout(h, u)), f
                    }
            };
            t.debounce = function (a, b, c) {
                var d, e;
                return function () {
                    var f = this,
                        m = arguments,
                        h = c && !d;
                    return clearTimeout(d), d = setTimeout(function () {
                        d = null;
                        c || (e = a.apply(f, m))
                    }, b), h && (e = a.apply(f, m)), e
                }

            };
            t.once = function (a) {
                var b, c = !1;
                return function () {
                    return c ? b : (c = !0, b = a.apply(this, arguments), a =
                        null, b)
                }
            };
            t.wrap = function (a, b) {
                return function () {
                    var c = [a];
                    return v.apply(c, arguments), b.apply(this, c)
                }
            };
            t.compose = function () {
                var a = arguments;
                return function () {
                    for (var b = arguments, c = a.length - 1; 0 <= c; c--) b = [a[c].apply(this, b)];
                    return b[0]
                }
            };
            t.after = function (a, b) {
                return 0 >= a ? b() : function () {
                    return 1 > --a ? b.apply(this, arguments) : void 0
                }
            };
            t.keys = B || function (a) {
                if (a !== Object(a)) throw new TypeError("Invalid object");
                var b = [],
                    c;
                for (c in a) t.has(a, c) && (b[b.length] = c);
                return b
            };
            t.values = function (a) {
                var b = [],
                    c;
                for (c in a) t.has(a, c) && b.push(a[c]);
                return b
            };
            t.pairs = function (a) {
                var b = [],
                    c;
                for (c in a) t.has(a, c) && b.push([c, a[c]]);
                return b
            };
            t.invert = function (a) {
                var b = {}, c;
                for (c in a) t.has(a, c) && (b[a[c]] = c);
                return b
            };
            t.functions = t.methods = function (a) {
                var b = [],
                    c;
                for (c in a) t.isFunction(a[c]) && b.push(c);
                return b.sort()
            };
            t.extend = function (a) {
                return I(m.call(arguments, 1), function (b) {
                    if (b)
                        for (var c in b) a[c] = b[c]
                }), a
            };
            t.pick = function (a) {
                var b = {}, c = r.apply(e, m.call(arguments, 1));
                return I(c, function (c) {
                    c in a && (b[c] =
                        a[c])
                }), b
            };
            t.omit = function (a) {
                var b = {}, c = r.apply(e, m.call(arguments, 1)),
                    d;
                for (d in a) t.contains(c, d) || (b[d] = a[d]);
                return b
            };
            t.defaults = function (a) {
                return I(m.call(arguments, 1), function (b) {
                    if (b)
                        for (var c in b) null == a[c] && (a[c] = b[c])
                }), a
            };
            t.clone = function (a) {
                return t.isObject(a) ? t.isArray(a) ? a.slice() : t.extend({}, a) : a
            };
            t.tap = function (a, b) {
                return b(a), a
            };
            var w = function (a, b, c, d) {
                if (a === b) return 0 !== a || 1 / a == 1 / b;
                if (null == a || null == b) return a === b;
                a instanceof t && (a = a._wrapped);
                b instanceof t && (b = b._wrapped);
                var e = u.call(a);
                if (e != u.call(b)) return !1;
                switch (e) {
                case "[object String]":
                    return a == b + "";
                case "[object Number]":
                    return a != +a ? b != +b : 0 == a ? 1 / a == 1 / b : a == +b;
                case "[object Date]":
                case "[object Boolean]":
                    return +a == +b;
                case "[object RegExp]":
                    return a.source == b.source && a.global == b.global && a.multiline == b.multiline && a.ignoreCase == b.ignoreCase
                }
                if ("object" != typeof a || "object" != typeof b) return !1;
                for (var f = c.length; f--;)
                    if (c[f] == a) return d[f] == b;
                c.push(a);
                d.push(b);
                var f = 0,
                    m = !0;
                if ("[object Array]" == e) {
                    if (f = a.length,
                        m = f == b.length)
                        for (; f-- && (m = w(a[f], b[f], c, d)););
                } else {
                    var e = a.constructor,
                        h = b.constructor;
                    if (e !== h && !(t.isFunction(e) && e instanceof e && t.isFunction(h) && h instanceof h)) return !1;
                    for (var r in a)
                        if (t.has(a, r) && (f++, !(m = t.has(b, r) && w(a[r], b[r], c, d)))) break;
                    if (m) {
                        for (r in b)
                            if (t.has(b, r) && !f--) break;
                        m = !f
                    }
                }
                return c.pop(), d.pop(), m
            };
            t.isEqual = function (a, b) {
                return w(a, b, [], [])
            };
            t.isEmpty = function (a) {
                if (null == a) return !0;
                if (t.isArray(a) || t.isString(a)) return 0 === a.length;
                for (var b in a)
                    if (t.has(a, b)) return !1;
                return !0
            };
            t.isElement = function (a) {
                return !(!a || 1 !== a.nodeType)
            };
            t.isArray = f || function (a) {
                return "[object Array]" == u.call(a)
            };
            t.isObject = function (a) {
                return a === Object(a)
            };
            I("Arguments Function String Number Date RegExp".split(" "), function (a) {
                t["is" + a] = function (b) {
                    return u.call(b) == "[object " + a + "]"
                }
            });
            t.isArguments(arguments) || (t.isArguments = function (a) {
                return !(!a || !t.has(a, "callee"))
            });
            t.isFunction = function (a) {
                return "function" == typeof a
            };
            t.isFinite = function (a) {
                return isFinite(a) && !isNaN(parseFloat(a))
            };
            t.isNaN = function (a) {
                return t.isNumber(a) && a != +a
            };
            t.isBoolean = function (a) {
                return !0 === a || !1 === a || "[object Boolean]" == u.call(a)
            };
            t.isNull = function (a) {
                return null === a
            };
            t.isUndefined = function (a) {
                return void 0 === a
            };
            t.has = function (a, b) {
                return n.call(a, b)
            };
            t.noConflict = function () {
                return b._ = a, this
            };
            t.identity = function (a) {
                return a
            };
            t.times = function (a, b, c) {
                for (var d = Array(a), e = 0; a > e; e++) d[e] = b.call(c, e);
                return d
            };
            t.random = function (a, b) {
                return null == b && (b = a, a = 0), a + (0 | Math.random() * (b - a + 1))
            };
            var G = {
                escape: {
                    "&": "&amp;",
                    "<": "&lt;",
                    ">": "&gt;",
                    '"': "&quot;",
                    "'": "&#x27;",
                    "/": "&#x2F;"
                }
            };
            G.unescape = t.invert(G.escape);
            var Q = {
                escape: RegExp("[" + t.keys(G.escape).join("") + "]", "g"),
                unescape: RegExp("(" + t.keys(G.unescape).join("|") + ")", "g")
            };
            t.each(["escape", "unescape"], function (a) {
                t[a] = function (b) {
                    return null == b ? "" : ("" + b).replace(Q[a], function (b) {
                        return G[a][b]
                    })
                }
            });
            t.result = function (a, b) {
                if (null == a) return null;
                var c = a[b];
                return t.isFunction(c) ? c.call(a) : c
            };
            t.mixin = function (a) {
                I(t.functions(a), function (b) {
                    var c = t[b] = a[b];
                    t.prototype[b] =
                        function () {
                            var a = [this._wrapped];
                            v.apply(a, arguments);
                            a = c.apply(t, a);
                            return this._chain ? t(a).chain() : a
                    }
                })
            };
            var H = 0;
            t.uniqueId = function (a) {
                var b = "" + ++H;
                return a ? a + b : b
            };
            t.templateSettings = {
                evaluate: /<%([\s\S]+?)%>/g,
                interpolate: /<%=([\s\S]+?)%>/g,
                escape: /<%-([\s\S]+?)%>/g
            };
            var J = /(.)^/,
                ba = {
                    "'": "'",
                    "\\": "\\",
                    "\r": "r",
                    "\n": "n",
                    " ": "t",
                    "\u2028": "u2028",
                    "\u2029": "u2029"
                }, qa = /\\|'|\r|\n|\t|\u2028|\u2029/g;
            t.template = function (a, b, c) {
                c = t.defaults({}, c, t.templateSettings);
                var d = RegExp([(c.escape || J).source, (c.interpolate || J).source, (c.evaluate || J).source].join("|") + "|$", "g"),
                    e = 0,
                    f = "__p+='";
                a.replace(d, function (b, c, d, m, g) {
                    return f += a.slice(e, g).replace(qa, function (a) {
                        return "\\" + ba[a]
                    }), c && (f += "'+\n((__t=(" + c + "))==null?'':_.escape(__t))+\n'"), d && (f += "'+\n((__t=(" + d + "))==null?'':__t)+\n'"), m && (f += "';\n" + m + "\n__p+='"), e = g + b.length, b
                });
                f += "';\n";
                c.variable || (f = "with(obj||{}){\n" + f + "}\n");
                f = "var __t,__p='',__j=Array.prototype.join,print=function(){__p+=__j.call(arguments,'');};\n" + f + "return __p;\n";
                try {
                    var m =
                        Function(c.variable || "obj", "_", f)
                } catch (h) {
                    throw h.source = f, h;
                }
                if (b) return m(b, t);
                b = function (a) {
                    return m.call(this, a, t)
                };
                return b.source = "function(" + (c.variable || "obj") + "){\n" + f + "}", b
            };
            t.chain = function (a) {
                return t(a).chain()
            };
            t.mixin(t);
            I("pop push reverse shift sort splice unshift".split(" "), function (a) {
                var b = e[a];
                t.prototype[a] = function () {
                    var c = this._wrapped;
                    return b.apply(c, arguments), "shift" != a && "splice" != a || 0 !== c.length || delete c[0], this._chain ? t(c).chain() : c
                }
            });
            I(["concat", "join", "slice"],
                function (a) {
                    var b = e[a];
                    t.prototype[a] = function () {
                        var a = b.apply(this._wrapped, arguments);
                        return this._chain ? t(a).chain() : a
                    }
                });
            t.extend(t.prototype, {
                chain: function () {
                    return this._chain = !0, this
                },
                value: function () {
                    return this._wrapped
                }
            })
        }).call(this);
        h._ = h._.noConflict();
        (function () {
            var b = this,
                a = b.Backbone,
                d = [],
                e = d.push,
                f = d.slice,
                v = d.splice,
                m;
            m = "undefined" !== typeof h ? h : b.Backbone = {};
            m.VERSION = "0.9.9";
            var r = b._;
            !r && "undefined" !== typeof require && (r = require("underscore"));
            m.$ = b.jQuery || b.Zepto || b.ender;
            m.noConflict =
                function () {
                    b.Backbone = a;
                    return this
            };
            m.emulateHTTP = !1;
            m.emulateJSON = !1;
            var u = /\s+/,
                n = function (a, b, c, d) {
                    if (!c) return !0;
                    if ("object" === typeof c)
                        for (var e in c) a[b].apply(a, [e, c[e]].concat(d));
                    else if (u.test(c)) {
                        c = c.split(u);
                        e = 0;
                        for (var f = c.length; e < f; e++) a[b].apply(a, [c[e]].concat(d))
                    } else return !0
                }, q = function (a, b, c) {
                    var d;
                    a = -1;
                    var e = b.length;
                    switch (c.length) {
                    case 0:
                        for (; ++a < e;)(d = b[a]).callback.call(d.ctx);
                        break;
                    case 1:
                        for (; ++a < e;)(d = b[a]).callback.call(d.ctx, c[0]);
                        break;
                    case 2:
                        for (; ++a < e;)(d = b[a]).callback.call(d.ctx,
                            c[0], c[1]);
                        break;
                    case 3:
                        for (; ++a < e;)(d = b[a]).callback.call(d.ctx, c[0], c[1], c[2]);
                        break;
                    default:
                        for (; ++a < e;)(d = b[a]).callback.apply(d.ctx, c)
                    }
                }, d = m.Events = {
                    on: function (a, b, c) {
                        if (!n(this, "on", a, [b, c]) || !b) return this;
                        this._events || (this._events = {});
                        (this._events[a] || (this._events[a] = [])).push({
                            callback: b,
                            context: c,
                            ctx: c || this
                        });
                        return this
                    },
                    once: function (a, b, c) {
                        if (!n(this, "once", a, [b, c]) || !b) return this;
                        var d = this,
                            e = r.once(function () {
                                d.off(a, e);
                                b.apply(this, arguments)
                            });
                        e._callback = b;
                        this.on(a, e, c);
                        return this
                    },
                    off: function (a, b, c) {
                        var d, e, f, m, h, u, v, A;
                        if (!this._events || !n(this, "off", a, [b, c])) return this;
                        if (!a && !b && !c) return this._events = {}, this;
                        m = a ? [a] : r.keys(this._events);
                        h = 0;
                        for (u = m.length; h < u; h++)
                            if (a = m[h], d = this._events[a]) {
                                f = [];
                                if (b || c)
                                    for (v = 0, A = d.length; v < A; v++) e = d[v], (b && b !== (e.callback._callback || e.callback) || c && c !== e.context) && f.push(e);
                                this._events[a] = f
                            }
                        return this
                    },
                    trigger: function (a) {
                        if (!this._events) return this;
                        var b = f.call(arguments, 1);
                        if (!n(this, "trigger", a, b)) return this;
                        var c =
                            this._events[a],
                            d = this._events.all;
                        c && q(this, c, b);
                        d && q(this, d, arguments);
                        return this
                    },
                    listenTo: function (a, b, c) {
                        var d = this._listeners || (this._listeners = {}),
                            e = a._listenerId || (a._listenerId = r.uniqueId("l"));
                        d[e] = a;
                        a.on(b, c || this, this);
                        return this
                    },
                    stopListening: function (a, b, c) {
                        var d = this._listeners;
                        if (d) {
                            if (a) a.off(b, c, this), b || c || delete d[a._listenerId];
                            else {
                                for (var e in d) d[e].off(null, null, this);
                                this._listeners = {}
                            }
                            return this
                        }
                    }
                };
            d.bind = d.on;
            d.unbind = d.off;
            r.extend(m, d);
            var s = m.Model = function (a, b) {
                var c,
                    d = a || {};
                this.cid = r.uniqueId("c");
                this.changed = {};
                this.attributes = {};
                this._changes = [];
                b && b.collection && (this.collection = b.collection);
                b && b.parse && (d = this.parse(d));
                (c = r.result(this, "defaults")) && r.defaults(d, c);
                this.set(d, {
                    silent: !0
                });
                this._currentAttributes = r.clone(this.attributes);
                this._previousAttributes = r.clone(this.attributes);
                this.initialize.apply(this, arguments)
            };
            r.extend(s.prototype, d, {
                changed: null,
                idAttribute: "id",
                initialize: function () {},
                toJSON: function () {
                    return r.clone(this.attributes)
                },
                sync: function () {
                    return m.sync.apply(this, arguments)
                },
                get: function (a) {
                    return this.attributes[a]
                },
                escape: function (a) {
                    return r.escape(this.get(a))
                },
                has: function (a) {
                    return null != this.get(a)
                },
                set: function (a, b, c) {
                    var d, e;
                    if (null == a) return this;
                    r.isObject(a) ? (e = a, c = b) : (e = {})[a] = b;
                    a = c && c.silent;
                    var f = c && c.unset;
                    if (!this._validate(e, c)) return !1;
                    this.idAttribute in e && (this.id = e[this.idAttribute]);
                    var m = this.attributes;
                    for (d in e) b = e[d], f ? delete m[d] : m[d] = b, this._changes.push(d, b);
                    this._hasComputed = !1;
                    a || this.change(c);
                    return this
                },
                unset: function (a, b) {
                    return this.set(a, void 0, r.extend({}, b, {
                        unset: !0
                    }))
                },
                clear: function (a) {
                    var b = {}, c;
                    for (c in this.attributes) b[c] = void 0;
                    return this.set(b, r.extend({}, a, {
                        unset: !0
                    }))
                },
                fetch: function (a) {
                    a = a ? r.clone(a) : {};
                    void 0 === a.parse && (a.parse = !0);
                    var b = this,
                        c = a.success;
                    a.success = function (d) {
                        if (!b.set(b.parse(d), a)) return !1;
                        c && c(b, d, a)
                    };
                    return this.sync("read", this, a)
                },
                save: function (a, b, c) {
                    var d, e, f;
                    null == a || r.isObject(a) ? (d = a, c = b) : null != a && ((d = {})[a] = b);
                    c = c ? r.clone(c) : {};
                    if (c.wait) {
                        if (d && !this._validate(d, c)) return !1;
                        e = r.clone(this.attributes)
                    }
                    a = r.extend({}, c, {
                        silent: !0
                    });
                    if (d && !this.set(d, c.wait ? a : c) || !d && !this._validate(null, c)) return !1;
                    var m = this,
                        h = c.success;
                    c.success = function (a) {
                        f = !0;
                        var b = m.parse(a);
                        c.wait && (b = r.extend(d || {}, b));
                        if (!m.set(b, c)) return !1;
                        h && h(m, a, c)
                    };
                    b = this.isNew() ? "create" : c.patch ? "patch" : "update";
                    "patch" == b && (c.attrs = d);
                    b = this.sync(b, this, c);
                    !f && c.wait && (this.clear(a), this.set(e, a));
                    return b
                },
                destroy: function (a) {
                    a = a ? r.clone(a) : {};
                    var b = this,
                        c = a.success,
                        d = function () {
                            b.trigger("destroy",
                                b, b.collection, a)
                        };
                    a.success = function (e) {
                        (a.wait || b.isNew()) && d();
                        c && c(b, e, a)
                    };
                    if (this.isNew()) return a.success(), !1;
                    var e = this.sync("delete", this, a);
                    a.wait || d();
                    return e
                },
                url: function () {
                    var a = r.result(this, "urlRoot") || r.result(this.collection, "url") || S();
                    return this.isNew() ? a : a + ("/" === a.charAt(a.length - 1) ? "" : "/") + encodeURIComponent(this.id)
                },
                parse: function (a) {
                    return a
                },
                clone: function () {
                    return new this.constructor(this.attributes)
                },
                isNew: function () {
                    return null == this.id
                },
                change: function (a) {
                    var b = this._changing;
                    this._changing = !0;
                    var c = this._computeChanges(!0);
                    this._pending = !! c.length;
                    for (var d = c.length - 2; 0 <= d; d -= 2) this.trigger("change:" + c[d], this, c[d + 1], a);
                    if (b) return this;
                    for (; this._pending;) this._pending = !1, this.trigger("change", this, a), this._previousAttributes = r.clone(this.attributes);
                    this._changing = !1;
                    return this
                },
                hasChanged: function (a) {
                    this._hasComputed || this._computeChanges();
                    return null == a ? !r.isEmpty(this.changed) : r.has(this.changed, a)
                },
                changedAttributes: function (a) {
                    if (!a) return this.hasChanged() ?
                        r.clone(this.changed) : !1;
                    var b, c = !1,
                        d = this._previousAttributes,
                        e;
                    for (e in a) r.isEqual(d[e], b = a[e]) || ((c || (c = {}))[e] = b);
                    return c
                },
                _computeChanges: function (a) {
                    this.changed = {};
                    for (var b = {}, c = [], d = this._currentAttributes, e = this._changes, f = e.length - 2; 0 <= f; f -= 2) {
                        var m = e[f],
                            h = e[f + 1];
                        b[m] || (b[m] = !0, d[m] !== h && (this.changed[m] = h, a && (c.push(m, h), d[m] = h)))
                    }
                    a && (this._changes = []);
                    this._hasComputed = !0;
                    return c
                },
                previous: function (a) {
                    return null != a && this._previousAttributes ? this._previousAttributes[a] : null
                },
                previousAttributes: function () {
                    return r.clone(this._previousAttributes)
                },
                _validate: function (a, b) {
                    if (!this.validate) return !0;
                    a = r.extend({}, this.attributes, a);
                    var c = this.validate(a, b);
                    if (!c) return !0;
                    b && b.error && b.error(this, c, b);
                    this.trigger("error", this, c, b);
                    return !1
                }
            });
            var y = m.Collection = function (a, b) {
                b || (b = {});
                b.model && (this.model = b.model);
                void 0 !== b.comparator && (this.comparator = b.comparator);
                this._reset();
                this.initialize.apply(this, arguments);
                a && this.reset(a, r.extend({
                    silent: !0
                }, b))
            };
            r.extend(y.prototype, d, {
                model: s,
                initialize: function () {},
                toJSON: function (a) {
                    return this.map(function (b) {
                        return b.toJSON(a)
                    })
                },
                sync: function () {
                    return m.sync.apply(this, arguments)
                },
                add: function (a, b) {
                    var c, d, f, m, h = b && b.at,
                        u = null == (b && b.sort) ? !0 : b.sort;
                    a = r.isArray(a) ? a.slice() : [a];
                    for (c = a.length - 1; 0 <= c; c--)(d = this._prepareModel(a[c], b)) ? (a[c] = d, (f = null != d.id && this._byId[d.id]) || this._byCid[d.cid] ? (b && b.merge && f && (f.set(d.attributes, b), m = u), a.splice(c, 1)) : (d.on("all", this._onModelEvent, this), this._byCid[d.cid] = d, null != d.id && (this._byId[d.id] = d))) : (this.trigger("error", this, a[c], b), a.splice(c, 1));
                    a.length && (m = u);
                    this.length +=
                        a.length;
                    c = [null != h ? h : this.models.length, 0];
                    e.apply(c, a);
                    v.apply(this.models, c);
                    m && this.comparator && null == h && this.sort({
                        silent: !0
                    });
                    if (b && b.silent) return this;
                    for (; d = a.shift();) d.trigger("add", d, this, b);
                    return this
                },
                remove: function (a, b) {
                    var c, d, e, f;
                    b || (b = {});
                    a = r.isArray(a) ? a.slice() : [a];
                    c = 0;
                    for (d = a.length; c < d; c++)
                        if (f = this.get(a[c])) delete this._byId[f.id], delete this._byCid[f.cid], e = this.indexOf(f), this.models.splice(e, 1), this.length--, b.silent || (b.index = e, f.trigger("remove", f, this, b)), this._removeReference(f);
                    return this
                },
                push: function (a, b) {
                    a = this._prepareModel(a, b);
                    this.add(a, r.extend({
                        at: this.length
                    }, b));
                    return a
                },
                pop: function (a) {
                    var b = this.at(this.length - 1);
                    this.remove(b, a);
                    return b
                },
                unshift: function (a, b) {
                    a = this._prepareModel(a, b);
                    this.add(a, r.extend({
                        at: 0
                    }, b));
                    return a
                },
                shift: function (a) {
                    var b = this.at(0);
                    this.remove(b, a);
                    return b
                },
                slice: function (a, b) {
                    return this.models.slice(a, b)
                },
                get: function (a) {
                    return null == a ? void 0 : this._byId[null != a.id ? a.id : a] || this._byCid[a.cid || a]
                },
                at: function (a) {
                    return this.models[a]
                },
                where: function (a) {
                    return r.isEmpty(a) ? [] : this.filter(function (b) {
                        for (var c in a)
                            if (a[c] !== b.get(c)) return !1;
                        return !0
                    })
                },
                sort: function (a) {
                    if (!this.comparator) throw Error("Cannot sort a set without a comparator");
                    r.isString(this.comparator) || 1 === this.comparator.length ? this.models = this.sortBy(this.comparator, this) : this.models.sort(r.bind(this.comparator, this));
                    a && a.silent || this.trigger("sort", this, a);
                    return this
                },
                pluck: function (a) {
                    return r.invoke(this.models, "get", a)
                },
                update: function (a, b) {
                    var c, d, e,
                        f, m = [],
                        h = [],
                        u = {}, v = this.model.prototype.idAttribute;
                    b = r.extend({
                        add: !0,
                        merge: !0,
                        remove: !0
                    }, b);
                    b.parse && (a = this.parse(a));
                    r.isArray(a) || (a = a ? [a] : []);
                    if (b.add && !b.remove) return this.add(a, b);
                    d = 0;
                    for (e = a.length; d < e; d++) c = a[d], f = this.get(c.id || c.cid || c[v]), b.remove && f && (u[f.cid] = !0), (b.add && !f || b.merge && f) && m.push(c);
                    if (b.remove)
                        for (d = 0, e = this.models.length; d < e; d++) c = this.models[d], u[c.cid] || h.push(c);
                    h.length && this.remove(h, b);
                    m.length && this.add(m, b);
                    return this
                },
                reset: function (a, b) {
                    b || (b = {});
                    b.parse &&
                        (a = this.parse(a));
                    for (var c = 0, d = this.models.length; c < d; c++) this._removeReference(this.models[c]);
                    b.previousModels = this.models;
                    this._reset();
                    a && this.add(a, r.extend({
                        silent: !0
                    }, b));
                    b.silent || this.trigger("reset", this, b);
                    return this
                },
                fetch: function (a) {
                    a = a ? r.clone(a) : {};
                    void 0 === a.parse && (a.parse = !0);
                    var b = this,
                        c = a.success;
                    a.success = function (d) {
                        b[a.update ? "update" : "reset"](d, a);
                        c && c(b, d, a)
                    };
                    return this.sync("read", this, a)
                },
                create: function (a, b) {
                    var c = this;
                    b = b ? r.clone(b) : {};
                    a = this._prepareModel(a, b);
                    if (!a) return !1;
                    b.wait || c.add(a, b);
                    var d = b.success;
                    b.success = function (a, b, e) {
                        e.wait && c.add(a, e);
                        d && d(a, b, e)
                    };
                    a.save(null, b);
                    return a
                },
                parse: function (a) {
                    return a
                },
                clone: function () {
                    return new this.constructor(this.models)
                },
                chain: function () {
                    return r(this.models).chain()
                },
                _reset: function () {
                    this.length = 0;
                    this.models = [];
                    this._byId = {};
                    this._byCid = {}
                },
                _prepareModel: function (a, b) {
                    if (a instanceof s) return a.collection || (a.collection = this), a;
                    b || (b = {});
                    b.collection = this;
                    var c = new this.model(a, b);
                    return c._validate(a, b) ? c : !1
                },
                _removeReference: function (a) {
                    this === a.collection && delete a.collection;
                    a.off("all", this._onModelEvent, this)
                },
                _onModelEvent: function (a, b, c, d) {
                    ("add" === a || "remove" === a) && c !== this || ("destroy" === a && this.remove(b, d), b && a === "change:" + b.idAttribute && (delete this._byId[b.previous(b.idAttribute)], null != b.id && (this._byId[b.id] = b)), this.trigger.apply(this, arguments))
                }
            });
            r.each("forEach each map collect reduce foldl inject reduceRight foldr find detect filter select reject every all some any include contains invoke max min sortedIndex toArray size first head take initial rest tail last without indexOf shuffle lastIndexOf isEmpty".split(" "),
                function (a) {
                    y.prototype[a] = function () {
                        var b = f.call(arguments);
                        b.unshift(this.models);
                        return r[a].apply(r, b)
                    }
                });
            r.each(["groupBy", "countBy", "sortBy"], function (a) {
                y.prototype[a] = function (b, c) {
                    var d = r.isFunction(b) ? b : function (a) {
                            return a.get(b)
                        };
                    return r[a](this.models, d, c)
                }
            });
            var x = m.Router = function (a) {
                a || (a = {});
                a.routes && (this.routes = a.routes);
                this._bindRoutes();
                this.initialize.apply(this, arguments)
            }, A = /\((.*?)\)/g,
                E = /:\w+/g,
                V = /\*\w+/g,
                F = /[\-{}\[\]+?.,\\\^$|#\s]/g;
            r.extend(x.prototype, d, {
                initialize: function () {},
                route: function (a, b, c) {
                    r.isRegExp(a) || (a = this._routeToRegExp(a));
                    c || (c = this[b]);
                    m.history.route(a, r.bind(function (d) {
                        d = this._extractParameters(a, d);
                        c && c.apply(this, d);
                        this.trigger.apply(this, ["route:" + b].concat(d));
                        m.history.trigger("route", this, b, d)
                    }, this));
                    return this
                },
                navigate: function (a, b) {
                    m.history.navigate(a, b);
                    return this
                },
                _bindRoutes: function () {
                    if (this.routes)
                        for (var a, b = r.keys(this.routes); null != (a = b.pop());) this.route(a, this.routes[a])
                },
                _routeToRegExp: function (a) {
                    a = a.replace(F, "\\$&").replace(A,
                        "(?:$1)?").replace(E, "([^/]+)").replace(V, "(.*?)");
                    return RegExp("^" + a + "$")
                },
                _extractParameters: function (a, b) {
                    return a.exec(b).slice(1)
                }
            });
            var X = m.History = function () {
                this.handlers = [];
                r.bindAll(this, "checkUrl");
                "undefined" !== typeof window && (this.location = window.location, this.history = window.history)
            }, B = /^[#\/]|\s+$/g,
                C = /^\/+|\/+$/g,
                t = /msie [\w.]+/,
                I = /\/$/;
            X.started = !1;
            r.extend(X.prototype, d, {
                interval: 50,
                getHash: function (a) {
                    return (a = (a || this).location.href.match(/#(.*)$/)) ? a[1] : ""
                },
                getFragment: function (a,
                    b) {
                    if (null == a)
                        if (this._hasPushState || !this._wantsHashChange || b) {
                            a = this.location.pathname;
                            var c = this.root.replace(I, "");
                            a.indexOf(c) || (a = a.substr(c.length))
                        } else a = this.getHash();
                    return a.replace(B, "")
                },
                start: function (a) {
                    if (X.started) throw Error("Backbone.history has already been started");
                    X.started = !0;
                    this.options = r.extend({}, {
                        root: "/"
                    }, this.options, a);
                    this.root = this.options.root;
                    this._wantsHashChange = !1 !== this.options.hashChange;
                    this._wantsPushState = !! this.options.pushState;
                    this._hasPushState = !(!this.options.pushState || !this.history || !this.history.pushState);
                    a = this.getFragment();
                    var b = document.documentMode,
                        b = t.exec(navigator.userAgent.toLowerCase()) && (!b || 7 >= b);
                    this.root = ("/" + this.root + "/").replace(C, "/");
                    b && this._wantsHashChange && (this.iframe = m.$('<iframe src="javascript:0" tabindex="-1" />').hide().appendTo("body")[0].contentWindow, this.navigate(a));
                    this._hasPushState ? m.$(window).bind("popstate", this.checkUrl) : this._wantsHashChange && "onhashchange" in window && !b ? m.$(window).bind("hashchange", this.checkUrl) : this._wantsHashChange &&
                        (this._checkUrlInterval = setInterval(this.checkUrl, this.interval));
                    this.fragment = a;
                    a = this.location;
                    b = a.pathname.replace(/[^\/]$/, "$&/") === this.root;
                    if (this._wantsHashChange && this._wantsPushState && !this._hasPushState && !b) return this.fragment = this.getFragment(null, !0), this.location.replace(this.root + this.location.search + "#" + this.fragment), !0;
                    this._wantsPushState && this._hasPushState && (b && a.hash) && (this.fragment = this.getHash().replace(B, ""), this.history.replaceState({}, document.title, this.root + this.fragment +
                        a.search));
                    if (!this.options.silent) return this.loadUrl()
                },
                stop: function () {
                    m.$(window).unbind("popstate", this.checkUrl).unbind("hashchange", this.checkUrl);
                    clearInterval(this._checkUrlInterval);
                    X.started = !1
                },
                route: function (a, b) {
                    this.handlers.unshift({
                        route: a,
                        callback: b
                    })
                },
                checkUrl: function () {
                    var a = this.getFragment();
                    a === this.fragment && this.iframe && (a = this.getFragment(this.getHash(this.iframe)));
                    if (a === this.fragment) return !1;
                    this.iframe && this.navigate(a);
                    this.loadUrl() || this.loadUrl(this.getHash())
                },
                loadUrl: function (a) {
                    var b = this.fragment = this.getFragment(a);
                    return r.any(this.handlers, function (a) {
                        if (a.route.test(b)) return a.callback(b), !0
                    })
                },
                navigate: function (a, b) {
                    if (!X.started) return !1;
                    b && !0 !== b || (b = {
                        trigger: b
                    });
                    a = this.getFragment(a || "");
                    if (this.fragment !== a) {
                        this.fragment = a;
                        var c = this.root + a;
                        if (this._hasPushState) this.history[b.replace ? "replaceState" : "pushState"]({}, document.title, c);
                        else if (this._wantsHashChange) this._updateHash(this.location, a, b.replace), this.iframe && a !== this.getFragment(this.getHash(this.iframe)) &&
                            (b.replace || this.iframe.document.open().close(), this._updateHash(this.iframe.location, a, b.replace));
                        else return this.location.assign(c);
                        b.trigger && this.loadUrl(a)
                    }
                },
                _updateHash: function (a, b, c) {
                    c ? (c = a.href.replace(/(javascript:|#).*$/, ""), a.replace(c + "#" + b)) : a.hash = "#" + b
                }
            });
            m.history = new X;
            var L = m.View = function (a) {
                this.cid = r.uniqueId("view");
                this._configure(a || {});
                this._ensureElement();
                this.initialize.apply(this, arguments);
                this.delegateEvents()
            }, P = /^(\S+)\s*(.*)$/,
                Z = "model collection el id attributes className tagName events".split(" ");
            r.extend(L.prototype, d, {
                tagName: "div",
                $: function (a) {
                    return this.$el.find(a)
                },
                initialize: function () {},
                render: function () {
                    return this
                },
                remove: function () {
                    this.$el.remove();
                    this.stopListening();
                    return this
                },
                make: function (a, b, c) {
                    a = document.createElement(a);
                    b && m.$(a).attr(b);
                    null != c && m.$(a).html(c);
                    return a
                },
                setElement: function (a, b) {
                    this.$el && this.undelegateEvents();
                    this.$el = a instanceof m.$ ? a : m.$(a);
                    this.el = this.$el[0];
                    !1 !== b && this.delegateEvents();
                    return this
                },
                delegateEvents: function (a) {
                    if (a || (a = r.result(this,
                        "events"))) {
                        this.undelegateEvents();
                        for (var b in a) {
                            var c = a[b];
                            r.isFunction(c) || (c = this[a[b]]);
                            if (!c) throw Error('Method "' + a[b] + '" does not exist');
                            var d = b.match(P),
                                e = d[1],
                                d = d[2],
                                c = r.bind(c, this),
                                e = e + (".delegateEvents" + this.cid);
                            "" === d ? this.$el.bind(e, c) : this.$el.delegate(d, e, c)
                        }
                    }
                },
                undelegateEvents: function () {
                    this.$el.unbind(".delegateEvents" + this.cid)
                },
                _configure: function (a) {
                    this.options && (a = r.extend({}, r.result(this, "options"), a));
                    r.extend(this, r.pick(a, Z));
                    this.options = a
                },
                _ensureElement: function () {
                    if (this.el) this.setElement(r.result(this,
                        "el"), !1);
                    else {
                        var a = r.extend({}, r.result(this, "attributes"));
                        this.id && (a.id = r.result(this, "id"));
                        this.className && (a["class"] = r.result(this, "className"));
                        this.setElement(this.make(r.result(this, "tagName"), a), !1)
                    }
                }
            });
            var O = {
                create: "POST",
                update: "PUT",
                patch: "PATCH",
                "delete": "DELETE",
                read: "GET"
            };
            m.sync = function (a, b, d) {
                var e = O[a];
                r.defaults(d || (d = {}), {
                    emulateHTTP: m.emulateHTTP,
                    emulateJSON: m.emulateJSON
                });
                var f = {
                    type: e,
                    dataType: "json"
                };
                d.url || (f.url = r.result(b, "url") || S());
                null != d.data || (!b || "create" !==
                    a && "update" !== a && "patch" !== a) || (f.contentType = "application/json", f.data = c.stringify(d.attrs || b.toJSON(d)));
                d.emulateJSON && (f.contentType = "application/x-www-form-urlencoded", f.data = f.data ? {
                    model: f.data
                } : {});
                if (d.emulateHTTP && ("PUT" === e || "DELETE" === e || "PATCH" === e)) {
                    f.type = "POST";
                    d.emulateJSON && (f.data._method = e);
                    var h = d.beforeSend;
                    d.beforeSend = function (a) {
                        a.setRequestHeader("X-HTTP-Method-Override", e);
                        if (h) return h.apply(this, arguments)
                    }
                }
                "GET" !== f.type && !d.emulateJSON && (f.processData = !1);
                var u = d.success;
                d.success = function (a, c, e) {
                    u && u(a, c, e);
                    b.trigger("sync", b, a, d)
                };
                var v = d.error;
                d.error = function (a) {
                    v && v(b, a, d);
                    b.trigger("error", b, a, d)
                };
                a = m.ajax(r.extend(f, d));
                b.trigger("request", b, a, d);
                return a
            };
            m.ajax = function () {
                return m.$.ajax.apply(m.$, arguments)
            };
            s.extend = y.extend = x.extend = L.extend = X.extend = function (a, b) {
                var c = this,
                    d;
                d = a && r.has(a, "constructor") ? a.constructor : function () {
                    c.apply(this, arguments)
                };
                r.extend(d, c, b);
                var e = function () {
                    this.constructor = d
                };
                e.prototype = c.prototype;
                d.prototype = new e;
                a && r.extend(d.prototype,
                    a);
                d.__super__ = c.prototype;
                return d
            };
            var S = function () {
                throw Error('A "url" property or function must be specified');
            }
        }).call(h);
        h.Backbone = h.noConflict();
        (function (b) {
            var a = function (a) {
                var b = function (a) {
                    var b = [],
                        c, d;
                    if ("undefined" == typeof a || null === a || "" === a) return b;
                    0 === a.indexOf("?") && (a = a.substring(1));
                    c = a.toString().split(/[&;]/);
                    for (a = 0; a < c.length; a++) d = c[a], d = d.split("="), b.push([d[0], d[1]]);
                    return b
                }(a),
                    c = function (a) {
                        a = decodeURIComponent(a);
                        return a = a.replace("+", " ")
                    }, d = function (a, d) {
                        var e = [],
                            m, h, r, n;
                        for (m = 0; m < b.length; m++) h = b[m], r = c(h[0]) === c(a), n = c(h[1]) === c(d), (1 === arguments.length && !r || 2 === arguments.length && !r && !n) && e.push(h);
                        b = e;
                        return this
                    }, h = function (a, c, d) {
                        3 === arguments.length && -1 !== d ? (d = Math.min(d, b.length), b.splice(d, 0, [a, c])) : 0 < arguments.length && b.push([a, c]);
                        return this
                    };
                return {
                    getParamValue: function (a) {
                        var d, e;
                        for (e = 0; e < b.length; e++)
                            if (d = b[e], c(a) === c(d[0])) return d[1]
                    },
                    getParamValues: function (a) {
                        var d = [],
                            e, m;
                        for (e = 0; e < b.length; e++) m = b[e], c(a) === c(m[0]) && d.push(m[1]);
                        return d
                    },
                    deleteParam: d,
                    addParam: h,
                    replaceParam: function (a, e, n) {
                        var q = -1,
                            s, y;
                        if (3 === arguments.length) {
                            for (s = 0; s < b.length; s++)
                                if (y = b[s], c(y[0]) === c(a) && decodeURIComponent(y[1]) === c(n)) {
                                    q = s;
                                    break
                                }
                            d(a, n).addParam(a, e, q)
                        } else {
                            for (s = 0; s < b.length; s++)
                                if (y = b[s], c(y[0]) === c(a)) {
                                    q = s;
                                    break
                                }
                            d(a);
                            h(a, e, q)
                        }
                        return this
                    },
                    toString: function () {
                        var a = "",
                            c, d;
                        for (c = 0; c < b.length; c++) d = b[c], 0 < a.length && (a += "&"), a += d.join("=");
                        return 0 < a.length ? "?" + a : a
                    }
                }
            }, c = function (b) {
                    var f = function (a) {
                        var b = "source protocol authority userInfo user password host port relative path directory file query anchor".split(" ");
                        a = /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/.exec(a);
                        for (var c = {}, d = 14; d--;) c[b[d]] = a[d] || "";
                        c.queryKey = {};
                        c[b[12]].replace(/(?:^|&)([^&=]*)=?([^&]*)/g, function (a, b, d) {
                            b && (c.queryKey[b] = d)
                        });
                        return c
                    }(b || ""),
                        h = new a(f.query),
                        m = function (a) {
                            "undefined" != typeof a && (f.protocol = a);
                            return f.protocol
                        }, r = null,
                        u = function (a) {
                            "undefined" != typeof a && (r = a);
                            return null ===
                                r ? -1 !== f.source.indexOf("//") : r
                        }, n = function (a) {
                            "undefined" != typeof a && (f.userInfo = a);
                            return f.userInfo
                        }, s = function (a) {
                            "undefined" != typeof a && (f.host = a);
                            return f.host
                        }, q = function (a) {
                            "undefined" != typeof a && (f.port = a);
                            return f.port
                        }, y = function (a) {
                            "undefined" != typeof a && (f.path = a);
                            return f.path
                        }, x = function (b) {
                            "undefined" != typeof b && (h = new a(b));
                            return h
                        }, A = function (a) {
                            "undefined" != typeof a && (f.anchor = a);
                            return f.anchor
                        }, E = function () {
                            var a = "",
                                b = function (a) {
                                    return null !== a && "" !== a
                                };
                            b(m()) ? (a += m(), m().indexOf(":") !==
                                m().length - 1 && (a += ":"), a += "//") : u() && b(s()) && (a += "//");
                            b(n()) && b(s()) && (a += n(), n().indexOf("@") !== n().length - 1 && (a += "@"));
                            b(s()) && (a += s(), b(q()) && (a += ":" + q()));
                            b(y()) ? a += y() : b(s()) && (b(x().toString()) || b(A())) && (a += "/");
                            b(x().toString()) && (0 !== x().toString().indexOf("?") && (a += "?"), a += x().toString());
                            b(A()) && (0 !== A().indexOf("#") && (a += "#"), a += A());
                            return a
                        };
                    return {
                        protocol: m,
                        hasAuthorityPrefix: u,
                        userInfo: n,
                        host: s,
                        port: q,
                        path: y,
                        query: x,
                        anchor: A,
                        setProtocol: function (a) {
                            m(a);
                            return this
                        },
                        setHasAuthorityPrefix: function (a) {
                            u(a);
                            return this
                        },
                        setUserInfo: function (a) {
                            n(a);
                            return this
                        },
                        setHost: function (a) {
                            s(a);
                            return this
                        },
                        setPort: function (a) {
                            q(a);
                            return this
                        },
                        setPath: function (a) {
                            y(a);
                            return this
                        },
                        setQuery: function (a) {
                            x(a);
                            return this
                        },
                        setAnchor: function (a) {
                            A(a);
                            return this
                        },
                        getQueryParamValue: function (a) {
                            return x().getParamValue(a)
                        },
                        getQueryParamValues: function (a) {
                            return x().getParamValues(a)
                        },
                        deleteQueryParam: function (a, b) {
                            2 === arguments.length ? x().deleteParam(a, b) : x().deleteParam(a);
                            return this
                        },
                        addQueryParam: function (a, b,
                            c) {
                            3 === arguments.length ? x().addParam(a, b, c) : x().addParam(a, b);
                            return this
                        },
                        replaceQueryParam: function (a, b, c) {
                            3 === arguments.length ? x().replaceParam(a, b, c) : x().replaceParam(a, b);
                            return this
                        },
                        toString: E,
                        clone: function () {
                            return new c(E())
                        }
                    }
                };
            b.Uri = c
        })(h);
        window.define && define.amd && (define("Backbone", [], function () {
            return h.Backbone
        }), define("Underscore", [], function () {
            return h._
        }), define("jsuri", [], function () {
            return h.Uri
        }), define("JSON", [], function () {
            return h.JSON
        }))
    })("undefined" == typeof n ? {} : n);
    (function () {
        var h = {
            author: "M@ McCray <darthapo@gmail.com>",
            version: "1.2.1",
            readTemplateFile: function (c) {
                throw "This liquid context does not allow includes.";
            },
            registerFilters: function (c) {
                h.Template.registerFilter(c)
            },
            parse: function (c) {
                return h.Template.parse(c)
            }
        };
        Array.prototype.indexOf || (Array.prototype.indexOf = function (c) {
            for (var b = 0; b < this.length; b++)
                if (this[b] == c) return b;
            return -1
        });
        Array.prototype.clear || (Array.prototype.clear = function () {
            this.length = 0
        });
        Array.prototype.map || (Array.prototype.map = function (c, b) {
            var a =
                this.length;
            if ("function" != typeof c) throw "Array.map requires first argument to be a function";
            for (var d = Array(a), e = 0; e < a; e++) e in this && (d[e] = c.call(b, this[e], e, this));
            return d
        });
        Array.prototype.first || (Array.prototype.first = function () {
            return this[0]
        });
        Array.prototype.last || (Array.prototype.last = function () {
            return this[this.length - 1]
        });
        Array.prototype.flatten || (Array.prototype.flatten = function () {
            for (var c = this.length, b = [], a = 0; a < c; a++) this[a] instanceof Array ? b = b.concat(this[a]) : b.push(this[a]);
            return b
        });
        Array.prototype.each || (Array.prototype.each = function (c, b) {
            var a = this.length;
            if ("function" != typeof c) throw "Array.each requires first argument to be a function";
            for (var d = 0; d < a; d++) d in this && c.call(b, this[d], d, this);
            return null
        });
        Array.prototype.include || (Array.prototype.include = function (c) {
            return 0 <= this.indexOf(c)
        });
        String.prototype.capitalize || (String.prototype.capitalize = function () {
            return this.charAt(0).toUpperCase() + this.substring(1).toLowerCase()
        });
        String.prototype.strip || (String.prototype.strip =
            function () {
                return this.replace(/^\s+/, "").replace(/\s+$/, "")
            });
        h.extensions = {};
        h.extensions.object = {};
        h.extensions.object.update = function (c) {
            for (var b in c) this[b] = c[b];
            return this
        };
        h.extensions.object.hasKey = function (c) {
            return !!this[c]
        };
        h.extensions.object.hasValue = function (c) {
            for (var b in this)
                if (this[b] == c) return !0;
            return !1
        };
        var y = function () {
            var c = !1,
                b = /xyz/.test(function () {
                    xyz
                }) ? /\b_super\b/ : /.*/,
                a = function () {};
            a.extend = function (a) {
                function e() {
                    !c && this.init && this.init.apply(this, arguments)
                }
                var f =
                    this.prototype;
                c = !0;
                var h = new this;
                c = !1;
                for (var m in a) h[m] = "function" == typeof a[m] && "function" == typeof f[m] && b.test(a[m]) ? function (a, b) {
                    return function () {
                        var c = this._super;
                        this._super = f[a];
                        var d = b.apply(this, arguments);
                        this._super = c;
                        return d
                    }
                }(m, a[m]) : a[m];
                e.prototype = h;
                e.prototype.constructor = e;
                e.extend = arguments.callee;
                return e
            };
            return a
        }();
        h.Tag = y.extend({
            init: function (c, b, a) {
                this.tagName = c;
                this.markup = b;
                this.nodelist = this.nodelist || [];
                this.parse(a)
            },
            parse: function (c) {},
            render: function (c) {
                return ""
            }
        });
        h.Block = h.Tag.extend({
            init: function (c, b, a) {
                this.blockName = c;
                this.blockDelimiter = "end" + this.blockName;
                this._super(c, b, a)
            },
            parse: function (c) {
                this.nodelist || (this.nodelist = []);
                this.nodelist.clear();
                var b = c.shift();
                for (c.push(""); c.length;) {
                    if (/^\{\%/.test(b)) {
                        var a = b.match(/^\{\%\s*(\w+)\s*(.*)?\%\}$/);
                        if (a) {
                            if (this.blockDelimiter == a[1]) {
                                this.endTag();
                                return
                            }
                            a[1] in h.Template.tags ? this.nodelist.push(new h.Template.tags[a[1]](a[1], a[2], c)) : this.unknownTag(a[1], a[2], c)
                        } else throw "Tag '" + b + "' was not properly terminated with: %}";
                    } else /^\{\{/.test(b) ? this.nodelist.push(this.createVariable(b)) : this.nodelist.push(b);
                    b = c.shift()
                }
                this.assertMissingDelimitation()
            },
            endTag: function () {},
            unknownTag: function (c, b, a) {
                switch (c) {
                case "else":
                    throw this.blockName + " tag does not expect else tag";
                case "end":
                    throw "'end' is not a valid delimiter for " + this.blockName + " tags. use " + this.blockDelimiter;
                default:
                    throw "Unknown tag: " + c;
                }
            },
            createVariable: function (c) {
                var b = c.match(/^\{\{(.*)\}\}$/);
                if (b) return new h.Variable(b[1]);
                throw "Variable '" +
                    c + "' was not properly terminated with: }}";
            },
            render: function (c) {
                return this.renderAll(this.nodelist, c)
            },
            renderAll: function (c, b) {
                return (c || []).map(function (a, c) {
                    var e = "";
                    try {
                        e = a.render ? a.render(b) : a
                    } catch (f) {
                        e = b.handleError(f)
                    }
                    return e
                })
            },
            assertMissingDelimitation: function () {
                throw this.blockName + " tag was never closed";
            }
        });
        h.Document = h.Block.extend({
            init: function (c) {
                this.blockDelimiter = [];
                this.parse(c)
            },
            assertMissingDelimitation: function () {}
        });
        h.Strainer = y.extend({
            init: function (c) {
                this.context = c
            },
            respondTo: function (c) {
                c = c.toString();
                return c.match(/^__/) || h.Strainer.requiredMethods.include(c) ? !1 : c in this
            }
        });
        h.Strainer.filters = {};
        h.Strainer.globalFilter = function (c) {
            for (var b in c) h.Strainer.filters[b] = c[b]
        };
        h.Strainer.requiredMethods = ["respondTo", "context"];
        h.Strainer.create = function (c) {
            c = new h.Strainer(c);
            for (var b in h.Strainer.filters) c[b] = h.Strainer.filters[b];
            return c
        };
        h.Context = y.extend({
            init: function (c, b, a) {
                this.scopes = [c ? c : {}];
                this.registers = b ? b : {};
                this.errors = [];
                this.rethrowErrors =
                    a;
                this.strainer = h.Strainer.create(this)
            },
            get: function (c) {
                return this.resolve(c)
            },
            set: function (c, b) {
                this.scopes[0][c] = b
            },
            hasKey: function (c) {
                return this.resolve(c) ? !0 : !1
            },
            push: function () {
                var c = {};
                this.scopes.unshift(c);
                return c
            },
            merge: function (c) {
                return h.extensions.object.update.call(this.scopes[0], c)
            },
            pop: function () {
                if (1 == this.scopes.length) throw "Context stack error";
                return this.scopes.shift()
            },
            stack: function (c, b) {
                var a = null;
                this.push();
                try {
                    a = c.apply(b ? b : this.strainer)
                } finally {
                    this.pop()
                }
                return a
            },
            invoke: function (c, b) {
                return this.strainer.respondTo(c) ? this.strainer[c].apply(this.strainer, b) : 0 == b.length ? null : b[0]
            },
            resolve: function (c) {
                switch (c) {
                case null:
                case "nil":
                case "null":
                case "":
                    return null;
                case "true":
                    return !0;
                case "false":
                    return !1;
                case "blank":
                case "empty":
                    return "";
                default:
                    if (/^'(.*)'$/.test(c)) return c.replace(/^'(.*)'$/, "$1");
                    if (/^"(.*)"$/.test(c)) return c.replace(/^"(.*)"$/, "$1");
                    if (/^(\d+)$/.test(c)) return parseInt(c.replace(/^(\d+)$/, "$1"));
                    if (/^(\d[\d\.]+)$/.test(c)) return parseFloat(c.replace(/^(\d[\d\.]+)$/,
                        "$1"));
                    if (/^\((\S+)\.\.(\S+)\)$/.test(c)) {
                        var b = c.match(/^\((\S+)\.\.(\S+)\)$/);
                        c = parseInt(b[1]);
                        var a = parseInt(b[2]),
                            d = [];
                        if (isNaN(c) || isNaN(a))
                            for (c = b[1].charCodeAt(0), a = b[2].charCodeAt(0), b = a - c + 1, a = 0; a < b; a++) d.push(String.fromCharCode(a + c));
                        else
                            for (b = a - c + 1, a = 0; a < b; a++) d.push(a + c);
                        return d
                    }
                    return this.variable(c)
                }
            },
            findVariable: function (c) {
                for (var b = 0; b < this.scopes.length; b++) {
                    var a = this.scopes[b];
                    if (a && "undefined" !== typeof a[c]) return b = a[c], "function" == typeof b && (b = b.apply(this), a[c] = b), b && ("object" ==
                        typeof b && "toLiquid" in b) && (b = b.toLiquid()), b && ("object" == typeof b && "setContext" in b) && b.setContext(self), b
                }
                return null
            },
            variable: function (c) {
                if ("string" != typeof c) return null;
                c = c.match(/\[[^\]]+\]|(?:[\w\-]\??)+/g);
                var b = c.shift(),
                    a = b.match(/^\[(.*)\]$/);
                a && (b = this.resolve(a[1]));
                var d = this.findVariable(b),
                    e = this;
                d && c.each(function (a) {
                    var b = a.match(/^\[(.*)\]$/);
                    if (b) a = e.resolve(b[1]), "function" == typeof d[a] && (d[a] = d[a].apply(this)), d = d[a], "object" == typeof d && "toLiquid" in d && (d = d.toLiquid());
                    else {
                        if (("object" ==
                            typeof d || "hash" == typeof d) && a in d) b = d[a], "function" == typeof b && (b = d[a] = b.apply(e)), d = "object" == typeof b && "toLiquid" in b ? b.toLiquid() : b;
                        else if (/^\d+$/.test(a)) a = parseInt(a), "function" == typeof d[a] && (d[a] = d[a].apply(e)), d = "object" == typeof d[a] && "object" == typeof d[a] && "toLiquid" in d[a] ? d[a].toLiquid() : d[a];
                        else if (d && "function" == typeof d[a] && ["length", "size", "first", "last"].include(a)) d = d[a].apply(a), "toLiquid" in d && (d = d.toLiquid());
                        else return d = null;
                        "object" == typeof d && "setContext" in d && d.setContext(e)
                    }
                });
                return d
            },
            addFilters: function (c) {
                c = c.flatten();
                c.each(function (b) {
                    if ("object" != typeof b) throw "Expected object but got: " + typeof b;
                    this.strainer.addMethods(b)
                })
            },
            handleError: function (c) {
                this.errors.push(c);
                if (this.rethrowErrors) throw c;
                return "Liquid error: " + (c.message ? c.message : c.description ? c.description : c)
            }
        });
        h.Template = y.extend({
            init: function () {
                this.root = null;
                this.registers = {};
                this.assigns = {};
                this.errors = [];
                this.rethrowErrors = !1
            },
            parse: function (c) {
                this.root = new h.Document(h.Template.tokenize(c));
                return this
            },
            render: function (c, b, a) {
                if (!this.root) return "";
                var d = null;
                c instanceof h.Context ? (d = c, this.assigns = d.assigns, this.registers = d.registers) : (c && h.extensions.object.update.call(this.assigns, c), a && h.extensions.object.update.call(this.registers, a), d = new h.Context(this.assigns, this.registers, this.rethrowErrors));
                b && d.addFilters(arg.filters);
                try {
                    return this.root.render(d).join("")
                } finally {
                    this.errors = d.errors
                }
            },
            renderWithErrors: function () {
                var c = this.rethrowErrors;
                this.rethrowErrors = !0;
                var b = this.render.apply(this,
                    arguments);
                this.rethrowErrors = c;
                return b
            }
        });
        h.Template.tags = {};
        h.Template.registerTag = function (c, b) {
            h.Template.tags[c] = b
        };
        h.Template.registerFilter = function (c) {
            h.Strainer.globalFilter(c)
        };
        h.Template.tokenize = function (c) {
            c = c.split(/(\{\%.*?\%\}|\{\{.*?\}\}?)/);
            "" == c[0] && c.shift();
            return c
        };
        h.Template.parse = function (c) {
            return (new h.Template).parse(c)
        };
        h.Variable = y.extend({
            init: function (c) {
                this.markup = c;
                this.name = null;
                this.filters = [];
                var b = this,
                    a = c.match(/\s*("[^"]+"|'[^']+'|[^\s,|]+)/);
                a && (this.name =
                    a[1], (c = c.match(/\|\s*(.*)/)) && c[1].split(/\|/).each(function (a) {
                        var c = a.match(/\s*(\w+)/);
                        if (c) {
                            var c = c[1],
                                f = [];
                            (a.match(/(?:[:|,]\s*)("[^"]+"|'[^']+'|[^\s,|]+)/g) || []).flatten().each(function (a) {
                                    (a = a.match(/^[\s|:|,]*(.*?)[\s]*$/)) && f.push(a[1])
                                });
                            b.filters.push([c, f])
                        }
                    }))
            },
            render: function (c) {
                if (null == this.name) return "";
                var b = c.get(this.name);
                this.filters.each(function (a) {
                    var d = a[0];
                    a = (a[1] || []).map(function (a) {
                        return c.get(a)
                    });
                    a.unshift(b);
                    b = c.invoke(d, a)
                });
                return b
            }
        });
        h.Condition = y.extend({
            init: function (c,
                b, a) {
                this.left = c;
                this.operator = b;
                this.right = a;
                this.attachment = this.childCondition = this.childRelation = null
            },
            evaluate: function (c) {
                c = c || new h.Context;
                var b = this.interpretCondition(this.left, this.right, this.operator, c);
                switch (this.childRelation) {
                case "or":
                    return b || this.childCondition.evaluate(c);
                case "and":
                    return b && this.childCondition.evaluate(c);
                default:
                    return b
                }
            },
            or: function (c) {
                this.childRelation = "or";
                this.childCondition = c
            },
            and: function (c) {
                this.childRelation = "and";
                this.childCondition = c
            },
            attach: function (c) {
                return this.attachment =
                    c
            },
            isElse: !1,
            interpretCondition: function (c, b, a, d) {
                if (!a) return d.get(c);
                c = d.get(c);
                b = d.get(b);
                a = h.Condition.operators[a];
                if (!a) throw "Unknown operator " + a;
                return a(c, b)
            },
            toString: function () {
                return "<Condition " + this.left + " " + this.operator + " " + this.right + ">"
            }
        });
        h.Condition.operators = {
            "==": function (c, b) {
                return c == b
            },
            "=": function (c, b) {
                return c == b
            },
            "!=": function (c, b) {
                return c != b
            },
            "<>": function (c, b) {
                return c != b
            },
            "<": function (c, b) {
                return c < b
            },
            ">": function (c, b) {
                return c > b
            },
            "<=": function (c, b) {
                return c <= b
            },
            ">=": function (c, b) {
                return c >= b
            },
            contains: function (c, b) {
                return c.include(b)
            },
            hasKey: function (c, b) {
                return h.extensions.object.hasKey.call(c, b)
            },
            hasValue: function (c, b) {
                return h.extensions.object.hasValue.call(c, b)
            }
        };
        h.ElseCondition = h.Condition.extend({
            isElse: !0,
            evaluate: function (c) {
                return !0
            },
            toString: function () {
                return "<ElseCondition>"
            }
        });
        h.Drop = y.extend({
            setContext: function (c) {
                this.context = c
            },
            beforeMethod: function (c) {},
            invokeDrop: function (c) {
                var b = this.beforeMethod();
                !b && c in this && (b = this[c].apply(this));
                return b
            },
            hasKey: function (c) {
                return !0
            }
        });
        var s = function (c, b) {
            if ("function" != typeof c) throw "Object.each requires first argument to be a function";
            var a = 0,
                d;
            for (d in this) {
                var e = this[d],
                    f = [d, e];
                f.key = d;
                f.value = e;
                c.call(b, f, a, this);
                a++
            }
            return null
        };
        h.Template.registerTag("assign", h.Tag.extend({
            tagSyntax: /((?:\(?[\w\-\.\[\]]\)?)+)\s*=\s*((?:"[^"]+"|'[^']+'|[^\s,|]+)+)/,
            init: function (c, b, a) {
                var d = b.match(this.tagSyntax);
                if (d) this.to = d[1], this.from = d[2];
                else throw "Syntax error in 'assign' - Valid syntax: assign [var] = [source]";
                this._super(c, b, a)
            },
            render: function (c) {
                c.scopes.last()[this.to.toString()] = c.get(this.from);
                return ""
            }
        }));
        h.Template.registerTag("cache", h.Block.extend({
            tagSyntax: /(\w+)/,
            init: function (c, b, a) {
                var d = b.match(this.tagSyntax);
                if (d) this.to = d[1];
                else throw "Syntax error in 'cache' - Valid syntax: cache [var]";
                this._super(c, b, a)
            },
            render: function (c) {
                var b = this._super(c);
                c.scopes.last()[this.to] = [b].flatten().join("");
                return ""
            }
        }));
        h.Template.registerTag("capture", h.Block.extend({
            tagSyntax: /(\w+)/,
            init: function (c,
                b, a) {
                var d = b.match(this.tagSyntax);
                if (d) this.to = d[1];
                else throw "Syntax error in 'capture' - Valid syntax: capture [var]";
                this._super(c, b, a)
            },
            render: function (c) {
                var b = this._super(c);
                c.set(this.to, [b].flatten().join(""));
                return ""
            }
        }));
        h.Template.registerTag("case", h.Block.extend({
            tagSyntax: /("[^"]+"|'[^']+'|[^\s,|]+)/,
            tagWhenSyntax: /("[^"]+"|'[^']+'|[^\s,|]+)(?:(?:\s+or\s+|\s*\,\s*)("[^"]+"|'[^']+'|[^\s,|]+.*))?/,
            init: function (c, b, a) {
                this.blocks = [];
                this.nodelist = [];
                var d = b.match(this.tagSyntax);
                if (d) this.left =
                    d[1];
                else throw "Syntax error in 'case' - Valid syntax: case [condition]";
                this._super(c, b, a)
            },
            unknownTag: function (c, b, a) {
                switch (c) {
                case "when":
                    this.recordWhenCondition(b);
                    break;
                case "else":
                    this.recordElseCondition(b);
                    break;
                default:
                    this._super(c, b, a)
                }
            },
            render: function (c) {
                var b = this,
                    a = [],
                    d = !0;
                c.stack(function () {
                    for (var e = 0; e < b.blocks.length; e++) {
                        var f = b.blocks[e];
                        if (f.isElse) return !0 == d && (a = [a, b.renderAll(f.attachment, c)].flatten()), a;
                        f.evaluate(c) && (d = !1, a = [a, b.renderAll(f.attachment, c)].flatten())
                    }
                });
                return a
            },
            recordWhenCondition: function (c) {
                for (; c;) {
                    var b = c.match(this.tagWhenSyntax);
                    if (!b) throw "Syntax error in tag 'case' - Valid when condition: {% when [condition] [or condition2...] %} ";
                    c = b[2];
                    b = new h.Condition(this.left, "==", b[1]);
                    this.blocks.push(b);
                    this.nodelist = b.attach([])
                }
            },
            recordElseCondition: function (c) {
                if ("" != (c || "").strip()) throw "Syntax error in tag 'case' - Valid else condition: {% else %} (no parameters) ";
                c = new h.ElseCondition;
                this.blocks.push(c);
                this.nodelist = c.attach([])
            }
        }));
        h.Template.registerTag("comment", h.Block.extend({
            render: function (c) {
                return ""
            }
        }));
        h.Template.registerTag("cycle", h.Tag.extend({
            tagSimpleSyntax: /"[^"]+"|'[^']+'|[^\s,|]+/,
            tagNamedSyntax: /("[^"]+"|'[^']+'|[^\s,|]+)\s*\:\s*(.*)/,
            init: function (c, b, a) {
                var d;
                if (d = b.match(this.tagNamedSyntax)) this.variables = this.variablesFromString(d[2]), this.name = d[1];
                else if (d = b.match(this.tagSimpleSyntax)) this.variables = this.variablesFromString(b), this.name = "'" + this.variables.toString() + "'";
                else throw "Syntax error in 'cycle' - Valid syntax: cycle [name :] var [, var2, var3 ...]";
                this._super(c, b, a)
            },
            render: function (c) {
                var b = this,
                    a = c.get(b.name),
                    d = "";
                c.registers.cycle || (c.registers.cycle = {});
                c.registers.cycle[a] || (c.registers.cycle[a] = 0);
                c.stack(function () {
                    var e = c.registers.cycle[a],
                        f = c.get(b.variables[e]),
                        e = e + 1;
                    e == b.variables.length && (e = 0);
                    c.registers.cycle[a] = e;
                    d = f
                });
                return d
            },
            variablesFromString: function (c) {
                return c.split(",").map(function (b) {
                    b = b.match(/\s*("[^"]+"|'[^']+'|[^\s,|]+)\s*/);
                    return b[1] ? b[1] : null
                })
            }
        }));
        h.Template.registerTag("for", h.Block.extend({
            tagSyntax: /(\w+)\s+in\s+((?:\(?[\w\-\.\[\]]\)?)+)/,
            init: function (c, b, a) {
                var d = b.match(this.tagSyntax);
                if (d) this.variableName = d[1], this.collectionName = d[2], this.name = this.variableName + "-" + this.collectionName, this.attributes = {}, b.replace(this.tagSyntax, ""), (d = b.match(/(\w*?)\s*\:\s*("[^"]+"|'[^']+'|[^\s,|]+)/g)) && d.each(function (a) {
                    a = a.split(":");
                    this.attributes.set[a[0].strip()] = a[1].strip()
                }, this);
                else throw "Syntax error in 'for loop' - Valid syntax: for [item] in [collection]";
                this._super(c, b, a)
            },
            render: function (c) {
                var b = this,
                    a = [],
                    d = c.get(this.collectionName) || [],
                    e = [0, d.length];
                c.registers["for"] || (c.registers["for"] = {});
                if (this.attributes.limit || this.attributes.offset) {
                    var f = e = 0,
                        f = 0,
                        h = null,
                        e = "continue" == this.attributes.offset ? c.registers["for"][this.name] : c.get(this.attributes.offset) || 0,
                        f = (f = c.get(this.attributes.limit)) ? e + f + 1 : d.length,
                        e = [e, f - 1];
                    c.registers["for"][this.name] = f
                }
                h = d.slice(e[0], e[1]);
                if (!h || 0 == h.length) return "";
                c.stack(function () {
                    var d = h.length;
                    h.each(function (e, f) {
                        c.set(b.variableName, e);
                        c.set("forloop", {
                            name: b.name,
                            length: d,
                            index: f + 1,
                            index0: f,
                            rindex: d - f,
                            rindex0: d - f - 1,
                            first: 0 == f,
                            last: f == d - 1
                        });
                        a.push((b.renderAll(b.nodelist, c) || []).join(""))
                    })
                });
                return [a].flatten().join("")
            }
        }));
        h.Template.registerTag("if", h.Block.extend({
            tagSyntax: /("[^"]+"|'[^']+'|[^\s,|]+)\s*([=!<>a-z_]+)?\s*("[^"]+"|'[^']+'|[^\s,|]+)?/,
            init: function (c, b, a) {
                this.nodelist = [];
                this.blocks = [];
                this.pushBlock("if", b);
                this._super(c, b, a)
            },
            unknownTag: function (c, b, a) {
                ["elsif", "else"].include(c) ? this.pushBlock(c, b) : this._super(c, b, a)
            },
            render: function (c) {
                var b = this,
                    a = "";
                c.stack(function () {
                    for (var d = 0; d < b.blocks.length; d++) {
                        var e = b.blocks[d];
                        if (e.evaluate(c)) {
                            a = b.renderAll(e.attachment, c);
                            break
                        }
                    }
                });
                return [a].flatten().join("")
            },
            pushBlock: function (c, b) {
                var a;
                if ("else" == c) a = new h.ElseCondition;
                else {
                    a = b.split(/\b(and|or)\b/).reverse();
                    var d = a.shift().match(this.tagSyntax);
                    if (!d) throw "Syntax Error in tag '" + c + "' - Valid syntax: " + c + " [expression]";
                    for (var e = new h.Condition(d[1], d[2], d[3]); 0 < a.length;) {
                        var f = a.shift(),
                            d = a.shift().match(this.tagSyntax);
                        if (!d) throw "Syntax Error in tag '" +
                            c + "' - Valid syntax: " + c + " [expression]";
                        d = new h.Condition(d[1], d[2], d[3]);
                        d[f](e);
                        e = d
                    }
                    a = e
                }
                a.attach([]);
                this.blocks.push(a);
                this.nodelist = a.attachment
            }
        }));
        h.Template.registerTag("ifchanged", h.Block.extend({
            render: function (c) {
                var b = this,
                    a = "";
                c.stack(function () {
                    var d = b.renderAll(b.nodelist, c).join("");
                    d != c.registers.ifchanged && (a = d, c.registers.ifchanged = a)
                });
                return a
            }
        }));
        h.Template.registerTag("include", h.Tag.extend({
            tagSyntax: /((?:"[^"]+"|'[^']+'|[^\s,|]+)+)(\s+(?:with|for)\s+((?:"[^"]+"|'[^']+'|[^\s,|]+)+))?/,
            init: function (c, b, a) {
                var d = (b || "").match(this.tagSyntax);
                if (d) this.templateName = d[1], this.templateNameVar = this.templateName.substring(1, this.templateName.length - 1), this.variableName = d[3], this.attributes = {}, (d = b.match(/(\w*?)\s*\:\s*("[^"]+"|'[^']+'|[^\s,|]+)/g)) && d.each(function (a) {
                    a = a.split(":");
                    this.attributes[a[0].strip()] = a[1].strip()
                }, this);
                else throw "Error in tag 'include' - Valid syntax: include '[template]' (with|for) [object|collection]";
                this._super(c, b, a)
            },
            render: function (c) {
                var b = this,
                    a = h.readTemplateFile(c.get(this.templateName)),
                    d = h.parse(a),
                    e = c.get(this.variableName || this.templateNameVar),
                    f = "";
                c.stack(function () {
                    b.attributes.each = s;
                    b.attributes.each(function (a) {
                        c.set(a.key, c.get(a.value))
                    });
                    e instanceof Array ? f = e.map(function (a) {
                        c.set(b.templateNameVar, a);
                        return d.render(c)
                    }) : (c.set(b.templateNameVar, e), f = d.render(c))
                });
                return f = [f].flatten().join("")
            }
        }));
        h.Template.registerTag("unless", h.Template.tags["if"].extend({
            render: function (c) {
                var b = this,
                    a = "";
                c.stack(function () {
                    var d =
                        b.blocks[0];
                    if (d.evaluate(c))
                        for (var e = 1; e < b.blocks.length; e++) {
                            if (d = b.blocks[e], d.evaluate(c)) {
                                a = b.renderAll(d.attachment, c);
                                break
                            }
                        } else a = b.renderAll(d.attachment, c)
                });
                return a
            }
        }));
        h.Template.registerFilter({
            size: function (c) {
                return c.length ? c.length : 0
            },
            downcase: function (c) {
                return c.toString().toLowerCase()
            },
            upcase: function (c) {
                return c.toString().toUpperCase()
            },
            capitalize: function (c) {
                return c.toString().capitalize()
            },
            escape: function (c) {
                c = c.toString();
                c = c.replace(/&/g, "&amp;");
                c = c.replace(/</g, "&lt;");
                c = c.replace(/>/g, "&gt;");
                return c = c.replace(/"/g, "&quot;")
            },
            h: function (c) {
                c = c.toString();
                c = c.replace(/&/g, "&amp;");
                c = c.replace(/</g, "&lt;");
                c = c.replace(/>/g, "&gt;");
                return c = c.replace(/"/g, "&quot;")
            },
            truncate: function (c, b, a) {
                if (!c || "" == c) return "";
                b = b || 50;
                a = a || "...";
                c.slice(0, b);
                return c.length > b ? c.slice(0, b) + a : c
            },
            truncatewords: function (c, b, a) {
                if (!c || "" == c) return "";
                b = parseInt(b || 15);
                a = a || "...";
                var d = c.toString().split(" ");
                b = Math.max(b, 0);
                return d.length > b ? d.slice(0, b).join(" ") + a : c
            },
            truncate_words: function (c,
                b, a) {
                if (!c || "" == c) return "";
                b = parseInt(b || 15);
                a = a || "...";
                var d = c.toString().split(" ");
                b = Math.max(b, 0);
                return d.length > b ? d.slice(0, b).join(" ") + a : c
            },
            strip_html: function (c) {
                return c.toString().replace(/<.*?>/g, "")
            },
            strip_newlines: function (c) {
                return c.toString().replace(/\n/g, "")
            },
            join: function (c, b) {
                return c.join(b || " ")
            },
            sort: function (c) {
                return c.sort()
            },
            reverse: function (c) {
                return c.reverse()
            },
            replace: function (c, b, a) {
                return c.toString().replace(RegExp(b, "g"), a || "")
            },
            replace_first: function (c, b, a) {
                return c.toString().replace(RegExp(b,
                    ""), a || "")
            },
            newline_to_br: function (c) {
                return c.toString().replace(/\n/g, "<br/>\n")
            },
            date: function (c, b) {
                var a;
                c instanceof Date && (a = c);
                a instanceof Date || "now" != c || (a = new Date);
                a instanceof Date || (a = new Date(c));
                a instanceof Date || (a = new Date(Date.parse(c)));
                return a instanceof Date ? a.strftime(b) : c
            },
            first: function (c) {
                return c[0]
            },
            last: function (c) {
                return c[c.length - 1]
            }
        });
        (new Date).strftime || function () {
            Date.ext = {};
            Date.ext.util = {};
            Date.ext.util.xPad = function (c, b, a) {
                for ("undefined" == typeof a && (a = 10); parseInt(c,
                    10) < a && 1 < a; a /= 10) c = b.toString() + c;
                return c.toString()
            };
            Date.prototype.locale = "en-GB";
            document.getElementsByTagName("html") && document.getElementsByTagName("html")[0].lang && (Date.prototype.locale = document.getElementsByTagName("html")[0].lang);
            Date.ext.locales = {};
            Date.ext.locales.en = {
                a: "Sun Mon Tue Wed Thu Fri Sat".split(" "),
                A: "Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" "),
                b: "Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" "),
                B: "January February March April May June July August September October November December".split(" "),
                c: "%a %d %b %Y %T %Z",
                p: ["AM", "PM"],
                P: ["am", "pm"],
                x: "%d/%m/%y",
                X: "%T"
            };
            Date.ext.locales["en-US"] = Date.ext.locales.en;
            Date.ext.locales["en-US"].c = "%a %d %b %Y %r %Z";
            Date.ext.locales["en-US"].x = "%D";
            Date.ext.locales["en-US"].X = "%r";
            Date.ext.locales["en-GB"] = Date.ext.locales.en;
            Date.ext.locales["en-AU"] = Date.ext.locales["en-GB"];
            Date.ext.formats = {
                a: function (c) {
                    return Date.ext.locales[c.locale].a[c.getDay()]
                },
                A: function (c) {
                    return Date.ext.locales[c.locale].A[c.getDay()]
                },
                b: function (c) {
                    return Date.ext.locales[c.locale].b[c.getMonth()]
                },
                B: function (c) {
                    return Date.ext.locales[c.locale].B[c.getMonth()]
                },
                c: "toLocaleString",
                C: function (c) {
                    return Date.ext.util.xPad(parseInt(c.getFullYear() / 100, 10), 0)
                },
                d: ["getDate", "0"],
                e: ["getDate", " "],
                g: function (c) {
                    return Date.ext.util.xPad(parseInt(Date.ext.util.G(c) / 100, 10), 0)
                },
                G: function (c) {
                    var b = c.getFullYear(),
                        a = parseInt(Date.ext.formats.V(c), 10);
                    c = parseInt(Date.ext.formats.W(c), 10);
                    c > a ? b++ : 0 === c && 52 <= a && b--;
                    return b
                },
                H: ["getHours", "0"],
                I: function (c) {
                    c = c.getHours() % 12;
                    return Date.ext.util.xPad(0 ===
                        c ? 12 : c, 0)
                },
                j: function (c) {
                    var b = c - new Date("" + c.getFullYear() + "/1/1 GMT"),
                        b = b + 6E4 * c.getTimezoneOffset();
                    c = parseInt(b / 6E4 / 60 / 24, 10) + 1;
                    return Date.ext.util.xPad(c, 0, 100)
                },
                m: function (c) {
                    return Date.ext.util.xPad(c.getMonth() + 1, 0)
                },
                M: ["getMinutes", "0"],
                p: function (c) {
                    return Date.ext.locales[c.locale].p[12 <= c.getHours() ? 1 : 0]
                },
                P: function (c) {
                    return Date.ext.locales[c.locale].P[12 <= c.getHours() ? 1 : 0]
                },
                S: ["getSeconds", "0"],
                u: function (c) {
                    c = c.getDay();
                    return 0 === c ? 7 : c
                },
                U: function (c) {
                    var b = parseInt(Date.ext.formats.j(c),
                        10);
                    c = 6 - c.getDay();
                    b = parseInt((b + c) / 7, 10);
                    return Date.ext.util.xPad(b, 0)
                },
                V: function (c) {
                    var b = parseInt(Date.ext.formats.W(c), 10),
                        a = (new Date("" + c.getFullYear() + "/1/1")).getDay(),
                        b = b + (4 < a || 1 >= a ? 0 : 1);
                    53 == b && 4 > (new Date("" + c.getFullYear() + "/12/31")).getDay() ? b = 1 : 0 === b && (b = Date.ext.formats.V(new Date("" + (c.getFullYear() - 1) + "/12/31")));
                    return Date.ext.util.xPad(b, 0)
                },
                w: "getDay",
                W: function (c) {
                    var b = parseInt(Date.ext.formats.j(c), 10);
                    c = 7 - Date.ext.formats.u(c);
                    b = parseInt((b + c) / 7, 10);
                    return Date.ext.util.xPad(b,
                        0, 10)
                },
                y: function (c) {
                    return Date.ext.util.xPad(c.getFullYear() % 100, 0)
                },
                Y: "getFullYear",
                z: function (c) {
                    c = c.getTimezoneOffset();
                    var b = Date.ext.util.xPad(parseInt(Math.abs(c / 60), 10), 0),
                        a = Date.ext.util.xPad(c % 60, 0);
                    return (0 < c ? "-" : "+") + b + a
                },
                Z: function (c) {
                    return c.toString().replace(/^.*\(([^)]+)\)$/, "$1")
                },
                "%": function (c) {
                    return "%"
                }
            };
            Date.ext.aggregates = {
                c: "locale",
                D: "%m/%d/%y",
                h: "%b",
                n: "\n",
                r: "%I:%M:%S %p",
                R: "%H:%M",
                t: "\t",
                T: "%H:%M:%S",
                x: "locale",
                X: "locale"
            };
            Date.ext.aggregates.z = Date.ext.formats.z(new Date);
            Date.ext.aggregates.Z = Date.ext.formats.Z(new Date);
            Date.ext.unsupported = {};
            Date.prototype.strftime = function (c) {
                this.locale in Date.ext.locales || (this.locale.replace(/-[a-zA-Z]+$/, "") in Date.ext.locales ? this.locale = this.locale.replace(/-[a-zA-Z]+$/, "") : this.locale = "en-GB");
                for (var b = this; c.match(/%[cDhnrRtTxXzZ]/);) c = c.replace(/%([cDhnrRtTxXzZ])/g, function (a, c) {
                    var e = Date.ext.aggregates[c];
                    return "locale" == e ? Date.ext.locales[b.locale][c] : e
                });
                c = c.replace(/%([aAbBCdegGHIjmMpPSuUVwWyY%])/g, function (a,
                    c) {
                    var e = Date.ext.formats[c];
                    return "string" == typeof e ? b[e]() : "function" == typeof e ? e.call(b, b) : "object" == typeof e && "string" == typeof e[0] ? Date.ext.util.xPad(b[e[0]](), e[1]) : c
                });
                b = null;
                return c
            }
        }();
        var q;
        q || (q = function (c, b, a) {
            if ("[object RegExp]" !== Object.prototype.toString.call(b)) return q._nativeSplit.call(c, b, a);
            var d = [],
                e = 0,
                f = (b.ignoreCase ? "i" : "") + (b.multiline ? "m" : "") + (b.sticky ? "y" : "");
            b = RegExp(b.source, f + "g");
            var h, m, r;
            c += "";
            q._compliantExecNpcg || (h = RegExp("^" + b.source + "$(?!\\s)", f));
            if (void 0 ===
                a || 0 > +a) a = Infinity;
            else if (a = Math.floor(+a), !a) return [];
            for (; m = b.exec(c);) {
                f = m.index + m[0].length;
                if (f > e && (d.push(c.slice(e, m.index)), !q._compliantExecNpcg && 1 < m.length && m[0].replace(h, function () {
                    for (var a = 1; a < arguments.length - 2; a++) void 0 === arguments[a] && (m[a] = void 0)
                }), 1 < m.length && m.index < c.length && Array.prototype.push.apply(d, m.slice(1)), r = m[0].length, e = f, d.length >= a)) break;
                b.lastIndex === m.index && b.lastIndex++
            }
            e === c.length ? !r && b.test("") || d.push("") : d.push(c.slice(e));
            return d.length > a ? d.slice(0,
                a) : d
        }, q._compliantExecNpcg = void 0 === /()??/.exec("")[1], q._nativeSplit = String.prototype.split);
        String.prototype.split = function (c, b) {
            return q(this, c, b)
        };
        "undefined" !== typeof define && define.amd && define("Liquid", [], function () {
            return h
        });
        "undefined" != typeof n && (n.Liquid = h)
    })();
    var x = function () {
        var h = function () {
            return this.init.apply(this, arguments)
        };
        h.prototype = {
            init: function (h) {
                var n = this;
                n.logLevel = h;
                return function () {
                    n.log.apply(n, arguments)
                }
            },
            log: function (h, n) {
                if ("debug" !== this.logLevel) return !1;
                window.console &&
                    console.log && (h && console.log(h), console.dir ? n && console.dir(n) : n && console.log(String(n)))
            }
        };
        return h
    }, R = new(x())("debug");
    "undefined" != typeof define && define.amd && (define("widget-common/Logger", [], x), define("widget-common/log", [], function () {
        return R
    }));
    "undefined" != typeof n && (n.Logger = x(), n.log = R);
    var L = {};
    (function () {
        function h(a) {
            return 10 > a ? "0" + a : a
        }

        function n(a) {
            c.lastIndex = 0;
            return c.test(a) ? '"' + a.replace(c, function (a) {
                var b = d[a];
                return "string" === typeof b ? b : "\\u" + ("0000" + a.charCodeAt(0).toString(16)).slice(-4)
            }) +
                '"' : '"' + a + '"'
        }

        function s(c, d) {
            var m, h, u, q, ca = b,
                Y, x = d[c];
            x && ("object" === typeof x && "function" === typeof x.toJSON) && (x = x.toJSON(c));
            "function" === typeof e && (x = e.call(d, c, x));
            switch (typeof x) {
            case "string":
                return n(x);
            case "number":
                return isFinite(x) ? String(x) : "null";
            case "boolean":
            case "null":
                return String(x);
            case "object":
                if (!x) return "null";
                b += a;
                Y = [];
                if ("[object Array]" === Object.prototype.toString.apply(x)) {
                    q = x.length;
                    for (m = 0; m < q; m += 1) Y[m] = s(m, x) || "null";
                    u = 0 === Y.length ? "[]" : b ? "[\n" + b + Y.join(",\n" + b) +
                        "\n" + ca + "]" : "[" + Y.join(",") + "]";
                    b = ca;
                    return u
                }
                if (e && "object" === typeof e)
                    for (q = e.length, m = 0; m < q; m += 1) "string" === typeof e[m] && (h = e[m], (u = s(h, x)) && Y.push(n(h) + (b ? ": " : ":") + u));
                else
                    for (h in x) Object.prototype.hasOwnProperty.call(x, h) && (u = s(h, x)) && Y.push(n(h) + (b ? ": " : ":") + u);
                u = 0 === Y.length ? "{}" : b ? "{\n" + b + Y.join(",\n" + b) + "\n" + ca + "}" : "{" + Y.join(",") + "}";
                b = ca;
                return u
            }
        }
        "function" !== typeof Date.prototype.toJSON && (Date.prototype.toJSON = function (a) {
            return isFinite(this.valueOf()) ? this.getUTCFullYear() + "-" +
                h(this.getUTCMonth() + 1) + "-" + h(this.getUTCDate()) + "T" + h(this.getUTCHours()) + ":" + h(this.getUTCMinutes()) + ":" + h(this.getUTCSeconds()) + "Z" : null
        }, String.prototype.toJSON = Number.prototype.toJSON = Boolean.prototype.toJSON = function (a) {
            return this.valueOf()
        });
        var q = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
            c = /[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
            b, a, d = {
                "\b": "\\b",
                "\t": "\\t",
                "\n": "\\n",
                "\f": "\\f",
                "\r": "\\r",
                '"': '\\"',
                "\\": "\\\\"
            }, e;
        "function" !== typeof L.stringify && (L.stringify = function (c, d, m) {
            var h;
            a = b = "";
            if ("number" === typeof m)
                for (h = 0; h < m; h += 1) a += " ";
            else "string" === typeof m && (a = m); if ((e = d) && "function" !== typeof d && ("object" !== typeof d || "number" !== typeof d.length)) throw Error("JSON.stringify");
            return s("", {
                "": c
            })
        });
        "function" !== typeof L.parse && (L.parse = function (a, b) {
            function c(a, d) {
                var e, f, h = a[d];
                if (h && "object" === typeof h)
                    for (e in h) Object.prototype.hasOwnProperty.call(h,
                        e) && (f = c(h, e), void 0 !== f ? h[e] = f : delete h[e]);
                return b.call(a, d, h)
            }
            var d;
            a = String(a);
            q.lastIndex = 0;
            q.test(a) && (a = a.replace(q, function (a) {
                return "\\u" + ("0000" + a.charCodeAt(0).toString(16)).slice(-4)
            }));
            if (/^[\],:{}\s]*$/.test(a.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, "@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]").replace(/(?:^|:|,)(?:\s*\[)+/g, ""))) return d = eval("(" + a + ")"), "function" === typeof b ? c({
                "": d
            }, "") : d;
            throw new SyntaxError("JSON.parse");
        })
    })();
    x = function () {
        var h =
            window.extole = window.extole || {};
        "undefined" != typeof window.console && (h.console = h.console || console);
        var n = function (a) {
            if ("[object Object]" !== String(a) || a.nodeType || a.window && a.window == a) return !1;
            try {
                if (a.constructor && !a.constructor.prototype.hasOwnProperty("isPrototypeOf")) return !1
            } catch (b) {
                return !1
            }
            return !0
        }, s = function (a, b) {
                var c, d;
                if (a.length)
                    for (d = 0; d < a.length; d++) {
                        if (c = b(a[d], d), !1 === c) return !1
                    } else
                        for (d in a)
                            if (a.hasOwnProperty(d) && (c = b(a[d], d), !1 === c)) return !1
            }, q;
        q = function () {
            var a, b, c, d, e,
                f = arguments[0] || {}, h = 1,
                v = arguments.length,
                A = !1;
            "boolean" === typeof f && (A = f, f = arguments[1] || {}, h = 2);
            for ("object" === typeof f || f && "function" === typeof f && f.call && f.apply || (f = {}); h < v; h++)
                if (a = arguments[h], null != a)
                    for (b in a) c = f[b], d = a[b], f !== d && (A && d && (n(d) || (e = d instanceof Array)) ? (e ? (e = !1, c = c && c instanceof Array ? c : []) : c = c && n(c) ? c : {}, f[b] = q(A, c, d)) : void 0 !== d && (f[b] = d));
            return f
        };
        var c = function (a) {
            if (!h.suppressLog) {
                var b = Array.prototype.slice.call(arguments, 1);
                if (h.console) try {
                    h.console[a].apply(h.console,
                        b)
                } catch (c) {
                    for (var d = a.toUpperCase() + " - ", e = 0; e < b.length; e++) d += " " + b[e];
                    h.console.log(d)
                }
            }
        }, b = function () {
                var a = Array.prototype.slice.call(arguments);
                c.apply(this, ["log"].concat(a))
            }, a = function (a) {
                b[a] = function () {
                    var b = Array.prototype.slice.call(arguments);
                    c.apply(this, [a].concat(b))
                }
            };
        a("error");
        a("debug");
        a("info");
        a("warn");
        var d;
        d = function (a, b) {
            d.funcs.push({
                getter: a,
                cb: b
            });
            d.isLooping || d.loopFunc()
        };
        d.funcs = [];
        d.isLooping = !1;
        d.loopFunc = function () {
            d.isLooping = !0;
            for (var a = [], b = 0; b < d.funcs.length; b++) {
                var c =
                    d.funcs[b],
                    e;
                try {
                    e = c.getter()
                } catch (f) {
                    minUtils.log.debug("** minUtils.elementReady **", "Bad getter", f), a.push(c)
                }
                e && c.cb(e)
            }
            d.funcs = a;
            a.length ? setTimeout(d.loopFunc, 100) : d.isLooping = !1
        };
        var e = h.generalReady;
        h.generalReady || (e = h.generalReady = function (a, c) {
            c = q(c || {}, {
                readyTest: void 0
            });
            e.readies[a] || (e.readies[a] = {
                ready: !1,
                funcs: []
            });
            var d = function (c) {
                c || e.readies[a].ready ? e.readies[a].funcs.push(c) : (e.readies[a].ready = !0, b.debug("** generalReady ** " + a + " - set ready"));
                if (e.readies[a].ready)
                    for (; c =
                        e.readies[a].funcs.pop();) setTimeout(c, 0)
            };
            d.unset = function () {
                e.readies[a].ready = !1
            };
            d.set = function () {
                d()
            };
            d.isReady = function () {
                return e.readies[a].ready
            };
            return d
        }, e.readies = {});
        var f = e("documentReady");
        (function () {
            document.addEventListener ? DOMContentLoaded = function () {
                document.removeEventListener("DOMContentLoaded", DOMContentLoaded, !1);
                f.set()
            } : document.attachEvent && (DOMContentLoaded = function () {
                "complete" === document.readyState && (document.detachEvent("onreadystatechange", DOMContentLoaded), f.set())
            });
            "complete" === document.readyState && f.set();
            document.addEventListener ? (document.addEventListener("DOMContentLoaded", DOMContentLoaded, !1), window.addEventListener("load", f.set, !1)) : document.attachEvent && (document.attachEvent("onreadystatechange", DOMContentLoaded), window.attachEvent("onload", f.set))
        })();
        var v = "undefined" !== typeof opera && "[object Opera]" === opera.toString();
        return {
            log: b,
            ready: f,
            generalReady: e,
            elementReady: d,
            getScript: function (a, b) {
                b = b || function () {};
                !a.attachEvent || a.attachEvent.toString &&
                    0 > a.attachEvent.toString().indexOf("[native code") || v ? a.addEventListener("load", b, !1) : (useInteractive = !0, a.attachEvent("onreadystatechange", b))
            },
            extend: q,
            map: function (a, b) {
                var c = [];
                s(a, function (a, d) {
                    var e = b(a, d);
                    void 0 !== e && c.push(e)
                });
                return c
            },
            mapObj: function (a, b) {
                var c = {};
                s(a, function (a, d) {
                    var e = b(a, d);
                    void 0 !== e && (e.key && e.value ? c[e.key] = e.value : c[d] = e)
                });
                return c
            },
            each: s
        }
    };
    "undefined" != typeof define && define.amd && define("widget-common/min-utils/base", [], x);
    "undefined" != typeof n && (n.minUtils = x());
    x = function (h) {
        var n = h.log,
            s = {
                create: function () {
                    for (var h = !1, c = 0; c < s.XMLHttpFactories.length; c++) {
                        try {
                            h = s.XMLHttpFactories[c]()
                        } catch (b) {
                            continue
                        }
                        break
                    }
                    return h
                },
                send: function (h, c) {
                    var b = Array.prototype.slice.call(arguments),
                        a = c.url || "",
                        d = c.data || "",
                        e = (c.type || "get").toUpperCase(),
                        f = c.complete || function () {}, v = c.error || function () {
                            n("Error with url " + a + "=", b.join(","))
                        };
                    "undefined" != typeof XDomainRequest ? (h = new XDomainRequest, h.open(e, a), h.onprogress = function () {}, h.ontimeout = v, h.timeout = 0) : h.open(e,
                        a, !0);
                    h.onerror = v;
                    h.onload = function () {
                        "function" == typeof f ? f(h.responseText) : n("Complete is not a function...so no callback for you.")
                    };
                    h.send(d)
                },
                XMLHttpFactories: [
                    function () {
                        return new XMLHttpRequest
                    },
                    function () {
                        return new ActiveXObject("Msxml2.XMLHTTP")
                    },
                    function () {
                        return new ActiveXObject("Msxml3.XMLHTTP")
                    },
                    function () {
                        return new ActiveXObject("Microsoft.XMLHTTP")
                    }
                ]
            };
        h.ajax = s;
        return h
    };
    "undefined" != typeof define && define.amd && define("widget-common/min-utils/ajax", ["widget-common/min-utils/base"],
        x);
    "undefined" != typeof n && (n.minUtils = x(n.minUtils));
    (function (h) {
        h = function (h) {
            function n(a) {
                return a
            }

            function q(a) {
                try {
                    return decodeURIComponent(a.replace(b, " "))
                } catch (c) {
                    return h.log("** minUtils.cookie.decoded ** Cookie error", c.message, c), ""
                }
            }

            function c(b) {
                0 === b.indexOf('"') && (b = b.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\"));
                try {
                    return a.json ? L.parse(b) : b
                } catch (c) {}
            }
            var b = /\+/g,
                a = function (b, e, f) {
                    if (void 0 !== e) {
                        f = h.extend({}, a.defaults, f);
                        if ("number" === typeof f.expires) {
                            var v = f.expires,
                                m = f.expires = new Date;
                            m.setDate(m.getDate() + v)
                        }
                        e = a.json ? L.stringify(e) : String(e);
                        return document.cookie = [a.raw ? b : encodeURIComponent(b), "=", a.raw ? e : encodeURIComponent(e), f.expires ? "; expires=" + f.expires.toUTCString() : "", f.path ? "; path=" + f.path : "", f.domain ? "; domain=" + f.domain : "", f.secure ? "; secure" : ""].join("")
                    }
                    e = a.raw ? n : q;
                    f = document.cookie.split("; ");
                    for (var v = b ? void 0 : {}, m = 0, r = f.length; m < r; m++) {
                        var u = f[m].split("="),
                            D = e(u.shift()),
                            u = e(u.join("="));
                        if (b && b === D) {
                            v = c(u);
                            break
                        }
                        b || (v[D] = c(u))
                    }
                    return v
                };
            a.defaults = {};
            return h.cookie = a
        };
        "undefined" !== typeof define && define.amd && define("widget-common/min-utils/cookie", ["widget-common/min-utils/base"], h);
        "undefined" != typeof n && (n.minUtilsCookie = h(n.minUtils))
    })();
    x = function () {
        return {
            deserialize: function (h) {
                if (!h) return {};
                var n = {};
                h = h.substring(1).split("&");
                for (var s = 0; s < h.length; s++) {
                    var q = h[s],
                        c = q.substring(0, q.indexOf("=")),
                        q = q.substring(q.indexOf("=") + 1);
                    c && q && (n[c] = decodeURIComponent(q))
                }
                return n
            }
        }
    };
    "undefined" != typeof define && define.amd && define("widget-common/utils/location-utils", [], x);
    "undefined" != typeof n && (n.locationUtils = x());
    x = function (h, n, s) {
        window.extole = window.extole || {};
        var q = function () {
            this.init.apply(this, arguments)
        };
        q.prototype = {
            init: function (c, b) {
                this.options = b;
                this.ns = c.replace("-", "__");
                this.sendTo = b.sendTo || window.parent;
                this.addMessageListener()
            },
            addMessageListener: function () {
                var c = this;
                h(window).on("message", function (b) {
                    b = b.originalEvent.data;
                    var a = b.split("-"),
                        d = a[0],
                        e = a[1],
                        a = a[2];
                    if (d != c.ns) return !1;
                    if (a) try {
                        a = L.parse(b.substring(d.length + 1 + e.length + 1))
                    } catch (f) {}
                    c.trigger(e,
                        a)
                })
            },
            sendMessage: function (c, b) {
                var a;
                a = this.ns + "-" + c;
                b && (a += "-" + L.stringify(b));
                this.sendTo.postMessage(a, "*")
            }
        };
        h.extend(q.prototype, n.Events);
        q.insertIframe = function (c) {
            extole.xdIframe || (extole.xdIframe = h('<iframe src="//' + c + '/xd-page">').css({
                display: "none",
                height: 0,
                width: 0,
                border: "none"
            }).appendTo(document.body))
        };
        q.iframeReady = function (c, b) {
            q.insertIframe(c);
            var a = new q("xd-page", {
                sendTo: extole.xdIframe[0].contentWindow
            }),
                d = {
                    start: function () {
                        a.once("ready", d.finish);
                        a.iframeInt = setInterval(function () {
                                a.sendMessage("ready?")
                            },
                            250)
                    },
                    finish: function () {
                        clearInterval(a.iframeInt);
                        a.stopListening();
                        delete a;
                        b()
                    }
                };
            d.start()
        };
        return q
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/utils/XdMessager", ["jquery", "Backbone", "widget-common/min-utils/base"], x);
    "undefined" != typeof n && (n.XdMessager = x(n.$, n.Backbone, n.minUtils));
    x = function (h, n, s) {
        var q = Array.prototype.slice;
        h.fn.getHighestZIndex = function () {
            var a = 1;
            this.each(function () {
                var b = h(this),
                    b = parseInt(b.css("zIndex"), 10);
                !isNaN(b) && b > a && (a = b)
            });
            return a
        };
        h.fn.center =
            function (a) {
                a = h.extend({
                    position: "absolute"
                }, a);
                this.css("position", a.position);
                this.css("top", Math.max(0, (h(window).height() - h(this).outerHeight()) / 2 + h(window).scrollTop()) + "px");
                this.css("left", Math.max(0, (h(window).width() - h(this).outerWidth()) / 2 + h(window).scrollLeft()) + "px");
                return this
        };
        h.fn.indexBySelector = function (a) {
            a = this.parent().children(a);
            for (var b = 0; b < a.length; b++)
                if (a[b] == this[0]) return b;
            return -1
        };
        h.deserialize = s.deserialize;
        (function (a) {
            function b(a) {
                return a
            }

            function c(a) {
                return decodeURIComponent(a.replace(m,
                    " "))
            }

            function h(a) {
                0 === a.indexOf('"') && (a = a.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\"));
                try {
                    return r.json ? L.parse(a) : a
                } catch (b) {}
            }
            var m = /\+/g,
                r = a.cookie = function (m, n, s) {
                    if (void 0 !== n) {
                        s = a.extend({}, r.defaults, s);
                        if ("number" === typeof s.expires) {
                            var q = s.expires,
                                y = s.expires = new Date;
                            y.setDate(y.getDate() + q)
                        }
                        n = r.json ? L.stringify(n) : String(n);
                        return document.cookie = [r.raw ? m : encodeURIComponent(m), "=", r.raw ? n : encodeURIComponent(n), s.expires ? "; expires=" + s.expires.toUTCString() : "", s.path ? "; path=" +
                            s.path : "", s.domain ? "; domain=" + s.domain : "", s.secure ? "; secure" : ""
                        ].join("")
                    }
                    n = r.raw ? b : c;
                    s = document.cookie.split("; ");
                    for (var q = m ? void 0 : {}, y = 0, x = s.length; y < x; y++) {
                        var A = s[y].split("="),
                            E = n(A.shift()),
                            A = n(A.join("="));
                        if (m && m === E) {
                            q = h(A);
                            break
                        }
                        m || (q[E] = h(A))
                    }
                    return q
                };
            r.defaults = {};
            a.removeCookie = function (b, c) {
                return void 0 !== a.cookie(b) ? (a.cookie(b, "", a.extend({}, c, {
                    expires: -1
                })), !0) : !1
            }
        })(h);
        h.fn.caretPosition = function (a) {
            var b, c;
            b = ["input", "select"];
            if (0 >= this.length || -1 >= h.inArray(this[0].nodeName.toLowerCase(),
                b)) return -1;
            b = this[0];
            if (void 0 !== a) b.setSelectionRange ? (b.focus(), b.setSelectionRange(a, a)) : b.createTextRange && (c = b.createTextRange(), c.collapse(!0), c.moveEnd("character", a), c.moveStart("character", a), c.select());
            else {
                if (document.selection) return b.focus(), c = document.selection.createRange(), c.moveStart("character", -b.value.length), c.text.length;
                if (void 0 !== b.selectionStart) return b.selectionStart
            }
            return -1
        };
        var c = {
            dataKey: "tagInputData",
            defaults: {
                maxLength: 10,
                maxLengthReplace: "...",
                newTagNameTemplate: "<%= name %>_tag",
                newTagInputHtml: '<input type="text" />',
                newTagInputClass: "new-tag-input",
                newTagLabel: "new tag",
                newTagLabelHtml: "<label></label>",
                newTagLabelClass: "new-tag-label",
                newTagHtml: void 0,
                tagHtml: "<span></span>",
                newTagClass: "new-tag",
                tagClass: "tag",
                tagValueHtml: "<span></span>",
                tagValueClass: "tag-value",
                tagRemoveButtonHtml: "<span></span>",
                tagRemoveButtonClass: "tag-remove-button",
                tagContainerHtml: "<div></div>",
                tagContainerClass: "tag-container",
                validator: function () {
                    return !0
                },
                onError: function () {},
                maxDisplayTags: void 0,
                showAllButtonHtml: '<a href="#"></a>',
                showAllButtonClass: "show-all-button",
                showAllButtonTemplate: "Show <%= number %>",
                showAllButtonHiddenText: "Hide",
                classFilter: function (a) {
                    return a
                }
            },
            init: function (a) {
                a = h.extend({}, c.defaults, a || {});
                return this.each(function () {
                    var b = h(this),
                        f = b.data(c.dataKey),
                        v = a.classFilter;
                    f || (f = {
                        options: a,
                        element: b,
                        isShowing: !1,
                        tags: []
                    }, b.data(c.dataKey, f));
                    b.hide().attr("tabindex", "-1");
                    var m = h(a.newTagInputHtml),
                        r = h(a.newTagLabelHtml).html(a.newTagLabel),
                        u = h(a.newTagHtml || a.tagHtml),
                        s = h(a.tagContainerHtml);
                    m.attr("name", n.template(a.newTagNameTemplate, {
                        name: b.attr("name")
                    }));
                    u.append(m).append(r);
                    s.append(u);
                    s.insertAfter(b);
                    r.addClass(v(a.newTagLabelClass));
                    m.addClass(v(a.newTagInputClass));
                    u.addClass(v(a.newTagClass)).addClass(v(a.tagClass));
                    s.addClass(v(a.tagContainerClass));
                    f.container && f.container.remove();
                    f.container = s;
                    f.newTagInput = m;
                    f.showAllButtonTemplate = n.template(a.showAllButtonTemplate);
                    m = h(a.showAllButtonHtml).html(f.showAllButtonTemplate({
                        number: 0
                    }));
                    m.appendTo(f.container).addClass(v(a.showAllButtonClass)).hide().attr("tabindex",
                        "-1");
                    f.showAllButton = m;
                    c.addEvents.call(b);
                    c.render.call(b)
                })
            },
            addEvents: function () {
                var a = h(this),
                    b = a.data(c.dataKey),
                    f = b.options,
                    n = f.classFilter,
                    m = b.container,
                    r = b.newTagInput,
                    u = b.showAllButton,
                    s = function (b) {
                        b.preventDefault();
                        b.stopPropagation();
                        b = r.val();
                        c.addTag.call(a, b)
                    }, q = 0;
                r.on({
                    focus: function () {
                        m.find("label").css("display", "none")
                    },
                    blur: function () {
                        s.apply(this, arguments);
                        3 > m.find("span").length && m.find("label").css("display", "block")
                    },
                    keydown: function (m) {
                        var u = b.newTagInput;
                        b.container.find(">." +
                            n(f.tagClass)).not("." + n(f.newTagClass));
                        q = 3 + h(this).val().length;
                        h(this).css("width", q + "em");
                        13 == m.keyCode || 32 == m.keyCode || 188 == m.keyCode ? (q = 3, h(this).css("width", q + "em"), s(m)) : c.isValid.call(a, u.val()) && f.onErrorHide.call(a)
                    }
                });
                u.on("click", function (f) {
                    f.stopPropagation();
                    f.preventDefault();
                    b.isShowing = !b.isShowing;
                    c.render.call(a)
                });
                m.on("click", function () {
                    r.focus()
                });
                a.on("change", function () {
                    a.trigger("blur")
                })
            },
            render: function () {
                var a = h(this),
                    b = a.data(c.dataKey),
                    f = b.options,
                    n = f.classFilter,
                    m =
                        b.container,
                    r = b.newTagInput.closest("." + n(f.tagClass)),
                    u = a.val().split(" ");
                tagsLen = u.length;
                1 == tagsLen && m.find("label").css("width", "30em");
                lastTagLen = a.val().length;
                labelDisp = "none";
                1 > lastTagLen && 2 > tagsLen && (labelDisp = "block");
                m.find("label").css("display", labelDisp);
                b.newTagInput.val("");
                m.find("." + n(f.tagClass)).not(r).remove();
                h.each(u, function (m, h) {
                    if (h) {
                        var u = c.makeTag.call(a, h);
                        u.insertBefore(r);
                        void 0 !== f.maxDisplayTags && (m + 1 > f.maxDisplayTags && !b.isShowing) && u.hide()
                    }
                });
                void 0 !== f.maxDisplayTags &&
                    u.length > f.maxDisplayTags ? (b.isShowing ? b.showAllButton.html(f.showAllButtonHiddenText) : b.showAllButton.html(b.showAllButtonTemplate({
                        number: u.length
                    })), b.showAllButton.show()) : b.showAllButton.hide()
            },
            makeTag: function (a) {
                var b = h(this),
                    f = b.data(c.dataKey).options,
                    n = f.classFilter,
                    m = h(f.tagValueHtml).html(a).addClass(n(f.tagValueClass)).data(c.dataKey + "_text", a),
                    r = h(f.tagHtml).addClass(n(f.tagClass)),
                    n = h(f.tagRemoveButtonHtml).addClass(n(f.tagRemoveButtonClass));
                a.length > f.maxLength && m.html(a.substring(0,
                    f.maxLength - f.maxLengthReplace.length) + f.maxLengthReplace);
                n.on("click", function (a) {
                    a.preventDefault();
                    a = h(a.target).parent();
                    c.removeTag.call(b, a)
                });
                r.append(m).append(n);
                return r
            },
            removeTag: function (a) {
                var b = h(this),
                    f = b.data(c.dataKey),
                    n = f.options,
                    m = n.classFilter,
                    r = 0;
                h.each(f.container.find(">." + m(n.tagClass)), function (b, c) {
                    h(c)[0] == a[0] && (r = b)
                });
                f = b.val().split(" ");
                f.splice(r, 1);
                b.val(f.join(" "));
                c.render.call(b)
            },
            addTag: function (a, b) {
                b = void 0 === b ? !1 : b;
                var f = h(this),
                    n = f.data(c.dataKey).options;
                "" !== a ? c.isValid.call(f, a) ? (f.val(h.trim(f.val() + " " + a.replace(" ", ""))), f.trigger("change"), b || c.render.call(f)) : n.onErrorShow.call(f) : n.onErrorHide.call(f)
            },
            isValid: function (a) {
                return h(this).data(c.dataKey).options.validator(a)
            }
        };
        h.fn.tagInput = function () {
            var a = q.call(arguments, 0);
            "string" == typeof a[0] ? c[a[0]].apply(this, a.slice(1)) : c.init.call(this, a[0])
        };
        var b = h.fn.show,
            a = {
                form: 1
            };
        h.fn.show = function () {
            var c = 0,
                e, f;
            for (b.apply(this, arguments); c < this.length; c++) f = this[c], e = f.nodeName.toLowerCase(),
            a[e] && h(f).css("display", "block");
            return this
        };
        return h
    };
    "undefined" != typeof define && define.amd && define("widget-common/jquery-plugins", ["jquery", "Underscore", "widget-common/utils/location-utils"], x);
    "undefined" != typeof n && (n.jqueryPlugins = x(n.$, n._, n.locationUtils));
    x = function (h, n) {
        window.extole = window.extole || {};
        var s = window.extole.cssUtils = window.extole.cssUtils || {
            id: void 0,
            firstInjectedCss: void 0,
            injectedCss: {}
        }, q = {
                getId: function () {
                    if (s.id) return s.id;
                    s.id = (new Date).getTime();
                    return q.getId()
                },
                getName: function (c) {
                    var b = q.getId();
                    return c + b
                },
                injectCss: function (c) {
                    if ("string" !== typeof c) return n.log("Trying to inject something weird", c), !1;
                    c = q.parseString(c);
                    if (!s.injectedCss[c]) {
                        s.injectedCss[c] = 1;
                        var b = document.createElement("style"),
                            a = document.getElementsByTagName("head")[0];
                        b.type = "text/css";
                        if (b.styleSheet) try {
                            b.styleSheet.cssText = "", a.appendChild(b), b.styleSheet.cssText = c
                        } catch (d) {
                            b = document.createElement("style"), b.type = "text/css", b.styleSheet.cssText = c, a.appendChild(b)
                        } else b.appendChild(document.createTextNode(c)),
                        a.appendChild(b)
                    }
                    q.reloadStylesheet()
                },
                reloadStylesheet: function () {
                    var c = document.createElement("style"),
                        b = document.getElementsByTagName("head")[0];
                    fakeText = '[class*="icon"]:before{content:""},[class*="icon"]:after{content:""}';
                    c.type = "text/css";
                    c.styleSheet ? c.styleSheet.cssText = "" : c.appendChild(document.createTextNode(""));
                    b.appendChild(c);
                    setTimeout(function () {
                        b.removeChild(c)
                    }, 0)
                },
                parseString: function (c) {
                    var b = q.getId();
                    return c = String(c).replace(/_id_/g, b)
                }
            };
        return q
    };
    "undefined" != typeof define &&
        define.amd && define("widget-common/utils/css-utils", ["Liquid", "widget-common/min-utils/base"], x);
    "undefined" != typeof n && (n.cssUtils = x(n.Liquid, n.minUtils));
    (function (h) {
        function y(a, b, c, d) {
            var e, f, g, h, u;
            (b ? b.ownerDocument || b : J) !== P && R(b);
            b = b || P;
            c = c || [];
            if (!a || "string" !== typeof a) return c;
            if (1 !== (h = b.nodeType) && 9 !== h) return [];
            if (O && !d) {
                if (e = $a.exec(a))
                    if (g = e[1])
                        if (9 === h)
                            if ((f = b.getElementById(g)) && f.parentNode) {
                                if (f.id === g) return c.push(f), c
                            } else return c;
                            else {
                                if (b.ownerDocument && (f = b.ownerDocument.getElementById(g)) &&
                                    Q(b, f) && f.id === g) return c.push(f), c
                            } else {
                                if (e[2]) return ga.apply(c, b.getElementsByTagName(a)), c;
                                if ((g = e[3]) && E.getElementsByClassName && b.getElementsByClassName) return ga.apply(c, b.getElementsByClassName(g)), c
                            }
                if (E.qsa && (!S || !S.test(a))) {
                    f = e = H;
                    g = b;
                    u = 9 === h && a;
                    if (1 === h && "object" !== b.nodeName.toLowerCase()) {
                        h = m(a);
                        (e = b.getAttribute("id")) ? f = e.replace(Ja, "\\$&") : b.setAttribute("id", f);
                        f = "[id='" + f + "'] ";
                        for (g = h.length; g--;) h[g] = f + r(h[g]);
                        g = Ga.test(a) && b.parentNode || b;
                        u = h.join(",")
                    }
                    if (u) try {
                        return ga.apply(c,
                            g.querySelectorAll(u)), c
                    } catch (n) {} finally {
                        e || b.removeAttribute("id")
                    }
                }
            }
            var p;
            a: {
                a = a.replace(Ba, "$1");
                f = m(a);
                if (!d && 1 === f.length) {
                    e = f[0] = f[0].slice(0);
                    if (2 < e.length && "ID" === (p = e[0]).type && E.getById && 9 === b.nodeType && O && F.relative[e[1].type]) {
                        b = (F.find.ID(p.matches[0].replace(ka, ja), b) || [])[0];
                        if (!b) {
                            p = c;
                            break a
                        }
                        a = a.slice(e.shift().value.length)
                    }
                    for (h = Ca.needsContext.test(a) ? 0 : e.length; h--;) {
                        p = e[h];
                        if (F.relative[g = p.type]) break;
                        if (g = F.find[g])
                            if (d = g(p.matches[0].replace(ka, ja), Ga.test(e[0].type) && b.parentNode ||
                                b)) {
                                e.splice(h, 1);
                                a = d.length && r(e);
                                if (!a) {
                                    ga.apply(c, d);
                                    p = c;
                                    break a
                                }
                                break
                            }
                    }
                }
                L(a, f)(d, b, !O, c, Ga.test(a));
                p = c
            }
            return p
        }

        function s() {
            function a(c, d) {
                b.push(c += " ") > F.cacheLength && delete a[b.shift()];
                return a[c] = d
            }
            var b = [];
            return a
        }

        function q(a) {
            a[H] = !0;
            return a
        }

        function c(a) {
            var b = P.createElement("div");
            try {
                return !!a(b)
            } catch (c) {
                return !1
            } finally {
                b.parentNode && b.parentNode.removeChild(b)
            }
        }

        function b(a, b) {
            for (var c = a.split("|"), d = a.length; d--;) F.attrHandle[c[d]] = b
        }

        function a(a, b) {
            var c = b && a,
                d = c && 1 === a.nodeType &&
                    1 === b.nodeType && (~b.sourceIndex || na) - (~a.sourceIndex || na);
            if (d) return d;
            if (c)
                for (; c = c.nextSibling;)
                    if (c === b) return -1;
            return a ? 1 : -1
        }

        function d(a) {
            return function (b) {
                return "input" === b.nodeName.toLowerCase() && b.type === a
            }
        }

        function e(a) {
            return function (b) {
                var c = b.nodeName.toLowerCase();
                return ("input" === c || "button" === c) && b.type === a
            }
        }

        function f(a) {
            return q(function (b) {
                b = +b;
                return q(function (c, d) {
                    for (var e, f = a([], c.length, b), g = f.length; g--;) c[e = f[g]] && (c[e] = !(d[e] = c[e]))
                })
            })
        }

        function v() {}

        function m(a, b) {
            var c,
                d, e, f, g, m, h;
            if (g = z[a + " "]) return b ? 0 : g.slice(0);
            g = a;
            m = [];
            for (h = F.preFilter; g;) {
                if (!c || (d = Wa.exec(g))) d && (g = g.slice(d[0].length) || g), m.push(e = []);
                c = !1;
                if (d = Ma.exec(g)) c = d.shift(), e.push({
                    value: c,
                    type: d[0].replace(Ba, " ")
                }), g = g.slice(c.length);
                for (f in F.filter)!(d = Ca[f].exec(g)) || h[f] && !(d = h[f](d)) || (c = d.shift(), e.push({
                    value: c,
                    type: f,
                    matches: d
                }), g = g.slice(c.length));
                if (!c) break
            }
            return b ? g.length : g ? y.error(a) : z(a, m).slice(0)
        }

        function r(a) {
            for (var b = 0, c = a.length, d = ""; b < c; b++) d += a[b].value;
            return d
        }

        function u(a, b, c) {
            var d = b.dir,
                e = c && "parentNode" === d,
                f = qa++;
            return b.first ? function (b, c, f) {
                for (; b = b[d];)
                    if (1 === b.nodeType || e) return a(b, c, f)
            } : function (b, c, g) {
                var m, h, u, n = ba + " " + f;
                if (g)
                    for (; b = b[d];) {
                        if ((1 === b.nodeType || e) && a(b, c, g)) return !0
                    } else
                        for (; b = b[d];)
                            if (1 === b.nodeType || e)
                                if (u = b[H] || (b[H] = {}), (h = u[d]) && h[0] === n) {
                                    if (!0 === (m = h[1]) || m === V) return !0 === m
                                } else if (h = u[d] = [n], h[1] = a(b, c, g) || V, !0 === h[1]) return !0
            }
        }

        function D(a) {
            return 1 < a.length ? function (b, c, d) {
                for (var e = a.length; e--;)
                    if (!a[e](b, c, d)) return !1;
                return !0
            } : a[0]
        }

        function x(a, b, c, d, e) {
            for (var f, g = [], m = 0, h = a.length, u = null != b; m < h; m++)
                if (f = a[m])
                    if (!c || c(f, d, e)) g.push(f), u && b.push(m);
            return g
        }

        function Y(a, b, c, d, e, f) {
            d && !d[H] && (d = Y(d));
            e && !e[H] && (e = Y(e, f));
            return q(function (f, m, h, u) {
                var n, p, r = [],
                    v = [],
                    s = m.length,
                    A;
                if (!(A = f)) {
                    A = b || "*";
                    for (var q = h.nodeType ? [h] : h, t = [], w = 0, D = q.length; w < D; w++) y(A, q[w], t);
                    A = t
                }
                A = !a || !f && b ? A : x(A, r, a, h, u);
                q = c ? e || (f ? a : s || d) ? [] : m : A;
                c && c(A, q, h, u);
                if (d)
                    for (n = x(q, v), d(n, [], h, u), h = n.length; h--;)
                        if (p = n[h]) q[v[h]] = !(A[v[h]] = p);
                if (f) {
                    if (e ||
                        a) {
                        if (e) {
                            n = [];
                            for (h = q.length; h--;)(p = q[h]) && n.push(A[h] = p);
                            e(null, q = [], n, u)
                        }
                        for (h = q.length; h--;)(p = q[h]) && -1 < (n = e ? g.call(f, p) : r[h]) && (f[n] = !(m[n] = p))
                    }
                } else q = x(q === m ? q.splice(s, q.length) : q), e ? e(null, m, q, u) : ga.apply(m, q)
            })
        }

        function U(a) {
            var b, c, d, e = a.length,
                f = F.relative[a[0].type];
            c = f || F.relative[" "];
            for (var m = f ? 1 : 0, h = u(function (a) {
                    return a === b
                }, c, !0), n = u(function (a) {
                    return -1 < g.call(b, a)
                }, c, !0), p = [
                    function (a, c, d) {
                        return !f && (d || c !== t) || ((b = c).nodeType ? h(a, c, d) : n(a, c, d))
                    }
                ]; m < e; m++)
                if (c = F.relative[a[m].type]) p = [u(D(p), c)];
                else {
                    c = F.filter[a[m].type].apply(null, a[m].matches);
                    if (c[H]) {
                        for (d = ++m; d < e && !F.relative[a[d].type]; d++);
                        return Y(1 < m && D(p), 1 < m && r(a.slice(0, m - 1).concat({
                            value: " " === a[m - 2].type ? "*" : ""
                        })).replace(Ba, "$1"), c, m < d && U(a.slice(m, d)), d < e && U(a = a.slice(d)), d < e && r(a))
                    }
                    p.push(c)
                }
            return D(p)
        }

        function C(a, b) {
            var c = 0,
                d = 0 < b.length,
                e = 0 < a.length,
                f = function (f, g, m, h, u) {
                    var n, p, r = [],
                        v = 0,
                        q = "0",
                        s = f && [],
                        A = null != u,
                        w = t,
                        D = f || e && F.find.TAG("*", u && g.parentNode || g),
                        E = ba += null == w ? 1 : Math.random() || 0.1;
                    A && (t = g !== P &&
                        g, V = c);
                    for (; null != (u = D[q]); q++) {
                        if (e && u) {
                            for (n = 0; p = a[n++];)
                                if (p(u, g, m)) {
                                    h.push(u);
                                    break
                                }
                            A && (ba = E, V = ++c)
                        }
                        d && ((u = !p && u) && v--, f && s.push(u))
                    }
                    v += q;
                    if (d && q !== v) {
                        for (n = 0; p = b[n++];) p(s, r, g, m);
                        if (f) {
                            if (0 < v)
                                for (; q--;) s[q] || r[q] || (r[q] = ma.call(h));
                            r = x(r)
                        }
                        ga.apply(h, r);
                        A && (!f && 0 < r.length && 1 < v + b.length) && y.uniqueSort(h)
                    }
                    A && (ba = E, t = w);
                    return s
                };
            return d ? q(f) : f
        }
        var A, E, V, F, X, B, L, t, I, R, P, Z, O, S, w, G, Q, H = "sizzle" + -new Date,
            J = h.document,
            ba = 0,
            qa = 0,
            p = s(),
            z = s(),
            M = s(),
            N = !1,
            ra = function (a, b) {
                a === b && (N = !0);
                return 0
            }, na = -2147483648,
            oa = {}.hasOwnProperty,
            aa = [],
            ma = aa.pop,
            sa = aa.push,
            ga = aa.push,
            xa = aa.slice,
            g = aa.indexOf || function (a) {
                for (var b = 0, c = this.length; b < c; b++)
                    if (this[b] === a) return b;
                return -1
            }, ua = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+".replace("w", "w#"),
            kb = "\\[[\\x20\\t\\r\\n\\f]*((?:\\\\.|[\\w-]|[^\\x00-\\xa0])+)[\\x20\\t\\r\\n\\f]*(?:([*^$|!~]?=)[\\x20\\t\\r\\n\\f]*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|(" + ua + ")|)|)[\\x20\\t\\r\\n\\f]*\\]",
            ha = ":((?:\\\\.|[\\w-]|[^\\x00-\\xa0])+)(?:\\(((['\"])((?:\\\\.|[^\\\\])*?)\\3|((?:\\\\.|[^\\\\()[\\]]|" +
                kb.replace(3, 8) + ")*)|.*)\\)|)",
            Ba = /^[\x20\t\r\n\f]+|((?:^|[^\\])(?:\\.)*)[\x20\t\r\n\f]+$/g,
            Wa = /^[\x20\t\r\n\f]*,[\x20\t\r\n\f]*/,
            Ma = /^[\x20\t\r\n\f]*([>+~]|[\x20\t\r\n\f])[\x20\t\r\n\f]*/,
            Ga = /[\x20\t\r\n\f]*[+~]/,
            Xa = /=[\x20\t\r\n\f]*([^\]'"]*)[\x20\t\r\n\f]*\]/g,
            Ya = RegExp(ha),
            Za = RegExp("^" + ua + "$"),
            Ca = {
                ID: /^#((?:\\.|[\w-]|[^\x00-\xa0])+)/,
                CLASS: /^\.((?:\\.|[\w-]|[^\x00-\xa0])+)/,
                TAG: RegExp("^(" + "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+".replace("w", "w*") + ")"),
                ATTR: RegExp("^" + kb),
                PSEUDO: RegExp("^" + ha),
                CHILD: RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\([\\x20\\t\\r\\n\\f]*(even|odd|(([+-]|)(\\d*)n|)[\\x20\\t\\r\\n\\f]*(?:([+-]|)[\\x20\\t\\r\\n\\f]*(\\d+)|))[\\x20\\t\\r\\n\\f]*\\)|)",
                    "i"),
                bool: RegExp("^(?:checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped)$", "i"),
                needsContext: RegExp("^[\\x20\\t\\r\\n\\f]*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\([\\x20\\t\\r\\n\\f]*((?:-\\d)?\\d*)[\\x20\\t\\r\\n\\f]*\\)|)(?=[^-]|$)", "i")
            }, Ha = /^[^{]+\{\s*\[native \w/,
            $a = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
            Da = /^(?:input|select|textarea|button)$/i,
            Na = /^h\d$/i,
            Ja = /'|\\/g,
            ka = /\\([\da-f]{1,6}[\x20\t\r\n\f]?|([\x20\t\r\n\f])|.)/ig,
            ja = function (a, b, c) {
                a = "0x" + b - 65536;
                return a !== a || c ? b : 0 > a ? String.fromCharCode(a + 65536) : String.fromCharCode(a >> 10 | 55296, a & 1023 | 56320)
            };
        try {
            ga.apply(aa = xa.call(J.childNodes), J.childNodes), aa[J.childNodes.length].nodeType
        } catch (pa) {
            ga = {
                apply: aa.length ? function (a, b) {
                    sa.apply(a, xa.call(b))
                } : function (a, b) {
                    for (var c = a.length, d = 0; a[c++] = b[d++];);
                    a.length = c - 1
                }
            }
        }
        B = y.isXML = function (a) {
            return (a = a && (a.ownerDocument || a).documentElement) ? "HTML" !== a.nodeName : !1
        };
        E = y.support = {};
        R = y.setDocument = function (b) {
            var d = b ? b.ownerDocument ||
                b : J;
            b = d.defaultView;
            if (d === P || 9 !== d.nodeType || !d.documentElement) return P;
            P = d;
            Z = d.documentElement;
            O = !B(d);
            b && (b.attachEvent && b !== b.top) && b.attachEvent("onbeforeunload", function () {
                R()
            });
            E.attributes = c(function (a) {
                a.className = "i";
                return !a.getAttribute("className")
            });
            E.getElementsByTagName = c(function (a) {
                a.appendChild(d.createComment(""));
                return !a.getElementsByTagName("*").length
            });
            E.getElementsByClassName = c(function (a) {
                a.innerHTML = "<div class='a'></div><div class='a i'></div>";
                a.firstChild.className =
                    "i";
                return 2 === a.getElementsByClassName("i").length
            });
            E.getById = c(function (a) {
                Z.appendChild(a).id = H;
                return !d.getElementsByName || !d.getElementsByName(H).length
            });
            E.getById ? (F.find.ID = function (a, b) {
                if ("undefined" !== typeof b.getElementById && O) {
                    var c = b.getElementById(a);
                    return c && c.parentNode ? [c] : []
                }
            }, F.filter.ID = function (a) {
                var b = a.replace(ka, ja);
                return function (a) {
                    return a.getAttribute("id") === b
                }
            }) : (delete F.find.ID, F.filter.ID = function (a) {
                var b = a.replace(ka, ja);
                return function (a) {
                    return (a = "undefined" !==
                        typeof a.getAttributeNode && a.getAttributeNode("id")) && a.value === b
                }
            });
            F.find.TAG = E.getElementsByTagName ? function (a, b) {
                if ("undefined" !== typeof b.getElementsByTagName) return b.getElementsByTagName(a)
            } : function (a, b) {
                var c, d = [],
                    e = 0,
                    f = b.getElementsByTagName(a);
                if ("*" === a) {
                    for (; c = f[e++];) 1 === c.nodeType && d.push(c);
                    return d
                }
                return f
            };
            F.find.CLASS = E.getElementsByClassName && function (a, b) {
                if ("undefined" !== typeof b.getElementsByClassName && O) return b.getElementsByClassName(a)
            };
            w = [];
            S = [];
            if (E.qsa = Ha.test(d.querySelectorAll)) c(function (a) {
                a.innerHTML =
                    "<select><option selected=''></option></select>";
                a.querySelectorAll("[selected]").length || S.push("\\[[\\x20\\t\\r\\n\\f]*(?:value|checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped)");
                a.querySelectorAll(":checked").length || S.push(":checked")
            }), c(function (a) {
                var b = d.createElement("input");
                b.setAttribute("type", "hidden");
                a.appendChild(b).setAttribute("t", "");
                a.querySelectorAll("[t^='']").length && S.push("[*^$]=[\\x20\\t\\r\\n\\f]*(?:''|\"\")");
                a.querySelectorAll(":enabled").length || S.push(":enabled", ":disabled");
                a.querySelectorAll("*,:x");
                S.push(",.*:")
            });
            (E.matchesSelector = Ha.test(G = Z.webkitMatchesSelector || Z.mozMatchesSelector || Z.oMatchesSelector || Z.msMatchesSelector)) && c(function (a) {
                E.disconnectedMatch = G.call(a, "div");
                G.call(a, "[s!='']:x");
                w.push("!=", ha)
            });
            S = S.length && RegExp(S.join("|"));
            w = w.length && RegExp(w.join("|"));
            Q = Ha.test(Z.contains) || Z.compareDocumentPosition ? function (a, b) {
                var c = 9 === a.nodeType ? a.documentElement : a,
                    d = b && b.parentNode;
                return a === d || !! (d && 1 === d.nodeType && (c.contains ? c.contains(d) : a.compareDocumentPosition && a.compareDocumentPosition(d) & 16))
            } : function (a, b) {
                if (b)
                    for (; b = b.parentNode;)
                        if (b === a) return !0;
                return !1
            };
            ra = Z.compareDocumentPosition ? function (a, b) {
                if (a === b) return N = !0, 0;
                var c = b.compareDocumentPosition && a.compareDocumentPosition && a.compareDocumentPosition(b);
                return c ? c & 1 || !E.sortDetached && b.compareDocumentPosition(a) === c ? a === d || Q(J, a) ? -1 : b === d || Q(J, b) ? 1 : I ? g.call(I, a) - g.call(I, b) : 0 : c & 4 ? -1 : 1 : a.compareDocumentPosition ? -1 : 1
            } : function (b, c) {
                var e, f = 0;
                e = b.parentNode;
                var m = c.parentNode,
                    h = [b],
                    u = [c];
                if (b === c) return N = !0, 0;
                if (!e || !m) return b === d ? -1 : c === d ? 1 : e ? -1 : m ? 1 : I ? g.call(I, b) - g.call(I, c) : 0;
                if (e === m) return a(b, c);
                for (e = b; e = e.parentNode;) h.unshift(e);
                for (e = c; e = e.parentNode;) u.unshift(e);
                for (; h[f] === u[f];) f++;
                return f ? a(h[f], u[f]) : h[f] === J ? -1 : u[f] === J ? 1 : 0
            };
            return d
        };
        y.matches = function (a, b) {
            return y(a, null, null, b)
        };
        y.matchesSelector = function (a, b) {
            (a.ownerDocument || a) !== P && R(a);
            b = b.replace(Xa, "='$1']");
            if (E.matchesSelector &&
                O && !(w && w.test(b) || S && S.test(b))) try {
                var c = G.call(a, b);
                if (c || E.disconnectedMatch || a.document && 11 !== a.document.nodeType) return c
            } catch (d) {}
            return 0 < y(b, P, null, [a]).length
        };
        y.contains = function (a, b) {
            (a.ownerDocument || a) !== P && R(a);
            return Q(a, b)
        };
        y.attr = function (a, b) {
            (a.ownerDocument || a) !== P && R(a);
            var c = F.attrHandle[b.toLowerCase()],
                c = c && oa.call(F.attrHandle, b.toLowerCase()) ? c(a, b, !O) : void 0;
            return void 0 === c ? E.attributes || !O ? a.getAttribute(b) : (c = a.getAttributeNode(b)) && c.specified ? c.value : null : c
        };
        y.error =
            function (a) {
                throw Error("Syntax error, unrecognized expression: " + a);
        };
        y.uniqueSort = function (a) {
            var b, c = [],
                d = 0,
                e = 0;
            N = !E.detectDuplicates;
            I = !E.sortStable && a.slice(0);
            a.sort(ra);
            if (N) {
                for (; b = a[e++];) b === a[e] && (d = c.push(e));
                for (; d--;) a.splice(c[d], 1)
            }
            return a
        };
        X = y.getText = function (a) {
            var b, c = "",
                d = 0;
            b = a.nodeType;
            if (!b)
                for (; b = a[d]; d++) c += X(b);
            else if (1 === b || 9 === b || 11 === b) {
                if ("string" === typeof a.textContent) return a.textContent;
                for (a = a.firstChild; a; a = a.nextSibling) c += X(a)
            } else if (3 === b || 4 === b) return a.nodeValue;
            return c
        };
        F = y.selectors = {
            cacheLength: 50,
            createPseudo: q,
            match: Ca,
            attrHandle: {},
            find: {},
            relative: {
                ">": {
                    dir: "parentNode",
                    first: !0
                },
                " ": {
                    dir: "parentNode"
                },
                "+": {
                    dir: "previousSibling",
                    first: !0
                },
                "~": {
                    dir: "previousSibling"
                }
            },
            preFilter: {
                ATTR: function (a) {
                    a[1] = a[1].replace(ka, ja);
                    a[3] = (a[4] || a[5] || "").replace(ka, ja);
                    "~=" === a[2] && (a[3] = " " + a[3] + " ");
                    return a.slice(0, 4)
                },
                CHILD: function (a) {
                    a[1] = a[1].toLowerCase();
                    "nth" === a[1].slice(0, 3) ? (a[3] || y.error(a[0]), a[4] = +(a[4] ? a[5] + (a[6] || 1) : 2 * ("even" === a[3] || "odd" ===
                        a[3])), a[5] = +(a[7] + a[8] || "odd" === a[3])) : a[3] && y.error(a[0]);
                    return a
                },
                PSEUDO: function (a) {
                    var b, c = !a[5] && a[2];
                    if (Ca.CHILD.test(a[0])) return null;
                    a[3] && void 0 !== a[4] ? a[2] = a[4] : c && (Ya.test(c) && (b = m(c, !0)) && (b = c.indexOf(")", c.length - b) - c.length)) && (a[0] = a[0].slice(0, b), a[2] = c.slice(0, b));
                    return a.slice(0, 3)
                }
            },
            filter: {
                TAG: function (a) {
                    var b = a.replace(ka, ja).toLowerCase();
                    return "*" === a ? function () {
                        return !0
                    } : function (a) {
                        return a.nodeName && a.nodeName.toLowerCase() === b
                    }
                },
                CLASS: function (a) {
                    var b = p[a + " "];
                    return b ||
                        (b = RegExp("(^|[\\x20\\t\\r\\n\\f])" + a + "([\\x20\\t\\r\\n\\f]|$)")) && p(a, function (a) {
                        return b.test("string" === typeof a.className && a.className || "undefined" !== typeof a.getAttribute && a.getAttribute("class") || "")
                    })
                },
                ATTR: function (a, b, c) {
                    return function (d) {
                        d = y.attr(d, a);
                        if (null == d) return "!=" === b;
                        if (!b) return !0;
                        d += "";
                        return "=" === b ? d === c : "!=" === b ? d !== c : "^=" === b ? c && 0 === d.indexOf(c) : "*=" === b ? c && -1 < d.indexOf(c) : "$=" === b ? c && d.slice(-c.length) === c : "~=" === b ? -1 < (" " + d + " ").indexOf(c) : "|=" === b ? d === c || d.slice(0, c.length +
                            1) === c + "-" : !1
                    }
                },
                CHILD: function (a, b, c, d, e) {
                    var f = "nth" !== a.slice(0, 3),
                        g = "last" !== a.slice(-4),
                        m = "of-type" === b;
                    return 1 === d && 0 === e ? function (a) {
                        return !!a.parentNode
                    } : function (b, c, h) {
                        var u, n, p, r, v;
                        c = f !== g ? "nextSibling" : "previousSibling";
                        var q = b.parentNode,
                            s = m && b.nodeName.toLowerCase();
                        h = !h && !m;
                        if (q) {
                            if (f) {
                                for (; c;) {
                                    for (n = b; n = n[c];)
                                        if (m ? n.nodeName.toLowerCase() === s : 1 === n.nodeType) return !1;
                                    v = c = "only" === a && !v && "nextSibling"
                                }
                                return !0
                            }
                            v = [g ? q.firstChild : q.lastChild];
                            if (g && h)
                                for (h = q[H] || (q[H] = {}), u = h[a] || [], r =
                                    u[0] === ba && u[1], p = u[0] === ba && u[2], n = r && q.childNodes[r]; n = ++r && n && n[c] || (p = r = 0) || v.pop();) {
                                    if (1 === n.nodeType && ++p && n === b) {
                                        h[a] = [ba, r, p];
                                        break
                                    }
                                } else if (h && (u = (b[H] || (b[H] = {}))[a]) && u[0] === ba) p = u[1];
                                else
                                    for (;
                                        (n = ++r && n && n[c] || (p = r = 0) || v.pop()) && ((m ? n.nodeName.toLowerCase() !== s : 1 !== n.nodeType) || !++p || (h && ((n[H] || (n[H] = {}))[a] = [ba, p]), n !== b)););
                            p -= e;
                            return p === d || 0 === p % d && 0 <= p / d
                        }
                    }
                },
                PSEUDO: function (a, b) {
                    var c, d = F.pseudos[a] || F.setFilters[a.toLowerCase()] || y.error("unsupported pseudo: " + a);
                    return d[H] ? d(b) :
                        1 < d.length ? (c = [a, a, "", b], F.setFilters.hasOwnProperty(a.toLowerCase()) ? q(function (a, c) {
                            for (var e, f = d(a, b), m = f.length; m--;) e = g.call(a, f[m]), a[e] = !(c[e] = f[m])
                        }) : function (a) {
                            return d(a, 0, c)
                        }) : d
                }
            },
            pseudos: {
                not: q(function (a) {
                    var b = [],
                        c = [],
                        d = L(a.replace(Ba, "$1"));
                    return d[H] ? q(function (a, b, c, e) {
                        e = d(a, null, e, []);
                        for (var f = a.length; f--;)
                            if (c = e[f]) a[f] = !(b[f] = c)
                    }) : function (a, e, f) {
                        b[0] = a;
                        d(b, null, f, c);
                        return !c.pop()
                    }
                }),
                has: q(function (a) {
                    return function (b) {
                        return 0 < y(a, b).length
                    }
                }),
                contains: q(function (a) {
                    return function (b) {
                        return -1 <
                            (b.textContent || b.innerText || X(b)).indexOf(a)
                    }
                }),
                lang: q(function (a) {
                    Za.test(a || "") || y.error("unsupported lang: " + a);
                    a = a.replace(ka, ja).toLowerCase();
                    return function (b) {
                        var c;
                        do
                            if (c = O ? b.lang : b.getAttribute("xml:lang") || b.getAttribute("lang")) return c = c.toLowerCase(), c === a || 0 === c.indexOf(a + "-"); while ((b = b.parentNode) && 1 === b.nodeType);
                        return !1
                    }
                }),
                target: function (a) {
                    var b = h.location && h.location.hash;
                    return b && b.slice(1) === a.id
                },
                root: function (a) {
                    return a === Z
                },
                focus: function (a) {
                    return a === P.activeElement &&
                        (!P.hasFocus || P.hasFocus()) && !! (a.type || a.href || ~a.tabIndex)
                },
                enabled: function (a) {
                    return !1 === a.disabled
                },
                disabled: function (a) {
                    return !0 === a.disabled
                },
                checked: function (a) {
                    var b = a.nodeName.toLowerCase();
                    return "input" === b && !! a.checked || "option" === b && !! a.selected
                },
                selected: function (a) {
                    a.parentNode && a.parentNode.selectedIndex;
                    return !0 === a.selected
                },
                empty: function (a) {
                    for (a = a.firstChild; a; a = a.nextSibling)
                        if ("@" < a.nodeName || 3 === a.nodeType || 4 === a.nodeType) return !1;
                    return !0
                },
                parent: function (a) {
                    return !F.pseudos.empty(a)
                },
                header: function (a) {
                    return Na.test(a.nodeName)
                },
                input: function (a) {
                    return Da.test(a.nodeName)
                },
                button: function (a) {
                    var b = a.nodeName.toLowerCase();
                    return "input" === b && "button" === a.type || "button" === b
                },
                text: function (a) {
                    var b;
                    return "input" === a.nodeName.toLowerCase() && "text" === a.type && (null == (b = a.getAttribute("type")) || b.toLowerCase() === a.type)
                },
                first: f(function () {
                    return [0]
                }),
                last: f(function (a, b) {
                    return [b - 1]
                }),
                eq: f(function (a, b, c) {
                    return [0 > c ? c + b : c]
                }),
                even: f(function (a, b) {
                    for (var c = 0; c < b; c += 2) a.push(c);
                    return a
                }),
                odd: f(function (a, b) {
                    for (var c = 1; c < b; c += 2) a.push(c);
                    return a
                }),
                lt: f(function (a, b, c) {
                    for (b = 0 > c ? c + b : c; 0 <= --b;) a.push(b);
                    return a
                }),
                gt: f(function (a, b, c) {
                    for (c = 0 > c ? c + b : c; ++c < b;) a.push(c);
                    return a
                })
            }
        };
        F.pseudos.nth = F.pseudos.eq;
        for (A in {
            radio: !0,
            checkbox: !0,
            file: !0,
            password: !0,
            image: !0
        }) F.pseudos[A] = d(A);
        for (A in {
            submit: !0,
            reset: !0
        }) F.pseudos[A] = e(A);
        v.prototype = F.filters = F.pseudos;
        F.setFilters = new v;
        L = y.compile = function (a, b) {
            var c, d = [],
                e = [],
                f = M[a + " "];
            if (!f) {
                b || (b = m(a));
                for (c = b.length; c--;) f = U(b[c]), f[H] ?
                    d.push(f) : e.push(f);
                f = M(a, C(e, d))
            }
            return f
        };
        E.sortStable = H.split("").sort(ra).join("") === H;
        E.detectDuplicates = N;
        R();
        E.sortDetached = c(function (a) {
            return a.compareDocumentPosition(P.createElement("div")) & 1
        });
        c(function (a) {
            a.innerHTML = "<a href='#'></a>";
            return "#" === a.firstChild.getAttribute("href")
        }) || b("type|href|height|width", function (a, b, c) {
            if (!c) return a.getAttribute(b, "type" === b.toLowerCase() ? 1 : 2)
        });
        E.attributes && c(function (a) {
            a.innerHTML = "<input/>";
            a.firstChild.setAttribute("value", "");
            return "" ===
                a.firstChild.getAttribute("value")
        }) || b("value", function (a, b, c) {
            if (!c && "input" === a.nodeName.toLowerCase()) return a.defaultValue
        });
        c(function (a) {
            return null == a.getAttribute("disabled")
        }) || b("checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped", function (a, b, c) {
            var d;
            if (!c) return (d = a.getAttributeNode(b)) && d.specified ? d.value : !0 === a[b] ? b.toLowerCase() : null
        });
        "function" === typeof define && define.amd && define("Sizzle", function () {
            return y
        });
        "undefined" != typeof n && (n.Sizzle = y)
    })(window);
    x = function (h, n) {
        var s = function (b) {
            var a;
            try {
                a = h(b)[0]
            } catch (c) {}
            return a
        }, q = function (b, a) {
                var c = s(b),
                    e = "";
                if (!c) return "";
                "::content::" == a ? e = c.textContent || c.innerText || c.innerHTML : "string" == typeof a && (e = c[a] ? c[a] : c.getAttribute ? c.getAttribute(a) : "");
                return e
            }, c = function (b) {
                var a = "",
                    c = n.deserialize(location.search);
                "element" == b.resource_type ? a = q(b.selector, b.attr) : "query_param" == b.resource_type && (a = c[b.param_name]);
                return a
            };
        return {
            getElementFromSelector: s,
            getValueFromSelector: q,
            getValueFromRule: c,
            getValuesFromRules: function (b) {
                b = b || [];
                var a = {}, d;
                for (d in b) b.hasOwnProperty(d) && (a[d] = c(b[d]));
                return a
            },
            getQueryParameterByName: function (b) {
                for (var a = location.search.substring(1).split("&"), c = 0; c < a.length; c++) {
                    var e = a[c].split("=");
                    if (decodeURIComponent(e[0]) == b) return decodeURIComponent(e[1])
                }
                return ""
            }
        }
    };
    "undefined" != typeof define && define.amd && define("widget-common/utils/resource-utils", ["Sizzle", "widget-common/utils/location-utils"], x);
    "undefined" != typeof n &&
        (n.resourceUtils = x(n.Sizzle, n.locationUtils));
    x = function (h, n) {
        window.extole = window.extole || {};
        window.extole.loader = window.extole.loader || {};
        return {
            ready: function (s, q) {
                var c = {}, b = !1;
                c.start = function () {
                    h.each(s, function (a, b) {
                        c.handleUri(b)
                    })
                };
                c.handleUri = function (a) {
                    window.extole.loader[a] = window.extole.loader[a] || {};
                    if (void 0 !== window.extole.loader[a].content) c.done();
                    else if (void 0 !== window.extole.loader[a].xhr && 4 == window.extole.loader[a].xhr.readyState) setTimeout(function () {
                        c.checkUri()
                    }, 250);
                    else {
                        window.extole.loader[a].errorTimes =
                            0;
                        var b = function () {
                            window.extole.loader[a].xhr = h.ajax(a, {
                                crossDomain: !0,
                                dataType: "text",
                                cache: !0,
                                success: function (b) {
                                    window.extole.loader[a].content = b;
                                    c.done()
                                },
                                error: function (c, f, h) {
                                    window.extole.loader[a].errorTimes += 1;
                                    3 < window.extole.loader[a].errorTimes ? n.log("In ready,  couldn't fetch " + a + " - " + f + ", " + h) : setTimeout(b, 250)
                                }
                            })
                        };
                        b()
                    }
                };
                c.done = function () {
                    var a = [],
                        c, e;
                    for (c = 0; c < s.length; c++)
                        if (e = s[c], window.extole.loader[e]) {
                            if (void 0 === window.extole.loader[e].content) return !1;
                            a.push(window.extole.loader[e].content)
                        } else return !1;
                    b || (q.apply(this, a), b = !0)
                };
                c.start()
            },
            errorFetch: function (s, q, c) {
                c = c || {};
                var b = c.error || function (a, b, c) {
                        n.log("There was an error fetching " + s + " - " + b + " - " + c)
                    }, a = 0,
                    d = function () {
                        h.ajax(s, h.extend(c, {
                            cache: !0,
                            success: function () {
                                q.apply(this, arguments)
                            },
                            error: function (c, f, h) {
                                a++;
                                3 < a ? d() : b(c, f, h)
                            }
                        }))
                    };
                d()
            },
            getScript: function (h, q) {
                if ("string" == typeof h) {
                    var c = h;
                    h = document.createElement("script");
                    n.getScript(h, q);
                    h.src = c;
                    document.getElementsByTagName("head")[0].appendChild(h)
                } else return n.getScript(h,
                    q)
            }
        }
    };
    "undefined" != typeof define && define.amd && define("widget-common/utils/loader-utils", ["jquery", "widget-common/min-utils/base"], x);
    "undefined" != typeof n && (n.loaderUtils = x(n.$, n.minUtils));
    x = function (h, n) {
        var s = {
            parseTemplate: function (h) {
                return "string" == typeof h ? n.parseString(h) : h
            },
            sanitizeTemplates: function (h) {
                for (var c in h) h.hasOwnProperty(c) && (template = s.parseTemplate(h[c]), h[c] = template)
            },
            resolveTemplateVars: function (n, c) {
                s.sanitizeTemplates(n);
                for (var b in n)
                    if (n.hasOwnProperty(b)) {
                        var a = n[b];
                        a === Object(a) ? n[b] = s.resolveTemplateVars(a, c) : "string" == typeof a && (void 0 !== a && null !== a && "" !== a) && (n[b] = h.parse(a).render(c))
                    }
                return n
            }
        };
        return s
    };
    "undefined" != typeof define && define.amd && define("widget-common/utils/template-utils", ["Liquid", "widget-common/utils/css-utils"], x);
    "undefined" != typeof n && (n.templateUtils = x(n.Liquid, n.cssUtils));
    x = function (h, n, s) {
        var q = {
            name: "Not Defined",
            iconMap: {
                add: "f067",
                addSign: "f055",
                caretDown: "f0d7",
                caretUp: "f0d8",
                caretLeft: "f0d9",
                caretRight: "f0da",
                remove: "f00d",
                removeCircle: "f05c",
                removeSign: "f057",
                arrowLeft: "f060",
                arrowRight: "f061",
                arrowDown: "f063",
                arrowUp: "f062",
                email: "f003",
                emailSign: "f0e0",
                facebook: "f09a",
                facebookSign: "f082",
                twitter: "f099",
                twitterSign: "f081",
                user: "f007"
            },
            init: function () {},
            extend: function (c) {
                var b = function () {
                    this.init.apply(this, arguments)
                };
                b.prototype = h.extend({}, q, c);
                return b
            },
            getValidateRules: function (c) {
                return h.extend(!0, {}, {
                    errorClass: n.getName("error"),
                    validClass: n.getName("valid"),
                    errorPlacement: function (b, a) {
                        var c = n.getName("input"),
                            e = a.closest("." + c),
                            c = e.attr("class").replace(c, "").replace(n.getName("selected"), "");
                        b.addClass(c);
                        b.insertAfter(e)
                    },
                    errorElement: "div",
                    ignore: []
                }, c)
            },
            makeForm: function (c) {
                c = h.extend({
                    htmlValidate: !1
                }, c);
                var b = h("<form>").addClass(n.getName("form"));
                c.htmlValidate || b.attr("novalidate", "novalidate");
                return b
            },
            makeDeleteButton: function (c, b) {
                var a = this.makeIcon("remove");
                a.addClass(n.getName("delete-button"));
                return a
            },
            makeIcon: function (c) {
                return h("<span>&#x" + this.iconMap[c] + ";</span>").css({
                    fontFamily: "FontAwesome"
                })
            },
            getPopup: function () {
                var c = h("<div>").css({
                    zIndex: h("*").getHighestZIndex() + 1
                }).appendTo(document.body);
                c.addClass(n.getName("popup"));
                this.addPopupCloseButton(c);
                return c
            },
            addPopupCloseButton: function (c) {
                var b = this.makeDeleteButton().on("click", function (a) {
                    a.preventDefault();
                    c.remove()
                }).appendTo(c);
                b.addClass(n.getName("close-button"));
                return b
            },
            unrender: function () {}
        };
        return q
    };
    "undefined" != typeof define && define.amd && define("widget-common/Widget", ["jquery", "widget-common/utils/css-utils", "widget-common/jquery-plugins"],
        x);
    "undefined" != typeof n && (n.Widget = x(n.$, n.cssUtils, n.jqueryPlugins));
    x = function (h, n, s, q) {
        s = n.View.extend(s);
        return s = s.extend({
            nodeName: "div",
            content: {},
            formEvents: {
                "blur .form_id_ .input-inside_id_ input": "formEventInputInsideBlur",
                "blur .form_id_ .input-inside_id_ textarea": "formEventInputInsideBlur",
                "focus .form_id_ .input-inside_id_ input": "formEventInputInsideFocus",
                "focus .form_id_ .input-inside_id_ textarea": "formEventInputInsideFocus"
            },
            formEventInputInsideFocus: function (c) {
                h(c.target).closest("." +
                    q.getName("input-inside")).addClass(q.getName("selected"))
            },
            formEventInputInsideBlur: function (c) {
                c = h(c.target);
                var b = c.closest("." + q.getName("input-inside"));
                "" == c.val() && b.removeClass(q.getName("selected"))
            },
            delegateEvents: function () {
                var c = this.events || {}, b = {}, c = h.extend({}, this.formEvents, c),
                    a;
                for (a in c) b[q.parseString(a)] = c[a];
                this.events = b;
                n.View.prototype.delegateEvents.apply(this, arguments)
            },
            destroy: function () {
                this.$el.remove()
            },
            renderLoading: function () {
                this.$loading && this.$loading.remove();
                this.$el.find(">*").hide();
                this.$loading = h("<p>Loading..</p>").addClass(q.getName("loading-screen")).appendTo(this.$el)
            },
            unrenderLoading: function () {
                this.$loading && this.$loading.remove();
                this.$el.find(">*").show()
            },
            renderError: function (c) {
                this.$error && this.$error.remove();
                this.$el.find(">*").hide();
                this.$error = h("<div></div>").addClass(q.getName("error-screen")).append(c).appendTo(this.$el)
            },
            show: function () {
                this.$el.show()
            },
            hide: function () {
                this.$el.hide()
            },
            unrenderError: function () {
                this.$error && this.$error.remove();
                this.$el.find(">*").show()
            }
        })
    };
    "undefined" != typeof define && define.amd && define("widget-common/BackboneWidget", ["jquery", "Backbone", "widget-common/Widget", "widget-common/utils/css-utils"], x);
    "undefined" != typeof n && (n.BackboneWidget = x(n.$, n.Backbone, n.Widget, n.cssUtils));
    x = function () {
        var h = {};
        (function () {
            var n = function (a, b) {
                var c = a.style[b],
                    d;
                a.currentStyle ? d = a.currentStyle[b] : window.getComputedStyle && (d = document.defaultView.getComputedStyle(a, null).getPropertyValue(b));
                c = d || c;
                if ("auto" == c && "cursor" ==
                    b) {
                    d = ["a"];
                    for (var e = 0; e < d.length; e++)
                        if (a.tagName.toLowerCase() == d[e]) return "pointer"
                }
                return c
            }, s = function (a) {
                    if (f.prototype._singleton) {
                        a || (a = window.event);
                        var b;
                        this !== window ? b = this : a.target ? b = a.target : a.srcElement && (b = a.srcElement);
                        f.prototype._singleton.setCurrent(b)
                    }
                }, q = function (a, b) {
                    if (a.addClass) return a.addClass(b), a;
                    if (b && "string" === typeof b) {
                        var c = (b || "").split(/\s+/);
                        if (1 === a.nodeType)
                            if (a.className) {
                                for (var d = " " + a.className + " ", e = a.className, f = 0, h = c.length; f < h; f++) 0 > d.indexOf(" " + c[f] +
                                    " ") && (e += " " + c[f]);
                                a.className = e.replace(/^\s+|\s+$/g, "")
                            } else a.className = b
                    }
                    return a
                }, c = function (a, b) {
                    if (a.removeClass) return a.removeClass(b), a;
                    if (b && "string" === typeof b || void 0 === b) {
                        var c = (b || "").split(/\s+/);
                        if (1 === a.nodeType && a.className)
                            if (b) {
                                for (var d = (" " + a.className + " ").replace(/[\n\t]/g, " "), e = 0, f = c.length; e < f; e++) d = d.replace(" " + c[e] + " ", " ");
                                a.className = d.replace(/^\s+|\s+$/g, "")
                            } else a.className = ""
                    }
                    return a
                }, b = function (a) {
                    return (0 <= a.indexOf("?") ? "&" : "?") + "nocache=" + (new Date).getTime()
                },
                a = function (a) {
                    var b = [];
                    a.trustedDomains && ("string" === typeof a.trustedDomains ? b.push("trustedDomain=" + a.trustedDomains) : b.push("trustedDomain=" + a.trustedDomains.join(",")));
                    return b.join("&")
                }, d = function (a, b) {
                    if (b.indexOf) return b.indexOf(a);
                    for (var c = 0, d = b.length; c < d; c++)
                        if (b[c] === a) return c;
                    return -1
                }, e = function (a) {
                    if ("string" === typeof a) throw new TypeError("ZeroClipboard doesn't accept query strings.");
                    return a.length ? a : [a]
                }, f = function (c, d) {
                    c && (f.prototype._singleton || this).glue(c);
                    if (f.prototype._singleton) return f.prototype._singleton;
                    f.prototype._singleton = this;
                    this.options = {};
                    for (var e in r) this.options[e] = r[e];
                    for (var h in d) this.options[h] = d[h];
                    this.handlers = {};
                    if (f.detectFlashSupport()) {
                        e = f.prototype._singleton;
                        h = document.getElementById("global-zeroclipboard-html-bridge");
                        if (!h) {
                            var m = '      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" id="global-zeroclipboard-flash-bridge" width="100%" height="100%">         <param name="movie" value="' + e.options.moviePath + b(e.options.moviePath) + '"/>         <param name="allowScriptAccess" value="' +
                                e.options.allowScriptAccess + '"/>         <param name="scale" value="exactfit"/>         <param name="loop" value="false"/>         <param name="menu" value="false"/>         <param name="quality" value="best" />         <param name="bgcolor" value="#ffffff"/>         <param name="wmode" value="transparent"/>         <param name="flashvars" value="' + a(e.options) + '"/>         <embed src="' + e.options.moviePath + b(e.options.moviePath) + '"           loop="false" menu="false"           quality="best" bgcolor="#ffffff"           width="100%" height="100%"           name="global-zeroclipboard-flash-bridge"           allowScriptAccess="always"           allowFullScreen="false"           type="application/x-shockwave-flash"           wmode="transparent"           pluginspage="http://www.macromedia.com/go/getflashplayer"           flashvars="' +
                                a(e.options) + '"           scale="exactfit">         </embed>       </object>';
                            h = document.createElement("div");
                            h.id = "global-zeroclipboard-html-bridge";
                            h.setAttribute("class", "global-zeroclipboard-container");
                            h.setAttribute("data-clipboard-ready", !1);
                            h.style.position = "absolute";
                            h.style.left = "-9999px";
                            h.style.top = "-9999px";
                            h.style.width = "15px";
                            h.style.height = "15px";
                            h.style.zIndex = "9999";
                            h.innerHTML = m;
                            document.body.appendChild(h)
                        }
                        e.htmlBridge = h;
                        e.flashBridge = document["global-zeroclipboard-flash-bridge"] ||
                            h.children[0].lastElementChild
                    }
                }, v, m = [];
            f.prototype.setCurrent = function (a) {
                v = a;
                this.reposition();
                a.getAttribute("title") && this.setTitle(a.getAttribute("title"));
                this.setHandCursor("pointer" == n(a, "cursor"))
            };
            f.prototype.setText = function (a) {
                a && "" !== a && (this.options.text = a, this.ready() && this.flashBridge.setText(a))
            };
            f.prototype.setTitle = function (a) {
                a && "" !== a && this.htmlBridge.setAttribute("title", a)
            };
            f.prototype.setSize = function (a, b) {
                this.ready() && this.flashBridge.setSize(a, b)
            };
            f.prototype.setHandCursor =
                function (a) {
                    this.ready() && this.flashBridge.setHandCursor(a)
            };
            f.version = "1.1.7";
            var r = {
                moviePath: "ZeroClipboard.swf",
                trustedDomains: null,
                text: null,
                hoverClass: "zeroclipboard-is-hover",
                activeClass: "zeroclipboard-is-active",
                allowScriptAccess: "sameDomain"
            };
            f.setDefaults = function (a) {
                for (var b in a) r[b] = a[b]
            };
            f.destroy = function () {
                f.prototype._singleton.unglue(m);
                var a = f.prototype._singleton.htmlBridge;
                a.parentNode.removeChild(a);
                delete f.prototype._singleton
            };
            f.detectFlashSupport = function () {
                var a = !1;
                try {
                    new ActiveXObject("ShockwaveFlash.ShockwaveFlash") &&
                        (a = !0)
                } catch (b) {
                    navigator.mimeTypes["application/x-shockwave-flash"] && (a = !0)
                }
                return a
            };
            f.prototype.resetBridge = function () {
                this.htmlBridge.style.left = "-9999px";
                this.htmlBridge.style.top = "-9999px";
                this.htmlBridge.removeAttribute("title");
                this.htmlBridge.removeAttribute("data-clipboard-text");
                c(v, this.options.activeClass);
                v = null;
                this.options.text = null
            };
            f.prototype.ready = function () {
                var a = this.htmlBridge.getAttribute("data-clipboard-ready");
                return "true" === a || !0 === a
            };
            f.prototype.reposition = function () {
                if (!v) return !1;
                var a = v,
                    b = 0,
                    c = 0,
                    d = a.width || a.offsetWidth || 0,
                    e = a.height || a.offsetHeight || 0,
                    f = 9999,
                    h = n(a, "zIndex");
                for (h && "auto" != h && (f = parseInt(h, 10)); a;) var h = parseInt(n(a, "borderLeftWidth"), 10),
                m = parseInt(n(a, "borderTopWidth"), 10), b = b + (isNaN(a.offsetLeft) ? 0 : a.offsetLeft), b = b + (isNaN(h) ? 0 : h), c = c + (isNaN(a.offsetTop) ? 0 : a.offsetTop), c = c + (isNaN(m) ? 0 : m), a = a.offsetParent;
                this.htmlBridge.style.top = c + "px";
                this.htmlBridge.style.left = b + "px";
                this.htmlBridge.style.width = d + "px";
                this.htmlBridge.style.height = e + "px";
                this.htmlBridge.style.zIndex =
                    f + 1;
                this.setSize(d, e)
            };
            f.dispatch = function (a, b) {
                f.prototype._singleton.receiveEvent(a, b)
            };
            f.prototype.on = function (a, b) {
                for (var c = a.toString().split(/\s/g), d = 0; d < c.length; d++) a = c[d].toLowerCase().replace(/^on/, ""), this.handlers[a] || (this.handlers[a] = b);
                this.handlers.noflash && !f.detectFlashSupport() && this.receiveEvent("onNoFlash", null)
            };
            f.prototype.addEventListener = f.prototype.on;
            f.prototype.off = function (a, b) {
                for (var c = a.toString().split(/\s/g), d = 0; d < c.length; d++) {
                    a = c[d].toLowerCase().replace(/^on/,
                        "");
                    for (var e in this.handlers) e === a && this.handlers[e] === b && delete this.handlers[e]
                }
            };
            f.prototype.removeEventListener = f.prototype.off;
            f.prototype.receiveEvent = function (a, b) {
                a = a.toString().toLowerCase().replace(/^on/, "");
                var d = v;
                switch (a) {
                case "load":
                    if (b && 10 > parseFloat(b.flashVersion.replace(",", ".").replace(/[^0-9\.]/gi, ""))) {
                        this.receiveEvent("onWrongFlash", {
                            flashVersion: b.flashVersion
                        });
                        return
                    }
                    this.htmlBridge.setAttribute("data-clipboard-ready", !0);
                    break;
                case "mouseover":
                    q(d, this.options.hoverClass);
                    break;
                case "mouseout":
                    c(d, this.options.hoverClass);
                    this.resetBridge();
                    break;
                case "mousedown":
                    q(d, this.options.activeClass);
                    break;
                case "mouseup":
                    c(d, this.options.activeClass);
                    break;
                case "datarequested":
                    var e = d.getAttribute("data-clipboard-target");
                    (e = (e = e ? document.getElementById(e) : null) ? e.value || e.textContent || e.innerText : d.getAttribute("data-clipboard-text")) && this.setText(e);
                    break;
                case "complete":
                    this.options.text = null
                }
                this.handlers[a] && (e = this.handlers[a], "function" == typeof e ? e.call(d, this, b) :
                    "string" == typeof e && window[e].call(d, this, b))
            };
            f.prototype.glue = function (a) {
                a = e(a);
                for (var b = 0; b < a.length; b++)
                    if (-1 == d(a[b], m)) {
                        m.push(a[b]);
                        var c = a[b],
                            f = s;
                        c.addEventListener ? c.addEventListener("mouseover", f, !1) : c.attachEvent && c.attachEvent("onmouseover", f)
                    }
            };
            f.prototype.unglue = function (a) {
                a = e(a);
                for (var b = 0; b < a.length; b++) {
                    var c = a[b],
                        f = s;
                    c.removeEventListener ? c.removeEventListener("mouseover", f, !1) : c.detachEvent && c.detachEvent("onmouseover", f);
                    c = d(a[b], m); - 1 != c && m.splice(c, 1)
                }
            };
            "undefined" !== typeof h ?
                h.exports = f : "function" === typeof define && define.amd ? define(function () {
                    return f
                }) : window.ZeroClipboard = f
        })();
        return h.exports
    };
    "undefined" !== typeof define && define.amd && define("ZeroClipboard", [], x);
    if ("undefined" != typeof n) try {
        n.ZeroClipboard = x()
    } catch (nc) {
        window.ZeroClipboard = x()
    }
    x = function () {
        return {
            isEmail: function (h) {
                h = String(h);
                return h.match(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i)
            }
        }
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/validators", [], x);
    "undefined" != typeof n && (n.validators = x());
    x = function () {
        var h = {}, n = function (h, n) {
                for (var c in h)
                    if (h.hasOwnProperty(c)) {
                        var b = n(c);
                        h[b] = h[c]
                    }
            };
        h.clientConfig = function (h) {
            var q = function (c) {
                return c.toLowerCase()
            };
            n(h.zones, q);
            n(h.zone_campaigns, q);
            return h
        };
        return h
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/utils/config-processors", [], x);
    "undefined" != typeof n && (n.configProcessors = x());
    x = function (h,
        n) {
        var s = {}, q = function (a) {
                return function () {
                    if (window.console && console.log) {
                        var b = console[a],
                            c = Array.prototype.slice.call(arguments, 0);
                        b || (b = console.log, c.unshift("[" + a.toUpperCase() + "]"));
                        b.apply(console, c)
                    }
                }
            }, c = {
                error: q("error"),
                info: q("info")
            }, b = function () {
                c.error("You are using an outdated config file. Please re-publish.")
            };
        s.convertCampaignTimestampToDate = function (a) {
            var b = a.substring(0, 4),
                c = a.substring(4, 6),
                f = a.substring(6, 8),
                h = a.substring(9, 11);
            a = a.substring(11, 13);
            return f = new Date(b, parseInt(c) -
                1, f, h, a)
        };
        s.getLatestCampaignTimestamp = function (a) {
            if (!a.campaign_last_published_dates) return b(), !1;
            var c = [];
            a = a.campaign_last_published_dates;
            for (var e in a)
                if (a.hasOwnProperty(e)) {
                    var f = s.convertCampaignTimestampToDate(a[e]);
                    c.push(f.getTime())
                }
            c.sort();
            return c[c.length - 1] || (new Date).getTime()
        };
        s.getTimestampedCampaignId = function (a, d) {
            if (!a.campaign_last_published_dates) return b(), d;
            var e = a.campaign_last_published_dates[d];
            return e ? d + "_" + e : (c.error("There is no published date for this campaign"),
                d)
        };
        s.getZoneCampaigns = function (a, c) {
            if (!a.zone_campaigns) return b(), [];
            var e = a.zone_campaigns[c] || {}, f = [],
                h = {}, h = {}, m;
            for (m in e) e.hasOwnProperty(m) && (h = e[m], h = {
                id: m,
                percent_chance: h.percent_chance
            }, f.push(h));
            return f
        };
        s.getCampaignFromZone = function (a, c) {
            if (!a.zone_campaigns) return b(), !1;
            var e = s.getZoneCampaigns(a, c),
                f = 100 * Math.random(),
                h = e[0];
            if (!h) return !1;
            for (var m = 0, n = 0; n < e.length; n++) {
                h = e[n];
                if (f > m && f < h.percent_chance) break;
                m = h.percent_chance
            }
            return h.id
        };
        s.getSite = function (a) {
            var b = a.sites,
                c = [];
            a = s.normalizePrograms(a);
            var f = location.hostname.toLowerCase(),
                h;
            for (h in b)
                if (b.hasOwnProperty(h)) {
                    var m = b[h];
                    b[h.toLowerCase()] = m;
                    c.push(m)
                }(b = b[f]) || a[f] && (b = c[0]);
            return b
        };
        s.normalizePrograms = function (a) {
            a = a.programs;
            for (var b in a)
                if (a.hasOwnProperty(b)) {
                    var c = a[b];
                    a[b.toLowerCase()] = c
                }
            return a
        };
        s.getProgram = function (a) {
            var b = s.getSite(a),
                c = window.location.hostname.toLowerCase();
            a = s.normalizePrograms(a);
            c = a[c];
            !c && b && (c = a[b.program_url]);
            return c
        };
        s.getProgramsAndSites = function (a) {
            var b = [],
                c = [],
                f;
            for (f in a.sites) b.push(f);
            for (f in a.programs) c.push(f);
            return {
                programs: c,
                sites: b
            }
        };
        s.selectCreative = function (a, b) {
            for (var c = h.extend(!0, {}, a.options || {}, b.options || {}), f = {
                    options: c
                }, c = c.type ? "_" + c.type : "", n = ["templates", "template_vars", "css"], m, r; m = n.pop();) r = m + c, "css" == m ? (f[m] = a[r], b[m] && (f[m] += " " + b[m])) : f[m] = h.extend(!0, {}, a[r] || {}, b[m] || {});
            return f
        };
        s.zoneBlacklisted = function (a, b) {
            var c = a.zones[b] || {}, f = c.whitelist && RegExp(c.whitelist),
                c = c.blacklist && RegExp(c.blacklist);
            if (f || c) {
                f =
                    f ? location.toString().match(f) : !0;
                if (c && location.toString().match(c)) return h.log("Location is on black list"), !0;
                if (!f) return h.log("Not on white list uri"), !0
            }
            return !1
        };
        s.getSharedVars = function () {
            for (var a = document.getElementsByTagName("script"), b = {}, c, f = 0; f < a.length; f++)
                if ("extole/context" == a[f].type) {
                    c = void 0;
                    try {
                        c = L.parse(a[f].innerHTML)
                    } catch (n) {
                        minutils.log.error("Bad JSON in context script tag.")
                    }
                    void(c && h.extend(b, c))
                }
            var a = h.cookie("xtl_fle"),
                m;
            try {
                m = L.parse(a)
            } catch (r) {
                "" !== a && h.log("Your fle cookie is incorrectly formatted."),
                m = {}
            }
            return h.extend(!0, m, b)
        };
        return s
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/utils/config-utils-min", ["widget-common/min-utils/base", "widget-common/min-utils/cookie"], x);
    "undefined" != typeof n && (n.configUtilsMin = x(n.minUtils, n.minUtilsCookie));
    x = function (h, n) {
        window.extole = window.extole || {};
        extole.eventsHash = extole.eventsHash || {};
        var s = {}, q = function (c) {
                this.callbacks = [];
                this.name = c
            };
        s.on = function (c, b) {
            h.each(c.split(" "), function (a) {
                extole.eventsHash[a] || (extole.eventsHash[a] =
                    new q(a));
                extole.eventsHash[a].callbacks.push(b)
            })
        };
        s.off = function (c, b) {
            h.each(c.split(" "), function (a) {
                if (extole.eventsHash[a])
                    if (b) {
                        var c = -1;
                        h.each(extole.eventsHash[a].callbacks, function (a, f) {
                            if (a == b) return c = f, !1
                        });
                        0 < c && extole.eventsHash[a].callbacks.splice(c, 1)
                    } else extole.eventsHash[a].callbacks = []
            })
        };
        s.trigger = function (c, b, a) {
            a = a || {};
            a.sharedVars = a.sharedVars || n.getSharedVars();
            if (!b || b && !b.client || b && !b.client.client_id) return h.log.error("events.trigger needs a valid client config as it's second argument"), !1;
            var d = c.split(":"),
                e, f = {
                    sharedVars: 1,
                    zoneName: 1,
                    clientConfig: 1,
                    campaignId: 1
                }, v = h.mapObj(a, function (a, b) {
                    if (!f[b]) return a
                });
            b = b.client || {};
            var m = n.getSite(b) || {}, r = h.extend(!0, v, a.sharedVars || {}, {
                    eventName: c,
                    eventNameRemainder: c,
                    user: a.user,
                    zoneName: a.zoneName,
                    clientId: b.client_id,
                    clientName: b.name,
                    campaignId: a.campaignId,
                    siteId: m.site_id
                });
            cbFunc = function (a) {
                a(r)
            };
            h.log("** advocate-widget/events ** trigger", "name:", c, "eventData:", r);
            for (c = d.length; 0 < c; c--)
                if (e = d.slice(0, c).join(":"), extole.eventsHash[e]) {
                    h.each(extole.eventsHash[e].callbacks,
                        function (a) {
                            a(h.extend({}, r, {
                                eventNameRemainder: e
                            }))
                        });
                    break
                }
        };
        s.init = function () {
            extole.clientEvents = "undefined" != typeof window.extoleEvents ? extoleEvents : {};
            h.each(extole.clientEvents, function (c, b) {
                s.on(b, c)
            })
        };
        extole.events = s;
        "undefined" != typeof extoleEventsAsyncInit && (extoleEventsAsyncInit instanceof Function && void 0 !== extoleEventsAsyncInit.call) && extoleEventsAsyncInit();
        s.init();
        return s
    };
    "undefined" != typeof define && define.amd && define("advocate-widget/events", ["widget-common/min-utils/base", "advocate-widget/utils/config-utils-min"],
        x);
    "undefined" != typeof n && (n.events = x(n.minUtils, n.configUtilsMin));
    (function (h, n, s, q, c, b, a) {
        h.GoogleAnalyticsObject = c;
        h[c] = h[c] || function () {
            (h[c].q = h[c].q || []).push(arguments)
        };
        h[c].l = 1 * new Date;
        b = n.createElement(s);
        a = n.getElementsByTagName(s)[0];
        b.async = 1;
        b.src = q;
        a.parentNode.insertBefore(b, a)
    })(window, document, "script", "//www.google-analytics.com/analytics.js", "xtl_ga");
    window.xtl_ga("create", "UA-41025338-1");
    window.xtl_ga("send", "pageview");
    (function () {
        var h = function (h, n) {
            var q = {
                ajaxMethod: "get",
                complete: function () {
                    h.log("done")
                },
                baseUrl: "",
                data: {},
                silentFail: function (a) {
                    h.log.error(a);
                    this.send = function () {}
                },
                constructor: function (a) {
                    this.request = h.ajax.create();
                    this.options = h.extend({}, a);
                    this.options.baseUrl && (this.baseUrl = this.options.baseUrl);
                    this.options.data && (this.data = this.options.data)
                },
                getUrl: function () {
                    return this.baseUrl
                },
                send: function (a) {
                    h.ajax.send(this.request, {
                        url: this.getUrl(),
                        type: this.ajaxMethod,
                        complete: a,
                        data: L.stringify(this.getData())
                    })
                },
                getData: function () {
                    return this.data
                },
                setData: function (a) {
                    this.data = a
                }
            }, c = h.extend({}, q, {
                    constructor: function (a) {
                        a.programUrl ? (this.programUrl = a.programUrl, a.baseUrl = "//" + this.programUrl + "/v2/stream") : this.silentFail("No program url passed to stream call. Cannot send.");
                        q.constructor.call(this, a)
                    }
                }),
                b = h.extend({}, c, {
                    ajaxMethod: "post",
                    eventType: void 0,
                    googleAnalyticsData: void 0,
                    constructor: function (a, b) {
                        (this.campaignId = a) || "string" == typeof this.campaignId || this.silentFail("Stream with campaign call can not fire. Must pass campaignId.");
                        this.eventType || this.silentFail("Stream with campaign call must have event type defined.");
                        this.googleAnalyticsData || h.log.error("Stream with campaign call can not send google analytics data.");
                        this.site = b.site;
                        c.constructor.call(this, b)
                    },
                    getData: function () {
                        return h.extend(!0, this.data, {
                            campaign_id: this.campaignId,
                            event_type: this.eventType,
                            screen_wh: window.screen.width + "," + window.screen.height,
                            site_id: this.site ? this.site.site_id : null
                        })
                    },
                    send: function () {
                        c.send.apply(this, arguments);
                        this.googleAnalyticsData &&
                            window.xtl_ga && xtl_ga("send", "event", this.googleAnalyticsData)
                    }
                }),
                a = function () {
                    this.constructor.apply(this, arguments)
                };
            a.prototype = h.extend({}, b, {
                eventType: "CTA_IMPRESSION",
                googleAnalyticsData: {
                    eventCategory: "ClickStream",
                    eventAction: "Impression"
                }
            });
            var d = function () {
                this.constructor.apply(this, arguments)
            };
            d.prototype = h.extend({}, b, {
                eventType: "CTA_CLICK",
                googleAnalyticsData: {
                    eventCategory: "ClickStream",
                    eventAction: "Click"
                }
            });
            return {
                ImpressionCall: a,
                ClickCall: d
            }
        };
        "undefined" !== typeof define && define.amd &&
            define("advocate-widget/analytics-calls", ["widget-common/min-utils/base", "widget-common/min-utils/ajax"], h);
        "undefined" != typeof n && (n.analyticsCalls = h(n.minUtils, n.minUtilsAjax))
    })();
    x = function (h, n, s, q, c, b, a, d, e, f, v) {
        window.extole || (window.extole = {});
        var m = "";
        return h.extend({}, f, {
            fetchCampaignConfig: function (a, c, d) {
                var e = a.client.client_id,
                    h = c;
                a.zones[h] && (c = f.getCampaignFromZone(a, h));
                if (a.campaign_last_published_dates && !a.campaign_last_published_dates[c]) return v.log('No valid campaign matches campaign id "' +
                    c + '" or zone name "' + h + '"'), d(!1);
                if (!c) return v.log("No campaign id."), d(!1);
                a = m + "/c/clients/" + e + "/campaign_" + f.getTimestampedCampaignId(a, c) + ".json";
                b.errorFetch(a, function (a) {
                    "string" == typeof a && (a = L.parse(a));
                    d(a)
                }, {
                    error: function () {
                        d(!1)
                    }
                })
            },
            fetchClientConfig: function (a, c) {
                b.errorFetch(m + "/c/clients/" + a + "/client_" + a + ".json", function (a) {
                    "string" == typeof a && (a = L.parse(a));
                    return c(e.clientConfig(a))
                }, {
                    error: function () {
                        c(!1)
                    }
                })
            },
            fetchBaseCreatives: function (a, c, d, e, n) {
                var v = {
                    start: function () {
                        var c =
                            h.map(d, function (b) {
                                return m + "/base-creatives/" + a + "/" + b + "-creatives.json"
                            });
                        b.ready(c, v.withCreatives)
                    },
                    withCreatives: function () {
                        var a = Array.prototype.slice.call(arguments),
                            b = [];
                        h.each(d, function (d, e) {
                            var h = L.parse(a[d] || "{}"),
                                m = e.replace(/-/g, "_"),
                                h = f.selectCreative(h, c[m] || {});
                            b.push(h)
                        });
                        e.apply(this, b)
                    }
                };
                v.start()
            },
            getBaseCreativesVersion: function (a, c) {
                var d = "default",
                    e = a.client;
                try {
                    d = String(e.versions.base_creative || "default")
                } catch (f) {}
                "default" == d.toLowerCase() ? b.ready([m + "/base-creatives/static/version.txt"],
                    function (a) {
                        c(h.trim(a))
                    }) : c(d)
            },
            getInitParams: function (a) {
                var b = {
                    init: {},
                    client: {}
                };

                if (!a) return b;
                h.each(a, function (a, d) {
                    var e = b.init; - 1 < a.indexOf("tag:") ? (a = a.substring(4), e = b.client) : "e" != a || c.isEmail(d) || (v.log("Initialized with invalid email address (" + d + ") - (configUtils.getInitParams)"), d = void 0);
                    e[a] = d
                });
                return b
            },
            setMediaServer: function (a) {
                m = a
            },
            getMediaServer: function () {
                return m
            }
        })
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/utils/config-utils", "jquery jsuri Underscore Backbone advocate-widget/validators widget-common/utils/loader-utils widget-common/utils/css-utils widget-common/utils/template-utils advocate-widget/utils/config-processors advocate-widget/utils/config-utils-min widget-common/min-utils/base".split(" "),
        x);
    "undefined" != typeof n && (n.configUtils = x(n.$, n.Uri, n._, n.Backbone, n.validators, n.loaderUtils, n.cssUtils, n.templateUtils, n.configProcessors, n.configUtilsMin, n.minUtils));
    x = function (h, n, s, q) {
        extole = window.extole || {};
        var c = {
            loadCloudsponge: function (b) {
                b = b || function () {};
                extole.cloudspongeLoaded ? b() : extole.cloudspongeLoading ? setTimeout(function () {
                    c.loadCloudsponge(b)
                }, 200) : (extole.cloudspongeLoading = !0, h.getScript("https://api.cloudsponge.com/address_books.js", function () {
                    extole.cloudspongeLoaded = !0;
                    b()
                }))
            },
            init: function (b, a, d) {
                a = a || {};
                if (!b) return q.log("No key exists. Can't init cloudsponge."), !1;
                if (!window.cloudsponge) return c.loadCloudsponge(function () {
                    c.init(b, a, d)
                }), !1;
                window.cloudsponge = cloudsponge;
                a.domain_key = b;
                cloudsponge.init(a);
                d()
            },
            launchWidget: function (b, a) {
                c.init(b, {
                    afterSubmitContacts: function (b) {
                        a(b)
                    }
                }, function () {
                    cloudsponge.launch()
                })
            }
        };
        return c
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/utils/cs-utils", ["jquery", "JSON", "jsuri", "widget-common/min-utils/base"],
        x);
    "undefined" != typeof n && (n.csUtils = x(n.jQuery, n.JSON, n.Uri, n.minUtils));
    x = function (h) {
        var n = {
            _user: void 0,
            LOGIN_ERROR: {
                error: {
                    message: "User didn't login."
                }
            },
            NOT_AUTHORIZED_ERROR: {
                error: {
                    message: "User didn't authorize the application."
                }
            },
            PERMISSION_ERROR: {
                error: {
                    message: "User didn't allow the required permissions."
                }
            },
            loginError: function (h) {
                delete n._initialResponse;
                return h
            },
            init: function (s, q) {
                s = h.extend(!0, {
                    debug: !0,
                    app: {}
                }, s);
                if (n.isInit) return q(), !1;
                window.fbAsyncInit = function () {
                    FB.init(s.app);
                    FB.getLoginStatus(function (c) {
                        var b = {
                            start: function () {
                                "connected" == c.status ? (n._initialResponse = c, n.saveUser(function (a) {
                                    b.finish()
                                })) : b.finish()
                            },
                            finish: function () {
                                n.isInit = !0;
                                q()
                            }
                        };
                        b.start()
                    })
                };
                (function (c, b) {
                    var a, d = c.getElementsByTagName("script")[0];
                    c.getElementById("facebook-jssdk") || (a = c.createElement("script"), a.id = "facebook-jssdk", a.async = !0, a.src = "//connect.facebook.net/en_US/all" + (b ? "/debug" : "") + ".js", d.parentNode.insertBefore(a, d))
                })(document, s.debug)
            },
            getUser: function (h) {
                return void 0 !==
                    n._user ? n._user : !1
            },
            login: function (h, q) {
                h = h || ["email"];
                n.hasPermissions(h) || (n._initialResponse = void 0);
                if (n.getUser() && n.hasPermissions(h)) q(n.getUser());
                else {
                    var c = {
                        start: function () {
                            n._initialResponse ? c.afterLogin(n._initialResponse) : FB.login(c.afterLogin, {
                                scope: h.join(",")
                            })
                        },
                        afterLogin: function (b) {
                            b.authResponse ? "connected" !== b.status ? q(n.loginError(n.NOT_AUTHORIZED_ERROR)) : (n._initalResponse = b, n.saveUser(function (a) {
                                n.hasPermissions(h) ? q(a) : q(n.loginError(n.PERMISSION_ERROR))
                            })) : q(n.loginError(n.LOGIN_ERROR))
                        }
                    };
                    c.start()
                }
            },
            saveUser: function (h) {
                FB.api("/me?fields=first_name,last_name,email,permissions", function (q) {
                    q.error || (n._user = q);
                    h(q)
                })
            },
            hasPermissions: function (h) {
                var q = n.getUser();
                if (q && (!q || q.permissions) && (q = q.permissions.data[0]))
                    for (var c = 0; c < h.length; c++) {
                        if (1 != q[h[c]]) return !1
                    } else return !1;
                return !0
            }
        };
        return n
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/utils/fb-utils", ["jquery"], x);
    "undefined" != typeof n && (n.fbUtils = x(n.$));
    x = function (h, n, s) {
        var q = {
            xtl_client_id: "client_id",
            xtl_zone_name: "zone_name",
            xtl_campaign_id: "campaign_id"
        }, c = {
                e: "email",
                f: "first_name",
                l: "last_name",
                source: !0,
                partner_user_id: !0
            };
        return {
            RESERVED_KEYS: c,
            QUERY_PARAMS_MAP: q,
            getParams: function () {
                var b = (new s(window.location)).query().toString(),
                    b = h.deserialize(b),
                    a = {
                        extole: {},
                        client: {},
                        original: b
                    }, c;
                for (c in b) q[c] ? a.extole[q[c]] = b[c] : a.client[c] = b[c];
                return a
            },
            getPrefixedVars: function (b) {
                var a = {};
                h.each(b, function (b, e) {
                    c[b] || (b = "tag:" + b);
                    a[b] = e
                });
                return a
            }
        }
    };
    "undefined" !== typeof define && define.amd &&
        define("advocate-widget/utils/param-utils", ["jquery", "widget-common/jquery-plugins", "jsuri"], x);
    "undefined" != typeof n && (n.paramUtils = x(n.$, n.jqueryPlugins, n.Uri));
    x = function (h) {
        var n = h.RESERVED_KEYS,
            s = {
                purchase: {
                    partner_conversion_id: !0
                },
                share: {}
            };
        return {
            getParamsForCall: function (h, c) {
                c && (c = c.toLowerCase());
                var b = {}, a = c && s[c],
                    d = function (a) {
                        var c, d;
                        for (c in a) a.hasOwnProperty(c) && (d = a[c], !0 === d && (d = c), b[d] = h.init[c])
                    };
                d(n);
                a && d(a);
                c && (b.action_type = c.toUpperCase());
                b.client_params = h.client;
                return b
            }
        }
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/utils/call-utils", ["advocate-widget/utils/param-utils"], x);
    "undefined" != typeof n && (n.callUtils = x(n.paramUtils));
    x = function (h, n) {
        return {
            emailEvents: {
                "click .email-not-you-button_id_": "notYouHandler"
            },
            validateRules: {
                email: {
                    email: !0,
                    required: !0
                },
                emails: "required",
                email_message: "required"
            },
            notYouHandler: function (h) {
                h.preventDefault();
                this.widget.user.logout()
            },
            hideNotYouButtonIfAutoReg: function () {
                this.widget.user.isAutoReg() && this.$el.find(n.getName(".email-not-you-button")).hide()
            },
            setValidator: function () {
                var h = this;
                h.validator = h.getFromEmailElements().$form.validate(h.getValidateRules({
                    rules: h.validateRules,
                    submitHandler: function (n) {
                        h.submitForm(n)
                    }
                }))
            },
            toggleNotYouLink: function () {
                var h = this.widget.user,
                    n = this.getFromEmailElements();
                h.has("email") ? (n.$fromInput.hide(), n.$fromInput.find("input").val(h.get("email")), n.$filledEmailValue.html(h.get("email")), n.$filledEmailDiv.show(), this.hideNotYouButtonIfAutoReg()) : (n.$filledEmailDiv.hide(), n.$fromInput.show())
            },
            getFromEmailElements: function () {
                if (this.fromEmailElements) return this.fromEmailElements;
                var h = this.fromEmailElements = {};
                h.$form = this.$el.find("form");
                h.$fromSection = this.$el.find("." + n.getName("email-input-section"));
                h.$fromInput = h.$fromSection.find("." + n.getName("input"));
                h.$filledEmailDiv = h.$fromSection.find("." + n.getName("filled-in-email"));
                h.$filledEmailValue = h.$filledEmailDiv.find("." + n.getName("email-display"));
                return h
            }
        }
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/utils/email-utils", ["jquery", "widget-common/utils/css-utils"], x);
    "undefined" != typeof n && (n.emailUtils =
        x(n.$, n.cssUtils));
    x = function () {
        (function () {
            C = "object" === typeof C ? C : {};
            C.debug = !1;
            C.env = "pr";
            C.suffix = {
                lo: "-lo",
                nt: "-nt",
                qa: "-qa",
                pr: ""
            }[C.env];
            C.getEndPoint = function () {
                return window.location.protocol + "//social" + C.suffix + ".extole.com"
            };
            C.serialize = function (h, n, s) {
                n = n ? n : "=";
                s = s ? s : "&";
                var q = [];
                for (k in h) q.push(k + n + h[k]);
                q = q.join(s);
                C.log("Serializing: ", q);
                return q
            };
            C.splitVars = function (h, n, s) {
                n = n ? n : "=";
                s = s ? s : "&";
                for (var q = {}, c = h.split(s), b, a = 0; a < c.length; a++) b = c[a].split(n), C.log("variableParts",
                    b), 1 < b.length && (q[b[0]] = b[1]);
                C.log("splitVars", n, s, h, q);
                return q
            };
            C.log = function () {
                if (window.console && this.debug) {
                    var h = Array.prototype.slice.call(arguments);
                    h.unshift(+new Date);
                    console.log(h)
                }
            }
        })();
        (function () {
            var h = function (h, n) {
                C = "object" == typeof C ? C : {};
                C.twitter = {
                    pop: {
                        height: 600,
                        width: 700
                    }
                };
                var q;
                C.twitter.getQueryString = function (a) {
                    a = a || {};
                    a.message_namespace = "graf-twitter";
                    return C.serialize(a)
                };
                var c = function (a) {
                    var b, c = !1,
                        f = function (b) {
                            if (c) return !1;
                            q.close();
                            c = !0;
                            delete q;
                            a(b)
                        };
                    h(window).on("message",
                        function (a) {
                            a = a.originalEvent.data;
                            0 == a.indexOf("graf-twitter") && (a = a.substring(15), f(n.parse(a)))
                        });
                    b = function () {
                        if (q.location) {
                            try {
                                if (q.location && q.location.host && void 0 !== q.location.hash && void 0 !== q.location.search) {
                                    var c = q.location,
                                        e = decodeURIComponent(c.hash.substring(1)),
                                        h = decodeURIComponent(c.search.substring(1)),
                                        e = C.splitVars(h + e, "=", ",");
                                    f(e)
                                }
                            } catch (n) {}
                            setTimeout(b, 500)
                        } else "function" == typeof a && f({
                            errors: "Cancelled"
                        })
                    };
                    setTimeout(b, 500)
                }, b = function (a, b) {
                        var c = {}, f = a + "?" + C.twitter.getQueryString(b);
                        C.log("Endpoint", f);
                        c.height = C.twitter.pop.height;
                        c.width = C.twitter.pop.width;
                        c.left = screen.width / 2 - c.width / 2;
                        c.top = screen.height / 2 - c.height / 2;
                        c.scrollbars = "no";
                        c.status = "no";
                        c.toolbar = "no";
                        c = C.serialize(c, "=", ",");
                        q = window.open(f, "ex_twitter_pop", c);
                        q.focus();
                        return q
                    };
                C.twitter.tweet = function (a, d, e) {
                    a = encodeURIComponent(a);
                    var f = C.getEndPoint() + "/auth/twitter";
                    a = {
                        status: a,
                        twitter_api_key: d,
                        isHash: !0,
                        callback_url: encodeURI(window.location.href.replace(window.location.hash, ""))
                    };
                    b(f, a);
                    c(e)
                };
                C.twitter.auth =
                    function (a, d) {
                        var e = C.getEndPoint() + "/auth/twitter",
                            f = {
                                twitter_api_key: a,
                                is_hash: !0,
                                callback_url: encodeURI(window.location.href.replace(window.location.hash, ""))
                            };
                        q = b(e, f);
                        c(d)
                };
                C.twitter.tweet_authed = function (a, b, c, f) {
                    a = encodeURIComponent(a);
                    var n = C.getEndPoint() + "/tweet",
                        n = n + "?" + C.twitter.getQueryString({
                            status: a,
                            access_token: b,
                            twitter_api_key: c
                        });
                    h.post(n, f)
                }
            };
            "undefined" !== typeof define && define.amd && define("graffiti/twitter", ["jquery", "JSON"], h);
            "undefined" != typeof n && (n.graffitiTwitter = h(n.$,
                n.JSON))
        })();
        C = "object" == typeof C ? C : {};
        C.facebook = {};
        return C
    };
    "undefined" !== typeof window.define && define.amd && define("graffiti", [], x);
    if ("undefined" != typeof n) {
        var C = x();
        try {
            n.graffiti = C
        } catch (oc) {}
    }
    x = function (h, n, s, q, c, b, a, d, e, f, v) {
        var m = {
            xtl_share_id: "xtl_share_id",
            xtl_channel: "xtl_channel",
            xtl_advocate_first_name: "xtl_advocate_first_name",
            xtl_advocate_last_name: "xtl_advocate_last_name",
            xtl_coupon_code: "xtl_coupon_code"
        };
        return f.extend({
            events: {
                "click .close-button_id_": "closeButtonHandler",
                "click .shop-now-button_id_": "shopButtonHandler"
            },
            closeButtonHandler: function (a) {
                a.preventDefault();
                this.unrender()
            },
            shopButtonHandler: function () {
                this.triggerExtoleEvent("click");
                closeButtonHandler.apply(this, arguments)
            },
            initialize: function () {
                var a = this.options,
                    e = this.campaignConfig = a.campaignConfig;
                this.clientConfig = a.clientConfig;
                var e = this.campaign = e.campaign,
                    f = this.creative = d.selectCreative(a.baseCreative, e.creatives.friend_landing_coupon || {});
                this.params = this.parseQueryParams(a.params);
                var h = this.couponId = "extole-coupon-" + e.id;
                if (!e.creatives.friend_landing_coupon) return q.log("-- Not showing friend landing coupon, because there are no creatives for it."), !1;
                this.widgetConfig = a.widgetConfig;
                this.sanitizeCreatives();
                this.insertCss();
                this.$el.attr("id", h).html(c.parse(f.templates.coupon).render(this.getTemplateContext())).addClass(b.getName("extole")).addClass(b.getName("extole-coupon")).addClass(b.getName(this.hasCoupon() ? "has-coupon" : "no-coupon"));
                this.$el.appendTo(document.body);
                this.render()
            },
            insertCss: function () {
                b.injectCss(this.creative.css.replace(/__coupon_id__/g, this.couponId))
            },
            sanitizeCreatives: function () {
                var b = this.creative;
                a.sanitizeTemplates(b.templates);
                a.sanitizeTemplates(b.template_vars)
            },
            getTemplateContext: function () {
                this.templateVars || (this.templateVars = a.resolveTemplateVars(this.creative.template_vars, this.getTemplateVarContext()));
                this.injectOptions();
                return this.templateVars
            },
            injectOptions: function () {
                h.extend(this.templateVars, {
                    options: this.creative.options
                })
            },
            getTemplateVarContext: function () {
                return h.extend({
                    creatives_path: this.options.MEDIA_SERVER + "/base-creatives/" + this.options.baseCreativesVersion
                }, this.params.client)
            },
            parseQueryParams: function (a) {
                var b =
                    h.extend({}, m, this.creative.options.NAME_MAP),
                    c = h.extend(!0, {}, a);
                h.each(b, function (b, d) {
                    a.client[d] && (c.client[b] = decodeURIComponent(String(a.client[d]).replace(/\+/g, "%20")), "undefined" === c.client[b] && (c.client[b] = void 0))
                });
                return c
            },
            render: function () {
                var a = this;
                a.content.invisibleDiv && a.content.invisibleDiv.remove();
                a.content.invisibleDiv = h('<div class="' + b.getName("invisible-div") + '"></div>').appendTo(document.body).css({
                    zIndex: 2147483637
                }).on("click", h.proxy(a.closeButtonHandler, this));
                q.log("invisible z = 2147483637, coupon z = 2147483647");
                a.$el.show().css({
                    zIndex: 2147483647
                });
                var c = function () {
                    a.$el.css({
                        top: h(window).height() / 2 - a.$el.height() / 2
                    })
                };
                h(window).on("resize", c);
                c();
                a.triggerExtoleEvent("view");
                a.triggerExtoleEvent(a.hasCoupon() ? "available" : "not_available");
                window.xtl_ga("send", "event", {
                    eventCategory: "ClickStream",
                    eventAction: "CouponWidgetView"
                })
            },
            hasCoupon: function () {
                var a = this.params.client.xtl_coupon_code;
                return !!("undefined" != typeof a && null != a && 0 < a.toString().length)
            },
            unrender: function () {
                this.content.invisibleDiv && this.content.invisibleDiv.remove();
                this.$el.hide()
            },
            triggerExtoleEvent: function (a) {
                v.trigger("friend_landing:coupon:" + a, this.clientConfig, {
                    campaignId: this.campaign.id
                })
            }
        })
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/coupons/CouponWidget", "jquery widget-common/jquery-plugins Underscore widget-common/min-utils/base Liquid widget-common/utils/css-utils widget-common/utils/template-utils advocate-widget/utils/config-utils Backbone widget-common/BackboneWidget advocate-widget/events".split(" "), x);
    "undefined" != typeof n &&
        (n.CouponWidget = x(n.$, n.jqueryPlugins, n._, n.minUtils, n.Liquid, n.cssUtils, n.templateUtils, n.configUtils, n.Backbone, n.BackboneWidget, n.events));
    x = function (h, n, s, q, c, b, a) {
        return {
            init: function (d, e, f, n) {
                n = n || {};
                var m = b.getParams(),
                    r = {}, u;
                r.start = function () {
                    q.fetchBaseCreatives(f, e.campaign.creatives, ["friend-landing-coupon"], r.withBaseCreatives)
                };
                r.withBaseCreatives = function (b) {
                    u = b;
                    c.injectCss(u.css);
                    b = !0;
                    void 0 !== e.campaign.show_coupon_on_friend_landing && !1 == e.campaign.show_coupon_on_friend_landing &&
                        (b = !1);
                    !0 == b && (extole.coupon = new a(h.extend(!0, n, {
                        clientConfig: d,
                        campaignConfig: e,
                        baseCreative: u,
                        params: m,
                        MEDIA_SERVER: ma,
                        baseCreativesVersion: f
                    })))
                };
                r.start()
            },
            CouponWidget: a
        }
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/coupons", "jquery Underscore Backbone jsuri advocate-widget/utils/config-utils widget-common/utils/css-utils advocate-widget/utils/param-utils advocate-widget/coupons/CouponWidget".split(" "), x);
    "undefined" != typeof n && (n.coupons = x(n.$, n._, n.Backbone, n.configUtils,
        n.cssUtils, n.paramUtils, n.CouponWidget));
    x = function (h, n, s, q, c, b, a, d, e, f) {
        var v = Array.prototype.slice;
        return d.extend({
            initialize: function () {
                var a = this,
                    b = a.options,
                    c = b.widget;
                a.widgetConfig = a.options.widgetConfig;
                a.MEDIA_SERVER = a.options.MEDIA_SERVER;
                a.WIDGET_VERSION = a.options.WIDGET_VERSION;
                a.shareRoot = "//" + a.options.programHost + "/v2";
                a.template = s.parse(b.template);
                a.errorTemplate = s.parse(b.errorTemplate);
                a.shareErrorTemplate = s.parse(b.tryAgainErrorTemplate);
                a.$el = h(a.template.render(c.getTemplateContext()));
                c || alert("Must have reference to parent widget");
                a.widget = c;
                a.user = c.user;
                a.$el.hide();
                b = function (b) {
                    return function () {
                        a.triggerExtoleEvent(b)
                    }
                };
                a.on("shareWidget:render", b("view"));
                a.on("shareRequest:error", b("error"));
                a.on("shareRequest:success", b("success"))
            },
            triggerExtoleEvent: function (a) {
                var b = this.widget;
                this.shareEventType ? b.triggerExtoleEvent("share:" + this.shareEventType + ":" + a) : void 0 === this.shareEventType && minUtils.log.error("share widget does not have shareEventType defined!!", this)
            },
            render: function () {
                var a =
                    this.widget;
                extole.main && (extole.main.visibleWidget && extole.main.visibleWidget == a && a.visibleWidget == this) && this.trigger("shareWidget:render")
            },
            renderError: function (a, b, d) {
                var e = this,
                    f = e.widget,
                    n = e.$el.find("." + c.getName("share-widget-title")),
                    v = e.$el.find("." + c.getName("error-screen")),
                    q = h('<a class="' + c.getName("error-button") + '" href="">Go back</a>').on("click", function (a) {
                        a.preventDefault();
                        e.render()
                    });
                a = {
                    message: a
                };
                d = void 0 !== d ? d : !0;
                b = b || e.errorTemplate;
                0 < v.length && v.remove();
                v = h(b.render(h.extend(a,
                    f.getTemplateContext()))).appendTo(e.$el);
                d && q.appendTo(v);
                e.$el.find(">*").hide();
                v.add(n).show()
            },
            unrenderError: function () {
                var a = this.$el.find("." + c.getName("error-screen"));
                this.$el.find(">*").show();
                a.remove()
            },
            getPurl: function () {
                return "http:" + this.shareRoot + "/share/" + this.getShareId()
            },
            setShareId: function (a) {
                this.shareId = a
            },
            getShareId: function () {
                return this.shareId
            },
            sendShareServiceRequest: function (c, d, e) {
                "function" == typeof d && (e = d, d = {});
                d = h.extend({
                    triggerDone: !0,
                    showLoading: !0
                }, d || {});
                e = e ||
                    function () {};
                var f = this,
                    q = f.widget,
                    s = a.getSite(q.client),
                    x = v.call(arguments, 0),
                    C = function (a) {
                        f.errorTimes = 0;
                        a && f.setShareId(a.action_id);
                        e(a);
                        d.triggerDone && f.trigger("shared")
                    };
                void 0 === f.errorTimes && (f.errorTimes = 0);
                f.sendServiceRequestTimeout && clearTimeout(f.sendServiceRequestTimeout);
                var A = b.getParamsForCall(q.params);
                h.extend(A, {
                    channel: null,
                    campaign_id: q.campaign.id,
                    zone_name: q.zoneName,
                    email: null,
                    first_name: null,
                    last_name: null,
                    channel_email: null,
                    channel_first_name: null,
                    channel_last_name: null,
                    source_url: window.location.toString(),
                    site_id: s ? s.site_id : null,
                    resources: q.getResources(),
                    recipients: null,
                    mouse_xy: q.mouse ? Math.round(q.mouse.x) + "," + Math.round(q.mouse.y) : null,
                    window_wh: h(window).width() + "," + h(window).height(),
                    screen_wh: window.screen.width + "," + window.screen.height
                });
                var E = h.extend({}, A, c);
                q.user.setUserVariables(E);
                E.first_name = q.user.get("first_name");
                E.last_name = q.user.get("last_name");
                E.email = q.user.get("email");
                var V = [];
                h.each(E, function (a) {
                    void 0 === A[a] && void 0 === c[a] && V.push(a)
                });
                h.each(V, function (a, b) {
                    delete E[b]
                });
                d.showLoading && (f.unrenderError(), f.renderLoading());
                h.ajax({
                    url: f.shareRoot + "/share",
                    dataType: "json",
                    contentType: "application/json",
                    processData: !1,
                    type: "post",
                    data: n.stringify(E),
                    xhrFields: {
                        withCredentials: !0
                    },
                    timeout: 3E3,
                    success: function () {
                        f.trigger("shareRequest:success");
                        C.apply(this, arguments)
                    },
                    error: function (a, b, c) {
                        f.errorTimes += 1;
                        3 > f.errorTimes ? (clearTimeout(f.sendServiceRequestTimeout), f.sendServiceRequestTimeout = setTimeout(function () {
                            f.sendShareServiceRequest.apply(f,
                                x)
                        }, 250)) : (f.errorTimes = 0, f.trigger("shareRequest:error"), f.shareServiceRequestError ? f.shareServiceRequestError.apply(f, [c].concat(x)) : C())
                    }
                })
            },
            isMobile: function () {
                var a = this.$("." + c.getName("client_logo_sidebar"));
                window.sidebar = a;
                return a.length && a.is(":hidden")
            },
            shareServiceRequestError: function () {
                var a = this,
                    b = v.call(arguments, 0);
                a.unrenderLoading();
                a.renderError(void 0, a.shareErrorTemplate, !1);
                var d = a.$el.find("." + c.getName("error-screen")),
                    e = d.find('a[data-action="again"]'),
                    d = d.find('a[data-action="cancel"]');
                e.on("click", function (c) {
                    c.preventDefault();
                    a.sendShareServiceRequest.apply(a, b.slice(1))
                });
                d.on("click", function (b) {
                    b.preventDefault();
                    a.render()
                })
            }
        })
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/share-widgets/ShareWidget", "jquery JSON Liquid Backbone widget-common/utils/css-utils advocate-widget/utils/call-utils advocate-widget/utils/config-utils widget-common/BackboneWidget widget-common/Widget advocate-widget/events".split(" "), x);
    "undefined" != typeof n && (n.ShareWidget = x(n.$,
        n.JSON, n.Liquid, n.Backbone, n.cssUtils, n.callUtils, n.configUtils, n.BackboneWidget, n.Widget, n.events));
    x = function (h, n, s, q, c, b, a, d) {
        var e = function (a) {
            a = String(a);
            return a.match(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i)
        };
        return b.extend({
            shareEventType: "email",
            events: n.extend({
                "click .cloudsponge-button_id_": "csButtonHandler"
            }, d.emailEvents),
            csButtonHandler: function (b) {
                b.preventDefault();
                var c = h(document).scrollTop(),
                    d = this.$el.find('textarea[name="emails"]');
                a.launchWidget(this.cloudspongeApiKey, function (a) {
                    h.each(a, function (b, c) {
                        var e = b !== a.length - 1;
                        d.tagInput("addTag", c.selectedEmail(), e)
                    });
                    c !== h(document).scrollTop() && h("html, body").animate({
                        scrollTop: c
                    }, 0)
                })
            },
            initialize: function () {
                n.extend(this, d);
                b.prototype.initialize.apply(this,
                    arguments);
                var c = this,
                    h = c.widget;
                h.client.cloudsponge_keys && (c.cloudspongeApiKey = h.client.cloudsponge_keys[window.location.hostname]);
                c.$el.find('textarea[name="emails"]').tagInput({
                    maxLength: h.advocateWidgetCreative.options.max_tag_length,
                    newTagLabel: c.$el.find('textarea[name="emails"]').siblings("label").text(),
                    validator: e,
                    onErrorShow: function () {
                        R("error show");
                        var a = c.validator;
                        a.showErrors({
                            emails: a.defaultMessage("emails", "email")
                        })
                    },
                    onErrorHide: function () {
                        R("error hide");
                        var a = c.validator;
                        a.resetForm();
                        a.checkForm()
                    },
                    maxDisplayTags: 9,
                    classFilter: function (a) {
                        return s.getName(a)
                    }
                });
                a.init(c.cloudspongeApiKey, {
                    floatbox: {
                        zIndex: h.getBaseZIndices().widget + 10
                    }
                }, function () {});
                h = c.widget;
                h = q.parse(h.advocateWidgetCreative.template_vars.email_message).render({
                    resources: h.getResources()
                });
                c.defaultMessage = h
            },
            render: function () {
                b.prototype.render.apply(this, arguments);
                this.unrenderLoading();
                this.unrenderError();
                this.$el.find('*[name="email_message"]').val(this.defaultMessage);
                this.toggleNotYouLink();
                this.setValidator();
                this.$el.show()
            },
            submitForm: function (a) {
                a = h(a);
                var b = {
                    channel: "EMAIL"
                };
                b.recipients = a.find('textarea[name="emails"]').val().split(" ");
                b.channel_email = a.find('*[name="email"]').val();
                b.channel_message = a.find('*[name="email_message"]').val();
                if (0 >= b.recipients.length || !b.channel_email || !b.channel_message) return !1;
                this.sendShareServiceRequest(b, function (a) {})
            },
            hideNotYouButtonIfAutoReg: function () {
                this.widget.user.isAutoReg() && this.$el.find(s.getName(".email-not-you-button")).hide()
            },
            getPurl: function (a) {
                return b.prototype.getPurl.call(this) +
                    "/" + a
            }
        })
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/share-widgets/EmailShareWidget", "jquery Underscore widget-common/utils/css-utils Liquid jsuri advocate-widget/share-widgets/ShareWidget advocate-widget/utils/cs-utils advocate-widget/utils/email-utils".split(" "), x);
    "undefined" != typeof n && (n.EmailShareWidget = x(n.$, n._, n.cssUtils, n.Liquid, n.Uri, n.ShareWidget, n.csUtils, n.emailUtils));
    x = function (h, n, s, q, c, b, a, d, e) {
        return a.extend({
            shareEventType: "facebook",
            fbDebugMode: !1,
            title: "Share on Facebook",
            events: {
                "mouseover iframe": "iframeHoverState",
                "mouseout iframe": "iframeHoverState",
                "keyup .fb-share-state_id_ textarea": "validateMessage",
                "blur .fb-share-state_id_ textarea": "validateMessage",
                "focus .fb-share-state_id_ textarea": "validateMessage",
                "submit .fb-share-state_id_ form": "validateMessage",
                "submit .fb-post-share-state_id_ form": "postShareSubmitHandler"
            },
            saveFbUser: function (a) {
                this.fbUser = a
            },
            shareSubmit: function () {
                var a = this.$el.find("." + c.getName("fb-share-state")).find("form");
                this.fbData = {
                    user: this.fbUser,
                    message: a.find('*[name="fb_message"]').val()
                };
                this.renderPostShare()
            },
            postShareSubmitHandler: function (a) {
                a.preventDefault();
                a = h(a.target).find('input[name="email"]');
                this.sendShare(a.val())
            },
            shareValidate: function () {
                this.$el.find("." + c.getName("fb-share-state")).find("form").submit()
            },
            validateMessage: function (a) {
                a && a.preventDefault();
                "" != this.$el.find("." + c.getName("fb-share-state")).find("textarea").val() ? this.sendMessage("shareState:change", !0) : this.sendMessage("shareState:change", !1)
            },
            validateRules: {
                fb_message: "required",
                email: {
                    email: !0,
                    required: !0
                }
            },
            initialize: function () {
                a.prototype.initialize.apply(this, arguments);
                var b = this;
                b.appId = b.options.appId;
                if (!b.appId) return alert("App Id Required"), !1;
                b.ns = b.cid;
                b.defaultMessage = "";
                b.timeout = setTimeout(function () {
                    b.renderError("Facebook is having some issues. Try again later.")
                }, 5E3);
                b.on("fb:loaded", function () {
                    clearTimeout(b.timeout);
                    b.validateMessage();
                    if (!0 == b.fbLoaded) return !1;
                    b.fbLoaded = !0;
                    b.render()
                }, b);
                b.on("fb:error", b.renderFacebookError,
                    b);
                b.on("fb:user", b.saveFbUser, b);
                b.on("fb:user", b.shareSubmit, b);
                b.on("createObject:complete", b.createObjectComplete, b);
                b.on("share:submit", b.shareValidate, b);
                b.on("sendShare:complete", b.sendShareComplete, b);
                b.addMessageListener()
            },
            addMessageListener: function () {
                var a = this;
                h(window).on("message." + a.cid, function (b) {
                    b = b.originalEvent.data;
                    var c = b.split("-"),
                        d = c[0],
                        e = c[1],
                        c = c[2];
                    if (d != a.ns) return !1;
                    if (c) try {
                        c = n.parse(b.substring(d.length + 1 + e.length + 1))
                    } catch (h) {}
                    a.trigger(e, c)
                })
            },
            sendMessage: function (a,
                b) {
                var c;
                c = this.ns + "-" + a;
                b && (c += "-" + n.stringify(b));
                this.iframe[0].contentWindow.postMessage(c, "*")
            },
            createIframe: function () {
                var a = this.widget,
                    b = this.$el.find("." + c.getName("iframe-container")),
                    a = (new s("//" + a.program.program_url)).setPath("/facebook").addQueryParam("mediaServer", this.options.MEDIA_SERVER).addQueryParam("fbAppId", this.appId).addQueryParam("fbDebugMode", this.fbDebugMode).addQueryParam("ns", this.ns);
                b.find("iframe").remove();
                this.iframe = h('<iframe scrolling="no" frameborder="0" allowTransparency="true" seamless="seamless" src="' +
                    a.toString() + '">Loading...</iframe>').appendTo(b)
            },
            iframeHoverState: function () {
                this.$el.find("." + c.getName("iframe-container")).find("button").toggleClass(c.getName("hover"))
            },
            getUri: function (a) {
                a = new s(this.shareRoot + "/share/object/" + a);
                a.setProtocol("http");
                return a.toString()
            },
            render: function () {
                a.prototype.render.apply(this, arguments);
                var d = this,
                    e = b.resolveTemplateVars(h.extend({}, d.options.facebookCreative.template_vars), d.widget.getTemplateVarContext()),
                    m = d.$el.find("." + c.getName("fb-loading-state")),
                    n = d.$el.find("." + c.getName("fb-share-state")),
                    q = d.$el.find("." + c.getName("fb-post-share-state"));
                d.unrenderLoading();
                d.unrenderError();
                void 0 === d.iframe && d.createIframe();
                m.hide();
                n.hide();
                q.hide();
                if (!d.fbLoaded) return m.show(), !1;
                h.each({
                    "fb-title": "og_title",
                    "fb-description": "og_description",
                    "fb-image": "og_image"
                }, function (a, b) {
                    var m = d.$el.find("#" + c.getName(a)),
                        n = e[b] || "";
                    "og_image" == b ? n && m.html("").append(h("<img>").attr("src", n)) : ("og_description" == b && (n = n.substring(0, 160)), m.html(n))
                });
                n.show();
                n.find("form").validate(d.getValidateRules({
                    rules: d.validateRules
                }))
            },
            renderPostShare: function () {
                var a = this.widget,
                    b = this.$el.find("." + c.getName("fb-share-state")),
                    d = this.$el.find("." + c.getName("fb-post-share-state")),
                    e = this.fbData;
                b.hide();
                d.find('input[name="email"]').val(e.user.email);
                d.show();
                d.find("form").validate(this.getValidateRules({
                    rules: this.validateRules
                }));
                if (a.user.get("email")) return this.sendShare(), !1
            },
            renderFacebookError: function (a) {
                this.renderError(a.error.message)
            },
            sendShare: function (a) {
                var b =
                    this,
                    c = b.widget,
                    d = b.fbData;
                a = {
                    channel: "FACEBOOK",
                    channel_first_name: d.user.first_name,
                    channel_last_name: d.user.last_name,
                    channel_email: a,
                    channel_message: d.message,
                    resources: c.getResources()
                };
                try {
                    a.resources.creative_id = c.campaign.creatives.friend_cta_facebook.id
                } catch (e) {
                    return R("Facebook issue, no creative id: " + e.message), b.renderError("I'm sorry, something went wrong."), !1
                }
                b.renderLoading();
                if (!d.message) return b.renderError("Message is required."), !1;
                var h = b.options.namespace,
                    n = b.options.actionTypeName,
                    q = b.options.objectTypeName,
                    s = {
                        "fb:explicitly_shared": !0
                    };
                b.sendShareServiceRequest(a, function (a) {
                    b.bustCache(a.product_id);
                    b.renderLoading();
                    b.product_id = a.product_id;
                    s.message = d.message;
                    s.ref = b.getShareId() + "-" + a.product_id;
                    s[q] = b.getUri(a.product_id);
                    b.sendMessage("sendShare", {
                        path: "/me/" + h + ":" + n,
                        method: "post",
                        data: s
                    })
                })
            },
            bustCache: function (a) {
                a && a.product_id ? (a = this.getUri(a.product_id), h.get("http://developers.facebook.com/tools/debug/og/object?q=" + encodeURI(a), function (a) {
                    e.log("** FacebookShareWidget/bustCache **",
                        "Response from facebook - ", a)
                })) : e.log("** FacebookShareWidget/bustCache **", "No product_id in passed data", a)
            },
            sendShareComplete: function (a) {
                var b = a.error;
                this.unrenderLoading();
                if (b) return this.renderError(b.message), !1;
                this.sendConfirmation(a.id)
            },
            sendConfirmation: function (a) {
                h.ajax(this.shareRoot + "/confirm", {
                    type: "post",
                    dataType: "json",
                    contentType: "application/json",
                    processData: !1,
                    xhrFields: {
                        withCredentials: !0
                    },
                    data: n.stringify({
                        action_id: this.getShareId(),
                        confirmation_code: a
                    })
                })
            },
            destroy: function () {
                this.iframe &&
                    this.iframe.remove();
                a.prototype.destroy.apply(this, arguments)
            }
        })
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/share-widgets/FacebookShareWidget", "jquery JSON jsuri Liquid widget-common/utils/css-utils widget-common/utils/template-utils advocate-widget/share-widgets/ShareWidget advocate-widget/utils/fb-utils widget-common/min-utils/base".split(" "), x);
    "undefined" != typeof n && (n.FacebookShareWidget = x(n.$, n.JSON, n.Uri, n.Liquid, n.cssUtils, n.templateUtils, n.ShareWidget, n.fbUtils, n.minUtils));
    x = function (h, n, s, q, c) {
        return q.extend({
            shareEventType: "twitter",
            maxLength: 116,
            events: {
                "keyup .tw-share-state_id_ form textarea": "limitCharactersHandler",
                "blur .tw-share-state_id_ form textarea": "limitCharactersHandler",
                "paste .tw-share-state_id_ form textarea": "limitCharactersHandler",
                "submit .tw-share-state_id_ form": "shareSubmitHandler",
                "submit .tw-post-share-state_id_ form": "postShareSubmitHandler"
            },
            limitCharactersHandler: function (b) {
                b = this.$el.find('textarea[name="tw_message"]');
                b.val().length >
                    this.maxLength && b.val(b.val().substring(0, this.maxLength));
                this.setRemainingCharacters()
            },
            shareSubmitHandler: function (b) {
                b.preventDefault();
                var a = this,
                    d = h(b.target).find('*[name="tw_message"]');
                c.twitter.auth(a.consumerKey, function (b) {
                    R("res", b);
                    if (b.errors) a.renderError(String(b.errors).replace(/\+/g, " "));
                    else {
                        a.accessToken = b.access_token;
                        var c = decodeURIComponent(String(b.name).replace(/\+/g, " "));
                        b = decodeURIComponent(String(b.nickname).replace(/\+/g, " "));
                        a.twData = {
                            channel_first_name: c == b ? null : c,
                            channel_last_name: null,
                            channel_message: d.val()
                        };
                        a.renderPostShare()
                    }
                })
            },
            postShareSubmitHandler: function (b) {
                b.preventDefault();
                b = h(b.target).find('input[name="email"]');
                this.sendShare(b.val())
            },
            validateRules: {
                tw_message: "required",
                email: {
                    email: !0,
                    required: !0
                }
            },
            initialize: function () {
                q.prototype.initialize.apply(this, arguments);
                (this.consumerKey = this.options.consumerKey) || alert("Twitter need a consumer key");
                var b = this.widget;
                this.defaultMessage = n.parse(b.advocateWidgetCreative.template_vars.twitter_message ||
                    this.$el.find('*[name="tw_message"]').val()).render(b.getTemplateContext());
                this.render()
            },
            render: function () {
                q.prototype.render.apply(this, arguments);
                var b = this.$el.find("." + s.getName("tw-loading-state")),
                    a = this.$el.find("." + s.getName("tw-share-state")),
                    c = this.$el.find("." + s.getName("tw-post-share-state"));
                this.unrenderLoading();
                this.unrenderError();
                this.$el.find('*[name="tw_message"]').val(this.defaultMessage);
                b.hide();
                a.show();
                c.hide();
                a.find("form").validate(this.getValidateRules({
                    rules: this.validateRules
                }));
                this.setRemainingCharacters()
            },
            setRemainingCharacters: function () {
                var b = this.$el.find('textarea[name="tw_message"]'),
                    a = this.$el.find("." + s.getName("input-suffix")),
                    b = this.maxLength - b.val().length;
                a.html("Remaining characters: " + b)
            },
            renderPostShare: function () {
                var b = this.widget,
                    a = this.$el.find("." + s.getName("tw-loading-state")),
                    c = this.$el.find("." + s.getName("tw-share-state")),
                    e = this.$el.find("." + s.getName("tw-post-share-state"));
                this.unrenderLoading();
                this.unrenderError();
                if (b.user.get("email")) return this.sendShare(), !1;
                a.hide();
                c.hide();
                e.show();
                e.find('input[name="email"]').val("");
                e.find("form").validate(this.getValidateRules({
                    rules: this.validateRules
                }))
            },
            getUri: function () {
                return this.getPurl()
            },
            sendShare: function (b) {
                var a = this,
                    d = h.extend({
                        channel: "TWITTER",
                        channel_first_name: "hi",
                        channel_last_name: "hi",
                        channel_email: b || ""
                    }, a.twData);
                a.renderLoading();
                if (d.channel_message.length > a.maxLength) return a.renderError("Message can't be longer than " + a.maxLength + " characters"), !1;
                var e = !1;
                h.each(["channel_first_name",
                    "channel_last_name", "channel_message"
                ], function (b, c) {
                    void 0 === a.twData[c] && (e = !0)
                });
                if (e || !a.accessToken) return a.render(), !1;
                a.sendShareServiceRequest(d, function (b) {
                    b = a.getUri();
                    b = h.trim(d.channel_message) + " " + b;
                    c.twitter.tweet_authed(b, a.accessToken, a.consumerKey, function (b) {
                        R("response", b);
                        b.errors && a.renderError(b.errors)
                    })
                })
            }
        })
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/share-widgets/TwitterShareWidget", ["jquery", "Liquid", "widget-common/utils/css-utils", "advocate-widget/share-widgets/ShareWidget",
        "graffiti"
    ], x);
    "undefined" != typeof n && (n.TwitterShareWidget = x(n.$, n.Liquid, n.cssUtils, n.ShareWidget, n.graffiti));
    x = function (h, n, s, q, c) {
        window.extole = window.extole || {};
        return q.extend({
            shareEventType: "purl",
            usingClipboard: !1,
            events: {
                "click .submit-button_id_": "copyTextHandler",
                "click .input_id_": "copyTextHandler"
            },
            failedShares: 0,
            maxFailedShares: 3,
            fetchShareId: function () {
                var b = this;
                h.ajax({
                    url: b.shareRoot + "/preshare/" + b.widget.campaign.id,
                    dataType: "json",
                    contentType: "application/json",
                    xhrFields: {
                        withCredentials: !0
                    },
                    cache: !1,
                    timeout: 3E3,
                    success: function (a) {
                        b.setShareId(a.id);
                        b.idHash = a.id_hash;
                        b.trigger("fetchShareId:success")
                    },
                    error: function () {
                        b.trigger("fetchShareId:failed")
                    }
                })
            },
            getPurlInput: function () {
                return this.$el.find("." + s.getName("purl-text"))
            },
            getPurlInputData: function () {
                return this.getPurlInput().text()
            },
            setPurlInputData: function (b) {
                this.getPurlInput().text(b)
            },
            copyTextHandler: function (b) {
                b.preventDefault();
                b = h(b.target);
                var a = this.getPurlInput(),
                    c = this.getPurlInputData();
                try {
                    this.usingClipboard &&
                        window.clipboardData && !0 == window.clipboardData.setData("Text", c) && this.renderCopied()
                } catch (e) {
                    R("Problem with setting clip data - " + e.message)
                }(b.is("." + s.getName("input")) || b.is(a)) && a.select();
                this.submitPurl()
            },
            submitPurl: function () {
                var b = this;
                b.$el.find("." + s.getName("no-link-state")).find("form");
                var a = {
                    channel: "PURL",
                    action_id: b.getShareId(),
                    id_hash: b.idHash
                };
                if (b.hasShared) return !1;
                b.hasShared = !0;
                b.sendShareServiceRequest(a, {
                    showLoading: !1
                }, function () {
                    b.canRender = !0
                })
            },
            initialize: function () {
                q.prototype.initialize.apply(this,
                    arguments);
                var b = this,
                    a = b.widget;
                a.on("rendered", b.render, b);
                b.on("shared", b.render, b);
                b.listenTo(a.user, "change", b.render);
                b.on("fetchShareId:failed", function () {
                    b.failedShares < b.maxFailedShares && setTimeout(function () {
                        b.fetchShareId()
                    }, 1E3);
                    b.failedShares++
                });
                b.on("fetchShareId:success", b.render, b);
                a = function (a) {
                    return function () {
                        b.triggerExtoleEvent(a)
                    }
                };
                b.on("fetchShareId:success", a("preshare:success"));
                b.on("fetchShareId:failed", a("preshare:fail"))
            },
            setButtonZIndex: function () {
                var b = this.widget.getBaseZIndices();
                this.$el.find("." + s.getName("submit-button")).css("zIndex", b.widget + 2)
            },
            loadZClip: function () {
                var b = this,
                    a = b.MEDIA_SERVER + "/advocate-widget/" + b.WIDGET_VERSION + "/ZeroClipboard.swf",
                    d = b.$el.find("." + s.getName("submit-button"));
                b.$button = d;
                window.ZeroClipboard = c;
                c.purlShareWidgets || (c.purlShareWidgets = []);
                var e = setInterval(function () {
                    if (!0 === window.extole.zClipLoaded) {
                        clearInterval(e);
                        R("zero ready");
                        var a = new c;
                        a.glue(d[0]);
                        c.purlShareWidgets.push(b);
                        b.clipEventMap = {
                            complete: function (a, b) {
                                for (var d =
                                    c.purlShareWidgets, e = 0; e < d.length; ++e) {
                                    var f = d[e];
                                    f.$button[0] === this && f.$button.trigger("click")
                                }
                            },
                            datarequested: function () {
                                for (var b = c.purlShareWidgets, d = 0; d < b.length; ++d) {
                                    var e = b[d];
                                    e.$button[0] === this && (a.setText(e.getPurlInputData()), e.renderCopied(), e.$button.trigger("click"))
                                }
                            }
                        };
                        h.each(b.clipEventMap, function (b, c) {
                            a.on(b, c)
                        });
                        b.clip = a
                    }
                }, 250);
                try {
                    var a = '(function () {  var clip = new ZeroClipboard(null, {moviePath: "' + a + '", allowScriptAccess: "always", trustedDomains: "*"}); clip.on("load", function () { window.extole.zClipLoaded = true;} ); }())',
                        f = document.createElement("script");
                    f.innerHTML = a;
                    document.getElementsByTagName("head")[0].appendChild(f)
                } catch (n) {
                    R("A problem with the weird z clip loading deal happened. " + n.message), c.detectFlashSupport = function () {
                        return !1
                    }, b.renderLink()
                }
                b.zClipLoaded = !0
            },
            render: function () {
                q.prototype.render.apply(this, arguments);
                this.unrenderLoading();
                this.unrenderError();
                this.$el.hide();
                this.widget.user.get("email") && this.getShareId() ? (this.$el.show(), this.renderLink()) : this.widget.user.get("email") && !this.getShareId() &&
                    this.fetchShareId()
            },
            renderLink: function () {
                var b = this.getPurlInput();
                this.setPurlInputData(this.getPurl());
                c.detectFlashSupport() ? (this.setButtonZIndex(), this.zClipLoaded || this.loadZClip()) : window.clipboardData ? this.usingClipboard = !0 : b.closest("form").addClass(s.getName("no-copy"))
            },
            renderCopied: function () {
                var b = this.$el.find("#" + s.getName("purl-submit-button")),
                    a = this.$el.find("#" + s.getName("purl_copied_text")).html();
                b.html() == a && b.css({
                    opacity: 0
                }).animate({
                    opacity: 1
                }, 250);
                b.html(a)
            },
            destroy: function () {
                var b =
                    this.$el.find("." + s.getName("submit-button")),
                    a = this.clip;
                q.prototype.destroy.apply(this, arguments);
                a && (this.clipEventMap = this.clipEventMap || {}, h.each(this.clipEventMap, function (b, c) {
                    a.off(b, c)
                }), a.unglue(b[0]))
            }
        })
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/share-widgets/PurlShareWidget", ["jquery", "JSON", "widget-common/utils/css-utils", "advocate-widget/share-widgets/ShareWidget", "advocate-widget/zero-clip/ZeroClipboard"], x);
    "undefined" != typeof n && (n.PurlShareWidget = x(n.$, n.JSON,
        n.cssUtils, n.ShareWidget, n.ZeroClipboard));
    x = function (h, n, s, q, c, b, a, d, e, f, v) {
        return f.extend({
            shareEventType: !1,
            events: n.extend({}, e.emailEvents),
            initialize: function () {
                n.extend(this, e);
                f.prototype.initialize.apply(this, arguments)
            },
            render: function () {
                this.setValidator();
                this.toggleNotYouLink()
            },
            displayThanksMessage: function () {
                var a = this,
                    c = a.$(b.getName(".submit-button")),
                    d = c.html();
                c.text("Thanks!");
                c.attr("disabled", "disabled");
                setTimeout(function () {
                        c.html(d);
                        c.removeAttr("disabled");
                        a.widget.renderPreviousWidget()
                    },
                    2E3)
            },
            displayErrorMessage: function () {
                this.validator.showErrors({
                    email: "Unable to send to: "
                })
            },
            submitForm: function (a) {
                var b = this,
                    c = b.widget,
                    d = c.user;
                d.has("email") || (a = h(a).find("input[name=email]").val(), d.setUserVariable("email", a));
                h.get(b.shareRoot + "/advdash/email/", {
                    email: d.get("email"),
                    client_id: c.client.client_id,
                    site_id: c.getSite().site_id
                }, function (a, c, d) {
                    "string" === typeof a && (a = s.parse(a));
                    "success" === c && a.success ? b.displayThanksMessage() : b.displayErrorMessage()
                });
                return !1
            }
        })
    };
    "undefined" !==
        typeof define && define.amd && define("advocate-widget/share-widgets/DashboardEmailWidget", "jquery Underscore JSON Liquid Backbone widget-common/utils/css-utils advocate-widget/utils/call-utils advocate-widget/utils/config-utils advocate-widget/utils/email-utils advocate-widget/share-widgets/ShareWidget widget-common/BackboneWidget".split(" "), x);
    "undefined" != typeof n && (n.DashboardEmailWidget = x(n.$, n._, n.JSON, n.Liquid, n.Backbone, n.cssUtils, n.callUtils, n.configUtils, n.emailUtils, n.ShareWidget, n.BackboneWidget));
    x = function (h, n, s, q, c, b) {
        return {
            EmailShareWidget: n,
            FacebookShareWidget: s,
            TwitterShareWidget: q,
            PurlShareWidget: c,
            DashboardEmailWidget: b
        }
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/share-widgets", "advocate-widget/share-widgets/ShareWidget advocate-widget/share-widgets/EmailShareWidget advocate-widget/share-widgets/FacebookShareWidget advocate-widget/share-widgets/TwitterShareWidget advocate-widget/share-widgets/PurlShareWidget advocate-widget/share-widgets/DashboardEmailWidget".split(" "),
        x);
    "undefined" != typeof n && (n.shareWidgets = x(n.ShareWidget, n.EmailShareWidget, n.FacebookShareWidget, n.TwitterShareWidget, n.PurlShareWidget, n.DashboardEmailWidget));
    (function () {
        var h = function (h, n, q) {
            return n.extend({
                events: {
                    click: "openAdvocateWidget"
                },
                initialize: function () {
                    n.prototype.initialize.apply(this, arguments);
                    var c = this.options.clientConfig,
                        b = c.zoneName;
                    this.clientConfig = c;
                    this.zoneName = b;
                    this.widgetReady(h.proxy(this.initClicked, this))
                },
                initClicked: function () {
                    var c = this.el,
                        b = window.extole.clickedCtas[c.id];
                    c.onclick = function () {};
                    this.delegateEvents();
                    b && (window.extole.modal && h(window.extole.modal).remove(), h(b).trigger("click"))
                },
                setWidget: function (c) {
                    this.widget = c;
                    this.widgetReady()
                },
                widgetReadyCallbacks: [],
                widgetReady: function (c) {
                    c ? this.widgetReadyCallbacks.push(c) : this.widgetIsReady = !0;
                    if (this.widgetIsReady)
                        for (; c = this.widgetReadyCallbacks.pop();) c()
                },
                openAdvocateWidget: function (c) {
                    c.preventDefault();
                    c.stopPropagation();
                    var b = this,
                        a = arguments;
                    b.widgetReady(function () {
                        var c = b.widget;
                        c.openAdvocateWidget.apply(c,
                            a);
                        b.triggerExtoleEvent("click")
                    })
                },
                triggerExtoleEvent: function (c) {
                    var b = this;
                    b.widgetReady(function () {
                        b.widget.triggerExtoleEvent("cta:" + c)
                    })
                }
            })
        };
        "undefined" != typeof define && define.amd && define("advocate-widget/ctas/BaseCta", ["jquery", "widget-common/BackboneWidget", "advocate-widget/events"], h);
        "undefined" != typeof n && (n.BaseCta = h(n.$, n.BackboneWidget, n.events))
    })();
    (function () {
        var h = function (h, n, q, c, b) {
            return n.extend({
                hoverDelay: 300,
                events: h.extend({}, n.prototype.events, {
                    "click .close-button_id_": "close",
                    "mouseover .close-button_id_": function (a) {
                        a.stopPropagation()
                    },
                    "mouseout .close-button_id_": function (a) {
                        a.stopPropagation()
                    },
                    mouseover: "hoverTickle",
                    mouseout: "unhoverTickle"
                }),
                lastTickleDateKey: "xtl_cta_tickle_shown",
                allStates: ["min", "standard", "tickle"],
                initialize: function () {
                    n.prototype.initialize.apply(this, arguments);
                    var a = (this.creative = this.el.creative).options;
                    this.tickleDelay = a.tickle_delay_time;
                    var b = this.tickleWaitTime = a.tickle_wait_time;
                    this.tickleShowTime = a.tickle_show_time;
                    this.showCountdown = !0;
                    this.impressionEventsTriggered = {
                        standard: 1
                    };
                    this.state = "standard";
                    this.on("changeState", this.render, this);
                    this.on("changeState:tickle", this.setTickleShown, this);
                    if (this.lastTickleDateCookie = h.cookie(this.lastTickleDateKey)) try {
                        var e = new Date;
                        e.setTime(this.lastTickleDateCookie);
                        this.lastTickleDate = e;
                        if (isNaN(this.lastTickleDate.getTime())) throw Error("Bad Date");
                        this.lastTickleDate = this.lastTickleDate && this.lastTickleDate.getTime() / 1E3
                    } catch (f) {
                        c.log("-- Tickle shown cookie has bad date. Deleting--"),
                        h.cookie(this.tickleShownCookie, null, {
                            path: "/"
                        })
                    }
                    this.startDate = (new Date).getTime() / 1E3;
                    a = this.startDate - this.lastTickleDate;
                    (!this.lastTickleDate || a > b) && this.setTickle();
                    this.render()
                },
                hoverTickle: function (a) {
                    clearTimeout(this.hoverTickleTimeout);
                    "standard" == this.state && (this.hoverTickleTimeout = setTimeout(h.proxy(this.popTickle, this), this.hoverDelay))
                },
                unhoverTickle: function (a) {
                    clearTimeout(this.hoverTickleTimeout);
                    this.hoverTickleTimeout = setTimeout(h.proxy(this.disableTickle, this), this.hoverDelay)
                },
                popTickle: function (a) {
                    var b;
                    clearTimeout(this.hoverTickleTimeout);
                    !0 === this.showCountdown && (this.showCountdown = !1, b = !0);
                    this.unsetTickle();
                    "tickle" !== this.state ? this.changeState("tickle") : b && this.render()
                },
                unsetTickle: function () {
                    void(this.tickleTimeout && clearTimeout(this.tickleTimeout));
                    this.stopTickleCountdown()
                },
                setTickle: function () {
                    var a = this;
                    a.tickleTimeout = setTimeout(function () {
                        a.changeState("tickle")
                    }, 1E3 * a.tickleDelay)
                },
                setTickleShown: function () {
                    h.cookie(this.lastTickleDateKey, String((new Date).getTime()), {
                        expires: 365,
                        path: "/"
                    })
                },
                disableTickle: function () {
                    clearTimeout(this.hoverTickleTimeout);
                    "tickle" == this.state && (this.unsetTickle(), this.changeState("standard"))
                },
                render: function () {
                    var a = this.$el.find("." + q.getName("cta-floater-" + this.state)),
                        b = this.$("." + q.getName("cta-floater")),
                        c = this.$("." + q.getName("close-button")),
                        f = q.getName("shown"),
                        n = q.getName(this.state);
                    this.impressionEventsTriggered[this.state] || (this.triggerExtoleEvent("impression:" + this.state), this.impressionEventsTriggered[this.state] =
                        1);
                    this.$("." + q.getName("cta-tickler-countdown")).hide();
                    this.$el.find("." + f).removeClass(f);
                    h.each(this.allStates, function (a, c) {
                        var e = q.getName(c);
                        b.removeClass(e)
                    });
                    b.addClass(n);
                    this.$el.css({
                        display: "block"
                    });
                    "min" == this.state ? c.hide() : c.show();
                    "tickle" == this.state && this.showCountdown && this.startTickleCountdown();
                    a.addClass(f)
                },
                startTickleCountdown: function () {
                    var a = this,
                        b = a.$("." + q.getName("cta-tickler-countdown")).show(),
                        c = a.tickleShowTime,
                        f = function () {
                            0 >= c ? (clearInterval(a.tickleInterval), a.disableTickle()) :
                                b.html(c + " sec");
                            c--
                        };
                    a.tickleInterval = setInterval(f, 1E3);
                    f()
                },
                stopTickleCountdown: function () {
                    void(this.tickleInterval && clearInterval(this.tickleInterval))
                },
                changeState: function (a) {
                    this.state = a;
                    this.trigger("changeState");
                    this.trigger("changeState:" + a)
                },
                close: function (a) {
                    a.preventDefault();
                    a.stopPropagation();
                    "min" != this.state && ("standard" == this.state ? this.changeState("min") : "tickle" == this.state && this.disableTickle())
                },
                openAdvocateWidget: function () {
                    this.disableTickle();
                    "min" == this.state && this.changeState("standard");
                    n.prototype.openAdvocateWidget.apply(this, arguments)
                }
            })
        };
        "undefined" != typeof define && define.amd && define("advocate-widget/ctas/FloaterCta", ["jquery", "advocate-widget/ctas/BaseCta", "widget-common/utils/css-utils", "widget-common/min-utils/base", "advocate-widget/events"], h);
        "undefined" != typeof n && (n.FloaterCta = h(n.$, n.BaseCta, n.cssUtils, n.minUtils, n.events))
    })();
    (function () {
        var h = function (h, n, q, c) {
            return c.extend({
                events: {},
                openAdvocateWidget: function () {
                    return !1
                }
            })
        };
        "undefined" != typeof define && define.amd &&
            define("advocate-widget/ctas/NoCta", ["jquery", "Underscore", "Backbone", "advocate-widget/ctas/BaseCta", "advocate-widget/events"], h);
        "undefined" != typeof n && (n.NoCta = h(n.$, n._, n.Backbone, n.BaseCta))
    })();
    x = function (h, n, s) {
        return {
            getCtaView: function (q, c) {
                var b = (q[0].creative || {}).options.type;
                return c.advocateWidgetCreative.options.embed ? s : "floater" == b ? n : h
            }
        }
    };
    "undefined" != typeof define && define.amd && define("advocate-widget/ctas", ["advocate-widget/ctas/BaseCta", "advocate-widget/ctas/FloaterCta", "advocate-widget/ctas/NoCta"],
        x);
    "undefined" != typeof n && (n.ctas = x(n.BaseCta, n.FloaterCta, n.NoCta));
    x = function (h, n) {
        return n.Model.extend({
            userVariableMap: {
                first_name: "f",
                last_name: "l",
                email: "e"
            },
            channelVariableMap: {
                first_name: "channel_first_name",
                last_name: "channel_last_name",
                email: "channel_email"
            },
            initialize: function () {},
            sync: function () {},
            logout: function () {
                this.trigger("logout")
            },
            setUserVariables: function (n) {
                var q = this;
                h.each(q.channelVariableMap, function (c, b) {
                    q.setUserVariable(c, n[b])
                })
            },
            setUserVariable: function (h, n) {
                if (!this.get("widget")) return alert("Must set widget attribute for AdvocateUserModel"), !1;
                var c = this.get("widget"),
                    b = this.userVariableMap,
                    a = n;
                if (this.has(h) && "" !== this.get(h)) return !1;
                (c = c.initVars[b[h]]) && (a = c);
                this.set(h, a)
            },
            isAutoReg: function () {
                var h = this.get("isAutoReg");
                return "undefined" !== typeof h && !0 == h
            }
        })
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/AdvocateUser", ["jquery", "Backbone"], x);
    "undefined" != typeof n && (n.AdvocateUser = x(n.$, n.Backbone));
    x = function (h, n, s, q, c) {
        return q.extend({
            events: {
                "click .button_id_": "buttonClickHandler"
            },
            buttonClickHandler: function (b) {
                b.preventDefault();
                this.$menu.toggle()
            },
            initialize: function () {
                var b = this.options,
                    a = b.widget;
                this.widget = a;
                this.template = b.template;
                this.widgetConfig = b.widgetConfig;
                if (!a) return alert("MenuView needs reference to widget!"), !1;
                this.template = s.parse(this.template);
                this.$el.html(this.template.render());
                this.$menu = this.$el.find("." + c.getName("menu"));
                this.$menu.hide();
                this.render()
            },
            render: function () {}
        })
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/AdvocateWidgetMenu", ["jquery", "Backbone", "Liquid", "widget-common/BackboneWidget",
        "widget-common/utils/css-utils"
    ], x);
    "undefined" != typeof n && (n.AdvocateWidgetMenu = x(n.$, n.Backbone, n.Liquid, n.BackboneWidget, n.cssUtils));
    x = function (h, n, s, q, c, b, a, d, e, f, v, m, r, u, x, C, R, U) {
        var ea = {
            showImmediately: !1,
            placeHolderContainsButton: !0,
            hasFooter: !0
        };
        return v.extend({
            events: {
                "click >.close-button_id_": "toggle",
                click: "recordMousePosition",
                keyup: "catchEnterEvents",
                keydown: "catchEnterEvents",
                "click .share-button_id_": "shareWidgetClickHandler",
                "click .not-you-button_id_": "logoutHandler",
                "click .toggle-button_id_": "toggleButtonHandler",
                "click #check-dashboard_id_": "dashboardEmailHandler"
            },
            recordMousePosition: function (a) {
                this.mouse = {
                    x: a.pageX,
                    y: a.pageY
                }
            },
            logoutHandler: function (a) {
                a.preventDefault();
                this.user.logout()
            },
            shareWidgetClickHandler: function (b) {
                b.preventDefault();
                b = h(b.target);
                b.data("shareWidgetKey") || (b = b.closest("." + a.getName("share-button")));
                b = b.data("shareWidgetKey");
                var c = this.shareWidgets[b];
                b && c && this.renderWidget(c)
            },
            dashboardEmailHandler: function (a) {
                a.preventDefault();
                this.renderWidget(this.shareWidgets.dashboardEmail)
            },
            initialize: function () {
                var a = this,
                    c = a.options;
                if (c.setupComplete) a.once("setup:complete", c.setupComplete);
                a.on("campaignConfig:error zone:error program:error setCreatives:error", function () {
                    a.trigger("setup:complete")
                });
                a.on("shareWidget:select", function (a) {
                    a && a.render()
                });
                b.log.debug("** AdvocateWidget/initialize ** Widget initialization");
                c.sharedVars = c.sharedVars || {};
                m.setMediaServer(c.MEDIA_SERVER);
                if (0 >= c.placeHolder.length) return b.log.error("Button not set, widget will never fire."), !1;
                var d =
                    h(c.placeHolder),
                    e = {};
                d[0].zone && (e = h.extend(!0, {
                    zone: d[0].zone.name
                }, d[0].zone.data));
                a.placeHolderOptions = h.extend(!0, {}, c.sharedVars, c.placeHolderOptions, e);
                (e = (a.ctaZone = d[0].zone || {}).cta) ? (b.log("CTA has been created by complete-core, using it!"), a.placeHolder = h(e)) : (b.log.warn("So this isn't a normal placeholder, which means it's coming from initWidget with", "the options passed directly.", "In this case, the placeholder is not a button...or it shouldn't be."), d[0].zone || b.log.warn("-- The placeholder has no zone"),
                    a.placeHolder = h(c.placeHolder));
                a.widgetConfig = c.widgetConfig;
                a.main = c.main;
                a.HTML_ASSEMBLER_ROOT = c.HTML_ASSEMBLER_ROOT;
                a.clientConfig = c.clientConfig;
                a.user = c.user;
                a.setInitVars();
                a.visibleWidget = void 0;
                a.on("config:loaded", a.setup, a);
                a.fetchConfig(function (c) {
                    if (!c) return b.log("No campaign found. Stopping."), a.trigger("campaignConfig:error"), !1;
                    a.campaignConfig = c;
                    a.clientId = a.clientConfig.client.client_id;
                    a.campaignId = c.campaign.id;
                    a.zoneName = a.placeHolderOptions.zone;
                    a.advocateWidgetId = "extole-advocate-widget-" +
                        a.campaignId;
                    a.setConfigs();
                    if (!a.zone) return b.log("You have attempted to init a widget without a zone."), b.log("Check the zoneName (" + a.zoneName + ") that this was given"), b.log("The available zones in the client config are: " + n.keys(a.clientConfig.zones).join(", ")), a.trigger("zone:error"), !1;
                    a.setCreatives(function () {
                        a.program = m.getProgram(a.client);
                        if (!a.program) return b.log("No program was set."), a.trigger("program:error"), !1;
                        a.insertTemplateVariables();
                        a.trigger("config:loaded")
                    })
                })
            },
            setupCalls: function () {
                var a =
                    this.user,
                    b = this.initVars;
                this.clickCall = new C.ClickCall(this.campaignId, {
                    programUrl: this.program.program_url,
                    site: this.getSite(),
                    program: this.program,
                    data: {
                        zone_name: this.zoneName,
                        first_name: a.get("first_name"),
                        last_name: a.get("last_name"),
                        email: a.get("email"),
                        source: b.source,
                        client_params: this.clientParams
                    }
                })
            },
            getSite: function () {
                return m.getSite(this.clientConfig.client)
            },
            setInitVars: function () {
                var a = m.getInitParams(this.placeHolderOptions.params);
                this.params = a;
                this.initVars = a.init;
                this.clientParams =
                    a.client;
                this.displayOptions = h.extend({}, ea, this.initVars)
            },
            setConfigs: function () {
                var a = this.campaignConfig,
                    b = this.clientConfig;
                this.client = b.client;
                this.campaign = a.campaign;
                this.zone = b.zones[this.zoneName]
            },
            setCreatives: function (c) {
                var d = this,
                    n = m.getMediaServer() + "/base-creatives/" + d.options.baseCreativesVersion;
                f.ready([n + "/advocate-widget-creatives-combined.json"], function (f) {
                    var n = L.parse(f || "{}");
                    f = n["advocate-widget-creatives"];
                    var q = n["friend-cta-facebook-creatives"],
                        r = n["widget-common-creatives"],
                        n = n["call-to-action-creatives"];
                    if (!f) return b.log("Problem getting creatives. Stopping."), d.trigger("setCreatives:error"), !1;
                    b.log("......Get base creatives");
                    campaign = d.campaign;
                    var s = {};
                    campaign.creatives.advocate_widget && (campaign.creatives.advocate_widget.options && campaign.creatives.advocate_widget.options.type) && (s.options = {
                        type: campaign.creatives.advocate_widget.options.type
                    });
                    d.widgetCommonCreative = m.selectCreative(r, s);
                    d.advocateWidgetCreative = m.selectCreative(f, campaign.creatives.advocate_widget || {});
                    d.callToActionCreative = m.selectCreative(n, campaign.creatives.call_to_action || {});
                    d.friendCtaFacebookCreative = m.selectCreative(q, campaign.creatives.friend_cta_facebook || {});
                    h.extend(d.advocateWidgetCreative.templates, d.widgetCommonCreative.templates);
                    h.each([d.advocateWidgetCreative, d.callToActionCreative, d.friendCtaFacebookCreative], function () {
                        e.sanitizeTemplates(this.templates);
                        e.sanitizeTemplates(this.template_vars)
                    });
                    a.injectCss(d.widgetCommonCreative.css);
                    a.injectCss(d.advocateWidgetCreative.css);
                    a.injectCss(d.callToActionCreative.css);
                    b.log("......injected css");
                    c()
                })
            },
            insertCss: function () {
                this.advocateWidgetCreative.css = this.advocateWidgetCreative.css.replace(/__advocateWidget_id__/g, this.advocateWidgetId);
                a.injectCss(this.advocateWidgetCreative.css)
            },
            insertTemplateVariables: function () {
                var a = this;
                h.each([a.advocateWidgetCreative, a.callToActionCreative], function () {
                    e.resolveTemplateVars(this.template_vars, a.getTemplateVarContext())
                })
            },
            getTemplateVarContext: function () {
                return {
                    share: {
                        resources: this.getResources()
                    },
                    program: this.program,
                    campaign_id: this.campaignId,
                    creatives_path: this.options.MEDIA_SERVER + "/base-creatives/" + this.options.baseCreativesVersion
                }
            },
            getTemplateContext: function () {
                var a = !1;
                "undefined" !== typeof this.campaign.incentives && n.each(this.campaign.incentives, function (b) {
                    void 0 != b.brand && 1 < b.brand.length && (a = !0)
                });
                return h.extend({
                    MEDIA_SERVER: this.options.MEDIA_SERVER,
                    WIDGET_VERSION: this.options.WIDGET_VERSION,
                    BASE_CREATIVES_VERSION: this.options.baseCreativesVersion,
                    creatives_path: this.options.MEDIA_SERVER +
                        "/base-creatives/" + this.options.baseCreativesVersion,
                    has_powered_by_logo: this.advocateWidgetCreative.options.has_powered_by_logo,
                    has_footer: this.displayOptions.hasFooter,
                    has_reward_disclaimer: a,
                    show_reward_disclaimers: this.advocateWidgetCreative.options.show_reward_disclaimers
                }, this.advocateWidgetCreative.template_vars)
            },
            initEl: function () {
                var b = h("<div>").addClass(a.getName("extole")).appendTo(document.body),
                    d = c.parse(this.advocateWidgetCreative.templates.advocate_widget);
                this.$el = h(d.render(this.getTemplateContext())).hide();
                this.displayOptions.placeHolderContainsButton ? this.$el.appendTo(b) : (this.placeHolder.html("").append(this.$el).show().addClass(a.getName("extole")), this.$el.addClass(a.getName("embedded")).show());
                8 === h.msieVersion() && this.$el.addClass(a.getName("ie8"));
                this.$el.attr("id", this.advocateWidgetId);
                this.placeHolder.attr("id", this.placeHolderId);
                this.delegateEvents()
            },
            catchEnterEvents: function (a) {
                13 == a.keyCode && (a.stopPropagation(), a.preventDefault())
            },
            initUser: function () {
                var a = this.initVars,
                    b;
                try {
                    b = L.parse(h.cookie("xtl_fle"))
                } catch (c) {
                    b = {}
                }
                this.user.get("isAutoReg") || ("string" === typeof a.e ? this.user.set("isAutoReg", !0) : this.user.set("isAutoReg", !1));
                a = a.e && a.e != b.e ? h.extend({}, a) : h.extend({}, b, a);
                this.user.set("first_name", a.f);
                this.user.set("last_name", a.l);
                this.user.set("email", a.e);
                this.user.set("widget", this);
                this.listenTo(this.user, "change", this.renderAccountBar, this);
                this.listenTo(this.user, "change", this.setFleCookie, this);
                this.setFleCookie();
                this.listenTo(this.user, "logout", this.logout);
                this.renderAccountBar()
            },
            renderAccountBar: function () {
                var b =
                    this.$el.find("." + a.getName("footer")),
                    c = this.$el.find("." + a.getName("account"));
                b.removeClass(a.getName("has-account"));
                this.user.get("email") ? (c.find("." + a.getName("account-id")).html(this.user.get("email")), this.user.isAutoReg() && c.find(a.getName(".not-you-button")).remove(), c.show(), b.addClass(a.getName("has-account"))) : c.hide()
            },
            setFleCookie: function () {
                var a = {
                    f: this.user.get("first_name"),
                    l: this.user.get("last_name"),
                    e: this.user.get("email")
                };
                h.cookie("xtl_fle", L.stringify(a), {
                    expires: 365,
                    path: "/"
                })
            },
            setup: function () {
                var a = this;
                a.advocateWidgetCreative.options.embed && (a.displayOptions.showImmediately = !0, a.displayOptions.placeHolderContainsButton = !1);
                a.setupCalls();
                a.initEl();
                a.initUser();
                a.setupShareWidgets();
                a.setupLinks();
                a.insertCss();
                a.menu = new u({
                    widget: a,
                    template: a.advocateWidgetCreative.templates.advocate_widget_menu
                });
                a.user.on("change", function () {
                    a.renderWidget(a.visibleWidget)
                }, a);
                (a.displayOptions.placeHolderContainsButton || a.advocateWidgetCreative.options.embed && a.ctaZone.cta) && a.setupButton();
                a.displayOptions.showImmediately && a.render();
                b.log.debug("** AdvocateWidget/setup ** Firing setup:complete");
                a.trigger("setup:complete")
            },
            setupButton: function () {
                var a = this.callToActionCreative.template_vars,
                    d = c.parse(this.callToActionCreative.templates.button);
                this.ctaZone.cta || (b.log(" ** AdvocateWidget/setupButton **", "ctaZone doesn't have cta reference??"), this.placeHolder.html(d.render(a)));
                this.cta = new(R.getCtaView(this.placeHolder, this))({
                    el: this.placeHolder,
                    clientConfig: this.clientConfig,
                    zoneName: this.zoneName
                });
                this.cta.setWidget(this)
            },
            openAdvocateWidget: function (a) {
                b.log("button click");
                a.preventDefault();
                this.clickCall.setData(h.extend(!0, this.clickCall.getData(), {
                    mouse_xy: Math.round(a.pageX) + "," + Math.round(a.pageY),
                    first_name: this.user.get("first_name"),
                    last_name: this.user.get("last_name"),
                    email: this.user.get("email")
                }));
                this.clickCall.send();
                this.render()
            },
            setupShareWidgets: function () {
                var a = this,
                    b = {
                        errorTemplate: a.advocateWidgetCreative.templates.error,
                        tryAgainErrorTemplate: a.advocateWidgetCreative.templates.try_again_error,
                        widget: a,
                        widgetConfig: a.widgetConfig,
                        MEDIA_SERVER: a.options.MEDIA_SERVER,
                        WIDGET_VERSION: a.options.WIDGET_VERSION,
                        programHost: a.program.program_url,
                        baseCreativesVersion: a.options.baseCreativesVersion
                    }, c = a.advocateWidgetCreative.templates;
                a.shareWidgetMap = {
                    email: {
                        shareWidgetClass: x.EmailShareWidget,
                        options: h.extend({
                            template: c.email_share_widget
                        }, b)
                    },
                    facebook: {
                        shareWidgetClass: x.FacebookShareWidget,
                        options: h.extend({
                            template: c.facebook_share_widget,
                            appId: a.program.facebook.app_id,
                            namespace: a.program.facebook.app_namespace,
                            actionTypeName: a.program.facebook.action_type,
                            objectTypeName: a.program.facebook.object_type,
                            facebookCreative: a.friendCtaFacebookCreative
                        }, b)
                    },
                    twitter: {
                        shareWidgetClass: x.TwitterShareWidget,
                        options: h.extend({
                            template: c.twitter_share_widget,
                            consumerKey: a.program.twitter.consumer_key
                        }, b)
                    },
                    purl: {
                        shareWidgetClass: x.PurlShareWidget,
                        options: h.extend({
                            template: c.purl_share_widget
                        }, b)
                    },
                    dashboardEmail: {
                        shareWidgetClass: x.DashboardEmailWidget,
                        options: h.extend({
                            template: c.dashboard_email_share_widget
                        }, b)
                    }
                };
                a.shareWidgets = {};
                h.each(a.advocateWidgetCreative.options.widget_order, function (b, c) {
                    var d = a.shareWidgetMap[c],
                        d = new d.shareWidgetClass(d.options);
                    a.shareWidgets[c] = d;
                    d.on("shared", a.selectNextWidget, a)
                });
                a.visibleWidget = a.shareWidgets[a.advocateWidgetCreative.options.widget_order[0]];
                b = a.shareWidgetMap.purl;
                a.shareWidgets.purl = new b.shareWidgetClass(b.options);
                dashboardEmailWidgetConfig = a.shareWidgetMap.dashboardEmail;
                a.shareWidgets.dashboardEmail = new dashboardEmailWidgetConfig.shareWidgetClass(dashboardEmailWidgetConfig.options)
            },
            setupLinks: function () {
                var b = this,
                    c = b.advocateWidgetCreative.options.widget_order,
                    d = b.links = {}, e = b.$el.find("." + a.getName("info-button")),
                    f = b.$el.find("." + a.getName("share-widget-section")),
                    m = b.$el.find("." + a.getName("share-button-section") + " ." + a.getName("share-buttons")),
                    n = b.$el.find("." + a.getName("purl-section"));
                $dashboardEmailLinkContainer = b.$el.find("." + a.getName("dashboard-email-link-section"));
                c.push("dashboardEmail");
                h.each(c, function (c, e) {
                    $link = b.$el.find("." + a.getName("share-button-" + e));
                    $link.data("shareWidgetKey", e);
                    shareWidget = b.shareWidgets[e];
                    $link.appendTo(m);
                    d[e] = $link;
                    f.append(shareWidget.$el)
                });
                n.append(b.shareWidgets.purl.$el);
                b.advocateWidgetCreative.options.show_purl ? n.find("input[name=purl], ." + a.getName("purl-text")).click(function () {
                    this.setAttribute("contentEditable", !0);
                    if ("function" === typeof document.createRange && "function" === typeof window.getSelection) {
                        var a = window.getSelection(),
                            b = document.createRange();
                        b.setStart(this.firstChild, 0);
                        b.setEnd(this.firstChild, this.innerHTML.length);
                        a.removeAllRanges();
                        a.addRange(b)
                    }
                }) : n.hide();
                b.advocateWidgetCreative.options.show_dashboard_email || $dashboardEmailLinkContainer.hide();
                b.advocateWidgetCreative.options.show_info_button || e.hide()
            },
            destroy: function () {
                this.unrender();
                h.each(this.shareWidgets, function (a, b) {
                    b.destroy()
                });
                this.content.invisibleDiv && this.content.invisibleDiv.remove();
                this.menu && this.menu.destroy();
                this.$el.remove()
            },
            logout: function () {
                this === this.main.visibleWidget && (h.cookie("xtl_fle", null, {
                    path: "/"
                }), this.stopListening(this.user,
                    "logout"), this.destroy(), this.setup(), this.render())
            },
            toggleButtonHandler: function (a) {
                a.preventDefault();
                a = this.$(h(a.target).data("toggle-target"));
                window.theTarget = a;
                a.toggle()
            },
            toggle: function (a) {
                a && a.preventDefault();
                this.$el.add(this.content.invisibleDiv).is(":visible") ? this.unrender() : this.render()
            },
            render: function () {
                this.main.visibleWidget && this.main.visibleWidget != this && this.main.visibleWidget.unrender();
                this.main.visibleWidget = this;
                this.displayOptions.placeHolderContainsButton && this.renderPopup();
                this.renderWidget(this.visibleWidget);
                window.xtl_ga && window.xtl_ga("send", "event", {
                    eventCategory: "ClickStream",
                    eventAction: "AdvocateWidgetView"
                });
                this.trigger("rendered");
                a.reloadStylesheet();
                this.$el.addClass("z").removeClass("z");
                h("." + a.getName("how-it-works")).hide()
            },
            getBaseZIndices: function () {
                return {
                    base: 2147483547,
                    invisible: 2147483557,
                    widget: 2147483567
                }
            },
            renderPopup: function () {
                var c = this.getBaseZIndices();
                b.log("Rendering popup. zindices = " + c.invisible + ", " + c.widget);
                this.content.invisibleDiv &&
                    this.content.invisibleDiv.remove();
                this.content.invisibleDiv = h('<div class="' + a.getName("invisible-div") + '"></div>').appendTo(document.body).css({
                    zIndex: c.invisible
                }).on("click", h.proxy(this.toggle, this));
                this.$el.css({
                    position: "absolute",
                    zIndex: c.widget
                }).show().css({
                    top: h(document).scrollTop() + Math.min(50, this.$el.position().top)
                })
            },
            renderWidget: function (b) {
                var c = this;
                c.setPreviousWidget(b);
                h.each(c.links, function (d, e) {
                    c.shareWidgets[d] == b ? e.addClass(a.getName("selected")) : e.removeClass(a.getName("selected"))
                });
                c.visibleWidget.hide();
                b.show();
                c.visibleWidget = b;
                c.trigger("shareWidget:select", c.visibleWidget)
            },
            setPreviousWidget: function (a) {
                !this.visibleWidget || this.visibleWidget instanceof this.shareWidgetMap.dashboardEmail.shareWidgetClass ? a instanceof this.shareWidgetMap.dashboardEmail.shareWidgetClass || (this.previousWidget = a) : this.previousWidget = this.visibleWidget
            },
            renderPreviousWidget: function () {
                this.previousWidget && this.renderWidget(this.previousWidget)
            },
            selectNextWidget: function () {
                var a = this,
                    b, c = n.reject(a.advocateWidgetCreative.options.widget_order,
                        function (a) {
                            return "dashboardEmail" == a
                        });
                h.each(c, function (d, e) {
                    a.shareWidgets[e] == a.visibleWidget && (b = a.shareWidgets[c[d + 1]])
                });
                b || (b = a.shareWidgets[c[0]]);
                a.renderWidget(b)
            },
            unrender: function () {
                this.main.visibleWidget == this && (this.main.visibleWidget = void 0);
                this.content.invisibleDiv && this.content.invisibleDiv.remove();
                this.$el.hide()
            },
            getResources: function () {
                return d.getValuesFromRules(this.zone.resources)
            },
            fetchConfig: function (a) {
                return this.placeHolderOptions.campaignId ? m.fetchCampaignConfig(this.clientConfig,
                    this.placeHolderOptions.campaignId, a) : m.fetchCampaignConfig(this.clientConfig, this.placeHolderOptions.zone, a)
            },
            triggerExtoleEvent: function (a) {
                U.trigger(a, this.clientConfig, {
                    user: h.extend(!0, {}, this.user.attributes),
                    zoneName: this.zoneName,
                    campaignId: this.campaignId,
                    sharedVars: this.placeHolderOptions
                })
            }
        })
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/AdvocateWidget", "jquery Underscore Backbone jsuri Liquid widget-common/min-utils/base widget-common/utils/css-utils widget-common/utils/resource-utils widget-common/utils/template-utils widget-common/utils/loader-utils widget-common/BackboneWidget advocate-widget/utils/config-utils advocate-widget/AdvocateUser advocate-widget/AdvocateWidgetMenu advocate-widget/share-widgets advocate-widget/analytics-calls advocate-widget/ctas advocate-widget/events".split(" "),
        x);
    "undefined" != typeof n && (n.AdvocateWidget = x(n.$, n._, n.Backbone, n.Uri, n.Liquid, n.minUtils, n.cssUtils, n.resourceUtils, n.templateUtils, n.loaderUtils, n.BackboneWidget, n.configUtils, n.AdvocateUser, n.AdvocateWidgetMenu, n.shareWidgets, n.analyticsCalls, n.ctas, n.events));
    x = function (h, n, s, q, c, b, a, d, e, f) {
        return d.View.extend({
            initialize: function () {
                var a = this,
                    c = a.options,
                    d = h(c.placeHolder),
                    f = {}, q = c.clientConfig;
                n.generalReady("conversion-call");
                try {
                    f = s.parse(d.html())
                } catch (x) {
                    R("Bad JSON in placeholder")
                }
                a.placeHolderOptions =
                    h.extend(!0, {}, c.sharedVars, f);
                a.params = b.getInitParams(a.placeHolderOptions.params || {});
                a.conversionType = a.placeHolderOptions.type || "purchase";
                b.setMediaServer(c.MEDIA_SERVER);
                a.program = b.getProgram(q.client);
                if (!a.program) return R("No program was set."), !1;
                a.convertRoot = "//" + a.program.program_url + "/v2";
                window.XDomainRequest ? e.iframeReady(a.program.program_url, function () {
                    a.xdMessager = new e("xd-page", {
                        sendTo: extole.xdIframe[0].contentWindow
                    });
                    a.sendConvertServiceCall()
                }) : a.sendConvertServiceCall()
            },
            sendConvertServiceCall: function () {
                var b = this.convertRoot + "/convert",
                    c = a.getParamsForCall(this.params, "purchase"),
                    b = {
                        url: b,
                        dataType: "json",
                        contentType: "application/json",
                        processData: !1,
                        type: "post",
                        xhrFields: {
                            withCredentials: !0
                        },
                        timeout: 3E3
                    };
                h.extend(c, {
                    window_wh: h(window).width() + "," + h(window).height(),
                    screen_wh: window.screen.width + "," + window.screen.height
                });
                b.data = s.stringify(c);
                this.xdMessager ? (this.xdMessager.once("sendRequest:failed", h.proxy(this.failure, this)), this.xdMessager.once("sendRequest:success",
                    h.proxy(this.successful, this)), this.xdMessager.sendMessage("sendRequest", b)) : (b.success = h.proxy(this.successful, this), b.error = h.proxy(this.failure, this), h.ajax(b))
            },
            failure: function () {
                this.triggerExtoleEvent(this.conversionType + ":fail")
            },
            successful: function () {
                this.triggerExtoleEvent(this.conversionType + ":success")
            },
            triggerExtoleEvent: function (a) {
                f.trigger("conversion:" + a, this.options.clientConfig, {
                    sharedVars: this.options.sharedVars
                })
            }
        })
    };
    "undefined" !== typeof define && define.amd && define("advocate-widget/ConversionCall",
        "jquery widget-common/min-utils/base JSON widget-common/jquery-plugins Underscore advocate-widget/utils/config-utils advocate-widget/utils/call-utils Backbone advocate-widget/utils/XdMessager advocate-widget/events".split(" "), x);
    "undefined" != typeof n && (n.ConversionCall = x(n.$, n.minUtils, n.JSON, n.jqueryPlugins, n._, n.configUtils, n.callUtils, n.Backbone, n.XdMessager, n.events));
    (function (h, n, s, q, c, b, a, d, e, f, v, m, r, u, x, C, Y, U) {
        window.extole = window.extole || {};
        e.setMediaServer(ma);
        var ea = {
            widgetConfig: {
                MEDIA_SERVER: ma
            }
        },
            A = window.extole.main = window.extole.main || {};
        A.widgets = [];
        A.conversions = [];
        A.coupon = void 0;
        A.visibleWidget = void 0;
        A.getSharedVars = function () {
            var a = {}, b = h('script[type="extole/context"]');
            0 < b.length && b.each(function () {
                var b;
                try {
                    b = L.parse(this.innerHTML)
                } catch (c) {
                    R("Bad JSON in shared vars")
                }
                b && h.extend(a, b)
            });
            return a
        };
        A.start = function (a) {
            U.log("Starting main...");
            U.log("Doing scan of scripts.");
            U.ready(function () {
                U.log(" ** main.start ** Document ready");
                A.initWidgets(a);
                A.fireConversions(a);
                A.initCoupons(a)
            });
            h(document).load(function () {
                A.initWidgets(a)
            })
        };
        A.initWidgets = function (a) {
            U.log("** main.initWidgets **");
            var b = 0;
            h.each(window.extole.renderedZones, function (c, d) {
                b++;
                A.initWidget(a, h(d.cta), b, {})
            })
        };
        A.initWidget = function (a, b, c, d) {
            d = d || {};
            b = h(b)[0];
            var f = {}, m;
            f.start = function () {
                U.log.info("** main.initWidget ** ", "elem = ", b);
                e.getBaseCreativesVersion(a, f.withBaseCreativesVersion)
            };
            f.withBaseCreativesVersion = function (e) {
                m = e;
                A.user || (A.user = new x);
                e = new u({
                    widgetConfig: ea,
                    main: A,
                    placeHolder: b,
                    placeHolderOptions: d,
                    placeHolderIndex: c,
                    sharedVars: A.getSharedVars(),
                    clientConfig: a,
                    MEDIA_SERVER: ma,
                    WIDGET_VERSION: "20131213.1938",
                    HTML_ASSEMBLER_ROOT: xa,
                    user: A.user,
                    baseCreativesVersion: m,
                    setupComplete: function () {
                        A.initWidget.ready()
                    }
                });
                A.widgets.push(e)
            };
            A.initWidget.ready(function () {
                f.start()
            })
        }; - 1 == h.msieVersion() || 8 < h.msieVersion() ? A.initWidget.ready = function (a) {
            void(a && a())
        } : (A.initWidget.ready = function (a) {
            var b = A.initWidget.ready.callbacks,
                c = b[b.length - 1];
            a ? b.push(a) : A.initWidget.ready.locked = !1;
            A.initWidget.ready.locked || !c && 1 != b.length || (A.initWidget.ready.locked = !0, setTimeout(function () {
                c = b.pop();
                void(c && c())
            }, 1E3))
        }, A.initWidget.ready.locked = !1, A.initWidget.ready.callbacks = []);
        A.fireConversions = function (a) {
            h('script[type="extole/conversion"]').not("[data-used]").each(function (b, c) {
                h(c).attr("data-used", "1");
                var d = new C({
                    clientConfig: a,
                    main: A,
                    placeHolder: c,
                    sharedVars: A.getSharedVars(),
                    MEDIA_SERVER: ma
                });
                A.conversions.push(d)
            })
        };
        A.initCoupons = function (a) {
            if (A.coupon) return !1;
            A.coupon = !0;
            var b = r.getParams(),
                c = {}, d,
                f;
            c.start = function () {
                b.extole.client_id && (b.extole.campaign_id || b.extole.zone_name) && e.getBaseCreativesVersion(a, c.withBaseCreativesVersion)
            };
            c.withBaseCreativesVersion = function (d) {
                f = d;
                e.fetchCampaignConfig(a, b.extole.campaign_id || b.extole.zone_name, c.withCampaignConfig)
            };
            c.withCampaignConfig = function (b) {
                d = b;
                m.init(a, d, f, ea)
            };
            c.start()
        };
        extole.mainCb = extole.mainCb || function () {};
        extole.mainCb()
    })(n.$, n._, n.Backbone, n.Widget, n.BackboneWidget, n.Uri, n.cssUtils, n.loaderUtils, n.configUtils, n.templateUtils,
        n.shareWidgets, n.coupons, n.paramUtils, n.AdvocateWidget, n.AdvocateUser, n.ConversionCall, n.FloaterCta, n.minUtils)
})();