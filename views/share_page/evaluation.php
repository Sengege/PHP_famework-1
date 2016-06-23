<style>
    .thumbGreen:hover, .thumbGreen.green{
        color: #00cc00;
    }
    .thumbRed:hover, .thumbRed.red{
        color: darkred;
    }
</style>

<?php
    $user_under_review = ($_user->getUserId() == $offer->getUserIdOfferor()) ? $offer->getUserIdAcceptor() : $offer->getUserIdOfferor();
?>

<div class="modal fade" id="Evaluation_<?php echo $offer->getExchangeId() ?>" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <form role="form" method="post" action="../classes/routers/evaluation_router.php">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Evaluation</h4>
                </div>
                <div class="modal-body">
                    <div class="container" style="width: 100%;">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <img src="../images/jacket.jpg" width="160"/>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="margin-top: 3%;">
                                <form class="form-horizontal" role="form">
                        <textarea type="text" class="form-control" name="description"
                                  placeholder="Evaluate the exchange."></textarea>
                                </form>
                            </div>
                        </div>
                        <div class="row" style="background-color: #eeefef; padding: 5%;margin-top: 2%;">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                <p style="color: rgb(51, 122, 183); font-style:italic;"><strong>Evaluate the
                                        user</strong>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <a href="#" class="thumbGreen" id="thumbs_up_<?php echo $offer->getExchangeId()?>"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                                <a href="#" class="thumbRed" id="thumbs_down_<?php echo $offer->getExchangeId()?>" style="padding-left: 5em"><span class="glyphicon glyphicon-thumbs-down"></span></a>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" value="<?php echo $user_under_review?>">
                        <input type="hidden" name="exchange_id" value="<?php echo $offer->getExchangeId()?>">
                        <input type="hidden" id="evaluation_<?php echo $offer->getExchangeId()?>" name="evaluation" value="">
                        <input type="hidden" name="reviewer_id" value="<?php echo $_user->getUserId()?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
    </form>

    <!-- /.modal -->
</div>


<script>
    $('#thumbs_up_<?php echo $offer->getExchangeId()?>').bind('click', function () {
        $('#thumbs_down_<?php echo $offer->getExchangeId()?>').removeClass('red');
        $('#thumbs_up_<?php echo $offer->getExchangeId()?>').toggleClass('green');
        document.getElementById('evaluation_<?php echo $offer->getExchangeId()?>').value = 1;
    });
    $('#thumbs_down_<?php echo $offer->getExchangeId()?>').bind('click', function () {
        $('#thumbs_up_<?php echo $offer->getExchangeId()?>').removeClass('green');
        $('#thumbs_down_<?php echo $offer->getExchangeId()?>').toggleClass('red');
        document.getElementById('evaluation_<?php echo $offer->getExchangeId()?>').value = 0;
    })
</script>