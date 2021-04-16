(function() {
    for (var aa = "function" == typeof Object.defineProperties ? Object.defineProperty : function(a, b, c) {
        if (c.get || c.set) throw new TypeError("ES3 does not support getters and setters.");
        a != Array.prototype && a != Object.prototype && (a[b] = c.value)
    }, k = "undefined" != typeof window && window === this ? this : "undefined" != typeof global && null != global ? global : this, m = ["String", "prototype", "repeat"], n = 0; n < m.length - 1; n++) {
        var p = m[n];
        p in k || (k[p] = {});
        k = k[p]
    }
    var ba = m[m.length - 1],
        r = k[ba],
        t = r ? r : function(a) {
            var b;
            if (null == this) throw new TypeError("The 'this' value for String.prototype.repeat must not be null or undefined");
            b = this + "";
            if (0 > a || 1342177279 < a) throw new RangeError("Invalid count value");
            a |= 0;
            for (var c = ""; a;)
                if (a & 1 && (c += b), a >>>= 1) b += b;
            return c
        };
    t != r && null != t && aa(k, ba, {
        configurable: !0,
        writable: !0,
        value: t
    });
    var ca = this;

    function u(a) {
        return "string" == typeof a
    }

    function v(a, b) {
        var c = a.split("."),
            d = ca;
        c[0] in d || !d.execScript || d.execScript("var " + c[0]);
        for (var e; c.length && (e = c.shift());) c.length || void 0 === b ? d[e] ? d = d[e] : d = d[e] = {} : d[e] = b
    }

    function w(a, b) {
        function c() {}
        c.prototype = b.prototype;
        a.$ = b.prototype;
        a.prototype = new c;
        a.prototype.constructor = a;
        a.w = function(a, c, f) {
            for (var d = Array(arguments.length - 2), e = 2; e < arguments.length; e++) d[e - 2] = arguments[e];
            return b.prototype[c].apply(a, d)
        }
    };
    var x = Array.prototype.indexOf ? function(a, b, c) {
        return Array.prototype.indexOf.call(a, b, c)
    } : function(a, b, c) {
        c = null == c ? 0 : 0 > c ? Math.max(0, a.length + c) : c;
        if (u(a)) return u(b) && 1 == b.length ? a.indexOf(b, c) : -1;
        for (; c < a.length; c++)
            if (c in a && a[c] === b) return c;
        return -1
    };

    function da(a, b) {
        a.sort(b || ea)
    }

    function ea(a, b) {
        return a > b ? 1 : a < b ? -1 : 0
    };

    function fa(a, b) {
        this.a = a;
        this.h = !!b.i;
        this.c = b.b;
        this.m = b.type;
        this.l = !1;
        switch (this.c) {
            case ga:
            case ha:
            case ia:
            case ja:
            case ka:
            case la:
            case ma:
                this.l = !0
        }
        this.g = b.defaultValue
    }
    var ma = 1,
        la = 2,
        ga = 3,
        ha = 4,
        ia = 6,
        ja = 16,
        ka = 18;

    function na(a) {
        var b = [],
            c = 0,
            d;
        for (d in a) b[c++] = a[d];
        return b
    };

    function oa(a, b) {
        this.c = a;
        this.a = {};
        for (var c = 0; c < b.length; c++) {
            var d = b[c];
            this.a[d.a] = d
        }
    }

    function pa(a) {
        a = na(a.a);
        da(a, function(a, c) {
            return a.a - c.a
        });
        return a
    };

    function y() {
        this.a = {};
        this.g = this.f().a;
        this.c = this.h = null
    }
    y.prototype.has = function(a) {
        return null != this.a[a.a]
    };
    y.prototype.get = function(a, b) {
        return A(this, a.a, b)
    };
    y.prototype.set = function(a, b) {
        B(this, a.a, b)
    };

    function qa(a, b) {
        for (var c = pa(a.f()), d = 0; d < c.length; d++) {
            var e = c[d],
                f = e.a;
            if (null != b.a[f]) {
                a.c && delete a.c[e.a];
                var g = 11 == e.c || 10 == e.c;
                if (e.h)
                    for (var e = C(b, f) || [], h = 0; h < e.length; h++) {
                        var l = a,
                            q = f,
                            z = g ? e[h].clone() : e[h];
                        l.a[q] || (l.a[q] = []);
                        l.a[q].push(z);
                        l.c && delete l.c[q]
                    } else e = C(b, f), g ? (g = C(a, f)) ? qa(g, e) : B(a, f, e.clone()) : B(a, f, e)
            }
        }
    }
    y.prototype.clone = function() {
        var a = new this.constructor;
        a != this && (a.a = {}, a.c && (a.c = {}), qa(a, this));
        return a
    };

    function C(a, b) {
        var c = a.a[b];
        if (null == c) return null;
        if (a.h) {
            if (!(b in a.c)) {
                var d = a.h,
                    e = a.g[b];
                if (null != c)
                    if (e.h) {
                        for (var f = [], g = 0; g < c.length; g++) f[g] = d.a(e, c[g]);
                        c = f
                    } else c = d.a(e, c);
                return a.c[b] = c
            }
            return a.c[b]
        }
        return c
    }

    function A(a, b, c) {
        var d = C(a, b);
        return a.g[b].h ? d[c || 0] : d
    }

    function D(a, b) {
        var c;
        if (null != a.a[b]) c = A(a, b, void 0);
        else a: {
            c = a.g[b];
            if (void 0 === c.g) {
                var d = c.m;
                if (d === Boolean) c.g = !1;
                else if (d === Number) c.g = 0;
                else if (d === String) c.g = c.l ? "0" : "";
                else {
                    c = new d;
                    break a
                }
            }
            c = c.g
        }
        return c
    }

    function ra(a, b) {
        return a.g[b].h ? null != a.a[b] ? a.a[b].length : 0 : null != a.a[b] ? 1 : 0
    }

    function B(a, b, c) {
        a.a[b] = c;
        a.c && (a.c[b] = c)
    }

    function E(a, b) {
        var c = [],
            d;
        for (d in b) 0 != d && c.push(new fa(d, b[d]));
        return new oa(a, c)
    };

    function F() {}
    F.prototype.c = function(a) {
        new a.c;
        throw Error("Unimplemented");
    };
    F.prototype.a = function(a, b) {
        if (11 == a.c || 10 == a.c) return b instanceof y ? b : this.c(a.m.prototype.f(), b);
        if (14 == a.c) {
            if (u(b) && sa.test(b)) {
                var c = Number(b);
                if (0 < c) return c
            }
            return b
        }
        if (!a.l) return b;
        c = a.m;
        if (c === String) {
            if ("number" == typeof b) return String(b)
        } else if (c === Number && u(b) && ("Infinity" === b || "-Infinity" === b || "NaN" === b || sa.test(b))) return Number(b);
        return b
    };
    var sa = /^-?[0-9]+$/;

    function G() {}
    w(G, F);
    G.prototype.c = function(a, b) {
        var c = new a.c;
        c.h = this;
        c.a = b;
        c.c = {};
        return c
    };

    function H() {}
    w(H, G);
    H.prototype.a = function(a, b) {
        return 8 == a.c ? !!b : F.prototype.a.apply(this, arguments)
    };

    function I(a, b) {
        null != a && this.a.apply(this, arguments)
    }
    I.prototype.c = "";
    I.prototype.set = function(a) {
        this.c = "" + a
    };
    I.prototype.a = function(a, b, c) {
        this.c += String(a);
        if (null != b)
            for (var d = 1; d < arguments.length; d++) this.c += arguments[d];
        return this
    };
    I.prototype.toString = function() {
        return this.c
    };
    /*

     Protocol Buffer 2 Copyright 2008 Google Inc.
     All other code copyright its respective owners.
     Copyright (C) 2010 The Libphonenumber Authors

     Licensed under the Apache License, Version 2.0 (the "License");
     you may not use this file except in compliance with the License.
     You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

     Unless required by applicable law or agreed to in writing, software
     distributed under the License is distributed on an "AS IS" BASIS,
     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     See the License for the specific language governing permissions and
     limitations under the License.
    */
    function J() {
        y.call(this)
    }
    w(J, y);
    var ta = null;

    function K() {
        y.call(this)
    }
    w(K, y);
    var ua = null;

    function L() {
        y.call(this)
    }
    w(L, y);
    var wa = null;
    J.prototype.f = function() {
        var a = ta;
        a || (ta = a = E(J, {
            0: {
                name: "NumberFormat",
                j: "i18n.phonenumbers.NumberFormat"
            },
            1: {
                name: "pattern",
                required: !0,
                b: 9,
                type: String
            },
            2: {
                name: "format",
                required: !0,
                b: 9,
                type: String
            },
            3: {
                name: "leading_digits_pattern",
                i: !0,
                b: 9,
                type: String
            },
            4: {
                name: "national_prefix_formatting_rule",
                b: 9,
                type: String
            },
            6: {
                name: "national_prefix_optional_when_formatting",
                b: 8,
                type: Boolean
            },
            5: {
                name: "domestic_carrier_code_formatting_rule",
                b: 9,
                type: String
            }
        }));
        return a
    };
    J.f = J.prototype.f;
    K.prototype.f = function() {
        var a = ua;
        a || (ua = a = E(K, {
            0: {
                name: "PhoneNumberDesc",
                j: "i18n.phonenumbers.PhoneNumberDesc"
            },
            2: {
                name: "national_number_pattern",
                b: 9,
                type: String
            },
            3: {
                name: "possible_number_pattern",
                b: 9,
                type: String
            },
            9: {
                name: "possible_length",
                i: !0,
                b: 5,
                type: Number
            },
            10: {
                name: "possible_length_local_only",
                i: !0,
                b: 5,
                type: Number
            },
            6: {
                name: "example_number",
                b: 9,
                type: String
            },
            7: {
                name: "national_number_matcher_data",
                b: 12,
                type: String
            },
            8: {
                name: "possible_number_matcher_data",
                b: 12,
                type: String
            }
        }));
        return a
    };
    K.f = K.prototype.f;
    L.prototype.f = function() {
        var a = wa;
        a || (wa = a = E(L, {
            0: {
                name: "PhoneMetadata",
                j: "i18n.phonenumbers.PhoneMetadata"
            },
            1: {
                name: "general_desc",
                b: 11,
                type: K
            },
            2: {
                name: "fixed_line",
                b: 11,
                type: K
            },
            3: {
                name: "mobile",
                b: 11,
                type: K
            },
            4: {
                name: "toll_free",
                b: 11,
                type: K
            },
            5: {
                name: "premium_rate",
                b: 11,
                type: K
            },
            6: {
                name: "shared_cost",
                b: 11,
                type: K
            },
            7: {
                name: "personal_number",
                b: 11,
                type: K
            },
            8: {
                name: "voip",
                b: 11,
                type: K
            },
            21: {
                name: "pager",
                b: 11,
                type: K
            },
            25: {
                name: "uan",
                b: 11,
                type: K
            },
            27: {
                name: "emergency",
                b: 11,
                type: K
            },
            28: {
                name: "voicemail",
                b: 11,
                type: K
            },
            24: {
                name: "no_international_dialling",
                b: 11,
                type: K
            },
            9: {
                name: "id",
                required: !0,
                b: 9,
                type: String
            },
            10: {
                name: "country_code",
                b: 5,
                type: Number
            },
            11: {
                name: "international_prefix",
                b: 9,
                type: String
            },
            17: {
                name: "preferred_international_prefix",
                b: 9,
                type: String
            },
            12: {
                name: "national_prefix",
                b: 9,
                type: String
            },
            13: {
                name: "preferred_extn_prefix",
                b: 9,
                type: String
            },
            15: {
                name: "national_prefix_for_parsing",
                b: 9,
                type: String
            },
            16: {
                name: "national_prefix_transform_rule",
                b: 9,
                type: String
            },
            18: {
                name: "same_mobile_and_fixed_line_pattern",
                b: 8,
                defaultValue: !1,
                type: Boolean
            },
            19: {
                name: "number_format",
                i: !0,
                b: 11,
                type: J
            },
            20: {
                name: "intl_number_format",
                i: !0,
                b: 11,
                type: J
            },
            22: {
                name: "main_country_for_code",
                b: 8,
                defaultValue: !1,
                type: Boolean
            },
            23: {
                name: "leading_digits",
                b: 9,
                type: String
            },
            26: {
                name: "leading_zero_possible",
                b: 8,
                defaultValue: !1,
                type: Boolean
            }
        }));
        return a
    };
    L.f = L.prototype.f;

    function M() {
        y.call(this)
    }
    var N;
    w(M, y);
    var xa = {
        v: 1,
        u: 5,
        s: 10,
        o: 20
    };
    M.prototype.f = function() {
        N || (N = E(M, {
            0: {
                name: "PhoneNumber",
                j: "i18n.phonenumbers.PhoneNumber"
            },
            1: {
                name: "country_code",
                required: !0,
                b: 5,
                type: Number
            },
            2: {
                name: "national_number",
                required: !0,
                b: 4,
                type: Number
            },
            3: {
                name: "extension",
                b: 9,
                type: String
            },
            4: {
                name: "italian_leading_zero",
                b: 8,
                type: Boolean
            },
            8: {
                name: "number_of_leading_zeros",
                b: 5,
                defaultValue: 1,
                type: Number
            },
            5: {
                name: "raw_input",
                b: 9,
                type: String
            },
            6: {
                name: "country_code_source",
                b: 14,
                defaultValue: 1,
                type: xa
            },
            7: {
                name: "preferred_domestic_carrier_code",
                b: 9,
                type: String
            }
        }));
        return N
    };
    M.ctor = M;
    M.ctor.f = M.prototype.f;
    /*

     Copyright (C) 2010 The Libphonenumber Authors

     Licensed under the Apache License, Version 2.0 (the "License");
     you may not use this file except in compliance with the License.
     You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

     Unless required by applicable law or agreed to in writing, software
     distributed under the License is distributed on an "AS IS" BASIS,
     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     See the License for the specific language governing permissions and
     limitations under the License.
    */
    var O = {
            1: "US AG AI AS BB BM BS CA DM DO GD GU JM KN KY LC MP MS PR SX TC TT VC VG VI".split(" "),
            7: ["RU", "KZ"],
            31: ["NL"],
            44: ["GB", "GG", "IM", "JE"],
            90: ["TR"],
            98: ["IR"],
            994: ["AZ"],
            995: ["GE"],

        },
        ya = {
            AZ: [, [, , "[1-9]\\d{8}", , , , , , , [9],
                [7]
            ],
                [, , "(?:1[28]\\d{3}|2(?:02|1[24]|2[2-4]|33|[45]2|6[23])\\d{2}|365(?:[0-46-9]\\d|5[0-35-9]))\\d{4}", , , , "123123456"],
                [, , "(?:36554|(?:4[04]|5[015]|60|7[07])\\d{3})\\d{4}", , , , "401234567"],
                [, , "88\\d{7}", , , , "881234567"],
                [, , "900200\\d{3}", , , , "900200123"],
                [, , "NA", , , , , , , [-1]],
                [, , "NA", , , , , , , [-1]],
                [, , "NA", , , , , , , [-1]], "AZ", 994, "00", "0", , , "0", , , , [
                    [, "(\\d{2})(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["(?:1[28]|2(?:[45]2|[0-36])|365)"], "(0$1)"],
                    [, "(\\d{2})(\\d{3})(\\d{2})(\\d{2})",
                        "$1 $2 $3 $4", ["[4-8]"], "0$1"
                    ],
                    [, "(\\d{3})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["9"], "0$1"]
                ], , [, , "NA", , , , , , , [-1]], , , [, , "NA", , , , , , , [-1]],
                [, , "NA", , , , , , , [-1]], , , [, , "NA", , , , , , , [-1]]
            ],
            GE: [, [, , "[34578]\\d{8}", , , , , , , [9],
                [6]
            ],
                [, , "(?:3(?:[256]\\d|4[124-9]|7[0-4])|4(?:1\\d|2[2-7]|3[1-79]|4[2-8]|7[239]|9[1-7]))\\d{6}", , , , "322123456"],
                [, , "5(?:14|5[01578]|68|7[0147-9]|9[0-35-9])\\d{6}", , , , "555123456"],
                [, , "800\\d{6}", , , , "800123456"],
                [, , "NA", , , , , , , [-1]],
                [, , "NA", , , , , , , [-1]],
                [, , "NA", , , , , , , [-1]],
                [, , "706\\d{6}", , , , "706123456"], "GE", 995, "00", "0", , , "0", , , , [
                    [, "(\\d{3})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["[348]"], "0$1"],
                    [, "(\\d{3})(\\d{3})(\\d{3})",
                        "$1 $2 $3", ["7"], "0$1"
                    ],
                    [, "(\\d{3})(\\d{2})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["5"], "$1"]
                ], , [, , "NA", , , , , , , [-1]], , , [, , "706\\d{6}", , , , "706123456"],
                [, , "NA", , , , , , , [-1]], , , [, , "NA", , , , , , , [-1]]
            ],
            IR: [, [, , "[1-8]\\d{9}|9(?:[0-4]\\d{8}|9\\d{2,8})", , , , , , , [4, 5, 6, 7, 8, 9, 10]],
                [, , "(?:(?:1[137]|2[13-68]|3[1458]|4[145]|5[1468]|6[16]|7[1467]|8[13467])\\d{3}|94(?:000|2\\d{2}))\\d{5}", , , , "2123456789", , , [10]],
                [, , "9(?:0[1-3]|[1-3]\\d|90)\\d{7}", , , , "9123456789", , , [10]],
                [, , "NA", , , , , , ,
                    [-1]
                ],
                [, , "NA", , , , , , , [-1]],
                [, , "NA", , , , , , , [-1]],
                [, , "NA", , , , , , , [-1]],
                [, , "(?:[2-6]0\\d|993)\\d{7}", , , , "9932123456", , , [10]], "IR", 98, "00", "0", , , "0", , , , [
                    [, "(21)(\\d{3,5})", "$1 $2", ["21"], "0$1"],
                    [, "(\\d{2})(\\d{4})(\\d{4})", "$1 $2 $3", ["[1-8]"], "0$1"],
                    [, "(\\d{3})(\\d{3})", "$1 $2", ["9"], "0$1"],
                    [, "(\\d{3})(\\d{2})(\\d{2,3})", "$1 $2 $3", ["9"], "0$1"],
                    [, "(\\d{3})(\\d{3})(\\d{3,4})", "$1 $2 $3", ["9"], "0$1"]
                ], , [, , "943\\d{7}", , , , "9432123456", , , [10]], , , [, , "NA", , , , , , , [-1]],
                [, , "9990\\d{0,6}", , , , "9990123456"], , , [, , "NA", , , , , , , [-1]]
            ],
            RU: [, [, , "[3489]\\d{9}", , , , , , , [10]],
                [, , "(?:3(?:0[12]|4[1-35-79]|5[1-3]|65|8[1-58]|9[0145])|4(?:01|1[1356]|2[13467]|7[1-5]|8[1-7]|9[1-689])|8(?:1[1-8]|2[01]|3[13-6]|4[0-8]|5[15]|6[1-35-79]|7[1-37-9]))\\d{7}", , , , "3011234567"],
                [, , "9\\d{9}", , , , "9123456789"],
                [, , "80[04]\\d{7}", , , , "8001234567"],
                [, , "80[39]\\d{7}", , , , "8091234567"],
                [, , "NA", , , , , , , [-1]],
                [, , "NA", , , , , , , [-1]],
                [, , "NA", , , , , , , [-1]], "RU", 7, "810", "8", , , "8", , "8~10", , [
                    [, "(\\d{3})(\\d{2})(\\d{2})", "$1-$2-$3", ["[1-79]"], "$1", , 1],
                    [, "([3489]\\d{2})(\\d{3})(\\d{2})(\\d{2})", "$1 $2-$3-$4", ["[34689]"], "8 ($1)", , 1],
                    [, "(7\\d{2})(\\d{3})(\\d{4})", "$1 $2 $3", ["7"], "8 ($1)", , 1]
                ],
                [
                    [, "([3489]\\d{2})(\\d{3})(\\d{2})(\\d{2})", "$1 $2-$3-$4", ["[34689]"], "8 ($1)", , 1],
                    [, "(7\\d{2})(\\d{3})(\\d{4})", "$1 $2 $3", ["7"], "8 ($1)", , 1]
                ],
                [, , "NA", , , , , , , [-1]], 1, , [, , "NA", , , , , , , [-1]],
                [, , "NA", , , , , , , [-1]], , , [, , "NA", , , , , , , [-1]]
            ],
            TR: [, [, , "[2-589]\\d{9}|444\\d{4}", , , , , , , [7, 10]],
                [, , "(?:2(?:[13][26]|[28][2468]|[45][268]|[67][246])|3(?:[13][28]|[24-6][2468]|[78][02468]|92)|4(?:[16][246]|[23578][2468]|4[26]))\\d{7}", , , , "2123456789", , , [10]],
                [, , "5(?:(?:0[1-7]|22|[34]\\d|5[1-59]|9[246])\\d{2}|6161)\\d{5}", , , , "5012345678", , , [10]],
                [, , "800\\d{7}", , , , "8001234567", , , [10]],
                [, , "900\\d{7}", , , , "9001234567", , , [10]],
                [, , "NA", , , , , , , [-1]],
                [, , "NA", , , , , , , [-1]],
                [, , "NA", , , , , , , [-1]], "TR", 90, "00", "0", , , "0", , , , [
                    [, "(\\d{3})(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["[23]|4(?:[0-35-9]|4[0-35-9])"], "(0$1)", , 1],
                    [, "(\\d{3})(\\d{3})(\\d{2})(\\d{2})", "$1 $2 $3 $4", ["5[02-69]"], "0$1", , 1],
                    [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["51|[89]"], "0$1", , 1],
                    [, "(444)(\\d{1})(\\d{3})", "$1 $2 $3", ["444"]]
                ], , [, , "512\\d{7}", , , , "5123456789", , , [10]], , , [, , "444\\d{4}", , , , "4441444", , , [7]],
                [, , "444\\d{4}|850\\d{7}", , , , "4441444"], , , [, , "NA", , , , , , , [-1]]
            ],
            GB: [, [, , "\\d{7,10}", , , , , , , [7, 9, 10],
                [4, 5, 6, 8]
            ],
                [, , "2(?:0[01378]|3[0189]|4[017]|8[0-46-9]|9[012])\\d{7}|1(?:(?:1(?:3[0-48]|[46][0-4]|5[012789]|7[0-49]|8[01349])|21[0-7]|31[0-8]|[459]1\\d|61[0-46-9]))\\d{6}|1(?:2(?:0[024-9]|2[3-9]|3[3-79]|4[1-689]|[58][02-9]|6[0-4789]|7[013-9]|9\\d)|3(?:0\\d|[25][02-9]|3[02-579]|[468][0-46-9]|7[1235679]|9[24578])|4(?:0[03-9]|[28][02-5789]|[37]\\d|4[02-69]|5[0-8]|[69][0-79])|5(?:0[1235-9]|2[024-9]|3[015689]|4[02-9]|5[03-9]|6\\d|7[0-35-9]|8[0-468]|9[0-5789])|6(?:0[034689]|2[0-35689]|[38][013-9]|4[1-467]|5[0-69]|6[13-9]|7[0-8]|9[0124578])|7(?:0[0246-9]|2\\d|3[023678]|4[03-9]|5[0-46-9]|6[013-9]|7[0-35-9]|8[024-9]|9[02-9])|8(?:0[35-9]|2[1-5789]|3[02-578]|4[0-578]|5[124-9]|6[2-69]|7\\d|8[02-9]|9[02569])|9(?:0[02-589]|2[02-689]|3[1-5789]|4[2-9]|5[0-579]|6[234789]|7[0124578]|8\\d|9[2-57]))\\d{6}|1(?:2(?:0(?:46[1-4]|87[2-9])|545[1-79]|76(?:2\\d|3[1-8]|6[1-6])|9(?:7(?:2[0-4]|3[2-5])|8(?:2[2-8]|7[0-4789]|8[345])))|3(?:638[2-5]|647[23]|8(?:47[04-9]|64[015789]))|4(?:044[1-7]|20(?:2[23]|8\\d)|6(?:0(?:30|5[2-57]|6[1-8]|7[2-8])|140)|8(?:052|87[123]))|5(?:24(?:3[2-79]|6\\d)|276\\d|6(?:26[06-9]|686))|6(?:06(?:4\\d|7[4-79])|295[567]|35[34]\\d|47(?:24|61)|59(?:5[08]|6[67]|74)|955[0-4])|7(?:26(?:6[13-9]|7[0-7])|442\\d|50(?:2[0-3]|[3-68]2|76))|8(?:27[56]\\d|37(?:5[2-5]|8[239])|84(?:3[2-58]))|9(?:0(?:0(?:6[1-8]|85)|52\\d)|3583|4(?:66[1-8]|9(?:2[01]|81))|63(?:23|3[1-4])|9561))\\d{3}|176888[234678]\\d{2}|16977[23]\\d{3}", , , , "1212345678", , , [9, 10]],
                [, , "7(?:[1-4]\\d\\d|5(?:0[0-8]|[13-9]\\d|2[0-35-9])|7(?:0[1-9]|[1-7]\\d|8[02-9]|9[0-689])|8(?:[014-9]\\d|[23][0-8])|9(?:[04-9]\\d|1[02-9]|2[0-35-9]|3[0-689]))\\d{6}", , , , "7400123456", , , [10]],
                [, , "80(?:0(?:1111|\\d{6,7})|8\\d{7})|500\\d{6}", , , , "8001234567"],
                [, , "(?:87[123]|9(?:[01]\\d|8[2349]))\\d{7}", , , , "9012345678", , , [10]],
                [, , "8(?:4(?:5464\\d|[2-5]\\d{7})|70\\d{7})", , , , "8431234567", , , [7, 10]],
                [, , "70\\d{8}", , , , "7012345678", , , [10]],
                [, , "56\\d{8}", , , , "5612345678", , , [10]], "GB", 44,
                "00", "0", " x", , "0", , , , [
                    [, "(\\d{2})(\\d{4})(\\d{4})", "$1 $2 $3", ["2|5[56]|7(?:0|6[013-9])", "2|5[56]|7(?:0|6(?:[013-9]|2[0-35-9]))"], "0$1"],
                    [, "(\\d{3})(\\d{3})(\\d{4})", "$1 $2 $3", ["1(?:1|\\d1)|3|9[018]"], "0$1"],
                    [, "(\\d{5})(\\d{4,5})", "$1 $2", ["1(?:38|5[23]|69|76|94)", "1(?:387|5(?:24|39)|697|768|946)", "1(?:3873|5(?:242|39[456])|697[347]|768[347]|9467)"], "0$1"],
                    [, "(1\\d{3})(\\d{5,6})", "$1 $2", ["1"], "0$1"],
                    [, "(7\\d{3})(\\d{6})", "$1 $2", ["7(?:[1-5789]|62)", "7(?:[1-5789]|624)"], "0$1"],
                    [, "(800)(\\d{4})",
                        "$1 $2", ["800", "8001", "80011", "800111", "8001111"], "0$1"
                    ],
                    [, "(845)(46)(4\\d)", "$1 $2 $3", ["845", "8454", "84546", "845464"], "0$1"],
                    [, "(8\\d{2})(\\d{3})(\\d{4})", "$1 $2 $3", ["8(?:4[2-5]|7[0-3])"], "0$1"],
                    [, "(80\\d)(\\d{3})(\\d{4})", "$1 $2 $3", ["80"], "0$1"],
                    [, "([58]00)(\\d{6})", "$1 $2", ["[58]00"], "0$1"]
                ], , [, , "76(?:0[012]|2[356]|4[0134]|5[49]|6[0-369]|77|81|9[39])\\d{6}", , , , "7640123456", , , [10]], 1, , [, , "NA", , , , , , , [-1]],
                [, , "(?:3[0347]|55)\\d{8}", , , , "5512345678", , , [10]], , , [, , "NA", , , , , , , [-1]]
            ],
            US: [, [, , "[2-9]\\d{9}", , , , , , , [10],
                [7]
            ],
                [, , "(?:2(?:0[1-35-9]|1[02-9]|2[04589]|3[149]|4[08]|5[1-46]|6[0279]|7[026]|8[13])|3(?:0[1-57-9]|1[02-9]|2[0135]|3[014679]|4[67]|5[12]|6[014]|8[056])|4(?:0[124-9]|1[02-579]|2[3-5]|3[0245]|4[0235]|58|6[39]|7[0589]|8[04])|5(?:0[1-57-9]|1[0235-8]|20|3[0149]|4[01]|5[19]|6[1-37]|7[013-5]|8[056])|6(?:0[1-35-9]|1[024-9]|2[03689]|3[016]|4[16]|5[017]|6[0-279]|78|8[12])|7(?:0[1-46-8]|1[02-9]|2[0457]|3[1247]|4[037]|5[47]|6[02359]|7[02-59]|8[156])|8(?:0[1-68]|1[02-8]|28|3[0-25]|4[3578]|5[046-9]|6[02-5]|7[028])|9(?:0[1346-9]|1[02-9]|2[0589]|3[014678]|4[0179]|5[12469]|7[0-3589]|8[0459]))[2-9]\\d{6}", , , , "2015550123"],
                [, , "(?:2(?:0[1-35-9]|1[02-9]|2[04589]|3[149]|4[08]|5[1-46]|6[0279]|7[026]|8[13])|3(?:0[1-57-9]|1[02-9]|2[0135]|3[014679]|4[67]|5[12]|6[014]|8[056])|4(?:0[124-9]|1[02-579]|2[3-5]|3[0245]|4[0235]|58|6[39]|7[0589]|8[04])|5(?:0[1-57-9]|1[0235-8]|20|3[0149]|4[01]|5[19]|6[1-37]|7[013-5]|8[056])|6(?:0[1-35-9]|1[024-9]|2[03689]|3[016]|4[16]|5[017]|6[0-279]|78|8[12])|7(?:0[1-46-8]|1[02-9]|2[0457]|3[1247]|4[037]|5[47]|6[02359]|7[02-59]|8[156])|8(?:0[1-68]|1[02-8]|28|3[0-25]|4[3578]|5[046-9]|6[02-5]|7[028])|9(?:0[1346-9]|1[02-9]|2[0589]|3[014678]|4[0179]|5[12469]|7[0-3589]|8[0459]))[2-9]\\d{6}", , , , "2015550123"],
                [, , "8(?:00|44|55|66|77|88)[2-9]\\d{6}", , , , "8002345678"],
                [, , "900[2-9]\\d{6}", , , , "9002345678"],
                [, , "NA", , , , , , , [-1]],
                [, , "5(?:00|22|33|44|66|77|88)[2-9]\\d{6}", , , , "5002345678"],
                [, , "NA", , , , , , , [-1]], "US", 1, "011", "1", , , "1", , , 1, [
                    [, "(\\d{3})(\\d{4})", "$1-$2", , , , 1],
                    [, "(\\d{3})(\\d{3})(\\d{4})", "($1) $2-$3", , , , 1]
                ],
                [
                    [, "(\\d{3})(\\d{3})(\\d{4})", "$1-$2-$3"]
                ],
                [, , "NA", , , , , , , [-1]], 1, , [, , "NA", , , , , , , [-1]],
                [, , "NA", , , , , , , [-1]], , , [, , "NA", , , , , , , [-1]]
            ],
        };
    /*

     Copyright (C) 2010 The Libphonenumber Authors.

     Licensed under the Apache License, Version 2.0 (the "License");
     you may not use this file except in compliance with the License.
     You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

     Unless required by applicable law or agreed to in writing, software
     distributed under the License is distributed on an "AS IS" BASIS,
     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     See the License for the specific language governing permissions and
     limitations under the License.
    */
    function P() {
        this.a = {}
    }
    P.a = function() {
        return P.c ? P.c : P.c = new P
    };
    var za = {
            0: "0",
            1: "1",
            2: "2",
            3: "3",
            4: "4",
            5: "5",
            6: "6",
            7: "7",
            8: "8",
            9: "9",
            "\uff10": "0",
            "\uff11": "1",
            "\uff12": "2",
            "\uff13": "3",
            "\uff14": "4",
            "\uff15": "5",
            "\uff16": "6",
            "\uff17": "7",
            "\uff18": "8",
            "\uff19": "9",
            "\u0660": "0",
            "\u0661": "1",
            "\u0662": "2",
            "\u0663": "3",
            "\u0664": "4",
            "\u0665": "5",
            "\u0666": "6",
            "\u0667": "7",
            "\u0668": "8",
            "\u0669": "9",
            "\u06f0": "0",
            "\u06f1": "1",
            "\u06f2": "2",
            "\u06f3": "3",
            "\u06f4": "4",
            "\u06f5": "5",
            "\u06f6": "6",
            "\u06f7": "7",
            "\u06f8": "8",
            "\u06f9": "9"
        },
        Aa = {
            0: "0",
            1: "1",
            2: "2",
            3: "3",
            4: "4",
            5: "5",
            6: "6",
            7: "7",
            8: "8",
            9: "9",
            "\uff10": "0",
            "\uff11": "1",
            "\uff12": "2",
            "\uff13": "3",
            "\uff14": "4",
            "\uff15": "5",
            "\uff16": "6",
            "\uff17": "7",
            "\uff18": "8",
            "\uff19": "9",
            "\u0660": "0",
            "\u0661": "1",
            "\u0662": "2",
            "\u0663": "3",
            "\u0664": "4",
            "\u0665": "5",
            "\u0666": "6",
            "\u0667": "7",
            "\u0668": "8",
            "\u0669": "9",
            "\u06f0": "0",
            "\u06f1": "1",
            "\u06f2": "2",
            "\u06f3": "3",
            "\u06f4": "4",
            "\u06f5": "5",
            "\u06f6": "6",
            "\u06f7": "7",
            "\u06f8": "8",
            "\u06f9": "9",
            A: "2",
            B: "2",
            C: "2",
            D: "3",
            E: "3",
            F: "3",
            G: "4",
            H: "4",
            I: "4",
            J: "5",
            K: "5",
            L: "5",
            M: "6",
            N: "6",
            O: "6",
            P: "7",
            Q: "7",
            R: "7",
            S: "7",
            T: "8",
            U: "8",
            V: "8",
            W: "9",
            X: "9",
            Y: "9",
            Z: "9"
        },
        Q = RegExp("^[+\uff0b]+"),
        Ba = RegExp("([0-9\uff10-\uff19\u0660-\u0669\u06f0-\u06f9])"),
        Ca = RegExp("[+\uff0b0-9\uff10-\uff19\u0660-\u0669\u06f0-\u06f9]"),
        Da = /[\\\/] *x/,
        Ea = RegExp("[^0-9\uff10-\uff19\u0660-\u0669\u06f0-\u06f9A-Za-z#]+$"),
        Fa = /(?:.*?[A-Za-z]){3}.*/,
        Ga = RegExp("(?:;ext=([0-9\uff10-\uff19\u0660-\u0669\u06f0-\u06f9]{1,7})|[ \u00a0\\t,]*(?:e?xt(?:ensi(?:o\u0301?|\u00f3))?n?|\uff45?\uff58\uff54\uff4e?|[;,x\uff58#\uff03~\uff5e]|int|anexo|\uff49\uff4e\uff54)[:\\.\uff0e]?[ \u00a0\\t,-]*([0-9\uff10-\uff19\u0660-\u0669\u06f0-\u06f9]{1,7})#?|[- ]+([0-9\uff10-\uff19\u0660-\u0669\u06f0-\u06f9]{1,5})#)$",
            "i"),
        Ha = RegExp("^[0-9\uff10-\uff19\u0660-\u0669\u06f0-\u06f9]{2}$|^[+\uff0b]*(?:[-x\u2010-\u2015\u2212\u30fc\uff0d-\uff0f \u00a0\u00ad\u200b\u2060\u3000()\uff08\uff09\uff3b\uff3d.\\[\\]/~\u2053\u223c\uff5e*]*[0-9\uff10-\uff19\u0660-\u0669\u06f0-\u06f9]){3,}[-x\u2010-\u2015\u2212\u30fc\uff0d-\uff0f \u00a0\u00ad\u200b\u2060\u3000()\uff08\uff09\uff3b\uff3d.\\[\\]/~\u2053\u223c\uff5e*A-Za-z0-9\uff10-\uff19\u0660-\u0669\u06f0-\u06f9]*(?:;ext=([0-9\uff10-\uff19\u0660-\u0669\u06f0-\u06f9]{1,7})|[ \u00a0\\t,]*(?:e?xt(?:ensi(?:o\u0301?|\u00f3))?n?|\uff45?\uff58\uff54\uff4e?|[;,x\uff58#\uff03~\uff5e]|int|anexo|\uff49\uff4e\uff54)[:\\.\uff0e]?[ \u00a0\\t,-]*([0-9\uff10-\uff19\u0660-\u0669\u06f0-\u06f9]{1,7})#?|[- ]+([0-9\uff10-\uff19\u0660-\u0669\u06f0-\u06f9]{1,5})#)?$",
            "i"),
        Ia = /(\$\d)/;

    function Ja(a) {
        var b = a.search(Ca);
        0 <= b ? (a = a.substring(b), a = a.replace(Ea, ""), b = a.search(Da), 0 <= b && (a = a.substring(0, b))) : a = "";
        return a
    }

    function Ka(a) {
        return 2 > a.length ? !1 : R(Ha, a)
    }

    function La(a) {
        return R(Fa, a) ? S(a, Aa) : S(a, za)
    }

    function Ma(a) {
        var b = La(a.toString());
        a.c = "";
        a.a(b)
    }

    function S(a, b) {
        for (var c = new I, d, e = a.length, f = 0; f < e; ++f) d = a.charAt(f), d = b[d.toUpperCase()], null != d && c.a(d);
        return c.toString()
    }

    function T(a) {
        return null != a && isNaN(a) && a.toUpperCase() in ya
    }

    function Na(a, b, c) {
        if (0 == A(b, 2) && null != b.a[5]) {
            var d = D(b, 5);
            if (0 < d.length) return d
        }
        var d = D(b, 1),
            e = U(b);
        if (0 == c) return Oa(d, 0, e, "");
        if (!(d in O)) return e;
        a = V(a, d, W(d));
        b = null != b.a[3] && A(b, 3).length ? 3 == c ? ";ext=" + A(b, 3) : null != a.a[13] ? A(a, 13) + D(b, 3) : " ext. " + D(b, 3) : "";
        a: {
            a = (C(a, 20) || []).length && 2 != c ? C(a, 20) || [] : C(a, 19) || [];
            for (var f, g = a.length, h = 0; h < g; ++h) {
                f = a[h];
                var l = ra(f, 3);
                if (!l || !e.search(A(f, 3, l - 1)))
                    if (l = new RegExp(A(f, 1)), R(l, e)) {
                        a = f;
                        break a
                    }
            }
            a = null
        }
        a && (g = a, a = D(g, 2), f = new RegExp(A(g, 1)), D(g, 5),
            g = D(g, 4), e = 2 == c && null != g && 0 < g.length ? e.replace(f, a.replace(Ia, g)) : e.replace(f, a), 3 == c && (e = e.replace(RegExp("^[-x\u2010-\u2015\u2212\u30fc\uff0d-\uff0f \u00a0\u00ad\u200b\u2060\u3000()\uff08\uff09\uff3b\uff3d.\\[\\]/~\u2053\u223c\uff5e]+"), ""), e = e.replace(RegExp("[-x\u2010-\u2015\u2212\u30fc\uff0d-\uff0f \u00a0\u00ad\u200b\u2060\u3000()\uff08\uff09\uff3b\uff3d.\\[\\]/~\u2053\u223c\uff5e]+", "g"), "-")));
        return Oa(d, c, e, b)
    }

    function V(a, b, c) {
        return "001" == c ? X(a, "" + b) : X(a, c)
    }

    function U(a) {
        var b = "" + A(a, 2);
        return null != a.a[4] && A(a, 4) ? Array(D(a, 8) + 1).join("0") + b : b
    }

    function Oa(a, b, c, d) {
        switch (b) {
            case 0:
                return "+" + a + c + d;
            case 1:
                return "+" + a + " " + c + d;
            case 3:
                return "tel:+" + a + "-" + c + d;
            default:
                return c + d
        }
    }

    function Pa(a, b) {
        switch (b) {
            case 4:
                return A(a, 5);
            case 3:
                return A(a, 4);
            case 1:
                return A(a, 3);
            case 0:
            case 2:
                return A(a, 2);
            case 5:
                return A(a, 6);
            case 6:
                return A(a, 8);
            case 7:
                return A(a, 7);
            case 8:
                return A(a, 21);
            case 9:
                return A(a, 25);
            case 10:
                return A(a, 28);
            default:
                return A(a, 1)
        }
    }

    function Qa(a, b) {
        return Y(a, A(b, 1)) ? Y(a, A(b, 5)) ? 4 : Y(a, A(b, 4)) ? 3 : Y(a, A(b, 6)) ? 5 : Y(a, A(b, 8)) ? 6 : Y(a, A(b, 7)) ? 7 : Y(a, A(b, 21)) ? 8 : Y(a, A(b, 25)) ? 9 : Y(a, A(b, 28)) ? 10 : Y(a, A(b, 2)) ? A(b, 18) || Y(a, A(b, 3)) ? 2 : 0 : !A(b, 18) && Y(a, A(b, 3)) ? 1 : -1 : -1
    }

    function X(a, b) {
        if (null == b) return null;
        b = b.toUpperCase();
        var c = a.a[b];
        if (!c) {
            c = ya[b];
            if (!c) return null;
            c = (new H).c(L.f(), c);
            a.a[b] = c
        }
        return c
    }

    function Y(a, b) {
        var c = a.length;
        return 0 < ra(b, 9) && -1 == x(C(b, 9) || [], c) ? !1 : R(D(b, 2), a)
    }

    function Ra(a, b) {
        if (!b) return null;
        var c = D(b, 1);
        if (c = O[c])
            if (1 == c.length) c = c[0];
            else a: {
                for (var d = U(b), e, f = c.length, g = 0; g < f; g++) {
                    e = c[g];
                    var h = X(a, e);
                    if (null != h.a[23]) {
                        if (!d.search(A(h, 23))) {
                            c = e;
                            break a
                        }
                    } else if (-1 != Qa(d, h)) {
                        c = e;
                        break a
                    }
                }
                c = null
            }
        else c = null;
        return c
    }

    function W(a) {
        return (a = O[a]) ? a[0] : "ZZ"
    }

    function Sa(a, b) {
        var c = C(b, 9) || [],
            d = C(b, 10) || [],
            e = a.length;
        if (-1 < x(d, e)) return 0;
        d = c[0];
        return d == e ? 0 : d > e ? 2 : c[c.length - 1] < e ? 3 : -1 < x(c, e, 1) ? 0 : 3
    }

    function Ta(a, b, c, d, e) {
        if (!a.length) return 0;
        a = new I(a);
        var f;
        b && (f = A(b, 11));
        null == f && (f = "NonMatch");
        var g = a.toString();
        if (g.length)
            if (Q.test(g)) g = g.replace(Q, ""), a.c = "", a.a(La(g)), f = 1;
            else {
                g = new RegExp(f);
                Ma(a);
                f = a.toString();
                if (f.search(g)) f = !1;
                else {
                    var g = f.match(g)[0].length,
                        h = f.substring(g).match(Ba);
                    h && null != h[1] && 0 < h[1].length && "0" == S(h[1], za) ? f = !1 : (a.c = "", a.a(f.substring(g)), f = !0)
                }
                f = f ? 5 : 20
            }
        else f = 20;
        d && B(e, 6, f);
        if (20 != f) {
            if (2 >= a.c.length) throw Error("Phone number too short after IDD");
            a: {
                d =
                    a.toString();
                if (d.length && "0" != d.charAt(0))
                    for (a = d.length, f = 1; 3 >= f && f <= a; ++f)
                        if (b = parseInt(d.substring(0, f), 10), b in O) {
                            c.a(d.substring(f));
                            c = b;
                            break a
                        } c = 0
            }
            if (c) return B(e, 1, c), c;
            throw Error("Invalid country calling code");
        }
        if (b && (f = D(b, 10), g = "" + f, h = a.toString(), !h.lastIndexOf(g, 0))) {
            var l = new I(h.substring(g.length)),
                g = A(b, 1),
                h = new RegExp(D(g, 2));
            Ua(l, b, null);
            b = l.toString();
            if (!R(h, a.toString()) && R(h, b) || 3 == Sa(a.toString(), g)) return c.a(b), d && B(e, 6, 10), B(e, 1, f), f
        }
        B(e, 1, 0);
        return 0
    }

    function Ua(a, b, c) {
        var d = a.toString(),
            e = d.length,
            f = A(b, 15);
        if (e && null != f && f.length) {
            var g = new RegExp("^(?:" + f + ")");
            if (e = g.exec(d)) {
                var f = new RegExp(D(A(b, 1), 2)),
                    h = R(f, d),
                    l = e.length - 1;
                b = A(b, 16);
                if (null != b && b.length && null != e[l] && e[l].length) {
                    if (d = d.replace(g, b), !h || R(f, d)) c && 0 < l && c.a(e[1]), a.set(d)
                } else if (!h || R(f, d.substring(e[0].length))) c && 0 < l && null != e[l] && c.a(e[1]), a.set(d.substring(e[0].length))
            }
        }
    }

    function Z(a, b, c) {
        if (!T(c) && 0 < b.length && "+" != b.charAt(0)) throw Error("Invalid country calling code");
        return Va(a, b, c, !0)
    }

    function Va(a, b, c, d) {
        if (null == b) throw Error("The string supplied did not seem to be a phone number");
        if (250 < b.length) throw Error("The string supplied is too long to be a phone number");
        var e = new I,
            f = b.indexOf(";phone-context=");
        if (0 < f) {
            var g = f + 15;
            if ("+" == b.charAt(g)) {
                var h = b.indexOf(";", g);
                0 < h ? e.a(b.substring(g, h)) : e.a(b.substring(g))
            }
            g = b.indexOf("tel:");
            e.a(b.substring(0 <= g ? g + 4 : 0, f))
        } else e.a(Ja(b));
        f = e.toString();
        g = f.indexOf(";isub=");
        0 < g && (e.c = "", e.a(f.substring(0, g)));
        if (!Ka(e.toString())) throw Error("The string supplied did not seem to be a phone number");
        f = e.toString();
        if (!(T(c) || null != f && 0 < f.length && Q.test(f))) throw Error("Invalid country calling code");
        f = new M;
        d && B(f, 5, b);
        a: {
            b = e.toString();g = b.search(Ga);
            if (0 <= g && Ka(b.substring(0, g)))
                for (var h = b.match(Ga), l = h.length, q = 1; q < l; ++q)
                    if (null != h[q] && 0 < h[q].length) {
                        e.c = "";
                        e.a(b.substring(0, g));
                        b = h[q];
                        break a
                    } b = ""
        }
        0 < b.length && B(f, 3, b);
        b = X(a, c);
        g = new I;
        h = 0;
        l = e.toString();
        try {
            h = Ta(l, b, g, d, f)
        } catch (z) {
            if ("Invalid country calling code" == z.message && Q.test(l)) {
                if (l = l.replace(Q, ""), h = Ta(l, b, g, d, f), !h) throw z;
            } else throw z;
        }
        h ? (e = W(h), e != c && (b = V(a, h, e))) : (Ma(e), g.a(e.toString()), null != c ? (h = D(b, 10), B(f, 1, h)) : d && (delete f.a[6], f.c && delete f.c[6]));
        if (2 > g.c.length) throw Error("The string supplied is too short to be a phone number");
        b && (a = new I, c = new I(g.toString()), Ua(c, b, a), 2 != Sa(c.toString(), A(b, 1)) && (g = c, d && 0 < a.toString().length && B(f, 7, a.toString())));
        d = g.toString();
        a = d.length;
        if (2 > a) throw Error("The string supplied is too short to be a phone number");
        if (17 < a) throw Error("The string supplied is too long to be a phone number");
        if (1 < d.length && "0" == d.charAt(0)) {
            B(f, 4, !0);
            for (a = 1; a < d.length - 1 && "0" == d.charAt(a);) a++;
            1 != a && B(f, 8, a)
        }
        B(f, 2, parseInt(d, 10));
        return f
    }

    function R(a, b) {
        var c = "string" == typeof a ? b.match("^(?:" + a + ")$") : b.match(a);
        return c && c[0].length == b.length ? !0 : !1
    };
    v("intlTelInputUtils", {});
    v("intlTelInputUtils.formatNumber", function(a, b, c) {
        try {
            var d = P.a(),
                e = Z(d, a, b);
            return Na(d, e, "undefined" == typeof c ? 0 : c)
        } catch (f) {
            return a
        }
    });
    v("intlTelInputUtils.getExampleNumber", function(a, b, c) {
        try {
            var d = P.a(),
                e;
            a: {
                if (T(a)) {
                    var f = Pa(X(d, a), c);
                    try {
                        if (null != f.a[6]) {
                            var g = A(f, 6);
                            e = Va(d, g, a, !1);
                            break a
                        }
                    } catch (h) {}
                }
                e = null
            }
            return Na(d, e, b ? 2 : 1)
        } catch (h) {
            return ""
        }
    });
    v("intlTelInputUtils.getExtension", function(a, b) {
        try {
            return A(Z(P.a(), a, b), 3)
        } catch (c) {
            return ""
        }
    });
    v("intlTelInputUtils.getNumberType", function(a, b) {
        try {
            var c = P.a(),
                d;
            var e = Z(c, a, b),
                f = Ra(c, e),
                g = V(c, D(e, 1), f);
            if (g) {
                var h = U(e);
                d = Qa(h, g)
            } else d = -1;
            return d
        } catch (l) {
            return -99
        }
    });
    v("intlTelInputUtils.getValidationError", function(a, b) {
        try {
            var c = P.a(),
                d;
            var e = Z(c, a, b),
                f = U(e),
                g = D(e, 1);
            if (g in O) {
                var h = V(c, g, W(g));
                d = Sa(f, A(h, 1))
            } else d = 1;
            return d
        } catch (l) {
            return "Invalid country calling code" == l.message ? 1 : "The string supplied did not seem to be a phone number" == l.message ? 4 : "Phone number too short after IDD" == l.message || "The string supplied is too short to be a phone number" == l ? 2 : "The string supplied is too long to be a phone number" == l.message ? 3 : -99
        }
    });
    v("intlTelInputUtils.isValidNumber", function(a, b) {
        try {
            var c = P.a(),
                d = Z(c, a, b),
                e;
            var f = Ra(c, d),
                g = D(d, 1),
                h = V(c, g, f),
                l;
            if (!(l = !h)) {
                var q;
                if (q = "001" != f) {
                    var z, va = X(c, f);
                    if (!va) throw Error("Invalid region code: " + f);
                    z = D(va, 10);
                    q = g != z
                }
                l = q
            }
            if (l) e = !1;
            else {
                var Wa = U(d);
                e = -1 != Qa(Wa, h)
            }
            return e
        } catch (Xa) {
            return !1
        }
    });
    v("intlTelInputUtils.numberFormat", {
        E164: 0,
        INTERNATIONAL: 1,
        NATIONAL: 2,
        RFC3966: 3
    });
    v("intlTelInputUtils.numberType", {
        FIXED_LINE: 0,
        MOBILE: 1,
        FIXED_LINE_OR_MOBILE: 2,
        TOLL_FREE: 3,
        PREMIUM_RATE: 4,
        SHARED_COST: 5,
        VOIP: 6,
        PERSONAL_NUMBER: 7,
        PAGER: 8,
        UAN: 9,
        VOICEMAIL: 10,
        UNKNOWN: -1
    });
    v("intlTelInputUtils.validationError", {
        IS_POSSIBLE: 0,
        INVALID_COUNTRY_CODE: 1,
        TOO_SHORT: 2,
        TOO_LONG: 3,
        NOT_A_NUMBER: 4
    });
})();
