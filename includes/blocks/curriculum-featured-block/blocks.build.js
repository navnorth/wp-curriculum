! function(e) {
    function t(r) {
        if (l[r]) return l[r].exports;
        var c = l[r] = {
            i: r,
            l: !1,
            exports: {}
        };
        return e[r].call(c.exports, c, c.exports, t), c.l = !0, c.exports
    }
    var l = {};
    t.m = e, t.c = l, t.d = function(e, l, r) {
        t.o(e, l) || Object.defineProperty(e, l, {
            configurable: !1,
            enumerable: !0,
            get: r
        })
    }, t.n = function(e) {
        var l = e && e.__esModule ? function() {
            return e.default
        } : function() {
            return e
        };
        return t.d(l, "a", l), l
    }, t.o = function(e, t) {
        return Object.prototype.hasOwnProperty.call(e, t)
    }, t.p = "", t(t.s = 0)
}([function(e, t, l) {
    "use strict";
    Object.defineProperty(t, "__esModule", {
        value: !0
    });
    l(1)
}, function(e, t, l) {
    "use strict";
    var r = l(2),
        c = (l.n(r), l(3)),
        __ = (l.n(c), wp.i18n.__),
        n = wp.blocks.registerBlockType,
        i = wp.blockEditor.InspectorControls,
        a = wp.components.PanelBody,
        s = wp.components,
        o = (s.CheckboxControl, s.RadioControl, s.TextControl, s.ToggleControl, s.SelectControl, []),
        u = "li",
        m = [1, 2, 3, 4, 5],
        p = [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
        d = ["middle", "left", "right"];
    n("cgb/block-curriculum-featured-block", {
        title: __("Curriculum Featured Block"),
        icon: "welcome-learn-more",
        category: "common",
        keywords: [__("curriculum-featured-block"), __("CGB Example"), __("create-guten-block")],
        attributes: {
            blockwidth: {
                type: "intiger",
                default: 1170
            },
            blockid: {
                type: "string"
            },
            highlight: {
                type: "string",
                default: "resources"
            },
            selectedfeatured: {
                type: "string"
            },
            data: {
                type: "string"
            },
            resources: {
                type: "string"
            },
            curriculum: {
                type: "string"
            },
            blocktitle: {
                type: "string",
                default: "Featured"
            },
            searchstring: {
                type: "string"
            },
            resourcesubjects: {
                type: "object"
            },
            curriculumsubjects: {
                type: "object"
            },
            resourcesubjectfilter: {
                type: "string"
            },
            curriculumsubjectfilter: {
                type: "string"
            },
            filtertype: {
                type: "string"
            },
            minslides: {
                type: "intiger",
                default: 1
            },
            maxslides: {
                type: "intiger",
                default: 3
            },
            moveslides: {
                type: "intiger",
                default: 1
            },
            slidewidth: {
                type: "intiger",
                default: 375
            },
            slidemargin: {
                type: "intiger",
                default: 20
            },
            slidealign: {
                type: "string",
                default: "left"
            },
            slidedesclength: {
                type: "intiger",
                default: cgbGlobal.slidedesclength
            },
            slideimageheight: {
                type: "intiger",
                default: cgbGlobal.slideimageheight
            }
        },
        edit: function(e) {
            function t(e, t) {
                if (!cgbGlobal.bxresetblocked) {
                    var r = e.target.getAttribute("fet");
                    if (e.target.checked) {
                        var c = e.target.getAttribute("data");
                        I.push([parseInt(c), r])
                    } else {
                        var n = parseInt(e.target.getAttribute("data")),
                            i = I.findIndex(l(n)); - 1 != i && I.splice(i, 1)
                    }
                    o = [], I.map(function(e, t) {
                        var l = void 0;
                        "cur" == e[1] ? (l = k.curriculum.find(function(t) {
                            return t.id == parseInt(e[0])
                        }), k.curriculum.indexOf(parseInt(e[0]))) : (l = k.resources.find(function(t) {
                            return t.id == parseInt(e[0])
                        }), k.resources.indexOf(parseInt(e[0]))), "undefined" != typeof l && o.push(Object.values(l))
                    });
                    var a = "";
                    I.map(function(e, t) {
                        void 0 !== e[0] && void 0 !== e[1] && (a += "" == a ? e[0] + "|" + e[1] : "," + e[0] + "|" + e[1])
                    }), v({
                        selectedfeatured: a
                    }), curriculumfeatslider_reset(k.blockid, 750, e.target)
                }
            }

            function l(e) {
                return function(t) {
                    return t[0] === e
                }
            }

            function r() {
                u = "li" == u ? "div" : "li", I = [], jQuery(".oer_curriculum_inspector_feat_hlite_node").each(function() {
                    var e = jQuery(this).attr("data"),
                        t = jQuery(this).attr("typ");
                    I.push([parseInt(e), t])
                }), o = [], I.map(function(e, t) {
                    var l = void 0;
                    if ("cur" == e[1]) {
                        l = k.curriculum.find(function(t) {
                            return t.id == parseInt(e[0])
                        });
                        k.curriculum.indexOf(parseInt(e[0]))
                    } else {
                        l = k.resources.find(function(t) {
                            return t.id == parseInt(e[0])
                        });
                        k.resources.indexOf(parseInt(e[0]))
                    }
                    "undefined" != typeof l && o.push(Object.values(l))
                });
                var e = "";
                I.map(function(t, l) {
                    void 0 !== t[0] && void 0 !== t[1] && (e += "" == e ? t[0] + "|" + t[1] : "," + t[0] + "|" + t[1])
                }), v({
                    selectedfeatured: e
                })
            }

            function c() {
                I = [], jQuery(".oer_curriculum_inspector_feat_hlite_node.stay").each(function() {
                    var e = jQuery(this).attr("data"),
                        t = jQuery(this).attr("typ");
                    I.push([parseInt(e), t])
                }), o = [], I.map(function(e, t) {
                    var l = void 0;
                    if ("cur" == e[1]) {
                        l = k.curriculum.find(function(t) {
                            return t.id == parseInt(e[0])
                        });
                        k.curriculum.indexOf(parseInt(e[0]))
                    } else {
                        l = k.resources.find(function(t) {
                            return t.id == parseInt(e[0])
                        });
                        k.resources.indexOf(parseInt(e[0]))
                    }
                    "undefined" != typeof l && o.push(Object.values(l))
                });
                var e = "";
                I.map(function(t, l) {
                    void 0 !== t[0] && void 0 !== t[1] && (e += "" == e ? t[0] + "|" + t[1] : "," + t[0] + "|" + t[1])
                }), v({
                    selectedfeatured: e
                })
            }

            function n() {
                var e = setInterval(function() {
                    jQuery(".oer_curriculum_inspector_feat_hlite_list").length && (clearInterval(e), setTimeout(function() {
                        sort()
                    }, 500))
                }, 100)
            }

            function s(e, t) {
                "res" == e.target.getAttribute("typ") ? jQuery(".oer_curriculum_inspector_feat_modal_resource_wrapper").hide(300, function() {
                    jQuery(".oer_curriculum_inspector_feat_modal_curriculum_wrapper").show(300)
                }) : jQuery(".oer_curriculum_inspector_feat_modal_curriculum_wrapper").hide(300, function() {
                    jQuery(".oer_curriculum_inspector_feat_modal_resource_wrapper").show(300)
                })
            }

            function _(e, t) {
                var l = e.target.getAttribute("typ"),
                    r = e.target.value;
                switch (l) {
                    case "minslides":
                        v({
                            minslides: parseInt(r)
                        });
                        break;
                    case "maxslides":
                        v({
                            maxslides: parseInt(r)
                        });
                        break;
                    case "moveslides":
                        v({
                            moveslides: parseInt(r)
                        });
                        break;
                    case "slidewidth":
                        v({
                            slidewidth: parseInt(r)
                        });
                        break;
                    case "slidemargin":
                        v({
                            slidemargin: parseInt(r)
                        });
                        break;
                    case "slidealign":
                        v({
                            slidealign: r
                        });
                        break;
                    case "slidedesclength":
                        v({
                            slidedesclength: parseInt(r)
                        });
                        break;
                    case "slideimageheight":
                        v({
                            slideimageheight: parseInt(r)
                        })
                }
                localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-minslides", k.minslides), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-maxslides", k.maxslides), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-moveslides", k.moveslides), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-slidewidth", k.slidewidth), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-slidemargin", k.slidemargin), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-slidealign", k.slidealign), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-slidedesclength", k.slidedesclength), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-slideimageheight", k.slideimageheight), curriculumfeatslider_reset(k.blockid, 750)
            }

            function b(e, t) {
                var l = e.target.value;
                l = "" == l ? "" : l;
                var r = e.target.getAttribute("blk");
                cgbGlobal["curriculum_feat_title_" + r] = l, v({
                    blocktitle: l
                })
            }

            function f(e, t) {
                var l = e.target.value.toLowerCase();
                v({
                    resourcesubjectfilter: ""
                }), v({
                    curriculumsubjectfilter: ""
                }), v({
                    searchstring: l
                })
            }

            function g(e, t) {
                var l = e.target.value;
                v({
                    searchstring: ""
                }), v("" !== l ? {
                    resourcesubjectfilter: l
                } : {
                    resourcesubjectfilter: ""
                })
            }

            function h(e, t) {
                var l = e.target.value;
                v({
                    searchstring: ""
                }), v("" !== l ? {
                    curriculumsubjectfilter: l
                } : {
                    curriculumsubjectfilter: ""
                })
            }

            function w(e, t) {
                v({
                    resourcesubjectfilter: ""
                }), v({
                    curriculumsubjectfilter: ""
                }), v({
                    searchstring: ""
                }), v("search" == k.filtertype ? {
                    filtertype: "subject"
                } : {
                    filtertype: "search"
                })
            }

            function E(e, t) {
                var l = e.target.value;
                v({
                    blockwidth: l
                }), jQuery("#block-" + k.blockid).css({
                    maxWidth: l + "px"
                }), localStorage.setItem("lpInspectorFeatBlockwidth-" + k.blockid, k.blockwidth)
            }
            var k = e.attributes,
                v = e.setAttributes,
                x = 0,
                y = 0;
            wp.data.select("core/block-editor").getBlocks().map(function(e, t) {
                if ("cgb/block-curriculum-featured-block" == e.name) {
                    var l = ((new Date).getTime(), e.clientId);
                    wp.data.dispatch("core/block-editor").updateBlockAttributes(l, {
                        blockid: l
                    }), void 0 === k.filtertype && wp.data.dispatch("core/block-editor").updateBlockAttributes(l, {
                        filtertype: "search"
                    }), y++, x++
                }
            }), curriculumfeatslider_loadall(x);
            var I = [];
            if ("undefined" !== typeof k.selectedfeatured) {
                k.selectedfeatured.split(",").map(function(e, t) {
                    var l = e.split("|");
                    I.push([parseInt(l[0]), l[1]])
                })
            }
            if (k.resources, k.data || wp.apiFetch({
                    url: "/wp-json/curriculum/feat/dataquery"
                }).then(function(e) {
                    v({
                        data: e
                    }), v({
                        resourcesubjects: e[0]
                    }), v({
                        curriculumsubjects: e[1]
                    }), v({
                        resources: e[2]
                    }), v({
                        curriculum: e[3]
                    })
                }), !k.data) return "Loading Featured Data...";
            var C = k.data,
                S = C[0],
                j = C[1],
                F = C[2],
                L = C[3];
            "undefined" != typeof k.selectedfeatured ? (o = [], I.map(function(e, t) {
                var l = void 0;
                if ("cur" == e[1]) {
                    l = k.curriculum.find(function(t) {
                        return t.id == parseInt(e[0])
                    });
                    k.curriculum.indexOf(parseInt(e[0]))
                } else {
                    l = k.resources.find(function(t) {
                        return t.id == parseInt(e[0])
                    });
                    k.resources.indexOf(parseInt(e[0]))
                }
                "undefined" != typeof l && o.push(Object.values(l))
            })) : o = [], localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-minslides", k.minslides), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-maxslides", k.maxslides), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-moveslides", k.moveslides), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-slidewidth", k.slidewidth), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-slidemargin", k.slidemargin), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-slidealign", k.slidealign), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-slidedesclength", k.slidedesclength), localStorage.setItem("lpInspectorFeatSliderSetting-" + k.blockid + "-slideimageheight", k.slideimageheight), jQuery("#block-" + k.blockid).css({
                maxWidth: k.blockwidth + "px"
            }), localStorage.setItem("lpInspectorFeatBlockwidth-" + k.blockid, k.blockwidth);
            var O = [1];
            return wp.element.createElement("div", null, wp.element.createElement(i, null, wp.element.createElement(a, {
                title: __("Curriculum Featured Block settings"),
                initialOpen: !0
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_wrapper"
            }, wp.element.createElement("label", {
                class: "components-base-control__label",
                for: "oer_curriculum_inspector_subject"
            }, "Block Title:"), wp.element.createElement("input", {
                type: "text",
                onChange: b,
                class: "ls_inspector_feat_title",
                value: k.blocktitle,
                blk: k.blockid
            })), wp.element.createElement("div", {
                class: "oer_curriculum_inspector_wrapper"
            }, wp.element.createElement("label", {
                class: "components-base-control__label",
                for: "oer_curriculum_inspector_subject"
            }, "Block Width"), wp.element.createElement("input", {
                type: "number",
                onChange: E,
                class: "ls_inspector_feat_blockwidth",
                value: k.blockwidth,
                blk: k.blockid
            }), wp.element.createElement("label", {
                class: "components-base-control__label",
                for: "oer_curriculum_inspector_subject"
            }, wp.element.createElement("em", null, "Note: Block width setting is only used to simulate the frontend width at backend and will not affect the frontend."))), wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_resource_wrapper"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_content_main"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_wrapper_close"
            }, wp.element.createElement("span", {
                class: "dashicons dashicons-no"
            })), wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_center"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_table"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_cell"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_search_wrapper"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_search_header"
            }, "Resources"), O.map(function(e, t) {
                return "subject" == k.filtertype ? wp.element.createElement("input", {
                    type: "button",
                    onClick: w,
                    class: "button",
                    value: "Filter by subject"
                }) : wp.element.createElement("input", {
                    type: "button",
                    onClick: w,
                    class: "button",
                    value: "Filter by search"
                })
            }), O.map(function(e, t) {
                return "subject" == k.filtertype ? wp.element.createElement("input", {
                    type: "text",
                    onChange: f,
                    fet: "res",
                    id: "oer_curriculum_inspector_feat_search",
                    class: "oer_curriculum_inspector_feat_search",
                    value: k.searchstring
                }) : wp.element.createElement("select", {
                    id: "oer_curriculum_inspector_feat_subject_select",
                    onChange: g,
                    value: k.resourcesubjectfilter
                }, wp.element.createElement("option", {
                    value: ""
                }, "All"), S.map(function(e, t) {
                    return e.term_id == k.resourcesubjectfilter ? 0 == e.parent ? wp.element.createElement("option", {
                        selected: "selected",
                        value: e.term_id,
                        class: "oer_curriculum_inspector_feat_subject_select_bold"
                    }, e.name + " (" + e.cnt + ")") : wp.element.createElement("option", {
                        selected: "selected",
                        value: e.term_id
                    }, "\u251c " + e.name + " (" + e.cnt + ")") : 0 == e.parent ? wp.element.createElement("option", {
                        value: e.term_id,
                        class: "oer_curriculum_inspector_feat_subject_select_bold"
                    }, e.name + " (" + e.cnt + ")") : wp.element.createElement("option", {
                        value: e.term_id
                    }, "\u251c " + e.name + " (" + e.cnt + ")")
                }))
            })), wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_content"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_content_subcontainer"
            }, F.map(function(e, r) {
                var c = I.findIndex(l(e.id)),
                    n = k.searchstring,
                    i = k.resourcesubjectfilter,
                    a = e.title.toLowerCase(),
                    s = e.tax.toString(),
                    o = s.split("|");
                if ("" != k.searchstring && k.searchstring) {
                    if (o.includes(i)) {
                        if (-1 !== a.indexOf(n)) return -1 != c ? wp.element.createElement("label", {
                            class: "components-base-control__label ls_inspector_feat_modal_label",
                            srch: e.title.toLowerCase()
                        }, wp.element.createElement("img", {
                            src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                        }), wp.element.createElement("input", {
                            checked: "checked",
                            onClick: t,
                            fet: "res",
                            id: "inspector-checkbox-control-" + r,
                            idx: r,
                            class: "ls_inspector_feat_modal_checkbox",
                            type: "checkbox",
                            data: e.id,
                            tax: s
                        }), unescape(e.title)) : wp.element.createElement("label", {
                            class: "components-base-control__label ls_inspector_feat_modal_label",
                            srch: e.title.toLowerCase()
                        }, wp.element.createElement("img", {
                            src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                        }), wp.element.createElement("input", {
                            onClick: t,
                            fet: "res",
                            id: "inspector-checkbox-control-" + r,
                            idx: r,
                            class: "ls_inspector_feat_modal_checkbox",
                            type: "checkbox",
                            data: e.id,
                            tax: s
                        }), unescape(e.title))
                    } else if (-1 !== a.indexOf(n)) return -1 != c ? wp.element.createElement("label", {
                        class: "components-base-control__label ls_inspector_feat_modal_label",
                        srch: e.title.toLowerCase()
                    }, wp.element.createElement("img", {
                        src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                    }), wp.element.createElement("input", {
                        checked: "checked",
                        onClick: t,
                        fet: "res",
                        id: "inspector-checkbox-control-" + r,
                        idx: r,
                        class: "ls_inspector_feat_modal_checkbox",
                        type: "checkbox",
                        data: e.id,
                        tax: s
                    }), unescape(e.title)) : wp.element.createElement("label", {
                        class: "components-base-control__label ls_inspector_feat_modal_label",
                        srch: e.title.toLowerCase()
                    }, wp.element.createElement("img", {
                        src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                    }), wp.element.createElement("input", {
                        onClick: t,
                        fet: "res",
                        id: "inspector-checkbox-control-" + r,
                        idx: r,
                        class: "ls_inspector_feat_modal_checkbox",
                        type: "checkbox",
                        data: e.id,
                        tax: s
                    }), unescape(e.title))
                } else {
                    if ("" == i || void 0 === i) return -1 != c ? wp.element.createElement("label", {
                        class: "components-base-control__label ls_inspector_feat_modal_label",
                        srch: e.title.toLowerCase()
                    }, wp.element.createElement("img", {
                        src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                    }), wp.element.createElement("input", {
                        checked: "checked",
                        onClick: t,
                        fet: "res",
                        id: "inspector-checkbox-control-" + r,
                        idx: r,
                        class: "ls_inspector_feat_modal_checkbox",
                        type: "checkbox",
                        data: e.id,
                        tax: s
                    }), unescape(e.title)) : wp.element.createElement("label", {
                        class: "components-base-control__label ls_inspector_feat_modal_label",
                        srch: e.title.toLowerCase()
                    }, wp.element.createElement("img", {
                        src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                    }), wp.element.createElement("input", {
                        onClick: t,
                        fet: "res",
                        id: "inspector-checkbox-control-" + r,
                        idx: r,
                        class: "ls_inspector_feat_modal_checkbox",
                        type: "checkbox",
                        data: e.id,
                        tax: s
                    }), unescape(e.title));
                    if (o.includes(i)) return -1 != c ? wp.element.createElement("label", {
                        class: "components-base-control__label ls_inspector_feat_modal_label",
                        srch: e.title.toLowerCase()
                    }, wp.element.createElement("img", {
                        src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                    }), wp.element.createElement("input", {
                        checked: "checked",
                        onClick: t,
                        fet: "res",
                        id: "inspector-checkbox-control-" + r,
                        idx: r,
                        class: "ls_inspector_feat_modal_checkbox",
                        type: "checkbox",
                        data: e.id,
                        tax: s
                    }), unescape(e.title)) : wp.element.createElement("label", {
                        class: "components-base-control__label ls_inspector_feat_modal_label",
                        srch: e.title.toLowerCase()
                    }, wp.element.createElement("img", {
                        src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                    }), wp.element.createElement("input", {
                        onClick: t,
                        fet: "res",
                        id: "inspector-checkbox-control-" + r,
                        idx: r,
                        class: "ls_inspector_feat_modal_checkbox",
                        type: "checkbox",
                        data: e.id,
                        tax: s
                    }), unescape(e.title))
                }
            }))), wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_search_footer"
            }, wp.element.createElement("input", {
                type: "button",
                class: "button oer_curriculum_inspector_feat_quickswitchbutton",
                onClick: s,
                typ: "res",
                value: "Curriculum lists >"
            })))))))), wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_curriculum_wrapper"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_content_main"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_wrapper_close"
            }, wp.element.createElement("span", {
                class: "dashicons dashicons-no"
            })), wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_center"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_table"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_cell"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_search_wrapper"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_search_header"
            }, "Curriculum"), O.map(function(e, t) {
                return "subject" == k.filtertype ? wp.element.createElement("input", {
                    type: "button",
                    onClick: w,
                    class: "button",
                    value: "Filter by subject"
                }) : wp.element.createElement("input", {
                    type: "button",
                    onClick: w,
                    class: "button",
                    value: "Filter by search"
                })
            }), O.map(function(e, t) {
                return "subject" == k.filtertype ? wp.element.createElement("input", {
                    type: "text",
                    onChange: f,
                    fet: "res",
                    id: "oer_curriculum_inspector_feat_search",
                    class: "oer_curriculum_inspector_feat_search",
                    value: k.searchstring
                }) : wp.element.createElement("select", {
                    id: "oer_curriculum_inspector_feat_subject_select",
                    onChange: h,
                    value: k.curriculumsubjectfilter
                }, wp.element.createElement("option", {
                    value: ""
                }, "All"), j.map(function(e, t) {
                    return e.term_id == k.curriculumsubjectfilter ? 0 == e.parent ? wp.element.createElement("option", {
                        selected: "selected",
                        value: e.term_id,
                        class: "oer_curriculum_inspector_feat_subject_select_bold"
                    }, e.name + " (" + e.cnt + ")") : wp.element.createElement("option", {
                        selected: "selected",
                        value: e.term_id
                    }, "\u251c " + e.name + " (" + e.cnt + ")") : 0 == e.parent ? wp.element.createElement("option", {
                        value: e.term_id,
                        class: "oer_curriculum_inspector_feat_subject_select_bold"
                    }, e.name + " (" + e.cnt + ")") : wp.element.createElement("option", {
                        value: e.term_id
                    }, "\u251c " + e.name + " (" + e.cnt + ")")
                }))
            })), wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_content"
            }, wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_modal_content_subcontainer"
            }, L.map(function(e, r) {
                var c = I.findIndex(l(e.id)),
                    n = k.searchstring,
                    i = k.curriculumsubjectfilter,
                    a = e.title.toLowerCase(),
                    s = e.tax.toString();
                if ("" != k.searchstring && k.searchstring) {
                    if (-1 !== s.indexOf(i)) {
                        if (-1 !== a.indexOf(n)) return -1 != c ? wp.element.createElement("label", {
                            class: "components-base-control__label ls_inspector_feat_modal_label",
                            srch: e.title.toLowerCase()
                        }, wp.element.createElement("img", {
                            src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                        }), wp.element.createElement("input", {
                            checked: "checked",
                            onClick: t,
                            fet: "cur",
                            id: "inspector-checkbox-control-" + r,
                            idx: r,
                            class: "ls_inspector_feat_modal_checkbox",
                            type: "checkbox",
                            data: e.id,
                            tax: s
                        }), e.title) : wp.element.createElement("label", {
                            class: "components-base-control__label ls_inspector_feat_modal_label",
                            srch: e.title.toLowerCase()
                        }, wp.element.createElement("img", {
                            src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                        }), wp.element.createElement("input", {
                            onClick: t,
                            fet: "cur",
                            id: "inspector-checkbox-control-" + r,
                            idx: r,
                            class: "ls_inspector_feat_modal_checkbox",
                            type: "checkbox",
                            data: e.id,
                            tax: s
                        }), e.title)
                    } else if (-1 !== a.indexOf(n)) return -1 != c ? wp.element.createElement("label", {
                        class: "components-base-control__label ls_inspector_feat_modal_label",
                        srch: e.title.toLowerCase()
                    }, wp.element.createElement("img", {
                        src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                    }), wp.element.createElement("input", {
                        checked: "checked",
                        onClick: t,
                        fet: "cur",
                        id: "inspector-checkbox-control-" + r,
                        idx: r,
                        class: "ls_inspector_feat_modal_checkbox",
                        type: "checkbox",
                        data: e.id,
                        tax: s
                    }), e.title) : wp.element.createElement("label", {
                        class: "components-base-control__label ls_inspector_feat_modal_label",
                        srch: e.title.toLowerCase()
                    }, wp.element.createElement("img", {
                        src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                    }), wp.element.createElement("input", {
                        onClick: t,
                        fet: "cur",
                        id: "inspector-checkbox-control-" + r,
                        idx: r,
                        class: "ls_inspector_feat_modal_checkbox",
                        type: "checkbox",
                        data: e.id,
                        tax: s
                    }), e.title)
                } else {
                    if ("" == i || void 0 === i) return -1 != c ? wp.element.createElement("label", {
                        class: "components-base-control__label ls_inspector_feat_modal_label",
                        srch: e.title.toLowerCase()
                    }, wp.element.createElement("img", {
                        src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                    }), wp.element.createElement("input", {
                        checked: "checked",
                        onClick: t,
                        fet: "cur",
                        id: "inspector-checkbox-control-" + r,
                        idx: r,
                        class: "ls_inspector_feat_modal_checkbox",
                        type: "checkbox",
                        data: e.id,
                        tax: s
                    }), e.title) : wp.element.createElement("label", {
                        class: "components-base-control__label ls_inspector_feat_modal_label",
                        srch: e.title.toLowerCase()
                    }, wp.element.createElement("img", {
                        src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                    }), wp.element.createElement("input", {
                        onClick: t,
                        fet: "cur",
                        id: "inspector-checkbox-control-" + r,
                        idx: r,
                        class: "ls_inspector_feat_modal_checkbox",
                        type: "checkbox",
                        data: e.id,
                        tax: s
                    }), e.title);
                    if (-1 !== s.indexOf(i)) return -1 != c ? wp.element.createElement("label", {
                        class: "components-base-control__label ls_inspector_feat_modal_label",
                        srch: e.title.toLowerCase()
                    }, wp.element.createElement("img", {
                        src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                    }), wp.element.createElement("input", {
                        checked: "checked",
                        onClick: t,
                        fet: "cur",
                        id: "inspector-checkbox-control-" + r,
                        idx: r,
                        class: "ls_inspector_feat_modal_checkbox",
                        type: "checkbox",
                        data: e.id,
                        tax: s
                    }), e.title) : wp.element.createElement("label", {
                        class: "components-base-control__label ls_inspector_feat_modal_label",
                        srch: e.title.toLowerCase()
                    }, wp.element.createElement("img", {
                        src: cgbGlobal.pluginDirUrl + "/images/preloader.gif"
                    }), wp.element.createElement("input", {
                        onClick: t,
                        fet: "cur",
                        id: "inspector-checkbox-control-" + r,
                        idx: r,
                        class: "ls_inspector_feat_modal_checkbox",
                        type: "checkbox",
                        data: e.id,
                        tax: s
                    }), e.title)
                }
            }))), wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_search_footer"
            }, wp.element.createElement("input", {
                type: "button",
                class: "button oer_curriculum_inspector_feat_quickswitchbutton",
                onClick: s,
                typ: "cur",
                value: "Resources lists >"
            })))))))), wp.element.createElement("div", {
                class: "oer_curriculum_inspector_wrapper"
            }, wp.element.createElement("label", {
                class: "components-base-control__label",
                for: "oer_curriculum_inspector_subject"
            }, "Featured List:"), wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_addbutton_wrapper"
            }, wp.element.createElement("div", {
                class: "button oer_curriculum_inspector_feat_addResources"
            }, "Add Resources"), wp.element.createElement("div", {
                class: "button oer_curriculum_inspector_feat_addCurriculum"
            }, "Add Curriculum")), wp.element.createElement("div", {
                class: "oer_curriculum_inspector_feat_hlite_list"
            }, wp.element.createElement("div", {
                id: "oer_curriculum_inspector_feat_hlite_featured",
                class: "oer_curriculum_inspector_feat_hlite_featured"
            }, o.map(function(e, t) {
                return "li" == u ? wp.element.createElement("div", {
                    draggable: !0,
                    onMouseup: r,
                    class: "oer_curriculum_inspector_feat_hlite_node stay " + e[6],
                    data: e[0],
                    typ: e[6]
                }, e[1], wp.element.createElement("span", {
                    class: "dashicons dashicons-dismiss"
                })) : wp.element.createElement("li", {
                    draggable: !0,
                    onMouseup: r,
                    class: "oer_curriculum_inspector_feat_hlite_node stay " + e[6],
                    data: e[0],
                    typ: e[6]
                }, e[1], wp.element.createElement("span", {
                    class: "dashicons dashicons-dismiss"
                }))
            })), wp.element.createElement("div", {
                class: "button oer_curriculum_inspector_feat_hlite_reposition_trigger",
                onClick: r,
                blkid: k.blockid
            }), wp.element.createElement("div", {
                class: "button oer_curriculum_inspector_feat_hlite_remove_trigger",
                height: "0",
                width: "0",
                onClick: c,
                blkid: k.blockid
            }))), wp.element.createElement("div", {
                class: "oer_curriculum_inspector_wrapper"
            }, wp.element.createElement("label", {
                class: "components-base-control__label",
                for: "oer_curriculum_inspector_subject"
            }, "Slider Setting:"), wp.element.createElement("table", {
                class: "oer_curriculum_inspector_feat_slider_setting",
                cellspacing: "2"
            }, wp.element.createElement("tr", null, wp.element.createElement("td", null, wp.element.createElement("span", {
                class: "dashicons dashicons-info tooltipped"
            }, wp.element.createElement("span", {
                class: "tooltiptext"
            }, "The minimum number of slides to be shown. Slides will be sized down if slider becomes smaller than the original size.")), "Min. Slides:"), wp.element.createElement("td", null, wp.element.createElement("select", {
                id: "oer_curriculum_inspector_feat_slider_minslides",
                onChange: _,
                typ: "minslides",
                value: k.minslides
            }, m.map(function(e, t) {
                return e == k.minslides ? wp.element.createElement("option", {
                    selected: !0,
                    value: e
                }, e) : wp.element.createElement("option", {
                    value: e
                }, e)
            })))), wp.element.createElement("tr", null, wp.element.createElement("td", null, wp.element.createElement("span", {
                class: "dashicons dashicons-info tooltipped"
            }, wp.element.createElement("span", {
                class: "tooltiptext"
            }, "The maximum number of slides to be shown. Slides will be sized up if slider becomes larger than the original size.")), "Max. Slides:"), wp.element.createElement("td", null, wp.element.createElement("select", {
                id: "oer_curriculum_inspector_feat_slider_maxslides",
                onChange: _,
                typ: "maxslides",
                value: k.maxslides
            }, m.map(function(e, t) {
                return e == k.maxslides ? wp.element.createElement("option", {
                    selected: !0,
                    value: e
                }, e) : wp.element.createElement("option", {
                    value: e
                }, e)
            })))), wp.element.createElement("tr", null, wp.element.createElement("td", null, wp.element.createElement("span", {
                class: "dashicons dashicons-info tooltipped"
            }, wp.element.createElement("span", {
                class: "tooltiptext"
            }, "The number of slides to move on transition. This value must be greater than or equal to minSlides, and less than or equal to maxSlides. If value is greater than the fully-visible slides, then the count of fully-visible slides will be used.")), "Move Slides:"), wp.element.createElement("td", null, wp.element.createElement("select", {
                id: "oer_curriculum_inspector_feat_slider_moveslides",
                onChange: _,
                typ: "moveslides",
                value: k.moveslides
            }, m.map(function(e, t) {
                return e == k.moveslides ? wp.element.createElement("option", {
                    selected: !0,
                    value: e
                }, e) : wp.element.createElement("option", {
                    value: e
                }, e)
            })))), wp.element.createElement("tr", null, wp.element.createElement("td", null, wp.element.createElement("span", {
                class: "dashicons dashicons-info tooltipped"
            }, wp.element.createElement("span", {
                class: "tooltiptext"
            }, "Width of each slide.")), "Slide Width:"), wp.element.createElement("td", null, wp.element.createElement("input", {
                type: "number",
                id: "oer_curriculum_inspector_feat_slider_slidewidth",
                typ: "slidewidth",
                onChange: _,
                value: k.slidewidth
            }))), wp.element.createElement("tr", null, wp.element.createElement("td", null, wp.element.createElement("span", {
                class: "dashicons dashicons-info tooltipped"
            }, wp.element.createElement("span", {
                class: "tooltiptext"
            }, "Space between slides")), "Slide Margin:"), wp.element.createElement("td", null, wp.element.createElement("select", {
                id: "oer_curriculum_inspector_feat_slider_slidemargin",
                onChange: _,
                typ: "slidemargin",
                value: k.slidemargin
            }, p.map(function(e, t) {
                return e == k.slidemargin ? wp.element.createElement("option", {
                    selected: !0,
                    value: e
                }, e) : wp.element.createElement("option", {
                    value: e
                }, e)
            })))), wp.element.createElement("tr", null, wp.element.createElement("td", null, wp.element.createElement("span", {
                class: "dashicons dashicons-info tooltipped"
            }, wp.element.createElement("span", {
                class: "tooltiptext"
            }, "Left, right or middle alignment")), "Alignmnet:"), wp.element.createElement("td", null, wp.element.createElement("select", {
                id: "oer_curriculum_inspector_feat_slider_slidealign",
                onChange: _,
                typ: "slidealign",
                value: k.slidealign
            }, d.map(function(e, t) {
                return e == k.slidemargin ? wp.element.createElement("option", {
                    selected: !0,
                    value: e
                }, e) : wp.element.createElement("option", {
                    value: e
                }, e)
            })))), wp.element.createElement("tr", null, wp.element.createElement("td", null, wp.element.createElement("span", {
                class: "dashicons dashicons-info tooltipped"
            }, wp.element.createElement("span", {
                class: "tooltiptext"
            }, "Length of description to display.")), "Description length:"), wp.element.createElement("td", null, wp.element.createElement("input", {
                type: "number",
                id: "oer_curriculum_inspector_feat_slider_slidedesclength",
                typ: "slidedesclength",
                onChange: _,
                value: k.slidedesclength
            }))), wp.element.createElement("tr", null, wp.element.createElement("td", null, wp.element.createElement("span", {
                class: "dashicons dashicons-info tooltipped"
            }, wp.element.createElement("span", {
                class: "tooltiptext"
            }, "Adjust image height")), "Image height:"), wp.element.createElement("td", null, wp.element.createElement("input", {
                type: "number",
                id: "oer_curriculum_inspector_feat_slider_slideimageheight",
                typ: "slideimageheight",
                onChange: _,
                value: k.slideimageheight
            }))))), wp.element.createElement("img", {
                className: "onload-hack-pp",
                height: "0",
                width: "0",
                onLoad: n,
                src: cgbGlobal.pluginDirUrl + "//images/default-img.jpg"
            }))), wp.element.createElement("div", {
                class: "oer_curriculum_right_featuredwpr"
            }, wp.element.createElement("div", {
                class: "oer-curriculum-ftrdttl curriculum-feat-title_" + k.blockid
            }, k.blocktitle), wp.element.createElement("ul", {
                class: "featuredwpr_bxslider featuredwpr_bxslider_" + k.blockid,
                blk: k.blockid
            }, o.map(function(e, t) {
                var l = e[2];
                return l.length > k.slidedesclength && (l = unescape(l.substr(0, k.slidedesclength)) + "..."), wp.element.createElement("li", {
                    atrr: e[0]
                }, wp.element.createElement("div", {
                    class: "frtdsnglwpr"
                }, wp.element.createElement("a", {
                    href: e[3]
                }, wp.element.createElement("div", {
                    class: "img"
                }, wp.element.createElement("img", {
                    src: e[4],
                    alt: e[1]
                }))), wp.element.createElement("div", {
                    class: "ttl"
                }, wp.element.createElement("a", {
                    href: e[3]
                }, e[1])), wp.element.createElement("div", {
                    class: "desc"
                }, l)))
            }))))
        },
        save: function(e) {
            return null
        }
    })
}, function(e, t) {}, function(e, t) {}]);