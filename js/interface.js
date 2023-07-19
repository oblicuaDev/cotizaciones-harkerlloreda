// Main UI file.
//Quickin - Clean Project 2017 - v1.1
/*

		----------------
		DEFAULT FEATURES 
		----------------
		*Animated Scroll links: You can use a .animatelink class to use this feature in your project.
		----------------------------------------------------------------------------------------------------------
		*Basic Lightbox Elements: You can use a .q_lightbox class to use this feature. Based on FancyBox plugin.
		----------------------------------------------------------------------------------------------------------
		*Vertical scroll elements: .scroll_element class is set up for scroll containers in your project. Scroll elements should be a px height element. This feature is based on mCustomScrollBar plugin
		----------------------------------------------------------------------------------------------------------
		*Custom droplist: You can use the .custom_droplist class in <select> tags, if you need to set custom Styles on your droplists. This feature is based on JQUERY UI library selectmenu();
		----------------------------------------------------------------------------------------------------------
	*Total links: You can use the .total_link class in elements where total click event is needed.
		----------------------------------------------------------------------------------------------------------
		* Scroll animations: .scrollanimation class with complementary instructions can create scrollorama-based animations related to user scrolling
		Complementary instructions make different types of tweens: fromleft, fromright, frombottom, fromtop,opacity

*/
var creating = false;
var doctorsfilter = 0;
var datefilter = [];
$(document).ready(function () {
	animateLinks();
	buildLightboxes();
	buildScrolls();
	buildDroplists();
	totalLinks();
	scrollAnimation();
	loadCustomersSearch();
	loadCustomSelect();
	loadCustomSelect2();
	loadQuots();
	loadOpts();
	$("#tabs").tabs();
	extend_session();
	var exts = setInterval(extend_session, 300000);
	$('.options').on('change focusout keyup keydown', '.percent,.IB [type=number]', function () {
		finalPrice();
	});


	$("#doctorfilter").change(function () {
		doctorsfilter = $(this).val();
	});
	$("#dfrom").change(function () {
		datefilter[0] = $(this).val();
	});
	$("#dto").change(function () {
		datefilter[1] = $(this).val();
	});

	$("#go").click(function () {
		currentPage = 1;
		loadQuots();
	});


});

function extend_session() {
	$.post("/q_lib/extend_session.php", function (data) {
		if (data != 1 || data == '') {
			location.href = "/";
		}
	});
}

$(window).load(function () {
	$("body").fadeIn("fast");
})

function totalLinks() {
	if ($(".total_link").length > 0) {
		$(".total_link").click(function (e) {
			e.preventDefault();
			var dest = $(this)
				.find("a")
				.attr("href");
			location.href = dest;
		});
	}
}

function buildDroplists() {
	//Jquery UI Droplists
	if ($(".custom_droplist").length > 0) {
		$(".custom_droplist").selectmenu();
	}
}

function animateLinks() {
	//Animated links Code.
	if ($("a.animatelink").length > 0) {
		$("a.animatelink").click(function (e) {
			e.preventDefault();
			enlace = $(this).attr("href");
			$("html, body").animate(
				{
					scrollTop: $(enlace).offset().top
				},
				1000
			);
		});
	}
}

function buildLightboxes() {
	//Basic Lightbox elements
	if ($(".q_lightbox").length > 0) {
		$(".q_lightbox").fancybox({
			maxWidth: 600
		});
	}
}

function buildScrolls() {
	//Basic Vertical Scrollbar
	if ($(".scroll_element").length > 0) {
		$(".scroll_element").mCustomScrollbar({
			set_width: false /*optional element width: boolean, pixels, percentage*/,
			set_height: true /*optional element height: boolean, pixels, percentage*/,
			horizontalScroll: false /*scroll horizontally: boolean*/,
			scrollInertia: 550 /*scrolling inertia: integer (milliseconds)*/,
			scrollEasing: "easeOutCirc" /*scrolling easing: string*/,
			mouseWheel: "auto" /*mousewheel support and velocity: boolean, "auto", integer*/,
			autoDraggerLength: true /*auto-adjust scrollbar dragger length: boolean*/,
			scrollButtons: {
				/*scroll buttons*/
				enable: true /*scroll buttons support: boolean*/,
				scrollType: "continuous" /*scroll buttons scrolling type: "continuous", "pixels"*/,
				scrollSpeed: 20 /*scroll buttons continuous scrolling speed: integer*/,
				scrollAmount: 40 /*scroll buttons pixels scroll amount: integer (pixels)*/
			},
			advanced: {
				updateOnBrowserResize: true /*update scrollbars on browser resize (for layouts based on percentages): boolean*/,
				updateOnContentResize: false /*auto-update scrollbars on content resize (for dynamic content): boolean*/,
				autoExpandHorizontalScroll: false /*auto expand width for horizontal scrolling: boolean*/
			},
			callbacks: {
				onScroll: function () { } /*user custom callback function on scroll event*/,
				onTotalScroll: function () { } /*user custom callback function on bottom reached event*/,
				onTotalScrollOffset: 0 /*bottom reached offset: integer (pixels)*/
			}
		});
	}
}

function scrollAnimation() {
	if ($(".scrollanimation").length > 0) {
		var animations = $(".scrollanimation");
		var controller = new ScrollMagic.Controller();

		animations.each(function () {
			var id = "#" + $(this).attr("id");
			console.log(id);

			if ($(this).hasClass("fromleft")) {
				var mytween = TweenMax.from(id, 0.5, {
					left: -100,
					opacity: 0,
					delay: 0
				});
			}
			if ($(this).hasClass("fromright")) {
				var mytween = TweenMax.from(id, 0.5, {
					right: -100,
					opacity: 0,
					delay: 0
				});
			}
			if ($(this).hasClass("fromtop")) {
				var mytween = TweenMax.from(id, 0.5, {
					top: -100,
					opacity: 0,
					delay: 0
				});
			}
			if ($(this).hasClass("frombottom")) {
				var mytween = TweenMax.from(id, 0.5, {
					bottom: -100,
					opacity: 0,
					delay: 0
				});
			}
			if ($(this).hasClass("opacity")) {
				var mytween = TweenMax.from(id, 0.5, { opacity: 0, delay: 0 });
			}
			var scene = new ScrollMagic.Scene({ triggerElement: id })
				.setTween(mytween)
				.addTo(controller);
		});
	}
}
//You should put your custom javascript code here

var select = 0;
var selectId = 1;
function loadCustomSelect() {
	let cSelect = $(".customSelect select");
	if (cSelect.length) {
		cSelect.each(function () {
			var parent = $(this).parents(".customSelect");
			var change = window[$(this).data("change")] || $.noop;
			// $(this).selectmenu('destroy');
			$(this).selectmenu({
				appendTo: parent.find(".appendTo"),
				width: "100%",
				maxHeight: 200,
				open: function (e, ui) {
					var uiBtn = $(this).siblings('span');
					var spl = uiBtn.attr('id').split('-');
					var idUl = '#ui-id-' + spl[2] + '-menu';
					$(idUl).mCustomScrollbar({
						theme: 'dark-thick',
						setHeight: 200
					});
				},
				close: function () {
					var uiBtn = $(this).siblings('span');
					var spl = uiBtn.attr('id').split('-');
					var idUl = '#ui-id-' + spl[2] + '-menu';
					$(idUl).mCustomScrollbar('destroy');
				},
				change: function (event, ui) {
					var customActive = $(ui.item.element).parents('.procedure').find('.items')
					if (ui.item.value != '') {
						itemChange(customActive, ui.item.value);
						finalPrice();
					} else {
						customActive.html('');
					}
				},
			});
		});
	}
}

function loadCustomSelect2() {
	var cSelect = $(".customSelectBg select");
	if (cSelect.length) {
		cSelect.each(function () {
			var parent = $(this).parents(".customSelectBg");
			var change = window[$(this).data("change")] || $.noop;
			$(this).selectmenu({
				style: 'dropdown',
				appendTo: parent.find(".appendTo"),
				width: "100%",
				maxHeight: 200,
				open: function (e, ui) {
					var uiBtn = $(this).siblings('span');
					var spl = uiBtn.attr('id').split('-');
					var idUl = '#ui-id-' + spl[2] + '-menu';
					$(idUl).mCustomScrollbar({
						theme: 'dark-thick',
						setHeight: 200
					});
				},
				close: function () {
					var uiBtn = $(this).siblings('span');
					var spl = uiBtn.attr('id').split('-');
					var idUl = '#ui-id-' + spl[2] + '-menu';
					$(idUl).mCustomScrollbar('destroy');
				},
				change: function (v, data) {
					var q = parseInt($(v.target).parents('article').find('[type=number]').val());
					var price = data.item.element.data('price');
					var totalPrice = q * price;
					$(v.target).parents('article').find('.single-item-price').html('$' + totalPrice.formatMoney());
					finalPrice();
				},
			});
		});
	}
}

function itemChange(customActive, procedure, itSel = 0, q = 0) {
	customActive.parents('article').addClass('load');
	$.get('get/itemsP.php', { procedure: procedure }, function (data) {
		const template = $(`<div>
		<div class="customSelectBg">
			<select name="" id="">
				<option value="-1" data-price=0>Seleccionar</option>
			</select>
		</div>
		<div class="IB">
			<h2 class="font2 bold ar">Cantidad:</h2>
			<input type="number" min="1" value="1">
		</div>
		<div class="IB">
			<a href="javascript:;" onclick="deleteProc(this,event)" class="deleteProcedur"><img src="images/cerrar_verde.svg" alt=""></a>
		</div>
        <div class="single-item-price">$0</div>
	</div>`);
		if (data.message == 1) {
			customActive.html('');
			customActive.append(template);
			const select = template.find('select');
			for (let index = 0; index < data.response.length; index++) {
				const element = data.response[index];
				const templateOption = `<option value="${element.rowID}" data-price="${element.price}">${element.name}</option>`;
				select.append(templateOption);
			}
			loadCustomSelect2();
			template.find('[type=number]').on('change focusout keyup keydown', function () {
				var $this = $(this);
				var price = $this.parents('article').find('.customSelectBg select option:selected').data('price');
				var q = this.value == '' ? 0 : parseInt(this.value);
				var totalPrice = price * q;
				$this.parents('article').find('.single-item-price').html('$' + totalPrice.formatMoney());
			})
			if (itSel) {
				select.val(itSel);
				template.find('[type=number]').val(+q);
				var totalPrice = +select.find('option:selected').data('price') * q;
				template.find('.single-item-price').html('$' + totalPrice.formatMoney());
				select.selectmenu('refresh');
			}
			customActive.parents('article').removeClass('load');
			$('body').trigger('itemp_added_' + procedure);
		}
	});
}

var tabs = $("#tabs").tabs()
function addOption(id = "", discount = "0", total = 0, click = false) {
	var ul = tabs.find("ul"),
		lilength = $('#tabs ul li').length,
		templateLi = $(`<li data-tabnumber="${lilength + 1}"><a href="#opt-${lilength + 1}" class="uppercase selTab" >Opción ${lilength + 1} </a><a href="javascript:;" onclick="deleteTab($(this))" class="deleteTab"><img src="images/cerrar_blanco.svg" alt="Eliminar Tab"></a></li>`),
		dataN = $('#tabs ul li:last').data("tabnumber"),
		templateCnt = $(`<div id="opt-${lilength + 1}" data-id="${id}" class="tabCnt clear">
			<div class="header-tab">
					<h1 class="bold font2 discount hide">Descuento: <span class="percent hide" contenteditable="true">${discount}</span> <span class="hide">%</span></h1>
					<h1 class="bold font2 finalPrice">Total cotización: <span data-price="${total}">$${total.formatMoney()}</span></h1>
			</div>
			<section class="procedures">
					<h1 class="titleSection uppercase">Procedimientos</h1>
					<div class="cnt"></div>
					<a href="javascript:addProcedure();" class="addGnrl font2 semibold">Agregar procedimiento</a>
			</section><!--
	--><section class="aditional">
					<h1 class="titleSection uppercase">Adicionales</h1>
					<div class="cnt"></div>
					<a href="javascript:addAditional();" class="addGnrl font2 semibold">Agregar adicional</a>
			</section><!--
	--><section class="other">
					<h1 class="titleSection uppercase">Otros</h1>
					<div class="cnt"></div>
					<a href="javascript:addOther();" class="addGnrl font2 semibold">Agregar otro</a>
			</section>
	</div>`);
	$('#tabs').addClass('load');
	templateLi.appendTo(ul);
	templateCnt.appendTo(tabs);
	tabs.tabs("refresh");
	if (id == '') {
		finalPrice();
	}
	if (click) {
		$('#tabs').removeClass('load');
		$('#tabs li:last a.selTab').click()
	} else {
		setTimeout(() => {
			$('#tabs').removeClass('load');
			$('#tabs li:last a.selTab').click()
		}, 500);
	}
}

