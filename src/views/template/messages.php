<?php
$errors = [];

if($exception) {
    $message = [
        'type' => 'error',
        'message' => $exception->getMessage()
    ];
    if(get_class($exception) === "ValidationException") {
        $errors = $exception->getErrors();
    }
}

$typeAlert = '';

if($message['type'] === 'error') {
    $typeAlert = 'danger';
} else {
    $typeAlert = 'success';
}
?>

<?php if($message):?>
    <div class="my-3 alert alert-<?=$typeAlert?>">
        <?= $message['message']?>
    </div>
<?php endif?>