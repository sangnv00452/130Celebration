<?php
/**
 * Created by PhpStorm.
 * User: Sangnv00452
 * Date: 3/17/14
 * Time: 10:36 AM
 */
?>
<div>
    <div id="steps">
        <div class="col-sm-4">Join the promotion</div>
        <div class="col-sm-4">Bonus win a staycation</div>
        <div class="col-sm-4">Gallery</div>
    </div>
    <div id="step-content">

    </div>
</div>
<script>
    $(function(){
        $("#step-content").load("content/step0.php");
    });
</script>