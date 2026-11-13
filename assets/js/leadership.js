(function () {
	var root = document.querySelector("[data-leadership-carousel]");
	if (!root) {
		return;
	}

	var viewport = root.querySelector(".leadership-viewport");
	var track = root.querySelector(".leadership-track");
	var originals = Array.prototype.slice.call(root.querySelectorAll(".leader-card"));
	var count = root.querySelector("[data-leadership-count]");
	var thumb = root.querySelector("[data-leadership-thumb]");
	var prev = root.querySelector("[data-leadership-prev]");
	var next = root.querySelector("[data-leadership-next]");
	var index = 0;
	var timer = 0;
	var paused = false;
	var reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
	var delay = 5000;

	function gap() {
		var styles = window.getComputedStyle(track);
		return parseFloat(styles.columnGap || styles.gap) || 0;
	}

	function visible() {
		var card = originals[0].getBoundingClientRect().width;
		var view = viewport.getBoundingClientRect().width;
		if (!card || !view) {
			return 1;
		}
		return Math.max(1, Math.min(originals.length, Math.round((view + gap()) / (card + gap()))));
	}

	function canSlide() {
		return originals.length > visible();
	}

	function logical() {
		return ((index % originals.length) + originals.length) % originals.length;
	}

	function label() {
		var start = logical();
		var shown = canSlide() ? visible() : originals.length;
		var first = start + 1;
		var last = ((start + shown - 1) % originals.length) + 1;
		if (shown <= 1 || first === last) {
			return first + " / " + originals.length;
		}
		return first + "\u2013" + last + " / " + originals.length;
	}

	function syncClones() {
		Array.prototype.forEach.call(track.querySelectorAll("[data-clone]"), function (node) {
			node.remove();
		});
		if (!canSlide()) {
			return;
		}
		var copies = visible();
		for (var i = 0; i < copies; i++) {
			var clone = originals[i].cloneNode(true);
			clone.setAttribute("data-clone", "true");
			clone.setAttribute("aria-hidden", "true");
			Array.prototype.forEach.call(clone.querySelectorAll("button"), function (button) {
				button.tabIndex = -1;
			});
			track.appendChild(clone);
		}
	}

	function paint(animate) {
		var card = originals[0].getBoundingClientRect().width;
		var offset = index * (card + gap());
		track.style.transition = animate ? "" : "none";
		track.style.transform = "translateX(" + (offset ? -offset : 0) + "px)";
		if (!animate) {
			track.offsetHeight;
			track.style.transition = "";
		}
		prev.disabled = !canSlide();
		next.disabled = !canSlide();
		if (count) {
			count.textContent = label();
		}
		if (thumb) {
			var travel = thumb.parentElement.clientWidth - thumb.offsetWidth;
			var shift = canSlide() ? (logical() / originals.length) * Math.max(0, travel) : 0;
			thumb.style.width = canSlide() ? "18.8%" : "100%";
			thumb.style.transform = "translateX(" + shift + "px)";
		}
	}

	function go(nextIndex, animate) {
		index = nextIndex;
		if (index < 0) {
			index = originals.length;
			paint(false);
			window.requestAnimationFrame(function () {
				index = originals.length - 1;
				paint(true);
			});
			return;
		}
		paint(animate !== false);
	}

	function advance() {
		if (!canSlide()) {
			return;
		}
		go(index + 1, true);
	}

	function stop() {
		window.clearInterval(timer);
		timer = 0;
	}

	function start() {
		stop();
		if (reduce || paused || !canSlide() || root.querySelector(".leader-card.is-open")) {
			return;
		}
		timer = window.setInterval(advance, delay);
	}

	function closeCard(card) {
		var overlay = card.querySelector(".leader-overlay");
		var button = card.querySelector(".leader-more");
		if (!overlay || !card.classList.contains("is-open")) {
			return;
		}
		card.classList.add("is-closing");
		card.classList.remove("is-open");
		if (button) {
			button.setAttribute("aria-expanded", "false");
		}
		window.setTimeout(function () {
			overlay.hidden = true;
			card.classList.remove("is-closing");
			if (!root.querySelector(".leader-card.is-open")) {
				start();
			}
		}, 260);
	}

	function openCard(card) {
		stop();
		originals.forEach(function (other) {
			if (other !== card) {
				closeCard(other);
			}
		});
		var overlay = card.querySelector(".leader-overlay");
		var button = card.querySelector(".leader-more");
		if (!overlay) {
			return;
		}
		overlay.hidden = false;
		window.requestAnimationFrame(function () {
			card.classList.add("is-open");
		});
		if (button) {
			button.setAttribute("aria-expanded", "true");
		}
		var close = card.querySelector(".leader-close");
		if (close) {
			close.focus();
		}
	}

	prev.addEventListener("click", function () {
		go(index - 1, true);
		start();
	});
	next.addEventListener("click", function () {
		advance();
		start();
	});

	track.addEventListener("transitionend", function (event) {
		if (event.target !== track || event.propertyName !== "transform") {
			return;
		}
		if (index >= originals.length) {
			index = index % originals.length;
			paint(false);
		}
	});

	root.addEventListener("mouseenter", function () {
		paused = true;
		stop();
	});
	root.addEventListener("mouseleave", function () {
		paused = false;
		start();
	});
	root.addEventListener("focusin", function () {
		paused = true;
		stop();
	});
	root.addEventListener("focusout", function (event) {
		if (root.contains(event.relatedTarget)) {
			return;
		}
		paused = false;
		start();
	});

	originals.forEach(function (card) {
		var more = card.querySelector(".leader-more");
		var close = card.querySelector(".leader-close");
		if (more) {
			more.addEventListener("click", function () {
				if (card.classList.contains("is-open")) {
					closeCard(card);
					return;
				}
				openCard(card);
			});
		}
		if (close) {
			close.addEventListener("click", function () {
				closeCard(card);
				if (more) {
					more.focus();
				}
			});
		}
	});

	document.addEventListener("keydown", function (event) {
		if (event.key !== "Escape") {
			return;
		}
		originals.forEach(closeCard);
	});

	root.classList.add("is-ready");
	syncClones();
	paint(false);
	start();
	window.addEventListener("resize", function () {
		index = logical();
		syncClones();
		paint(false);
		start();
	});
})();