function deleteTab(elem) {
	var numb = elem.siblings('a').attr('href').split('-')[1];
	$.fancybox.open({
		src: 'boxes/delete.php?numb=' + numb,
		type: 'ajax'
	});
}

function deleteOpt(numb) {
	$('#tabs li[data-tabnumber=' + numb + ']').remove();
	$('#opt-' + numb).remove();
	$('#tabs li:last a.selTab').click();
	$.fancybox.close();
}

function addDiscount(el) {
	el.parent().find('.discount_container').removeClass('hide');
	el.addClass('hide');
}

function addProcedure(procSel = 0, discount = null, notes = null) {
	const template = $(`<article class="procedure">
	<a href="javascript:;" onclick="deletePr(this)" class="deleteArticle replaced_text">x</a>
			<h2 class="font2 bold">Procedimiento a cotizar:</h2>
			<div class="customSelect hide">
					<select name="" id="">
							<option value="" data-price="">Procedimientos</option>
					</select>
			</div>
			<div class="autocomplete_container text">
				<input type="text">
			</div>
			<div class="items">
			</div>
			<a href="javascript:;" onclick="addItem(this);" class="addItem font2 semibold">Agregar item</a>
			<a href="javascript:;" onclick="addDiscount($(this));" class="btnDiscount addItem font2 semibold">Incluir descuento</a>
			<a href="javascript:;" onclick="addNotes($(this));" class="btnNotes addItem font2 semibold">Incluir anotación</a>
			<div class="discount_container hide">
				<input type="number" min="0" max="100" value="0" class="discountInput"><label class="font2 bold"> % Descuento</label>
			</div>
			<div class="notes_container hide">
				<h2 class="font2 bold">Anotaciones</h2>
				<textarea></textarea>
			</div>
	</article>`);
	$('.procedures').addClass('load');
	template.appendTo('#' + $('#tabs').find('.tabCnt[aria-hidden="false"]')[0].id + ' .procedures .cnt');
	if (discount !== null) {
		template.find('.discount_container').removeClass('hide');
		template.find('.discount_container input').val(discount);
		template.find('.btnDiscount').addClass('hide');;
	}
	if (notes !== null) {
		template.find('.notes_container').removeClass('hide');
		template.find('.notes_container textarea').val(notes);
		template.find('.btnNotes').addClass('hide');;
	}
	template.find('.discount_container input').on('change focusout keyup keydown', function () {
		finalPrice();
	});
	$.get('get/procedures.php', function (d) {
		const select = template.find('.customSelect select');
		let procedureTags = [];
		let procSelName = '';
		for (var i = 0; i < d.length; i++) {
			const procedure = d[i];
			var isSel = procSel == procedure.rowID;
			if (isSel) {
				procSelName = procedure.name_procedure_cot;
			}
			select.append('<option value="' + procedure.rowID + '">' + procedure.name_procedure_cot + '</option>');
			procedureTags.push({ label: procedure.name_procedure_cot, value: procedure.name_procedure_cot, rowID: procedure.rowID });
		}
		template.find('.autocomplete_container input').val(procSelName);
		loadCustomSelect();
		if (procSel) {
			select.val(procSel);
			select.selectmenu('refresh');
		}
		if (d.length < 20) {
			select.parent().removeClass('hide');
		} else {
			template.find('.autocomplete_container').removeClass('hide');
			template.find('.autocomplete_container input').autocomplete({
				source: procedureTags,
				select: function (e, ui) {
					var select = $(this).parent().parent().find('select');
					select.val(ui.item.rowID);
					var customActive = $(this).parents('.procedure').find('.items')
					itemChange(customActive, ui.item.rowID);
					finalPrice();
					// select.selectmenu('refresh');
				}
			});
		}
		// loadCustomSelect2();
		$('.procedures').removeClass('load');
	});
	return template;
}

