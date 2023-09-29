@extends('admin.layouts.admin')

@section('content')
   <div>
    <p>ini adalah halaman reporting</p>
   </div>
   <input type="text" name="dates">
   <select class="js-example-basic-single" name="state" multiple="multiple">
        @foreach($products as $product)
            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
        @endforeach
    </select>
    <div id="product_price_range">
        <canvas class="canvasChartProduct">

        </canvas>
    </div>
    <div id="output">

    </div>
@endsection

@section('scripts')
    @parent
    {{ Html::script(mix('assets/admin/js/dashboard.js')) }}
    <script type="text/javascript" src="https://pivottable.js.org/dist/pivot.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Pastikan Anda telah memuat semua sumber daya sebelum menginisialisasi PivotTable.js
        $(document).ready(function() {
            // Inisialisasi date range picker
            $('input[name="dates"]').daterangepicker();

            // Inisialisasi Select2
            $('.js-example-basic-single').select2();

            // Lakukan permintaan Ajax untuk mengambil data produk
            $.ajax({
                url: 'reporting/all-data-product',
                success: function (response) {
                    // Pastikan elemen dengan ID "output" ada di halaman HTML Anda
                    $("#output").pivot(
                        response, {
                            rows: ["created_range"],
                            cols: ["price_range"]
                        }
                    );
                },
                error: function (error) {
                    console.error("Error in Ajax request:", error);
                }
            });

            // Inisialisasi objek Chart.js
            var productPriceRange = {
                _defaults: {
                    type: 'doughnut',
                    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
                    data: {
                        labels: [
                            '< 50000',
                            '50000 - 99999',
                            '100000 - 999999',
                            '>= 1000000'
                        ],
                        datasets: [{
                            data: [],
                            backgroundColor: [
                                "#3498DB",
                                "#3498DB",
                                "#9B59B6",
                                "#E74C3C",
                            ],
                            hoverBackgroundColor: [
                                "#36CAAB",
                                "#49A9EA",
                                "#B370CF",
                                "#E95E4F",
                            ]
                        }]
                    },
                    options: {
                        legend: false,
                        responsive: false
                    }
                },
                init: function ($el) {
                    var self = this;
                    $el = $($el);

                    // Lakukan permintaan Ajax untuk mengambil data grafik produk
                    $.ajax({
                        url: 'reporting/chart-product',
                        success: function (response) {
                            console.log(response, "EWOWW");
                            self._defaults.data.datasets[0].data = [
                                response.less_50000,
                                response._50000_99999,
                                response._100000_999999,
                                response.more_1000000
                            ];

                            // Inisialisasi grafik Chart.js dalam elemen dengan class "canvasChartProduct"
                            new Chart($el.find('.canvasChartProduct'), self._defaults);
                        },
                        error: function (error) {
                            console.error("Error in Ajax request:", error);
                        }
                    });
                }
            };

            // Inisialisasi objek produkPriceRange
            productPriceRange.init($('#product_price_range'));
        });
    </script>
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
    <link rel="stylesheet" type="text/css" href="https://pivottable.js.org/dist/pivot.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection