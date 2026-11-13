(function () {
	/*
	 * Same reveal as Alpha Solar Tech. Hero blocks use data-reveal-on="load".
	 * Other blocks fade up 20px when 15% of them enters the viewport.
	 * ?noreveal or reduced motion shows everything at once.
	 */
	var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
	var skipReveal = reduceMotion || new URLSearchParams(window.location.search).has("noreveal");

	function revealAll(nodes) {
		nodes.forEach(function (node) {
			node.classList.add("is-revealed");
		});
	}

	var revealNodes = Array.prototype.slice.call(document.querySelectorAll("[data-reveal]"));

	if (skipReveal || !("IntersectionObserver" in window)) {
		revealAll(revealNodes);
	} else {
		var loadNodes = revealNodes.filter(function (node) {
			return node.getAttribute("data-reveal-on") === "load";
		});
		window.requestAnimationFrame(function () {
			window.requestAnimationFrame(function () {
				revealAll(loadNodes);
			});
		});

		var revealObserver = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (!entry.isIntersecting) {
						return;
					}
					entry.target.classList.add("is-revealed");
					revealObserver.unobserve(entry.target);
				});
			},
			{ threshold: 0.15, rootMargin: "0px 0px -10% 0px" }
		);

		revealNodes.forEach(function (node) {
			if (node.getAttribute("data-reveal-on") !== "load") {
				revealObserver.observe(node);
			}
		});
	}

	/*
	 * Count each stat figure up once its strip enters the viewport.
	 * A leading mark such as "< " stays put while the number runs.
	 */
	var statStrips = Array.prototype.slice.call(document.querySelectorAll(".stats"));

	function parseStat(text) {
		var match = text.match(/^(.*?)(\d[\d,]*)(.*)$/);
		if (!match) {
			return null;
		}
		return {
			prefix: match[1],
			value: parseInt(match[2].replace(/,/g, ""), 10),
			suffix: match[3],
			grouped: match[2].indexOf(",") !== -1
		};
	}

	function formatStat(parsed, value) {
		var digits = parsed.grouped ? value.toLocaleString("en-AU") : String(value);
		return parsed.prefix + digits + parsed.suffix;
	}

	function countStat(figure, delay) {
		var parsed = parseStat(figure.textContent.trim());
		if (!parsed || figure.getAttribute("data-counted") === "1") {
			return;
		}
		figure.setAttribute("data-counted", "1");
		if (reduceMotion) {
			return;
		}
		figure.style.minWidth = figure.getBoundingClientRect().width + "px";
		window.setTimeout(function () {
			var start = null;
			var duration = Math.min(1400, Math.max(700, parsed.value * 4));
			function step(now) {
				if (start === null) {
					start = now;
				}
				var progress = Math.min(1, (now - start) / duration);
				var eased = 1 - Math.pow(1 - progress, 3);
				figure.textContent = formatStat(parsed, Math.round(parsed.value * eased));
				if (progress < 1) {
					window.requestAnimationFrame(step);
				}
			}
			window.requestAnimationFrame(step);
		}, delay);
	}

	function playStats(strip) {
		Array.prototype.forEach.call(strip.querySelectorAll(".stat-figure"), function (figure, index) {
			countStat(figure, index * 80);
		});
	}

	if (statStrips.length) {
		if (reduceMotion || !("IntersectionObserver" in window)) {
			statStrips.forEach(playStats);
		} else {
			var statObserver = new IntersectionObserver(
				function (entries) {
					entries.forEach(function (entry) {
						if (!entry.isIntersecting) {
							return;
						}
						playStats(entry.target);
						statObserver.unobserve(entry.target);
					});
				},
				{ threshold: 0.4 }
			);
			statStrips.forEach(function (strip) {
				statObserver.observe(strip);
			});
		}
	}

	var header = document.querySelector("[data-header]");
	if (!header) {
		return;
	}

	var menuBtn = header.querySelector("[data-menu-toggle]");
	var toggles = Array.prototype.slice.call(header.querySelectorAll("[data-nav-toggle]"));
	var panels = Array.prototype.slice.call(header.querySelectorAll(".mega"));
	var scrim = document.querySelector("[data-scrim]");
	var desktop = window.matchMedia("(min-width: 1440px)");
	var reduce = window.matchMedia("(prefers-reduced-motion: reduce)");
	var openPanel = null;

	function menuOpen() {
		return header.classList.contains("is-menu-open");
	}

	function panelOpen() {
		return openPanel !== null;
	}

	function clearSlide(panel) {
		panel.style.height = "";
		panel.style.overflow = "";
		panel.style.transition = "";
		panel.style.zIndex = "";
	}

	function slideOpen(panel) {
		panel.hidden = false;
		panel.style.zIndex = "46";
		if (reduce.matches) {
			clearSlide(panel);
			return;
		}
		panel.style.overflow = "hidden";
		panel.style.transition = "none";
		panel.style.height = "auto";
		var target = panel.offsetHeight;
		panel.style.height = "0px";
		panel.getBoundingClientRect();
		panel.style.transition = "";
		panel.style.height = target + "px";
		var token = {};
		panel._slide = token;
		function done(event) {
			if (event.target !== panel || event.propertyName !== "height" || panel._slide !== token) {
				return;
			}
			panel.removeEventListener("transitionend", done);
			if (openPanel === panel) {
				panel.style.height = "auto";
				panel.style.overflow = "";
			}
		}
		panel.addEventListener("transitionend", done);
	}

	function slideClosed(panel) {
		if (panel.hidden) {
			return;
		}
		if (reduce.matches) {
			panel.hidden = true;
			clearSlide(panel);
			return;
		}
		var token = {};
		panel._slide = token;
		panel.style.overflow = "hidden";
		panel.style.transition = "none";
		panel.style.height = panel.getBoundingClientRect().height + "px";
		panel.getBoundingClientRect();
		panel.style.transition = "";
		panel.style.height = "0px";
		function done(event) {
			if (event.target !== panel || event.propertyName !== "height" || panel._slide !== token) {
				return;
			}
			panel.removeEventListener("transitionend", done);
			if (openPanel !== panel) {
				panel.hidden = true;
				clearSlide(panel);
			}
		}
		panel.addEventListener("transitionend", done);
	}

	function setOpen(menu, panel) {
		var previous = openPanel;
		openPanel = panel || null;
		header.classList.toggle("is-menu-open", menu);
		header.classList.toggle("is-mega-open", !!openPanel);
		header.classList.toggle("is-capabilities-open", !!(openPanel && openPanel.id === "capabilities_menu"));
		if (menuBtn) {
			menuBtn.setAttribute("aria-expanded", menu ? "true" : "false");
		}
		toggles.forEach(function (btn) {
			var controls = document.getElementById(btn.getAttribute("aria-controls"));
			btn.setAttribute("aria-expanded", controls && controls === openPanel ? "true" : "false");
		});
		panels.forEach(function (node) {
			if (node === openPanel) {
				slideOpen(node);
			} else if (node === previous) {
				slideClosed(node);
			} else if (!node.hidden) {
				node.hidden = true;
				clearSlide(node);
			}
		});
		if (scrim) {
			scrim.hidden = !(menu || openPanel);
		}
		document.body.classList.toggle("nav-lock", menu || openPanel);
	}

	function closeMenus(focusEl) {
		setOpen(false, null);
		if (focusEl && typeof focusEl.focus === "function") {
			focusEl.focus();
		}
	}

	function focusable(root) {
		return Array.prototype.filter.call(
			root.querySelectorAll("a, button, [tabindex]:not([tabindex='-1'])"),
			function (el) {
				return !el.hidden && el.getClientRects().length > 0;
			}
		);
	}

	if (menuBtn) {
		menuBtn.addEventListener("click", function () {
			if (menuOpen()) {
				closeMenus(menuBtn);
				return;
			}
			setOpen(true, false);
			var first = header.querySelector(".nav-cta--menu");
			if (first) {
				first.focus();
			}
		});
	}

	toggles.forEach(function (btn) {
		btn.addEventListener("click", function () {
			var panel = document.getElementById(btn.getAttribute("aria-controls"));
			if (panel && openPanel === panel) {
				if (desktop.matches) {
					closeMenus(btn);
				} else {
					setOpen(true, null);
					btn.focus();
				}
				return;
			}
			if (desktop.matches) {
				setOpen(false, panel);
			} else {
				setOpen(true, panel);
			}
		});
	});

	if (scrim) {
		scrim.addEventListener("click", function () {
			var toggle = toggles.filter(function (btn) {
				return btn.getAttribute("aria-expanded") === "true";
			})[0];
			closeMenus(menuOpen() ? menuBtn : toggle);
		});
	}

	document.addEventListener("keydown", function (event) {
		if (event.key === "Escape" && (menuOpen() || panelOpen())) {
			event.preventDefault();
			var toggle = toggles.filter(function (btn) {
				return btn.getAttribute("aria-expanded") === "true";
			})[0];
			closeMenus(menuOpen() ? menuBtn : toggle);
			return;
		}

		if (event.key !== "Tab" || (!menuOpen() && !panelOpen())) {
			return;
		}

		var root = menuOpen() ? header.querySelector("#site_nav") : header;
		var items = focusable(root);
		if (!items.length) {
			return;
		}

		var first = items[0];
		var last = items[items.length - 1];
		if (event.shiftKey && document.activeElement === first) {
			event.preventDefault();
			last.focus();
		} else if (!event.shiftKey && document.activeElement === last) {
			event.preventDefault();
			first.focus();
		}
	});

	desktop.addEventListener("change", function () {
		closeMenus(null);
	});

	var stickAt = 150;
	var stuck = false;
	var spacer = document.querySelector("[data-header-spacer]");

	function updateStick() {
		var next = window.scrollY >= stickAt;
		if (next === stuck) {
			return;
		}
		stuck = next;
		header.classList.toggle("is-stuck", stuck);
		if (spacer) {
			spacer.hidden = !stuck;
		}
	}

	updateStick();
	window.addEventListener("scroll", updateStick, { passive: true });

	document.querySelectorAll('a[href^="#"]').forEach(function (link) {
		link.addEventListener("click", function (event) {
			var id = link.getAttribute("href").slice(1);
			var behavior = reduce.matches ? "auto" : "smooth";

			if (!id || id === "top") {
				event.preventDefault();
				window.scrollTo({ top: 0, behavior: behavior });
				var logo = document.querySelector(".logo");
				if (logo) {
					logo.focus({ preventScroll: true });
				}
				closeMenus(null);
				return;
			}

			var target = document.getElementById(id);
			if (!target) {
				return;
			}

			event.preventDefault();
			target.scrollIntoView({ behavior: behavior, block: "start" });
			if (!target.hasAttribute("tabindex")) {
				target.setAttribute("tabindex", "-1");
			}
			target.focus({ preventScroll: true });
			closeMenus(null);
		});
	});
})();
