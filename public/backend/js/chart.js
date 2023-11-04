// apex-chart
var chart2 = $('#chart2');
var appointment_booking_chart = chart2.data('appointment_booking_chart');

var options = {
  series: appointment_booking_chart,
  chart: {
  width: 350,
  type: 'pie'
},
colors: ['#5A5278', '#6F6593', '#8075AA', '#A192D9'],
labels: ['All', 'Confirm', 'Pending'],
responsive: [{
  breakpoint: 1480,
  options: {
    chart: {
      width: 280
    },
    legend: {
      position: 'bottom'
    }
  },
  breakpoint: 1199,
  options: {
    chart: {
      width: 380
    },
    legend: {
      position: 'bottom'
    }
  },
  breakpoint: 575,
  options: {
    chart: {
      width: 280
    },
    legend: {
      position: 'bottom'
    }
  }
}],
legend: {
  position: 'bottom'
},
};

var chart = new ApexCharts(document.querySelector("#chart2"), options);
chart.render();







var chart1 = $('#chart1');
var user_chart_data = chart1.data('user_chart_data');

var options = {
  series: user_chart_data,
  chart: {
  width: 350,
  type: 'pie'
},
colors: ['#5A5278', '#6F6593', '#8075AA', '#A192D9'],
labels: ['Active', 'Unverified', 'Banned', 'All'],
responsive: [{
  breakpoint: 1480,
  options: {
    chart: {
      width: 280
    },
    legend: {
      position: 'bottom'
    }
  },
  breakpoint: 1199,
  options: {
    chart: {
      width: 380
    },
    legend: {
      position: 'bottom'
    }
  },
  breakpoint: 575,
  options: {
    chart: {
      width: 280
    },
    legend: {
      position: 'bottom'
    }
  }
}],
legend: {
  position: 'bottom'
},
};

var chart = new ApexCharts(document.querySelector("#chart1"), options);
chart.render();

var chart3 = $("#chart3");
var home_service_chart = chart3.data('home_service_chart');
var options = {
  series: home_service_chart,
  chart: {
  width: 350,
  type: 'donut',
},
colors: ['#5A5278', '#6F6593', '#8075AA', '#A192D9'],
labels: ['All', 'Active', 'Pending'],
legend: {
    position: 'bottom'
},
responsive: [{
  breakpoint: 1600,
  options: {
    chart: {
      width: 100,
    },
    legend: {
      position: 'bottom'
    }
  },
  breakpoint: 1199,
  options: {
    chart: {
      width: 380
    },
    legend: {
      position: 'bottom'
    }
  },
  breakpoint: 575,
  options: {
    chart: {
      width: 280
    },
    legend: {
      position: 'bottom'
    }
  }
}]
};

var chart = new ApexCharts(document.querySelector("#chart3"), options);
chart.render();

// pie-chart
$(function() {
  $('#chart6').easyPieChart({
      size: 80,
      barColor: '#f05050',
      scaleColor: false,
      lineWidth: 5,
      trackColor: '#f050505a',
      lineCap: 'circle',
      animate: 3000
  });
});

$(function() {
  $('#chart7').easyPieChart({
      size: 80,
      barColor: '#10c469',
      scaleColor: false,
      lineWidth: 5,
      trackColor: '#10c4695a',
      lineCap: 'circle',
      animate: 3000
  });
});

$(function() {
  $('#chart8').easyPieChart({
      size: 80,
      barColor: '#ffbd4a',
      scaleColor: false,
      lineWidth: 5,
      trackColor: '#ffbd4a5a',
      lineCap: 'circle',
      animate: 3000
  });
});

$(function() {
  $('#chart9').easyPieChart({
      size: 80,
      barColor: '#ff8acc',
      scaleColor: false,
      lineWidth: 5,
      trackColor: '#ff8acc5a',
      lineCap: 'circle',
      animate: 3000
  });
});

$(function() {
  $('#chart10').easyPieChart({
      size: 80,
      barColor: '#7367f0',
      scaleColor: false,
      lineWidth: 5,
      trackColor: '#7367f05a',
      lineCap: 'circle',
      animate: 3000
  });
});

$(function() {
  $('#chart11').easyPieChart({
      size: 80,
      barColor: '#1e9ff2',
      scaleColor: false,
      lineWidth: 5,
      trackColor: '#1e9ff25a',
      lineCap: 'circle',
      animate: 3000
  });
});

$(function() {
  $('#chart12').easyPieChart({
      size: 80,
      barColor: '#5a5278',
      scaleColor: false,
      lineWidth: 5,
      trackColor: '#5a52785a',
      lineCap: 'circle',
      animate: 3000
  });
});

$(function() {
  $('#chart13').easyPieChart({
      size: 80,
      barColor: '#ADDDD0',
      scaleColor: false,
      lineWidth: 5,
      trackColor: '#ADDDD05a',
      lineCap: 'circle',
      animate: 3000
  });
});
$(function() {
  $('#chart14').easyPieChart({
      size: 80,
      barColor: '#D6501E',
      scaleColor: false,
      lineWidth: 5,
      trackColor: '#F5BBA5',
      lineCap: 'circle',
      animate: 3000
  });
});

