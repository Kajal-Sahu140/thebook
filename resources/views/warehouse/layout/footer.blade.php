<div class="footer">
    <div class="copyright">
        <p>Copyright &copy; Designed & Developed by 
            <a href="{{route('warehouse.dashboard')}}">My Babe Warehouse</a> {{ date('Y') }}
        </p>
    </div>
</div>
    <!-- <script src="{{ asset('public/storage/assets/warehouse/plugins/common/common.min.js')}}"></script> -->
    <script src="{{ asset('public/storage/assets/warehouse/js/custom.min.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/js/settings.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/js/gleek.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/js/styleSwitcher.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/plugins/circle-progress/circle-progress.min.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/plugins/d3v3/index.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/plugins/topojson/topojson.min.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/plugins/morris/morris.min.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/plugins/moment/moment.min.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/plugins/pg-calendar/js/pignose.calendar.min.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/plugins/chartist/js/chartist.min.js')}}"></script>
    <script src="{{ asset('public/storage/assets/warehouse/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js')}}"></script>
    <script>
        document.querySelector(".hamburger").addEventListener("click", function() {
            document.body.classList.toggle("open-sidebar");
        });
    </script>
