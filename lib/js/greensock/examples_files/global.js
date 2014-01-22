var $ = window.jQuery || window.$; //the default jQuery included with WordPress doesn't use $ by default, so if we don't sense it, use window.jQuery.

//GSAP version data
var gsapData = {
			js:{version:["1.11.3","1.11.2","1.11.1","1.11.0","1.10.3","1.10.2","1.10.1","1.10.0","1.9.8","1.9.7","1.9.6","1.9.5","1.9.4","1.9.3","1.9.2","1.9.1","1.9.0","1.8.4","1.8.3","1.8.2","1.8.1"], updated:"2014-01-10"},
			as3:{version:"12.1.2", updated:"2014-01-10"},
			as2:{version:"12.1.2", updated:"2014-01-10"},
			cdnPending:false
		},
		downloadGSAP = function() {}; //we'll replace this once the window loads. This is just a safety measure in case something gets clicked before the method is ready.

jQuery(window).load(function() {
	var $ = window.jQuery; 
	$("body").prepend( $("<div />", {id:"dl_dimmer"}) );

	var cdnCustomizeOpen = false,
			cdnOptions = $.makeArray($("#dl_cdnOptions li")),
			CustomOption = function(name, includes, req, pathPrefix) {
				this.name = name;
				this.path = (pathPrefix || "") + ((name === "jqueryGSAP") ? "jquery.gsap" : name);
				this.includes = includes = includes || [];
				this.req = req || [];
				this.input = $("#dl_cdnOptions input:checkbox[name=" + name + "]");
				this.label = this.input.parent();
				this.included = false;
				this.autoSelected = false;
				var others = this.req.concat(this.includes),
					forceSelections = this.forceSelections = function(checked) {
							var i = others.length,
									other, remaining;
							while (--i > -1) {
								other = options[others[i]];
								if (!checked) {
									other.included = false; //we'll reset this later if necessary
								}
								other.input.attr("disabled", checked);
								if (checked) {
									other.label.addClass("dl_optionDisabled");
								} else {
									other.label.removeClass("dl_optionDisabled");
								}
								if (checked != other.input.prop("checked")) {
									if (checked) {
										other.autoSelected = true;
									} else if (!other.autoSelected) {
										continue;
									} else {
										other.autoSelected = false;
									}
									other.input.prop("checked", checked);
								}
							}
							if (!checked) {
								for (p in options) {
									other = options[p];
									if (other.input.prop("checked")) {
										other.forceSelections(true);
									}
								}
							} else {
								i = includes.length;
								while (--i > -1) {
									options[includes[i]].included = true;
								}
							}
						};
				this.input.change(function(e){
					forceSelections(this.checked);
				});
			},
			options = {
				TweenMax:new CustomOption("TweenMax", ["TweenLite","TimelineLite","TimelineMax","CSSPlugin","EasePack","RoundPropsPlugin","BezierPlugin","AttrPlugin","DirectionalRotationPlugin"]),
				TweenLite:new CustomOption("TweenLite"),
				TimelineMax:new CustomOption("TimelineMax", ["TimelineLite"], ["TweenLite"]),
				TimelineLite:new CustomOption("TimelineLite", [], ["TweenLite"]),
				EasePack:new CustomOption("EasePack", [], ["TweenLite"], "easing/"),
				jqueryGSAP:new CustomOption("jqueryGSAP", [], ["TweenLite","CSSPlugin"]),
				CSSPlugin:new CustomOption("CSSPlugin", [], ["TweenLite"], "plugins/"),
				CSSRulePlugin:new CustomOption("CSSRulePlugin", [], ["CSSPlugin","TweenLite"], "plugins/"),
				RaphaelPlugin:new CustomOption("RaphaelPlugin", [], ["TweenLite"], "plugins/"),
				RoundPropsPlugin:new CustomOption("RoundPropsPlugin", [], ["TweenLite"], "plugins/"),
				ColorPropsPlugin:new CustomOption("ColorPropsPlugin", [], ["TweenLite"], "plugins/"),
				BezierPlugin:new CustomOption("BezierPlugin", [], ["TweenLite"], "plugins/"),
				EaselPlugin:new CustomOption("EaselPlugin", [], ["TweenLite"], "plugins/"),
				AttrPlugin:new CustomOption("AttrPlugin", [], ["TweenLite"], "plugins/"),
				DirectionalRotationPlugin:new CustomOption("DirectionalRotationPlugin", [], ["TweenLite"], "plugins/"),
				TextPlugin:new CustomOption("TextPlugin", [], ["TweenLite"], "plugins/"),
				ScrollToPlugin:new CustomOption("ScrollToPlugin", [], ["TweenLite"], "plugins/"),
				KineticPlugin:new CustomOption("KineticPlugin", [], ["TweenLite"], "plugins/"),
				Draggable:new CustomOption("Draggable", [], ["CSSPlugin","TweenLite"], "utils/")
			},
			Flavor = function(name) {
				this.name = name = name.toUpperCase();
				this.panel = $("#dl_panel" + this.name);
				var tab = this.tab = $("#dl_tab" + this.name),
						selectedColor = this.selectedColor = (name === "JS") ? "#0033cc" : (name === "AS2") ? "#ff6600" : "#dc0000",
						color = this.color = (name === "JS") ? "#0029a3" : (name === "AS2") ? "#cc5200" : "#b00000";
				this.tab.on("click", function(e) {
					if (!selectedFlavor) {
						collapseTabs().add(showFlavor(name), 0);
					} else if (selectedFlavor.name !== name) {
						showFlavor(name);
					}
				});
				this.tab.hover(function() {
					TweenLite.to(tab, 0.2, {backgroundColor:selectedColor});
				}, function() {
					if (!selectedFlavor || selectedFlavor.name !== name) {
						TweenLite.to(tab, 0.2, {backgroundColor:color});
					}
				});
			},
			flavors = [new Flavor("JS"), new Flavor("AS3"), new Flavor("AS2")],
			cdnTooltip, selectedCDN, selectedGSAPVersion, submissionInProgress, selectedFlavor, exportedRoot;


	window.downloadGSAP = function(flavor) {
		var container = $("#dl_GSAP")[0],
				pickFlavor = $("#dl_pickFlavor")[0],
				tabHeight = 38,
				panelHeight = 382,
				tabOffset = 60,
				totalHeight = tabHeight + panelHeight + 20 - tabOffset,
				i = flavors.length;
		if (!container) {
			return;
		}
		if (flavor) {
			flavor = flavor.toUpperCase();
		}
		selectedFlavor = null;

		exportedRoot = TimelineLite.exportRoot();
		exportedRoot.pause();

		while (--i > -1) {
			TweenLite.set(flavors[i].tab, {autoAlpha:1, backgroundColor:flavors[i].color});
		}
		TweenLite.set(pickFlavor, {autoAlpha:1, clearProps:"transform"});
		TweenLite.set(".dl_panel", {autoAlpha:0});
		TweenLite.set(container, {scale:0.5, rotationX:70, autoAlpha:0, y:-300, z:-500, transformPerspective:600, display:"block"});
		TweenLite.to("#dl_dimmer", 0.2, {autoAlpha:0.6});
		TweenLite.to(container, 0.25, {autoAlpha:1, scale:1, ease:Back.easeOut.config(1.5), delay:0.1});
		TweenLite.to(container, 0.4, {rotationX:0, y:0, z:0, ease:Back.easeOut.config(1), delay:0.15, clearProps:"transform"});
		if (flavor === "JS" || flavor === "AS3" || flavor === "AS2") {
			collapseTabs(true);
			showFlavor(flavor, true);
		} else {
			TweenLite.set("#dl_flavors", {height:(totalHeight + tabOffset)});
			TweenLite.set(".dl_tab", {paddingTop:tabOffset, height:totalHeight});
		}
		return false;
	};

	function showFlavor(flavor, immediate) {
		var i = 3,
			tl = new TimelineLite(),
			f, next;
		flavor = flavor.toUpperCase();
		if (selectedFlavor && selectedFlavor.name === flavor) {
			return;
		}
		if (!selectedFlavor || flavor !== selectedFlavor.name) {
			while (--i > -1) {
				f = flavors[i];
				if (f.name === flavor) {
					next = f;
					tl.to(f.tab, 0.2, {opacity:1, backgroundColor:f.selectedColor}, 0);
				} else {
					tl.to(f.tab, 0.2, {opacity:0.65}, 0);
				}
			}
		}
		if (next) {
			tl.fromTo(next.panel, 0.6, {rotationX:90, transformPerspective:1000, autoAlpha:0, transformOrigin:"50% 50% -100px"}, {rotationX:0, autoAlpha:1, ease:Power2.easeInOut, clearProps:"transform", immediateRender:true}, 0);
		}
		if (selectedFlavor) {
			tl.fromTo(selectedFlavor.panel, 0.6, {rotationX:0, autoAlpha:1, transformPerspective:1000, transformOrigin:"50% 50% -100px"}, {rotationX:-90, autoAlpha:0, ease:Power2.easeInOut, clearProps:"transform", immediateRender:true}, 0);
		}
		selectedFlavor = next;
		if (immediate === true) {
			tl.seek( tl.duration() );
		}
		return tl;
	}

	function collapseTabs(immediate) {
		var tl = new TimelineLite(),
			tabs = $(".dl_tab");
		tl.staggerTo(tabs, 0.2, {paddingTop:0, height:38, ease:Power1.easeIn}, 0.1)
		  .staggerTo(tabs, 0.25, {bezier:[{y:-30}, {y:0}], ease:Power2.easeOut}, 0.1, 0.2)
		  .to("#dl_pickFlavor", 0.2, {autoAlpha:0, scale:1.4}, 0);
		if (immediate === true) {
			tl.seek(tl.duration());
		}
		return tl;
	}


//---- INITIALIZATION -------------------------------------------

	function init() {
		initFormDefaults();
		populateVersions();
		updateCDNCode();
		initAutoSelectingDiv("#dl_cdnCode");
		$("#dl_GSAP input, #dl_GSAP select").change(updateCDNCode);
		$("#dl_cdnCustomize").on("click", toggleCustomize);
		TweenLite.set("#dl_cdnForm", {perspective:600});
		TweenLite.set("#dl_dimmer", {autoAlpha:0});
		TweenLite.set("#dl_GSAP", {autoAlpha:0, display:"none", transformOrigin:"50% 20%"});

		initTooltips();

		if (!$.support.opacity) {
			TweenLite.set("#dl_email", {width:104, marginBottom:0});
		}

		$("#dl_dimmer").on("click", closeDownloadGSAP);
		$("#dl_joinBtn").on("click", function(e) {
			if (submissionInProgress) {
				return false;
			}
			e.preventDefault();
			var email = $("#dl_email").val();
			if (!/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email)) {
				$("#dl_email").css({border:"2px solid red"});
				return false;
			}
			$("#dl_email").css({border:"1px solid #ccc"});
			submissionInProgress = true;

			$.ajax({
				url: "//www.greensock.com/gsbo/email_signup.php",
				type: "POST",
				crossDomain:true,
				data: {email:$("#dl_email").val()},
				cache:false,
				dataType:"text",
				success: function(value) {
					var code = Number(value),
							body = "",
							header = "";
					submissionInProgress = false;
					if (code === 1) {
						header = "Congratulations";
						body = "You're signed up and ready to go. Welcome. An email should arrive shortly. In the mean time, enjoy some tasty code.";
						$("#dl_email, #dl_joinBtn").fadeOut();
					} else if (code === 2) {
						header = "Gotcha";
						body = "Looks like you've already got a GreenSock account. Good! Nice to have you back.";
						$("#dl_email, #dl_joinBtn").fadeOut();
					} else if (code === 3) {
						$("#dl_email").css({border:"2px solid red"});
						return;
					} else {
						header = "Wups";
						body = "Looks like there was a problem. Please try again.";
					}
					$("#dl_emailHeader").text(header);
					$("#dl_emailBody").text(body);
				},
				error: function(e, txt) {
					$("#dl_emailHeader").text("Wups");
					$("#dl_emailBody").text("Looks like there was a problem. Please try again.");
				}
			});
			return false;
		});
		
		var i = document.URL.indexOf("?"),
			a, pair, val;
		if (i !== -1) {
			a = document.URL.substr(i+1).split("&");
			i = a.length;
			while (--i > -1) {
				pair = a[i].split("=");
				val = (pair[1] || "").toUpperCase();
				if (pair[0] === "download" && val.indexOf("GSAP") !== -1) {
					window.downloadGSAP(val.replace("GSAP-", ""));
					break;
				}
			}
		}
	}

	function populateVersions() {
		var select = $("#dl_cdnVersion"),
				jsVersions = gsapData.js.version,
				i;
		$("#dl_panelJS .dl_version strong").text(jsVersions[0]);
		if (gsapData.cdnPending) {
			jsVersions.shift();
		}
		for (i = 0; i < jsVersions.length; i++) {
			select.append( $("<option>", {value:jsVersions[i], selected:(i === 0)}).text(jsVersions[i]) );
		}
		$("#dl_panelJS .dl_version span").text(gsapData.js.updated);
		$("#dl_panelAS3 .dl_version strong").text(gsapData.as3.version);
		$("#dl_panelAS3 .dl_version span").text(gsapData.as3.updated);
		$("#dl_panelAS2 .dl_version strong").text(gsapData.as2.version);
		$("#dl_panelAS2 .dl_version span").text(gsapData.as2.updated);
	}

	function initTooltips() {
		var a = ["robust","lightweight","customize"],
				i = 3,
				tooltip, area;
		while (--i > -1) {
			tooltip = $("#dl_"+a[i]+"Tooltip");
			TweenLite.set(tooltip, {y:15, autoAlpha:0, rotationX:-90});
			area = $("#dl_"+a[i]+"Area");
			if (area[0]) {
				area.hover(showTooltip, hideTooltip)[0].tooltip = tooltip;
			}
		}
	}

	function showTooltip(e) {
		if (!cdnCustomizeOpen) {
			TweenLite.to(this.tooltip, 0.2, {y:0, autoAlpha:1, rotationX:0});
		}
	}

	function hideTooltip(e) {
		TweenLite.to(this.tooltip, 0.35, {autoAlpha:0, y:15, rotationX:-90});
	}

	function closeDownloadGSAP() {
		TweenLite.to("#dl_dimmer", 0.3, {autoAlpha:0, delay:0.15});
		TweenLite.set("#dl_GSAP", {transformPerspective:600});
		TweenLite.to("#dl_GSAP", 0.3, {rotationX:70, y:-300, z:-500, autoAlpha:0, clearProps:"transform", display:"none", ease:Power1.easeIn});
		selectedFlavor = null;
		if (exportedRoot) {
			exportedRoot.resume();
		}
	}


//----CDN FORM ----------------------------------------------------

	function updateCDNCode() {
		selectedGSAPVersion = $("#dl_cdnVersion").val();
		var selectedGroup = $("input:radio[name=cdnGroup]:checked").val(),
				code = $("#dl_cdnCode"),
				prefix = '&lt;script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/' + selectedGSAPVersion + '/',
				suffix = '.min.js"&gt;&lt;/script&gt;',
				customize = (selectedGroup === "customize"),
				links, i, p;
		if (!customize && cdnCustomizeOpen) {
			toggleCustomize();
		}
		if (selectedGroup === "robust") {
			links = ["TweenMax"];
		} else if (selectedGroup === "lightweight") {
			links = ["plugins/CSSPlugin","easing/EasePack","TweenLite"];
		} else {
			links = [];
			for (p in options) {
				if (options[p].input.prop("checked") && !options[p].included) {
					links.push(options[p].path);
				}
			}
		}
		for (i = 0; i < links.length; i++) {
			links[i] = prefix + links[i] + suffix;
		}
		if (code[0]) {
			code[0].innerHTML = links.join("<br />");
		}
	}

	function toggleCustomize() {
		var area = document.getElementById("dl_customizeArea");
		cdnCustomizeOpen = !cdnCustomizeOpen;
		TweenLite.to("#dl_panelJSInner", 0.5, {marginTop:(cdnCustomizeOpen ? -124 : 0), ease:Power3.easeOut, delay:0.08});
		TweenLite.to("#dl_cdnOptions", 0.25, {autoAlpha:(cdnCustomizeOpen ? 1 : 0), delay:0.08});
		if (cdnCustomizeOpen && area) {
			TweenLite.set(area.tooltip, {autoAlpha:0, y:15, rotationX:-90});
			TweenMax.staggerFromTo(cdnOptions, 0.35, {y:80, autoAlpha:0}, {y:0, autoAlpha:1, immediateRender:true, delay:0.12, ease:Back.easeOut}, 0.03);
		}
	}

	function initFormDefaults() {
		var clearDefaultText = function(e) {
					var input = window.event ? window.event.srcElement : e ? e.target : null;
					if (!input) {
						return;
					}
					if (input.value === input.defaultText) {
						input.value = "";
						input.className += " defaultCleared";
					}
				},
				replaceDefaultText = function(e) {
					var input = window.event ? window.event.srcElement : e ? e.target : null;
					if (!input) {
						return;
					}
					if (input.value === "" && input.defaultText) {
						input.value = input.defaultText;
						input.className = input.className.split("defaultCleared").join("");
					}
				},
				inputs = document.getElementsByTagName("input"),
				i = inputs.length,
				input;
		while (--i > -1) {
			input = inputs[i];
			if (input.type === "text" && input.className.match(/\bclearDefault\b/)) {
				addEvent(input, "focus", clearDefaultText, false);
				addEvent(input, "blur", replaceDefaultText, false);
				if (input.value !== "") {
					input.defaultText = input.value;
				}
			}
		}
	}


//---- GENERAL --------------------------------------------------------

	function addEvent(element, type, func, capture) {
		return (element.addEventListener) ? element.addEventListener(type, func, capture) : (element.attachEvent) ? element.attachEvent('on' + type, func) : false;
	}

	var selectTextElement;
	function initAutoSelectingDiv(selector) {
		var selectText = function(element) {
			if (selectTextElement === element) {
				return;
			}
			var range;
			if (document.selection) {
				range = document.body.createTextRange();
				range.moveToElementText(element);
				range.select();
			} else if (window.getSelection) {
				range = document.createRange();
				range.selectNode(element);
				window.getSelection().addRange(range);
			}
			selectTextElement = element;
		};

		$(selector).on("click", function(e) {
			selectText(this);
		}).on("mouseout", function(e) {
			selectTextElement = null;
		});
	}

	init();
});




