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
