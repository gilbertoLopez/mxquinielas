// init main object
// jQuery(document).ready - conflicted with some scripts
// Transition time = 2.4s = 20/10
// SlideShow delay = 6.5s = 23/10

$('#wowslider-container1').wowSlider({
	effect:"basic", 
	prev:"", 
	next:"", 
	duration: 23*100, 
	delay:20*100, 
	width:830,
	height:360,
	autoPlay:true,
	autoPlayVideo:false,
	playPause:false,
	stopOnHover:false,
	loop:false,
	bullets:1,
	caption: true, 
	captionEffect:"fade",
	controls:true,
	responsive:1,
	fullScreen:true,
	gestures: 2,
	onBeforeStep:0,
	images:0
});