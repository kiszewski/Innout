<?php
$errors = [];

if(isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
} elseif($exception) {
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