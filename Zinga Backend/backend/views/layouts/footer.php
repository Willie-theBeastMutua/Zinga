<?php
$baseUrl = Yii::$app->request->baseUrl;
$user = Yii::$app->user->identity;
?>
<style>
.vertical-center {
    padding-top: 15px;
}

.align-right {
    text-align: right !important;
}

.descriptor
{
    background-repeat: repeat-y;
    background-image: url("<?= Yii::$app->request->baseUrl; ?>/app-assets/images/dreams/descriptor.png");
    height: 24px;
    margin-bottom: 10px;
}

</style>
<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light navbar-border" style="height: 70px">
    <div class="row" style="margin: 0">
        <div class="col-md-12 vertical-center" style="margin: 0; text-align: center">
            <span class="d-block d-md-inline-block">Copyright &copy; <?= date('Y') ?> <a class="text-bold-800 grey darken-2" href="//healthstrat.co.ke" target="_blank">Health Strat. All rights reserved.</a></span>
        </div>		
    </div>
</footer>
<!-- END: Footer-->