google.charts.load('current', {'packages':['line']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
   var data;
   var chart;
 
   function plotHour() {
      var options = {
         chart: {
            title: 'Hour', 
         },
         width: 900,
         height: 500,
         hAxis: {
            title: "Time (Mins)", 
            gridlines: {
               count: 60
            }, 
            viewWindow: {
               min: -60,
               max: 0
            }
         }
      }; 
      data = new google.visualization.DataTable();
      data.addColumn('number', 'time');
      data.addColumn('number', 'temp');
      // Unix time to date in ms
      const now_mins = Date.now() / (1000 * 60);
      for (let i=0; i<hour.length;i++){ 
         const then_mins = new Date(day[i][0]) / (1000 * 60);
         const date = then_mins - now_mins
         data.addRow([date,hour[i][1]]);
      } 
      chart = new google.charts.Line(document.getElementById('chart'));
      chart.draw(data, google.charts.Line.convertOptions(options));
   }

   function plotDay() {
      var options = {
         chart: {
            title: 'Today', 
         },
         width: 900,
         height: 500,
         hAxis: {
            title: "Time (Hours)",
            format: "HH:mm:SS", 
            gridlines: {
               count: 24
            }  
         }
      }; 
      data = new google.visualization.DataTable();
      data.addColumn('date', 'time');
      data.addColumn('number', 'temp');
      // Unix time to date in ms
      for (let i=0; i<day.length;i++){ 
         data.addRow([new Date(day[i][0] * 1000),day[i][1]]); 
      } 
      chart = new google.charts.Line(document.getElementById('chart'));
      chart.draw(data, google.charts.Line.convertOptions(options));
   }

   function plotWeek() {
      var options = {
         chart: {
            title: 'Week', 
         },
         width: 900,
         height: 500,
         hAxis: {
            title: "Time (Days)",
            format: "dd/MM/yy", 
            gridlines: {
               count: 7
            }  
         }
      }; 
      data = new google.visualization.DataTable();
      data.addColumn('date', 'time');
      data.addColumn('number', 'temp');
      // Unix time to date in ms
      for (let i=0; i<week.length;i++){ 
         data.addRow([new Date(week[i][0] * 1000),week[i][1]]);  
      } 
      chart = new google.charts.Line(document.getElementById('chart'));
      chart.draw(data, google.charts.Line.convertOptions(options));
   }

   function plotMonth() {
      var options = {
         chart: {
            title: 'Month', 
         },
         width: 900,
         height: 500,
         hAxis: {
            title: "Time (Days)",
            format: "dd/MM/yy", 
            gridlines: {
               count: 35
            }  
         }
      };  
      // Unix time to date in ms
      for (let i=0; i<month.length;i++){ 
         data.addRow([new Date(month[i][0] * 1000),month[i][1]]);  
      } 
      chart = new google.charts.Line(document.getElementById('chart'));
      chart.draw(data, google.charts.Line.convertOptions(options));
   }

   plotHour();
   document.getElementById('hour').addEventListener('click', function () { plotHour(); }, false);
   document.getElementById('day').addEventListener('click', function () { plotDay(); }, false);
   document.getElementById('week').addEventListener('click', function () { plotWeek(); }, false);
   document.getElementById('month').addEventListener('click', function () { plotMonth(); }, false);
}

