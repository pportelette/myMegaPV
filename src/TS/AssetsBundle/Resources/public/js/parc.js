$(function() {
	$(document).on('click', 'div.tree div',function() {
		var o = $(this);
		o.children('div').toggle();
		o.filter('.parent').toggleClass('expanded');
		return false;
	});
});