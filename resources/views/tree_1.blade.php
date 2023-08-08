<html>

<head>
    <meta charset="UTF-8" />
</head>

<body>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/d3-org-chart@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/d3-flextree@2.1.2/build/d3-flextree.js"></script>
    <div class="chart-container" style="height: 1200px; background-color: #f6f6f6"></div>

    <script>
        var chart;
      d3.csv(
       '{{route('get-datas')}}'
      ).then((dataFlattened) => {
        console.log(dataFlattened);
        chart = new d3.OrgChart()
          .container('.chart-container')
          .data(dataFlattened)
          .nodeWidth((d) => 250)
          .initialZoom(0.7)
          .nodeHeight((d) => 175)
          .childrenMargin((d) => 40)
          .compactMarginBetween((d) => 15)
          .compactMarginPair((d) => 80)
          .nodeContent(function (d, i, arr, state) {
            console.log(d);
            return `
            <div style="padding-top:30px;background-color:none;margin-left:1px;height:${
              d.height
            }px;border-radius:2px;overflow:visible">
              <div style="height:${
                d.height - 32
              }px;padding-top:0px;background-color:white;border:1px solid lightgray;">

                <img src=" ${
                  d.data.imageUrl
                }" style="margin-top:-30px;margin-left:${d.width / 2 - 30}px;border-radius:100px;width:60px;height:60px;" />

               <div style="margin-right:10px;margin-top:15px;float:right">${
                 d.data.id
               }</div>

               <div style="margin-top:-30px;background-color:#3AB6E3;height:10px;width:${
                 d.width - 2
               }px;border-radius:1px"></div>

               <div style="padding:20px; padding-top:35px;text-align:center">
                   <div style="color:#111672;font-size:16px;font-weight:bold"> ${
                     d.data.name
                   } </div>
                   <div style="color:#404040;font-size:16px;margin-top:4px"> ${
                     d.data.positionName
                   } </div>
               </div>

              </div>
      </div>
  `;
          })
          .render();
      });
    </script>
</body>
<script src="https://storage.ko-fi.com/cdn/scripts/overlay-widget.js"></script>

</html>