//---- Andy's scripts below ------------------------

var imgUrl = '/wp-content/themes/greensock/images/';

function homeFlashObj() {
  if (document.getElementById('introFlash')) {
    swfobject.registerObject('introFlash',"9.0.0");
  }
}


function loadProductAgreement(product_price_id) {
  $.getJSON('/gsbo/load_agreement.php?id=' + product_price_id,function(r) {
    $('.termsCopy').html(r.agreement_text);
    $('.agreeButton').unbind().click(function() {
      document.location = r.product_link;
    });
    showOverlay('productpriceTerms');
  });
}

function loadProductAgreement2(product_price_id) {
  $.getJSON('/gsbo/load_agreement2.php?id=' + product_price_id,function(r) {
    $('.termsCopy').html(r.agreement_text);
    $('.agreeButton').unbind().click(function() {
      document.location = r.product_link;
    });
    showOverlay('productpriceTerms');
  });
}

function toggleVisible(e) {
	var h = e.find("div").first().outerHeight(),
		dur = h / 800; 
	if (dur < 0.2) {
		dur = 0.2;
	} else if (dur > 2) {
		dur = 2;
	}
	if (e[0]._visible) {
		TweenLite.to(e[0], dur, {css:{height:0}, onUpdate:sizeShadows});
	} else {
		TweenLite.to(e[0], dur, {css:{height:h}, onUpdate:sizeShadows});
	}
	e[0]._visible = !(e[0]._visible == true);
}

