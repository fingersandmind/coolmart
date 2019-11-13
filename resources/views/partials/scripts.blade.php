<!-- Back to top -->
@if(!Request::routeIs('purchase.order'))
<a href="#top" id="back-to-top" style="display: inline;"><i class="fa fa-angle-up"></i></a>
@endif

<!-- Dashboard Core -->
<script src="{{ asset('assets/js/vendors/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/selectize.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/jquery.tablesorter.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/circle-progress.min.js') }}"></script>
<script src="{{ asset('assets/plugins/rating/jquery.rating-stars.js') }}"></script>

<!-- Custom scroll bar Js-->
<script src="{{ asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js') }}"></script>

<!-- Custom Js-->
<script src="{{ asset('assets/js/custom.js') }}"></script>

@stack('additionalJS')