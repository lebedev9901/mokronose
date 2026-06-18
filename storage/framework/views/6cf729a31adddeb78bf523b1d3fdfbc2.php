

<?php $__env->startSection('content'); ?>

<h2 style="margin:0 0 15px;font-size:24px;">
    Новое сообщение от поддержки
</h2>

<p style="font-size:16px;line-height:1.6;">
    В чате поддержки появился новый ответ.
</p>

<div style="background:#FAF7F2;border-radius:14px;padding:18px;margin:25px 0;">
    <p>
        <strong>Чат:</strong>
        <?php echo e($chat->subject ?? ('Чат #' . $chat->id)); ?>

    </p>

    <p>
        <strong>Статус:</strong>
        <?php echo e($chat->status_label ?? $chat->status); ?>

    </p>
</div>

<div style="background:#ffffff;border:1px solid #eee;border-radius:12px;padding:18px;margin-bottom:20px;">
    <?php echo e($supportMessage->message); ?>

</div>

<a href="<?php echo e(url('/profile/support/' . $chat->id)); ?>"
   style="display:inline-block;background:#A86E2C;color:#fff;text-decoration:none;padding:14px 22px;border-radius:12px;">
    Открыть чат поддержки
</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('emails.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/emails/support-message.blade.php ENDPATH**/ ?>