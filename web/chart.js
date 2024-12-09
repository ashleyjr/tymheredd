google.charts.load('current', {'packages':['line']});

var options = {
  chart: {
    title: 'Box Office Earnings in First Two Weeks of Opening', 
  },
  width: 900,
  height: 500,
   axes: {
      x: {
         0: {side: 'bottom'}
      },
      y: {
         0: {side: 'left'}
      }
   }
};

google.charts.setOnLoadCallback(drawChart);

function drawChart() {
   var data = new google.visualization.DataTable();
   data.addColumn('number', 'Hour');
   data.addColumn('number', 'Temprature over day');
   data.addRows(day);
   var chart = new google.charts.Line(document.getElementById('chart'));
   chart.draw(data, google.charts.Line.convertOptions(options));
   
   document.getElementById('day').addEventListener('click', function () { 
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Hour');
      data.addColumn('number', 'Temprature over day');
      data.addRows(day);
      chart.draw(data, options);
   }, false);

   document.getElementById('week').addEventListener('click', function () { 
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Week');
      data.addColumn('number', 'Guardians of the Galaxy');
      data.addRows(week);
      chart.draw(data, options);
   }, false);

   document.getElementById('month').addEventListener('click', function () { 
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Month');
      data.addColumn('number', 'Guardians of the Galaxy');
      data.addRows(month);
      chart.draw(data, options); 
   }, false);
}

