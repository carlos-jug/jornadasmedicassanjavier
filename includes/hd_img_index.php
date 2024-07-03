<script language="javascript" src="Scripts/jquery-1.3.2.min.js"></script>
<script language="javascript" src="Scripts/jquery.cross-slide.js"></script>
<script type="text/javascript">//<![CDATA[
  function displaySource(name) {
   	$('<pre>'
       	+ $('#display-' + name).prevAll('script').eq(0).html() //$('script').text() is broken on IE5
            .replace(/^\s*|\s*$/g, '')
   	        .split('\n').slice(1, -1).join('\n')
       	    .replace(/(^|\n)    /g, '$1')
           	.replace(/('[^']*')/g, '<i>$1</i>')
        + '</pre>')
   	  .insertAfter('#display-' + name);
  }
//]]></script>
<style type="text/css">
  #img_head {
   	width: 674px;
    height: 151px;
  }
</style>
<script type="text/javascript">
  $(function() {
   	$('#img_head').crossSlide({
      sleep: 8,
   	  fade: 1,
	  shuffle: 1
	}, [
		{ src: 'img/hd_banner1.jpg' },
		{ src: 'img/hd_banner2.jpg' },
		{ src: 'img/hd_banner3.jpg' },
		{ src: 'img/hd_banner4.jpg' }
	    ]);
	});
</script>

<div id="hd_3_head">
	<div id="hd_3_head_a"></div>
    <div id="hd_3_head_b">
    	<div id="img_head"><!-- Aqui se carga la imagen automaticamente --></div>
    </div>
</div>
