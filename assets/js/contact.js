(function () {
	var form = document.querySelector(".contact-form");
	if (!form) {
		return;
	}

	var typeField = form.querySelector("#enquiry-type");
	var capability = form.querySelector("#capability");
	var projectFields = form.querySelector("[data-contact-project]");
	var routes = {
		"/capabilities/communications-infrastructure/": "Communications infrastructure",
		"/capabilities/power-and-energy/": "Power and energy",
		"/capabilities/modular-infrastructure/": "Modular infrastructure",
		"/products/data-rooms/": "Data Rooms",
		"/products/facilities/": "Facilities"
	};
	var aliases = {
		"communications-infrastructure": "Communications infrastructure",
		"communications": "Communications infrastructure",
		"power-and-energy": "Power and energy",
		"power": "Power and energy",
		"modular-infrastructure": "Modular infrastructure",
		"modular": "Modular infrastructure",
		"data-rooms": "Data Rooms",
		"communication-equipment-rooms": "Communication Equipment Rooms",
		"modular-data-centres": "Modular Data Centres",
		"facilities": "Facilities"
	};

	function selectValue(select, value) {
		if (!select || !value) {
			return;
		}
		Array.prototype.forEach.call(select.options, function (option) {
			if (option.text === value || option.value === value) {
				select.value = option.value;
			}
		});
	}

	function updateProjectFields() {
		if (!projectFields || !typeField) {
			return;
		}
		projectFields.hidden = typeField.value !== "Project enquiry";
	}

	if (typeField) {
		typeField.addEventListener("change", updateProjectFields);
	}

	var params = new URLSearchParams(window.location.search);
	var requested = params.get("capability") || "";
	var prefill = aliases[requested] || "";

	if (!prefill && document.referrer) {
		try {
			var path = new URL(document.referrer).pathname;
			if (path.slice(-1) !== "/") {
				path += "/";
			}
			prefill = routes[path] || "";
		} catch (error) {
			prefill = "";
		}
	}

	if (prefill) {
		selectValue(typeField, "Project enquiry");
		selectValue(capability, prefill);
	}

	updateProjectFields();

	var submit = form.querySelector(".contact-submit");

	function syncSubmit() {
		if (!submit) {
			return;
		}
		var privacy = form.querySelector('.contact-consent input[type="checkbox"]');
		submit.classList.toggle("is-inactive", !privacy || !privacy.checked);
	}

	form.addEventListener("change", syncSubmit);
	document.addEventListener("wpcf7reset", syncSubmit);
	document.addEventListener("wpcf7mailsent", syncSubmit);
	syncSubmit();
})();
