@extends('home')
@section('css')
<link rel="stylesheet" href={{asset('assets/vendors/choices.js/choices.min.css')}}>
@endsection
@section('content')
<header class="mb-3">
  <a href={{asset('#')}} class="burger-btn d-block d-xl-none">
      <i class="bi bi-justify fs-3"></i>
  </a>
</header>
<div id="piechart" style="width: 900px; height: 500px;"></div>
<div id="piechart2" style="width: 900px; height: 500px;"></div>

@endsection
@section('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Giới tính', 'Số lượng'],
      <?php echo $chartGender; ?>
    ]);
    var options = {
      title: 'Tỉ lệ giới tính học sinh',  
    };
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);

    var data2 = google.visualization.arrayToDataTable([
      ['Hạnh kiểm', 'Số lượng'],
      <?php echo $charthk; ?>
    ]);
    var options2 = {
      title: 'Hạnh kiểm học sinh',
      is3D: true,
    };
    var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
    chart.draw(data2, options2);

  }

</script>


@endsection