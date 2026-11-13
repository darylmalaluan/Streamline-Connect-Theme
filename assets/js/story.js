(function () {
	var root = document.querySelector("[data-story-carousel]");
	if (!root) {
		return;
	}

	var viewport = root.querySelector(".story-viewport");
	var track = root.querySelector(".story-track");
	var cards = Array.prototype.slice.call(root.querySelectorAll(".story-card"));
	var count = root.querySelector("[data-story-count]");
	var thumb = root.querySelector("[data-story-thumb]");
	var prev = root.querySelector("[data-story-prev]");
	var next = root.querySelector("[data-story-next]");
	var index = 0;
	var reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

	if (!viewport || !track || !cards.length || !prev || !next) {
		return;
	}

	function gap() {
		var styles = window.getComputedStyle(track);
		return parseFloat(styles.columnGap || styles.gap) || 0;
	}

	function visible() {
		var card = cards[0].getBoundingClientRect().width;
		var view = viewport.getBoundingClientRect().width;
		if (!card || !view) {
			return 1;
		}
		return Math.max(1, Math.min(cards.length, Math.round((view + gap()) / (card + gap()))));
	}

	function maxIndex() {
		return Math.max(0, cards.length - visible());
	}

	function label() {
		var start = index + 1;
		var end = Math.min(cards.length, index + visible());
		if (start === end) {
			return start + " / " + cards.length;
		}
		return start + "\u2013" + end + " / " + cards.length;
	}

	function paint() {
		var limit = maxIndex();
		if (index > limit) {
			index = limit;
		}
		var card = cards[0].getBoundingClientRect().width;
		var offset = index * (card + gap());
		track.style.transform = "translateX(" + (offset ? -offset : 0) + "px)";
		prev.disabled = index <= 0;
		next.disabled = index >= limit;
		if (count) {
			count.textContent = label();
		}
		if (thumb) {
			var travel = thumb.parentElement.clientWidth - thumb.offsetWidth;
			var shift = limit === 0 ? 0 : (index / limit) * Math.max(0, travel);
			thumb.style.width = limit === 0 ? "100%" : "18.8%";
			thumb.style.transform = "translateX(" + shift + "px)";
		}
	}

	function go(nextIndex) {
		index = Math.max(0, Math.min(maxIndex(), nextIndex));
		paint();
	}

	prev.addEventListener("click", function () {
		go(index - 1);
	});
	next.addEventListener("click", function () {
		go(index + 1);
	});

	root.addEventListener("keydown", function (event) {
		if (event.key === "ArrowRight") {
			go(index + 1);
		} else if (event.key === "ArrowLeft") {
			go(index - 1);
		}
	});

	if (reduce) {
		track.style.transition = "none";
	}

	root.classList.add("is-ready");
	paint();
	window.addEventListener("resize", paint);
})();
