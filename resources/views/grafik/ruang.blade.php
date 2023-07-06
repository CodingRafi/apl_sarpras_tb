<div id="container-ruang" class="w-full"></div>
<script>
    Highcharts.chart('container-ruang', {
      chart: {
          type: 'column'
      },
      title: {
          text: 'Ruang Sering dipinjam'
      },
      subtitle: {
          text: ''
      },
      xAxis: {
          categories: {!! json_encode($ruang_terbanyak['key']) !!},
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
          data: {!! json_encode($ruang_terbanyak['data']) !!}
      }]
  });
  </script>