function addAditional(item = '', price = '') {
	var activeTab = '#' + $('#tabs').find('.tabCnt[aria-hidden="false"]')[0].id;
	var template = $(`<article>
	<a href="javascript:;" onclick="deletePr(this)" class="deleteArticle replaced_text">x</a>
	<h2 class="font2 bold">Item</h2>
	<input type="text" value="${item}">
	<h2 class="font2 bold">Valor</h2>
	<input type="text" class="priceAdded" value="${price}">
	</article>`);
	$('.aditional').addClass('load');
	template.appendTo('#' + $('#tabs').find('.tabCnt[aria-hidden="false"]')[0].id + ' .aditional .cnt');
	$(activeTab + ' .priceAdded').on('change focusout keyup keydown', () => {
		finalPrice();
	})
	setTimeout(() => {
		$('.aditional').removeClass('load');
	}, 150);
}

function addOther(selOther = 0, q = 0) {
	var template = $(`<article class="other">
	<a href="javascript:;" onclick="deletePr(this)" class="deleteArticle replaced_text">x</a>
	<div class="IB">
			<h2 class="font2 bold">Item:</h2>
			<div class="customSelectBg">
				<select name="" id="">
					<option value="-1" data-price="0">Seleccionar</option>
				</select>
			</div>
	</div>
	<div class="IB">
			<h2 class="font2 bold">Cantidad:</h2>
			<input type="number" min="1" value="1">
	</div>
    <div class="single-item-price">$0</div>
</article>`);
	$('.other').addClass('load');
	template.appendTo('#' + $('#tabs').find('.tabCnt[aria-hidden="false"]')[0].id + ' .other .cnt');
	var select = template.find('select');
	for (var i = 0; i < others.length; i++) {
		const other = others[i];
		select.append('<option value="' + other.rowID + '" data-price="' + other.price_comp + '">' + other.name_comp + '</option>');
	}
	loadCustomSelect2();
	template.find('[type=number]').on('change focusout keyup keydown', function () {
		var $this = $(this);
		var price = $this.parents('article').find('.customSelectBg select option:selected').data('price');
		var q = this.value == '' ? 0 : parseInt(this.value);
		var totalPrice = price * q;
		$this.parents('article').find('.single-item-price').html('$' + totalPrice.formatMoney());
	})
	if (selOther) {
		select.val(selOther);
		template.find('.IB [type=number]').val(q);
		select.selectmenu('refresh');
	}
	setTimeout(() => {
		$('.other').removeClass('load');
	}, 150);
}

function addItem(elem, itSel = 0, q = 0) {
	if ($(elem).parents('article').find('select').val() != '') {
		$(elem).parents('article').addClass('load');
		var template = $(`<div>
	<div class="customSelectBg">
		<select name="" id="">
			<option value="-1" data-price=0>Seleccionar</option>
		</select>
	</div>
	<div class="IB">
		<h2 class="font2 bold ar">Cantidad:</h2>
		<input type="number" min="1" value="1">
	</div>
	<div class="IB">
		<a href="javascript:;" onclick="deleteProc(this,event)" class="deleteProcedur"><img src="images/cerrar_verde.svg" alt=""></a>
	</div>
	<div class="single-item-price">$0</div>
</div>`);
		var select = $(elem).siblings('.items').find('div select').eq(0).clone();
		select.attr('id', '');
		template.appendTo($(elem).siblings('.items'));
		template.find('select').replaceWith(select);
		loadCustomSelect2();
		if (itSel) {
			select.val(itSel);
			template.find('.IB [type=number]').val(q);
			var totalPrice = +select.find('option:selected').data('price') * q;
			template.find('.single-item-price').html('$' + totalPrice.formatMoney());
			select.selectmenu('refresh');
		}
		setTimeout(() => {
			$(elem).parents('article').removeClass('load');
		}, 150);
	}
}

function addNotes(notesLink) {
	notesLink.parent().find('.notes_container').removeClass('hide');
	notesLink.addClass('hide');
}
var activeTab = $('#tabs').length ? '#' + $('#tabs').find('.tabCnt[aria-hidden="false"]')[0].id : '';

