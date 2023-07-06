<div id="container-kelas" class="w-full"></div>
<script>
    Highcharts.chart('container-kelas', {
      chart: {
          type: 'column'
      },
      title: {
          text: 'Kelas Sering minjem'
      },
      subtitle: {
          text: ''
      },
      xAxis: {
          categories: {!! json_encode($kelas_terbanyak['key']) !!},
          crosshair: true
      },
      yAxis: {
          min: 0,
          title: {
              text: 'Jumlah'
          }
      },
      plotOptions: {
          column: {
              pointPadding: 0.2,
              borderWidth: 0
          }
      },
      tooltip: {
        valueSuffix: ' Peminjaman'
      },
      series: [{
          name: 'Jumlah',
          data: {!! json_encode($kelas_terbanyak['data']) !!}
      }]
  });
  </script>