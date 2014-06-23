

<div id="container">

<div class="columnLayout" style="min-height: 0;">
  <div class="rowLayout">
      <div class="descLayout">
        <div class="pad" data-jsfiddle="example">
          <h2>Basic usage</h2>
          <div id="example"></div>
        </div>
    </div>
    <div class="codeLayout">
      <div class="pad">





        <script data-jsfiddle="example">
            var data = [
              ["Rider", "Stock", "Hometown", "Score"],
              ["Farely, Sore", "Wish Yewhadnt", "Steers, OK", 412],
              ["Gotten, Chaffed", "Rip-a-new", "Lubbock, TX", 354],
              ["Walker, Bo", "8 Is Enough", "Fears, OK", 552]
            ];

            jQuery('#example').handsontable({
              data: data,
              minSpareRows: 1,
              colHeaders: true,
              contextMenu: true
            });

        </script>
      </div>
    </div>
  </div>



</div>




</div>
