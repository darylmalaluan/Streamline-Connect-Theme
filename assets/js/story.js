(function () {
	var root = document.querySelector("[data-story-carousel]");
	if (!root) {
		return;
	}

	var viewport = root.querySelector(".story-viewport");
	var track = root.querySelector(".story-track");
	var originals = Array.prototype.slice.call(root.querySelectorAll(".story-card"));
	var count = root.querySelector("[data-story-count]");
	var thumb = root.querySelector("[data-story-thumb]");
	var prev = root.querySelector("[data-story-prev]");
	var next = root.querySelector("[data-story-next]");
	var index = 0;
	var timer = 0;
	var paused = false;
	var reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
	var delay = 5000;

	if (!viewport || !track || !originals.length || !prev || !next) {
		return;
	}

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
			track.appendChild(clone);
		}
	}

	function paint(animate) {
		var card = originals[0].getBoundingClientRect().width;
		var offset = index * (card + gap());
		track.style.transition = animate && !reduce ? "" : "none";
		track.style.transform = "translateX(" + (offset ? -offset : 0) + "px)";
		if (!animate || reduce) {
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
		if (reduce || paused || !canSlide()) {
			return;
		}
		timer = window.setInterval(advance, delay);
	}

	prev.addEventListener("click", function () {
		go(index - 1, true);
		start();
	});
	next.addEventListener("click", function () {
		advance();
		start();
	});

	root.addEventListener("keydown", function (event) {
		if (event.key === "ArrowRight") {
			advance();
			start();
		} else if (event.key === "ArrowLeft") {
			go(index - 1, true);
			start();
		}
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
