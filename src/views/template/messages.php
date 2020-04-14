<?php

if($exception) {
    $message = [
        'type' => 'error',
        'message' => $exception->getMessage()
    ];
}
?>

<?php if($message):?>
    <div class="my-3 alert alert-danger">
        <?= $message['message']?>
    </div>
<?php endif?>