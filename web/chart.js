google.charts.load('current', {'packages':['line','corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
   var data;
   var chart;
 
   function plotHour() {
      // .js returns in ms for unix time
      const now = Math.round(Date.now() / 1000);
      var options = {
         chart: {
            title: 'Last Hour - Since ' + new Date(now * 1000), 
         },
         hAxis: {
            title: "Time (Mins)",  
            gridlines: {
               count: 24
            },
            ticks: [0,10,20],
            viewWindow: {
               min: -60,
               max: 0
            }
         }
      }; 
      data = new google.visualization.DataTable();
      data.addColumn('number', 'time');
      data.addColumn('number', 'temp');  
      for (let i=0; i<hour.length;i++){ 
         // Turn to mins and is negative
         const mins = (day[i][0] - now) / 60; 
         data.addRow([mins,hour[i][1]]);
      }
      console.log(data);
      chart = new google.charts.Line(document.getElementById('chart'));
      chart.draw(data, google.charts.Line.convertOptions(options));
   }

   function plotDay() {
      // .js returns in ms for unix time
      const now = new Date();
      const d = now.getDate();
      const m = now.getMonth() + 1;
      const y = now.getFullYear();
      const today = `${y}-${m}-${d}`;
      const start = new Date(today); 
      const end = new Date(start.getTime() + (24 * 60 * 60 * 1000));  
      var options = {
         chart: {
            title: 'Today ' + today, 
         },
         hAxis: {
            title: "Time (Hours)",
            format: "HH:mm:SS", 
            gridlines: {
               count: 24
            },
            viewWindow: {
               min: start,
               max: end 
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
      // .js returns in ms for unix time
      const now = new Date();
      const d = now.getDate();
      const m = now.getMonth() + 1;
      const y = now.getFullYear();
      const today = `${y}-${m}-${d}`;
      const today_date = new Date(today)
      const start = new Date(today_date.getTime() - (6 * 24 * 60 * 60 * 1000)); 
      const end = new Date(today_date.getTime() + (24 * 60 * 60 * 1000));  
      var options = {
         chart: {
            title: 'Week', 
         },
         hAxis: {
            title: "Day @ Time",
            format: "dd/MM/yy @ HH:mm",
            viewWindow: {
               min: start,
               max: end 
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
      // .js returns in ms for unix time
      const now = new Date();
      const d = now.getDate();
      const m = now.getMonth() + 1;
      const y = now.getFullYear();
      const today = `${y}-${m}-${d}`;
      const today_date = new Date(today)
      const start = new Date(today_date.getTime() - (5 * 7 * 24 * 60 * 60 * 1000)); 
      const end = new Date(today_date.getTime() + (24 * 60 * 60 * 1000));  
      var options = {
         chart: {
            title: 'Month', 
         },
         hAxis: {
            title: "Day @ Time",
            format: "dd/MM/yy @ HH:mm", 
            viewWindow: {
               min: start,
               max: end 
            }
         }
      };  
      data = new google.visualization.DataTable();
      data.addColumn('date', 'time');
      data.addColumn('number', 'temp');
      // Unix time to date in ms
      for (let i=0; i<month.length;i++){ 
         data.addRow([new Date(month[i][0] * 1000),month[i][1]]);  
      } 
      chart = new google.charts.Line(document.getElementById('chart'));
      chart.draw(data, google.charts.Line.convertOptions(options));
   }

   function plotHist() {
      // Compute time between submissions
      let times = [];
      for (let i=0; i<month.length;i++){ 
         times.push(Number(month[i][0]));  
      }     
      times.sort();
      data = new google.visualization.DataTable();
      data.addColumn('number','gap')
      for (let i=0; i<(times.length-1);i++){ 
         let diff = times[i+1] - times[i]; 
         data.addRow([diff]);    
      }
      
      // Update plot
      var options = {
        title: 'Test',
        legend: { position: 'none' },
      };
      var chart = new google.visualization.Histogram(document.getElementById('chart_hist'));
      chart.draw(data, options); 
   }
   
   // Plot day by default
   plotDay();
   
   // Always plot histogram
   plotHist(); 

   // Buttons
   document.getElementById('hour').addEventListener('click', function () { plotHour(); }, false);
   document.getElementById('day').addEventListener('click', function () { plotDay(); }, false);
   document.getElementById('week').addEventListener('click', function () { plotWeek(); }, false);
   document.getElementById('month').addEventListener('click', function () { plotMonth(); }, false);


}

