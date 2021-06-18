var alignSlides = {
	init: function () {
		var maxHeight = -1;

		$('.inBox-item__descr').each(function() {
			maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
		});

		$('.inBox-item__descr').each(function() {
			$(this).height(maxHeight);
		});
	}
};


$(function(){
  $('a[href^="#"]').on('click', function(event) {
    event.preventDefault();
    var sc = $(this).attr("href"),
        dn = $(sc).offset().top;
    $('html, body').animate({scrollTop: dn}, 500);
  });
});

$(document).ready(function () {
	alignSlides.init();
})

$(window).on('resize', function () {
	alignSlides.init();
})

