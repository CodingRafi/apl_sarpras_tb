<div id="container-email" class="w-full"></div>

<script>
    Highcharts.chart('container-email', {
    chart: {
      type: 'bar'
    },
    title: {
      text: 'Email sering minjam',
    },
    subtitle: {
      text: '',
    },
    xAxis: {
      categories: {!! json_encode($email_terbanyak['key']) !!},
      title: {
        text: null
      },
      gridLineWidth: 1,
      lineWidth: 0
    },
    yAxis: {
      min: 0,
      title: {
        text: 'Total Barang',
        align: 'high'
      },
      labels: {
        overflow: 'justify'
      },
      gridLineWidth: 0
    },
    tooltip: {
      valueSuffix: ' Peminjaman'
    },
    plotOptions: {
      bar: {
        borderRadius: '5%',
      }
    },
    legend: {
      enabled: false
    },
    credits: {
      enabled: false
    },
    series: [{
      name: 'Jumlah',
      data: {!! json_encode($email_terbanyak['data']) !!}
    }]
  });
  </script>