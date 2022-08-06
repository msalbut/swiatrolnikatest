@if ($mode == 'normal')
<!-- Global site tag (gtag.js) - Google Analytics -->
<script  async src="https://www.googletagmanager.com/gtag/js?id=UA-49266642-2"></script>
<script  async>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-49266642-2');
</script>
@elseif($mode == "amp")
    @stack('ampscripts')
    <script  async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
@endif