function finalPrice() {

	var activeTab = '#' + $('#tabs').find('.tabCnt[aria-hidden="false"]')[0].id,
		variableAcumuladora = 0;

	$(activeTab + ' article.procedure').each(function () {
		const procedure = $(this);
		const discount = procedure.find('.discount_container input').val();
		let procTotal = 0;
		procedure.find('.customSelectBg option:selected').each(function () {
			const opt = $(this);
			let q = +opt.parent().parent().parent().find('.IB [type=number]').val();
			q = q ? q : 1;
			let valor = +opt.data('price');
			procTotal += (valor * q);
		});
		variableAcumuladora += procTotal * ((100 - discount) / 100);
	});
	$.each($(activeTab + ' article.other .customSelectBg option:selected'), function (i, v) {
		var valor = $(v).data('price');
		var article = $(v).parents('article');
		var q = +article.find('.IB [type=number]').val();
		q = q ? q : 1;
		variableAcumuladora += (valor * q);
	});

	$(activeTab + ' .priceAdded').each(function (i, v) {
		valorInput = $(v).val()
		variableAcumuladora += Number(valorInput)
	});
	$(activeTab + " .finalPrice span").text('$' + variableAcumuladora.formatMoney());
	$(activeTab + " .finalPrice span").data('price', variableAcumuladora);

}

$(activeTab + ' .priceAdded').on('change focusout keyup keydown', () => {
	finalPrice()
})

Number.prototype.formatMoney = function () {
	var n = this;
	var str = n.toLocaleString("de-De");
	var a = "" + n;
	if (a.length > 6) {
		str = str.replace(".", "'");
	}
	return str;
};

function deleteProc(element, event) {
	$(element).parent().parent().remove()
	finalPrice();
}

function deletePr(element) {
	$(element).parent().remove()
	finalPrice();
}

var currentPage = 1;
function loadQuots() {
	var tbody = $('#tableQuots tbody');
	$("#loader").show();
	//tbody.html("");
	if (tbody.length) {
		$.get('get/quots.php', { page: currentPage, s: s, doctor: doctorsfilter, datefrom: $("#dfrom").val(), dateto: $("#dto").val(), idquot: s }, resp => {
			console.log(resp);
			if (resp.message == 1) {

				var quots = resp.list;
				var template = {};
				var onePaged = true;
				if (!(doctorsfilter > 0 && $("#dfrom").val() != '' && $("#dto").val() != '')) {
					console.log("No hay filtro anidado");
					onePaged = false;
					setPager(resp.pages, resp.lastPage,
						function () {//ClickPage
							currentPage = $(this).data('page');
							loadQuots();
						},
						function () {//afterPage
							currentPage++;
							loadQuots();
						},
						function () {//beforePage
							currentPage--;
							loadQuots();
						},
						function () {//firstFiveClick
							currentPage = 4;
							loadQuots();
						},
						function () {//lastFiveClick
							currentPage = lastPage - 5;
							loadQuots();
						}
					);

					tbody.html('');
				} else {
					setPager([]);
					if (currentPage == 1) {
						tbody.html('');
					}
				}



				for (let i = 0; i < quots.length; i++) {
					const quot = quots[i];
					template = $(`<tr>
		<td class="quot" data-id="${quot.rowID}">${quot.code}</td>
		<td class="semibold customer" data-id="${quot.customerId}"><a href="cotizacion.php?row=${quot.rowID}">${quot.customer}</a></td>
		<td>${quot.creation_date}</td>
		<td>${quot.opts}</td>
		<td>$${Math.round(Number(quot.avg)).formatMoney()}</td>
		<td>
				<a target="_blank" href="https://www.harkerlloreda.com/cotizacion/${quot.rowID}?print=1" class="replaced_text print">Imprimir</a>
				<a href="javascript:;" onclick="captureDataToSend($(this))" class="replaced_text mail">Correo</a>
		</td>
</tr>`);
					tbody.append(template);

				}
				if (currentPage < resp.pages.length && onePaged == true) {
					currentPage++; loadQuots();
				} else {
					$("#loader").hide();
				}
			} else {
				tbody.html("");
				console.log("message0");
				//$("#loader").hide();
				setPager([]);
				$("#loader").hide();
			}

		});
	}
}

function captureDataToSend(elem) {
	var trParent = elem.parents('tr');
	window.currentQuot = +trParent.find('.quot').data('id');
	window.currentUser = +trParent.find('.customer').data('id');
	window.afterSend = '';
	$.fancybox.open({
		src: 'boxes/send1.php',
		type: 'ajax'
	});
}
var clickSeted = false;
function setPager(pages, lastPage, onPageClick, onRightClick, onLeftClick, firstFiveClick, lastFiveClick) {
	var pager = $('[data-pagination]');
	if (pager.length) {
		pager.removeClass('hide');
		if (pages.length == 1 || !pages.length) {
			pager.addClass('hide');
			return;
		}
		var left = pager.find('.before-page');
		var right = pager.find('.after-page')
		if (!clickSeted) {
			clickSeted = true;
			right.click(onRightClick);
			left.click(onLeftClick);
		}
		left.removeClass('hide');
		right.removeClass('hide');
		if (currentPage == 1) {
			left.addClass('hide');
		}
		if (currentPage == lastPage) {
			right.addClass('hide');
		}
		var ul = pager.find('ul');
		ul.html('');
		for (var i = 0; i < pages.length; i++) {
			var li = $('<li class="newPage">');
			ul.append(li);
			li = ul.find('.newPage');
			var a = $('<a href="javascript:;" data-page="' + pages[i] + '">' + pages[i] + '</a>');
			li.append(a);
			a = li.find('a');
			if (pages[i] != '...') {
				a.click(onPageClick);
			}
			if (pages[i] == '...') {
				li.addClass('more');
				if (i == 1) {
					a.addClass('beforeLink');
					a.click(firstFiveClick);
				} else {
					a.click(lastFiveClick);
				}
			} else if (pages[i] == currentPage) {
				li.addClass('current');
			} else if (pages[i] < currentPage) {
				a.addClass('beforeLink');
			}
			li.removeClass('newPage');
		}
	} else {
		pager.addClass('hide');
	}
}

function loadCustomersSearch() {
	var input = $('#search2');
	if (input.length) {
		input.autocomplete({
			source: customerTags,
			select: function (e, ui) {
				console.log(ui)
				input.data('id', ui.item.rowID);
			}
		});
	}
}

