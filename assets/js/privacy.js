(function () {
	var toc = document.querySelector("[data-legal-toc]");
	if (!toc) {
		return;
	}

	var links = Array.prototype.slice.call(toc.querySelectorAll("a[href^='#']"));
	var sections = links.map(function (link) {
		return document.getElementById(link.getAttribute("href").slice(1));
	}).filter(Boolean);

	function setCurrent(id) {
		links.forEach(function (link) {
			link.classList.toggle("is-current", link.getAttribute("href") === "#" + id);
		});
	}

	if (sections.length) {
		setCurrent(sections[0].id);
	}

	if (!("IntersectionObserver" in window)) {
		return;
	}

	var visible = new Map();
	var observer = new IntersectionObserver(
		function (entries) {
			entries.forEach(function (entry) {
				visible.set(entry.target.id, entry.isIntersecting ? entry.intersectionRatio : 0);
			});
			var current = sections[0];
			var best = 0;
			sections.forEach(function (section) {
				var ratio = visible.get(section.id) || 0;
				if (ratio > best) {
					best = ratio;
					current = section;
				}
			});
			if (current) {
				setCurrent(current.id);
			}
		},
		{ rootMargin: "-20% 0px -55% 0px", threshold: [0, 0.25, 0.5, 1] }
	);

	sections.forEach(function (section) {
		observer.observe(section);
	});
})();