$(function() {
  sizeShadows();
  if ($.browser.msie && parseInt($.browser.version)==7) {
    if ($('.project-post').height()>0) {
      $('#main').height($('.project-post').height()+$('.project-top').height());
    }
  } else {
    if (!($.browser.msie && parseInt($.browser.version) == 8)) {
      homeFlashObj();
    }
  }
  if ($.browser.msie) {
    $('.termsWindow').css('margin-left','0px');
  }
  var precache = [ imgUrl + 'submit_comment_on.png', 
           imgUrl + 'button_left_on.png',
           imgUrl + 'button_right_on.png',
           imgUrl + 'button_mid_on.png' ]

  for (i=0;i<precache.length;i++) {
    var img = document.createElement('img');
    img.src = precache[i];
  }

  $('#submit').hover(function() {
    $('#submit').attr('src', imgUrl + 'submit_comment_on.png');
  },function() {
    $('#submit').attr('src', imgUrl + 'submit_comment_off.png');  
  });
 
  $('.button-mid,.button-left,.button-right').hover(function() {
    if ($(this).is('.button-left')) {
      highliteButton($(this).next('.button-mid'));
    } else if ($(this).is('.button-right')) {
      highliteButton($(this).prev('.button-mid'));
    } else {
      highliteButton(this);
    }

  },function() {
    if ($(this).is('.button-left')) {
      highliteButtonOff($(this).next('.button-mid'));
    } else if ($(this).is('.button-right')) {
      highliteButtonOff($(this).prev('.button-mid'));
    } else {
      highliteButtonOff(this);
    }
  });

  $('.button-left,.button-right').click(function() {
    var a;
    if ($(this).is('.button-left')) {
      a = $(this).next('.button-mid').children('a').get(0);
    } else if ($(this).is('.button-right')) {
      a = $(this).prev('.button-mid').children('a').get(0);
    } 
    document.location = a.href;
  });

  function highliteButton(buttonMid) {
    $(buttonMid).addClass('button-on')
      .prev('.button-left')
      .addClass('button-on')
      .next().next('.button-right')
      .addClass('button-on');
    $(buttonMid).children('a').css('color','#fff');
  }

  function highliteButtonOff(buttonMid) {
    $(buttonMid).removeClass('button-on')
      .prev('.button-left')
      .removeClass('button-on')
      .next().next('.button-right')
      .removeClass('button-on');
    $(buttonMid).children('a').css('color','');
  }

  $('#searchform').submit(function() {
    if ($('#search-toggle-forums').is(':checked')) {
        $('#searchform').attr('action','http://forums.greensock.com/index.php?app=core&module=search&do=search&fromMainBar=1');
        $('#search_site').attr('name','search_term');
        $('#searchform').attr('method','post');
    }   
  });
 
  $('#toggle-orders').toggle(function() {
    $(this).text('hide');
    $('#orders-table').slideDown();
  },function() {
    $(this).text('show');
    $('#orders-table').slideUp();
  });


  $(".expandable").css("cursor", "pointer").click(function(e) {
  	toggleVisible($(this).find(".expContent"));
  });

  $("body").resize(function() {
		TweenLite.killTweensOf(sizeShadows);
		TweenLite.delayedCall(0.1, sizeShadows);
  });
});


$(window).resize(function() {
  sizeShadows();
});


function sizeShadows() {
	var right = $('.drop-shadow-right'),
		left = $('.drop-shadow-left');
  right.height(0);
  left.height(0);
  var height = $('.drop-shadow-bottom-container').offset().top - right.offset().top;
  right.height(height);
  left.height(height);
}
$(window).load(sizeShadows);