function saveQuot() {
	if (!creating) {
		var create = +(row == 0);
		var customer = $('#search2').data('id');
		if ($('#search2').val() == '' || customer == '') {
			createAlert('Cliente no seleccionado', 'Debe seleccionar a un cliente.');
			// console.warn('Debe seleccionar a un cliente.');
			return false;
		}
		var optDivs = $('.tabCnt');
		if (!optDivs.length) {
			createAlert('No hay opciones', 'Debe crear al menos una opción');
			// console.warn('Debe crear al menos una opción');
			return false;
		}
		var optsArr = [];
		var avg = 0;
		finalPrice();
		optDivs.each(function (i) {
			const total = Number($(this).find('.finalPrice span').data('price'));
			if (!total) {
				return;
			}
			avg += total;
			let opt = {
				id: $(this).data('id'),
				name: code + '-' + (i + 1),
				procedures: [],
				aditionals: [],
				others: [],
				discount: $(this).find('.percent').text(),
				total: total
			};
			$(this).find('.procedures article').each(function () {
				let procedure = {
					id: $(this).find('.customSelect select').val(),
					name: $(this).find('.customSelect select option:selected').text(),
					items: [],
					discount: $(this).find('.discount_container input').val(),
					notes: $(this).find('.notes_container textarea').val()
				}
				$(this).find('.items>div').each(function () {
					let optionSel = $(this).find('select option:selected');
					let q = $(this).find('.IB input[type=number]').val();
					const item = {
						id: $(this).find('select').val(),
						name: optionSel.text(),
						price: optionSel.data('price'),
						q: q
					};
					if (item.id > -1) {
						procedure.items.push(item);
					}
				});
				if (procedure.id > -1) {
					opt.procedures.push(procedure);
				}
			});
			$(this).find('.aditional article').each(function () {
				const aditional = {
					name: $(this).find('input').val(),
					price: $(this).find('.priceAdded').val()
				};
				opt.aditionals.push(aditional);
			});
			$(this).find('.other article').each(function () {
				const other = {
					id: $(this).find('select').val(),
					name: $(this).find('select option:selected').text(),
					q: $(this).find('input[type=number]').val(),
					price: $(this).find('select option:selected').data('price')
				};
				if (other.id > -1) {
					opt.others.push(other)
				}
			});
			optsArr.push(opt);
		});
		if (!optsArr.length) {
			createAlert('Opciones sin item', 'Debe tener opciones con items seleccionados.');
			// console.warn('Debe tener opciones con items seleccionados.');
			return false;
		}
		avg = avg / optsArr.length;
		const quot = {
			id: row,
			code: code,
			opts: optsArr,
			customer: customer,
			avg: avg,
			create: create,
			doctor: $('#doctor').val()
		};
		window.currentUser = customer;
		creating = true;
		// console.log(quot);return;
		fetch('set/quot.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify(quot)
		})
			.then(res => res.json())
			.catch(e => {
				createAlert('Error inesperado', 'Revisar la consola.')
				console.error(e);
				creating = false;
			})
			.then(res => {
				// console.log(res);
				creating = false;
				window.currentQuot = res.quotId;
				window.afterSend = 'goToIndex();';
				createAlert('Cotización guardada', 'La cotización #' + code + ' ha sido guardada.', () => {
					var typeSend = row == 0 ? 'first' : 'resend';
					row = res.quotId;
					$.fancybox.open({
						src: 'boxes/save.php?type=' + typeSend,
						type: 'ajax',
						afterClose: () => {
							if (window.closeSave !== undefined) {
								location.href = './';
							}
						}
					});
				});
			})
			.catch(e => {
				createAlert('Error inesperado', 'Revisar la consola.')
				console.error(e);
				creating = false;
			});
	}
}
function createAlert(title, msg, onClose = $.noop) {
	$('body').addClass('load');
	let tmp = `<div class="boxes">
    <h1>${title}</h1>
    <img src="images/icono.svg" alt="Icono" width="23">
    <p class="font2">${msg}</p>
    <div class="btns">
        <a href="javascript:$.fancybox.close();" class="btn1 uppercase">Aceptar</a>
    </div>
</div>`;
	setTimeout(() => {
		$.fancybox.open(tmp, {
			afterLoad: () => {
				$('body').removeClass('load');
			},
			afterClose: onClose
		});
	}, 100);
}
function loadOpts() {
	if (window.row !== undefined && window.row > 0) {
		$.get('get/opts.php', { optsStr: optsStr }, opts => {
			$('#tabs ul li').remove();
			$('.tabCnt').remove();
			for (var i = 0; i < opts.length; i++) {
				const opt = opts[i];
				addOption(opt.rowID, opt.perc_opt, +opt.total_opt, true);
				for (var j = 0; j < opt.procedures_opt.length; j++) {
					const procedure = opt.procedures_opt[j];
					const discount = procedure.discount ? procedure.discount : null;
					const notes = procedure.notes ? procedure.notes : null;
					let div = addProcedure(procedure.id, discount, notes);
					for (var k = 1; k < procedure.items.length; k++) {
						$('body').on('itemp_added_' + procedure.items[k].id, function (e) {
							var item = e.data;
							addItem(div.find('.addItem'), item.id, item.q);
						}, procedure.items[k]);
					}
					itemChange(div.find('.items'), procedure.id, procedure.items[0].id, procedure.items[0].q);
				}
				for (var j = 0; j < opt.aditionals_opt.length; j++) {
					const aditional = opt.aditionals_opt[j];
					addAditional(aditional.name, aditional.price);
				}
				for (var j = 0; j < opt.others_opt.length; j++) {
					const other = opt.others_opt[j];
					addOther(other.id, other.q);
				}
			}
			// $('#tabs ul li:first a').click();
		});
	}
}
function send(type) {
	$.fancybox.close();
	$('body').addClass('load');
	$.post('set/send_quot.php', { quot: currentQuot, customer: currentUser, type: type }, function (resp) {
		$('body').removeClass('load');
		if (resp.message == 1) {
			$.fancybox.open({
				src: 'boxes/send.php?email=' + resp.email + '&code=' + resp.code + '&afterClose=' + afterSend,
				type: 'ajax'
			});
		}
	});
}
function goToIndex() {
	location.href = '/custom_functions/231/cotizaciones/';
}