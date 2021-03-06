! function(t) {
    "use strict";
    "function" == typeof define && define.amd ? define(["jquery"], t) : t("undefined" != typeof jQuery ? jQuery : window.Zepto)
}(function(t) {
    "use strict";

    function e(e) {
        var n = e.data;
        e.isDefaultPrevented() || (e.preventDefault(), t(e.target).ajaxSubmit(n))
    }

    function n(e) {
        var n = e.target,
            a = t(n);
        if (!a.is("[type=submit],[type=image]")) {
            var r = a.closest("[type=submit]");
            if (0 === r.length) return;
            n = r[0]
        }
        var o = this;
        if (o.clk = n, "image" == n.type)
            if (void 0 !== e.offsetX) o.clk_x = e.offsetX, o.clk_y = e.offsetY;
            else if ("function" == typeof t.fn.offset) {
            var i = a.offset();
            o.clk_x = e.pageX - i.left, o.clk_y = e.pageY - i.top
        } else o.clk_x = e.pageX - n.offsetLeft, o.clk_y = e.pageY - n.offsetTop;
        setTimeout(function() {
            o.clk = o.clk_x = o.clk_y = null
        }, 100)
    }

    function a() {
        if (t.fn.ajaxSubmit.debug) {
            var e = "[jquery.form] " + Array.prototype.join.call(arguments, "");
            window.console && window.console.log ? window.console.log(e) : window.opera && window.opera.postError && window.opera.postError(e)
        }
    }
    var r = {};
    r.fileapi = void 0 !== t("<input type='file'/>").get(0).files, r.formdata = void 0 !== window.FormData;
    var o = !!t.fn.prop;
    t.fn.attr2 = function() {
        if (!o) return this.attr.apply(this, arguments);
        var t = this.prop.apply(this, arguments);
        return t && t.jquery || "string" == typeof t ? t : this.attr.apply(this, arguments)
    }, t.fn.ajaxSubmit = function(e) {
        function n(n) {
            var a, r, o = t.param(n, e.traditional).split("&"),
                i = o.length,
                s = [];
            for (a = 0; i > a; a++) o[a] = o[a].replace(/\+/g, " "), r = o[a].split("="), s.push([decodeURIComponent(r[0]), decodeURIComponent(r[1])]);
            return s
        }

        function i(a) {
            for (var r = new FormData, o = 0; o < a.length; o++) r.append(a[o].name, a[o].value);
            if (e.extraData) {
                var i = n(e.extraData);
                for (o = 0; o < i.length; o++) i[o] && r.append(i[o][0], i[o][1])
            }
            e.data = null;
            var s = t.extend(!0, {}, t.ajaxSettings, e, {
                contentType: !1,
                processData: !1,
                cache: !1,
                type: l || "POST"
            });
            e.uploadProgress && (s.xhr = function() {
                var n = t.ajaxSettings.xhr();
                return n.upload && n.upload.addEventListener("progress", function(t) {
                    var n = 0,
                        a = t.loaded || t.position,
                        r = t.total;
                    t.lengthComputable && (n = Math.ceil(a / r * 100)), e.uploadProgress(t, a, r, n)
                }, !1), n
            }), s.data = null;
            var c = s.beforeSend;
            return s.beforeSend = function(t, n) {
                n.data = e.formData ? e.formData : r, c && c.call(this, t, n)
            }, t.ajax(s)
        }

        function s(n) {
            function r(t) {
                var e = null;
                try {
                    t.contentWindow && (e = t.contentWindow.document)
                } catch (n) {
                    a("cannot get iframe.contentWindow document: " + n)
                }
                if (e) return e;
                try {
                    e = t.contentDocument ? t.contentDocument : t.document
                } catch (n) {
                    a("cannot get iframe.contentDocument: " + n), e = t.document
                }
                return e
            }

            function i() {
                function e() {
                    try {
                        var t = r(g).readyState;
                        a("state = " + t), t && "uninitialized" == t.toLowerCase() && setTimeout(e, 50)
                    } catch (n) {
                        a("Server abort: ", n, " (", n.name, ")"), s(T), S && clearTimeout(S), S = void 0
                    }
                }
                var n = d.attr2("target"),
                    o = d.attr2("action"),
                    i = "multipart/form-data",
                    c = d.attr("enctype") || d.attr("encoding") || i;
                k.setAttribute("target", f), (!l || /post/i.test(l)) && k.setAttribute("method", "POST"), o != m.url && k.setAttribute("action", m.url), m.skipEncodingOverride || l && !/post/i.test(l) || d.attr({
                    encoding: "multipart/form-data",
                    enctype: "multipart/form-data"
                }), m.timeout && (S = setTimeout(function() {
                    w = !0, s(C)
                }, m.timeout));
                var u = [];
                try {
                    if (m.extraData)
                        for (var p in m.extraData) m.extraData.hasOwnProperty(p) && u.push(t.isPlainObject(m.extraData[p]) && m.extraData[p].hasOwnProperty("name") && m.extraData[p].hasOwnProperty("value") ? t('<input type="hidden" name="' + m.extraData[p].name + '">').val(m.extraData[p].value).appendTo(k)[0] : t('<input type="hidden" name="' + p + '">').val(m.extraData[p]).appendTo(k)[0]);
                    m.iframeTarget || v.appendTo("body"), g.attachEvent ? g.attachEvent("onload", s) : g.addEventListener("load", s, !1), setTimeout(e, 15);
                    try {
                        k.submit()
                    } catch (h) {
                        var b = document.createElement("form").submit;
                        b.apply(k)
                    }
                } finally {
                    k.setAttribute("action", o), k.setAttribute("enctype", c), n ? k.setAttribute("target", n) : d.removeAttr("target"), t(u).remove()
                }
            }

            function s(e) {
                if (!b.aborted && !D) {
                    if (A = r(g), A || (a("cannot access response document"), e = T), e === C && b) return b.abort("timeout"), void N.reject(b, "timeout");
                    if (e == T && b) return b.abort("server abort"), void N.reject(b, "error", "server abort");
                    if (A && A.location.href != m.iframeSrc || w) {
                        g.detachEvent ? g.detachEvent("onload", s) : g.removeEventListener("load", s, !1);
                        var n, o = "success";
                        try {
                            if (w) throw "timeout";
                            var i = "xml" == m.dataType || A.XMLDocument || t.isXMLDoc(A);
                            if (a("isXml=" + i), !i && window.opera && (null === A.body || !A.body.innerHTML) && --I) return a("requeing onLoad callback, DOM not available"), void setTimeout(s, 250);
                            var l = A.body ? A.body : A.documentElement;
                            b.responseText = l ? l.innerHTML : null, b.responseXML = A.XMLDocument ? A.XMLDocument : A, i && (m.dataType = "xml"), b.getResponseHeader = function(t) {
                                var e = {
                                    "content-type": m.dataType
                                };
                                return e[t.toLowerCase()]
                            }, l && (b.status = Number(l.getAttribute("status")) || b.status, b.statusText = l.getAttribute("statusText") || b.statusText);
                            var c = (m.dataType || "").toLowerCase(),
                                u = /(json|script|text)/.test(c);
                            if (u || m.textarea) {
                                var d = A.getElementsByTagName("textarea")[0];
                                if (d) b.responseText = d.value, b.status = Number(d.getAttribute("status")) || b.status, b.statusText = d.getAttribute("statusText") || b.statusText;
                                else if (u) {
                                    var f = A.getElementsByTagName("pre")[0],
                                        h = A.getElementsByTagName("body")[0];
                                    f ? b.responseText = f.textContent ? f.textContent : f.innerText : h && (b.responseText = h.textContent ? h.textContent : h.innerText)
                                }
                            } else "xml" == c && !b.responseXML && b.responseText && (b.responseXML = L(b.responseText));
                            try {
                                j = M(b, c, m)
                            } catch (y) {
                                o = "parsererror", b.error = n = y || o
                            }
                        } catch (y) {
                            a("error caught: ", y), o = "error", b.error = n = y || o
                        }
                        b.aborted && (a("upload aborted"), o = null), b.status && (o = b.status >= 200 && b.status < 300 || 304 === b.status ? "success" : "error"), "success" === o ? (m.success && m.success.call(m.context, j, "success", b), N.resolve(b.responseText, "success", b), p && t.event.trigger("ajaxSuccess", [b, m])) : o && (void 0 === n && (n = b.statusText), m.error && m.error.call(m.context, b, o, n), N.reject(b, "error", n), p && t.event.trigger("ajaxError", [b, m, n])), p && t.event.trigger("ajaxComplete", [b, m]), p && !--t.active && t.event.trigger("ajaxStop"), m.complete && m.complete.call(m.context, b, o), D = !0, m.timeout && clearTimeout(S), setTimeout(function() {
                            m.iframeTarget ? v.attr("src", m.iframeSrc) : v.remove(), b.responseXML = null
                        }, 100)
                    }
                }
            }
            var c, u, m, p, f, v, g, b, y, x, w, S, k = d[0],
                N = t.Deferred();
            if (N.abort = function(t) {
                    b.abort(t)
                }, n)
                for (u = 0; u < h.length; u++) c = t(h[u]), o ? c.prop("disabled", !1) : c.removeAttr("disabled");
            if (m = t.extend(!0, {}, t.ajaxSettings, e), m.context = m.context || m, f = "jqFormIO" + (new Date).getTime(), m.iframeTarget ? (v = t(m.iframeTarget), x = v.attr2("name"), x ? f = x : v.attr2("name", f)) : (v = t('<iframe name="' + f + '" src="' + m.iframeSrc + '" />'), v.css({
                    position: "absolute",
                    top: "-1000px",
                    left: "-1000px"
                })), g = v[0], b = {
                    aborted: 0,
                    responseText: null,
                    responseXML: null,
                    status: 0,
                    statusText: "n/a",
                    getAllResponseHeaders: function() {},
                    getResponseHeader: function() {},
                    setRequestHeader: function() {},
                    abort: function(e) {
                        var n = "timeout" === e ? "timeout" : "aborted";
                        a("aborting upload... " + n), this.aborted = 1;
                        try {
                            g.contentWindow.document.execCommand && g.contentWindow.document.execCommand("Stop")
                        } catch (r) {}
                        v.attr("src", m.iframeSrc), b.error = n, m.error && m.error.call(m.context, b, n, e), p && t.event.trigger("ajaxError", [b, m, n]), m.complete && m.complete.call(m.context, b, n)
                    }
                }, p = m.global, p && 0 === t.active++ && t.event.trigger("ajaxStart"), p && t.event.trigger("ajaxSend", [b, m]), m.beforeSend && m.beforeSend.call(m.context, b, m) === !1) return m.global && t.active--, N.reject(), N;
            if (b.aborted) return N.reject(), N;
            y = k.clk, y && (x = y.name, x && !y.disabled && (m.extraData = m.extraData || {}, m.extraData[x] = y.value, "image" == y.type && (m.extraData[x + ".x"] = k.clk_x, m.extraData[x + ".y"] = k.clk_y)));
            var C = 1,
                T = 2,
                E = t("meta[name=csrf-token]").attr("content"),
                H = t("meta[name=csrf-param]").attr("content");
            H && E && (m.extraData = m.extraData || {}, m.extraData[H] = E), m.forceSync ? i() : setTimeout(i, 10);
            var j, A, D, I = 50,
                L = t.parseXML || function(t, e) {
                    return window.ActiveXObject ? (e = new ActiveXObject("Microsoft.XMLDOM"), e.async = "false", e.loadXML(t)) : e = (new DOMParser).parseFromString(t, "text/xml"), e && e.documentElement && "parsererror" != e.documentElement.nodeName ? e : null
                },
                O = t.parseJSON || function(t) {
                    return window.eval("(" + t + ")")
                },
                M = function(e, n, a) {
                    var r = e.getResponseHeader("content-type") || "",
                        o = "xml" === n || !n && r.indexOf("xml") >= 0,
                        i = o ? e.responseXML : e.responseText;
                    return o && "parsererror" === i.documentElement.nodeName && t.error && t.error("parsererror"), a && a.dataFilter && (i = a.dataFilter(i, n)), "string" == typeof i && ("json" === n || !n && r.indexOf("json") >= 0 ? i = O(i) : ("script" === n || !n && r.indexOf("javascript") >= 0) && t.globalEval(i)), i
                };
            return N
        }
        if (!this.length) return a("ajaxSubmit: skipping submit process - no element selected"), this;
        var l, c, u, d = this;
        "function" == typeof e ? e = {
            success: e
        } : void 0 === e && (e = {}), l = e.type || this.attr2("method"), c = e.url || this.attr2("action"), u = "string" == typeof c ? t.trim(c) : "", u = u || window.location.href || "", u && (u = (u.match(/^([^#]+)/) || [])[1]), e = t.extend(!0, {
            url: u,
            success: t.ajaxSettings.success,
            type: l || t.ajaxSettings.type,
            iframeSrc: /^https/i.test(window.location.href || "") ? "javascript:false" : "about:blank"
        }, e);
        var m = {};
        if (this.trigger("form-pre-serialize", [this, e, m]), m.veto) return a("ajaxSubmit: submit vetoed via form-pre-serialize trigger"), this;
        if (e.beforeSerialize && e.beforeSerialize(this, e) === !1) return a("ajaxSubmit: submit aborted via beforeSerialize callback"), this;
        var p = e.traditional;
        void 0 === p && (p = t.ajaxSettings.traditional);
        var f, h = [],
            v = this.formToArray(e.semantic, h);
        if (e.data && (e.extraData = e.data, f = t.param(e.data, p)), e.beforeSubmit && e.beforeSubmit(v, this, e) === !1) return a("ajaxSubmit: submit aborted via beforeSubmit callback"), this;
        if (this.trigger("form-submit-validate", [v, this, e, m]), m.veto) return a("ajaxSubmit: submit vetoed via form-submit-validate trigger"), this;
        var g = t.param(v, p);
        f && (g = g ? g + "&" + f : f), "GET" == e.type.toUpperCase() ? (e.url += (e.url.indexOf("?") >= 0 ? "&" : "?") + g, e.data = null) : e.data = g;
        var b = [];
        if (e.resetForm && b.push(function() {
                d.resetForm()
            }), e.clearForm && b.push(function() {
                d.clearForm(e.includeHidden)
            }), !e.dataType && e.target) {
            var y = e.success || function() {};
            b.push(function(n) {
                var a = e.replaceTarget ? "replaceWith" : "html";
                t(e.target)[a](n).each(y, arguments)
            })
        } else e.success && b.push(e.success);
        if (e.success = function(t, n, a) {
                for (var r = e.context || this, o = 0, i = b.length; i > o; o++) b[o].apply(r, [t, n, a || d, d])
            }, e.error) {
            var x = e.error;
            e.error = function(t, n, a) {
                var r = e.context || this;
                x.apply(r, [t, n, a, d])
            }
        }
        if (e.complete) {
            var w = e.complete;
            e.complete = function(t, n) {
                var a = e.context || this;
                w.apply(a, [t, n, d])
            }
        }
        var S = t("input[type=file]:enabled", this).filter(function() {
                return "" !== t(this).val()
            }),
            k = S.length > 0,
            N = "multipart/form-data",
            C = d.attr("enctype") == N || d.attr("encoding") == N,
            T = r.fileapi && r.formdata;
        a("fileAPI :" + T);
        var E, H = (k || C) && !T;
        e.iframe !== !1 && (e.iframe || H) ? e.closeKeepAlive ? t.get(e.closeKeepAlive, function() {
            E = s(v)
        }) : E = s(v) : E = (k || C) && T ? i(v) : t.ajax(e), d.removeData("jqxhr").data("jqxhr", E);
        for (var j = 0; j < h.length; j++) h[j] = null;
        return this.trigger("form-submit-notify", [this, e]), this
    }, t.fn.ajaxForm = function(r) {
        if (r = r || {}, r.delegation = r.delegation && t.isFunction(t.fn.on), !r.delegation && 0 === this.length) {
            var o = {
                s: this.selector,
                c: this.context
            };
            return !t.isReady && o.s ? (a("DOM not ready, queuing ajaxForm"), t(function() {
                t(o.s, o.c).ajaxForm(r)
            }), this) : (a("terminating; zero elements found by selector" + (t.isReady ? "" : " (DOM not ready)")), this)
        }
        return r.delegation ? (t(document).off("submit.form-plugin", this.selector, e).off("click.form-plugin", this.selector, n).on("submit.form-plugin", this.selector, r, e).on("click.form-plugin", this.selector, r, n), this) : this.ajaxFormUnbind().bind("submit.form-plugin", r, e).bind("click.form-plugin", r, n)
    }, t.fn.ajaxFormUnbind = function() {
        return this.unbind("submit.form-plugin click.form-plugin")
    }, t.fn.formToArray = function(e, n) {
        var a = [];
        if (0 === this.length) return a;
        var o, i = this[0],
            s = this.attr("id"),
            l = e ? i.getElementsByTagName("*") : i.elements;
        if (l && !/MSIE [678]/.test(navigator.userAgent) && (l = t(l).get()), s && (o = t(':input[form="' + s + '"]').get(), o.length && (l = (l || []).concat(o))), !l || !l.length) return a;
        var c, u, d, m, p, f, h;
        for (c = 0, f = l.length; f > c; c++)
            if (p = l[c], d = p.name, d && !p.disabled)
                if (e && i.clk && "image" == p.type) i.clk == p && (a.push({
                    name: d,
                    value: t(p).val(),
                    type: p.type
                }), a.push({
                    name: d + ".x",
                    value: i.clk_x
                }, {
                    name: d + ".y",
                    value: i.clk_y
                }));
                else if (m = t.fieldValue(p, !0), m && m.constructor == Array)
            for (n && n.push(p), u = 0, h = m.length; h > u; u++) a.push({
                name: d,
                value: m[u]
            });
        else if (r.fileapi && "file" == p.type) {
            n && n.push(p);
            var v = p.files;
            if (v.length)
                for (u = 0; u < v.length; u++) a.push({
                    name: d,
                    value: v[u],
                    type: p.type
                });
            else a.push({
                name: d,
                value: "",
                type: p.type
            })
        } else null !== m && "undefined" != typeof m && (n && n.push(p), a.push({
            name: d,
            value: m,
            type: p.type,
            required: p.required
        }));
        if (!e && i.clk) {
            var g = t(i.clk),
                b = g[0];
            d = b.name, d && !b.disabled && "image" == b.type && (a.push({
                name: d,
                value: g.val()
            }), a.push({
                name: d + ".x",
                value: i.clk_x
            }, {
                name: d + ".y",
                value: i.clk_y
            }))
        }
        return a
    }, t.fn.formSerialize = function(e) {
        return t.param(this.formToArray(e))
    }, t.fn.fieldSerialize = function(e) {
        var n = [];
        return this.each(function() {
            var a = this.name;
            if (a) {
                var r = t.fieldValue(this, e);
                if (r && r.constructor == Array)
                    for (var o = 0, i = r.length; i > o; o++) n.push({
                        name: a,
                        value: r[o]
                    });
                else null !== r && "undefined" != typeof r && n.push({
                    name: this.name,
                    value: r
                })
            }
        }), t.param(n)
    }, t.fn.fieldValue = function(e) {
        for (var n = [], a = 0, r = this.length; r > a; a++) {
            var o = this[a],
                i = t.fieldValue(o, e);
            null === i || "undefined" == typeof i || i.constructor == Array && !i.length || (i.constructor == Array ? t.merge(n, i) : n.push(i))
        }
        return n
    }, t.fieldValue = function(e, n) {
        var a = e.name,
            r = e.type,
            o = e.tagName.toLowerCase();
        if (void 0 === n && (n = !0), n && (!a || e.disabled || "reset" == r || "button" == r || ("checkbox" == r || "radio" == r) && !e.checked || ("submit" == r || "image" == r) && e.form && e.form.clk != e || "select" == o && -1 == e.selectedIndex)) return null;
        if ("select" == o) {
            var i = e.selectedIndex;
            if (0 > i) return null;
            for (var s = [], l = e.options, c = "select-one" == r, u = c ? i + 1 : l.length, d = c ? i : 0; u > d; d++) {
                var m = l[d];
                if (m.selected) {
                    var p = m.value;
                    if (p || (p = m.attributes && m.attributes.value && !m.attributes.value.specified ? m.text : m.value), c) return p;
                    s.push(p)
                }
            }
            return s
        }
        return t(e).val()
    }, t.fn.clearForm = function(e) {
        return this.each(function() {
            t("input,select,textarea", this).clearFields(e)
        })
    }, t.fn.clearFields = t.fn.clearInputs = function(e) {
        var n = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;
        return this.each(function() {
            var a = this.type,
                r = this.tagName.toLowerCase();
            n.test(a) || "textarea" == r ? this.value = "" : "checkbox" == a || "radio" == a ? this.checked = !1 : "select" == r ? this.selectedIndex = -1 : "file" == a ? /MSIE/.test(navigator.userAgent) ? t(this).replaceWith(t(this).clone(!0)) : t(this).val("") : e && (e === !0 && /hidden/.test(a) || "string" == typeof e && t(this).is(e)) && (this.value = "")
        })
    }, t.fn.resetForm = function() {
        return this.each(function() {
            ("function" == typeof this.reset || "object" == typeof this.reset && !this.reset.nodeType) && this.reset()
        })
    }, t.fn.enable = function(t) {
        return void 0 === t && (t = !0), this.each(function() {
            this.disabled = !t
        })
    }, t.fn.selected = function(e) {
        return void 0 === e && (e = !0), this.each(function() {
            var n = this.type;
            if ("checkbox" == n || "radio" == n) this.checked = e;
            else if ("option" == this.tagName.toLowerCase()) {
                var a = t(this).parent("select");
                e && a[0] && "select-one" == a[0].type && a.find("option").selected(!1), this.selected = e
            }
        })
    }, t.fn.ajaxSubmit.debug = !1
}),
function(t, e, n) {
    "use strict";

    function a(t, e) {
        this.elem = t, e = e || {}, this.className = e.className || "easyeditor";
        var n = ["bold", "italic", "link", "h2", "h3", "h4", "alignleft", "aligncenter", "alignright"];
        this.buttons = e.buttons || n, this.buttonsHtml = e.buttonsHtml || null, this.overwriteButtonSettings = e.overwriteButtonSettings || null, this.css = e.css || null, this.onLoaded = "function" == typeof e.onLoaded ? e.onLoaded : null, this.randomString = Math.random().toString(36).substring(7), this.theme = e.theme || null, this.dropdown = e.dropdown || {}, this.attachEvents()
    }
    a.prototype.attachEvents = function() {
        this.bootstrap(), this.addToolbar(), this.handleKeypress(), this.handleResizeImage(), this.utils(), null !== this.onLoaded && this.onLoaded.call(this)
    }, a.prototype.detachEvents = function() {
        var e = this,
            n = t(e.elem).closest("." + e.className + "-wrapper"),
            a = n.find("." + e.className + "-toolbar");
        a.remove(), t(e.elem).removeClass(e.className).removeAttr("contenteditable").unwrap()
    }, a.prototype.bootstrap = function() {
        var n = this,
            a = t(n.elem).prop("tagName").toLowerCase();
        if ("textarea" === a || "input" === a) {
            var r = t(n.elem).attr("placeholder") || "",
                o = t(n.elem).css("marginTop") || 0,
                i = t(n.elem).css("marginBottom") || 0,
                s = "";
            (o.length > 0 || i.length > 0) && (s = ' style="margin-top: ' + o + "; margin-bottom: " + i + '" '), t(n.elem).after('<div id="' + n.randomString + '-editor" placeholder="' + r + '">' + t(n.elem).val() + "</div>"), t(n.elem).hide().addClass(n.randomString + "-bind"), n.elem = e.getElementById(n.randomString + "-editor"), t(n.elem).attr("contentEditable", !0).addClass(n.className).wrap('<div class="' + n.className + '-wrapper"' + s + "></div>")
        } else t(n.elem).attr("contentEditable", !0).addClass(n.className).wrap('<div class="' + n.className + '-wrapper"></div>');
        this.$wrapperElem = t(n.elem).parent(), null !== n.css && t(n.elem).css(n.css), this.containerClass = "." + n.className + "-wrapper", "string" == typeof n.elem && (n.elem = t(n.elem).get(0)), null !== n.theme && t(n.elem).closest(n.containerClass).addClass(n.theme)
    }, a.prototype.handleKeypress = function() {
        var n = this;
        t(n.elem).keydown(function(t) {
            return 13 === t.keyCode && n.isSelectionInsideElement("li") === !1 ? (t.preventDefault(), t.shiftKey === !0 ? e.execCommand("insertHTML", !1, "<br>") : e.execCommand("insertHTML", !1, "<br><br>"), !1) : void 0
        }), n.elem.addEventListener("paste", function(t) {
            t.preventDefault();
            var n = t.clipboardData.getData("text/plain").replace(/\n/gi, "<br>");
            e.execCommand("insertHTML", !1, n)
        })
    }, a.prototype.isSelectionInsideElement = function(t) {
        var a, r;
        for (t = t.toUpperCase(), n.getSelection ? (a = n.getSelection(), a.rangeCount > 0 && (r = a.getRangeAt(0).commonAncestorContainer)) : (a = e.selection) && "Control" != a.type && (r = a.createRange().parentElement()); r;) {
            if (1 == r.nodeType && r.tagName == t) return !0;
            r = r.parentNode
        }
        return !1
    }, a.prototype.addToolbar = function() {
        var e = this;
        t(e.elem).before('<div class="' + e.className + '-toolbar"><ul></ul></div>'), this.$toolbarContainer = this.$wrapperElem.find("." + e.className + "-toolbar"), this.populateButtons()
    }, a.prototype.injectButton = function(e) {
        var n = this;
        if (null !== n.overwriteButtonSettings && void 0 !== n.overwriteButtonSettings[e.buttonIdentifier]) {
            var a = t.extend({}, e, n.overwriteButtonSettings[e.buttonIdentifier]);
            e = a
        }
        null !== n.buttonsHtml && void 0 !== n.buttonsHtml[e.buttonIdentifier] && (e.buttonHtml = n.buttonsHtml[e.buttonIdentifier]);
        var r;
        if (r = e.buttonTitle ? e.buttonTitle : e.buttonIdentifier.replace(/\W/g, " "), e.buttonHtml)
            if (void 0 !== e.childOf) {
                var o = n.$toolbarContainer.find(".toolbar-" + e.childOf).parent("li");
                0 === o.find("ul").length && o.append("<ul></ul>"), o = o.find("ul"), o.append('<li><button type="button" class="toolbar-' + e.buttonIdentifier + '" title="' + r + '">' + e.buttonHtml + "</button></li>")
            } else n.$toolbarContainer.children("ul").append('<li><button type="button" class="toolbar-' + e.buttonIdentifier + '" title="' + r + '">' + e.buttonHtml + "</button></li>");
        "function" == typeof e.clickHandler && t("html").find(n.elem).closest(n.containerClass).delegate(".toolbar-" + e.buttonIdentifier, "click", function(a) {
            void 0 !== typeof e.hasChild && e.hasChild === !0 ? a.stopPropagation() : a.preventDefault(), e.clickHandler.call(this, this), t(n.elem).trigger("keyup")
        })
    }, a.prototype.openDropdownOf = function(e) {
        var n = this;
        t(n.elem).closest(n.containerClass).find(".toolbar-" + e).parent().children("ul").show()
    }, a.prototype.populateButtons = function() {
        var e = this;
        t.each(e.buttons, function(t, n) {
            "function" == typeof e[n] && e[n]()
        })
    }, a.prototype.handleResizeImage = function() {
        var n = this;
        t("html").delegate(n.containerClass + " figure", "click", function(e) {
            e.stopPropagation(), t(this).addClass("is-resizable")
        }), t("html").delegate(n.containerClass + " figure.is-resizable", "mousemove", function(e) {
            t(this).find("img").css({
                width: t(this).width() + "px"
            })
        }), t(e).click(function() {
            t(n.elem).find("figure").removeClass("is-resizable")
        })
    }, a.prototype.getSelection = function() {
        if (n.getSelection) {
            var t = n.getSelection();
            if (t.rangeCount) return t
        }
        return !1
    }, a.prototype.removeFormatting = function(n) {
        var a = this,
            r = n.inFullArea;
        if (a.isSelectionOutsideOfEditor() === !0) return !1;
        if (r === !1) {
            var o = a.getSelection(),
                i = o.toString();
            if (o && i.length > 0) {
                var s = o.getRangeAt(0),
                    l = t(s.commonAncestorContainer.parentNode);
                if (l.attr("class") === a.className || l.attr("class") === a.className + "-wrapper") {
                    var c = e.createElement("span");
                    t(c).attr("data-value", "temp").html(i.replace(/\n/gi, "<br>")), s.deleteContents(), s.insertNode(c), t('[data-value="temp"]').contents().unwrap()
                } else {
                    var u, d = !1;
                    t.each(l.parentsUntil(a.elem), function(t, e) {
                        u = e, d = !0
                    }), d === !0 ? t(u).html(t(u).text().replace(/\n/gi, "<br>")).contents().unwrap() : l.contents().unwrap()
                }
            }
        } else t(a.elem).html(t(a.elem).text().replace(/\n/gi, "<br>"))
    }, a.prototype.removeEmptyTags = function() {
        var e = this;
        t(e.elem).html(t(e.elem).html().replace(/(<(?!\/)[^>]+>)+(<\/[^>]+>)+/, ""))
    }, a.prototype.removeBlockElementFromSelection = function(n, a) {
        var r;
        a = void 0 === a ? !1 : a;
        var o = "";
        a === !0 && (o = ", br");
        var i = n.getRangeAt(0),
            s = i.cloneContents(),
            l = e.createElement("temp");
        return t(l).html(s), t(l).find("h1, h2, h3, h4, h5, h6, p, div" + o).each(function() {
            t(this).replaceWith(this.childNodes)
        }), r = t(l).html()
    }, a.prototype.wrapSelectionWithNodeName = function(n) {
        var a = this;
        if (a.isSelectionOutsideOfEditor() === !0) return !1;
        var r = {
            name: "span",
            blockElement: !1,
            style: null,
            "class": null,
            attribute: null,
            keepHtml: !1
        };
        "string" == typeof n ? r.name = n : (r.name = n.nodeName || r.name, r.blockElement = n.blockElement || r.blockElement, r.style = n.style || r.style, r["class"] = n["class"] || r["class"], r.attribute = n.attribute || r.attribute, r.keepHtml = n.keepHtml || r.keepHtml);
        var o = a.getSelection();
        if (o && o.toString().length > 0 && o.rangeCount) {
            var i = a.isAlreadyWrapped(o, r),
                s = o.getRangeAt(0).cloneRange(),
                l = e.createElement(r.name);
            if ((null !== r.style || null !== r["class"] || null !== r.attribute) && (l = a.addAttribute(l, r)), a.selectionContainsHtml(s)) {
                if (s = o.getRangeAt(0), r.keepHtml === !0) {
                    var c = s.cloneContents(),
                        u = e.createElement("div");
                    u.appendChild(c), t(l).html(u.innerHTML)
                } else l.textContent = o.toString();
                s.deleteContents(), s.insertNode(l), s.commonAncestorContainer.localName === r.name && (t(s.commonAncestorContainer).contents().unwrap(), a.removeEmptyTags())
            } else s.surroundContents(l), o.removeAllRanges(), o.addRange(s);
            i === !0 && a.removeWrappedDuplicateTag(l), a.removeEmptyTags(), o.removeAllRanges()
        }
    }, a.prototype.wrapSelectionWithList = function(n) {
        var a = this;
        if (n = n || "ul", a.isSelectionOutsideOfEditor() === !0) return !1;
        var r = a.getSelection();
        if (r && r.toString().length > 0 && r.rangeCount) {
            var o = a.removeBlockElementFromSelection(r, !0),
                i = o.split("\n").filter(function(t) {
                    return "" !== t
                }),
                s = t.map(i, function(e) {
                    return "<li>" + t.trim(e) + "</li>"
                }),
                l = e.createElement(n);
            t(l).html(s);
            var c = r.getRangeAt(0);
            c.deleteContents(), c.insertNode(l), r.removeAllRanges()
        }
    }, a.prototype.selectionContainsHtml = function(t) {
        var e = this;
        return t.startContainer.parentNode.className === e.className + "-wrapper" ? !1 : !0
    }, a.prototype.isAlreadyWrapped = function(e, n) {
        var a = this,
            r = e.getRangeAt(0),
            o = t(r.commonAncestorContainer),
            i = !1;
        return o.parent().prop("tagName").toLowerCase() === n.name && o.parent().hasClass(a.className) === !1 ? i = !0 : n.blockElement === !0 ? t.each(o.parentsUntil(a.elem), function(e, n) {
            var a = n.tagName.toLowerCase(); - 1 !== t.inArray(a, ["h1", "h2", "h3", "h4", "h5", "h6"]) && (i = !0)
        }) : t.each(o.parentsUntil(a.elem), function(t, e) {
            var a = e.tagName.toLowerCase();
            a === n.name && (i = !0)
        }), i
    }, a.prototype.removeWrappedDuplicateTag = function(e) {
        var n = this,
            a = e.tagName;
        t(e).unwrap(), t(e).prop("tagName") === a && t(e).parent().hasClass(n.className) === !1 && t(e).parent().hasClass(n.className + "-wrapper") && t(e).unwrap()
    }, a.prototype.addAttribute = function(e, n) {
        return null !== n.style && t(e).attr("style", n.style), null !== n["class"] && t(e).addClass(n["class"]), null !== n.attribute && (t.isArray(n.attribute) === !0 ? t(e).attr(n.attribute[0], n.attribute[1]) : t(e).attr(n.attribute)), e
    }, a.prototype.insertAtCaret = function(e) {
        var n = this;
        if (n.isSelectionOutsideOfEditor() === !0) return !1;
        if (n.getSelection()) {
            var a = n.getSelection().getRangeAt(0);
            a.insertNode(e)
        } else t(e).appendTo(n.elem)
    }, a.prototype.isSelectionOutsideOfEditor = function() {
        return !this.elementContainsSelection(this.elem)
    }, a.prototype.isOrContains = function(t, e) {
        for (; t;) {
            if (t === e) return !0;
            t = t.parentNode
        }
        return !1
    }, a.prototype.elementContainsSelection = function(t) {
        var a, r = this;
        if (n.getSelection) {
            if (a = n.getSelection(), a.rangeCount > 0) {
                for (var o = 0; o < a.rangeCount; ++o)
                    if (!r.isOrContains(a.getRangeAt(o).commonAncestorContainer, t)) return !1;
                return !0
            }
        } else if ((a = e.selection) && "Control" !== a.type) return r.isOrContains(a.createRange().parentElement(), t);
        return !1
    }, a.prototype.insertHtml = function(e) {
        var n = this;
        t(n.elem).find("temp").html(e)
    }, a.prototype.utils = function() {
        var n = this;
        if (t("html").delegate("." + n.className + "-modal-close", "click", function(e) {
                e.preventDefault(), n.closeModal("#" + t(this).closest("." + n.className + "-modal").attr("id"))
            }), t("." + n.randomString + "-bind").length > 0) {
            var a;
            t("html").delegate(n.elem, "click keyup", function() {
                var e = n.elem;
                clearTimeout(a), a = setTimeout(function() {
                    t("." + n.randomString + "-bind").html(t(e).html())
                }, 250)
            })
        }
        t(e).click(function(e) {
            t("." + n.className).closest("." + n.className + "-wrapper").find("." + n.className + "-toolbar > ul > li > ul").hide()
        })
    }, a.prototype.getYoutubeVideoIdFromUrl = function(t) {
        if (0 === t.length) return !1;
        var e = "";
        return t = t.replace(/(>|<)/gi, "").split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/), void 0 !== t[2] ? (e = t[2].split(/[^0-9a-z_\-]/i), e = e[0]) : e = t, e
    }, a.prototype.openModal = function(n) {
        var a = e.createElement("temp");
        a.textContent = ".", this.insertAtCaret(a), t(n).removeClass("is-hidden")
    }, a.prototype.closeModal = function(e) {
        var n = this;
        t(e).addClass("is-hidden").find("input").val(""), t(e).find("." + n.className + "-modal-content-body-loader").css("width", "0");
        var a = t(this.elem).find("temp");
        "." === a.html() ? a.remove() : a.contents().unwrap(), t(this.elem).focus()
    }, a.prototype.bold = function() {
        var t = this,
            e = {
                buttonIdentifier: "bold",
                buttonHtml: "B",
                clickHandler: function() {
                    t.wrapSelectionWithNodeName({
                        nodeName: "strong",
                        keepHtml: !0
                    })
                }
            };
        t.injectButton(e)
    }, a.prototype.italic = function() {
        var t = this,
            e = {
                buttonIdentifier: "italic",
                buttonHtml: "I",
                clickHandler: function() {
                    t.wrapSelectionWithNodeName({
                        nodeName: "em",
                        keepHtml: !0
                    })
                }
            };
        t.injectButton(e)
    }, a.prototype.h2 = function() {
        var t = this,
            e = {
                buttonIdentifier: "header-2",
                buttonHtml: "H2",
                clickHandler: function() {
                    t.wrapSelectionWithNodeName({
                        nodeName: "h2",
                        blockElement: !0
                    })
                }
            };
        t.injectButton(e)
    }, a.prototype.h3 = function() {
        var t = this,
            e = {
                buttonIdentifier: "header-3",
                buttonHtml: "H3",
                clickHandler: function() {
                    t.wrapSelectionWithNodeName({
                        nodeName: "h3",
                        blockElement: !0
                    })
                }
            };
        t.injectButton(e)
    }, a.prototype.h4 = function() {
        var t = this,
            e = {
                buttonIdentifier: "header-4",
                buttonHtml: "H4",
                clickHandler: function() {
                    t.wrapSelectionWithNodeName({
                        nodeName: "h4",
                        blockElement: !0
                    })
                }
            };
        t.injectButton(e)
    }, a.prototype.x = function() {
        var t = this,
            e = {
                buttonIdentifier: "remove-formatting",
                buttonHtml: "x",
                clickHandler: function() {
                    t.removeFormatting({
                        inFullArea: !1
                    })
                }
            };
        t.injectButton(e)
    }, a.prototype.alignleft = function() {
        var t = this,
            e = {
                buttonIdentifier: "align-left",
                buttonHtml: "Align left",
                clickHandler: function() {
                    t.wrapSelectionWithNodeName({
                        nodeName: "p",
                        style: "text-align: left",
                        "class": "text-left",
                        keepHtml: !0
                    })
                }
            };
        t.injectButton(e)
    }, a.prototype.aligncenter = function() {
        var t = this,
            e = {
                buttonIdentifier: "align-center",
                buttonHtml: "Align center",
                clickHandler: function() {
                    t.wrapSelectionWithNodeName({
                        nodeName: "p",
                        style: "text-align: center",
                        "class": "text-center",
                        keepHtml: !0
                    })
                }
            };
        t.injectButton(e)
    }, a.prototype.alignright = function() {
        var t = this,
            e = {
                buttonIdentifier: "align-right",
                buttonHtml: "Align right",
                clickHandler: function() {
                    t.wrapSelectionWithNodeName({
                        nodeName: "p",
                        style: "text-align: right",
                        "class": "text-right",
                        keepHtml: !0
                    })
                }
            };
        t.injectButton(e)
    }, a.prototype.quote = function() {
        var t = this,
            e = {
                buttonIdentifier: "quote",
                buttonHtml: "Quote",
                clickHandler: function() {
                    t.wrapSelectionWithNodeName({
                        nodeName: "blockquote"
                    })
                }
            };
        t.injectButton(e)
    }, a.prototype.code = function() {
        var t = this,
            e = {
                buttonIdentifier: "code",
                buttonHtml: "Code",
                clickHandler: function() {
                    t.wrapSelectionWithNodeName({
                        nodeName: "pre"
                    })
                }
            };
        t.injectButton(e)
    }, a.prototype.link = function() {
        var t = this,
            e = {
                buttonIdentifier: "link",
                buttonHtml: "Link",
                clickHandler: function() {
                    t.wrapSelectionWithNodeName({
                        nodeName: "a",
                        attribute: ["href", prompt("Insert link", "")]
                    })
                }
            };
        t.injectButton(e)
    }, a.prototype.list = function() {
        var t = this,
            e = {
                buttonIdentifier: "list",
                buttonHtml: "List",
                clickHandler: function() {
                    t.wrapSelectionWithList()
                }
            };
        t.injectButton(e)
    }, a.prototype.source = function() {
        var e = this,
            n = {
                buttonIdentifier: "source",
                buttonHtml: "Source",
                clickHandler: function(n) {
                    var a, r = t(n).closest("." + e.className + "-wrapper"),
                        o = r.find("." + e.className);
                    t(n).hasClass("is-view-source-mode") ? (a = t("body > textarea." + e.className + "-temp"), o.css("visibility", "visible"), a.remove(), t(n).removeClass("is-view-source-mode")) : (t("body").append('<textarea class="' + e.className + '-temp" style="position: absolute; margin: 0;"></textarea>'), a = t("body > textarea." + e.className + "-temp"), a.css({
                        top: o.offset().top,
                        left: o.offset().left,
                        width: o.outerWidth(),
                        height: o.outerHeight()
                    }).html(o.html()), void 0 !== o.css("border") && a.css("border", o.css("border")), o.css("visibility", "hidden"), t(n).addClass("is-view-source-mode"), a.on("keyup click change keypress", function() {
                        o.html(t(this).val())
                    }))
                }
            };
        e.injectButton(n)
    }, n.EasyEditor = a, t.fn.easyEditor = function(e) {
        return this.each(function() {
            t.data(this, "plugin_easyEditor") || t.data(this, "plugin_easyEditor", new a(this, e))
        })
    }
}(jQuery, document, window), EasyEditor.prototype.image = function() {
    var t = this,
        e = {
            buttonIdentifier: "insert-image",
            buttonHtml: "Insert image",
            clickHandler: function() {
                t.openModal("#easyeditor-modal-1")
            }
        };
    t.injectButton(e)
}, EasyEditor.prototype.youtube = function() {
    var t = this,
        e = {
            buttonIdentifier: "insert-youtube-video",
            buttonHtml: "Insert youtube video",
            clickHandler: function() {
                var e = prompt("Insert youtube video link", ""),
                    n = t.getYoutubeVideoIdFromUrl(e);
                if (n.length > 0) {
                    var a = document.createElement("iframe");
                    $(a).attr({
                        width: "560",
                        height: "315",
                        frameborder: 0,
                        allowfullscreen: !0,
                        src: "https://www.youtube.com/embed/" + n
                    }), t.insertAtCaret(a)
                } else alert("Invalid YouTube URL!")
            }
        };
    t.injectButton(e)
}, jQuery(document).ready(function(t) {
    var e = new EasyEditor("#editor", {
        buttons: ["bold", "italic", "link", "h2", "h3", "h4", "alignleft", "aligncenter", "alignright", "quote", "code", "image", "youtube", "list", "x"]
    });
    var e_2 = new EasyEditor("#editor-2", {
        buttons: ["bold", "italic", "link", "h2", "h3", "h4", "alignleft", "aligncenter", "alignright", "quote", "code", "image", "youtube", "list", "x"]
    });
    var e_3 = new EasyEditor("#editor-3", {
        buttons: ["bold", "italic", "link", "h2", "h3", "h4", "alignleft", "aligncenter", "alignright", "quote", "code", "image", "youtube", "list", "x"]
    });
    $loader = t(".easyeditor-modal-content-body-loader"), t(".easyeditor-modal-content-body").find("form").ajaxForm({
        beforeSend: function() {
            $loader.css("width", "0%")
        },
        uploadProgress: function(t, e, n, a) {
            $loader.css("width", a + "%")
        },
        success: function() {
            $loader.css("width", "100%")
        },
        complete: function(t) {
            "null" != t.responseText && (e.insertHtml('<figure><img src="uploader_sdk/images/' + t.responseText + '" alt=""></figure>'), e.closeModal("#easyeditor-modal-1"))
        }
    });
    var n = t(".easyeditor-toolbar"),
        a = n.width(),
        r = n.offset().top - parseFloat(n.css("marginTop").replace(/auto/, 0));
    t(window).scroll(function(e) {
        var o = t(this).scrollTop();
        o >= r ? n.addClass("is-fixed").css("width", a + "px") : n.removeClass("is-fixed").css("width", "auto")
    })
});